<?php
// Include your DB connection file
include("dbConn.php"); 

if (isset($_POST['user_id']) && isset($_POST['status'])) {
    $id = intval($_POST['user_id']);         // user id
    $status = intval($_POST['status']);      // new status: 1 or 0

    // Update query
    $query = "UPDATE job_posts SET status = $status WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status";
    }
} else {
    echo "Invalid request";
}
?>
