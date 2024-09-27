<?php
session_start();
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile - Admin</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include("sidebar.php"); ?>
      <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Profile</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-3 col-sm-3  profile_left">
                    <div class="profile_img">
                      <div id="crop-avatar">
                        <img class="img-responsive avatar-view"
                          src="../assets/panel/images/admin_image/<?php echo $row_admin['Image']; ?>" alt="Avatar"
                          title="Change the avatar" style="width: 220px; height: 220px; object-fit: cover;">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-9 col-sm-9 ">
                    <h3><?php echo $row_admin['Name']; ?></h3>
                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $row_admin['Address']; ?>
                      </li>
                      <li><i class="fa  fa-envelope user-profile-icon"></i> <?php echo $row_admin['Email']; ?>
                      </li>
                      <li><i class="fa fa-phone user-profile-icon"></i> <?php echo $row_admin['Contact']; ?>
                      </li>
                    </ul>
                    <a class="btn btn-success" href="profile-setting.php"><i class="fa fa-edit m-right-xs"></i>Edit
                      Profile</a>
                    <br />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer>
        <div class="pull-right">
        </div>
        <div class="clearfix"></div>
      </footer>
    </div>
  </div>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/vendors/raphael/raphael.min.js"></script>
  <script src="../assets/panel/vendors/morris.js/morris.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../assets/panel/vendors/moment/min/moment.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>