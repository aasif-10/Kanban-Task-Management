# Kanban Task Management (Full Stack)

A dynamic task management application built using **jQuery, AJAX, JSON, PHP, and MySQL**. This project simulates a simplified Jira or Trello board where users can create tasks, drag and drop them between progress stages ("To Do", "In Progress", "Done"), and delete them. The application features user session management, asynchronous updates, and a responsive design.

![Full Stack Kanban](https://img.shields.io/badge/Stack-FullStack-blue) ![PHP](https://img.shields.io/badge/Backend-PHP-purple) ![jQuery](https://img.shields.io/badge/Frontend-jQuery-orange) ![MySQL](https://img.shields.io/badge/DB-MySQL-blue)

---

## 🚀 Key Features

- **User Sessions**: Simple login system (Name-based) to personalize the experience.
- **Drag & Drop Interface**: Move tasks between columns using jQuery UI Sortable.
- **Asynchronous CRUD**: Create, Read, Update, and Delete tasks without page reloads (AJAX).
- **Real-time Status Updates**: Task positions and statuses are saved instantly to the database.
- **Responsive Design**: Clean, grid-based layout that works on desktop and mobile.

---

## 🛠️ Technology Stack

This project was built to demonstrate core Web Technology concepts:

- **Frontend**: HTML5, CSS3, jQuery, jQuery UI.
- **Backend**: PHP (7.4+).
- **Database**: MySQL (PDO connection for security).
- **Data Exchange**: JSON & AJAX.

---

## 🔧 Installation & Setup

1.  **Clone the Repository**

    ```bash
    git clone https://github.com/aasif-10/Kanban-Task-Management.git
    ```

    Place the folder in your server's root directory (e.g., `htdocs` for XAMPP).

2.  **Database Setup**
    - Open **phpMyAdmin** (usually `http://localhost/phpmyadmin`).
    - Create a new database named `kanban_board`.
    - Import the `database.sql` file located in the root folder of this project.

3.  **Configure Connection**
    - Open `config/database.php`.
    - Update the credentials if your local setup differs:
      ```php
      $host = '127.0.0.1';
      $db_name = 'kanban_board';
      $username = 'root';
      $password = '';
      ```

4.  **Run the App**
    - Start **Apache** and **MySQL** in XAMPP.
    - Navigate to: `http://localhost/Kanban-Task-Management/` (or your specific folder name).

---

## 📂 Project Structure

```
/
├── api/                   # PHP Endpoints (AJAX Requests)
│   ├── create_task.php    # Insert new task
│   ├── get_tasks.php      # Fetch all tasks (JSON)
│   ├── update_task_status.php # Update drag-drop position
│   └── delete_task.php    # Remove task
├── assets/
│   ├── css/
│   │   └── style.css      # Styling for Board & Modal
│   └── js/
│       └── app.js         # jQuery Logic (Drag-Drop, AJAX)
├── config/
│   └── database.php       # Database Connection (PDO)
├── database.sql           # SQL Schema Import File
├── index.php              # Main App (Login + Dashboard)
└── README.md              # Documentation
```

---

## 🎓 Concepts Implemented (Syllabus Alignment)

This project strictly follows the University Web Technology syllabus:

- **Module 3 (Client-Side Scripting)**:
  - **Selectors & Events**: Used jQuery to handle click events and form submissions.
  - **DOM Manipulation**: Dynamically appending task cards to the UI.
  - **Special Effects**: Drag-and-drop functionality using **jQuery UI**.
  - **AJAX & JSON**: Sending asynchronous requests to PHP and parsing JSON responses.

- **Module 4 (PHP Basics)**:
  - **Variables & Functions**: PHP logic to process inputs.
  - **Date & Time**: Formatting timestamps (e.g., "Oct 24, 2024").
  - **Including Files**: Modular code using `include_once`.

- **Module 5 (Advanced PHP)**:
  - **Sessions**: `session_start()` used to track the logged-in user.
  - **Authentication**: Simple login/logout flow using PHP sessions.

- **Module 6 (MySQL Integration)**:
  - **Database Connectivity**: Using **PDO** for secure database access.
  - **Form Handling**: Processing user input safely before insertion.
  - **CRUD Operations**: Full Create, Read, Update, Delete functionality.

---

## 📸 Usage

1.  **Login**: Enter your name to start a session.
2.  **Add Task**: Click "+ Add New Task", fill in the details, and hit Create.
3.  **Organize**: Drag cards from **To Do** → **In Progress** → **Done**.
4.  **Delete**: Click the `x` on a card to remove it permanently.

Enjoy organizing your tasks! 🚀
