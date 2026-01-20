<?php
require __DIR__ . '/../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input data from the form
    $classroomId = $conn->real_escape_string($_POST['classroom-id']);
    $classroomName = $conn->real_escape_string($_POST['classroom-name']);
    $classroomType = $conn->real_escape_string($_POST['classroom-type']);
    $seatingCapacity = $conn->real_escape_string($_POST['classroom-seats']);

    // Prepare an SQL statement to insert the new classroom
    $stmt = $conn->prepare("INSERT INTO classrooms (classroom_id, classroom_name, classroom_type, seating_capacity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $classroomId, $classroomName, $classroomType, $seatingCapacity);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        header('Location: ../index.html');
        exit;
    } else {
        echo "Error adding classroom: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
