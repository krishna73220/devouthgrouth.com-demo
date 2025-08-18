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

if (isset($_GET['slug'])) {
    $slug = $_GET['slug'];

    // Fetch the post ID using the slug
    $stmt = $conn->prepare("SELECT post_id, title FROM blog_posts WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        echo "Invalid blog slug.";
        exit;
    }

    $post_id = $post['post_id'];
    $post_title = $post['title'];
} else {
    echo "No blog slug provided.";
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Add FAQ here</h4>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                        <form method="POST" action="save-faq.php">
                                            <div id="faq-container">
                                                <div class="faq-group">
                                                    <div class="row g-2 align-items-center">
                                                        <input type="hidden" name="post_id" value="<?= intval($post_id) ?>">

                                                        <div class="col-lg-5">
                                                            <input type="text" name="question[]" class="form-control" placeholder="Question ?.." required>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <textarea name="answer[]" class="form-control" rows="3" placeholder="Faq Answer" required></textarea>
                                                        </div>

                                                        <div class="col-lg-2 ms-xl-auto">
                                                            <button class="btn btn-danger btn-sm createTask remove-faq" type="button">
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mt-5 text-center d-flex justify-content-center align-items-center">
                                                <div style="margin: 0 5px 0 0;">
                                                    <button class="btn btn-success btn-sm" type="button" id="add-faq">
                                                        <i class="ri-add-fill align-bottom"></i> Add More FAQ
                                                    </button>
                                                </div>
                                                <div>
                                                    <button class="btn btn-primary" type="submit">
                                                        Submit Now
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div><!--end row-->

                    <div class="row">
                        <div class="card">
                            <div class="col-md-10 col-lg-12 mt-5">
                                <?php
                                $get_faqs = mysqli_query($conn, "SELECT * FROM blog_post_faqs WHERE post_id = $post_id ORDER BY id ASC");
                                if (mysqli_num_rows($get_faqs) > 0) {
                                    echo '<h4 class="mt-4">Existing FAQs</h4>';
                                    echo '<table class="table table-bordered">';
                                    echo '<thead><tr><th>Question</th><th>Answer</th><th>Actions</th></tr></thead><tbody>';
                                    while ($faq = mysqli_fetch_assoc($get_faqs)) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($faq['question']) . '</td>';
                                        echo '<td>' . htmlspecialchars($faq['answer']) . '</td>';
                                        echo '<td class="d-flex">
                                     <a href="edit-faq.php?id=' . $faq['id'] . '" class="btn btn-sm btn-primary g-5">Edit</a>
                                    <a href="delete-faq.php?id=' . $faq['id'] . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                                       </td>';
                                        echo '</tr>';
                                    }
                                    echo '</tbody></table>';
                                }
                                ?>

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

    <script>
        document.getElementById('add-faq').onclick = function() {
            const container = document.getElementById('faq-container');
            const faqGroup = document.createElement('div');
            faqGroup.className = 'faq-group';
            faqGroup.innerHTML = `
            <div class="row g-2 align-items-center mt-3">
                <div class="col-lg-5">
                    <input type="text" name="question[]" class="form-control" placeholder="Question" required>
                </div>
                <div class="col-lg-5">
                    <textarea name="answer[]" class="form-control" placeholder="Answer" rows="3" required></textarea>
                </div>
                <div class="col-lg-2 ms-xl-auto">
                    <button type="button" class="remove-faq btn btn-sm btn-danger createTask">Remove</button>
                </div>
            </div>
        `;
            container.appendChild(faqGroup);
        };

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-faq')) {
                const group = e.target.closest('.faq-group');
                if (group) group.remove();
            }
        });
    </script>


</body>

</html>