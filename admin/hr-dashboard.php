<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

// Check if user is HR Admin (role_id 3) or Super Admin (role_id 1)
if ($_SESSION['role_id'] != 3 && $_SESSION['role_id'] != 1) {
    header('Location: access-denied.php');
    exit;
}

include("dbConn.php");
?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>HR | DG - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
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

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Dashboard</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">HR Dashboard</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-xxl-5 col-md-5">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                             <a href="job-posts.php">
                                            <div class="avatar-sm float-end">
                                                <div class="avatar-title bg-primary-subtle text-primary fs-3xl rounded"><i class="ti ti-bow"></i></div>
                                            </div>
                                            <p class="fs-md text-uppercase text-muted mb-0">Total Job Post</p>

                                            <h4 class="my-4"> <?php
                                                $selQ = mysqli_query($conn, "SELECT * FROM `job_posts`");
                                                $rows = mysqli_num_rows($selQ);
                                                echo $rows;
                                                ?></h4>
                                                </a>
                                            <p class="text-success fs-sm mb-0"><i class="bi bi-arrow-up me-1"></i> In Current Date</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-sm-6">
                                     <div class="card">
                                        <?php
                                        $selQ = mysqli_query($conn, "SELECT * FROM `career_applications`");
                                        $rows = mysqli_num_rows($selQ);
                                        ?>
                                        <div class="card-body">
                                               <a href="career.php">
                                            <div class="avatar-sm float-end">
                                                <div class="avatar-title bg-warning-subtle text-warning fs-3xl rounded">
                                                    <i class="ti ti-building-store"></i>
                                                </div>
                                            </div>
                                            <p class="fs-md text-uppercase text-muted mb-0">Resume Received</p>

                                            <h4 class="my-4">
                                                <span class="counter-value" data-target="<?= $rows ?>"><?= $rows ?></span> res.
                                            </h4>
                                              </a>
                                            <p class="text-success fs-sm mb-0"><i class="bi bi-arrow-up me-1"></i> 13% Last Month</p>
                                        </div>

                                    </div>
                                </div><!--end col-->
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                               <a href="contact-enquiry.php">
                                            <div class="avatar-sm float-end">
                                                <div class="avatar-title bg-success-subtle text-success fs-3xl rounded"><i class="ti ti-users-group"></i></div>
                                            </div>
                                            <p class="fs-md text-uppercase text-muted mb-0">Total Enquiry</p>

                                            <?php
                                            $selQ = mysqli_query($conn, "SELECT * FROM `enquiries`");
                                            $totalEnquiries = mysqli_num_rows($selQ);
                                            ?>
                                            <h4 class="my-4">
                                                <span class="counter" data-target="<?= $totalEnquiries ?>">0</span>
                                            </h4>
                                             </a>
                                            <p class="text-danger fs-sm mb-0"><i class="bi bi-arrow-down me-1"></i> 07.26% Last Week</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-sm-6">
                                    <div class="card">
                                        <div class="card-body">
                                                  <a href="add-team-member.php">
                                            <div class="avatar-sm float-end">
                                                <div class="avatar-title bg-secondary-subtle text-secondary fs-3xl rounded"><i class="ti ti-box-seam"></i></div>
                                            </div>
                                            <p class="fs-md text-uppercase text-muted mb-0">Employees</p>

                                            <h4 class="my-4"> <?php
                                                $selQ = mysqli_query($conn, "SELECT * FROM `our_team`");
                                                $rows = mysqli_num_rows($selQ);
                                                echo $rows;
                                                ?></h4>
                                                  </a>
                                            <p class="text-success fs-sm mb-0"><i class="bi bi-arrow-up me-1"></i> In Current Date</p>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end row-->
                        </div>

                        <div class="col-xxl-7 col-md-7">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <h6 class="card-title flex-grow-1 mb-0">Hirings Required</h6>
                                            <div class="flex-shrink-0">
                                                <button type="button" class="btn btn-subtle-info btn-sm"><i class="bi bi-file-earmark-text me-1 align-baseline"></i> Generate Reports</button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="monthly_profit" data-colors='["--tb-primary", "--tb-info", "--tb-warning", "--tb-success"]' class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div><!--end col-->
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header d-flex align-items-center">
                                            <h6 class="card-title flex-grow-1 mb-0">No. Of Reporting Managers</h6>
                                            <div class="dropdown flex-shrink-0">
                                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <span class="text-muted fs-lg"><i class="ti ti-dots align-middle"></i></span>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Today</a>
                                                    <a class="dropdown-item" href="#">Last Week</a>
                                                    <a class="dropdown-item" href="#">Last Month</a>
                                                    <a class="dropdown-item" href="#">Current Year</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="column_stacked_chart" data-colors='["--tb-primary", "--tb-success"]' class="apex-charts" dir="ltr"></div>
                                        </div>
                                    </div><!--end col-->
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

    <!-- dashboard-ecommerce init js -->
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const counters = document.querySelectorAll('.counter');
            counters.forEach(counter => {
                const target = +counter.getAttribute('data-target');
                const speed = 200; // smaller = faster
                const updateCount = () => {
                    const current = +counter.innerText;
                    const increment = Math.ceil(target / speed);
                    if (current < target) {
                        counter.innerText = current + increment;
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        });
    </script>


</body>

</html>