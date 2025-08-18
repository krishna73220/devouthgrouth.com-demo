<?php
session_start();
include("../dbConn.php");

if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 1) {
    header('Location: ../access-denied.php');
    exit;
}

?>

<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Add Blog faq | DG - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
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
                                        <li class="breadcrumb-item active">FAQs</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="card">
                            <div class="col-md-10 col-lg-10 mt-5">
                                <?php
                                $id = $_GET['id']; // Get FAQ ID from URL
                                $result = mysqli_query($conn, "SELECT * FROM blog_post_faqs WHERE id = $id");
                                $faq = mysqli_fetch_assoc($result);
                                $post_id = $faq['post_id'];

                                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                    $question = trim($_POST['question']);
                                    $answer = trim($_POST['answer']);

                                    // Update FAQ
                                    mysqli_query($conn, "UPDATE blog_post_faqs SET question='$question', answer='$answer' WHERE id=$id");

                                    // Get slug from post_id
                                    $slug_result = mysqli_query($conn, "SELECT slug FROM blog_posts WHERE post_id = $post_id");
                                    $slug_row = mysqli_fetch_assoc($slug_result);
                                    $slug = $slug_row['slug'];

                                    echo "<script>
                                    alert('FAQ updated successfully');
                                   window.location.href = 'blog_faq.php?slug=$slug';
                                   </script>";
                                    exit;
                                }
                                ?>

                                <div class="col-md-4 text-center mb-3">
                                    <marquee behavior="" scrollamount="10" onmouseover="stop()" onmouseout="start()" direction="left">
                                        <h3 class=" text-danger"><strong>Edit FAQs Here</strong></h3>
                                    </marquee>
                                </div>
                                <form method="POST">
                                    <div class="mb-3">
                                        <label>Question</label>
                                        <input type="text" name="question" class="form-control" value="<?= htmlspecialchars($faq['question']) ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>Answer</label>
                                        <textarea name="answer" class="form-control" rows="5" required><?= htmlspecialchars($faq['answer']) ?></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success mb-5">Update FAQ</button>
                                </form>


                            </div>
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

</body>

</html>