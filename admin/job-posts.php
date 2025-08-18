<?php
session_start();
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

include("dbConn.php");

// ADD JOB POST
if (isset($_POST['add_job'])) {
    $designation = trim($_POST['designation']);
    $required = trim($_POST['required']);
    $location = trim($_POST['location']);
    $role_description = trim($_POST['role_description']);
    $experience = trim($_POST['experience']);
    $skill = trim($_POST['skill']);
    $shift = trim($_POST['shift']);
    $pay = trim($_POST['pay']);
    $deadline = trim($_POST['deadline']); 
    $status = 1;

    if (empty($designation) || empty($required) || empty($location) || empty($deadline)) {
        echo "<script>alert('Please fill all required fields.'); window.history.back();</script>";
        exit;
    }

    // 👇 updated query:
    $stmt = $conn->prepare("INSERT INTO job_posts (designation, required, location, role_description, experience, skill, shift, supplemental_pay, deadline, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

    if ($stmt) {
        $stmt->bind_param("sssssssssi", $designation, $required, $location, $role_description, $experience, $skill, $shift, $pay, $deadline, $status);
        if ($stmt->execute()) {
            echo "<script>alert('Job posted successfully.'); window.location.href='job-posts.php';</script>";
        } else {
            echo "<script>alert('Something went wrong while saving.'); window.history.back();</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('SQL error: could not prepare statement.'); window.history.back();</script>";
    }
}

// DELETE JOB POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_team'])) {
    $id = (int) $_POST['team_id'];

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM job_posts WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Job Post deleted successfully.</div>";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Delete failed. Record may not exist.</div>";
        }

        $stmt->close();
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Invalid ID passed.</div>";
    }

    header("Location: job-posts.php");
    exit;
}

?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Job Post | DG - Dashboard</title>
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
                                                    <h4 class="card-title mb-0">Add New Job Post Here</h4>
                                                </div><!-- end card header -->
                                                <div class="card-body">
                                                    <p class="text-muted">Hey, fill me up soon—your audience is waiting! <code>Fresh</code> insights, new stories, let their curiosity find its way. Here's the <code>job post </code>that is shaping perspectives, provide knowledge, and sparking new <code>ideas</code> behind the marketing & branding world.</p>
                                                    <input type="hidden" name="team_id" value="<?= $job['id'] ?>">
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="designation" class="form-label">Designation:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="designation" required class="form-control" id="designation" placeholder="Enter candidate designation" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="required" class="form-label">Number of Required:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="number" name="required" class="form-control" id="required" placeholder="No. of required" min="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="dateInput" class="form-label">Location:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <select class="form-control" data-choices data-choices-search-false name="location" id="location">
                                                                <option value="">-- Select Location --</option>
                                                                <option value="On-Site">On-Site</option>
                                                                <option value="Remote">Remote</option>
                                                                <option value="Hybrid">Hybrid</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="shift" class="form-label">Job Shift:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="text" name="shift" class="form-control" id="shift" placeholder="Shift">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="pay" class="form-label">Supplemental Pay:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="pay" id="pay" class="form-control" rows="3" placeholder="Supplemental pay description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="deadline" class="form-label">Job Deadline Date:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <input type="date" name="deadline" class="form-control" id="deadline" required>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="role_description" class="form-label">About the Role:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="role_description" id="role_description" class="form-control" rows="5" placeholder="Enter job role description"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-3">
                                                            <label for="experience" class="form-label">Work Experience:</label>
                                                        </div>
                                                        <div class="col-lg-9">
                                                            <textarea name="experience" id="experience" class="form-control" rows="3" placeholder="Work Experience"></textarea>
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
                                                        <textarea class="form-control" name="skill" id="skill" rows="10" required></textarea>
                                                    </div>
                                                </div><!-- end card -->
                                            </div>

                                            <!-- end col -->

                                            <div class="text-end pb-2 mb-3 me-4">
                                                <button type="submit" name="add_job" class="btn btn-primary">Submit Now</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                        </div>
                        <!-- end row -->
                    </div>


                    <!-- Employee Details display in table formate -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Our Employee Details</h5>
                                </div>
                                <div class="card-body">

                                    <?php
                                    $result = mysqli_query($conn, "SELECT * FROM job_posts ORDER BY created_at DESC");
                                    ?>

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Designation</th>
                                                <th>Location</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Toggle</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $count = 1;
                                            while ($row = mysqli_fetch_assoc($result)): ?>
                                                <tr>
                                                    <td><?= $count++ ?></td>
                                                    <td><?= $row['designation'] ?></td>
                                                    <td><?= $row['location'] ?></td>
                                                    <td><?= date("d-m-Y", strtotime($row['created_at'])) ?></td>
                                                    <td>
                                                        <span class="badge <?= $row['status'] == 1 ? 'bg-success' : 'bg-danger' ?>">
                                                            <?= $row['status'] == 1 ? 'Active' : 'Inactive' ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input toggle-status"
                                                                type="checkbox"
                                                                role="switch"
                                                                data-user-id="<?= $row['id'] ?>"
                                                                <?= $row['status'] == 1 ? 'checked' : '' ?>>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="edit-job.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Edit</a>

                                                        <button class="btn btn-sm btn-danger btn-delete remove-item-btn"
                                                            data-id="<?= $row['id']; ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                        </div><!--end col-->
                    </div><!--end row-->

                    <!-- Modal for Deleting Team Member (script file niche hai*)-->
                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                </div>
                                <form action="job-posts.php" method="POST" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="mt-2 text-center">
                                            <i class="bi bi-trash3 display-5 text-danger"></i>
                                            <div class="mt-4 pt-2 fs-base mx-4 mx-sm-5">
                                                <h4>Are you Sure?</h4>
                                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this record?</p>
                                                <input type="hidden" name="team_id" id="delete-team-id" value="">
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="delete_team" class="btn w-sm btn-danger">Yes, Delete It!</button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>

                    <!-- End Modal -->

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

    <script>
        // Here we use delet functionality using model 
        document.addEventListener('DOMContentLoaded', function() {
            var deleteButtons = document.querySelectorAll('.remove-item-btn');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var teamId = this.getAttribute('data-id');
                    document.getElementById('delete-team-id').value = teamId;
                });
            });
        });


        // here tstatus toggle area 
        $(document).on('change', '.toggle-status', function() {
            var userId = $(this).data('user-id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: 'update_job_status.php',
                type: 'POST',
                data: {
                    user_id: userId,
                    status: status
                },
                success: function(response) {
                    alert(response); // success message
                },
                error: function() {
                    alert('Error updating status');
                }
            });
        });
    </script>
</body>

</html>