<?php
if (isset($_POST['submit'])) {
    include("dbConn.php");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name     = $conn->real_escape_string($_POST['name']);
    $email    = $conn->real_escape_string($_POST['email']);
    $country_code = $conn->real_escape_string($_POST['country_code']); // NEW
    $phone1   = $conn->real_escape_string($_POST['phone']);
    $interest = $conn->real_escape_string($_POST['interest']);
    $budget   = $conn->real_escape_string($_POST['budget']);
    $phone2   = $conn->real_escape_string($_POST['phone2']);
    $message  = $conn->real_escape_string($_POST['message']);

    $full_phone1 = $country_code . $phone1; // Combine country code and phone

    $target_dir = "uploaded/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

    if (isset($_FILES["file"])) {
        $file = $_FILES["file"];
        $allowed_ext = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'webp'];
        $allowed_mimes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/webp'];
        $file_ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $mime = mime_content_type($file["tmp_name"]);

        if (!in_array($file_ext, $allowed_ext) || !in_array($mime, $allowed_mimes)) {
            echo "<script>alert('Invalid file type.');</script>";
            exit;
        }

        if ($file["size"] > 5 * 1024 * 1024) {
            echo "<script>alert('File size exceeds 5MB.');</script>";
            exit;
        }

        if (!preg_match("/^[0-9]{10}$/", $phone1)) {
            echo "<script>alert('Please enter a valid 10-digit phone number.'); window.history.back();</script>";
            exit;
        }
        if (!empty($phone2) && !preg_match("/^[0-9]{10}$/", $phone2)) {
            echo "<script>alert('Please enter a valid 10-digit alternate phone number.'); window.history.back();</script>";
            exit;
        }

        $new_file_name = uniqid('file_', true) . "." . $file_ext;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO feedback_form (name, email, phone1, interest, budget, phone2, message, uploaded_file) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $name, $email, $full_phone1, $interest, $budget, $phone2, $message, $target_file);

            if ($stmt->execute()) {
                echo "<script>alert('Form submitted successfully'); window.location.href='thank-you.html';</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('File upload failed');</script>";
        }
    } else {
        echo "<script>alert('No file uploaded.');</script>";
    }

    $conn->close();
}
