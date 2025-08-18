<?php
session_start();
include("../dbConn.php"); // DB connection
require_once 'auth_check.php'; // check login session

// Generate CSRF Token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Fetch categories
$categories = $conn->query("SELECT category_id, category_name FROM blog_categories ORDER BY category_name ASC");
?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Add Blog | DG - Blog Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
    <meta content="Devout Growth" name="author">
    <!-- dropzone css -->
    <link rel="stylesheet" href="../assets/libs/dropzone/dropzone.css" type="text/css">
    <?php include('../include/blog-head.php'); ?>
    
     <style>
        .ck-content img {
  max-width: 100%!important;
  height: auto!important;
  display: block;
}

    </style>
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

                            <form action="save_post.php" method="POST" enctype="multipart/form-data" id="blog-form">
                                <div class="col-xxl-6">
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Add New Post</h4>
                                    </div><!-- end card header -->
                                    <div class="card-body">
                                        <p class="text-muted">Hey, fill me up soon—your audience is waiting! <code>Fresh</code> insights, new stories, let their curiosity find its way. Here's the <code>blog post </code>that is shaping perspectives, provide knowledge, and sparking new <code>ideas</code> behind the marketing & branding world.</p>

                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="title" class="form-label">Blog Title:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="title" required class="form-control" id="title" placeholder="Enter your Blog Title">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="slug" class="form-label">Slug (optional):</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="slug" class="form-control" id="slug" placeholder="Enter your url">
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
                                                        <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="author" class="form-label">Author:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <input type="text" name="author" required class="form-control" id="author" placeholder="Enter your Name">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="status" class="form-label">Status:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <select class="form-select" name="status" aria-label="Default select example">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="seo_description" class="form-label">Meta Description (SEO):</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <textarea name="seo_description" id="seo_description" class="form-control" rows="3" placeholder="Enter meta description for SEO"><?php echo isset($seo_description) ? $seo_description : ''; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-lg-3">
                                                <label for="short_desc" class="form-label">Short Description:</label>
                                            </div>
                                            <div class="col-lg-9">
                                                <textarea class="form-control" name="short_desc" required id="short_desc" rows="3" placeholder="Enter your Short Description"></textarea>
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
                                            <p class="text-muted">An image that provide the wholesome insight of blog.</p>
                                       
                                            <div class="dropzone" id="featured-image-dropzone">
                                                <div class="fallback">
                                                    <input type="file" class="form-control" name="image" id="image" accept="image/jpeg,image/png,image/webp" required>
                                                </div>
                                                <div class="dz-message needsclick">
                                                    <div class="mb-3">
                                                        <i class="display-4 text-muted ri-upload-cloud-2-fill"></i>
                                                    </div>
                                                    <h4>Drop files here or click to upload.</h4>
                                                </div>
                                            </div>

                                            <template id="dz-preview-template">
                                                <ul class="list-unstyled mb-0" id="dropzone-preview">

                                                    <li class="mt-2" id="dropzone-preview-list">
                                                        <div class="border rounded">
                                                            <div class="d-flex p-2">
                                                                <div class="flex-shrink-0 me-3">
                                                                    <div class="avatar-sm bg-light rounded">
                                                                        <img data-dz-thumbnail class="img-fluid rounded d-block" src="../assets/images/new-document.png" alt="blog-Image">
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1">
                                                                    <div class="pt-1">
                                                                        <h5 class="fs-md mb-1" data-dz-name>&nbsp;</h5>
                                                                        <p class="fs-sm text-muted mb-0" data-dz-size></p>
                                                                        <strong class="error text-danger" data-dz-errormessage></strong>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-shrink-0 ms-3">
                                                                    <button data-dz-remove class="btn btn-sm btn-danger">Delete</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </template>
                                            <!-- end dropzon-preview -->
                                        </div>
                                        <!-- end card body -->
                                    </div>
                                    <!-- end card -->
                                </div> <!-- end col -->

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0">Blog Description:</h4>
                                        </div><!-- end card header -->
                                        <div class="card-body">
                                            <p class="text-muted">Write the <code>compelling content</code> with strong opening that draws readers in.</p>

                                            <!-- ✅ Correct textarea for CKEditor -->
                                             <textarea class="form-control ckeditor-classi" name="description" id="description" rows="10"></textarea>
                                        </div><!-- end card-body -->
                                    </div><!-- end card -->
                                </div>

                                <!-- end col -->

                                <div class="text-end pb-2 mb-3 me-4">
                                    <button type="submit" class="btn btn-primary">Publish Post</button>
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
                this.on("error", function(file, errorMessage) {
                    console.error("File upload error:", errorMessage);
                });
            }
        });
    </script>


</body>

</html>