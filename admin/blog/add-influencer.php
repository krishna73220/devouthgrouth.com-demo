<?php
session_start();
include("../dbConn.php");
require_once 'auth_check.php'; // check login session

// Get post_id using slug
$post_id = 0;
$slug = '';
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];
    $stmt = $conn->prepare("SELECT post_id, title FROM blog_posts WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $stmt->bind_result($post_id, $post_title);
    $stmt->fetch();
    $stmt->close();
}
if ($post_id <= 0) {
    die("Invalid blog post.");
}

// ✅ UPDATE Influencer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = $_POST['name'];
    $followers = $_POST['followers'];
    $engagement_rate = $_POST['engagement_rate'];
    $description = $_POST['description'];
    $image_name = '';

    // Get existing image
    $stmt = $conn->prepare("SELECT image FROM influencers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($existing_image);
    $stmt->fetch();
    $stmt->close();

    $image_uploaded = false;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $targetDir = "influencers/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $image_name = basename($_FILES["image"]["name"]);
        $targetFilePath = $targetDir . $image_name;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            $image_uploaded = true;
        } else {
            $image_name = $existing_image;
        }
    } else {
        $image_name = $existing_image;
    }

    $stmt = $conn->prepare("UPDATE influencers SET name = ?, followers = ?, engagement_rate = ?, description = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $name, $followers, $engagement_rate, $description, $image_name, $id);
    if ($stmt->execute()) {
        if ($image_uploaded && !empty($existing_image) && file_exists("influencers/" . $existing_image)) {
            unlink("influencers/" . $existing_image);
        }
        header("Location: add-influencer.php?slug=" . urlencode($slug) . "&updated=1");
        exit;
    } else {
        echo "<script>alert('Failed to update influencer.'); window.history.back();</script>";
    }
    $stmt->close();
}

// ✅ ADD Influencers
elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['name']) && is_array($_POST['name'])) {
    $title = $_POST['title'];
    $names = $_POST['name'];
    $followers_list = $_POST['followers'];
    $engagement_rates = $_POST['engagement_rate'];
    $descriptions = $_POST['description'];
    $images = $_FILES['image'];

    $total = count($names);
    $success = true;

    for ($i = 0; $i < $total; $i++) {
        $name = $names[$i];
        $followers = $followers_list[$i];
        $engagement_rate = $engagement_rates[$i];
        $description = $descriptions[$i];
        $image_name = '';

        if (!empty($images['name'][$i])) {
            $targetDir = "influencers/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $image_name = basename($images["name"][$i]);
            $targetFilePath = $targetDir . $image_name;
            move_uploaded_file($images["tmp_name"][$i], $targetFilePath);
        }

        $stmt = $conn->prepare("INSERT INTO influencers (post_id, name, title, image, followers, engagement_rate, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $post_id, $name, $title, $image_name, $followers, $engagement_rate, $description);
        if (!$stmt->execute()) {
            $success = false;
        }
        $stmt->close();
    }

    if ($success) {
        echo "<script>alert('Influencers Added Successfully');</script>";
    } else {
        echo "<script>alert('Error: One or more influencers failed to save.');</script>";
    }
}

// ✅ DELETE Influencer
elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT image FROM influencers WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image);
    $stmt->fetch();
    $stmt->close();

    if (!empty($image)) {
        $imagePath = "influencers/" . $image;
        $deleteStmt = $conn->prepare("DELETE FROM influencers WHERE id = ?");
        $deleteStmt->bind_param("i", $id);
        if ($deleteStmt->execute()) {
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            echo "<script>alert('Influencer deleted successfully.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Failed to delete influencer.'); window.history.back();</script>";
        }
        $deleteStmt->close();
    } else {
        echo "<script>alert('Influencer not found.'); window.history.back();</script>";
    }
}
?>

<!-- ✅ One-time alert for update success -->
<?php if (isset($_GET['updated']) && $_GET['updated'] == 1): ?>
    <script>
        alert('Influencer updated successfully.');
        if (window.history.replaceState) {
            const url = new URL(window.location);
            url.searchParams.delete('updated');
            window.history.replaceState({}, document.title, url.toString());
        }
    </script>
<?php endif; ?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Add Influencer | DG - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
    <meta content="Devout Growth" name="author">
    <?php include('../include/blog-head.php'); ?>
