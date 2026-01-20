<?php
session_start();
require __DIR__ . '/../connection.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL to check the username and password
    $sql = "SELECT user_id, password, user_type FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, store user_id in session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect based on user type
            if ($row['user_type'] == 'student') {
                header('Location: ../student/index.php');
                exit;
            } elseif ($row['user_type'] == 'lecturer') {
                header('Location: ../lecturer/index.php');
                exit;
            } elseif ($row['user_type'] == 'admin') {
                // Redirect admins to the admin dashboard
                header('Location: ../admin/index.html');
                exit;
            } else {
                // Handle unexpected user type
                echo "Invalid user type.";
            }
        } else {
            // Invalid password
            echo "Invalid username or password.";
        }
    } else {
        // No user found
        echo "Invalid username or password.";
    }
} else {
    // Not a POST request
    echo "Invalid request method.";
}

$conn->close();
?>
