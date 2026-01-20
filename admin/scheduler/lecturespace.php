<?php
require __DIR__ . '/../../connection.php';
require 'assign_course.php';

// Fetch assigned course IDs
$assignedCourses = [];
$assignedCoursesQuery = $conn->query("SELECT DISTINCT course_id FROM classcourse");
while ($row = $assignedCoursesQuery->fetch_assoc()) {
    $assignedCourses[] = $row['course_id'];
}

// Fetch courses
$courses = $conn->query("SELECT course_id, course_name FROM courses");
$courseOptions = "";
while ($course = $courses->fetch_assoc()) {
    $courseId = htmlspecialchars($course['course_id']);
    $courseName = htmlspecialchars($course['course_name']);
    if (!in_array($courseId, $assignedCourses)) {
        $courseOptions .= "<option value='$courseId'>$courseName</option>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LectureSpace - Scheduler</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .loading {
      display: none;
      margin-top: 10px;
    }

    .loading.active {
      display: block;
      text-align: center;
    }
  </style>
</head>

<body>
  <header>
    <img src="Lecturespace 2.png" width="200px" alt="LectureSpace Logo">
    <h1>LectureSpace - Scheduler</h1>
  </header>
  <main>
    <h2>Assign Courses to Classrooms</h2>
    <form id="schedule-form" method="post" action="lecturespace.php">
      <div class="form-group">
        <label for="course">Course:</label>
        <select id="course" name="course" required>
          <?php echo $courseOptions; ?>
        </select>
      </div>
      <!-- Loading animation -->
      <div class="loading" id="loading">
        <img src="loading.gif" alt="Loading" width="50px">
        <p>Assigning...</p>
      </div>
      <!-- Button to assign course -->
      <button type="button" id="assign-button">Assign Course</button>
      <!-- Button to clear scheduler -->
      <button type="button" id="clear-button" style="background-color: red; color: white;">Clear Scheduler</button>
      <button type="button" onclick="goBack()">Go Back</button>
      </div>
    </form>
  </main>
  <script>
    // Assign button click handler
    document.getElementById("assign-button").addEventListener("click", function() {
      document.getElementById("loading").classList.add("active");
      setTimeout(function() {
        document.getElementById("schedule-form").submit();
      }, 2000);
    });
    // Clear button click handler
    document.getElementById("clear-button").addEventListener("click", function() {});

    document.getElementById("clear-button").addEventListener("click", function() {
      if (confirm("Are you sure you want to clear the scheduler?")) {
        window.location.href = "clear.php";
      }
    });

    function goBack() {
      window.location.href = "../index.html";
    }
  </script>
</body>

</html>