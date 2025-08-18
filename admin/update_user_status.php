<?php
// Include your DB connection file
include("dbConn.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from AJAX request
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    // Validate inputs (optional but recommended)
    if (!is_numeric($user_id) || !in_array($status, [0, 1])) {
        echo "Invalid data.";
        exit;
    }

    // Update the user status
    $query = "UPDATE users SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $status, $user_id);

    if ($stmt->execute()) {
        echo "Status updated successfully.";
    } else {
        echo "Failed to update status.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
