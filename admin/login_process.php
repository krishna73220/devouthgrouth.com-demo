<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "dg-panel"); // change db name

$email = $_POST['email'];
$password = $_POST['password'];

// Escape for security
$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);

// Query
$query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 1) {
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    // Redirect according to role
    if ($user['role'] == 'super_admin') {
        header("Location: super-admin/dashboard.php");
    } elseif ($user['role'] == 'seo_admin') {
        header("Location: seo-admin/blog-dashboard.php");
    } elseif ($user['role'] == 'enquiry_admin') {
        header("Location: enquiry-admin/index.php");
    } else {
        echo "Unknown role!";
    }
} else {
    echo "Invalid email or password!";
}
?>
