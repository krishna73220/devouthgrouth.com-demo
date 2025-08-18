<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Contact | DG - Admin & Dashboard</title>
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
                                <h4 class="mb-sm-0">Dashboard</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Career With DG</li>
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
                                    <h5 class="card-title mb-0">Applicant Vault :-</h5>
                                </div>
                                <div class="card-body">
                                    <table id="scroll-vertical" class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr.No.</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Role Applying For</th>
                                                <th>Resume</th>
                                                <th>Date | Time</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                            <?php
                                            include("dbConn.php");

                                            $sql = "SELECT * FROM career_applications ORDER BY id DESC";
                                            $result = mysqli_query($conn, $sql);
                                            $sr = 1;

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $resumeLink = '/assets/formphp/uploaded/resumes/' . $row['resume_filename']; // adjust the path if needed
                                                echo "<tr>
                                               <td>{$sr}</td>
                                               <td>{$row['name']}</td>
                                               <td><a href='mailto:" . htmlspecialchars($row['email']) . "'>" . htmlspecialchars($row['email']) . "</a></td>
                                               <td>{$row['role_applying_for']}</td>
                                               <td>
                                              <div class='avatar-group'>
                                             <a href='{$resumeLink}' target='_blank' class='avatar-group-item' data-bs-toggle='tooltip' title='Download Resume'>
                                             <img src='assets/images/users/pdf_ic.png' width='45' height='45' alt='resume' class='avatar-xxs'>
                                              </a>
                                            </div>
                                             </td>
                                                <td>" . date('d M, Y H:i', strtotime($row['submitted_at'])) . "</td>
                                               <td>{$row['message']}</td>
                                              </tr>";
                                                $sr++;
                                            }
                                            ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
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