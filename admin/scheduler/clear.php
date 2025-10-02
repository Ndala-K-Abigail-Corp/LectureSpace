<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    
</body>
</html>
<?php
require 'C:\xampp\htdocs\RoomAllocation\connection.php';

$sql = "DELETE FROM classcourse";
if ($conn->query($sql) === TRUE) {
  echo "<div class='alert alert-success mb-0' role='alert'>Scheduler cleared successfully, redirecting please wait.....</div>";
  header("refresh:3;url=/RoomAllocation/admin/scheduler/lecturespace.php");
} else {
  echo "Error clearing scheduler: " . $conn->error;
}
$conn->close();
?>
