<?php
include("../dbConn.php");

$data = json_decode(file_get_contents("php://input"), true);
$slug = $data['slug'];
$duration = $data['duration'];

// Optionally get IP or session info too
$ip = $_SERVER['REMOTE_ADDR'];

$stmt = $conn->prepare("INSERT INTO blog_visit_logs (slug, duration, ip_address, visit_time) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("sis", $slug, $duration, $ip);
$stmt->execute();
?>
