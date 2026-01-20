<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LectureSpace - View Classrooms</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="header-content">
            <a href="#">
                <img src="../../Lecturespace 2.png" width="200px" alt="LectureSpace Logo"> </a>
            <h1>LectureSpace Admin Dashboard</h1>
        </div>
    </header>
    <main>
        <?php
        session_start();
        require __DIR__ . '/../../connection.php';
        // Check if the user_id is stored in session and retrieve it
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not logged in
            header('Location: /login/login.html');
            exit;
        }

        // Prepare an SQL statement to fetch all classrooms
        $sql = "SELECT classroom_id, classroom_name, classroom_type,
                 CASE
                     WHEN seating_capacity BETWEEN 1 AND 50 THEN '1-50'
                     WHEN seating_capacity BETWEEN 51 AND 100 THEN '51-100'
                     WHEN seating_capacity BETWEEN 101 AND 250 THEN '101-250'
                 END AS seating_capacity_range
          FROM classrooms";
        $result = $conn->query($sql);


        if ($result->num_rows > 0) {
            // Output data of each row
            echo "<h2>List of Classrooms</h2>";
            echo "<table class='data-table'>";
            echo "<tr><th>ID</th><th>Name</th><th>Type</th><th>Seating Capacity</th><th>Action</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["classroom_id"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["classroom_name"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["classroom_type"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["seating_capacity_range"]) . "</td>";
                echo "<td><a href='delete_classroom.php?id=" . urlencode($row["classroom_id"]) . "' onclick='return confirmDelete()' class='delete-icon'><i class='fas fa-trash-alt'></i></a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "0 results found.";
        }

        $conn->close();
        ?>

    </main>


    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this classroom?");
        }
    </script>

</body>

</html>