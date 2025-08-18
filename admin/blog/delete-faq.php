<?php
include("../dbConn.php");

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM blog_post_faqs WHERE id = $id");
echo "<script>alert('FAQ deleted successfully'); window.history.back();</script>";
