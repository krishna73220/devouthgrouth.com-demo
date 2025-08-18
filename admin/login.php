<?php 
session_start();
include("dbConn.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password, role_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // Allow only Super Admin
            if ($user['role_id'] != 1) {
                echo "<script>alert('Access denied! Only Super Admin allowed.'); window.history.back();</script>";
                exit;
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role_id'] = $user['role_id'];

            echo "<script>alert('Login successful! Redirecting to dashboard.'); window.location.href='dashboard.php';</script>";
            exit;

        } else {
            echo "<script>alert('Invalid password!'); window.history.back();</script>";
            exit;
        }

    } else {
        echo "<script>alert('User not found!'); window.history.back();</script>";
        exit;
    }
}
?>

<!-- Simple Login Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Super Admin Login</title>
</head>
<body>
    <h2>Super Admin Login</h2>
    <form method="post">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
