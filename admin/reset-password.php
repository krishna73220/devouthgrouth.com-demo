<?php
include("dbConn.php");

if (!isset($_GET['token'])) {
    echo "Invalid reset link.";
    exit;
}

$token = $_GET['token'];

$stmt = $conn->prepare("SELECT email, reset_token_expires FROM users WHERE reset_token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows !== 1) {
    echo "Invalid or expired reset link.";
    exit;
}

$user = $res->fetch_assoc();
$current_time = date("Y-m-d H:i:s");

if ($current_time > $user['reset_token_expires']) {
    echo "<script>alert('Reset link expired. Please request again.'); window.location.href='forgot-password.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Password and Confirm Password do not match.');</script>";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $stmt2 = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE reset_token = ?");
        $stmt2->bind_param("ss", $hashed_password, $token);
        
        if ($stmt2->execute()) {
            echo "<script>alert('Password updated successfully.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error updating password. Please try again.');</script>";
        }
    }
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="disable" data-bs-theme="light">

<head>

    <meta charset="utf-8">
    <title>Create New Password | DG - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
    <meta content="Devout Growth" name="author">
    <?php include('include/head.php'); ?>
    <style>
        .valid {
            color: green;
        }

        .invalid {
            color: red;
        }

        .password-addon {
            cursor: pointer;
        }
    </style>
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
                                            <div class="text-center">
                                                <h5 class="fs-3xl">Create new password</h5>
                                                <p class="text-muted mb-5">Your new password must be different from previous used password.</p>
                                            </div>

                                            <div class="p-2">
                                                <form method="post">
                                                    <div class="mb-3">
                                                        <!-- <label class="form-label" for="password-input">Password</label> -->
                                                        <div class="position-relative auth-pass-inputgroup">
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1"><i class="ri-lock-2-line"></i></span>
                                                                <input type="password" name="new_password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                                                <button class="btn btn-link position-absolute shadow-none end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                            </div>

                                                        </div>
                                                        <div id="passwordInput" class="form-text">Your password must be 8-20 characters long.</div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label" for="confirm-password-input">Confirm Password</label>
                                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="basic-addon1"><i class="ri-lock-2-line"></i></span>
                                                                <input type="password" name="confirm_password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="confirm-password-input" required>
                                                                <button class="btn btn-link position-absolute shadow-none end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                                        <h5 class="fs-sm">Password must contain:</h5>
                                                        <p id="pass-length" class="invalid fs-xs mb-2">Minimum <b>8 characters</b></p>
                                                        <p id="pass-lower" class="invalid fs-xs mb-2">At <b>lowercase</b> letter (a-z)</p>
                                                        <p id="pass-upper" class="invalid fs-xs mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                                        <p id="pass-number" class="invalid fs-xs mb-0">A least <b>number</b> (0-9)</p>
                                                    </div>

                                                    <div class="form-check form-check-primary">
                                                        <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                    </div>

                                                    <div class="mt-4">
                                                        <button class="btn btn-primary w-100" type="submit">Reset Password</button>
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
                                                <p class="text-white opacity-75">You're almost there! The new key to access your account is just a step away.</p>
                                            </div>

                                            <div class="auth-effect-main my-5 position-relative rounded-circle d-flex align-items-center justify-content-center mx-auto">
                                                <div class="auth-user-list list-unstyled">
                                                    <img src="assets/images/auth/signin.png" alt="" class="img-fluid">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end container-->
    </section>

    <?php include('include/login-footer-js.php'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector("form");
            const passwordInput = document.getElementById('password-input');
            const confirmPasswordInput = document.getElementById('confirm-password-input');

            const passLength = document.getElementById('pass-length');
            const passLower = document.getElementById('pass-lower');
            const passUpper = document.getElementById('pass-upper');
            const passNumber = document.getElementById('pass-number');

            // Function to validate password strength
            function validatePasswordStrength(password) {
                let valid = true;

                // Length
                const isLengthValid = password.length >= 8;
                passLength.classList.toggle('valid', isLengthValid);
                passLength.classList.toggle('invalid', !isLengthValid);
                valid = valid && isLengthValid;

                // Lowercase
                const hasLower = /[a-z]/.test(password);
                passLower.classList.toggle('valid', hasLower);
                passLower.classList.toggle('invalid', !hasLower);
                valid = valid && hasLower;

                // Uppercase
                const hasUpper = /[A-Z]/.test(password);
                passUpper.classList.toggle('valid', hasUpper);
                passUpper.classList.toggle('invalid', !hasUpper);
                valid = valid && hasUpper;

                // Number
                const hasNumber = /\d/.test(password);
                passNumber.classList.toggle('valid', hasNumber);
                passNumber.classList.toggle('invalid', !hasNumber);
                valid = valid && hasNumber;

                return valid;
            }

            // Show password requirements on focus
            passwordInput.addEventListener('focus', function() {
                document.getElementById('password-contain').style.display = 'block';
            });

            // Hide password requirements on blur if empty or invalid
            passwordInput.addEventListener('blur', function() {
                if (!passwordInput.value || !validatePasswordStrength(passwordInput.value)) {
                    document.getElementById('password-contain').style.display = 'none';
                }
            });

            // Real-time validation on input
            passwordInput.addEventListener('input', function() {
                validatePasswordStrength(passwordInput.value);
            });

            // Confirm password live match check
            confirmPasswordInput.addEventListener('input', function() {
                confirmPasswordInput.setCustomValidity(
                    confirmPasswordInput.value !== passwordInput.value ?
                    "Passwords do not match" :
                    ""
                );
            });

            // Final form submit validation
            form.addEventListener("submit", function(e) {
                const pass = passwordInput.value;
                const confirm = confirmPasswordInput.value;

                const isStrong = validatePasswordStrength(pass);

                if (!isStrong) {
                    alert("Password does not meet the required criteria.");
                    e.preventDefault();
                    return;
                }

                if (pass !== confirm) {
                    alert("Password and Confirm Password do not match.");
                    e.preventDefault();
                }
            });
        });
    </script>


</body>

</html>