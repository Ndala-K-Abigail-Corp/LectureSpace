<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="port" content="width=device-width, initial-scale=1.0">
  <title>LectureSpace - Courses</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <header>
    <img src="../../Lecturespace 2.png" width="200px" alt="LectureSpace Logo"> </a>
    <h1>LectureSpace Lecturer Dashboard</h1>
  </header>
  <nav>
  </nav>
  <main>
    <h2>Your Courses</h2>
    <table id="courses-table">

      <?php
      session_start();

      // Check if the user is logged in, otherwise redirect to the login page
      if (!isset($_SESSION['user_id'])) {
        header('Location: /login/login.html');
        exit;
      }

      // Include the database connection
      require __DIR__ . '/../../connection.php';

      $lecturerId = $_SESSION['user_id'];  // Use lecturer's user ID from session
      // Fetch courses added by the logged-in lecturer
      $sql = "SELECT course_id, course_name, num_students, course_type, lecturer_id, student_intake, college FROM courses WHERE lecturer_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $lecturerId);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        // Output data of each row in HTML table
        echo "<tr><th>Course ID</th><th>Course Name</th><th>Students</th><th>Type</th><th>Student Intake</th><th>College</th><th>Actions</th></tr>";
        while ($row = $result->fetch_assoc()) {
          // Calculate the range for the number of students
          $numStudents = (int)$row['num_students'];
          $studentRange = ($numStudents == 1) ? '1-50' : (($numStudents == 101) ? '51-100' : '101-250');

          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['course_id']) . "</td>";
          echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
          echo "<td>" . htmlspecialchars($studentRange) . "</td>"; // Display student range
          echo "<td>" . htmlspecialchars($row['course_type']) . "</td>";
          echo "<td>" . htmlspecialchars($row['student_intake']) . "</td>";
          echo "<td>" . htmlspecialchars($row['college']) . "</td>";
          echo "<td><a href='delete_course.php?course_id=" . urlencode($row['course_id']) . "' onclick='return confirm(\"Are you sure you want to delete this course?\")'><i class='fas fa-trash-alt'></i></a></td>";
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='10'>No courses found</td></tr>";
      }

      $conn->close();
      ?>


    </table>
  </main>
  <script src="script.js"></script>
</body>

</html>