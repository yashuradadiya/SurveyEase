<?php
session_start();

if (!isset($_GET["template_id"])) {
    header("location:survey_template.php");
} else {
    $template_id = 1;
    $template_id = $_GET["template_id"];
    $con = mysqli_connect("localhost", "root", "", "online_survey_system");
    $sql_template = "SELECT * FROM survey_templates WHERE ID = $template_id";
    $res_template = mysqli_query($con, $sql_template);
    $template = mysqli_fetch_array($res_template);
    $sql_questions = "SELECT * FROM survey_questions WHERE template_id=$template_id and created_by='admin';";
    $res_questions = mysqli_query($con, $sql_questions);
}
?>

<head>
    <meta charset="utf-8">
    <title>Employees templates - SurveyEase</title>
    <meta content="width=device-width, initial-scale=1" name="viewport">

    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

    <link rel="stylesheet" href="assets/user/main_web/style.css">
    <link rel="stylesheet" href="assets/user/main_web/survey_que.css">
</head>
<?php
include "header.php";
?>
<div style="background-color:#f4fbfe" class="section-inner-hero padding-huge hero-top-padding">
    <div class="container-medium">
        <div class="breadcrumbs">
            <?php
            $cat_sql = "SELECT * FROM survey_category WHERE ID = " . $template['Template_category'];
            $cat_res = mysqli_query($con, $cat_sql);
            $cat_row = mysqli_fetch_assoc($cat_res);
            ?>
            <a href="all_template.php" class="link">Surveys</a>
            <div class="breadcrumb-separator">/ </div>
            <a href="<?php echo $cat_row['Category']; ?>.php" class="link"><?php echo $cat_row['Category']; ?></a>
            <div class="breadcrumb-separator">/ </div>
            <div class="breadcrumb-title"><?php echo $template['Template_name']; ?></div>
        </div>
        <div class="spacer-xmedium"></div>
    </div>
    <div class="container-medium text-align-center">
        <div>
            <div id="w-node-_49d1f7a0-b678-7c80-0121-5d776a378f44-2b908e23" class="survey-template-info">
                <h1 class="survey-template-title"><?php echo $template['Template_name']; ?></h1>
                <div class="spacer-small"></div>
                <div class="rte-container">
                    <div class="text-rich-text w-richtext">
                        <?php echo $template['Template_description']; ?>
                    </div>
                </div>
                <div class="rte-container w-condition-invisible">
                    <div class="text-rich-text w-dyn-bind-empty w-richtext"></div>
                </div>
                <div class="spacer-medium"></div>
                <div class="survey-template-button-holder">
                    <a href="survey/survey_create.php?template_id=<?php echo $template['ID']; ?>"
                        class="button w-button">Use this template</a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="w-embed">

</div>
<div class="section-content padding-huge background-colour-grey">
    <div class="container-medium">
        <h2 class="text-align-center"><?php echo $template['Template_name']; ?></h2>
        <div class="spacer-xsmall"></div>
        <div id="w-node-d56624f1-8cd0-cc75-908f-77b538d52263-2b908e23" class="rte-container">
            <div
                class="text-rich-text align-center max-width-large padding-top-1rem padding-bottom-1rem w-dyn-bind-empty w-richtext">
            </div>
            <div class="spacer-medium"></div>
            <div class="survey-template-questions-container container-small">
                <div class="text-rich-text padding-medium w-richtext">


                    <?php
                    $que_cnt = 0;
                    while ($row = mysqli_fetch_assoc($res_questions)) {
                        $que_cnt++;
                        ?>
                        <h3><?php echo $que_cnt . ". " . $row['question']; ?></h3>

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
                        <ol>
                            <?php
                            $sql_option = "SELECT * FROM survey_options WHERE que_id=" . $row['que_id'];
                            $res_option = mysqli_query($con, $sql_option);
                            while ($option = mysqli_fetch_array($res_option)) {
                                ?>
                                <li>

                                    <?php if ($row['answer_type'] == 'rating') {
                                        for ($i = 1; $i <= $option['options']; $i++) {
                                            echo "<input type='radio' name='" . $option['op_id'] . "' value='" . $i . "'> <span style='margin-right: 30px;'>$i</span>";
                                        }
                                    } else {
                                        echo $option['options'];
                                    } ?>
                                </li>
                            <?php } ?>
                        </ol>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-content padding-huge w-condition-invisible">
    <div class="container-medium">
        <div id="w-node-f4eaa1ca-45b0-ac8a-4bf1-e44b8a39e990-2b908e23" class="rte-container">
            <div class="text-rich-text w-dyn-bind-empty w-richtext"></div>
            <div class="spacer-medium"></div>
        </div>
    </div>
</div>
<div class="section-cta padding-huge">
    <div class="container-medium">
        <div class="align-center text-align-center">
            <h2>Get started and create your first survey</h2>
            <div class="spacer-medium"></div>
            <div class="text-size-xmedium text-colour-blue">If you would like more information then please get in touch.
            </div>
        </div>
        <div class="spacer-xlarge"></div>
        <div class="cta-holder is-centred">
            <a href="./login.php" class="button w-button">Start for free</a>
            <div class="horizontal-spacer-xmedium"></div>
            <a href="./contact.php" class="button is-secondary w-button">Get in touch</a>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>