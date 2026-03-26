<?php
header('Content-Type: application/json');

include_once '../config/database.php';

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get database connection
    global $conn;

    // Check if task ID and status are provided
    if(isset($_POST['id']) && isset($_POST['status'])) {
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $status = $_POST['status'];

        // Validate status
        $allowedStatuses = ['todo', 'in_progress', 'done'];
        if(!$id || !in_array($status, $allowedStatuses)) {
             echo json_encode(['success' => false, 'message' => 'Invalid input']);
             exit;
        }

        try {
            // Prepare update statement
            $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
            
            // Bind parameters
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $id);
            
            // Execute the query
            if($stmt->execute()) {
                if ($stmt->rowCount() > 0) {
                     echo json_encode(['success' => true, 'message' => 'Task status updated']);
                } else {
                     echo json_encode(['success' => false, 'message' => 'Task not found or no changes made']);
                }

            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update task']);
            }
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing ID or Status']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>
