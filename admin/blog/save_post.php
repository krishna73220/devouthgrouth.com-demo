<?php
session_start();
include("../dbConn.php"); // DB connection
require_once 'auth_check.php'; // check login session

// CSRF Token check (optional during Dropzone upload)
if (isset($_POST['csrf_token']) && $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die("Invalid CSRF token.");
}

// Form values
$title = trim($_POST['title'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$category_id = intval($_POST['category_id'] ?? 0);
$author = htmlspecialchars($_POST['author'] ?? '');
$short_desc = trim($_POST['short_desc'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = isset($_POST['status']) ? intval($_POST['status']) : 1;
$seo_description = trim($_POST['seo_description']);
$created_at = date("Y-m-d H:i:s");

// ========== 🟢 FILE UPLOAD ONLY MODE (Dropzone from edit page) ==========
if (isset($_FILES['image']) && isset($_POST['slug']) && !isset($_POST['title'])) {
    $slug = trim($_POST['slug']);

    $allowed = ['image/jpeg', 'image/png', 'image/webp'];
    $file = $_FILES['image'];

    if (!in_array($file['type'], $allowed)) {
        die("Invalid file type.");
    }

    if ($file['size'] > 4 * 1024 * 1024) {
        die("Image size should be less than 4MB.");
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $image_name = 'blog_' . time() . '.' . $ext;
    $upload_dir = 'uploaded_blog_images/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $featured_image = $upload_dir . $image_name;
    if (move_uploaded_file($file['tmp_name'], $featured_image)) {
        // ✅ Update only image in edit mode
        $stmt = $conn->prepare("UPDATE blog_posts SET featured_image = ? WHERE slug = ?");
        $stmt->bind_param("ss", $featured_image, $slug);
        if ($stmt->execute()) {
            echo "Image updated successfully!";
        } else {
            echo "Error updating image: " . $stmt->error;
        }
        $stmt->close();
        exit;
    } else {
        die("Image upload failed.");
    }
}

// ========== 🔵 CREATE NEW BLOG MODE ==========
if (!empty($title)) {
    // Auto-generate slug if empty
    if (empty($slug)) {
        $slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $title));
        $slug = trim($slug, '-');
    }

    // Ensure unique slug
    $stmt = $conn->prepare("SELECT COUNT(*) FROM blog_posts WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        $slug .= '-' . time();
    }

    // Image Upload
    $featured_image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $file = $_FILES['image'];

        if (!in_array($file['type'], $allowed)) {
            die("Invalid file type.");
        }

        if ($file['size'] > 4 * 1024 * 1024) {
            die("Image size should be less than 4MB.");
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $image_name = 'blog_' . time() . '.' . $ext;
        $upload_dir = 'uploaded_blog_images/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $featured_image = $upload_dir . $image_name;
        move_uploaded_file($file['tmp_name'], $featured_image);
    }

    // Insert
    $stmt = $conn->prepare("INSERT INTO blog_posts (title, slug, category_id, author, short_desc, description, featured_image, seo_description, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisssssis", $title, $slug, $category_id, $author, $short_desc, $description, $featured_image, $seo_description, $status, $created_at);

    if ($stmt->execute()) {
        echo "<script>alert('Post added successfully!'); window.location.href='list_posts.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