</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include('../include/sidebar-blog.php'); ?>
        <!-- Left Sidebar End -->
        <?php include('../include/blog-header.php'); ?>
        <?php include('../include/notification-model.php'); ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Influencer</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="card">

                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="col-xxl-6">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Add New Influencer List</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted">We help brands team up with real voices <code>people</code> actually listen to  </p>

                                        <!-- Single Title Input -->
                                        <div class="row mb-3">
                                            <div class="col-lg-3"><label class="form-label">Title Name:</label></div>
                                            <div class="col-lg-9"><input class="form-control" type="text" name="title" placeholder="List Heading"></div>
                                        </div>

                                        <div id="influencer-wrapper">
                                            <div class="influencer-block">
                                                <div class="row mb-3">
                                                    <div class="col-lg-3"><label class="form-label">Influencer Name:</label></div>
                                                    <div class="col-lg-9"><input type="text" name="name[]" class="form-control" required></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-lg-3"><label class="form-label">Influencer Image:</label></div>
                                                    <div class="col-lg-9"><input type="file" name="image[]" class="form-control" accept="image/*" required></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-lg-3"><label class="form-label">Followers:</label></div>
                                                    <div class="col-lg-9"><input type="text" name="followers[]" class="form-control" required></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-lg-3"><label class="form-label">Engagement Rate:</label></div>
                                                    <div class="col-lg-9"><input type="text" name="engagement_rate[]" class="form-control" required></div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-lg-3"><label class="form-label">About the Creator:</label></div>
                                                    <div class="col-lg-9"><textarea name="description[]" rows="4" class="form-control" required></textarea></div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-success mb-3" onclick="addInfluencer()">+ Add More</button>
                                    </div>
                                </div>

                                <div class="text-end pb-2 mb-3 me-4">
                                    <button type="submit" class="btn btn-primary">Submit All</button>
                                </div>
                            </form>

                        </div>
                        <!-- end row -->
                    </div>


                </div> <!-- container-fluid -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <?php
                            if (isset($_GET['slug'])) {
                                $slug = mysqli_real_escape_string($conn, $_GET['slug']);

                                // Get post_id from slug
                                $postQuery = "SELECT post_id FROM blog_posts WHERE slug = '$slug'";
                                $postResult = mysqli_query($conn, $postQuery);

                                if (mysqli_num_rows($postResult) > 0) {
                                    $postRow = mysqli_fetch_assoc($postResult);
                                    $post_id = $postRow['post_id'];

                                    // Fetch influencers related to post_id
                                    $query = "SELECT * FROM influencers WHERE post_id = '$post_id' ORDER BY id ASC";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                            ?>
                                        <table class="table table-responsive align-middle table-hover table-bordered" cellpadding="10" cellspacing="0" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Name</th>
                                                    <th>Followers</th>
                                                    <th>Engagement Rate</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sl = 1;
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                ?>
                                                    <tr>
                                                        <td><?= $sl++; ?></td>
                                                        <td><img src="influencers/<?= htmlspecialchars($row['image']) ?>" width="80" /></td>
                                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                                        <td><?= htmlspecialchars($row['followers']) ?></td>
                                                        <td><?= htmlspecialchars($row['engagement_rate']) ?></td>
                                                        <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                                                            <a href="add-influencer.php?slug=<?= urlencode($slug) ?>&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete this influencer?')">Delete</a>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <form action="" method="POST" enctype="multipart/form-data">
                                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Edit Influencer</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="mb-3">
                                                                            <label>Name</label>
                                                                            <input type="text" name="name" value="<?= htmlspecialchars($row['name']) ?>" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Followers</label>
                                                                            <input type="text" name="followers" value="<?= htmlspecialchars($row['followers']) ?>" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Engagement Rate</label>
                                                                            <input type="text" name="engagement_rate" value="<?= htmlspecialchars($row['engagement_rate']) ?>" class="form-control">
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Description</label>
                                                                            <textarea name="description" class="form-control"><?= htmlspecialchars($row['description']) ?></textarea>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label>Image (optional)</label>
                                                                            <input type="file" name="image" class="form-control">
                                                                            <small>Current: <?= htmlspecialchars($row['image']) ?></small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php
                                                } // end while
                                                ?>
                                            </tbody>
                                        </table>
                            <?php
                                    } else {
                                        echo "<p>No influencers found.</p>";
                                    }
                                } else {
                                    echo "<p>Invalid slug.</p>";
                                }
                            } else {
                                echo "<p>Slug not set.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Page-content -->


            <?php include('../include/dashboard-footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('../include/blog-loader.php'); ?>
    <?php include('../include/blog-footer-js.php'); ?>

    <script>
        function addInfluencer() {
            const html = `
        <div class="influencer-block">
            <div class="row mb-3">
                <div class="col-lg-3"><label class="form-label">Influencer Name:</label></div>
                <div class="col-lg-9"><input type="text" name="name[]" class="form-control" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3"><label class="form-label">Influencer Image:</label></div>
                <div class="col-lg-9"><input type="file" name="image[]" class="form-control" accept="image/*" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3"><label class="form-label">Followers:</label></div>
                <div class="col-lg-9"><input type="text" name="followers[]" class="form-control" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3"><label class="form-label">Engagement Rate:</label></div>
                <div class="col-lg-9"><input type="text" name="engagement_rate[]" class="form-control" required></div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-3"><label class="form-label">About the Creator:</label></div>
                <div class="col-lg-9"><textarea name="description[]" rows="4" class="form-control" required></textarea></div>
            </div>
            <hr>
        </div>`;
            document.getElementById("influencer-wrapper").insertAdjacentHTML("beforeend", html);
        }
    </script>

</body>

</html>