$(document).ready(function () {
  // Initial fetch of tasks
  fetchTasks();

  // Enable drag and drop
  $(".task-list")
    .sortable({
      connectWith: ".task-list",
      placeholder: "ui-state-highlight",
      receive: function (event, ui) {
        const taskId = ui.item.data("id");
        const newStatus = $(this).data("status");

        updateTaskStatus(taskId, newStatus);
      },
    })
    .disableSelection();

  // Modal Logic
  const modal = $("#add-task-modal");
  const span = $(".close");

  $("#add-task-btn").on("click", function () {
    modal.show();
  });

  span.on("click", function () {
    modal.hide();
  });

  $(window).on("click", function (event) {
    if (event.target == modal[0]) {
      modal.hide();
    }
  });

  // Handle Create Task Form Submission
  $("#create-task-form").on("submit", function (e) {
    e.preventDefault();

    const title = $("#task-title").val();
    const description = $("#task-desc").val();

    if (title.trim() === "") {
      alert("Title is required!");
      return;
    }

    $.ajax({
      url: "api/create_task.php",
      type: "POST",
      data: { title: title, description: description },
      dataType: "json",
      success: function (response) {
        if (response.success) {
          // Add new task to UI as card
          const newTask = {
            id: response.id,
            title: title,
            description: description,
            status: "todo",
          };
          renderTask(newTask, true); // true = prepend to start

          // Reset form and close modal
          $("#create-task-form")[0].reset();
          modal.hide();
        } else {
          alert("Error creating task: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error:", error);
        alert("Failed to create task based on server error.");
      },
    });
  });

  // Delete Task Logic (using event delegation for dynamically created elements)
  $(document).on("click", ".delete-task-btn", function () {
    if (confirm("Are you sure you want to delete this task?")) {
      const taskId = $(this).closest(".task-card").data("id");
      const card = $(this).closest(".task-card");

      $.ajax({
        url: "api/delete_task.php",
        type: "POST",
        data: { id: taskId },
        dataType: "json",
        success: function (response) {
          if (response.success) {
            card.remove();
            updateCounts();
          } else {
            alert("Error deleting task: " + response.message);
          }
        },
        error: function (xhr, status, error) {
          console.error("Error:", error);
          alert("Failed to delete task.");
        },
      });
    }
  });

  function fetchTasks() {
    $.ajax({
      url: "api/get_tasks.php",
      type: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          const tasks = response.tasks;
          // Clear lists first
          $("#todo-list").empty();
          $("#inprogress-list").empty();
          $("#done-list").empty();

          tasks.forEach(function (task) {
            renderTask(task, false); // false = append to end (since tasks are ordered by created_at DESC from API, we want them in that order)
          });

          updateCounts();
        } else {
          console.error("Failed to load tasks");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching tasks:", error);
      },
    });
  }

  function renderTask(task, prepend = false) {
    // Module 4: Date and Time
    const dateStr = task.formatted_date || "Just now";

    const cardHtml = `
            <div class="task-card" data-id="${task.id}">
                <h3>${task.title}</h3>
                <p>
                    ${task.description || ""}
                    <br><small style="color: #888; font-size: 0.8em;">${dateStr}</small>
                </p>
                <div class="task-actions">
                    <button class="delete-task-btn delete-btn" title="Delete Task">&times;</button>
                </div>
            </div>
        `;

    let targetList = "#todo-list";
    if (task.status === "in_progress") targetList = "#inprogress-list";
    else if (task.status === "done") targetList = "#done-list";

    if (prepend) {
      $(targetList).prepend(cardHtml);
    } else {
      $(targetList).append(cardHtml);
    }

    updateCounts();
  }

  function updateTaskStatus(id, status) {
    $.ajax({
      url: "api/update_task_status.php",
      type: "POST",
      data: { id: id, status: status },
      dataType: "json",
      success: function (response) {
        if (!response.success) {
          alert(
            "Failed to update task location on server: " + response.message,
          );
          // Revert UI change if server fails (optional, but good UX)
          fetchTasks(); // Reload to sync
        } else {
          updateCounts();
        }
      },
      error: function (xhr, status, error) {
        console.error("Error updating status:", error);
        alert("Failed to update status.");
        fetchTasks(); // Reload to sync
      },
    });
  }

  function updateCounts() {
    $("#todo-count").text($("#todo-list .task-card").length);
    $("#inprogress-count").text($("#inprogress-list .task-card").length);
    $("#done-count").text($("#done-list .task-card").length);
  }
});
