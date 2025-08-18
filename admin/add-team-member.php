<?php
session_start();
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}
include("dbConn.php");

$target_dir = "team_uploads/";
$allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
$max_size = 2 * 1024 * 1024; // 2MB

// ADD TEAM MEMBER
if (isset($_POST['btn_team'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $department_id = (int)$_POST['department_id'];

    $file_name = time() . '_' . uniqid() . '_' . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $file_name;
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false && in_array($file_ext, $allowed_ext) && $_FILES["image"]["size"] <= $max_size) {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO our_team (name, designation, department_id, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $name, $designation, $department_id, $target_file);
            $stmt->execute();
            $_SESSION['msg'] = "<div class='alert alert-success'>Team member added successfully!</div>";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Invalid image type, size, or file format.</div>";
    }

    header("Location: add-team-member.php");
    exit;
}


// DELETE TEAM MEMBER
if (isset($_POST['delete_team'])) {
    $id = (int)$_POST['team_id'];  
    $stmt = $conn->prepare("SELECT image FROM our_team WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $get = $result->fetch_assoc();

    if ($get && file_exists($get['image'])) unlink($get['image']);

    // Record delete 
    $del_stmt = $conn->prepare("DELETE FROM our_team WHERE id = ?");
    $del_stmt->bind_param("i", $id);
    $del_stmt->execute();

    $_SESSION['msg'] = "<div class='alert alert-success'>Team member deleted successfully.</div>";
    header("Location: add-team-member.php");
    exit;
}

// UPDATE TEAM MEMBER
if (isset($_POST['update_team'])) {
    $id = (int)$_POST['team_id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $designation = mysqli_real_escape_string($conn, $_POST['designation']);
    $department_id = (int)$_POST['department_id'];

    if (!empty($_FILES["image"]["name"])) {
        $file_name = time() . '_' . uniqid() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $file_name;
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false && in_array($file_ext, $allowed_ext) && $_FILES["image"]["size"] <= $max_size) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                // Delete old image
                $stmt = $conn->prepare("SELECT image FROM our_team WHERE id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $old_image = $result->fetch_assoc()['image'];
                if (file_exists($old_image)) unlink($old_image);

                // ✅ Update with new image
                $update_stmt = $conn->prepare("UPDATE our_team SET name=?, designation=?, department_id=?, image=? WHERE id=?");
                $update_stmt->bind_param("ssisi", $name, $designation, $department_id, $target_file, $id);
                $update_stmt->execute();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-danger'>Error uploading image. Please try again.</div>";
                header("Location: add-team-member.php");
                exit;
            }
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Invalid image type, size, or file format.</div>";
            header("Location: add-team-member.php");
            exit;
        }
    } else {
        // ✅ Update without changing image
        $update_stmt = $conn->prepare("UPDATE our_team SET name=?, designation=?, department_id=? WHERE id=?");
        $update_stmt->bind_param("ssii", $name, $designation, $department_id, $id);
        $update_stmt->execute();
    }

    $_SESSION['msg'] = "<div class='alert alert-success'>Team member updated successfully.</div>";
    header("Location: add-team-member.php");
    exit;
}

?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Add Team Members | DG - Admin & Dashboard</title>
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
                                <h4 class="mb-sm-0">Employees Dashboard</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Our Team</li>
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
                                    <div class="card-header">
                                        <h4 class="card-title mb-0">Add New Team Members Here</h4>
                                    </div>

                                    <div class="card-body">
                                        <div id="customerList">
                                            <div class="row g-4 mb-3">
                                                <div class="col-sm-auto">
                                                    <div>
                                                        <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn" data-bs-target="#showModal"><i class="ri-add-line align-bottom me-1"></i> Add</button>
                                                        <button class="btn btn-subtle-danger" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-sm">
                                                    <div class="d-flex justify-content-sm-end">
                                                        <div class="search-box ms-2">
                                                            <input type="text" class="form-control search" placeholder="Search...">
                                                            <i class="ri-search-line search-icon"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
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

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered table-responsive" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SR No.</th>
                                                <th>Employee Name</th>
                                                <th>Designation</th>
                                                <th>Department</th>
                                                <th>Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            // Fetch employees from the database
                                            $sr = 1;
                                            $selq = mysqli_query($conn, "
                                           SELECT t.*, d.name AS department_name 
                                          FROM our_team t 
                                          LEFT JOIN departments d ON t.department_id = d.id 
                                          ORDER BY t.id DESC
                                         ");

                                            while ($restt = mysqli_fetch_assoc($selq)) { ?>
                                                <tr>
                                                    <td><?php echo $sr++; ?></td>
                                                    <td><?php echo htmlspecialchars($restt['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($restt['designation']); ?></td>
                                                    <td><?php echo htmlspecialchars($restt['department_name']); ?></td>
                                                    <td>
                                                        <img src="<?php echo $restt['image']; ?>" width="40" height="40" alt="<?php echo htmlspecialchars($restt['name']); ?>" class="rounded-circle">
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success edit-item-btn"
                                                            data-id="<?= $restt['id']; ?>"
                                                            data-name="<?= htmlspecialchars($restt['name']); ?>"
                                                            data-designation="<?= htmlspecialchars($restt['designation']); ?>"
                                                            data-department-id="<?= $restt['department_id']; ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateModal">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-sm btn-danger btn-delete remove-item-btn"
                                                            data-id="<?= $restt['id']; ?>"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deleteRecordModal">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->

                    <!-- Modal for Adding Team Member -->
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Team Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="close-modal"></button>
                                </div>
                                <form method="POST" enctype="multipart/form-data" class="tablelist-form">
                                    <div class="modal-body">

                                        <div class="mb-3" id="modal-id" style="display: none;">
                                            <label for="id-field" class="form-label">ID</label>
                                            <input type="text" id="id-field" class="form-control" placeholder="ID" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Employee Name:</label>
                                            <input type="text" name="name" id="customername-field" class="form-control" placeholder="Enter Name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email-field" class="form-label">Designation:</label>
                                            <input type="text" name="designation" id="email-field" class="form-control" placeholder="Enter Designation" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="date-field" class="form-label">Employee Image:</label>
                                            <input type="file" name="image" id="date-field" class="form-control" required>
                                        </div>

                                        <div>
                                            <label for="status-field" class="form-label">Department:</label>
                                            <select class="form-control" name="department_id" id="status-field" required>
                                                <option value="">Select Department</option>
                                                <?php
                                                $dept_res = mysqli_query($conn, "SELECT * FROM departments ORDER BY name ASC");
                                                while ($dept = mysqli_fetch_assoc($dept_res)) {
                                                    echo "<option value='{$dept['id']}'>{$dept['name']}</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name="btn_team" class="btn btn-success" id="add-btn">Add Employee</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Edit Team Member -->
                    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateTeamMemberModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="updateTeamMemberModalLabel">Update Team Member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="team_id" id="team_id">
                                        <div class="mb-3">
                                            <label for="update_name" class="form-label">Employee Name:</label>
                                            <input type="text" name="name" class="form-control" id="update_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="update_designation" class="form-label">Designation:</label>
                                            <input type="text" name="designation" class="form-control" id="update_designation" required>
                                        </div>
                                        <div class="mb-3">
                                            <select name="department_id" id="update_department" class="form-control" required>
                                                <option value="">Select Department</option>
                                                <?php
                                                $dept_q = $conn->query("SELECT id, name FROM departments");
                                                while ($dept = $dept_q->fetch_assoc()) {
                                                    echo "<option value='{$dept['id']}'>{$dept['name']}</option>";
                                                }
                                                ?>
                                            </select>

                                        </div>

                                        <div class="mb-3">
                                            <label for="update_image" class="form-label">Image (Leave blank to keep current image)</label>
                                            <input type="file" name="image" class="form-control" id="update_image" accept="image/*">
                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" name="update_team" class="btn btn-success">Update Team Member</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Deleting Team Member (script file niche hai*)-->
                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                </div>
                                <form method="POST" enctype="multipart/form-data">
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
        // Edit team member modal
        $(document).on('click', '.edit-item-btn', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const designation = $(this).data('designation');
            const departmentId = $(this).data('department-id');

            $('#team_id').val(id);
            $('#update_name').val(name);
            $('#update_designation').val(designation);
            $('#update_department').val(departmentId);

            // Optional: In case modal doesn't open reliably
            $('#updateModal').modal('show');
        });


        // Here we use delet functionality using model 
        document.addEventListener('DOMContentLoaded', function() {
            var removeButtons = document.querySelectorAll('.remove-item-btn');
            removeButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var teamId = this.getAttribute('data-id');
                    document.getElementById('delete-team-id').value = teamId;
                });
            });
        });
    </script>

</body>

</html>