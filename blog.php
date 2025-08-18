<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog DG</title>
    <meta name="keywords"
        content="Top digital marketing companies in india, best digital marketing agency in india, best digital marketing company in india, why digital marketing is important,importance and benefits of digital marketing">
    <meta name="description" content="Transform Your Website into a Traffic Magnet with Devout Growth">
    <meta name="author" content="Devout Growth">
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://www.devoutgrowth.com/" />
    <meta property="og:title" content="Devout Growth | Branding and Performance marketing agency" />
    <meta property="og:description"
        content="Elevate your online presence with Devout Growth's expert digital marketing services. Boost visibility, drive traffic, and achieve success. Explore now!" />
    <meta property="og:site_name" content="Devout Growth" />
    <meta property="og:image" content="https://www.devoutgrowth.com/digital-marketing-company/DG-Logo.png" />
    <meta property="og:image:width" content="405" />
    <meta property="og:image:height" content="409" />
    <meta name="robots" content="index">
    <meta property="article:published_time" content="2020-12-26T16:54:18+00:00" />
    <meta property="article:modified_time" content="2022-10-22T16:04:13+00:00" />
    <link rel="canonical" href="https://www.devoutgrowth.com/blog.html" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Devout Growth" />
    <meta name="twitter:title" content="Devout Growth | Branding and Performance marketing agency" />
    <meta name="twitter:description"
        content="Elevate your online presence with Devout Growth's expert digital marketing services. Boost visibility, drive traffic, and achieve success. Explore now!" />
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
    <link rel="stylesheet" href="css/blog-details.css">
    <!--================= Favicon =================-->
    <link rel="apple-touch-icon" sizes="180x180" href="digital-marketing-company/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192"
        href="digital-marketing-company/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512"
        href="digital-marketing-company/favicon/android-chrome-512x512.png">
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
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MQW5XDQZ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Navbar section -->
    <special-header></special-header>
    <!-- Navbar section exit -->
    <!-- bredcumb started here -->
    <section class="breadcrumb-section blog-bredcum">
        <div class="container breadcrumb-container">
            <div class="row">
                <div class="breadcrumb-content">
                    <div class="col-md-12">
                        <div class="title-container text-center">
                            <div class="breadcrumb" typeof="BreadcrumbList" vocab="https://schema.org/">
                                <span property="itemListElement" typeof="ListItem">
                                    <a property="item" typeof="WebPage" title="Go to DG." href="index.html"
                                        class="breadcrumb-home">
                                        <span property="name">DG</span>
                                    </a>
                                    <meta property="position" content="1">
                                </span>
                                &gt;
                                <span property="itemListElement" typeof="ListItem">
                                    <span property="name" class="breadcrumb-current">Blog</span>
                                    <meta property="position" content="2">
                                </span>
                            </div>

                            <h1 class="title">Blog</h1>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- bredcumb end here -->


    <section class="blog-wraps pb-md-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 ">
                    <div class="widget-sidebar ml-15">
                        <div id="myBtnContainer" class="sidebar-widget categories">
                            <h3>Categories</h3>

                            <?php
                            include("dbConn.php");

                            $catQuery = "SELECT DISTINCT category_name FROM blog_categories ORDER BY category_name ASC";
                            $catResult = mysqli_query($conn, $catQuery);
                            ?>
                            <ul>
                                <li class="catagory-btn active d-flex justify-content-between" onclick="filterSelection('all')">
                                    View All <i class="fas fa-angle-right"></i>
                                </li>
                                <?php while ($catRow = mysqli_fetch_assoc($catResult)) {
                                    $className = strtolower(str_replace(' ', '-', $catRow['category_name']));
                                ?>
                                    <li class="catagory-btn d-flex justify-content-between" onclick="filterSelection('<?php echo $className; ?>')">
                                        <?php echo $catRow['category_name']; ?> <i class="fas fa-angle-right"></i>
                                    </li>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="sidebar-widget recent-post">
                            <h3 class="widget-title">Recent Blogs</h3>

                            <ul>

                                <?php
                                // Database se latest 3 blog posts fetch karte hain
                                $query = "SELECT title, slug, featured_image, created_at FROM blog_posts WHERE status = 1 ORDER BY created_at DESC LIMIT 3";
                                $result = mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    $post_title = $row['title'];
                                    $post_slug = $row['slug'];
                                    $post_image = $row['featured_image'];
                                    $post_date = date("F j, Y", strtotime($row['created_at']));  // Date format ko readable bana rahe hain
                                ?>
                                    <li>
                                        <a href="blog/<?php echo $post_slug; ?>">
                                            <?php echo $post_title; ?>
                                            <img src="./admin/blog/<?php echo $post_image; ?>" width="80px" height="80px" alt="<?php echo $post_title; ?>">
                                        </a>
                                        <span><?php echo $post_date; ?></span>
                                    </li>
                                <?php
                                }
                                ?>

                                <!--<li>
                                    <a href="blog/digital-marketing-agency-for-jewellery-business-india.html">
                                        Best Digital Marketing Agency for Jewellery Business in India
                                        <img src="digital-marketing-company/blogs/recent-img-3.webp"
                                            alt="Nurturing Growth">
                                    </a>
                                    <span>January 09, 2025</span>
                                </li> -->
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 ">
                    <div class="row wrapper">
                        <?php
                        include("dbConn.php");
                        $query = "SELECT bp.*, bc.category_name 
          FROM blog_posts bp 
          LEFT JOIN blog_categories bc ON bp.category_id = bc.category_id
          WHERE bp.status = 1
          ORDER BY bp.created_at DESC";

                        $result = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $post_slug = $row['slug']; 
                        ?>
                            <div class="col-lg-6 col-md-6 mb-4 item all <?php echo strtolower(str_replace(' ', '-', $row['category_name'])); ?>">
                                <div class="blog-wrap-post">
                                    <div class="featured-media">
                                          <img src="./admin/blog/<?php echo $row['featured_image']; ?>" class="img-fluid" alt="<?php echo $row['title']; ?>">
                                    </div>
                                    <div class="entry-header pt-2">
                                        <a href="blog/<?php echo $post_slug; ?>" class="entry-title-link">
                                            <h5 class="entry-title"><?php echo $row['title']; ?></h5>
                                        </a>
                                        <div class="entry-excerpt">
                                            <p class="entry-text"><?php echo $row['short_desc']; ?></p>
                                        </div>

                                        <div class="button-wrapper-digital">
                                            <a class="button-digital button-xl" href="blog/<?php echo $post_slug; ?>">Read More <span class="button-icon">
                                                    <i aria-hidden="true" class="fas fa-long-arrow-alt-right"></i>
                                                </span></a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <!-- Er. Hrisheekesh Kr -->


                    </div>
                </div>
            </div>
            <div id="pagination" class="my-5"></div>
            <nav aria-label="Page navigation example" style="display: flex; justify-content: center;">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">4</a></li>
                    <li class="page-item"><a class="page-link" href="#">5</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>
        </div>
    </section>

    <!-- Footer section -->
    <special-footer> </special-footer>
    <!-- Footer section exit -->
    <a href="#" class="scroll-up" id="scrollUpBtn">
        <i class="fas fa-arrow-up"></i>
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

    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script>
        function filterSelection(category) {
            let items = document.getElementsByClassName("item");
            for (let i = 0; i < items.length; i++) {
                if (category == "all" || items[i].classList.contains(category)) {
                    items[i].style.display = "block";
                } else {
                    items[i].style.display = "none";
                }
            }

            // Update active class on buttons
            let btns = document.getElementsByClassName("catagory-btn");
            for (let j = 0; j < btns.length; j++) {
                btns[j].classList.remove("active");
            }
            event.currentTarget.classList.add("active");
        }



        $(document).ready(function() {
            var $grid = $('.wrapper').isotope({
                itemSelector: '.item',
                layoutMode: 'fitRows'
            });
            $('.catagory-btn').click(function() {
                var filterValue = $(this).attr('onclick').split("'")[1];
                $grid.isotope({
                    filter: '.' + filterValue
                });
                $('.catagory-btn').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WKTNF3GN" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
</body>

</html>