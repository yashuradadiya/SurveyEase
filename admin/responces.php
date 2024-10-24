<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
} elseif (!isset($_GET['survey_id'])) {
  header("location:surveys.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $survey_id = $_GET['survey_id'];
  $sql_survey = "SELECT questions FROM survey WHERE ID = $survey_id";
  $res_survey = mysqli_query($con, $sql_survey);
  $row_survey = mysqli_fetch_assoc($res_survey);
  $sql_by = "SELECT * FROM responces_by WHERE survey_id=$survey_id";
  $res_by = mysqli_query($con, $sql_by);
  $row_cnt = mysqli_num_rows($res_by);
  if ($row_cnt > 0) {
    $question_ids = implode(',', json_decode($row_survey['questions'], true));
    $sql = "SELECT sq.que_id, sq.question, sq.answer_type , sr.responce 
      FROM survey_questions sq 
      LEFT JOIN responces sr ON sq.que_id = sr.question_id 
      WHERE sq.que_id IN ($question_ids)
      ORDER BY sq.que_id";
    $result = mysqli_query($con, $sql);
    $questions_responses = [];
    while ($row = mysqli_fetch_assoc($result)) {
      $questions_responses[$row['que_id']]['question'] = $row['question'];
      $questions_responses[$row['que_id']]['answer_type'] = $row['answer_type'];
      $questions_responses[$row['que_id']]['responses'][] = $row['responce'];
      $total_responses[$row['que_id']] = $total_responses[$row['que_id']] ?? 0;
      $total_responses[$row['que_id']]++;
    }
  } else {
    $msg = "No Responces Yet.";
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

  <title>Admin | Survey Responce</title>

  <link href="css/jquery.dataTables.min.css">
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>
<style>
  .x_title h2 {
    font-size: 24px;
    font-weight: bold;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
    margin-bottom: 20px;
  }

  #msg {
    color: #ff4f4f;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .card-box {
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    margin-bottom: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .card-box strong {
    font-size: 18px;
    color: black;
    margin-bottom: 10px;
    display: block;
  }

  .progress {
    height: 20px;
    border-radius: 10px;
    background-color: #e9ecef;
    margin-bottom: 10px;
  }

  .progress-bar-striped {
    background-color: #2a3f54;
    border-radius: 10px;
    text-align: center;
    color: white;
    font-size: 12px;
  }

  ul {
    list-style: none;
    padding: 0;
  }

  li {
    font-size: 14px;
  }

  .que li {
    padding: 10px;
    background-color: #f1f1f1;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
  }

  .table-responsive {
    margin-top: 20px;
  }
</style>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php
      include("sidebar.php");
      ?>
      <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Responces</h2>
                  <div class="clearfix"></div>
                </div>
                <div>
                  <?php
                  echo @$msg;
                  ?>
                </div>
                <?php
                if ($row_cnt > 0) {
                  foreach ($questions_responses as $que_id => $data) { ?>
                    <div class="x_content">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="card-box table-responsive">
                            <div>
                              <div>
                                <strong>
                                  <?php echo $data['question']; ?>
                                </strong>
                              </div>
                              <div>
                                <ul>
                                  <?php
                                  if (!empty($data['responses'])) {
                                    $answer_type = $data['answer_type'];
                                    if (in_array($answer_type, ['radio', 'select', 'rate'])) {
                                      $question_id = $que_id;
                                      $optionsQuery = "SELECT so.options, COUNT(r.responce) AS count
                                      FROM survey_options so
                                      LEFT JOIN responces r ON r.responce = so.op_id AND r.question_id = so.que_id
                                      WHERE so.que_id = '$question_id'
                                      GROUP BY so.op_id
                                      ";
                                      $optionsResult = mysqli_query($con, $optionsQuery);
                                      while ($option = mysqli_fetch_assoc($optionsResult)) {
                                        $option_text = $option['options'];
                                        $response_count = $option['count'] ?: 0;
                                        $percentage = ($response_count / ($total_responses[$que_id] ?: 1)) * 100;
                                        $options_count[$que_id][] = [
                                          'option' => $option_text,
                                          'count' => $response_count,
                                          'percentage' => $percentage
                                        ];
                                        ?>
                                        <li style="display: flex;">
                                          <div style="width: 100%;">
                                            <?php echo $option_text ?>
                                          </div>
                                          <div class="progress" style="width: 100%;">
                                            <div class="progress-bar-striped " role="progressbar"
                                              style="width: <?php echo $percentage; ?>%; display: flex;  flex-direction: column;  justify-content: center;  color: #fff;  text-align: center;  white-space: nowrap;  background-color: $progress-bar-bg;  @include transition($progress-bar-transition);"
                                              aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100">
                                              <?php echo round($percentage, 2); ?>%
                                            </div>
                                          </div>
                                        <?php }
                                    } else { ?>
                                        <ul class="que">
                                          <?php
                                          foreach ($data['responses'] as $response) {
                                            ?>
                                            <li><?php echo "Response: " . ($response ?? 'No response'); ?></li>
                                          <?php } ?>
                                        </ul>
                                      </li>
                                      <?php
                                    }
                                  }
                                  ?>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php }
                } ?>
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
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/vendors/iCheck/icheck.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../assets/panel/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../assets/panel/vendors/jszip/dist/jszip.min.js"></script>
  <script src="../assets/panel/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../assets/panel/vendors/pdfmake/build/vfs_fonts.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>