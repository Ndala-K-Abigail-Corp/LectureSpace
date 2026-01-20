<?php
require __DIR__ . '/../../connection.php';
$result = $conn->query("SELECT user_id, full_name FROM users WHERE user_type = 'lecturer'");
$lecturers = $result->fetch_all(MYSQLI_ASSOC);
echo json_encode($lecturers);
$conn->close();
?>
