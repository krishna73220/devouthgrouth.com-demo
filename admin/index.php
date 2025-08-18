<?php 
session_start();

// Show alerts for URL messages
if (!empty($_GET['msg'])) {
    if ($_GET['msg'] == 'not_allowed') {
        echo "<script>alert('Please login first.');</script>";
    } elseif ($_GET['msg'] == 'logout') {
        echo "<script>alert('Logged out successfully.');</script>";
    }
}

include("dbConn.php");

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, email, password, role_id, status FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Check if account is active
            if ($user['status'] != 1) {
                echo "<script>alert('Your account is inactive. Contact admin.'); window.history.back();</script>";
                exit;
            }

            // Setup session
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role_id'] = $user['role_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_loggedIn'] = true;

            // Redirect based on role
            switch ($user['role_id']) {
                case 1:
                    echo "<script>alert('Welcome Bhagwan! 🙏🙏'); window.location.href='dashboard.php';</script>";
                    break;
                case 2:
                    echo "<script>alert('Welcome SEO Admin!'); window.location.href='blog/dashboard.php';</script>";
                    break;
                case 3:
                    echo "<script>alert('Welcome HR Admin!'); window.location.href='hr-dashboard.php';</script>";
                    break;
                    case 4:
                    echo "<script>alert('Welcome BD Admin!'); window.location.href='bd-dashboard.php';</script>";
                    break;
                default:
                    echo "<script>alert('Your role is not recognized.'); window.history.back();</script>";
            }

            exit;

        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('No user found with that email.'); window.history.back();</script>";
        exit;
    }
}
?>




<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <title>Sign Up | Devout Growth - Admin & Dashboard</title>
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
                                            <div class="text-center mt-5">
                                                <h5 class="fs-3xl">Welcome Back</h5>
                                                <p class="text-muted">Sign in to continue to DG.</p>
                                            </div>
                                            <div class="p-2 mt-5">
                                                <form action="" method="post" autocomplete="off">
                                                    <div class="mb-3">
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon"><i class="ri-user-3-line"></i></span>
                                                            <input name="email" required class="form-control" id="username" placeholder="Enter username">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <div class="position-relative auth-pass-inputgroup overflow-hidden">
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1"><i class="ri-lock-2-line"></i></span>
                                                                <input type="password" name="password" required class="form-control pe-5 password-input" placeholder="Enter password" id="password-input">
                                                            </div>
                                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="float-end">
                                                        <a href="forgot-password.php" class="text-muted">Forgot password?</a>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                    </div>
                                                    <div class="mt-4">
                                                        <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                                    </div>
                                                    <div class="mt-4 pt-2 text-center">
                                                        <div class="signin-other-title position-relative">
                                                            <h5 class="fs-sm mb-4 title">Sign In with</h5>
                                                        </div>
                                                        <div class="pt-2 hstack gap-2 justify-content-center">
                                                        <a href="https://www.facebook.com/devoutgrowth" target="_blank"><button type="button" class="btn btn-subtle-primary btn-icon"><i class="ri-facebook-fill fs-lg"></i></button></a>
                                                        <a href="https://www.instagram.com/devoutgrowth" target="_blank"><button type="button" class="btn btn-subtle-danger btn-icon"><i class="ri-instagram-fill fs-lg"></i></button></a>
                                                        <a href="https://github.com/dgdigital-tech" target="_blank"><button type="button" class="btn btn-subtle-dark btn-icon"><i class="ri-github-fill fs-lg"></i></button></a>
                                                            <a href="https://x.com/Devoutgrowth" target="_blank"><button type="button" class="btn btn-subtle-info btn-icon"><i class="ri-twitter-fill fs-lg"></i></button></a>
                                                        </div>
                                                    </div>
                                                </form>
                                                <div class="text-center mt-5">
                                                    <p class="mb-1">Trouble signing in?</p>
                                                    <a href="forgot-password.php" class="text-secondary text-decoration-underline"> Forgot password</a>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div><!-- end card -->
                                </div>
                                <!--end col-->
                                <div class="col-xxl-5 col-md-5">
                                    <div class="card auth-card h-100 border-0 shadow-none d-none d-sm-block mb-0">
                                        <div class="card-body py-5 d-flex justify-content-between flex-column">
                                            <div class="text-center">
                                                <h5 class="text-white">Nice to see you again!</h5>
                                                <p class="text-white opacity-75">Enter your details and start your journey with us.</p>
                                            </div>
                                            <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <div class="auth-user-list list-unstyled">
                                                    <img src="assets/images/auth/signin.png" alt="admin" class="img-fluid">
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
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <?php include('include/login-footer-js.php'); ?>

</body>

</html>