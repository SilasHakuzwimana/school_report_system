<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Courses & Classes</title>
    <link rel="stylesheet" href="register_courses_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Register Courses & Assign Teachers</h2>
        <form action="process_register_courses.php" method="POST">
            <div class="form-group">
                <label for="registration_type">Select Registration Type</label>
                <select id="registration_type" name="registration_type" onchange="handleRegistrationTypeChange()" required>
                    <option value="" disabled selected>Select registration type</option>
                    <option value="course">Register Course</option>
                    <option value="class">Register Class</option>
                </select>
            </div>
            <div id="course_form" style="display: none;">
                <div class="form-group">
                    <label for="course_name">Course Name</label>
                    <input type="text" id="course_name" name="course_name" placeholder="Enter Course name" required>
                </div>
                <div class="form-group">
                    <label for="class">Class</label>
                    <select id="class" name="class" required>
                        <option value="Select" disabled>Select class</option>
                        <option value="Nursery 1">Nursery 1</option>
                        <option value="Nursery 2">Nursery 2</option>
                        <option value="Nursery 3">Nursery 3</option>
                        <option value="Primary 1">Primary 1</option>
                        <option value="Primary 2">Primary 2</option>
                        <option value="Primary 3">Primary 3</option>
                        <option value="Primary 4">Primary 4</option>
                        <option value="Primary 5">Primary 5</option>
                        <option value="Primary 6">Primary 6</option>
                        <option value="Senior 1">Senior 1</option>
                        <option value="Senior 2">Senior 2</option>
                        <option value="Senior 3">Senior 3</option>
                        <option value="Senior 4 MCE">Senior 4 MCE</option>
                        <option value="L3 BDC">L3 BDC</option>
                        <option value="L3 PLT">L3 PLT</option>
                        <option value="Senior 5 MCE">Senior 5 MCE</option>
                        <option value="L4 BDC">L4 BDC</option>
                        <option value="L4 PLT">L4 PLT</option>
                        <option value="Senior 6 MCE">Senior 6 MCE</option>
                        <option value="L5 BDC">L5 BDC</option>
                        <option value="L5 PLT">L5 PLT</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="teacher">Assign Teacher</label>
                    <select id="teacher" name="teacher" required>
                    <?php
                    // Database connection
                    require 'db_connection.php';

                    // Fetch teachers from database where role is 'teacher'
                    $sql = "SELECT * FROM users WHERE role = 'teacher'";
                    $result = mysqli_query($conn, $sql);

                    // Generate options for select dropdown
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                    }

                    // Close database connection
                    mysqli_close($conn);
                    ?>
                    </select>
                </div>
            </div>
            <div id="class_form" style="display: none;">
            <label for="class_name">Class:</label>
            <input type="text" id="class_name" name="class_name" placeholder="Enter new class" required>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
                <br><br>
                <button type="button" id="back" onclick="redirectToDashboard();">Back</button>
            </div>
        </form>
    </div>
    <script>
        function handleRegistrationTypeChange() {
            var registrationType = document.getElementById('registration_type').value;
            var courseForm = document.getElementById('course_form');
            var classForm = document.getElementById('class_form');
            
            if (registrationType === 'course') {
                courseForm.style.display = 'block';
                classForm.style.display = 'none';
            } else if (registrationType === 'class') {
                courseForm.style.display = 'none';
                classForm.style.display = 'block';
            }
        }

        function redirectToDashboard() {
            window.location.href = "dashboard.php";
        }
    </script>
</body>
</html>
