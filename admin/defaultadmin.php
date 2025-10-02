<?php
require 'C:\xampp\htdocs\RoomAllocation\connection.php';

// Admin user details
$email = "lecturespace@example.com";
$fullName = "Lecture Space";
$password = "@Lecture2024";  
$userType = "admin";
$college = "Admin Department";
$adminId = "ADMIN001";
$salutation = "Dr";

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Begin transaction
$conn->begin_transaction();

try {
    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (email, full_name, password, salutation, user_type, college) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $email, $fullName, $hashedPassword, $salutation, $userType, $college);
    $stmt->execute();
    $last_id = $stmt->insert_id;

    // Insert into admins table
    $stmt = $conn->prepare("INSERT INTO admins (user_id, admin_id) VALUES (?, ?)");
    $stmt->bind_param("is", $last_id, $adminId);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    echo "Admin user created successfully.";
} catch (Exception $e) {
    // An error occured, roll back the transaction
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

$conn->close();
