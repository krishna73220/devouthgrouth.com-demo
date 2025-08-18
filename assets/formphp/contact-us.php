<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/Exception.php';
require './phpmailer/PHPMailer.php';
require './phpmailer/SMTP.php';

if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secretKey = '6LccC-IqAAAAAAc4fTtcvsKebGE6OvOXAuiFwUnI'; 
    $captcha = $_POST['g-recaptcha-response'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$captcha}";

    $response = file_get_contents($url);
    $responseData = json_decode($response);

    if ($responseData && $responseData->success) {

        // Form data
        $formName = $_POST["your-name"];
        $formEmail = $_POST["your-email"];
        $formphone = $_POST["your-phone-number"];
        $formenqre = $_POST["purpose-of-enquiry"];
        $formMsg = $_POST["your-message"];

        // Database connection
        include("dbConn.php");

        // Insert form data into database
        $stmt = $conn->prepare("INSERT INTO enquiries (name, email, phone, purpose, message) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $formName, $formEmail, $formphone, $formenqre, $formMsg);
        $stmt->execute();
        $stmt->close();
        $conn->close();

        // PHPMailer to send email
        $mailToDG = new PHPMailer(true);
        $mailToClient = new PHPMailer(true);

        try {
            $mailToDG->isSMTP();
            $mailToDG->Host       = 'smtp.hostinger.com';
            $mailToDG->SMTPAuth   = true;
            $mailToDG->Username   = 'no-reply@dgdigital.in';
            $mailToDG->Password   = 'No_reply#2025';
            $mailToDG->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mailToDG->Port       = 465;

            $mailToClient = clone $mailToDG;

            $mailToDG->setFrom($mailToDG->Username, 'Devout Growth');
            $mailToDG->addAddress('contact@devoutgrowth.com', 'Devout Growth');
            $mailToDG->addCC('monikapriyajha@gmail.com');
            $mailToDG->addReplyTo($formEmail, $formName);

            $mailToClient->setFrom($mailToClient->Username, 'Devout Growth');
            $mailToClient->addAddress($formEmail, $formName);

            $mailToDG->isHTML(true);
            $mailToDG->Subject = "Application Received - {$formName}";
            $mailToDG->Body = "Name: {$formName}<br>Email: {$formEmail}<br>Phone Number: {$formphone}<br>Purpose of Enquiry: {$formenqre}<br>Message:<br>{$formMsg}";
            $mailToDG->AltBody = "Name: {$formName}\nEmail: {$formEmail}\nPhone Number: {$formphone}\nPurpose of Enquiry: {$formenqre}\nMessage:\n{$formMsg}";

            $mailToClient->isHTML(true);
            $mailToClient->addReplyTo('contact@devoutgrowth.com', 'HR');
            $mailToClient->Subject = "Application Submitted with DG";
            $mailToClient->Body = "Thank you {$formName} for reaching out to us. We are excited to know about your company and followed requirements. <br> It will be great if we can connect to know more about your services and operations. Let’s connect!";
            $mailToClient->AltBody = "Thank you {$formName} for reaching out to us. We are excited to know about your company and followed requirements. It will be great if we can connect to know more about your services and operations. Let’s connect!";

            $mailToClient->send();
            $mailToDG->send();

            echo "<script>
                alert('Your form submitted successfully');
                window.history.back();
            </script>";
        } catch (Exception $e) {
            echo "<script>
                alert('Something went wrong while sending the email. Please try again later.');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
        alert('reCAPTCHA verification failed. Please try again.');
        window.history.back();
        </script>";
    }
} else {
    echo "<script>
    alert('Please complete the reCAPTCHA.');
    window.history.back();
    </script>";
}
