<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'school_report');

// Check for form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (name, email, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('User registered successfully');</script>";
    } else {
        echo "<script>alert('Error registering user');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User - School Report System</title>
    <link rel="icon" href="images/register.png">
    <link rel="stylesheet" href="register_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Register User</h2>
            <form method="POST" action="register_user.php">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" required placeholder="Enter name">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required placeholder="Enter email">
                </div>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required placeholder="Enter username">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required placeholder="Enter password">
                </div>
                <div class="input-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value="admin">Admin</option>
                        <option value="teacher">Teacher</option>
                    </select>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
