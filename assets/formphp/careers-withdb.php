<?php

include('../../mydb.php');

try {
    $mailToDG->isSMTP();
    $mailToDG->Host       = 'smtp.hostinger.com';
    $mailToDG->SMTPAuth   = true;
    $mailToDG->Username   = 'info@dgdigital.in';
    $mailToDG->Password   = 'InfoDG@0205';
    $mailToDG->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mailToDG->Port       = 465;

    $mailToCandidate =  clone $mailToDG;

    $mailToDG->setFrom($mailToDG->Username, 'DG Digital');
    $mailToDG->addAddress('monikapriyajha@gmail.com', 'HR');
    // $mailToDG->addCC('monikapriyajha@gmail.com');
    $mailToDG->AddAttachment($file_tmp, $file_name);

    $mailToCandidate->setFrom($mailToCandidate->Username, 'DG Digital');
    $mailToCandidate->addAddress($formEmail, $formName);

    $mailToDG->isHTML(true);
    $mailToDG->Subject = "Application Received";
    $mailToDG->Body = "Name : {$formName}<br><br>Role Applied For : {$formRoleAppliedFor}<br><br>Message: <br>{$formMsg}";

    $mailToCandidate->isHTML(true);
    $mailToCandidate->Subject = "Application submitted with DG";
    $mailToCandidate->Body = "Thank you {$formName} for applying with us.<br>We have received your application.We will review the same and get back to you shortly.";

    $sJSON = new stdClass();
    $sJSON->status = "sucess";
    $sJSON->message = "Your form submitted Sucessfully";
    $mysJSON = json_encode($sJSON);

    $mailToCandidate->send();
    $mailToDG->send();

    echo $mysJSON;

    move_uploaded_file($file_tmp, "uploaded/" . $file_name);
    $sql = "INSERT INTO tbl_resumes (cname, email, appliedfor, msg, cresume, ondate)
    VALUES ('$formName', '$formEmail', '$formRoleAppliedFor' , '$formMsg' , '$file_name' , now())";

    $conn->query($sql);
} catch (Exception $e) {
    $fJSON = new stdClass();
    $fJSON->status = "sucess";
    $fJSON->message = "Error While Submitting";
    $myfJSON = json_encode($fJSON);
    echo $myfJSON;
}
