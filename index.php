<?php
// index.php

$host = 'localhost';
$user = 'root';
$pass = ''; // default in xampp

// Connect to MySQL server first to create DB if not exists
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB
$sql = "CREATE DATABASE IF NOT EXISTS student_db";
$conn->query($sql);

// Select DB
$conn->select_db('student_db');

// Create Table
$sql = "CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    department VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

$message = '';
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $department = $conn->real_escape_string($_POST['department']);
    $phone = $conn->real_escape_string($_POST['phone']);

    $insert = "INSERT INTO registrations (name, email, dob, department, phone) VALUES ('$name', '$email', '$dob', '$department', '$phone')";
    if ($conn->query($insert) === TRUE) {
        $message = "<div class='alert success'>Registration successful!</div>";
    } else {
        $message = "<div class='alert error'>Error: " . $conn->error . "</div>";
    }
}

// Fetch records
$result = $conn->query("SELECT * FROM registrations ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-color: #0b0f1a;
            --surface: rgba(30, 41, 59, 0.7);
            --text: #f8fafc;
            --text-muted: #94a3b8;
            --border: rgba(51, 65, 85, 0.5);
            --success: #10b981;
            --error: #ef4444;
            --glass: rgba(255, 255, 255, 0.03);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(192, 132, 252, 0.15) 0px, transparent 50%);
            color: var(--text);
            min-height: 100vh;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1100px;
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            margin-top: 2rem;
        }

        @media(min-width: 900px) {
            .container {
                grid-template-columns: 420px 1fr;
            }
        }

        .card {
            background: var(--surface);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--border);
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            margin-bottom: 2rem;
            font-size: 1.75rem;
            font-weight: 700;
            background: linear-gradient(135deg, #a5b4fc, #e879f9);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.6rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            transition: color 0.3s;
        }

        .form-group:focus-within label {
            color: var(--primary);
        }

        input, select {
            width: 100%;
            padding: 0.85rem 1.1rem;
            border-radius: 12px;
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid var(--border);
            color: var(--text);
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(15, 23, 42, 1);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            transform: scale(1.01);
        }

        button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-hover));
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.4);
            filter: brightness(1.1);
        }

        button:active {
            transform: translateY(0);
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success {
            background: rgba(16, 185, 129, 0.1);
            color: #34d399;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .error {
            background: rgba(239, 68, 68, 0.1);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 16px;
            background: rgba(15, 23, 42, 0.3);
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            padding: 1.25rem 1rem;
            background: rgba(255, 255, 255, 0.02);
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-bottom: 1px solid var(--border);
        }

        td {
            padding: 1.25rem 1rem;
            font-size: 0.9rem;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: rgba(255, 255, 255, 0.04);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .student-name {
            font-weight: 600;
            color: var(--text);
            display: block;
            margin-bottom: 0.2rem;
        }

        .student-email {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .dept-badge {
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            background: var(--glass);
            border: 1px solid var(--border);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--text-muted);
        }

        .header-section {
            text-align: center;
            margin-bottom: 1rem;
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>

    <div class="header-section">
        <h1>Student <span style="color: var(--primary);">Portal</span></h1>
        <p style="color: var(--text-muted);">Manage and track student registrations with ease.</p>
    </div>

    <div class="container">
        <!-- Form Section -->
        <div class="card">
            <h2>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="17" y1="11" x2="23" y2="11"></line></svg>
                Registration
            </h2>
            <?php echo $message; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" required placeholder="Enter student name">
                </div>
                
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="email@example.com">
                </div>
                
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" required>
                </div>
                
                <div class="form-group">
                    <label>Department</label>
                    <select name="department" required>
                        <option value="">Select Department</option>
                        <option value="Computer Science">Computer Science</option>
                        <option value="Information Technology">Information Technology</option>
                        <option value="Electrical Engineering">Electrical Engineering</option>
                        <option value="Mechanical Engineering">Mechanical Engineering</option>
                        <option value="Business Administration">Business Administration</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" required placeholder="Phone number">
                </div>
                
                <button type="submit">Register Student</button>
            </form>
        </div>

        <!-- Data Display Section -->
        <div class="card">
            <h2>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                Registered Students
            </h2>
            <div class="table-responsive">
                <?php if ($result && $result->num_rows > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Student Details</th>
                                <th>Department</th>
                                <th>Contact</th>
                                <th>Reg. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <span class="student-name"><?php echo htmlspecialchars($row['name']); ?></span>
                                        <span class="student-email"><?php echo htmlspecialchars($row['email']); ?></span>
                                    </td>
                                    <td>
                                        <span class="dept-badge"><?php echo htmlspecialchars($row['department']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                    <td style="color: var(--text-muted); font-size: 0.8rem;">
                                        <?php echo date('M d, Y', strtotime($row['reg_date'])); ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1.5rem; opacity: 0.2;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <p>No student records found in the database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

</body>
</html>
<?php 
if (isset($conn) && $conn) {
    $conn->close(); 
}
?>
