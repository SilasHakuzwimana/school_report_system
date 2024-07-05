<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || !isset($_SESSION['username'])) {
    header("Location: user_authentication.php");
    exit();
}

$role = $_SESSION['role'];
$username = htmlspecialchars($_SESSION['username']); // Use htmlspecialchars for security
$roleDisplayName = ($role == 'admin') ? 'Admin' : 'Teacher'; // Determine the display name based on the role
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="keywords">
    <meta name="Description" content="school report generation system, designed for faster and more accurate reports">
    <title>Dashboard - School Report System</title>
    <link rel="icon" href="images/kisspng-computer-icons-dashboard-computer-software-big-dat-commercial-signs-5ade4ea0d09c77.5609530515245185608545.jpg">
    <link rel="stylesheet" href="dashboard_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="dashboard-container">
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3>School Report System</h3>
            <p>Welcome, <?php echo $roleDisplayName . ' ' . $username; ?></p>
        </div>
        <ul class="nav-links">
            <li><a href="javascript:void(0);" onclick="redirectToDashboard();"><i class="fas fa-home"></i> Dashboard</a></li>
            <?php if ($role == 'admin') { ?>
                <li><a href="javascript:void(0);" onclick="redirectToRegisterUser();" ><i class="fas fa-user-plus"></i> Register User</a></li>
                <li><a href="javascript:void(0);" onclick="redirectToGenerate();" ><i class="fas fa-file-alt"></i> Generate Reports</a></li>
                <li><a href="javascript:void(0);" onclick="redirectToRegisterCourses();" ><i class="fas fa-book"></i> Register Courses & Classes</a></li>
            <?php } ?>
            <?php if ($role == 'teacher') { ?>
                <li><a href="javascript:void(0);" onclick="redirectToMarksRecording();" ><i class="fas fa-pencil-alt"></i> Record Student Marks</a></li>
            <?php } ?>
            <li><a href="Javascript:void(0);" onclick="redirectToLogout();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>

    <div class="main-content">
        <header>
            <h2>Dashboard</h2>
        </header>
        <section class="cards">
            <?php if ($role == 'admin') { ?>
                <div class="card">
                    <h3><i class="fas fa-user-plus"></i> Register User</h3>
                    <p>Admins can register new users here.</p>
                    <a href="javascript:void(0);" onclick="redirectToRegisterUser();" class="btn">Register User</a>
                </div>
                <div class="card">
                    <h3><i class="fas fa-file-alt"></i> Generate Reports</h3>
                    <p>Admins can generate reports here.</p>
                    <a href="javascript:void(0);" onclick="redirectToGenerate();"  class="btn">Generate Reports</a>
                </div>
                <div class="card">
                    <h3><i class="fas fa-book"></i> Register Courses & Classes</h3>
                    <p>Admins can register courses and assign classes here.</p>
                    <a href="javascript:void(0);" onclick="redirectToRegisterCourses();"  class="btn">Register Courses & Classes</a>
                </div>
            <?php } ?>
            <?php if ($role == 'teacher') { ?>
                <div class="card">
                    <h3><i class="fas fa-pencil-alt"></i> Record Marks</h3>
                    <p>Teachers can record marks here.</p>
                    <a href="javascript:void(0);" onclick="redirectToMarksRecording();" class="btn">Record Student Marks</a>
                </div>
            <?php } ?>
        </section>
    </div>
</div>
<script>
    function redirectToRegisterUser() {
        window.location.href="register_user.php";
    }
    function redirectToGenerate(){
        window.location.href="generating_reports.php";
    }
    function redirectToRegisterCourses(){
        window.location.href="register_courses.php";
    }
    function redirectToMarksRecording(){
    window.location.href="marks_recording.php";
    }
    function redirectToLogout(){
    window.location.href="logout.php";
    }
    function redirectToDashboard(){
    window.location.href="dashboard.php";
    }
</script>
</body>
</html>
