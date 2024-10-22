<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  if (isset($_GET['survey_id'])) {
    $survey_id = $_GET['survey_id'];
    $sql_survey = "SELECT * FROM survey WHERE ID=$survey_id";
    $res_survey = mysqli_query($con, $sql_survey);
    $row_survey = mysqli_fetch_assoc($res_survey);
  }
  if (isset($_GET['surveyopen'])) {
    $open = $_GET['surveyopen'];
    $sql = "UPDATE survey SET status='open' WHERE ID = $open";
    $res = mysqli_query($con, $sql);
    header('location:survey_collect.php?survey_id=' . $open);
  }
  if (isset($_GET['surveyclose'])) {
    $close = $_GET['surveyclose'];
    $sql = "UPDATE survey SET status='close' WHERE ID = $close";
    $res = mysqli_query($con, $sql);
    header('location:survey_collect.php?survey_id=' . $close);
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
  <title>Survey Collect</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
  <style>
    .page-title {
      margin-bottom: 30px;
    }

    .title_left h3 {
      font-size: 2rem;
      margin-bottom: 15px;
    }

    .survey-buttons {
      margin-top: 20px;
    }

    .survey-buttons button {
      margin-right: 10px;
      padding: 10px 15px;
      font-size: 1rem;
    }

    .survey-link p {
      font-size: 1rem;
      word-break: break-all;
    }

    .survey-status {
      font-size: 1.2rem;
      margin-bottom: 10px;
    }

    @media (max-width: 768px) {
      .title_left h3 {
        font-size: 1.5rem;
      }

      .survey-buttons button {
        font-size: 0.9rem;
      }
    }

    @media (max-width: 576px) {
      .survey-buttons button {
        font-size: 0.8rem;
      }
    }
  </style>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('sidebar.php') ?>
      <div class="right_col" role="main">
        <div class="page-title">
          <div class="title_left">
            <h3>Surey Collect</h3>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="survey-link">
          <strong>Link:</strong>
          <p id="textToCopy" style="display:inline;border: #ccc 2px solid;padding: 7px 20px;">
            http://localhost/SurveyEase/survey.php?survey=<?php echo $row_survey['link']; ?></p>
          <button onclick="copyText()" class="btn btn-primary">Copy Link</button>
        </div>
        <div class="survey-status">
          <p>Status: <?php echo ucfirst($row_survey['status']); ?></p>
        </div>
        <div class="survey-buttons">
          <a href="survey_collect.php?surveyopen=<?php echo $survey_id; ?>"><button class="btn btn-success">Open
              Survey</button></a>
          <a href="survey_collect.php?surveyclose=<?php echo $survey_id; ?>"><button class="btn btn-danger">Close
              Survey</button></a>
          <a href="responces.php?survey_id=<?php echo $survey_id; ?>"><button class="btn btn-primary">View
              Analysis</button></a>
        </div>
      </div>
    </div>
  </div>
  </div>
  <script>
    function copyText() {
      var text = document.getElementById("textToCopy").innerText;
      var tempTextArea = document.createElement("textarea");
      tempTextArea.value = text;
      document.body.appendChild(tempTextArea);
      tempTextArea.select();
      document.execCommand("copy");
      document.body.removeChild(tempTextArea);
      alert("Copied the text: " + text);
    }
  </script>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
  <script src="../assets/panel/build/js/script.js"></script>
</body>

</html>