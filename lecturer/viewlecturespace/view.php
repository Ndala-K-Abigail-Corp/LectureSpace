<?php
require __DIR__ . '/../../connection.php';

// Fetch all schedule entries from the database
$query = "
SELECT c.course_id, c.course_name, cl.classroom_name, cc.day, cc.time,c.student_intake,c.college, u.full_name AS lecturer_name
FROM classcourse cc
JOIN courses c ON cc.course_id = c.course_id
JOIN classrooms cl ON cc.classroom_id = cl.classroom_id
JOIN users u ON c.lecturer_id = u.user_id;
";
$result = $conn->query($query);
if (!$result) {
    die("SQL error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LectureSpace - View Lecturespace</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <img src="../../Lecturespace 2.png" width="200px" alt="LectureSpace Logo">
        <h1>LectureSpace - Schedule</h1>
        <div class="export-buttons">
            <button id="export-csv">Export to CSV</button>
            <button id="export-pdf">Export to PDF</button>
        </div>
    </header>
    <main>
        <h2>Complete Schedule</h2>
        <table id="schedule-table">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Classroom</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Student Intake</th>
                    <th>College</th>
                    <th>Lecturer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['course_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['classroom_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['day']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['time']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['student_intake'])."</td>";
                        echo "<td>" . htmlspecialchars($row['college']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['lecturer_name']) . "</td>";
                       
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No scheduled classes found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </main>
</body>

</html>
