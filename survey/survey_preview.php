<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  header("location:index.php");
} else {
  if (!isset($_GET["survey_id"])) {
    header("location:survey_template.php");
  } else {
    $con = mysqli_connect("localhost", "root", "", database: "online_survey_system");
    $survey_id = $_GET['survey_id'];
    $sql_survey = "SELECT * FROM survey WHERE ID = $survey_id";
    $res_survey = mysqli_query($con, $sql_survey);
    $row_survey = mysqli_fetch_assoc($res_survey);
    $survey_id = $row_survey['ID'];
    $questions_array = json_decode($row_survey['questions'], true);
  }
}
?>
<html>

<head>
  <meta charset="utf-8">
  <title><?php echo $row_survey['name']; ?></title>
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">

  <link rel="stylesheet" href="../assets/user/main_web/style.css">
  <link rel="stylesheet" href="../assets/user/main_web/survey_que.css">
</head>

<style type="text/css">
  /* Button Styling */
  .survey-btn {
    display: inline-block;
    margin-left: 43%;
    margin-top: 0px;
    padding: 12px 30px;
    font-size: 16px;
    color: white;
    background-color: #007bff;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .survey-btn:hover {
    background-color: #0056b3;
    transform: scale(1.05);
  }

  .survey-btn:active {
    background-color: #004080;
  }
</style>

<body class="body">
  <div class="w-embed"></div>
  <div class="section-content padding-huge background-colour-grey">
    <div class="container-medium">

      <h2 class="text-align-center"><?php echo $row_survey['name']; ?></h2>

      <div class="spacer-small"></div>
      <div class="rte-container">
        <div class="text-rich-text w-richtext">
          <?php echo $row_survey['description']; ?>
        </div>
        <div>
          <a href="survey_collect.php?survey_id=<?php echo $survey_id; ?>" class="survey-btn">Open Survey</a>
        </div>
      </div>
      <div class="spacer-xsmall"></div>
      <div id="w-node-d56624f1-8cd0-cc75-908f-77b538d52263-2b908e23" class="rte-container">
        <div class="spacer-medium"></div>
        <div class="survey-template-questions-container container-small">
          <div class="text-rich-text padding-medium w-richtext">
            <?php
            $cnt = 1;
            foreach ($questions_array as $question_id) {
              $sql_que = "SELECT * FROM survey_questions WHERE que_id=$question_id";
              $res_que = mysqli_query($con, $sql_que);
              $row_que = mysqli_fetch_assoc($res_que);
              ?>
              <h3><?php echo $cnt . ". " . $row_que['question'] ?></h3>
              <p>The answer should be a
                <?php if ($row_que['answer_type'] == 'radio') {
                  echo 'single choice';
                } elseif ($row_que['answer_type'] == 'checkbox') {
                  echo 'multiple choice';
                } elseif (($row_que['answer_type'] == 'select')) {
                  echo 'Select box';
                } elseif (($row_que['answer_type'] == 'rating')) {
                  echo 'Rating';
                } else {
                  echo 'text input';
                } ?>
                :
              </p>
              <?php
              if ($row_que['answer_type'] == 'radio' || $row_que['answer_type'] == 'checkbox' || $row_que['answer_type'] == 'rating' || $row_que['answer_type'] == 'SELECT') {
                $sql_op = "SELECT * FROM question_option WHERE que_id = " . $row_que['que_id'] . " AND survey_id = $survey_id";
                $res_op = mysqli_query($con, $sql_op);
                $row_op = mysqli_fetch_assoc($res_op);
                $option_array = json_decode($row_op['options_id'], true);
                ?>

                <?php if ($row_que['answer_type'] == 'radio' || $row_que['answer_type'] == 'checkbox' || $row_que['answer_type'] == 'SELECT') {
                  ?>
                  <ol>
                  <?php
                  foreach ($option_array as $option_id) {
                    $sql_option = "SELECT * FROM survey_options WHERE op_id=$option_id";
                    $res_option = mysqli_query($con, $sql_option);
                    while ($row_option = mysqli_fetch_assoc($res_option)) {
                      ?>
                      <li><?php echo $row_option['options']; ?></li>
                    <?php }
                  }
                  ?>
                  </ol>
                  <?php
                } elseif ($row_que['answer_type'] == 'textarea') { ?>
                  <textarea name="<?php echo $row_que['que_id']; ?>" rows="5" cols="150"></textarea>
                <?php } else
                  if ($row_que['answer_type'] == 'rating') {
                    for ($i = 1; $i <= $option['options']; $i++) {
                      echo "<input type='radio' name='" . $option['op_id'] . "' value='" . $i . "'> <span style='margin-right: 30px;'>$i</span>";
                    }
                  } else {
                    ?>
                    <input type="<?php echo $row_que['answer_type'] ?>" name="<?php echo $row_que['que_id']; ?>">
                  <?php }
              } ?>
              <?php
              $cnt++;

            } ?>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  </div>
  </div>
</body>

</html>