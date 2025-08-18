<?php
session_start();

// Ensure the user is logged in and has a valid session
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] == false) {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit;
}

// Check if the logged-in user is a Super Admin (role_id = 1)
if ($_SESSION['role_id'] != 1) {
    // If not Super Admin, redirect to another page (maybe dashboard or restricted access)
    header("Location: dashboard.php");
    exit;
}

include("../dbConn.php"); // Include your database connection

// Check if the post_id is passed in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = $_GET['id'];

    // Delete the post from the blog_posts table
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        // Successfully deleted, redirect with success message
        header("Location: list_posts.php?msg=deleted");
        exit;
    } else {
        // Error in deletion, redirect with error message
        header("Location: list_posts.php?msg=delete_failed");
        exit;
    }
} else {
    // No post ID passed, redirect with error
    header("Location: list_posts.php?msg=invalid_post");
    exit;
}
?>
