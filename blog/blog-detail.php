<?php
session_start();  // Start session 
include("../dbConn.php");

// Get the slug from the URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';

// Validate slug input
if (empty($slug)) {
    header("Location: 404.php");
    exit;
}

// Prepare and execute the query securely using prepared statements
$sql = "SELECT bp.*, bc.category_name 
        FROM blog_posts bp 
        LEFT JOIN blog_categories bc ON bp.category_id = bc.category_id 
        WHERE bp.slug = ? LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

// Check if blog exists
if ($result->num_rows === 1) {
    $blog = $result->fetch_assoc();

    // Extract blog details
    $post_title = $blog['title'];
    $seo_description = $blog['seo_description'];
    $short_desc = $blog['short_desc'];
    $post_content = $blog['description'];  // Contains HTML tags
    $category_name = $blog['category_name'];
    $featured_image = $blog['featured_image'];
    $created_at = date("F j, Y", strtotime($blog['created_at']));
    $author = $blog['author'];

    // Optionally remove HTML tags from description if needed
    $post_content_stripped = strip_tags($post_content);

    // Update impressions count once per session per slug
    if (!isset($_SESSION['impressions'][$slug])) {
        $updateStmt = $conn->prepare("UPDATE blog_posts SET impressions = impressions + 1 WHERE slug = ?");
        $updateStmt->bind_param("s", $slug);
        $updateStmt->execute();
        $updateStmt->close();

        $_SESSION['impressions'][$slug] = true;
    }
} else {
    header("Location: 404.php");
    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($seo_description ?: substr(strip_tags($short_desc), 0, 150)); ?>">
    <meta name="author" content="Devout Growth">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.devoutgrowth.com/blog/<?php echo $slug; ?>.php" />
    <meta property="og:title" content="<?php echo htmlspecialchars($post_title); ?>" />
    <meta property="og:description" content="<?php echo htmlspecialchars($blog['meta_description'] ?? substr(strip_tags($post_content), 0, 150)); ?>" />
    <meta property="og:site_name" content="Devout Growth" />
    <meta property="og:image" content="https://www.devoutgrowth.com/digital-marketing-company/blogs/blog-details/<?php echo $featured_image; ?>" />
    <meta property="og:image:width" content="405" />
    <meta property="og:image:height" content="409" />
    <meta name="robots" content="index">
    <meta property="article:published_time" content="2025-04-17T16:54:18+00:00" />
    <meta property="article:modified_time" content="2025-04-17T16:04:13+00:00" />
    <link rel="canonical" href="https://www.devoutgrowth.com/blog/<?php echo $slug; ?>.php" />
    <meta property="og:url" content="https://www.devoutgrowth.com/blog/<?php echo $slug; ?>.php" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Devout Growth" />
    <meta name="twitter:title" content="<?php echo htmlspecialchars($post_title); ?>" />
    <meta name="twitter:description" content="<?php echo htmlspecialchars($blog['meta_description'] ?? substr(strip_tags($post_content), 0, 150)); ?>" />
    <meta name="twitter:image" content="https://www.devoutgrowth.com/digital-marketing-company/blogs/blog-details/<?php echo htmlspecialchars($featured_image); ?>" />
    <meta name="twitter:url" content="https://x.com/Devoutgrowth" />
    <meta name="google-site-verification" content="b5HDQuObJmuF72DIfVc3aEHb0bW5r8J-kkkW6C3KZ70" />
    <!--================= styling =================-->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="../css/fontawesome-all.min.css">
    <!-- animation css -->
    <link href="../css/aos.css" rel="stylesheet">
    <!-- Custom File's Link -->
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/responsiveStyle.css">
    <link rel="stylesheet" href="../css/blog-details.css">
    <!--================= Favicon =================-->
    <link rel="apple-touch-icon" sizes="180x180" href="../digital-marketing-company/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="../digital-marketing-company/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="../digital-marketing-company/favicon/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../digital-marketing-company/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../digital-marketing-company/favicon/favicon-16x16.png">
    <link href="../digital-marketing-company/favicon/favicon.ico" rel="shortcut icon">
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-MQW5XDQZ');
    </script>
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQW5XDQZ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Navbar section -->
    <header class="header_wrapper dg-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container primary-menu-inner">
                <a class="navbar-brand" href="../index.html">
                    <img decoding="async" src="../digital-marketing-company/DG-Logo.png" class="img-fluid"
                        alt="best digital marketing company in India" width="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <!-- Close Button -->
                    <a class="mobile-logo mobile-social-icone" href="../index.html"><img
                            src="../digital-marketing-company/software-company-in-patna.png"
                            alt="best marketing in patna">
                    </a>
                    <button class="close-btn">
                        <div class="close-under">
                            <i class="fa-solid fa-times"></i>
                        </div>
                    </button>
                    <ul class="navbar-nav menu-navbar-nav">
                        <li class="nav-item dropdown nav-menus">
                            <a class="nav-link " aria-current="page" href="#">Services <i
                                    class="fa-solid fa-angle-down"></i></a>
                            <ul class="dropdown-menu nav-menus-hover">
                                <li><a class="nav-link" href="../performance-marketing.html">Performance Marketing</a>
                                </li>
                                <li><a class="nav-link" href="../digital-marketing.html">Digital Marketing</a></li>
                                <li><a class="nav-link" href="../web-app-development.html">Website and App
                                        Development</a></li>
                                <li><a class="nav-link" href="../software-erp-crm.html">Software/ERP/CRM Development</a>
                                </li>
                                <li><a class="nav-link" href="../pr-services.html">PR Services</a></li>
                            </ul>
                        </li>
                        <li class="nav-item ">
                            <a href="../about-us.html" class="nav-link">
                                About Us
                                <i class="ri-arrow-down-s-line"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../our-team.php">Our Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contact-us.html">Contact Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../careers.php">Careers</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../blog.php">Blog</a>
                        </li>
                        <li class="nav-item dg-whatpp dg-desktop-whatp">
                            <a class="nav-link btn btn-dark text-white hader-wahatp-btn"
                                href="https://wa.me/917368083688" target="_blank">WhatsApp:
                                +91-7368083688</a>
                        </li>
                        <li class="nav-item dg-whatpp mobile-social-icone">
                            <a class="nav-link btn btn-dark text-white hader-wahatp-btn"
                                href="https://wa.me/917368083688" target="_blank"><i
                                    class="fa-brands fa-whatsapp me-2"></i>
                                +91-7368083688</a>
                        </li>
                    </ul>
                    <ul class=" list-unstyled m-3  mobile-social-icone">
                        <div class="d-flex justify-content-around">
                            <a href="https://www.facebook.com/devoutgrowth">
                                <li><i class="fa-brands fa-facebook text-black"></i> </li>
                            </a>
                            <a href="https://www.linkedin.com/company/devout-growth-digital/">
                                <li><i class="fa-brands fa-x-twitter text-black"></i></li>
                            </a>
                            <a href="https://www.youtube.com/@dgdigitaltm">
                                <li><i class="fa-brands fa-youtube text-black"></i></li>
                            </a>
                            <a href="https://x.com/i/flow/login?redirect_after_login=%2FDgDigitaltm">
                                <li><i class="fa-brands fa-linkedin text-black"></i></li>
                            </a>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navbar section exit -->

    <!-- bredcumb started here -->
    <section class="breadcrumb-section blog-bredcum blogs-wrap">
        <div class="container breadcrumb-container">
            <div class="row">
                <div class="breadcrumb-content">
                    <div class="col-md-12">
                        <div class="title-container text-center">
                            <div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">
                                <span property="itemListElement" typeof="ListItem">
                                    <a property="item" typeof="WebPage" title="Go to DG." href="../index.html"
                                        class="breadcrumb-home">
                                        <span property="name">DG</span>
                                    </a>
                                    <meta property="position" content="1">
                                </span>
                                >
                                <a href="../blog.html">BLOGs</a>
                                >
                                <span property="itemListElement" typeof="ListItem">
                                    <span property="name" class="breadcrumb-current"><?php echo htmlspecialchars($post_title); ?>
                                    </span>
                                    <meta property="url">
                                    <meta property="position" content="2">
                                </span>
                            </div>
                            <h1 class="title"><?php echo htmlspecialchars($post_title); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- bredcumb end here -->

    <!-- Start Blog Details Area -->
    <section class="blog-details-area ptb-100 pt-1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details-content mr-15">
                        <div class="blog-details-img">
                            <img src="../admin/blog/<?= htmlspecialchars($featured_image); ?>" alt="<?= htmlspecialchars($post_title); ?>" class="img-fluid">
                        </div>
                        <div class="blog-top-content">
                            <div class="blog-content">
                                <ul class="admin">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user"></i>
                                            <?= htmlspecialchars($author); ?>
                                        </a>
                                    </li>

                                    <li>
                                        <i class="fa fa-calendar"></i>
                                        <?= date("F d, Y", strtotime($created_at)); ?>
                                    </li>
                                </ul>

                                <p><?php echo nl2br(htmlspecialchars($short_desc)); ?></p>
                                <div class="gap-mb-20"></div>
                            </div>

                            <!-- Influncer listing area :- -->

                            <?php
                            if (isset($_GET['slug'])) {
                                $slug = mysqli_real_escape_string($conn, $_GET['slug']);

                                // Step 1: Fetch post_id from blog_posts
                                $postQuery = "SELECT post_id FROM blog_posts WHERE slug = '$slug'";
                                $postResult = mysqli_query($conn, $postQuery);

                                if (mysqli_num_rows($postResult) > 0) {
                                    $postRow = mysqli_fetch_assoc($postResult);
                                    $post_id = $postRow['post_id'];

                                    // Step 2: Fetch influencers for this post_id
                                    $query = "SELECT * FROM influencers WHERE post_id = '$post_id' ORDER BY id ASC";
                                    $result = mysqli_query($conn, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        // Fetch all rows first
                                        $influencers = [];
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $influencers[] = $row;
                                        }

                                        // Show title only once using first row
                                        echo '<h2 class="text-md-start text-center">' . htmlspecialchars($influencers[0]['title']) . '</h2>';

                                        // Serial number counter
                                        $sl_no = 1;

                                        // Loop through all influencers
                                        foreach ($influencers as $row) {
                            ?>
                                            <div>
                                                <div class="row">
                                                    <div class="col-md-4 text-md-start text-center">
                                                        <div>
                                                            <img class="img-fluid" src="../admin/blog/influencers/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <h4 class="name-of-youtuber text-md-start text-center my-3 mt-md-0">
                                                            <a href="#!"><?= $sl_no . '. ' . htmlspecialchars($row['name']) ?></a>
                                                        </h4>

                                                        <div class="stats-block">
                                                            <div class="stats-wrapper">
                                                                <div class="stat-item">
                                                                    <span> Followers: </span> <?= htmlspecialchars($row['followers']) ?>
                                                                </div>
                                                                <div class="stat-item">
                                                                    <span> Engagement Rate: </span> <?= htmlspecialchars($row['engagement_rate']) ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="accod-panel">
                                                            <div class="accod-head" onclick="toggleAccordion(this)">
                                                                <span class="accod-icon">+ </span>
                                                                <h4 class="heading-acordina ms-3">About the Creator:</h4>
                                                            </div>
                                                            <div class="accod-content">
                                                                <p><?= nl2br(htmlspecialchars($row['description'])) ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                            $sl_no++; // increment serial number
                                        } // end foreach
                                    } // end if result rows > 0
                                } // end if post exists
                            } // end if slug
                            ?>

                            <?php echo $post_content; ?>

                            <!-- Faqs area started here -->
                            <?php

                            $slug = mysqli_real_escape_string($conn, $_GET['slug']); // Sanitize input

                            // Get post ID from slug
                            $get_post_id = mysqli_query($conn, "SELECT post_id FROM blog_posts WHERE slug = '$slug'");
                            $post_data = mysqli_fetch_assoc($get_post_id);

                            if ($post_data) {
                                $post_id = $post_data['post_id'];

                                // Get FAQs for this post only
                                $faq_query = "SELECT * FROM blog_post_faqs WHERE post_id = $post_id ORDER BY id ASC";
                                $faq_result = mysqli_query($conn, $faq_query);

                                if (mysqli_num_rows($faq_result) > 0) {
                                    $counter = 1;
                            ?>
                                    <div class="faqss blog-faqss">
                                        <h3>Faqs:</h3>
                                        <hr>
                                        <div class="row">
                                            <div class="bsb-faq-3 py-xl-8">
                                                <div class="row justify-content-center">
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="accordion accordion-flush" id="faqAccount">
                                                            <?php while ($row = mysqli_fetch_assoc($faq_result)) {
                                                                $question = htmlspecialchars($row['question']);
                                                                $answer = htmlspecialchars($row['answer']);
                                                                $id = $counter;
                                                            ?>
                                                                <div class="accordion-item bg-transparent border-bottom">
                                                                    <h2 class="accordion-header" id="faqAccountHeading<?= $id ?>">
                                                                        <button
                                                                            class="accordion-button collapsed bg-transparent fw-bold shadow-none link-primary"
                                                                            type="button"
                                                                            data-bs-toggle="collapse"
                                                                            data-bs-target="#faqAccountCollapse<?= $id ?>"
                                                                            aria-expanded="false"
                                                                            aria-controls="faqAccountCollapse<?= $id ?>">
                                                                            <img class="conversation_img" src=".././digital-marketing-company/conversation.png" alt="conversation">
                                                                            <?= $question ?>
                                                                        </button>
                                                                    </h2>
                                                                    <div id="faqAccountCollapse<?= $id ?>" class="accordion-collapse collapse"
                                                                        aria-labelledby="faqAccountHeading<?= $id ?>">
                                                                        <div class="accordion-body">
                                                                            <p><?= nl2br($answer) ?></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php $counter++;
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                } else {
                                    echo "<p>No FAQs available for this blog post.</p>";
                                }
                            } else {
                                echo "<p>Invalid blog post.</p>";
                            }
                            ?>

                        </div>

                        <special-share></special-share>

                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="widget-sidebar ml-15">
                        <div class="sidebar-widget categories">
                            <h3>Categories</h3>

                            <ul>
                                <li>
                                    <a href="../blog.html">
                                        Influencer Marketing
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        ⁠Branding & Advertisement
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        ⁠Social Media Marketing
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        ⁠Performance Marketing
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        Search Engine Optimisation
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        Business Intelligence
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        Marketing & Collaboration
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="../blog.html">
                                        ⁠Algorithms & Development
                                        <i class="fas fa-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-widget recent-post">
                            <h3 class="widget-title">Recent Blogs</h3>

                            <ul>
                                <?php
                                // Current blog slug
                                $current_slug = isset($_GET['slug']) ? $_GET['slug'] : '';

                                // Prepare recent blog posts query, excluding current blog
                                $query = "SELECT title, slug, featured_image, created_at FROM blog_posts WHERE slug != ? AND status = 1 ORDER BY created_at DESC LIMIT 3";
                                $stmt = $conn->prepare($query);
                                $stmt->bind_param("s", $current_slug);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                // Show recent blogs
                                while ($row = $result->fetch_assoc()) {
                                    $post_title = $row['title'];
                                    $post_slug = $row['slug'];
                                    $post_image = $row['featured_image'];
                                    $post_date = date("F j, Y", strtotime($row['created_at']));
                                ?>
                                    <li>
                                        <a href="blog/<?php echo $post_slug; ?>.php">
                                            <?php echo $post_title; ?>
                                            <img src="../admin/blog/<?php echo $post_image; ?>" width="80px" height="80px" alt="<?php echo $post_title; ?>">
                                        </a>
                                        <span><?php echo $post_date; ?></span>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>

                        </div>


                        <div class="sidebar-widget tags mb-0">
                            <h3>Tags</h3>

                            <ul>
                                <li>
                                    <a href="../blog.html">Influencer</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Marketing</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Branding</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Promotion</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Social Media</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Google</a>
                                </li>
                                <li>
                                    <a href="../blog.html">Coding</a>
                                </li>
                                <li>
                                    <a href="../blog.html">⁠Algorithms</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- End Blog Details Area -->

    <!-- Footer section -->
    <special-footer> </special-footer>
    <!-- Footer section exit -->
    <!-- DG all JS Here -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <!-- Custom Js Link -->
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/fontawesome-kit.js"></script>
    <script src="../assets/js/icone.js"></script>
    <!-- animation js -->
    <script src="../assets/js/aos.js"></script>
    <script src="../assets/includes/footer-blog.js"></script>

    <script>
        // Note  This code is for the blog section only to get blog visit duratin
        const visitStart = Date.now();

        window.addEventListener('beforeunload', function() {
            const visitEnd = Date.now();
            const duration = Math.floor((visitEnd - visitStart) / 1000); // seconds

            // Send data to server using fetch or AJAX
            navigator.sendBeacon('track-duration.php', new Blob([JSON.stringify({
                slug: '<?= $slug ?>',
                duration: duration
            })], {
                type: 'application/json'
            }));
        });

        AOS.init();

        // For Influncer accordian
        function toggleAccordion(headerElement) {
            const panel = headerElement.closest('.accod-panel');
            const icon = headerElement.querySelector('.accod-icon');
            panel.classList.toggle('active');
            icon.textContent = panel.classList.contains('active') ? '−' : '+';
        }
    </script>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WKTNF3GN" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>