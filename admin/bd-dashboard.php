<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    // Redirect to the login page if not logged in
    header('Location: index.php');
    exit;
}

// Include the database connection file
include("dbConn.php");

// blog-dashboard.php
// if ($_SESSION['role'] != 'seo_admin' && $_SESSION['role'] != 'super_admin') {
//     echo "Access Denied!";
//     exit;
// }
?>



<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>BD | DG - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Devout Growth" name="author">
    <?php include('include/head.php'); ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?php include('include/left-sidebar.php'); ?>
        <!-- Left Sidebar End -->
        <?php include('include/top-header.php'); ?>
        <?php include('include/notification-model.php'); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-xl-8">
                            <div>
                                <div class="row gy-4">
                                    <div class="col-sm-4 border-end-sm">
                                        <?php
                                        $selQ = mysqli_query($conn, "SELECT * FROM `influence_model_enquiry_form`");
                                        $rows = mysqli_num_rows($selQ);
                                        ?>
                                        <div class="text-center">
                                            <a href="influencers-enquiry.php">
                                                <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Total Enquiry</p>
                                                <h4 class="fw-semibold mb-3"><span class="counter-value" data-target="<?= $rows ?>"><?= $rows ?></span> </h4>
                                            </a>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="text-success fs-xs mb-0">
                                                    <i class="ri-arrow-right-up-line fs-sm align-middle"></i>
                                                </h5>
                                                <p class="text-muted mb-0">In Current Date</p>
                                            </div>
                                        </div><!-- end card -->
                                    </div>
                                    <!-- <div class="col-sm-4 border-end-sm">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Avg. Visit Duration</p>
                                            <h4 class="fw-semibold mb-3"><span class="counter-value" data-target="1.57">0</span>s </h4>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="text-success fs-xs mb-0">
                                                    <i class="ri-arrow-right-up-line fs-sm align-middle"></i> +19.07 %
                                                </h5>
                                                <p class="text-muted mb-0">than last week</p>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="col-sm-4">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Impressions</p>
                                            <h4 class="fw-semibold mb-3"><span class="counter-value" data-target="2368">0</span>k </h4>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="text-success fs-xs mb-0">
                                                    <i class="ri-arrow-right-up-line fs-sm align-middle"></i> +19.07 %
                                                </h5>
                                                <p class="text-muted mb-0">than last week</p>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                                <div class="mt-4">
                                    <div class="mx-n4">
                                        <!-- <div id="performance_overview" data-colors='["--tb-primary", "--tb-warning"]' class="apex-charts" dir="ltr"></div> -->
                                    </div>
                                </div>

                            </div>
                        </div><!--end col-->
                        <div class="col-xl-4">
                            <div class="d-none d-xl-block">
                                <div class="card bg-success-subtle shadow-none rounded-0 border-0 dashboard-widgets-wrapper">
                                    <div class="card-body text-center mt-5 pt-5">
                                        <h5>Welcome to <?php echo $_SESSION['user_name']; ?></h5>
                                        <p class="text-muted fs-md ">Have a Nice Day! Let’s Start Connecting!</p>
                                        <img src="assets/images/dashboard.png" alt="Connecting" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?php include('include/dashboard-footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('include/preloader.php'); ?>
    <?php include('include/dashboard-footer-js.php'); ?>

</body>

</html>