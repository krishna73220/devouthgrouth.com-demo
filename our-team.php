<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team DG</title>
    <meta name="keywords" content="Top digital marketing companies in india, best digital marketing agency in india, best digital marketing company in india, why digital marketing is important,importance and benefits of digital marketing">
    <meta name="description" content="Transform Your Website into a Traffic Magnet with Devout Growth">
    <meta name="author" content="Devout Growth">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.devoutgrowth.com/" />
    <meta property="og:title" content="Devout Growth | Branding and Performance marketing agency" />
    <meta property="og:description" content="Transform Your Website into a Traffic Magnet with Devout Growth" />
    <meta property="og:site_name" content="Devout Growth" />
    <meta property="og:image" content="https://www.devoutgrowth.com/digital-marketing-company/DG-Logo.png" />
    <meta property="og:image:width" content="405" />
    <meta property="og:image:height" content="409" />
    <meta name="robots" content="index">
    <meta property="article:published_time" content="2020-12-26T16:54:18+00:00" />
    <meta property="article:modified_time" content="2022-10-22T16:04:13+00:00" />
    <link rel="canonical" href="https://www.devoutgrowth.com/our-team.html" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Devout Growth" />
    <meta name="twitter:title" content="Devout Growth | Branding and Performance marketing agency" />
    <meta name="twitter:description" content="Transform Your Website into a Traffic Magnet with Devout Growth" />
    <meta name="twitter:url" content="https://x.com/Devoutgrowth" />
    <meta name="twitter:image" content="https://www.devoutgrowth.com/digital-marketing-company/DG-Logo.png" />
    <meta name="google-site-verification" content="b5HDQuObJmuF72DIfVc3aEHb0bW5r8J-kkkW6C3KZ70" />
    <!--================= styling =================-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fontawesome-all.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link href="css/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsiveStyle.css">
    <!--================= Favicon =================-->
    <link rel="apple-touch-icon" sizes="180x180" href="digital-marketing-company/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="digital-marketing-company/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="digital-marketing-company/favicon/android-chrome-512x512.png">
    <link rel="icon" type="image/png" sizes="32x32" href="digital-marketing-company/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="digital-marketing-company/favicon/favicon-16x16.png">
    <link href="digital-marketing-company/favicon/favicon.ico" rel="shortcut icon">

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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQW5XDQZ"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Navbar section -->
    <special-header></special-header>
    <!-- Navbar section exit -->

    <!-- bredcumb started here -->
    <section class="breadcrumb-section">
        <div class="container breadcrumb-container">
            <div class="row">
                <div class="breadcrumb-content">
                    <div class="col-md-6">
                        <div class="breadcrumb-text">
                            <span>OUR TEAM</span>
                            <h1>Meet The Devoted Growers</h1>
                            <p>Get a team on-board with whom growth is not claimed on Reports instead calculated as ROI.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="breadcrumb-image d-sm-none d-md-block d-lg-block d-none text-center">
                            <img src="digital-marketing-company/dg-img/evi.png" class="img-fluid"
                                alt="no 1 digital marketing company">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- bredcumb end here -->

      <section class="testimonial_bg contact_us our_strength">
    <div class="container">
        <div class="breadcrumb-text team-head mt-5">
            <span class="text-center my-3 d-block">Corporate Team</span>
            <h3 class="text-center mb-5">DG'S War Room</h3>
        </div>

        <div class="row pt-md-4">
            <?php
            include("dbConn.php");

            // Department order array (replace with your actual department IDs)
            $department_order = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            $dept_order_str = implode(',', $department_order);

            // Single query to fetch all team members ordered by department as per $department_order
            $teamQuery = mysqli_query($conn, 
                "SELECT * FROM our_team 
                 ORDER BY FIELD(department_id, $dept_order_str), id ASC"
            );

            if (!$teamQuery) {
                die("Error fetching team members: " . mysqli_error($conn));
            }

            while ($team = mysqli_fetch_assoc($teamQuery)) {
                $imagePath = "admin/" . $team['image'];
                if (!file_exists($imagePath) || empty($team['image'])) {
                    $imagePath = "admin/default-team.jpg"; // fallback default image
                }
            ?>
                <div class="col-lg-4 col-md-4">
                    <div class="dg-team text-center">
                        <img src="<?php echo htmlspecialchars($imagePath); ?>" class="img-fluid" alt="<?php echo htmlspecialchars($team['name']); ?>">
                        <div class="name-degination pt-4">
                            <h5><?php echo htmlspecialchars($team['name']); ?></h5>
                            <p><?php echo htmlspecialchars($team['designation']); ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

    <!-- contact area started here -->
    <section class="join_with_dg">
        <div class="container">
            <div class="row cadder-area">
                <div class="col-md-7">
                    <div class="join-title">
                        <h2>Want to join? </h2>
                        <p>Sign Up to the team who are devoted towards Growth and make Growth devoted towards
                            <strong>YOU!</strong>
                        </p>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="join-btn-area ">
                        <a href="contact-us.html" class="btn btn-dark dg_btns_main btn-md"> Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer section -->
    <special-footer> </special-footer>
    <!-- Footer section exit -->
    <!-- Scroll to Top Button -->
    <a href="#" class="scroll-up" id="scrollUpBtn">
        <i class="fas fa-arrow-up"></i> <!-- You can use an icon or text -->
    </a>
    <!-- Dg all JS Here -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/fontawesome-kit.js"></script>
    <!-- animation js -->
    <script src="assets/js/aos.js"></script>
    <script src="assets/includes/footer.js"></script>
    <script src="assets/includes/header.js"></script>
    <script>
        AOS.init();
    </script>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WKTNF3GN"
            height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
</body>

</html>