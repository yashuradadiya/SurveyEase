<?php
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $admin_id = $_SESSION['admin_id'];
  $sql_admin = "SELECT * FROM admin WHERE ID = " . $admin_id;
  $res_admin = mysqli_query($con, $sql_admin);
  $row_admin = mysqli_fetch_assoc($res_admin);
}
?>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0; padding-left:20px ;">
      <img src="../assets/panel/images/logo1.png" alt="" width="80%" height="70%">

    </div>
    <div class="clearfix"></div>
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="../assets/panel/images/admin_image/<?php echo $row_admin['Image']; ?>" alt="..." class="img-circle profile_img"
          style="object-fit: cover;">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $row_admin['Name']; ?></h2>
      </div>
    </div>
    <br />
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a></li>
          <li><a href="survey_creator.php"><i class="fa fa-user"></i> Survey Creator </a></li>
          <li><a><i class="fa  fa-bar-chart"></i> Tempalates <span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu">
              <li><a href="survey_template.php">All Template</a></li>
              <li><a href="survey_creation.php">Template Creation</a></li>
            </ul>
          </li>
          <li><a href="surveys.php"><i class="fa fa-paper-plane"></i>Collected Survey </a></li>
          <li><a href="feedback.php"><i class="fa fa-question-circle"></i>FeedBack & Queries</a></li>
          <li><a href="contactus.php"><i class="fa fa-question-circle"></i>Conatact Us</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="top_nav">
  <div class="nav_menu">
    <div class="nav toggle">
      <a id="menu_toggle"><i class="fa fa-bars"></i></a>
    </div>
    <nav class="nav navbar-nav">
      <ul class=" navbar-right">
        <li class="nav-item dropdown open" style="padding-left: 15px;">
          <a href="profile.php" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown"
            data-toggle="dropdown" aria-expanded="false">
            <img src="../assets/panel/images/admin_image/<?php echo $row_admin['Image']; ?>" style="object-fit: cover;" height="30"
              width="30"><?php echo $row_admin['Name'] ?>
          </a>
          <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="profile.php"> Profile</a>
            <a class="dropdown-item" href="logout.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
          </div>
        </li>
        <li role="presentation" class="nav-item dropdown open">
        </li>
      </ul>
    </nav>
  </div>
</div>