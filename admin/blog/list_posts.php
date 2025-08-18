<?php
// Start session before any output
session_start();
include("../dbConn.php");

// Main Query with JOINs to fetch category and tags
$sql = "SELECT 
    bp.post_id, 
    bp.title, 
    bp.author, 
    bc.category_name, 
    bp.status, 
    bp.created_at,
    bp.slug,  /* This line Specially for slag */
    GROUP_CONCAT(t.tag_name SEPARATOR ', ') AS tags
FROM 
    blog_posts bp
LEFT JOIN 
    blog_categories bc ON bp.category_id = bc.category_id
LEFT JOIN 
    blog_post_tags bpt ON bp.post_id = bpt.post_id
LEFT JOIN 
    tags t ON bpt.tag_id = t.tag_id
GROUP BY 
    bp.post_id
ORDER BY 
    bp.post_id DESC";


$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en" data-layout="vertical" data-sidebar="dark" data-sidebar-size="sm-hover" data-preloader="disable" data-bs-theme="light">


<head>

    <meta charset="utf-8">
    <title>Add Blog | DG - Blog Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Devout Growth" name="author">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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
                                <h4 class="mb-sm-0">Datatables</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                        <li class="breadcrumb-item active">Datatables</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="alert alert-danger" role="alert">
                        Discover the <strong>collection</strong> of insightful <b>blogs</b> all in one place!
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Our List Of Blogs</h5>
                                </div>
                                <div class="card-body">
                                    <?php
                                    // Display alerts based on the message passed in the URL
                                    if (isset($_GET['msg'])) {
                                        if ($_GET['msg'] == 'deleted') {
                                            echo "<script>alert('Post deleted successfully.');</script>";
                                        } elseif ($_GET['msg'] == 'delete_failed') {
                                            echo "<script>alert('Failed to delete the post.');</script>";
                                        } elseif ($_GET['msg'] == 'invalid_post') {
                                            echo "<script>alert('Invalid post ID.');</script>";
                                        }
                                    }
                                    ?>

                                    <table id="alternative-pagination" class="table nowrap dt-responsive align-middle table-hover table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Categories</th>
                                                <th>Tags</th>
                                                <th>Status</th>
                                                <th>Date | Time</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($result->num_rows > 0) {
                                                $i = 1;
                                                while ($row = $result->fetch_assoc()) {
                                                    $statusText = $row['status'] == 1 ? 'Active' : 'Inactive';
                                                    $tagList = !empty($row['tags']) ? $row['tags'] : '—';

                                                    echo "<tr>
                <td>{$i}</td>
                <td>{$row['title']}</td>
                <td>{$row['author']}</td>
                <td>{$row['category_name']}</td>
                <td>{$tagList}</td>
                <td>{$statusText}</td>
                <td>{$row['created_at']}</td>
                <td>
                    <div class='dropdown d-inline-block'>
                        <button class='btn btn-subtle-secondary btn-sm dropdown' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                            <i class='ri-more-fill align-middle'></i>
                        </button>
                        <ul class='dropdown-menu dropdown-menu-end'>
                            <li><a href='../../blog/blog-detail.php?slug={$row['slug']}' class='dropdown-item' target='_blank'>
                                <i class='ri-eye-fill align-bottom me-2 text-muted'></i> View
                            </a></li>
                            <li><a href='edit-post.php?slug={$row['slug']}' class='dropdown-item'>
                                <i class='ri-pencil-fill align-bottom me-2 text-muted'></i> Edit
                            </a></li>
                             <li><a href='blog_faq.php?slug={$row['slug']}' class='dropdown-item'>
                                <i class='ri-pencil-fill align-bottom me-2 text-muted'></i> Add FAQ
                            </a></li>
                             <a href='add-influencer.php?slug={$row['slug']}' class='dropdown-item'>
                        <i class='ri-pencil-fill align-bottom me-2 text-muted'></i> Add Influencer
                            </a>
                               </li>
                               ";

                                                    // Check if the logged-in user is a Super Admin (role_id = 1)
                                                    if (isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1) {
                                                        echo "<li><a href='delete-post.php?id={$row['post_id']}' class='dropdown-item' onclick=\"return confirm('Are you sure you want to delete this post?')\">
                        <i class='ri-delete-bin-fill align-bottom me-2 text-muted'></i> Delete
                    </a></li>";
                                                    }

                                                    echo "</ul>
                    </div>
                </td>
            </tr>";
                                                    $i++;
                                                }
                                            } else {
                                                echo "<tr><td colspan='8'>No posts found</td></tr>";
                                            }
                                            ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div><!--end col-->
                    </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="../assets/js/pages/datatables.init.js"></script>

</body>

</html>