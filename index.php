<?php
session_start();

// Handle Form Submission for Name (Module 5: Sessions)
if (isset($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Kanban Board</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .login-container {
            display: flex; justify-content: center; align-items: center; height: 100vh;
        }
        .login-box {
            background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-align: center;
        }
    </style>
</head>
<body>

<?php if (!$username): ?>
    <!-- Login Screen (Module 5: Session Authentication) -->
    <div class="login-container">
        <div class="login-box">
            <h1>Welcome to Kanban</h1>
            <p>Please enter your name to start session.</p>
            <form method="POST">
                <input type="text" name="username" required placeholder="Your Name" style="width: 100%; padding: 10px; margin-bottom: 20px;">
                <button type="submit" class="btn btn-primary">Start</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <header>
        <div class="container">
            <h1>Kanban Board</h1>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <div>
                     <span style="margin-right: 15px;">Hello, <?php echo $username; ?>!</span>
                     <!-- Module 4: Date and Time functions -->
                     <span style="font-size: 0.9em; color: #555;"><?php echo date("l, F j, Y"); ?></span>
                </div>
                <div>
                    <button id="add-task-btn" class="btn btn-primary">+ Add New Task</button>
                    <a href="?logout=true" style="margin-left: 10px; color: #d93025;">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="board">
            <!-- Todo Column -->
            <div class="column" id="todo-column">
                <div class="column-header status-todo">
                    <h2>To Do</h2>
                    <span class="task-count" id="todo-count">0</span>
                </div>
                <div class="task-list" id="todo-list" data-status="todo"></div>
            </div>

            <!-- In Progress Column -->
            <div class="column" id="inprogress-column">
                <div class="column-header status-inprogress">
                    <h2>In Progress</h2>
                    <span class="task-count" id="inprogress-count">0</span>
                </div>
                <div class="task-list" id="inprogress-list" data-status="in_progress"></div>
            </div>

            <!-- Done Column -->
            <div class="column" id="done-column">
                <div class="column-header status-done">
                    <h2>Done</h2>
                    <span class="task-count" id="done-count">0</span>
                </div>
                <div class="task-list" id="done-list" data-status="done"></div>
            </div>
        </div>
    </main>

    <!-- Add Task Modal -->
    <div id="add-task-modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Create New Task</h2>
            <form id="create-task-form">
                <div class="form-group">
                    <label for="task-title">Title</label>
                    <input type="text" id="task-title" name="title" required placeholder="Enter task title...">
                </div>
                <div class="form-group">
                    <label for="task-desc">Description</label>
                    <textarea id="task-desc" name="description" rows="3" placeholder="Enter details (optional)..."></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Create Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="assets/js/app.js"></script>
<?php endif; ?>
</body>
</html>
