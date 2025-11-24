<!DOCTYPE html>
<?php
session_start();

require 'C:\xampp\htdocs\RoomAllocation\connection.php';

// Check if the user_id is stored in session and retrieve it
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: /login/login.html');
    exit;
}

$lecturerId = $_SESSION['user_id'];  // user_id stored in session

// Prepare an SQL statement to avoid SQL injection
$stmt = $conn->prepare("SELECT users.salutation, users.full_name, salutation, users.user_id, users.college, lecturers.lecturer_id
                        FROM users
                        JOIN lecturers ON users.user_id = lecturers.user_id
                        WHERE users.user_id = ? AND users.user_type = 'lecturer'");

// Bind parameters and execute
$stmt->bind_param("i", $lecturerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $lecturerDetails = $result->fetch_assoc();
} else {
    echo "No lecturer details found.";
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>



<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LectureSpace Lecturer Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <img src="/RoomAllocation/Lecturespace 2.png" width="120px" alt="LectureSpace Logo">
    <h1>LectureSpace Lecturer Dashboard</h1>
  </header>
  <main>
    <div class="profile-container">
      <img src="contact.jpg" alt="Profile Picture" style="width: 200px; height: 200px; object-fit: cover;">
      <div class="lecturer-details">
        <h2>Lecturer Information</h2>
        <p>Name: <span id="lecturer-name"><?php echo $lecturerDetails['salutation'] . ' ' . $lecturerDetails['full_name']; ?></span></p>
        <p>ID: <span id="lecturer-id"><?php echo $lecturerDetails['lecturer_id']; ?></span></p>
        <p>College: <span id="lecturer-college"><?php echo $lecturerDetails['college']; ?></span></p>
      </div>
    </div>
    <div class="button-container">
      <a href="/RoomAllocation/lecturer/viewlecturespace/view.php" class="dashboard-button">View LectureSpace</a>
      <a href="/RoomAllocation/lecturer/Viewcourses/viewcourses.php" class="dashboard-button">View Courses</a>
      <a href="/RoomAllocation/lecturer/addcourses/course.php" class="dashboard-button">Add Courses</a>
      <button onclick="logout()">Logout</button>
    </div>
  </main>
  <footer style="position: absolute; bottom: 0; width: 100%; text-align: center;">
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
