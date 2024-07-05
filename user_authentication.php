<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_report');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("SELECT id, password, role, username FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password, $role, $db_username);
    $stmt->fetch();

    // Verify the password and set session variables
    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $db_username; // Set the username in the session
        $_SESSION['role'] = $role;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid login credentials.');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Report System</title>
    <link rel="icon" href="images/kisspng-computer-icons-login-management-user-5ae155f3386149.6695613615247170432309.jpg">
    <link rel="stylesheet" href="user_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Additional styles can be placed here */
        .input-group {
            position: relative;
            margin-bottom: 15px;
        }
        .input-group input {
            padding-right: 40px; /* Adjust as needed to accommodate the icon */
            width: 100%; /* Ensure input field stretches to fill parent */
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        #togglePassword {
            position: absolute;
            top: 50%;
            left: 300px;
            transform: translateY(-50%);
            cursor: pointer;
            z-index: 1;
            color: #555; /* Adjust color as needed */
        }
        #togglePassword.fa-eye-slash {
            transform: translateY(-50%) rotate(-80deg); /* Rotate -45 degrees for oblique slash */
        }
    </style>
</head></style>
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <h2>School report generation Login</h2>
            <form method="POST" action="user_authentication.php">
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" required placeholder="Username">
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" required placeholder="Password">
                    <i id="togglePassword" class="fas fa-eye" aria-hidden="true"></i>
                </div>
                <button type="submit" class="btn">Login</button>
                <br>
                <br>
                <button type="button" class="btn" onclick="redirectToForgotPassword()">Forgot Password</button>
                <br>
                <br>
                <button type="button" class="btn" onclick="redirectToHomepage()">Back to home</button>
            </form>
        </div>
    </div>
    <script>
        function redirectToForgotPassword() {
            window.location.href = "forgot_password.php";
        }
        function redirectToHomepage() {
            window.location.href = "index.html";
        }
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');

            if (togglePasswordButton && passwordInput) {
                togglePasswordButton.addEventListener('click', function() {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    this.classList.toggle('fa-eye-slash');
                });
            }
        });
    </script>
</body>
</html>

