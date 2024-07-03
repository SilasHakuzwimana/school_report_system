<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report - School Report System</title>
    <link rel="stylesheet" href="marks_and_generation.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="report-container">
            <h2>Student Reports</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Mark</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'school_report');
                    $result = $conn->query("SELECT students.name as student, subjects.name as subject, marks.mark 
                                            FROM marks 
                                            JOIN students ON marks.student_id = students.id 
                                            JOIN subjects ON marks.subject_id = subjects.id");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>".$row['student']."</td>";
                        echo "<td>".$row['subject']."</td>";
                        echo "<td>".$row['mark']."</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button onclick="window.print()" class="btn">Print Report</button>
        </div>
    </div>
</body>
</html>
