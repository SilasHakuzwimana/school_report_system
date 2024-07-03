<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'school_report');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['email'])) {
    // Step 1: User Requests Password Reset
    $email = $_POST['email'];

    // Step 2: Email Verification
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Step 3: Send Reset Link
        $token = bin2hex(random_bytes(50)); // Generate a random token
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();

        $resetLink = "http://yourdomain.com/forgot_password.php?token=$token";
        $subject = "Password Reset";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: no-reply@yourdomain.com";

        mail($email, $subject, $message, $headers);

        $_SESSION['reset_email_sent'] = true;
        $_SESSION['reset_email'] = $email;

        header("Location: forgot_password.php");
        exit();
    } else {
        $error_message = "Email not found.";
    }

    $stmt->close();
} elseif (isset($_POST['token']) && isset($_POST['password'])) {
    // Step 4: Reset Password Form
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Verify the token
    $stmt = $conn->prepare("SELECT email FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($email);
    $stmt->fetch();

    if ($stmt->num_rows > 0) {
        // Step 5: Update Password
        $stmt->close();

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();

        // Delete the reset token after successful password reset
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        $_SESSION['password_reset_success'] = true;

        header("Location: login.php"); // Redirect to login page after successful password reset
        exit();
    } else {
        $error_message = "Invalid or expired token.";
    }

    $stmt->close();
}
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        /* Reset default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            }

        /* Basic styling for the page container */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

        .form-container {
            text-align: center;
            }

        h2 {
            margin-bottom: 20px;
            color: #333;
            }

        .input-group {
            margin-bottom: 15px;
            }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            outline: none;
            }

        button.btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            }

        button.btn:hover {
            background-color: #0056b3;
            }

        .error {
            color: #ff0000;
            margin-top: 10px;
            }

        /* Responsive adjustments */
        @media (max-width: 768px) {
        .container {
            max-width: 90%;
            }
            }

        @media (max-width: 480px) {
            input[type="email"],
            input[type="password"] {
            font-size: 14px;
            }
            }
    </style>
</head>
<body>
<div class="container">
        <div class="form-container">
            <?php if (isset($_SESSION['reset_email_sent']) && $_SESSION['reset_email_sent']) { ?>
                <h2>Reset Password</h2>
                <form method="POST" action="forgot_password.php">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
                    <div class="input-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" required placeholder="Enter your new password">
                    </div>
                    <button type="submit" class="btn">Reset Password</button>
                </form>
                <?php unset($_SESSION['reset_email_sent']); ?>
            <?php } else { ?>
                <h2>Forgot Password</h2>
                <?php if (isset($error_message)) { ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php } ?>
                <form method="POST" action="forgot_password.php">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required placeholder="Enter your email">
                    </div>
                    <button type="submit" class="btn">Send Reset Link</button>
                    <br>
                    <br>
                    <button type="button" class="btn" onclick="redirectToForgotPassword()">Back to login</button>
                </form>
            <?php } ?>
        </div>
    </div>
    <script>
        function redirectToForgotPassword() {
            window.location.href = "user_authentication.php";
        }
    </script>
</body>
</html>
