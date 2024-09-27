<?php
session_start();
if (!isset($_SESSION['survey_creator'])) {
  if (isset($_GET["template_id"])) {
    @$_SESSION['user_template'] = "survey_create.php?template_id=" . $_GET["template_id"];
  }
  header("location:index.php");
} else {
  if (isset($_SESSION['user_template'])) {
    unset($_SESSION['user_template']);
  }
  $survey_creator = $_SESSION['survey_creator'];
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $sql_category = "SELECT * FROM survey_category";
  $res_category = mysqli_query($con, $sql_category);

  if (isset($_GET['template_id'])) {
    @$template_id = $_GET['template_id'];
    $sql_template = "SELECT * FROM survey_templates WHERE ID=$template_id";
    $res_template = mysqli_query($con, $sql_template);
    $row_template = mysqli_fetch_assoc($res_template);
    $sql_questions = "SELECT * FROM survey_questions WHERE template_id=$template_id";
    $res_questions = mysqli_query($con, $sql_questions);
    if (isset($_POST['save'])) {
      $survey_name = $_POST['survey_name'];
      $survey_description = $_POST['survey_default_descripton'];
      $existing_questions = [];
      $existing_options = [];
      while ($row_questions = mysqli_fetch_assoc($res_questions)) {
        $existing_questions[$row_questions['que_id']] = [
          'question' => $row_questions['question'],
          'answer_type' => $row_questions['answer_type']
        ];
        $sql_options = "SELECT * FROM survey_options WHERE que_id={$row_questions['que_id']} AND added_by = 'admin'";
        $res_options = mysqli_query($con, $sql_options);
        while ($row_options = mysqli_fetch_assoc($res_options)) {
          $existing_options[$row_options['op_id']] = [
            'option' => $row_options['options'],
            'question_number' => $row_options['que_id']
          ];
        }
      }
      $arr = $_POST;
      $submitted_questions = [];
      $submiteed_options = [];
      foreach ($arr as $key => $value) {
        if (preg_match('/^question(\d+)$/', $key, $matches)) {
          $question_number = $matches[1];
          $question_text = $value;
          $answer_type = $arr["anstype$question_number"];
          $submitted_questions[$question_number] = [
            'question' => $question_text,
            'answer_type' => $answer_type
          ];
          $sql_ques = "SELECT * FROM survey_questions WHERE template_id=$template_id AND question='$question_text'";
          $res_ques = mysqli_query($con, $sql_ques);
          while ($row_ques = mysqli_fetch_assoc($res_ques)) {
            $sql_options = "SELECT * FROM survey_options WHERE que_id={$row_ques['que_id']} AND added_by = 'admin'";
            foreach ($arr as $opt_key => $opt_value) {
              $sel_que = $row_ques['que_id'];
              if (preg_match("/^question{$question_number}_option(\d+)$/", $opt_key)) {
                $submiteed_options[] = [
                  'option' => $opt_value,
                  'question_number' => $sel_que
                ];
              }
            }
          }
        }
      }
      $question_array_for_insert = [];
      foreach ($submitted_questions as $number => $question) {
        if (!in_array($question, $existing_questions)) {
          $sql_insert = "INSERT INTO survey_questions (template_id, question, answer_type,created_by) VALUES ($template_id, '{$question['question']}', '{$question['answer_type']}',$survey_creator)";
          $res_insert = mysqli_query($con, $sql_insert);
          $question_id = mysqli_insert_id($con);
          $sub_que_id = $number;
          foreach ($arr as $opt_key => $opt_value) {
            if (preg_match("/^question{$sub_que_id}_option(\d+)$/", $opt_key)) {
              $sql_option = "INSERT INTO survey_options (que_id, options,added_by) VALUES ($question_id, '$opt_value',$survey_creator)";
              $res_option = mysqli_query($con, $sql_option);
            }
          }
        }
        $que_sql = "SELECT * FROM survey_questions WHERE question='" . $question['question'] . "' AND template_id = $template_id";
        $que_res = mysqli_query($con, $que_sql);
        $que_row = mysqli_fetch_assoc($que_res);
        $question_array_for_insert[] = $que_row['que_id'];
      }

      foreach ($submiteed_options as $number => $option) {
        if (!in_array($option, $existing_options)) {
          $sql_option = "INSERT INTO survey_options (que_id, options,added_by) VALUES ({$option['question_number']}, '{$option['option']}',$survey_creator)";
          $res_option = mysqli_query($con, $sql_option);
        }
        $sql_optiones = "SELECT * FROM survey_options WHERE que_id =  {$option['question_number']} AND options = '{$option['option']}'";
        $res_optiones = mysqli_query($con, $sql_optiones);
        $row_optiones = mysqli_fetch_assoc($res_optiones);
        $submiteed_options[$number]['option_id'] = $row_optiones['op_id'];

      }
      function generateRandomPattern($length = 6)
      {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($characters), 0, $length);
      }
      $link = generateRandomPattern();
      $arr_que = implode(',', $question_array_for_insert);
      $sql_surveys = "INSERT INTO survey (template_id,creator_id,name,description,questions,link,status) VALUES ($template_id,$survey_creator,'$survey_name','$survey_description','[$arr_que]','$link','open');";
      $res_surveys = mysqli_query($con, $sql_surveys);
      $surveys_ids = mysqli_insert_id($con);
      $grouped_options = [];
      foreach ($submiteed_options as $item) {
        $grouped_options[$item['question_number']][] = $item['option_id'];
      }
      foreach ($grouped_options as $question_number => $options_ids) {
        $options_ids_string = "[" . implode(',', $options_ids) . "]";
        $sql = "INSERT INTO question_option (que_id, options_id, survey_id) VALUES ('$question_number', '$options_ids_string', '$surveys_ids')";
        mysqli_query($con, $sql);
      }
      header('location:survey_preview.php?survey_id=' . $surveys_ids);

    }
  }
  if (isset($_POST['submit'])) {
    @$name = @$_POST['survey_name'];
    @$des_def = @$_POST['survey_default_descripton'];
    function generateRandomPattern($length = 6)
    {
      $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      return substr(str_shuffle($characters), 0, $length);
    }
    $link = generateRandomPattern();
    $sql_survey = "INSERT INTO survey (creator_id,name,description,questions,link,status) VALUES ($survey_creator,'$name','$des_def','[]','$link','open');";
    $res_survey = mysqli_query($con, $sql_survey);
    $survey_id = mysqli_insert_id($con);
    $arr = $_POST;
    $questions = array();
    foreach ($arr as $key => $value) {
      if (preg_match('/^question(\d+)$/', $key, $matches)) {
        $question_number = $matches[1];
        $question_text = $value;
        $answer_type = $arr["anstype$question_number"];
        $sql_question = "INSERT INTO survey_questions (template_id, question, answer_type,created_by) VALUES ($survey_id, '$question_text', '$answer_type', $survey_creator);";
        $res_question = mysqli_query($con, $sql_question);
        $question_id = mysqli_insert_id($con);
        $questions[] = $question_id;
        $options_arr = array();
        foreach ($arr as $opt_key => $opt_value) {
          if (preg_match("/^question{$question_number}_option(\d+)$/", $opt_key)) {
            $sql_option = "INSERT INTO survey_options (que_id, options,added_by) VALUES ($question_id, '$opt_value',$survey_creator)";
            $res_option = mysqli_query($con, $sql_option);
            $options_id = mysqli_insert_id($con);
            $options_arr[] = $options_id;
          }
        }
        if (!empty($options_arr)) {
          $options_ids_string = "[" . implode(',', $options_arr) . "]";
          $sql = "INSERT INTO question_option (que_id, options_id, survey_id) VALUES ('$question_id', '$options_ids_string', '$survey_id')";
          mysqli_query($con, $sql);
          unset($options_arr);
        }
      }
    }

    $question_string = "[" . implode(',', $questions) . "]";
    $sql_up = "UPDATE survey SET questions='$question_string' WHERE ID=$survey_id";
    $res_up = mysqli_query($con, $sql_up);
    
    header('location:survey_preview.php?survey_id=' . $survey_id);

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
  <title>Survey Survey Creation</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
  <link href="../assets/panel/build/survey_creation/survey_creation.css" rel="stylesheet">

</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php include('sidebar.php') ?>
      <div class="right_col" role="main">
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>Survey Creation</h3>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_content">
                  <div id="wizard" class="form_wizard wizard_horizontal">
                    <ul class="wizard_steps">
                      <li>
                        <a href="#step-1">
                          <span class="step_no">1</span>
                          <span class="step_descr">
                            Step 1<br />
                            <small>Survey Details</small>
                          </span>
                        </a>
                      </li>
                      <li>
                        <a href="#step-2">
                          <span class="step_no">2</span>
                          <span class="step_descr">
                            Step 2<br />
                            <small>Add Questions</small>
                          </span>
                        </a>
                      </li>
                    </ul>
                    <form class="form-horizontal form-label-left" method="post" enctype="multipart/form-data">
                      <?php if (@$_GET['template_id']) { ?>
                        <div id="step-1">
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Survey
                              Name
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <input type="text" required="required" class="form-control" name="survey_name"
                                value="<?php echo @$row_template['Template_name']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"> Survey
                              Description
                            </label>
                            <div class="col-md-6 col-sm-6 ">
                              <textarea class="form-control " name="survey_default_descripton"
                                value="<?php echo @$row_template['Survey_description']; ?>"><?php echo $row_template['Survey_description']; ?></textarea>
                            </div>
                          </div>
                        </div>
                        <div id="step-2">
                          <h2 class="StepTitle">Add Questions</h2>
                          <div class="col-md-9 p-3">
                            <div class="d-flex justify-content-between align-items-center">
                              <h4>Create Your Survey</h4>

                            </div>
                            <hr>

                            <div id="questions-container">
                              <?php
                              $c = 0;
                              while ($row_questions = mysqli_fetch_assoc($res_questions)) {
                                $c++;
                                ?>
                                <div class="question-wrapper">
                                  <div class="mb-3 question-item">
                                    <label for="question<?php echo $c; ?>" class="form-label">Question
                                      <?php echo $c; ?></label>
                                    <input type="text" class="form-control" id="question<?php echo $c; ?>"
                                      placeholder="Enter your question" name="question<?php echo $c; ?>"
                                      value="<?php echo $row_questions['question']; ?>">
                                    <label class="form-label mt-2">Answer Type</label>
                                    <select class="form-select answer-type" name="anstype<?php echo $c; ?>">
                                      <option value="text" <?php if ($row_questions['answer_type'] == 'text')
                                        echo 'selected'; ?>>Text</option>
                                      <option value="textarea" <?php if ($row_questions['answer_type'] == 'textarea')
                                        echo 'selected'; ?>>Textarea
                                      </option>
                                      <option value="email" <?php if ($row_questions['answer_type'] == 'email')
                                        echo 'selected'; ?>>Email
                                      </option>
                                      <option value="tel" <?php if ($row_questions['answer_type'] == 'tel')
                                        echo 'selected'; ?>>Telephone
                                      </option>
                                      <option value="number" <?php if ($row_questions['answer_type'] == 'number')
                                        echo 'selected'; ?>>Number
                                      </option>
                                      <option value="rating" <?php if ($row_questions['answer_type'] == 'rating')
                                        echo 'selected'; ?>>Rating
                                      </option>
                                      <option value="select" <?php if ($row_questions['answer_type'] == 'select')
                                        echo 'selected'; ?>>Select
                                      </option>
                                      <option value="checkbox" <?php if ($row_questions['answer_type'] == 'checkbox')
                                        echo 'selected'; ?>>Checkbox
                                      </option>
                                      <option value="radio" <?php if ($row_questions['answer_type'] == 'radio')
                                        echo 'selected'; ?>>Radio
                                      </option>
                                    </select>
                                    <div class="options-container mt-2">

                                      <?php if (in_array($row_questions['answer_type'], ['radio', 'checkbox', 'select', 'rating'])) {
                                        $sql_option = "SELECT * FROM survey_options WHERE que_id = " . $row_questions['que_id'];
                                        $res_option = mysqli_query($con, $sql_option);
                                        $op_c = 0;
                                        while ($row_option = mysqli_fetch_assoc($res_option)) {
                                          $op_c++;
                                          ?>
                                          <div class="option-item d-flex align-items-center mb-2">
                                            <input type="text" class="form-control" placeholder="Option"
                                              name="question<?php echo $c; ?>_option<?php echo $op_c; ?>"
                                              value="<?php echo $row_option['options']; ?>">
                                            <button type="button" class="btn btn-success btn-sm ms-2 add-option">+</button>
                                            <button type="button" class="btn btn-danger btn-sm ms-2 remove-option">-</button>
                                          </div>
                                        <?php }
                                      } ?>
                                    </div>
                                  </div>
                                  <button type="button" class="btn btn-secondary mt-2 add-between">Add
                                    Another
                                    Question</button>
                                  <button type="button" class="btn btn-danger mt-2 remove-question">Remove
                                    This
                                    Question</button>
                                </div>

                              <?php } ?>
                              <div>
                                <input type="submit" name="save" value="Save" class="btn-save">

                              </div>
                              <?php
                      } else { ?>
                              <div id="step-1">
                                <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align">Survey
                                    Name
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                    <input type="text" required="required" class="form-control" name="survey_name">
                                  </div>
                                </div>
                                <div class="form-group row">
                                  <label class="col-form-label col-md-3 col-sm-3 label-align"> Survey
                                    Description
                                  </label>
                                  <div class="col-md-6 col-sm-6 ">
                                    <textarea class="form-control " name="survey_default_descripton"></textarea>
                                  </div>
                                </div>
                              </div>
                              <div id="step-2">
                                <h2 class="StepTitle">Add Questions</h2>
                                <div class="col-md-9 p-3">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <h4>Create Your Survey</h4>

                                  </div>
                                  <hr>
                                  <div id="questions-container">
                                    <div class="question-wrapper">
                                      <div class="mb-3 question-item">
                                        <label for="question1" class="form-label">Question1</label>
                                        <input type="text" class="form-control" id="question1"
                                          placeholder="Enter your question" name="question1">
                                        <label class="form-label mt-2">Answer Type</label>
                                        <select class="form-select answer-type" name="anstype1">
                                          <option value="text">Text</option>
                                          <option value="textarea">Text Area</option>
                                          <option value="email">Email</option>
                                          <option value="tel">Telephone</option>
                                          <option value="number">Number</option>
                                          <option value="rating">Rating</option>
                                          <option value="select">Select</option>
                                          <option value="checkbox">Checkbox</option>
                                          <option value="radio">Radio</option>
                                        </select>
                                        <div class="options-container mt-2"></div>
                                      </div>
                                      <button type="button" class="btn btn-secondary mt-2 add-between">Add
                                        Another
                                        Question</button>
                                      <button type="button" class="btn btn-danger mt-2 remove-question">Remove
                                        This
                                        Question</button>
                                    </div>
                                    <div>
                                      <input type="submit" name="submit" value="submit" class="btn-save">

                                    </div>
                                  </div>

                                <?php } ?>
                              </div>
                            </div>
                          </div>
                    </form>
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
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
  <script>
    let questionCount = 1;

    function updateQuestionNumbers() {
      const questionItems = document.querySelectorAll('.question-item');
      questionItems.forEach((item, index) => {
        const questionNumber = index + 1;
        const label = item.querySelector('.form-label');
        label.innerText = `Question ${questionNumber}`;
        const input = item.querySelector('input[type="text"]');
        input.id = `question${questionNumber}`;
        input.setAttribute('placeholder', `Enter your question`);
        input.name = `question${questionNumber}`;

        const select = item.querySelector('.answer-type');
        select.name = `anstype${questionNumber}`;

        // Update the names of any existing options
        const options = item.querySelectorAll('.option-item input');
        options.forEach((option, optionIndex) => {
          option.name = `question${questionNumber}_option${optionIndex + 1}`;
          option.placeholder = `Option ${optionIndex + 1}`;
        });
      });
    }

    function createQuestionElement(questionNumber) {
      const newQuestion = document.createElement('div');
      newQuestion.classList.add('question-wrapper');

      newQuestion.innerHTML = `
      <div class="mb-3 question-item">
         <label for="question${questionNumber}" class="form-label">Question ${questionNumber}</label>
         <input type="text" class="form-control" id="question${questionNumber}" placeholder="Enter your question" name="question${questionNumber}">
         <label class="form-label mt-2">Answer Type</label>
         <select class="form-select answer-type" name="anstype${questionNumber}">
            <option value="text">Text</option>
            <option value="textarea">Textarea</option>
            <option value="email">Email</option>
            <option value="tel">Telephone</option>
            <option value="number">Number</option>
            <option value="rating">Rating</option>
            <option value="select">Select</option>
            <option value="radio">Radio</option>
            <option value="checkbox">Checkbox</option>
         </select>
         <div class="options-container mt-2"></div>
      </div>
      <button type="button" class="btn btn-secondary mt-2 add-between">Add Another Question</button>
      <button type="button" class="btn btn-danger mt-2 remove-question">Remove This Question</button>
   `;

      return newQuestion;
    }

    function handleAnswerTypeChange(event) {
      const select = event.target;
      const questionWrapper = select.closest('.question-item');
      const optionsContainer = questionWrapper.querySelector('.options-container');
      const questionNumber = questionWrapper.querySelector('input[type="text"]').id.replace('question', '');

      switch (select.value) {
        case 'select':
        case 'radio':
        case 'checkbox': // Added checkbox case
          optionsContainer.innerHTML = `
            <label class="form-label">Options</label>
            <div class="option-item d-flex align-items-center mb-2">
               <input type="text" class="form-control" placeholder="Option 1" name="question${questionNumber}_option1">
               <button type="button" class="btn btn-success btn-sm ms-2 add-option">+</button>
               <button type="button" class="btn btn-danger btn-sm ms-2 remove-option">-</button>
            </div>
         `;
          break;
        case 'rating':
          optionsContainer.innerHTML = `
            <label class="form-label">Rating Scale</label>
            <input type="number" class="form-control" placeholder="Enter the number of stars" min="1" max="10" name="question${questionNumber}_rating">
         `;
          break;
        default:
          optionsContainer.innerHTML = '';
          break;
      }
    }

    document.getElementById('questions-container').addEventListener('click', function (event) {
      if (event.target.classList.contains('add-between')) {
        const currentWrapper = event.target.closest('.question-wrapper');
        questionCount++;
        const newQuestion = createQuestionElement(questionCount);
        currentWrapper.insertAdjacentElement('afterend', newQuestion);
        updateQuestionNumbers();
      } else if (event.target.classList.contains('remove-question')) {
        const currentWrapper = event.target.closest('.question-wrapper');
        currentWrapper.remove();
        updateQuestionNumbers();
      } else if (event.target.classList.contains('add-option')) {
        const optionItem = event.target.closest('.option-item');
        const optionsContainer = event.target.closest('.options-container');
        const optionCount = optionsContainer.querySelectorAll('.option-item').length + 1;
        const questionNumber = optionsContainer.closest('.question-item').querySelector('input[type="text"]').id.replace('question', '');

        const newOption = document.createElement('div');
        newOption.classList.add('option-item', 'd-flex', 'align-items-center', 'mb-2');
        newOption.innerHTML = `
         <input type="text" class="form-control" placeholder="Option ${optionCount}" name="question${questionNumber}_option${optionCount}">
         <button type="button" class="btn btn-success btn-sm ms-2 add-option">+</button>
         <button type="button" class="btn btn-danger btn-sm ms-2 remove-option">-</button>
      `;
        optionItem.insertAdjacentElement('afterend', newOption);
        updateQuestionNumbers();
      } else if (event.target.classList.contains('remove-option')) {
        const optionItem = event.target.closest('.option-item');
        optionItem.remove();
        updateQuestionNumbers();
      }
    });

    document.getElementById('questions-container').addEventListener('change', function (event) {
      if (event.target.classList.contains('answer-type')) {
        handleAnswerTypeChange(event);
      }
    });

  </script>

</body>

</html>