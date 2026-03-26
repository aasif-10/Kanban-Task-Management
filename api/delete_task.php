<?php
header('Content-Type: application/json');

include_once '../config/database.php';

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get database connection
    global $conn;

    // Check if task ID is provided
    if(isset($_POST['id'])) {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        
        if(!$id) {
             echo json_encode(['success' => false, 'message' => 'Invalid ID']);
             exit;
        }

        try {
            // Prepare delete statement
            $stmt = $conn->prepare("DELETE FROM tasks WHERE id = :id");
            
            // Bind parameters
            $stmt->bindParam(':id', $id);
            
            // Execute the query
            if($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                     echo json_encode(['success' => true, 'message' => 'Task deleted successfully']);
                } else {
                     echo json_encode(['success' => false, 'message' => 'Task not found']);
                }

            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete task']);
            }
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing ID']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>
