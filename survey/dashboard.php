<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $survey_creator_id = $_SESSION['survey_creator'];
  $sql_survey = "SELECT * FROM survey WHERE creator_id=$survey_creator_id;";
  $res_survey = mysqli_query($con, $sql_survey);
  $count_survey = mysqli_num_rows($res_survey);

  $sql_template = "SELECT * FROM survey WHERE creator_id=$survey_creator_id AND status='open';";
  $res_template = mysqli_query($con, $sql_template);
  $count_template = mysqli_num_rows($res_template);

  $sql_creator = "SELECT * FROM survey WHERE creator_id=$survey_creator_id AND status='close'";
  $res_creator = mysqli_query($con, $sql_creator);
  $count_creator = mysqli_num_rows($res_creator);
  $sur_sql = "SELECT * FROM survey WHERE creator_id=$survey_creator_id AND status='open' ORDER BY Create_at DESC LIMIT 5";
  $sur_res = mysqli_query($con, $sur_sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Survey Creator | Dashboard</title>
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
                <div class="icon"><i class="fa fa-th-list"></i></div>
                <div class="count"><?php echo $count_survey; ?></div>
                <h4>Survey</h4>
                <p>Total Surveys Created</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-edit"></i></div>
                <div class="count"><?php echo $count_template; ?></div>
                <h4>Open Surveys</h4>
                <p>Survey is Analysing</p>
              </div>
            </div>
            <div class="animated flipInY col-lg-4 col-md-4 col-sm-6 ">
              <div class="tile-stats">
                <div class="icon"><i class="fa fa-check-square-o"></i></div>
                <div class="count"><?php echo $count_creator; ?></div>
                <h4>Completed Survey</h4>
                <p>Survey was analysed</p>
              </div>
            </div>
          </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Recent Survey</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Survey Name</th>
                              <th>Survey Created At</th>
                              <th>Collect</th>
                              <th>Analysis</th>
                              <th>Response Chart</th> <!-- Add chart column -->
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $cnt = 1;
                            while ($row = mysqli_fetch_assoc($sur_res)) {
                              ?>
                              <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['Create_at']; ?></td>
                                <td><a href="survey_collect.php?survey_id=<?php echo $row['ID']; ?>"><i
                                      class="fa fa-paper-plane-o"></i></a></td>
                                <td><a href="responces.php?survey_id=<?php echo $row['ID']; ?>"><i
                                      class="fa fa-pie-chart"></i></a></td>
                                <td>
                                  <?php
                                  // Get response data by survey
                                  $sql_chart = "SELECT DATE(submit_at) as submit_date, COUNT(user_id) as user_count 
                                                FROM responces_by 
                                                WHERE survey_id = ".$row['ID']." 
                                                GROUP BY DATE(submit_at)";
                                  $res_chart = mysqli_query($con,$sql_chart);
                                  $chart_dates = [];
                                  $chart_counts = [];
                                  while ($row_chart = mysqli_fetch_assoc($res_chart)){
                                    $chart_dates[] = $row_chart['submit_date'];
                                    $chart_counts[] = $row_chart['user_count'];
                                  }
                                  ?>
                                  <canvas class="surveyChart" data-dates='<?php echo json_encode($chart_dates); ?>' 
                                          data-counts='<?php echo json_encode($chart_counts); ?>' width="400" height="150">
                                  </canvas>
                                </td>
                              </tr>
                              <?php $cnt++;
                            } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>

  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/Chart.js/dist/Chart.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
  <script src="../assets/panel/vendors/DateJS/build/date.js"></script>
  <script src="../assets/panel/vendors/moment/min/moment.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>

  <script>
    // Loop through each canvas with class 'surveyChart'
    document.querySelectorAll('.surveyChart').forEach(function(canvas) {
      // Get the dates and counts from the canvas data attributes
      var dates = JSON.parse(canvas.getAttribute('data-dates'));
      var counts = JSON.parse(canvas.getAttribute('data-counts'));

      var ctx = canvas.getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: dates,
          datasets: [{
            label: 'User Responses',
            data: counts,
            borderColor: 'rgba(75, 192, 192, 1)',
            fill: false,
            tension: 0.1
          }]
        },
        options: {
          scales: {
            x: {
              type: 'time',
              time: {
                unit: 'day'
              },
              title: {
                display: true,
                text: 'Date'
              }
            },
            y: {
              title: {
                display: true,
                text: 'Number of Responses'
              }
            }
          }
        }
      });
    });
  </script>
</body>

</html>
