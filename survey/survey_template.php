<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $sql_category = "SELECT * FROM survey_category";
  $res_category = mysqli_query($con, $sql_category);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Survey Template</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('sidebar.php') ?>
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left" style="width:45% !important">
              <h3>Survey Templates</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12">
              <div class="x_panel">
                <?php while ($row = mysqli_fetch_assoc($res_category)) { ?>
                  <div class="x_title">
                    <h2> <?php echo $row['Category']; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <?php
                      $sql_survey = "SELECT * FROM survey_templates WHERE Template_category = " . $row['ID'];
                      $res_survey = mysqli_query($con, $sql_survey);
                      ?>
                      <?php while ($row_sur = mysqli_fetch_assoc($res_survey)) { ?>
                        <a href="template_view.php?template_id=<?php echo $row_sur['ID']; ?>">
                          <div class="col-md-55">
                            <div class="thumbnail">
                              <div class="image view view-first">
                                <img style="width: 100%; display: block;"
                                  src="../assets/panel/Images_Survey/<?php echo $row_sur['Template_image']; ?>"
                                  alt="image" />
                              </div>
                              <div class="caption">
                                <h6><?php echo $row_sur['Template_name']; ?></h6>
                              </div>
                        </a>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="pull-right">
      Copyright &copy; 2024 <a href="../../SurveyEase/">SurveyEase</a>
    </div>
    <div class="clearfix"></div>
  </footer>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>