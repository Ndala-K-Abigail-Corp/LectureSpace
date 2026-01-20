<?php
require __DIR__ . '/../connection.php'; //assuming xampp is your c drive

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting data
    $salutation = $_POST['user-salutation'];
    $email = $_POST['user-email'];
    $fullName = $_POST['user-name'];
    $userType = $_POST['user-type'];
    $userId = $_POST['user-id'];
    $college = $_POST['user-college'];
    $password = $_POST['user-password'];
    $confirmPassword = $_POST['user-confirm-password'];
    $studentIntake = isset($_POST['student-intake']) ? $_POST['student-intake'] : null;

    // Validating password match
    if ($password !== $confirmPassword) {
        die('Passwords do not match.');
    }

    // Hashing the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL to insert into the users table
    $sql = "INSERT INTO users (salutation, email, full_name, password, user_type, college) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $salutation, $email, $fullName, $hashedPassword, $userType, $college);
        if ($stmt->execute()) {
            $last_id = $conn->insert_id;

            // Inserting into students or lecturers table based on user type
            if ($userType === 'student' && $studentIntake !== null) {
                $sqlStudent = "INSERT INTO students (user_id, student_id, intake) VALUES (?, ?, ?)";
                $stmtStudent = $conn->prepare($sqlStudent);
                if ($stmtStudent) {
                    $stmtStudent->bind_param("iss", $last_id, $userId, $studentIntake);
                    if (!$stmtStudent->execute()) {
                        die('Error: ' . $stmtStudent->error);
                    }
                } else {
                     die('Error preparing student statement: ' . $conn->error);
                }
            } elseif ($userType === 'lecturer') {
                $sqlLecturer = "INSERT INTO lecturers (user_id, lecturer_id) VALUES (?, ?)";
                $stmtLecturer = $conn->prepare($sqlLecturer);
                if ($stmtLecturer) {
                    $stmtLecturer->bind_param("is", $last_id, $userId);
                    if (!$stmtLecturer->execute()) {
                        die('Error: ' . $stmtLecturer->error);
                    }
                } else {
                     die('Error preparing lecturer statement: ' . $conn->error);
                }
            }

            // Redirect to login page after successful registration
            header('Location: ../login/login.html');
            exit;
        } else {
             echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
} else {
    // Not a POST request
    echo "Invalid request";
}

$conn->close();

