<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "online_survey_system");
if (!isset($_SESSION['user_id'])) {
  $_SESSION['redirect_to'] = $_GET['survey'];
  header("Location:login.php");
} else {
  if (isset($_GET['survey'])) {
    $survey_link = $_GET['survey'];
    $sql_survey = "select * from survey where link = '$survey_link'";
    $res_survey = mysqli_query($con, $sql_survey);
    $row_survey = mysqli_fetch_assoc($res_survey);
    if ($row_survey['status'] == 'close') {
      $header = "survey";
      $title = "Survey Closed";
      $msg = "This survey is currently closed.";
    } else {
      $questions_array = json_decode($row_survey['questions'], true);
      $_SESSION['questions_array'] = $questions_array;
      $_SESSION['survey_id'] = $row_survey['ID'];
    }
  } else {
    header("Location: index.php");
  }
  if (isset($_POST['submit'])) {
    $survey_id = $_SESSION['survey_id'];
    $user_id = $_SESSION['user_id'];
    $questions_array = $_SESSION['questions_array'];
    $sql_res_by = "INSERT INTO responces_by (survey_id,user_id) VALUES ($survey_id,$user_id)";
    $res_by = mysqli_query($con, $sql_res_by);
    $responce_by = mysqli_insert_id($con);
    foreach ($questions_array as $question_id) {
      $responce = $_POST[$question_id];
      $sql_res = "INSERT INTO responces (responce_by,question_id,responce) VALUES ($responce_by,$question_id,'$responce')";
      $res_res = mysqli_query($con, $sql_res);
    }
    header("Location: thank-you.php");

  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $row_survey['name']; ?></title>
  <link href="assets/user/style_responces.css" rel="stylesheet">
</head>

<body>
  <div id="header-color">
    <div class="que_container">
      <h2 class="custom_header"><?php if (@$header) {
        echo $header;
      } else {
        echo $row_survey['name'];
      } ?></h2>
    </div>
  </div>
  <div class="que_container">
    <?php if (!@$msg) { ?>
      <div class="que_title">
        <h3 class="custom_sec_header">Demographic Information</h3>
        <hr>
      </div>
      <div class="greeting">
        <p><?php echo $row_survey['description']; ?></p>
      </div>
      <form method="post" enctype="multipart/form-data">
        <div>
          <?php
          $cnt = 1;
          foreach ($questions_array as $question_id) {
            $sql_que = "select * from survey_questions where que_id=$question_id";
            $res_que = mysqli_query($con, $sql_que);
            $row_que = mysqli_fetch_assoc($res_que);
            ?>
            <div>
              <div>
                <h3><?php echo $cnt . ". " . $row_que['question'] ?></h3>
                <?php
                if ($row_que['answer_type'] == 'radio' || $row_que['answer_type'] == 'checkbox' || $row_que['answer_type'] == 'rating' || $row_que['answer_type'] == 'select') {

                  $sql_option = "select * from survey_options where que_id=" . $row_que['que_id'];
                  $res_option = mysqli_query($con, $sql_option);

                  ?>
                  <?php if ($row_que['answer_type'] == 'radio' || $row_que['answer_type'] == 'checkbox') {
                    while ($row_option = mysqli_fetch_assoc($res_option)) {
                      ?>
                      <div class="custom_options">
                        <input type="<?php echo $row_que['answer_type']; ?>" name="<?php echo $row_que['que_id']; ?>"
                          value="<?php echo $row_option['op_id']; ?>">
                        <span><?php echo $row_option['options']; ?></span>
                      </div>
                    <?php }
                  } elseif ($row_que['answer_type'] == 'select') { ?>
                    <select name="<?php echo $row_que['que_id']; ?>" id="">
                      <?php while ($row_option = mysqli_fetch_assoc($res_option)) { ?>
                        <option value="<?php echo $row_option['op_id']; ?>"><?php echo $row_option['options']; ?></option>
                      <?php } ?>
                    </select>
                    <?php
                  }
                  ?>
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
                  <?php } ?>
              </div>
            </div>
            <?php
            $cnt++;
          } ?>
          <input type="submit" value="save" name="submit">
        </div>
      </form>
    <?php } else { ?>
      <div style="text-align: center;">
        <h2> <?php echo $title; ?></h2>
        <h5> <?php echo $msg; ?></h5>
      </div>
    <?php } ?>
  </div>
</body>

</html>