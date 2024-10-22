<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
	header("location:index.php");
} else {
	$con = mysqli_connect("localhost", "root", "", "online_survey_system");
	$sql_category = "SELECT * FROM survey_category";
	$res_category = mysqli_query($con, $sql_category);
	if (isset($_POST['save'])) {
		@$name = @$_POST['survey_name'];
		@$des = @$_POST['survey_descripton'];
		@$des_def = @$_POST['survey_default_descripton'];
		@$category_id = @$_POST['category'];
		@$template_image = @$_FILES['image']['name'];
		move_uploaded_file($_FILES['image']['tmp_name'], '../Images_Survey/'.$template_image);
		$sql_survey = "INSERT INTO survey_templates (Template_name,Template_description,Template_category,Survey_description,Template_image) VALUES('$name','$des',$category_id,'$des_def','$template_image');";
		$res_survey = mysqli_query($con, $sql_survey);
		$survey_id = mysqli_insert_id($con);
		$arr = $_POST;
		$questions = array();
		foreach ($arr as $key => $value) {
			if (preg_match('/^question(\d+)$/', $key, $matches)) {
				$question_number = $matches[1];
				$question_text = $value;
				$answer_type = $arr["anstype$question_number"];
				$sql_question = "INSERT INTO survey_questions (template_id, question, answer_type,created_by) VALUES ($survey_id, '$question_text', '$answer_type', 'admin');";
				$res_question = mysqli_query($con, $sql_question);
				$question_id = mysqli_insert_id($con);
				foreach ($arr as $opt_key => $opt_value) {
					if (preg_match("/^question{$question_number}_option(\d+)$/", $opt_key)) {
						$sql_option = "INSERT INTO survey_options (que_id, options) VALUES ($question_id, '$opt_value')";
						$res_option = mysqli_query($con, $sql_option);
					}
				}
			}
		}
		header("location:survey_template.php");
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
	<title>Admin | Survey Creation</title>
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
							<h3>Temaplate Creation</h3>
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
														<small>Temaplate Details</small>
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
										<form class="form-horizontal form-label-left" method="post"
											enctype="multipart/form-data">
											<div id="step-1">
												<div class="form-group row">
													<label
														class="col-form-label col-md-3 col-sm-3 label-align">Temaplate
														Name
													</label>
													<div class="col-md-6 col-sm-6 ">
														<input type="text" required="required" class="form-control"
															name="survey_name">
													</div>
												</div>
												<div class="form-group row">
													<label class="col-form-label col-md-3 col-sm-3 label-align">
														Temaplate
														Description
													</label>
													<div class="col-md-6 col-sm-6 ">
														<textarea class="form-control "
															name="survey_descripton"></textarea>
													</div>
												</div>

												<div class="form-group row">
													<label class="col-form-label col-md-3 col-sm-3 label-align">
														Temaplate Category
													</label>
													<div class="col-md-6 col-sm-6 ">
														<select class="form-control" required name="category">
															<?php while ($row_category = mysqli_fetch_array($res_category)) { ?>
																<option value="<?php echo $row_category['ID']; ?>">
																	<?php echo $row_category['Category']; ?>
																</option>
															<?php } ?>
														</select>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-form-label col-md-3 col-sm-3 label-align"> Survey
														Default
														Description
													</label>
													<div class="col-md-6 col-sm-6 ">
														<textarea class="form-control "
															name="survey_default_descripton"></textarea>
													</div>
												</div>
												<div class="form-group row">
													<label
														class="col-form-label col-md-3 col-sm-3 label-align">Image</label>
													<div class="col-md-6 col-sm-6 ">
														<input type="file" name="image">
													</div>
												</div>
											</div>
											<div id="step-2">
												<h2 class="StepTitle">Step 2 Content</h2>
												<div class="col-md-9 p-3">
													<div class="d-flex justify-content-between align-items-center">
														<h4>Create Your Temaplate</h4>
														
													</div>
													<hr>
													<div id="questions-container">
														<div class="question-wrapper">
															<div class="mb-3 question-item">
																<label for="question1"
																	class="form-label">Question1</label>
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
															<button type="button"
																class="btn btn-secondary mt-2 add-between">Add Another
																Question</button>
															<button type="button"
																class="btn btn-danger mt-2 remove-question">Remove This
																Question</button>

														</div>
														<div>
																<input type="submit" name="save" value="Save" class="btn-save">

														</div>
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
				case 'checkbox': 
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
				<input type="number" class="form-control" placeholder="Enter the number of stars" min="1" max="10" name="question${questionNumber}_option1">
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