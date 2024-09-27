<?php
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $survey_creator = $_SESSION['survey_creator'];
  $sql_survey_creator = "SELECT * FROM survey_creator WHERE ID = " . $survey_creator;
  $res_survey_creator = mysqli_query($con, $sql_survey_creator);
  $row_survey_creator = mysqli_fetch_assoc($res_survey_creator);
}
?>

<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0; padding-left:20px;">
            <img src="../assets/panel/images/logo1.png" alt="" width="80%" height="70%">

    </div>
    <div class="clearfix"></div>
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="../assets/panel/images/admin_image/<?php echo $row_survey_creator['Image']; ?>" alt="..."
          class="img-circle profile_img" style="object-fit: cover;">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2><?php echo $row_survey_creator['Name']; ?></h2>
      </div>
    </div>
    <br />
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <ul class="nav side-menu">
          <li><a href="dashboard.php"><i class="fa fa-home"></i> Home </a></li>
          <li><a href="survey_create.php"><i class="fa  fa-pencil-square-o"></i> Create Blank Survey </a></li>
          <li><a href="survey_template.php"><i class="fa fa-file-text-o"></i>Use Survey Template</a></li>
          <li><a href="survey.php"><i class="fa  fa-bar-chart"></i>View Survey </a></li>
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
            <img src="../assets/panel/images/admin_image/<?php echo $row_survey_creator['Image']; ?>"
              style="object-fit: cover;" height="30" width="30"><?php echo $row_survey_creator['Name'] ?>
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