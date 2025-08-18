<?php
session_start();

if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SESSION['role_id'] != 2 && $_SESSION['role_id'] != 1) {
    header('Location: ../access-denied.php');
    exit;
}

include("../dbConn.php");

function calcGrowth($current, $last) {
    if ($last > 0) {
        return round((($current - $last) / $last) * 100, 2);
    }
    return 100;
}
// Current month blog count
$currentMonthQuery = "SELECT COUNT(*) AS total FROM blog_posts WHERE MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
$currentResult = $conn->query($currentMonthQuery);
$currentRow = $currentResult->fetch_assoc();
$currentTotal = (int)$currentRow['total'];
// Last month blog count
$lastMonthQuery = "SELECT COUNT(*) AS total FROM blog_posts WHERE MONTH(created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)";
$lastResult = $conn->query($lastMonthQuery);
$lastRow = $lastResult->fetch_assoc();
$lastTotal = (int)$lastRow['total'];

$growth = calcGrowth($currentTotal, $lastTotal);

$current_week_sql = "
    SELECT AVG(duration) AS avg_duration 
    FROM blog_visit_logs 
    WHERE YEARWEEK(visit_time, 1) = YEARWEEK(CURDATE(), 1)
";
$current_result = $conn->query($current_week_sql);
$current_avg = (float)($current_result->fetch_assoc()['avg_duration'] ?? 0);

$last_week_sql = "
    SELECT AVG(duration) AS avg_duration 
    FROM blog_visit_logs 
    WHERE YEARWEEK(visit_time, 1) = YEARWEEK(CURDATE(), 1) - 1
";
$last_result = $conn->query($last_week_sql);
$last_avg = (float)($last_result->fetch_assoc()['avg_duration'] ?? 0);

$percent_change = 0;
if ($last_avg > 0) {
    $percent_change = round((($current_avg - $last_avg) / $last_avg) * 100, 2);
}

$current_avg = round($current_avg, 2);

$change_class = $percent_change >= 0 ? 'text-success' : 'text-danger';
$arrow_icon = $percent_change >= 0 ? 'ri-arrow-right-up-line' : 'ri-arrow-right-down-line';
// Fetch total impressions from blog_posts table
$res = $conn->query("SELECT SUM(impressions) AS total FROM blog_posts");
$impressionsTotal = (int)($res->fetch_assoc()['total'] ?? 0);
$impressions = round($impressionsTotal / 1000, 1); // e.g. 2.4
$impressionsFormatted = $impressions . 'k';
?>



<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Blog | DG - Blog Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
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

                    <div class="row">
                        <div class="col-xl-8">
                            <div>
                                <div class="row gy-4">
                                    <div class="col-sm-4 border-end-sm">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Total Blogs</p>
                                            <h4 class="fw-semibold mb-3">
                                                <?= $currentTotal ?>
                                            </h4>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="<?= ($growth >= 0) ? 'text-success' : 'text-danger' ?> fs-xs mb-0">
                                                    <i class="ri-arrow-<?= ($growth >= 0) ? 'right-up' : 'down' ?>-line fs-sm align-middle"></i>
                                                    <?= number_format($growth, 2) ?>%
                                                </h5>
                                                <p class="text-muted mb-0">than last month</p>
                                            </div>
                                        </div><!-- end card -->

                                    </div>

                                    <div class="col-sm-4 border-end-sm">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Avg. Visit Duration</p>
                                            <h4 class="fw-semibold mb-3">
                                                <span class="counter-value" data-target="<?= $current_avg; ?>">0</span>s
                                            </h4>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="<?= $change_class; ?> fs-xs mb-0">
                                                    <i class="<?= $arrow_icon; ?> fs-sm align-middle"></i>
                                                    <?= ($percent_change >= 0 ? '+' : '') . $percent_change; ?>%
                                                </h5>
                                                <p class="text-muted mb-0">than last week</p>
                                            </div>
                                        </div><!-- end card -->
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="text-center">
                                            <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Impressions</p>
                                            <h4 class="fw-semibold mb-3">
                                                <span class="counter-value" data-target="<?= $impressions ?>"><?= $impressions ?></span>k
                                            </h4>
                                            <div class="d-flex align-items-center justify-content-center gap-2">
                                                <h5 class="<?= $change_class ?> fs-xs mb-0">
                                                    <i class="<?= $arrow_icon ?> fs-sm align-middle"></i> <?= abs($percent_change) ?> %
                                                </h5>
                                                <p class="text-muted mb-0">than last week</p>
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="mx-n4">
                                        <div id="performance_overview" data-colors='["--tb-primary", "--tb-warning"]' class="apex-charts" dir="ltr"></div>
                                    </div>
                                </div>

                            </div>
                        </div><!--end col-->
                        <div class="col-xl-4">
                            <div class="d-none d-xl-block">
                                <div class="card bg-success-subtle shadow-none rounded-0 border-0 dashboard-widgets-wrapper">
                                    <div class="card-body text-center mt-5 pt-5">
                                        <h5>Welcome <?php echo $_SESSION['user_name']; ?></h5>
                                        <p class="text-muted fs-md ">There are latest updates for the last 7 days, check now</p>
                                        <img src="../assets/images/dashboard.png" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>

                        </div><!--end col-->
                    </div><!--end row-->


                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?php include('../include/dashboard-footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('../include/blog-loader.php'); ?>
    <?php include('../include/blog-footer-js.php'); ?>
    <script src="../assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard-analytics.init.js"></script>

</body>

</html>