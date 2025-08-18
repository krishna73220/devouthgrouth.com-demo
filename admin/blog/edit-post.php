<?php
session_start();
include("../dbConn.php");
require_once 'auth_check.php';

// CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch categories
$categories = $conn->query("SELECT category_id, category_name FROM blog_categories ORDER BY category_name ASC");

// Get blog slug
if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // Fetch post by slug
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Post not found.");
    }

    $row = $result->fetch_assoc();
} else {
    die("Invalid request.");
}

// Function to generate slug from title
function generateSlug($title)
{
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("CSRF token mismatch!");
    }

    $title        = $_POST['title'];
    $author       = $_POST['author'];
    $category_id  = $_POST['category_id'];
    $status       = $_POST['status'];
    $seo_description = trim($_POST['seo_description']);
    $short_desc   = $_POST['short_desc'];
    $description  = $_POST['description'];
    $new_slug     = $_POST['slug'] ?? generateSlug($title);
    $old_slug     = $row['slug'];
    $post_id      = $row['post_id'];

    // Check for slug duplication excluding current post
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE slug = ? AND post_id != ?");
    $stmt->bind_param("si", $new_slug, $post_id);
    $stmt->execute();
    $checkSlug = $stmt->get_result();

    if ($checkSlug->num_rows > 0) {
        echo "<script>alert('Slug already exists. Please choose another one.');</script>";
    } else {
        // Keep existing image by default
        $image_name = $row['featured_image'];

        if (!empty($_FILES['image']['name'])) {
            $target_dir = "uploaded_blog_images/";
            $uploaded_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $uploaded_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $allowed_types = ['jpg', 'jpeg', 'png', 'webp'];

            if (in_array($imageFileType, $allowed_types)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    $image_name = $target_dir . $uploaded_name; 
                } else {
                    echo "<script>alert('Image upload failed. Old image retained.');</script>";
                }
            } else {
                echo "<script>alert('Invalid image format. Allowed: JPG, JPEG, PNG, WEBP.');</script>";
            }
        }

        // Conditional update query
        if (!empty($_FILES['image']['name']) && file_exists($target_file)) {
            $update = $conn->prepare("UPDATE blog_posts SET title = ?, author = ?, category_id = ?, status = ?, short_desc = ?, description = ?, seo_description = ?, slug = ?, featured_image = ? WHERE slug = ?");
            $update->bind_param("ssisssssss", $title, $author, $category_id, $status, $short_desc, $description, $seo_description, $new_slug, $image_name, $old_slug);
        } else {
            $update = $conn->prepare("UPDATE blog_posts SET title = ?, author = ?, category_id = ?, status = ?, short_desc = ?, description = ?, seo_description = ?, slug = ? WHERE slug = ?");
            $update->bind_param("ssissssss", $title, $author, $category_id, $status, $short_desc, $description, $seo_description, $new_slug, $old_slug);
        }

        if ($update->execute()) {
            echo "<script>alert('Post updated successfully!'); window.location.href='list_posts.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to update post.');</script>";
        }
    }
}
?>



