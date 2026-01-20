<?php
// Start the session
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /login/login.html');
    exit;
}

// Include the database connection
require __DIR__ . '/../connection.php';

// Prepare an SQL statement to fetch student details
$stmt = $conn->prepare("SELECT users.full_name, users.college, students.student_id, students.intake
                        FROM users
                        JOIN students ON users.user_id = students.user_id
                        WHERE users.user_id = ? AND users.user_type = 'student'");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $studentDetails = $result->fetch_assoc();
} else {
    echo "No student details found.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LectureSpace Student Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <img src="../Lecturespace 2.png" width="200px" alt="LectureSpace Logo">
    <h1>LectureSpace Student Dashboard</h1>
  </header>
  <main>
    <div class="profile-container">
      <img src="contact.jpg" alt="Profile Picture" style="width: 150px; height: 150px; object-fit: cover;">
      <div class="student-details">
        <h2>Student Information</h2>
        <p>Name: <span><?= $studentDetails['full_name']; ?></span></p>
        <p>ID: <span><?= $studentDetails['student_id']; ?></span></p>
        <p>Year: <span><?= $studentDetails['intake']; ?></span></p>
        <p>College: <span><?= $studentDetails['college']; ?></span></p>
      </div>
    </div>
    <a href="viewlecturespace/view.php" class="view-button">View LectureSpace</a>
    <button onclick="logout()">Logout</button>
  </main>
  <footer>
    <p>&copy; 2024 LectureSpace. All rights reserved.</p>
  </footer>
  <script>
    function logout() {
      sessionStorage.clear()
      window.location.href = "/RoomAllocation/index.html"; // Replace "logout.php" with the actual logout page URL
    }
  </script>
</body>
</html>
