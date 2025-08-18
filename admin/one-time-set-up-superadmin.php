<?php
session_start();
include("dbConn.php");

// Check if Super Admin already exists
$check = $conn->query("SELECT COUNT(*) as total FROM users WHERE role_id = 1");
$data = $check->fetch_assoc();

if ($data['total'] >= 1) {
    echo "<script>alert('Super Admin already registered! Please log in.'); window.location.href='login.php';</script>";
    exit;
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role_id = 1; // Super Admin

    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $hashed_password, $role_id);

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful! You can now log in.'); window.location.href='login.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}
?>


<!-- Simple Signup Form -->
<!DOCTYPE html>
<html>

<head>
    <title>Super Admin Signup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center pt-2 mb-3">Super Admin Signup</h2>

                        <div class="tab-content text-center">
                            <!-- one time set up signup Form -->
                            <div class="tab-pane fade show active">
                                <form method="POST" action="">
                                    <div class="form-group mb-3">
                                        <label>Name:</label>
                                        <input type="text" name="name" class="form-control mt-2" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Email:</label><br>
                                        <input type="email" name="email" class="form-control mt-2" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Password:</label><br>
                                        <input type="password" name="password" class="form-control mt-2" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Confirm Password:</label><br>
                                        <input type="password" name="confirm_password" class="form-control mt-2" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 mb-5">Register Super Admin</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>