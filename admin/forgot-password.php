<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("dbConn.php");

    $email = trim($_POST['email']);
    $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        // Generate reset token & expiry time
        $token = bin2hex(random_bytes(16));
        $expiry = date("Y-m-d H:i:s", strtotime('+10 minutes')); // 10 minutes expiry


        // Update token and expiry in DB
        $stmt2 = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expires = ? WHERE email = ?");
        $stmt2->bind_param("sss", $token, $expiry, $email);
        $stmt2->execute();

        // Reset link (update domain if needed)
        $resetLink = "https://www.devoutgrowth.com/admin/reset-password.php?token=$token";


        // Send email
        $subject = "Password Reset Request";
        $message = "Hi {$user['name']},\n\nClick the link below to reset your password:\n$resetLink\n\nThis link will expire in 10 minutes.";
        $headers = "From: no-reply@dgdigital.in\r\nContent-Type: text/plain; charset=UTF-8";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>alert('Password reset link sent to your email.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Failed to send email. Try again later.');</script>";
        }
    } else {
        echo "<script>alert('No account found with this email.');</script>";
    }
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <title>Forgot Password | DG - Admin & Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
    <meta content="Devout Growth" name="author">
    <?php include('include/head.php'); ?>

</head>

<body>

    <section class="auth-page-wrapper py-5 position-relative bg-light d-flex align-items-center justify-content-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-11">
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row g-0 align-items-center">
                                <div class="col-xxl-6 col-md-6 mx-auto">
                                    <div class="card mb-0 border-0 shadow-none mb-0">
                                        <div class="card-body p-sm-5 m-lg-4">
                                            <div class="text-center mt-2">
                                                <h5 class="fs-3xl">Forgot Password?</h5>
                                                <p class="text-muted mb-4">Reset password with DG</p>
                                                <div class="pb-4">
                                                    <img src="assets/images/auth/email.png" alt="Reset Your Password" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="alert border-0 alert-info text-center mb-2 mx-2" role="alert">
                                                One step to access—Enter your email to reset!
                                            </div>
                                            <div class="p-2">
                                                <form method="post">
                                                    <div class="mb-4">
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon"><i class="ri-mail-line"></i></span>
                                                            <input type="email" class="form-control" name="email" id="useremail" placeholder="Enter email address" required>
                                                        </div>
                                                    </div>

                                                    <div class="text-center mt-4">
                                                        <button class="btn btn-primary w-100" type="submit">Send Reset Link</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="mt-4 text-center">
                                                <p class="mb-1">Wait, I remember my password...</p>
                                                <a href="index.php" class="text-secondary text-decoration-underline"> Click here </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-xxl-5 col-md-5">
                                    <div class="card auth-card bg-secondary h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                        <div class="card-body py-5 d-flex justify-content-between flex-column h-100">
                                            <div class="text-center">
                                                <h5 class="text-white">Welcome to DG.</h5>
                                                <p class="text-white opacity-75 fs-base">We'll send you a secure link to reset your password in no time!</p>
                                            </div>

                                            <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <div class="auth-user-list list-unstyled">
                                                    <img src="assets/images/auth/signin.png" alt="user reset" class="img-fluid">
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <p class="text-white opacity-75 mb-0 mt-3">
                                                    &copy;
                                                    <script>
                                                        document.write(new Date().getFullYear())
                                                    </script> DG. Crafted with <i class="ti ti-heart-filled text-danger"></i> by Devout Growth
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include('include/login-footer-js.php'); ?>

</body>

</html>