<?php 
session_start();
$con = mysqli_connect("localhost", "root", "", "online_survey_system");
$sql = "SELECT * FROM survey_templates WHERE Template_category=1 ORDER BY Template_name ASC";
$res = mysqli_query($con, $sql);
$category = 'Customer';
?>
<!DOCTYPE html>
<html data-wf-page="63ece81ba4a783765134aad6" lang="en">

<head>
  <meta charset="utf-8">
  <title>Customers Templates - SurveyEase</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

  <link rel="stylesheet" href="assets/user/main_web/style.css">
</head>
<?php
include "header.php";
?>
<div class="section-inner-hero padding-huge hero-top-padding background-colour-grey">
  <div class="container-small text-align-center">
    <h1>Survey Templates</h1>
    <div class="spacer-xsmall"></div>
    <div class="text-rich-text w-richtext">
      <p>Create a survey in minutes with one of our fully customisable survey templates. Get started now by finding a
        suitable example then using as is or customising to suit.</p>
    </div>
  </div>
</div>
<div class="section-templates padding-huge top-padding-small">
  <div class="container-medium">
    <div class="template-list">
      <div class="templates_col01">
        <div>
          <a href="all_template.php" aria-current="page" class="templates_heading-link w--current">Survey
            Templates</a>
          <div class="spacer-tiny"></div>
          <div class="w-dyn-list">
            <div role="list" class="w-dyn-items">
              <?php 
              $sql_category = "SELECT * FROM survey_category";
              $res_category = mysqli_query($con, $sql_category);
              while ($row_category=mysqli_fetch_assoc($res_category)) { 
                ?>
              <div role="listitem" class="category-item w-dyn-item">
                <a href="./<?php echo $row_category['Category']; ?>.php" class="category-link <?php if (@$row_category['Category']==@$category){ echo 'w--current'; } ?>"><?php echo $row_category['Category']; ?></a>
              </div>
              <?php } ?>
            </div>
          </div>
          <div class="spacer-small"></div>
        </div>
      </div>
      <div class="templates_col02">
        <div class="templates-header-row">
          <h3>Customer templates</h3>
        </div>
        <div class="spacer-medium"></div>
        <div class="w-dyn-list">
          <div fs-countitems-element="list" role="list" class="grid-col-list w-dyn-items">

          <?php
          while ($row = mysqli_fetch_assoc($res)){
          ?>
            <div role="listitem" class="w-dyn-item">
              <a href="template.php?template_id=<?php echo $row['ID']; ?>"
                class="template-item w-inline-block">
                <div class="template-image">
                  <img
                    src="assets/panel/Images_Survey/<?php echo $row['Template_image']; ?>"
                    loading="lazy" alt="" class="image-cover">
                </div>
                <div class="spacer-tiny"></div>
                <div class="text-weight-medium text-size-small template-title"><?php echo $row['Template_name']; ?></div>
                <div class="spacer-tiny"></div>
              </a>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="spacer-huge"></div>
        <div class="w-dyn-bind-empty w-richtext"></div>
      </div>
    </div>
  </div>
</div>
<?php
include "footer.php";
?>