<?php
session_start();
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

include("dbConn.php");

// ✅Edit Job post 
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Job ID.");
}

$job_id = $_GET['id'];

$sql = "SELECT * FROM job_posts WHERE id = $job_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
} else {
    die("Job not found.");
}

if (isset($_POST['update_job'])) {
    $job_id = $_POST['job_id'];
    $designation = trim($_POST['designation']);
    $required = trim($_POST['required']);
    $location = trim($_POST['location']);
    $role_description = trim($_POST['role_description']);
    $experience = trim($_POST['experience']);
    $skill = trim($_POST['skill']);
    $shift = trim($_POST['shift']);
    $pay = trim($_POST['pay']);
    $deadline = trim($_POST['deadline']);

    $stmt = $conn->prepare("UPDATE job_posts SET designation=?, required=?, location=?, role_description=?, experience=?, skill=?, shift=?, supplemental_pay=?, deadline=? WHERE id=?");

    $stmt->bind_param("sssssssssi", $designation, $required, $location, $role_description, $experience, $skill, $shift, $pay, $deadline, $job_id);

    if ($stmt->execute()) {
        echo "<script>alert('Job updated successfully.'); window.location.href='job-posts.php';</script>";
    } else {
        echo "<script>alert('Failed to update job.');</script>";
    }
    $stmt->close();
}
?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Edit Job Post | DG - Dashboard</title>
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
                                        <li class="breadcrumb-item active">Job Post</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <?php if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    } ?>

                    <!-- // This section renders the "Add Team Detail" button, which triggers a modal form. -->
                    <div class="alert alert-danger" role="alert">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">

                                    <div class="card-body">
                                        <form action="" method="POST" enctype="multipart/form-data" id="job-form">
                                            <div class="col-xxl-6">
                                                <div class="card-header">
                                                    <h1 class="card-title mb-0"><code>Edit Job Post Here</code></h1>
                                                </div><!-- end card header -->
                                                <div class="card-body">
                                                    <p class="text-muted">Hey, fill me up soon—your audience is waiting! <code>Fresh</code> insights, new stories, let their curiosity find its way. Here's the <code>job post </code>that is shaping perspectives, provide knowledge, and sparking new <code>ideas</code> behind the marketing & branding world.</p>
                                                    <input type="hidden" name="job_id" value="<?= $row['id'] ?>">
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="designation" class="form-label">Designation:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($row['designation']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="required" class="form-label">Number of Required:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="required" class="form-control" value="<?= htmlspecialchars($row['required']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="dateInput" class="form-label">Location:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <select class="form-control" data-choices data-choices-search-false name="location" id="location">
                                                                <option value="">-- Select Location --</option>
                                                                <option value="On-Site" <?= ($row['location'] == 'On-Site') ? 'selected' : '' ?>>On-Site</option>
                                                                <option value="Remote" <?= ($row['location'] == 'Remote') ? 'selected' : '' ?>>Remote</option>
                                                                <option value="Hybrid" <?= ($row['location'] == 'Hybrid') ? 'selected' : '' ?>>Hybrid</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="shift" class="form-label">Job Shift:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="shift" class="form-control" value="<?= htmlspecialchars($row['shift']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="pay" class="form-label">Supplemental Pay:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="pay" id="pay" class="form-control" rows="3"><?= htmlspecialchars($row['supplemental_pay']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="deadline" class="form-label">Job Deadline Date:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="date" name="deadline" class="form-control" id="deadline" value="<?= htmlspecialchars($row['deadline']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="role_description" class="form-label">About the Role:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="role_description" id="role_description" class="form-control" rows="3"><?= htmlspecialchars($row['role_description']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="experience" class="form-label">Work Experience:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="experience" id="experience" class="form-control" rows="3"><?= htmlspecialchars($row['experience']) ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header align-items-center d-flex">
                                                        <h4 class="card-title mb-0">Eligibility Criteria:</h4>
                                                    </div><!-- end card header -->
                                                    <div class="card-body">
                                                        <p class="text-muted">Enter candidate <code>job</code> Skill Requirements:.</p>
                                                        <textarea class="form-control" name="skill" id="skill" rows="8"><?= htmlspecialchars($row['skill']) ?></textarea>
                                                    </div>
                                                </div><!-- end card -->
                                            </div>

                                            <!-- end col -->

                                            <div class="text-end pb-2 mb-3 me-4">
                                                <button type="submit" name="update_job" class="btn btn-primary">Update Job</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                        </div>
                        <!-- end row -->
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
    <?php include('include/datatable-footer-js.php'); ?>
</body>

</html>