  <!-- ========== App Menu ========== -->
  <div class="app-menu navbar-menu">
      <!-- LOGO -->
      <div class="navbar-brand-box">
          <a href="../index.php" class="logo logo-dark">
              <span class="logo-sm">
                  <img src="../assets/images/logo-sm.png" alt="digital marketing company" height="22">
              </span>
              <span class="logo-lg">
                  <img src="../assets/images/DG-Logo.png" alt="Digital marketing services" height="22">
              </span>
          </a>
          <a href="../index.php" class="logo logo-light">
              <span class="logo-sm">
                  <img src="../assets/images/logo-sm.png" alt="performance marketing" height="22">
              </span>
              <span class="logo-lg">
                  <img src="../assets/images/DG-Logo.png" alt="logo" height="30">
              </span>
          </a>
          <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover shadow-none" id="vertical-hover">
              <i class="ri-record-circle-line"></i>
          </button>
      </div>

      <div id="scrollbar">
          <div class="container-fluid">

              <div id="two-column-menu">
              </div>
              <ul class="navbar-nav" id="navbar-nav">

                  <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                  <li class="nav-item">
                      <a class="nav-link menu-link collapsed dg-men" href="dashboard.php" role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                          <i class="ti ti-brand-google-home"></i> <span data-key="t-dashboards">Dashboard</span>
                      </a>
                  
                  </li>

                  <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">DG Patna</span></li>
  
                  <li class="nav-item">
                      <a class="nav-link menu-link collapsed" href="#sidebarLayouts" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarLayouts">
                          <i class="ti ti-layout-board"></i> <span data-key="t-layouts">Blog Posts</span> <span class="badge badge-pill bg-danger" data-key="t-hot">New</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarLayouts">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="list_posts.php" class="nav-link" data-key="t-horizontal">All Posts</a>
                              </li>
                              <li class="nav-item">
                                  <a href="add_post.php" class="nav-link" data-key="t-detached">Add Post</a>
                              </li>
                              <li class="nav-item">
                                  <a href="#!" target="_blank" class="nav-link" data-key="t-hovered">Tags</a>
                              </li>
                          </ul>
                      </div>
                  </li>
                  <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-pages">Pages</span></li>

                  <li class="nav-item">
                      <a class="nav-link menu-link collapsed" href="#sidebarPages" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarPages">
                          <i class="ti ti-brand-adobe"></i> <span data-key="t-pages">Pages</span>
                      </a>
                      <div class="collapse menu-dropdown" id="sidebarPages">
                          <ul class="nav nav-sm flex-column">
                              <li class="nav-item">
                                  <a href="#!" class="nav-link" data-key="t-starter"> All Pages </a>
                              </li>
                              <li class="nav-item">
                                  <a href="#!" class="nav-link" data-key="t-profile"> Add Page </a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link menu-link" href="logout.php">
                          <i class="ti ti-lock"></i> <span data-key="t-widgets">Log Out</span>
                      </a>
                  </li>

              </ul>
          </div>
          <!-- Sidebar -->
      </div>

      <div class="sidebar-background"></div>
  </div>