<?php
include("dbConn.php");
session_start();

// Check if user is logged in
if (!isset($_SESSION['is_loggedIn']) || $_SESSION['is_loggedIn'] !== true) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $role_id = (int)$_POST['role_id'];
    $status = (int)$_POST['status'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); history.back();</script>";
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Handle image upload
    $imageName = null;
    if (!empty($_FILES['profile_image']['name'])) {
        $uploadDir = 'upload_user_image/';
        $imageName = time() . '_' . basename($_FILES['profile_image']['name']);
        $uploadPath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $uploadPath);
    }

    // Insert user into the users table
    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, role_id, status, password, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssisss", $fullname, $email, $phone, $role_id, $status, $hashed_password, $imageName);

    if ($stmt->execute()) {
        echo "<script>alert('User created successfully'); window.location.href='create-user.php';</script>";
    } else {
        echo "<script>alert('Error creating user'); history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>


<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Create Profile User | DG - Admin & Dashboard</title>
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
                                <h4 class="mb-sm-0">User Profile</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                        <li class="breadcrumb-item active">Profile</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="card">
                        <div class="profile-foreground position-relative">
                            <div class="profile-wid-bg position-static">
                                <img src="assets/images/small/img-2.jpg" alt="digital marketing" class="profile-wid-img card-img-top">
                                <div>
                                    <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input d-none">
                                    <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light btn-sm position-absolute end-0 top-0 m-3 z-1">
                                        <i class="ri-image-edit-line align-bottom me-1"></i> Edit Cover Images
                                    </label>
                                </div>
                            </div>
                            <div class="bg-overlay bg-primary bg-opacity-75 card-img-top"></div>
                        </div>

                        <div class="card-body mt-n5">
                            <div class="position-relative mt-n3">
                                <div class="avatar-lg position-relative">
                                    <img src="assets/images/users/avatar-4.jpg" alt="user-img" class="img-thumbnail rounded-circle user-profile-image" style="z-index: 1;">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute end-0 bottom-0">
                                        <input id="profile-img-file-input" type="file" class="profile-img-file-input d-none">
                                        <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="bi bi-camera"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="mt-3">
                                    <h3 class="fs-xl mb-1"><?php echo $_SESSION['user_name']; ?></h3>
                                    <p class="fs-md text-muted mb-0">Owner & Founder</p>
                                </div>

                                <div class="">
                                    <a href="pages-profile-settings.html" class="btn btn-primary"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-3">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4 pb-2">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Complete Your Profile</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="badge bg-light text-secondary"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                                        </div>
                                    </div>
                                    <div class="progress animated-progress custom-progress progress-label">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                            <div class="label">30%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-4">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title mb-0">Portfolio</h5>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <a href="javascript:void(0);" class="badge bg-info-subtle text-info fs-12"><i class="ri-add-fill align-bottom me-1"></i> Add</a>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle bg-dark-subtle text-body">
                                                <i class="bi bi-github"></i>
                                            </span>
                                        </div>
                                        <input type="email" class="form-control" id="gitUsername" placeholder="Username" value="dgdigital-tech">
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                <i class="bi bi-facebook"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="websiteInput" placeholder="www.example.com" value="devoutgrowth">
                                    </div>
                                    <div class="mb-3 d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle bg-success-subtle text-success">
                                                <i class="bi bi-dribbble"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="dribbleName" placeholder="Username" value="Devoutgrowth/">
                                    </div>
                                    <div class="d-flex">
                                        <div class="avatar-xs d-block flex-shrink-0 me-3">
                                            <span class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                                <i class="bi bi-instagram"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" id="pinterestName" placeholder="Username" value="devoutgrowth">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                        <div class="col-xl-9">
                            <div class="card">
                                <div class="card-body">
                                    <ul class="nav nav-pills nav-custom-outline nav-info gap-2 flex-grow-1 mb-0" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link fs-md active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                                                Personal Details
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link fs-md" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false" tabindex="-1">
                                                User History
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card">
                                <div class="tab-content">

                                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                        <div class="card-header">
                                            <h6 class="card-title mb-0">Personal Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <form action="" method="POST" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="fullname" class="form-label">Full Name</label>
                                                            <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Enter your fullname" value="Richard">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label fs-md">Phone Number</label>
                                                            <input type="text" name="phone" class="form-control fs-md" id="phone" placeholder="Enter your phone number" value="617 219 6245">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label fs-md">Email Address</label>
                                                            <input type="email" name="email" class="form-control fs-md" id="email" placeholder="Enter your email" value="alexandramarshall@steex.com">
                                                        </div>
                                                    </div>
                                                    <!--end col-->

                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="role_id" class="form-label fs-md">Role</label>
                                                            <select class="form-control" data-choices data-choices-search-false name="role_id" id="role_id">
                                                                <option value="">Select Role</option>
                                                                <!-- <option value="super_admin">Super Admin</option> -->
                                                                <?php
                                                                // Fetch roles from the database to populate the select options
                                                                include("dbConn.php");
                                                                $result = $conn->query("SELECT id, role_name FROM roles");
                                                                while ($row = $result->fetch_assoc()) {
                                                                    echo "<option value='" . $row['id'] . "'>" . $row['role_name'] . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label fs-md">Status</label>
                                                            <select class="form-control" data-choices data-choices-search-false name="status" id="status">
                                                                <option value="">Select status</option>
                                                                <option value="1">Active</option>
                                                                <option value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <label for="profile_image" class="form-label fs-md">Profile Image</label>
                                                            <input type="file" class="form-control fs-md" id="profile_image" name="profile_image" accept="image/*" placeholder="profile">
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <div class="auth-pass-inputgroup">
                                                                <label for="password" class="form-label fs-md">New Password*</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control fs-md" id="password" name="password" placeholder="Enter new password" required>
                                                                    <button class="btn btn-link shadow-none position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-3">
                                                            <div class="auth-pass-inputgroup">
                                                                <label for="confirm_passwordt" class="form-label fs-md">Confirm Password*</label>
                                                                <div class="position-relative">
                                                                    <input type="password" class="form-control fs-md" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                                                                    <button class="btn btn-link shadow-none position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                    <div class="col-lg-12">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="submit" class="btn btn-primary">Create User</button>
                                                            <button type="reset" class="btn btn-subtle-danger">Cancel</button>
                                                        </div>
                                                    </div>
                                                    <!--end col-->
                                                </div>
                                                <!--end row-->
                                            </form>
                                        </div>
                                    </div>
                                    <!--end tab-pane-->
                                    <div class="tab-pane" id="changePassword" role="tabpanel">
                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">Our User List Details</h5>
                                                        </div>
                                                        <div class="card-body">

                                                            <?php
                                                            include("dbConn.php");
                                                            $result = mysqli_query($conn, "SELECT users.*, roles.role_name FROM users LEFT JOIN roles ON users.role_id = roles.id");
                                                            ?>
                                                            <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th>SR No.</th>
                                                                        <th>Name</th>
                                                                        <th>Email</th>
                                                                        <th>Role</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $sr = 1;
                                                                    while ($row = mysqli_fetch_assoc($result)) { ?>
                                                                        <tr>
                                                                            <td><?= $sr++ ?></td>
                                                                            <td><?= $row['name'] ?></td>
                                                                            <td><?= $row['email'] ?></td>
                                                                            <td><?= $row['role_name'] ?></td>
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

                                                                        </tr>
                                                                    <?php } ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div><!--end col-->
                                            </div>
                                        </div>
                                    </div>
                                    <!--end tab-pane-->
                                </div>
                            </div>
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
                <!-- container-fluid -->
            </div><!-- End Page-content -->

            <?php include('include/dashboard-footer.php'); ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?php include('include/preloader.php'); ?>
    <?php include('include/datatable-footer-js.php'); ?>
    

    <script>
        $(document).on('change', '.toggle-status', function() {
            var userId = $(this).data('user-id');
            var status = $(this).is(':checked') ? 1 : 0;

            $.ajax({
                url: 'update_user_status.php', // redirect to this page using ajax logic 
                type: 'POST',
                data: {
                    user_id: userId,
                    status: status
                },
                success: function(response) {
                    alert(response);
                },
                error: function() {
                    alert('Error updating status');
                }
            });
        });
        
         // this J-query using for password visibuility
        $(document).ready(function() {
            $('.password-addon').on('click', function() {
                let input = $(this).siblings('input');
                let icon = $(this).find('i');

                if (input.attr('type') === 'password') {
                    input.attr('type', 'text');
                    icon.removeClass('ri-eye-fill').addClass('ri-eye-off-fill');
                } else {
                    input.attr('type', 'password');
                    icon.removeClass('ri-eye-off-fill').addClass('ri-eye-fill');
                }
            });
        });
    </script>

</body>

</html>