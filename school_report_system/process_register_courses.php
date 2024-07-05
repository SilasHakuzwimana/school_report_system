<?php
// Database connection
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $class = $_POST['class'];
    $teacher = $_POST['teacher'];

    // Insert the new course into the database
    $sql = "INSERT INTO courses (course_name, class, teacher) VALUES ('$course_name', '$class', '$teacher')";

    if (mysqli_query($conn, $sql)) {
        echo "New course registered successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
