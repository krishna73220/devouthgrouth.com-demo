<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['is_loggedIn']) || !isset($_SESSION['role_id'])) {
    header("Location: ../index.php?msg=not_allowed");
    exit();
}

// Optional: Customize role access per page
$currentRole = $_SESSION['role_id'];

// Set allowed roles for this page
$allowedRoles = [1, 2]; // Allow only Super Admin (1) and SEO Admin (2)

// Check if user's role is allowed
if (!in_array($currentRole, $allowedRoles)) {
    // Redirect based on role
    switch ($currentRole) {
        case 3:
            header("Location: ../hr-dashboard.php?msg=access_denied");
            break;
        default:
            header("Location: ../index.php?msg=not_allowed");
    }
    exit();
}
?>
