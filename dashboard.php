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
                <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
                <?php if ($role == 'admin') { ?>
                    <li><a href="register_user.php"><i class="fas fa-user-plus"></i> Register User</a></li>
                    <li><a href="generating_reports.php"><i class="fas fa-file-alt"></i> Generate Reports</a></li>
                <?php } ?>
                <?php if ($role == 'teacher') { ?>
                    <li><a href="marks_recording.php"><i class="fas fa-pencil-alt"></i> Record Marks</a></li>
                <?php } ?>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
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
                        <a href="register_user.php" class="btn">Register User</a>
                    </div>
                    <div class="card">
                        <h3><i class="fas fa-file-alt"></i> Generate Reports</h3>
                        <p>Admins can generate reports here.</p>
                        <a href="generating_reports.php" class="btn">Generate Reports</a>
                    </div>
                <?php } ?>
                <?php if ($role == 'teacher') { ?>
                    <div class="card">
                        <h3><i class="fas fa-pencil-alt"></i> Record Marks</h3>
                        <p>Teachers can record marks here.</p>
                        <a href="marks_recording.php" class="btn">Record Marks</a>
                    </div>
                <?php } ?>
            </section>
        </div>
    </div>
</body>
</html>
