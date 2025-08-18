
class ShareIcone extends HTMLElement {

    connectedCallback() {
        this.innerHTML = `
            <div class="tags">                    

                        <div class="share-link">
                            <ul class="social-icon">
                                <li>
                                    <span>Share</span>
                                </li>
                                <li>
                                    <a href="https://www.facebook.com/devoutgrowth" target="_blank">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/devoutgrowth/" target="_blank">
                                        <i class="fa fa-instagram"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.linkedin.com/company/devout-growth-digital/" target="_blank">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="https://x.com/Devoutgrowth" target="_blank">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <ul class="tag-link">
                            <li class="title">
                             
                            </li>
                            <li>
                                <a href="../blog.html" target="_blank">
                                    &nbsp;
                                </a>
                            </li>
                            
                        </ul>
                    </div>


        `
    }
}

customElements.define('special-share', ShareIcone)
