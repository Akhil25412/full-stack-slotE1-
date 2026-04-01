<?php
header('Content-Type: application/json');
require_once 'db.php';

$action = $_GET['action'] ?? '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!$data || !isset($data['name'], $data['email'], $data['dob'], $data['department'], $data['phone'])) {
            throw new Exception('Missing required fields');
        }

        $stmt = $pdo->prepare('INSERT INTO students (name, email, dob, department, phone) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['dob'],
            $data['department'],
            $data['phone']
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Student registered successfully']);
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query('SELECT name, email, dob, department, phone FROM students ORDER BY created_at DESC');
        echo json_encode($stmt->fetchAll());
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
