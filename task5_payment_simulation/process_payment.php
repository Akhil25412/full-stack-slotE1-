<?php
header('Content-Type: application/json');
require_once 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['amount'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid payment data']);
    exit;
}

$amount = (float)$data['amount'];
if ($amount <= 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Amount must be greater than zero']);
    exit;
}

try {
    // START TRANSACTION
    $pdo->beginTransaction();

    // 1. Fetch current user balance
    $stmt = $pdo->prepare('SELECT balance FROM accounts WHERE id = 1 FOR UPDATE');
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user || $user['balance'] < $amount) {
        throw new Exception('Insufficient funds in user account');
    }

    // 2. Deduct from User
    $stmt = $pdo->prepare('UPDATE accounts SET balance = balance - ? WHERE id = 1');
    $stmt->execute([$amount]);

    // 3. Add to Merchant
    $stmt = $pdo->prepare('UPDATE accounts SET balance = balance + ? WHERE id = 2');
    $stmt->execute([$amount]);

    // 4. Simulate a random failure (Optional: remove this in real apps)
    // if (rand(1, 100) > 90) throw new Exception('Random Network Failure Simulation');

    // COMMIT if everything succeeded
    $pdo->commit();

    // Fetch updated balances for display
    $stmt = $pdo->query('SELECT balance, account_type FROM accounts');
    $balances = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'message' => 'Transaction Completed Successfully!',
        'balances' => $balances
    ]);

} catch (Exception $e) {
    // ROLLBACK if any error occurred
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
