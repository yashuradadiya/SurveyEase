<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
  exit;
}

if (!isset($_GET["template_id"])) {
  header("location:survey_template.php");
  exit;
}

$template_id = $_GET["template_id"];
$con = mysqli_connect("localhost", "root", "", "online_survey_system");

$sql_template = "SELECT * FROM survey_templates WHERE ID = $template_id";
$res_template = mysqli_query($con, $sql_template);
$template = mysqli_fetch_array($res_template);

$sql_questions = "SELECT * FROM survey_questions WHERE template_id=$template_id AND created_by='admin'";
$res_questions = mysqli_query($con, $sql_questions);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $template['Template_name']; ?></title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
  <style>
    .x_title h2 {
      font-size: 16px;
      word-spacing: 3px;
      letter-spacing: 0.1px;
      font-weight: 450;
      line-height: 20px;
    }

    .x_content {
      font-size: 16px;
      word-spacing: 3px;
      letter-spacing: 0.1px;
      font-weight: 450;
      line-height: 25px;
    }

    .ans {
      width: 70%;
      padding: 5px 20px;
      margin-bottom: 8px;
      box-sizing: border-box;
    }
    /* Styling for the button */
.btn-template {
    background-color: blue; /* Blue background */
    color: white;
    border: none; /* Remove border */
    padding: 10px 20px; /* Padding around the button */
    border-radius: 5px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    transition: background-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
/*    display: inline-block; /* Ensure it remains inline */*/
}

/* Hover effect for button */
.btn-template:hover {
    background-color: blue; /* Darker blue on hover */
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15); /* Increase shadow on hover */
    color: white;
}

/* Styling for the link inside the button */
.btn-link {
  display: inline !important;
  float: right;
    color: white; /* White text */
    text-decoration: none; /* Remove underline from the link */
    font-weight: 600; /* Bold text */
    font-size: 16px; /* Font size */
    display: block; /* Ensure the link fills the button */
}

/* Change text color on hover */
.btn-link:hover {
    color: #; /* Yellow text on hover */
}

  </style>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('sidebar.php') ?>

      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left" style="width: 100%;">
              <h3 style="display: inline;"><?php echo $template['Template_name']; ?></h3>
             
                  <a href="survey_create.php?template_id=<?php echo $template['ID']; ?>" class="btn-link"> <button class="btn-template">UseTemplate  </button></a>
             

            </div>
          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2 style="text-wrap: wrap;"><?php echo $template['Template_description']; ?></h2>
                  <div class="clearfix"></div>
                </div>

                <div class="x_content">
                  <?php
                  $que_cnt = 0;
                  while ($row = mysqli_fetch_assoc($res_questions)) {
                    $que_cnt++;
                    echo "<div class='questions' style='font-size: 18px;font-weight: bold;'>" . $que_cnt . ". " . $row['question'] . "<br></div>";
                    ?>
                    <p>The answer should be a
                      <?php if ($row['answer_type'] == 'radio') {
                        echo 'single choice';
                      } elseif ($row['answer_type'] == 'checkbox') {
                        echo 'multiple choice';
                      } elseif (($row['answer_type'] == 'select')) {
                        echo 'Select box';
                      } elseif (($row['answer_type'] == 'rating')) {
                        echo 'Rating';
                      } else {
                        echo 'text input';
                      } ?>
                      :
                    </p>
                    <?php
                    $sql_option = "SELECT * FROM survey_options WHERE que_id=" . $row['que_id'];
                    $res_option = mysqli_query($con, $sql_option);

                    if (mysqli_num_rows($res_option) > 0) {
                      if ($row['answer_type'] == 'radio' || $row['answer_type'] == 'checkbox') {
                        while ($option = mysqli_fetch_assoc($res_option)) {
                          echo "<div class='custom_options' style='line-height: 30px;padding-left: 20px;'>";
                          echo "<input type='" . $row['answer_type'] . "' name='" . $row['que_id'] . "' value='" . $option['op_id'] . "'>";
                          echo "<span style='padding-left: 10px;'>" . $option['options'] . "</span></div>";
                        }
                      } elseif ($row['answer_type'] == 'select') {
                        echo "<select name='" . $row['que_id'] . "'>";
                        while ($option = mysqli_fetch_assoc($res_option)) {
                          echo "<option value='" . $option['op_id'] . "'>" . $option['options'] . "</option>";
                        }
                        echo "</select>";
                      } elseif ($row['answer_type'] == 'rating') {
                        $option = mysqli_fetch_assoc($res_option);
                        for ($i = 1; $i <= $option['options']; $i++) {
                          echo "<input type='radio' name='" . $option['op_id'] . "' value='" . $i . "'> <span style='margin-right: 30px;'>$i</span>";
                        }
                      }
                    } else {
                      echo "<input type='text' name='text_" . $row['que_id'] . "' class='ans' placeholder='Enter your answer here'>";
                    }
                    echo "<br><br>";
                  }
                  ?>
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
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>