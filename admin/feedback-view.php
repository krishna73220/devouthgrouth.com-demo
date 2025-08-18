<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Budget enquiry | DG - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="Digital marketing services,digital marketing company in India, top digital marketing agency in india, best digital marketing company in india">
    <meta name="description" content="Join hands with the best digital marketing company in India. Digital marketing services, performance marketing campaigns, and website development services.">
    <meta content="Devout Growth" name="author">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <?php include('include/head.php'); ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <!-- ========== App Menu ========== -->
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
                                <h4 class="mb-sm-0">Budget Enquiry Dashboard</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Budget Enquiry</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Query Record</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="buttons-datatables" class="display table table-bordered table-nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone No.</th>
                                                    <th>Whatsapp No.</th>
                                                    <th>Interest</th>
                                                    <th>Budget</th>
                                                    <th>Message</th>
                                                    <th>File</th>
                                                    <th>Date | Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include("dbConn.php");

                                                $sql = "SELECT * FROM feedback_form ORDER BY id DESC";
                                                $result = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($result) > 0) {
                                                    $serial = 1;
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $fileLink = '/assets/formphp/' . $row['uploaded_file']; // updated here

                                                        echo "<tr>";
                                                        echo "<td>" . $serial++ . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                        echo "<td><a href='mailto:" . htmlspecialchars($row['email']) . "'>" . htmlspecialchars($row['email']) . "</a></td>";
                                                        echo "<td>" . htmlspecialchars($row['phone1']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['phone2']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['interest']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['budget']) . "</td>";
                                                        echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                                                        echo "<td>
                                                     <div class='avatar-group'>
                                                     <a href='" . $fileLink . "' target='_blank' class='avatar-group-item' data-bs-toggle='tooltip' title='Document'>
                                                    <img src='assets/images/users/pdf_ic.png' width='45' height='45' alt='document' class='avatar-xxs'>
                                                         </a>
                                                          </div>
                                                        </td>";
                                                        echo "<td>" . date('d M, Y h:i A', strtotime($row['submitted_at'])) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                }
                                                ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->

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
    <?php include('include/datatable-footer-js.php'); ?>

</body>

</html>