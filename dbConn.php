<?php
// Set PHP default timezone
date_default_timezone_set('Asia/Kolkata');

// DB connection
$host_name = "localhost";
$user = "u406436799_Devoutgrowth25";
$pass = "Devout-growth@#25";
$db = "u406436799_dg_panel";

$conn = mysqli_connect($host_name, $user, $pass, $db);

if (!$conn) {
    die("db connection failed: " . mysqli_connect_error());
}

// Set MySQL timezone
mysqli_query($conn, "SET time_zone = '+05:30'");
?>
