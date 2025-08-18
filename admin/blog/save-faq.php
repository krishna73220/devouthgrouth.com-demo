<?php
include("../dbConn.php");

$post_id = $_POST['post_id'];
$questions = $_POST['question'];
$answers = $_POST['answer'];

// Prepare the statement once
$stmt = $conn->prepare("INSERT INTO blog_post_faqs (post_id, question, answer) VALUES (?, ?, ?)");

// Loop through the FAQs
for ($i = 0; $i < count($questions); $i++) {
    $q = trim($questions[$i]);
    $a = trim($answers[$i]);

    // Validation: skip if question or answer is empty
    if ($q === '' || $a === '') {
        continue;
    }

    $stmt->bind_param("iss", $post_id, $q, $a);
    $stmt->execute();
}

echo "<script>alert('FAQ(s) added successfully'); window.history.back();</script>";
?>
