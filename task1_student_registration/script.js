document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('registrationForm');
    const tableBody = document.getElementById('studentTableBody');

    // Fetch and display students
    const fetchStudents = async () => {
        try {
            const response = await fetch('api.php');
            const students = await response.json();
            
            tableBody.innerHTML = '';
            students.forEach(student => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.name}</td>
                    <td>${student.email}</td>
                    <td>${student.dob}</td>
                    <td>${student.department}</td>
                    <td>${student.phone}</td>
                `;
                tableBody.appendChild(row);
            });
        } catch (error) {
            console.error('Error fetching students:', error);
        }
    };

    // Handle form submission
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            if (result.status === 'success') {
                alert('Registration Successful!');
                form.reset();
                fetchStudents();
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            alert('An error occurred during registration.');
        }
    });

    // Initial load
    fetchStudents();
});
