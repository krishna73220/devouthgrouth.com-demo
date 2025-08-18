<?php
// header for JSON
header('Content-Type: application/json');

// Optional debug
file_put_contents(__DIR__ . '/debug_upload.log', print_r($_FILES, true));

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES)) {
    $fileKey = array_key_first($_FILES);
    $file = $_FILES[$fileKey];

    $allowed = ['image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/x-png', 'image/webp'];
    $maxSize = 4 * 1024 * 1024; // 4MB

    if (!in_array($file['type'], $allowed)) {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Invalid file type.']]);
        exit;
    }

    if ($file['size'] > $maxSize) {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'File size exceeds 4MB.']]);
        exit;
    }

    $uploadDir = 'uploaded_blog_images/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'blog_' . time() . '.' . $ext;
    $filepath = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        $url = 'https://www.devoutgrowth.com/admin/blog/' . $filepath;

        echo json_encode([
            'uploaded' => 1,
            'fileName' => $filename,
            'url' => $url
        ]);
    } else {
        echo json_encode(['uploaded' => 0, 'error' => ['message' => 'Failed to move file.']]);
    }
} else {
    echo json_encode(['uploaded' => 0, 'error' => ['message' => 'No file uploaded.']]);
}
