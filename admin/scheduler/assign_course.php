<?php
session_start();
require 'C:\xampp\htdocs\RoomAllocation\connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect input data from the form
    $courseId = $conn->real_escape_string($_POST['course']);
    
    // Query the course details to get the number of students
    $courseQuery = "SELECT num_students FROM courses WHERE course_id = '$courseId'";
    $courseResult = $conn->query($courseQuery);
    
    if ($courseResult->num_rows > 0) {
        $courseData = $courseResult->fetch_assoc();
        $numStudents = $courseData['num_students'];
        
        // Define available time slots
        $timeSlots = [
            'Monday 9:00 AM - 12:00 PM',
            'Monday 2:00 PM - 5:00 PM',
            'Tuesday 9:00 AM - 12:00 PM',
            'Tuesday 2:00 PM - 5:00 PM',
            'Wednesday 9:00 AM - 12:00 PM',
            'Wednesday 2:00 PM - 5:00 PM',
            'Thursday 9:00 AM - 12:00 PM',
            'Thursday 2:00 PM - 5:00 PM',
            'Friday 9:00 AM - 12:00 PM',
            'Friday 2:00 PM - 5:00 PM',
        ];

        // Query available classrooms based on seating capacity and time slots
        foreach ($timeSlots as $timeSlot) {
            $dayTime = explode(" ", $timeSlot);
            $day = $dayTime[0];
            $time = $dayTime[1] . " " . $dayTime[2];
            
            // Adjusted SQL query to select classrooms within the appropriate seating capacity range
            $classroomQuery = "SELECT * FROM classrooms WHERE 
                                CASE
                                    WHEN seating_capacity >= 250 THEN 250
                                    WHEN seating_capacity >= 101 THEN 101
                                    WHEN seating_capacity >= 51 THEN 51
                                    ELSE 1
                                END >= $numStudents
                                AND NOT EXISTS (
                                    SELECT 1 FROM classcourse WHERE classroom_id = classrooms.classroom_id 
                                    AND day = '$day' AND time = '$time'
                                ) LIMIT 1";
            $classroomResult = $conn->query($classroomQuery);
            
            if ($classroomResult->num_rows > 0) {
                // Assign the first available classroom that meets the seating capacity requirement
                $classroomData = $classroomResult->fetch_assoc();
                $classroomId = $classroomData['classroom_id'];

                // Insert the assignment into the database
                $insertAssignmentQuery = "INSERT INTO classcourse (course_id, classroom_id, day, time) 
                                            VALUES ('$courseId', '$classroomId', '$day', '$time')";
                if ($conn->query($insertAssignmentQuery) === TRUE) {
                    // Redirect to the scheduler page
                    header('Location: /RoomAllocation/admin/viewlecturespace/viewlecturespace.php');
                    exit;
                } else {
                    echo "Error assigning classroom: " . $conn->error;
                }
            }
        }
        echo "No available classrooms with sufficient seating capacity and time slots.";
    } else {
        echo "Invalid course selection.";
    }
}
?>
