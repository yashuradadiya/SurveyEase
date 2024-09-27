<style type="text/css">
  .top-bar_nav {
    padding: 0px;
  }

  .top-bar_nav {
    z-index: 0;
  }

  .nav {
    padding-top: 10px !important;
    padding-bottom: 20px !important;
    background-color: white;
    /*        background: rgb(232,233,235);*/
    /*        background: linear-gradient(0deg, rgba(232,233,235,0.37) 0%, rgba(255,255,255,0) 100%);*/
    /*        position: sticky; /* Make the header sticky */
    */ top: 0;
    /* Stick to the top of the viewport */
    z-index: 1000;
    /* Ensure it is above other content */
  }

  .button {
    color: white !important;
  }

  /* Style for dropdown */
  .nav-dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-list {
    display: none;
    position: absolute;
    background-color: white;
    min-width: 160px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
    z-index: 1;
    margin-top: 0px;
  }

  .dropdown-list a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
  }

  .dropdown-list a:hover {
    background-color: #f1f1f1;
  }

  /* Show the dropdown menu on hover */
  .nav-dropdown:hover .dropdown-list {
    display: block;
  }

  .nav-dropdown-toggle {
    cursor: pointer;
  }
</style>


<body class="body">
  <div class="page-wrapper">
    <main class="main-wrapper no-overflow">
      <div class="nav-control">
        <div class="nav w-nav" role="banner" data-doc-height="1">
          <div class="top-bar_nav m-0"></div>
          <div class="nav-content-block">
            <div class="container-medium ">
              <a href="./index.php" class="logo w-nav-brand w--current" aria-label="home">
                <img loading="lazy" width="200" height="" src="assets/user/main_web/image/logo.png"
                  alt="SmartSurvey logo.">
              </a>
              <nav role="navigation" class="nav-menu is-static w-nav-menu">
                <a href="./index.php" class="nav-link is-main-nav w-nav-link">Home</a>

                <!-- Dropdown for Templates -->
                <div class="nav-dropdown">
                  <div class="nav-dropdown-toggle" id="w-dropdown-toggle-2">
                    Templates
                  </div>
                  <div class="dropdown-list">
                    <a href="./customer.php">Customer</a>
                    <a href="./education.php">Education</a>
                    <a href="./employee.php">Employee</a>
                    <a href="./events.php">Events</a>
                    <a href="./hospitality.php">Hospitality</a>
                    <a href="./all_template.php">All Categories</a>
                  </div>
                </div>

                <!-- Example: Adding dropdown to About Us -->
                <a href="./aboutus.php" class="nav-link is-main-nav w-nav-link">About us</a>

                <a href="./blog.php" class="nav-link is-main-nav w-nav-link">Blog</a>
                <a href="./contact.php" class="nav-link is-main-nav w-nav-link">Contact Us</a>
                <div class="nav-button-wrapper hide-tablet">
                  <a href="./survey/" class="button is-small wide-button w-button">Create Survey</a>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>