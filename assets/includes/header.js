class SpecialHeader extends HTMLElement {

    connectedCallback() {
        this.innerHTML = `
                <header class="header_wrapper dg-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container primary-menu-inner">
                <a class="navbar-brand" href="index.html">
                    <img decoding="async" src="digital-marketing-company/DG-Logo.png" class="img-fluid"
                        alt="best digital marketing company in India" width="50">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <!-- Close Button -->
                    <a class="mobile-logo mobile-social-icone" href="index.html"><img
                            src="digital-marketing-company/software-company-in-patna.png" alt="best marketing in patna"
                            class="img-fluid">
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
                                <li><a class="nav-link" href="performance-marketing.html">Performance Marketing</a></li>
                                <li><a class="nav-link" href="influencer-marketing.html">Influencer Marketing</a></li>
                                <li><a class="nav-link" href="digital-marketing.html">Digital Marketing</a></li>
                        </li>
                        <li><a class="nav-link" href="software-erp-crm.html">Software/ERP/CRM Development</a>
                        </li>
                        <li><a class="nav-link" href="pr-services.html">PR Services</a></li>

                    </ul>
                    </li>

                    <li class="nav-item dropdown nav-menus">
                        <a class="nav-link" aria-current="page" href="#">Tech-Dev <i
                                class="fa-solid fa-angle-down"></i></a>
                        <ul class="dropdown-menu nav-menus-hover">

                            <li class="nav-item dropdown nav-submenu" style="position: relative;">
                                <a style="margin-left:0px !important" class="nav-link" href="#">Website and App
                                    Development <i class="fa-solid fa-angle-right"></i></a>
                                <ul class="dropdown-menu sub-hover web-aap-mega-drop" >
                                    <li><a class="nav-link" href="website-development.html">Website Development</a></li>
                                    <li><a class="nav-link" href="app-development.html">Apps Development</a></li>
                                </ul>
                            </li>

                            <li style="border-radius: 8px; margin-left: 0px !important;"><a
                                    style="margin-left: 10px !important;" class="nav-link "
                                    href="influencer-marketing.html">Software Solutions</a></li>
                        </ul>
                    </li>
                    <style>
                        /* Submenu by default hidden */
                        .sub-hover {
                            display: none;
                        }

                        /* Hover on parent li only shows submenu */
                        .nav-submenu:hover>.sub-hover {
                            display: block;
                        }

                        .web-aap-mega-drop {
                            top: 10px;
                            left: 100%;
                            position: absolute;
                            width: max-content;
                            border-top: 2px solid var(--secondary-color);
                            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
                        }           

                        /* Submenu ka bhi same alignment */
                        .sub-hover .nav-link {
                            padding-left: 15px !important;
                            padding-right: 15px !important;
                        }

                        /* Li pe border-radius ka effect aur proper alignment */
                        .dropdown-menu>li {
                            border-radius: 8px;
                            margin-left: 0 !important;
                            margin-right: 0 !important;
                        }
                    </style>

                    <li class="nav-item ">
                        <a href="about-us.html" class="nav-link">
                            About Us
                            <i class="ri-arrow-down-s-line"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="our-team">Our Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-us.html">Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="careers">Careers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog.php">Blog</a>
                    </li>
                    <li class="nav-item dg-whatpp dg-desktop-whatp">
                        <a class="nav-link btn btn-dark text-white hader-wahatp-btn" href="https://wa.me/917368083688"
                            target="_blank">WhatsApp:
                            +91-7368083688</a>
                    </li>
                    <li class="nav-item dg-whatpp mobile-social-icone">
                        <a class="nav-link btn btn-dark text-white hader-wahatp-btn" href="https://wa.me/917368083688"
                            target="_blank"><i class="fa-brands fa-whatsapp me-2"></i>
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
        
        `
    }
}

customElements.define('special-header', SpecialHeader)
