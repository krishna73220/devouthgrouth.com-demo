class SpecialFooter extends HTMLElement {

    connectedCallback() {
        this.innerHTML = `
             <!-- Footer section -->
    <footer>    

        <section class="footer_wrapper mt-md-0 pb-0 testimonial_bg">
            <div class="container pb-3">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <h5>Devout Growth</h5>
                        <p class="ps-0">Transform your brand with our digital magic! Expert in organic content,
                            branding, lead generation and CGI ads. Let’s create your digital success story!.....</p>
                        <div class="contact-info">
                            <ul class="list-unstyled">
                                <li><a href="https://wa.me/917368083688" target="_blank"><i
                                            class="fa fa-whatsapp me-3 text-center"></i> +91 736 808 3688</a></li>
                                <li><a href="tel:+919900012122"><i class="fa fa-phone me-3"></i>+91 990 001 2122</a>
                                </li>
                                <li><a href="mailto:contact@devoutgrowth.com"><i
                                            class="fa fa-envelope me-3"></i>contact@devoutgrowth.com</a></li>
                            </ul>
                        </div>
                    </div>                  
                    <div class="col-lg-3 col-md-6">
                        <h5>Quick Links</h5>
                        <ul class="link-widget p-0">                            
                            <li><a href="../pr-services.html">PR Services</a></li>
                            <li><a href="../digital-marketing.html">Digital Marketing</a></li>
                            <li><a href="../performance-marketing.html">Performance Marketing</a></li>
                            <li><a href="../search-engine-optimization.html">Search Engine Optimization</a></li>
                            <li><a href="../web-app-development.html">Website and App Development</a></li>
                            <li><a href="../software-erp-crm.html">Software/ERP/CRM Development</a></li>

                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">                                           
                        <h5 class=" text-md-center">Corporate Office</h5>
                        <div class="d-flex mt-3 align-items-center">
                            <i class="fas fa-map-marker-alt"></i>
                            <p class="link-widget p-0 ms-2  mb-1">
                                4th Floor Colabspace, Office Space Building 7, 19th Main Rd, Sector 4, HSR Layout, Bengaluru, Karnataka 560102
                            </p>
                        </div>  
                        <h4 class="fs-6 mt-3 registered-office-heading text-md-center">Registered Office</h4>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt "></i>
                            <p class="link-widget p-0 ms-2  mb-1 registered-office patna-office">
                                BUDHA TOYOTA Showroom, 145, Patliputra Kurji Rd, in front of SBI Bank, Patliputra
                                Colony, Patna, Bihar 800013
                            </p>
                        </div>                      

                    </div>
                  
                    <div class="col-lg-3 col-md-6 mt-3 mt-sm-0">
                        <h5>Newsletter</h5>

                        <div class="form-group mb-4">
                            <input type="email" class="form-control bg-transparent" placeholder="enter your email here">
                            <button type="submit"
                                class="main-btn rounded-2 mt-3 border-white text-white">Subscribe</button>
                        </div>
                        <h5>Stay Connected</h5>
                        <ul class="social-network d-flex align-items-center p-0">
                            <li><a href="https://www.facebook.com/devoutgrowth" target="_blank"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://x.com/Devoutgrowth" target="_blank"><i
                                        class="fab fa-x-twitter"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/devout-growth-digital" target="_blank"><i
                                        class="fab fa-linkedin"></i></a></li>
                            <li><a href="https://www.instagram.com/devoutgrowth" target="_blank"><i
                                        class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid copyright-section">
                <p>Copyright © 2024 <a href="#">Devout Growth</a> All Rights Reserved</p>
            </div>
        </section>
    </footer>
    <!-- Footer section exit -->
        
        `
    }
}

customElements.define('special-footer', SpecialFooter)


// *********************************************************************************************

class Recentblog extends HTMLElement {

    connectedCallback() {
        this.innerHTML = `
           <div class="sidebar-widget recent-post">
                            <h3 class="widget-title">Recent Blogs</h3>

                            <ul>
                                <li>
                                    <a href="blog/influencer-marketing-regulation-india-guide.html">
                                        The Rise of Influencer Marketing in India
                                        <img src="../digital-marketing-company/blogs/recent-smal-img1.webp"
                                            alt="Six Conversion Champions">
                                    </a>
                                    <span>February 28, 2025</span>
                                </li>
                                <li>
                                    <a href="blog/famous-mumbai-instagram-influencers.html">
                                        Top 20 Influencers in Mumbai January 2025
                                        <img src="../digital-marketing-company/blogs/recent-img-2.webp"
                                            alt="Segmentation Strategies">
                                    </a>
                                    <span>january 18, 2025</span>
                                </li>
                                <li>
                                    <a href="blog/digital-marketing-agency-for-jewellery-business-india.html">
                                        Best Digital Marketing Agency for Jewellery Business in India
                                        <img src="../digital-marketing-company/blogs/recent-img-3.webp"
                                            alt="Nurturing Growth">
                                    </a>
                                    <span>January 09, 2025</span>
                                </li>
                            </ul>
                        </div>
        `}
}
customElements.define('recent-blogs', Recentblog)