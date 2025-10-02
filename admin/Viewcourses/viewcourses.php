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
    <img src="/RoomAllocation/Lecturespace 2.png" width="200px" alt="LectureSpace Logo"> </a>
    <h1>Admin - View Courses</h1>
  </header>
  <nav>
  </nav>
  <main>
    <h2> Courses</h2>
    <table id="courses-table">
      <?php
      session_start();

      // Check if the user is logged in, otherwise redirect to the login page
      if (!isset($_SESSION['user_id'])) {
        header('Location: /login/login.html');
        exit;
      }

      require 'C:\xampp\htdocs\RoomAllocation\connection.php';

      // Fetch courses with lecturer's name and manipulated student intake range
      $sql = "SELECT c.course_id, c.course_name, 
                   CASE 
                       WHEN c.num_students = 1 THEN '1-50' 
                       WHEN c.num_students = 51 THEN '51-100' 
                       WHEN c.num_students = 101 THEN '101-250' 
                   END AS students_range,
                   c.course_type, 
                   u.full_name, 
                   c.student_intake, 
                   c.college 
            FROM courses c
            INNER JOIN users u ON c.lecturer_id = u.user_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        // Output data of each row in HTML table
        echo "<tr><th>Course ID</th><th>Course Name</th><th>Students</th><th>Type</th><th>Lecturer</th><th>Student Intake</th><th>College</th></tr>";
        while ($row = $result->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . htmlspecialchars($row['course_id']) . "</td>";
          echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['students_range']) . "</td>";
          echo "<td>" . htmlspecialchars($row['course_type']) . "</td>";
          echo "<td>" . htmlspecialchars($row['full_name']) . "</td>";
          echo "<td>" . htmlspecialchars($row['student_intake']) . "</td>";
          echo "<td>" . htmlspecialchars($row['college']) . "</td>";
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