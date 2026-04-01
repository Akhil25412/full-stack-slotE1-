document.addEventListener('DOMContentLoaded', () => {
    const payBtn = document.getElementById('payBtn');
    const payAmount = document.getElementById('payAmount');
    const userBalance = document.getElementById('userBalance');
    const merchantBalance = document.getElementById('merchantBalance');
    const logs = document.getElementById('logs');

    const addLog = (message, type = 'system') => {
        const time = new Date().toLocaleTimeString();
        const div = document.createElement('div');
        div.className = `log ${type}`;
        div.textContent = `[${time}] ${message}`;
        logs.prepend(div);
    };

    const updateUI = (balances) => {
        balances.forEach(acc => {
            if (acc.account_type === 'USER') {
                userBalance.textContent = `$${parseFloat(acc.balance).toLocaleString()}`;
            } else {
                merchantBalance.textContent = `$${parseFloat(acc.balance).toLocaleString()}`;
            }
        });
    };

    // Initial balance fetch (using the processing endpoint with a 0 amount or simple GET)
    // For this demo, we'll manually set initial or let first transaction load it.
    // Let's assume starting balances for visual:
    userBalance.textContent = '$500.00';
    merchantBalance.textContent = '$1,000.00';

    payBtn.addEventListener('click', async () => {
        const amount = payAmount.value;
        if (!amount || amount <= 0) {
            addLog('Please enter a valid payment amount', 'error');
            return;
        }

        payBtn.disabled = true;
        addLog(`Initiating transaction for $${amount}...`, 'system');
        addLog('SQL: START TRANSACTION;', 'system');

        try {
            const response = await fetch('process_payment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ amount })
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                addLog('SQL: COMMIT; (Funds successfully moved)', 'success');
                addLog(result.message, 'success');
                updateUI(result.balances);
                payAmount.value = '';
            } else {
                addLog('SQL: ROLLBACK; (Transaction aborted)', 'error');
                addLog(result.message || 'Payment failed', 'error');
            }
        } catch (error) {
            addLog('SQL: ROLLBACK; (Hardware/Connection Error)', 'error');
            addLog('Critical system error occurred.', 'error');
        } finally {
            payBtn.disabled = false;
        }
    });
});
