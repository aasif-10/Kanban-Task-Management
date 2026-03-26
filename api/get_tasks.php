<?php
header('Content-Type: application/json');

include_once '../config/database.php';

// Get database connection
global $conn;

// Check if only fetching by status (optional)
$status = isset($_GET['status']) ? $_GET['status'] : null;

try {
    $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
    
    // Prepare statement if status is provided
    if($status) {
        $sql = "SELECT * FROM tasks WHERE status = :status ORDER BY created_at DESC";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $status);
    } else {
        $stmt = $conn->prepare($sql);
    }

    $stmt->execute();
    
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format date for better readability (Module 4: Date and Time functions)
    foreach($tasks as &$task) {
        $task['formatted_date'] = date("M j, Y g:i A", strtotime($task['created_at']));
    }

    echo json_encode(['success' => true, 'tasks' => $tasks]);

} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
