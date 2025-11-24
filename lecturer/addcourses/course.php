<?php
session_start();

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: /login/login.html');
    exit;
}

// Include the database connection
require 'C:\xampp\htdocs\RoomAllocation\connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $courseId = $conn->real_escape_string($_POST['course-id']);
    $courseName = $conn->real_escape_string($_POST['course-name']);
    $numStudents = $conn->real_escape_string($_POST['num-students']);
    $courseType = $conn->real_escape_string($_POST['course-type']);
    $studentIntake = $conn->real_escape_string($_POST['student-intake']);
    $college = $conn->real_escape_string($_POST['college']);
    $lecturerId = $_SESSION['user_id'];

    // Prepare an SQL statement to insert the new course
    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, num_students, course_type, lecturer_id, student_intake, college) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisiss", $courseId, $courseName,  $numStudents, $courseType, $lecturerId, $studentIntake, $college);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Course added successfully!";
    } else {
        echo "Error adding course: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="port" content="width=device-width, initial-scale=1.0">
    <title>LectureSpace - Add Course</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="/RoomAllocation/Lecturespace 2.png" width="200px" alt="LectureSpace Logo"> </a>
        <h1>LectureSpace Lecturer Dashboard</h1>
    </header>
    <nav>
    </nav>
    <main>
        <h2>Add New Course</h2>
        <form id="course-form" method="post" action="course.php">
            <div class="form-group">
                <label for="course-id">Course ID:</label>
                <input type="text" id="course-id" name="course-id" required>
            </div>
            <div class="form-group">
                <label for="course-name">Course Name:</label>
                <input type="text" id="course-name" name="course-name" required>
            </div>

            <div class="form-group">
                <label for="num-students">Number of Students:</label>
                <select id="num-students" name="num-students" required>
                    <option value="1-25">1-25</option>
                    <option value="26-50">26-50</option>
                    <option value="51-100">51-100</option>
                    <option value ="101-150">101-150</option>
                    <option value="151-200">151-200</option>
                </select>
            </div>


            <div class="form-group">
                <label for="course-type">Course Type:</label>
                <input type="radio" id="course-type-practical" name="course-type" value="practical" required>
                <label for="course-type-practical">Practical</label>
                <input type="radio" id="course-type-theoretical" name="course-type" value="theoretical" required>
                <label for="course-type-theoretical">Theoretical</label>
            </div>



            </div>
            <div class="form-group">
                <label for="student-intake">Student Intake:</label>
                <select id="student-intake" name="student-intake" required>
                    <optgroup label="Undergraduates">
                        <option value="1.1">1.1</option>
                        <option value="1.2">1.2</option>
                        <option value="2.1">2.1</option>
                        <option value="2.2">2.2</option>
                        <option value="3.1">3.1</option>
                        <option value="3.2">3.2</option>
                        <option value="4.1">4.1</option>
                        <option value="4.2">4.2</option>
                    </optgroup>
                    <optgroup label="Masters">
                        <option value="1.1">1.1</option>
                        <option value="1.2">1.2</option>
                        <option value="2.1">2.1</option>
                        <option value="2.2">2.2</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label for="college">College:</label>
                <select id="college" name="college" required>
                    <option value="CEAS">CEAS</option>
                    <option value="CBPLG">CBPLG</option>
                    <option value="CSSTHE">CSSTHE</option>
                    <option value="CHANS">CHANS</option>
                    <option value="School Of Law">School Of Law</option>
                </select>
            </div>
            <button type="submit">Add Course</button>
          <button id ="back-button"> Back to Dashboard</button>
        </form>
    </main>
    <script>
    document.getElementById("back-button").addEventListener("click", function(){
        window.location.href="/RoomAllocation/lecturer/index.php";
    });
    </script>
</body>

</html>