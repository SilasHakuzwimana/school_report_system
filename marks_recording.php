<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Marks - School Report System</title>
    <link rel="stylesheet" href="marks_and_generation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Record Marks</h2>
            <form method="POST" action="marks_recording.php">
                <div class="input-group">
                    <label for="student_id">Student</label>
                    <select name="student_id" id="student_id" required>
                        <?php
                        $conn = new mysqli('localhost', 'root', '', 'school_report');
                        $result = $conn->query("SELECT id, name FROM students");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="subject_id">Subject</label>
                    <select name="subject_id" id="subject_id" required>
                        <?php
                        $result = $conn->query("SELECT id, name FROM subjects");
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input-group">
                    <label for="mark">Mark</label>
                    <input type="number" name="mark" id="mark" required placeholder="Enter mark">
                </div>
                <button type="submit" class="btn">Submit</button>
                <br>
                <br>
                <button type="button" onclick="redirectToPage();" class="btn">Back</button>
            </form>
        </div>
    </div>
    <script>
        function redirectToPage() {
            window.location.href="dashboard.php";
        }
    </script>
</body>
</html>
