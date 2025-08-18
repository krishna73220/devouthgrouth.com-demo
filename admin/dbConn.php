<?php
// Set PHP default timezone
date_default_timezone_set('Asia/Kolkata');

// Database connection using mysqli (with basic error handling)
$host = "localhost";
$user = "u406436799_Devoutgrowth25";
$pass = "Devout-growth@#25";
$dbname = "u406436799_dg_panel";

$conn = mysqli_connect($host, $user, $pass, $dbname);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Set MySQL timezone
mysqli_query($conn, "SET time_zone = '+05:30'");
?>
