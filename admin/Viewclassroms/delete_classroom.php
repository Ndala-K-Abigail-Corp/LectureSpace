<?php
session_start();
require __DIR__ . '/../../connection.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $classroom_id = $conn->real_escape_string($_GET['id']);

    // Prepare the DELETE statement to avoid SQL injection
    $stmt = $conn->prepare("DELETE FROM classrooms WHERE classroom_id = ?");
    $stmt->bind_param("s", $classroom_id);
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        echo "Classroom deleted successfully.";
    } else {
        echo "Error deleting classroom. It may not exist or your query failed.";
    }

    $stmt->close();
} else {
    echo "Invalid request. No classroom ID specified.";
}

$conn->close();

// Redirect back to the classroom listing page
header("Location: viewclassroom.php");
exit();
