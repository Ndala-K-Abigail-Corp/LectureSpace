<?php
require 'C:\xampp\htdocs\RoomAllocation\connection.php'; //assuming xampp is your c drive

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting data
    $salutation = $conn->real_escape_string($_POST['user-salutation']);
    $email = $conn->real_escape_string($_POST['user-email']);
    $fullName = $conn->real_escape_string($_POST['user-name']);
    $userType = $conn->real_escape_string($_POST['user-type']);
    $userId = $conn->real_escape_string($_POST['user-id']);
    $college = $conn->real_escape_string($_POST['user-college']);
    $password = $_POST['user-password'];
    $confirmPassword = $_POST['user-confirm-password'];
    $studentIntake = isset($_POST['student-intake']) ? $conn->real_escape_string($_POST['student-intake']) : null;

    // Validating password match
    if ($password !== $confirmPassword) {
        die('Passwords do not match.');
    }

    // Hashing the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert into the users table
    $sql = "INSERT INTO users (salutation, email, full_name, password, user_type, college) VALUES ('$salutation', '$email', '$fullName', '$hashedPassword', '$userType', '$college')";

    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id; 

        // Inserting into students or lecturers table based on user type
        if ($userType === 'student' && $studentIntake !== null) {
            $sqlStudent = "INSERT INTO students (user_id, student_id, intake) VALUES ('$last_id', '$userId', '$studentIntake')";
            if (!$conn->query($sqlStudent)) {
                die('Error: ' . $conn->error);
            }
        } elseif ($userType === 'lecturer') {
            $sqlLecturer = "INSERT INTO lecturers (user_id, lecturer_id) VALUES ('$last_id', '$userId')";
            if (!$conn->query($sqlLecturer)) {
                die('Error: ' . $conn->error);
            }
        }

        // Redirect to login page after successful registration
        header('Location: /RoomAllocation/login/login.html');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Not a POST request
    echo "Invalid request";
}

$conn->close();

