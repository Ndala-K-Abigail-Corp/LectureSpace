<?php
require 'C:\xampp\htdocs\RoomAllocation\connection.php'; 

$courseId = $_POST['course_id'];

// Prepare and execute SQL statement to delete the row
$stmt = $conn->prepare("DELETE FROM classcourse WHERE course_id = ?");
$stmt->bind_param("s", $courseId);
if ($stmt->execute()) {
    // Deletion successful
    echo "Schedule deleted successfully!";
} else {
    // Error handling
    echo "Error deleting schedule.";
}

$stmt->close();
$conn->close();
?>
