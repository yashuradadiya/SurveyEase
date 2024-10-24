<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");

  $sql_survey = "SELECT * FROM survey;";
  $res_survey = mysqli_query($con, $sql_survey);
  $count_survey = mysqli_num_rows($res_survey);

  $sql_template = "SELECT * FROM survey_templates;";
  $res_template = mysqli_query($con, $sql_template);
  $count_template = mysqli_num_rows($res_template);

  $sql_creator = "SELECT * FROM survey_creator;";
  $res_creator = mysqli_query($con, $sql_creator);
  $count_creator = mysqli_num_rows($res_creator);

  $chart_date = [];
  $chart_count = [];
  $sql_chart = "SELECT DATE(Create_at) as date, COUNT(*) as count FROM survey GROUP BY DATE(Create_at) ORDER BY DATE(Create_at) DESC LIMIT 7";
  $res_chart = mysqli_query($con, $sql_chart);
  while ($row = mysqli_fetch_assoc($res_chart)) {
    $chart_date[] = $row['date'];
    $chart_count[] = $row['count'];
  }
  $chart_categoty = [];
  $chart_template = [];
  $sql_cat = "SELECT * FROM survey_category";
  $res_cat = mysqli_query($con, $sql_cat);
  while ($row_cat = mysqli_fetch_assoc($res_cat)) {
    $sql_count = "SELECT COUNT(*) AS count_tem FROM survey_templates WHERE Template_category = " . $row_cat['ID'];
    $res_count = mysqli_query($con, query: $sql_count);
    $row_count = mysqli_fetch_assoc($res_count);
    $chart_categoty[] = $row_cat['Category'];
    $chart_template[] = $row_count['count_tem'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin | Dashboard</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('sidebar.php') ?>
      <div class="right_col" role="main">
        <div class="row" style="display: block;">
          <div class="top_tiles">
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
              <div class="tile-stats">
                <div class="icon"><i class="fa  fa-area-chart"></i></div>
                <div class="count"><?php echo $count_survey; ?></div>
                <h4>Survey</h4>
                <p>Total Surveys Created</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-list-alt"></i></div>
                <div class="count"><?php echo $count_template; ?></div>
                <h4>Template</h4>
                <p>Total Templates Available</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count"><?php echo $count_creator; ?></div>
                <h4>Survey Creator</h4>
                <p>Total Active Survey Creator</p>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-md-8   col-sm-12 ">
            <div class="dashboard_graph x_panel">
              <div class="x_title">
                <h4>Survey</h4>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <canvas id="SurveyChart" style="width:100%;padding:10px;"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-4   col-sm-12 ">
            <div class="dashboard_graph x_panel">
              <div class="x_title">
                <h4>Survey Category</h4>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <canvas id="categoryChart" style="width:100px;height: 110px;padding:10px;"></canvas>
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
    </div>
  </div>
  <script>
    const xValues = <?php echo json_encode($chart_date); ?>;
    const yValues = <?php echo json_encode($chart_count); ?>;
    new Chart("SurveyChart", {
      type: "line",
      data: {
        labels: xValues,
        datasets: [{
          fill: false,
          lineTension: 0,
          backgroundColor: "rgba(26, 187, 156, 1)",
          borderColor: "rgba(26, 187, 156, 0.3)",
          data: yValues
        }]
      },
      options: {
        scales: {
          y: {
            ticks: {
              callback: function (value) {
                return Number.isInteger(value) ? value : null;
              },
              stepSize: 1
            }
          }
        },
        legend: { display: false }
      }
    });

    const xValue = <?php echo json_encode($chart_categoty); ?>;
    const yValue = <?php echo json_encode($chart_template); ?>;
    const barColors = [
      "#FF6F61",
      "#00aba9",
      "#88B04B",
      "#F7CAC9",
      "#92A8D1",
      "#955251",
      "#B565A7",
      "#009B77",
      "#DD4124"
    ];
    new Chart("categoryChart", {
      type: "doughnut",
      data: {
        labels: xValue,
        datasets: [{
          backgroundColor: barColors,
          data: yValue
        }]
      }
    });
  </script>


  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/Chart.js/dist/Chart.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../assets/panel/vendors/DateJS/build/date.js"></script>
  <script src="../assets/panel/vendors/moment/min/moment.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>