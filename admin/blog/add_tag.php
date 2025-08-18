<?php
// Database connection
include("../dbConn.php");

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get the tag name from the form (to add a new tag)
    if (!empty($_POST['tag_name'])) {
        $tag_name = mysqli_real_escape_string($conn, $_POST['tag_name']);

        // Insert the tag into the tags table
        $sql = "INSERT INTO tags (tag_name) VALUES ('$tag_name')";
        if (mysqli_query($conn, $sql)) {
            echo "New tag added successfully!<br>";
        } else {
            echo "Error: " . mysqli_error($conn) . "<br>";
        }
    }

    // Check if tags are selected to assign to a post
    if (!empty($_POST['tags'])) {
        $post_id = 1;  // Example: post ID, change accordingly

        // Loop through selected tags and insert into blog_post_tags table
        foreach ($_POST['tags'] as $tag_id) {
            $sql = "INSERT INTO blog_post_tags (post_id, tag_id) VALUES ('$post_id', '$tag_id')";
            if (mysqli_query($conn, $sql)) {
                echo "Tag assigned to post successfully!<br>";
            } else {
                echo "Error: " . mysqli_error($conn) . "<br>";
            }
        }
    }
}

// Fetch tags from the database
$sql = "SELECT * FROM tags";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add and Assign Tags</title>
</head>
<body>

<h2>Add a New Tag</h2>
<form action="" method="POST">
    <label for="tag_name">Tag Name:</label>
    <input type="text" id="tag_name" name="tag_name" required>
    <button type="submit" name="submit">Add Tag</button>
</form>

<h2>Assign Tags to Post</h2>
<form action="" method="POST">
    <label for="tags">Select Tags:</label>
    <select name="tags[]" id="tags" multiple required>
        <?php
        // Display tags from the database
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<option value='" . $row['tag_id'] . "'>" . $row['tag_name'] . "</option>";
        }
        ?>
    </select>
    <button type="submit" name="submit">Assign Tags</button>
</form>

</body>
</html>
