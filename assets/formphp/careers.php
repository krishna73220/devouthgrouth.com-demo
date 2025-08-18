<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';
require './phpmailer/Exception.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Sanitize and validate inputs
$formName = htmlspecialchars($_POST["your-name"], ENT_QUOTES, 'UTF-8');
$formEmail = filter_var($_POST["your-email"], FILTER_SANITIZE_EMAIL);
$formRoleAppliedFor = htmlspecialchars($_POST["role-applying"], ENT_QUOTES, 'UTF-8');
$formMsg = htmlspecialchars($_POST["your-message"], ENT_QUOTES, 'UTF-8');

// Email validation
if (!filter_var($formEmail, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email address'); window.location.href='../../';</script>";
    exit;
}

// Validate file upload
if ($_FILES['attachment']['error'] !== UPLOAD_ERR_OK) {
    echo "<script>alert('File upload error'); window.location.href='../../';</script>";
    exit;
}

// Validate file type and size
$file_tmp  = $_FILES['attachment']['tmp_name'];
$file_name = preg_replace("/[^a-zA-Z0-9\._-]/", "_", basename($_FILES['attachment']['name']));
$file_size = $_FILES['attachment']['size'];
$file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
$allowed_types = ['pdf', 'doc', 'docx'];

if (!in_array($file_ext, $allowed_types) || $file_size > 5242880) {
    echo "<script>alert('Invalid file type or file size exceeded (max 5MB).'); window.location.href='../../';</script>";
    exit;
}

// Save uploaded file to a directory (optional)
$uploadDir = __DIR__ . '/uploaded/resumes/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
$destinationPath = $uploadDir . $file_name;
move_uploaded_file($file_tmp, $destinationPath);

// Send Emails
$mailToDG = new PHPMailer(true);
$mailToCandidate = new PHPMailer(true);

try {
    // SMTP configuration
    $mailToDG->isSMTP();
    $mailToDG->Host       = 'smtp.hostinger.com';
    $mailToDG->SMTPAuth   = true;
    $mailToDG->Username   = 'no-reply@dgdigital.in';
    $mailToDG->Password   = 'No_reply#2025';
    $mailToDG->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mailToDG->Port       = 465;
    $mailToDG->CharSet    = 'UTF-8';

    $mailToCandidate = clone $mailToDG;

    // Mail to HR
    $mailToDG->setFrom($mailToDG->Username, 'DG Digital');
    $mailToDG->addAddress('hr@devoutgrowth.com', 'HR');
    $mailToDG->addCC('monikapriyajha@gmail.com');
    $mailToDG->addReplyTo($formEmail, $formName);
    $mailToDG->addAttachment($destinationPath, $file_name);

    $mailToDG->isHTML(true);
    $mailToDG->Subject = "Application Received";
    $mailToDG->Body    = "Name: {$formName}<br>Email: {$formEmail}<br>Role Applied For: {$formRoleAppliedFor}<br><br>Message:<br>{$formMsg}";

    // Mail to Candidate
    $mailToCandidate->setFrom($mailToCandidate->Username, 'Devout Growth');
    $mailToCandidate->addAddress($formEmail, $formName);
    $mailToCandidate->addReplyTo('hr@devoutgrowth.com', 'HR');
    $mailToCandidate->isHTML(true);
    $mailToCandidate->Subject = "Application Submitted with DG";
    $mailToCandidate->Body    = "Thank you {$formName} for applying.<br>We have received your application and will get back to you shortly.";

    // Send both mails
    $mailToCandidate->send();
    $mailToDG->send();

    // Database insert
    include("dbConn.php");

    $file_type = mime_content_type($destinationPath);
    $stmt = $conn->prepare("INSERT INTO career_applications (name, email, role_applying_for, message, resume_filename, resume_filetype, resume_filesize) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $formName, $formEmail, $formRoleAppliedFor, $formMsg, $file_name, $file_type, $file_size);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "<script>alert('Your form was submitted successfully'); window.location.href='../../';</script>";

} catch (Exception $e) {
    error_log("PHPMailer Error: " . $e->getMessage());
    echo "<script>alert('Something went wrong: " . addslashes($e->getMessage()) . "'); window.location.href='../../';</script>";
}
?>
