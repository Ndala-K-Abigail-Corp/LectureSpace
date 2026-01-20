<?php
session_start();

require __DIR__ . '/../../connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "You are not authorized to perform this action.";
    exit;
}

if (isset($_GET['course_id'])) {
    $courseId = $conn->real_escape_string($_GET['course_id']);

    $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
    $stmt->bind_param("s", $courseId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Course deleted successfully.";
    } else {
        echo "Error deleting course.";
    }

    $stmt->close();
    $conn->close();

    header("Location: viewcourses.php"); 
    exit;
}

