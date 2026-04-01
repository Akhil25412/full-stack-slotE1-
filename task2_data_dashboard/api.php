<?php
header('Content-Type: application/json');
require_once 'db.php';

$action = $_GET['action'] ?? '';

try {
    if ($action === 'get_students') {
        $sort = $_GET['sort'] ?? 'name';
        $filter = $_GET['filter'] ?? '';
        
        $allowedSorts = ['name', 'dob', 'created_at'];
        if (!in_array($sort, $allowedSorts)) $sort = 'name';

        $query = "SELECT name, email, dob, department, phone FROM students";
        $params = [];

        if ($filter) {
            $query .= " WHERE department = ?";
            $params[] = $filter;
        }

        $query .= " ORDER BY $sort ASC";
        
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        echo json_encode($stmt->fetchAll());
        exit;
    }

    if ($action === 'get_stats') {
        $stmt = $pdo->query('SELECT department, COUNT(*) as count FROM students GROUP BY department');
        echo json_encode($stmt->fetchAll());
        exit;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
