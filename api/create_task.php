<?php
header('Content-Type: application/json');

include_once '../config/database.php';

// Check if data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get database connection
    global $conn;

    // Validate if title is present
    if(isset($_POST['title']) && !empty($_POST['title'])) {
        $title = trim($_POST['title']);
        $description = isset($_POST['description']) ? trim($_POST['description']) : '';
        $status = 'todo'; // Default status

        try {
            // Prepare statement
            $stmt = $conn->prepare("INSERT INTO tasks (title, description, status) VALUES (:title, :description, :status)");
            
            // Bind parameters
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            
            // Execute the query
            if($stmt->execute()) {
                $last_id = $conn->lastInsertId();
                echo json_encode(['success' => true, 'message' => 'Task created successfully', 'id' => $last_id]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Task could not be created']);
            }
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Title is required']);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed']);
}
?>