<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Edit Blog | DG - Blog Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services" name="description">
    <meta content="Devout Growth" name="author">
    <!-- dropzone css -->
    <link rel="stylesheet" href="../assets/libs/dropzone/dropzone.css" type="text/css">
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
                                        <li class="breadcrumb-item active">Blogs</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="card">

                            <form method="POST" action="" enctype="multipart/form-data" id="blog-form">
                                <div class="col-xxl-6">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Edit This Post</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <p class="text-muted">Create horizontal forms with the grid by adding the <code>row</code> class to form groups and using the <code>col-*-*</code> class to specify the width of your labels and controls. Be sure to add <code>col-form-label</code> class to your <code>&lt;label&gt;</code>s as well so they’re vertically centered with their associated form controls.</p>

                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="title" class="form-label">Blog Title:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="title" class="form-control" id="title" value="<?= htmlspecialchars($row['title']) ?>" placeholder="Enter your Blog Title">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="slug" class="form-label">Slug (optional):</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="slug" class="form-control" id="slug" value="<?php echo $row['slug']; ?>" placeholder="Enter your url">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="dateInput" class="form-label">Category:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select class="form-control" data-choices data-choices-search-false name="category_id" id="category_id">
                                                    <option value="">-- Select Category --</option>
                                                    <?php while ($cat = $categories->fetch_assoc()) { ?>
                                                        <option value="<?= $cat['category_id'] ?>" <?= ($cat['category_id'] == $row['category_id']) ? 'selected' : '' ?>>
                                                            <?= htmlspecialchars($cat['category_name']) ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="author" class="form-label">Author:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="author" required class="form-control" id="author" value="<?= htmlspecialchars($row['author']) ?>" placeholder="Enter your Name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="status" class="form-label">Status:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select class="form-select" name="status" aria-label="Default select example">
                                                    <option value="1" <?= ($row['status'] == 1) ? 'selected' : '' ?>>Active</option>
                                                    <option value="0" <?= ($row['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="seo_description" class="form-label">Meta Description (SEO):</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <textarea name="seo_description" id="seo_description" class="form-control" rows="3" placeholder="Enter meta description for SEO"><?php echo htmlspecialchars($row['seo_description']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="short_desc" class="form-label">Short Description:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="short_desc" rows="4" cols="50" required><?= htmlspecialchars($row['short_desc']) ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4 class="card-title mb-0">Featured Image:</h4>
                                        </div><!-- end card header -->

                                        <div class="card-body">
                                            <p class="text-muted">Your Current Image is:</p>
                                            <?php
                                            $imagePath = './uploaded_blog_images/' . $row['featured_image'];
                                    
                                            if (!empty($row['featured_image']) && file_exists($imagePath)): ?>
                                                <div class="mb-3">
                                                    <img src="<?= $imagePath ?>" alt="Current Post Image" class="img-fluid" style="max-height: 200px; display:">
                                                </div>
                                            <?php else: ?>
                                                <p>No image uploaded yet.</p>
                                            <?php endif; ?>

                                            <div class="dropzone" id="featured-image-dropzone">
                                                <div class="fallback">
                                                    <input type="hidden" id="slug" value="<?php echo $slug; ?>">
                                                    <input type="file" class="form-control" name="image" id="image" accept="image/jpeg,image/png,image/webp">
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    </div>
                                                    <h4>Drop files here or click to upload a new image.</h4>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div>


                                    <!-- end card -->
                                </div> <!-- end col -->

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0">Blog Description:</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <p class="text-muted">Use <code>ckeditor-classic</code> class to set ckeditor classic editor.</p>

                                            <!-- ✅ Correct textarea for CKEditor -->
                                            <textarea class="form-control ckeditor-classi" name="description" id="description" rows="10" cols="70" required><?= htmlspecialchars($row['description']) ?></textarea>

                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div>

                                <!-- end col -->

                                <div class="text-end pb-2 mb-3 me-4">
                                    <button type="submit" class="btn btn-primary">Update Post</button>
                                </div>
                            </form>
                        </div>
                        <!-- end row -->
                    </div>

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <?php include('../include/dashboard-footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('../include/blog-loader.php'); ?>
    <?php include('../include/blog-footer-js.php'); ?>


    <!-- ckeditor -->
    <script src="../assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <!-- init js -->
    <script src="../assets/js/pages/form-editor.init.js"></script>
     <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                ckfinder: {
                    uploadUrl: 'https://www.devoutgrowth.com/admin/blog/upload.php'
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <!-- dropzone min -->
    <script src="../assets/libs/dropzone/dropzone-min.js"></script>

    <script src="../assets/js/pages/form-file-upload.init.js"></script>

<script>
        Dropzone.autoDiscover = false;

        const previewTemplate = document.querySelector("#dz-preview-template").innerHTML;

        const dropzone = new Dropzone("#featured-image-dropzone", {
            url: "save_post.php",
            method: "POST",
            previewTemplate: previewTemplate,
            previewsContainer: "#dropzone-preview",
            paramName: "image",
            maxFilesize: 4, // MB
            acceptedFiles: "image/jpeg,image/png,image/webp",
            dictDefaultMessage: "Drop files here or click to upload.",
            init: function() {
                this.on("sending", function(file, xhr, formData) {
                    const slug = document.querySelector("#slug").value; // 👈 slug get
                    formData.append("slug", slug); 
                });

                this.on("error", function(file, errorMessage) {
                    console.error("File upload error:", errorMessage);
                });
            }
        });

    </script>


</body>

</html>