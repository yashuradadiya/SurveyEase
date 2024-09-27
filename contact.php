<?php

$con = mysqli_connect("localhost", "root", "", "online_survey_system");

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $sql_feedback = "INSERT INTO user_feedback (Name,Email,Subject,Message) VALUES ('$name','$email','$subject','$message')";
  $result_feedback = mysqli_query($con, $sql_feedback);
}
?>

<head>
  <meta charset="utf-8">
  <title>Employees templates - SurveyEase</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

  <link rel="stylesheet" href="assets/user/main_web/style.css">
</head>
<?php
include "header.php";
?>
<style type="text/css">
  /* General Form Styles */
  form {
    max-width: 500px;
    margin: 0 auto;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .form-group label {
    flex: 0 0 150px;
    /* Adjust the width of the label */
    margin-bottom: 0;
    font-size: 16px;
    color: #333;
  }

  .form-group input[type="text"],
  .form-group input[type="email"],
  .form-group select,
  .form-group textarea {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    background-color: #fff;
    outline: none;
    transition: border-color 0.3s;
  }

  input[type="text"]:focus,
  input[type="email"]:focus,
  select:focus,
  textarea:focus {
    border-color: #1ABB9C;
    box-shadow: 0 0 5px rgba(26, 187, 156, 0.5);
  }

  textarea {
    resize: none;
  }

  input[type="submit"] {
    display: block;
    width: 100%;
    padding: 12px;
    background-color: #2a3f55;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  input[type="submit"]:hover {
    background-color: #1ABB9C;
  }

  /* Responsive Design */
  @media (max-width: 600px) {
    .form-group {
      display: block;
    }

    .form-group label {
      width: 100%;
      margin-bottom: 8px;
    }
  }
</style>

<div class="section-inner-hero padding-huge hero-top-padding background-colour-grey">
  <div class="container-medium text-align-center">
    <h1>Contact Us</h1>
    <div class="spacer-xsmall"></div>
    <p class="text-size-xmedium text-colour-blue">
      Please get in touch with any questions, queries or suggestions.<br>
    </p>
  </div>
</div>

<div class="section-map padding-huge">
  <div class="container-medium">
    <div class="w-layout-grid grid_2-col_wide-right">
      <div id="w-node-_23ba4e5d-e847-122f-d54b-309ad59666f5-e33561d8" class="grid-column is-first">
        <div class="vertical-grid-item">
          <div class="feature-content-block">
            <div class="horizontal-flex is-no-gap">
              <div class="text-size-xlarge text-weight-semibold">Location</div>
            </div>
            <div class="spacer-medium"></div>
            <p class="text-size-medium text-colour-blue">Have questions or need assistance? Feel free to reach out to
              us...</p>
            <div class="spacer-medium"></div>
            <div class="text-size-medium text-weight-semibold text-colour-blue">Office Hours (UK time)</div>
            <div class="spacer-xxxtiny"></div>
            <p class="text-size-medium text-colour-blue">Mon–Fri, 9:00am–5:30pm</p>
            <div class="spacer-small"></div>
            <div class="text-size-medium text-weight-semibold text-colour-blue">Phone number:</div>
            <p class="text-size-medium text-colour-blue">+44 (0)1684 342 400</p>
          </div>
        </div>
      </div>
      <div id="w-node-eb98ee84-090d-fdaf-8a45-bffd5acbbe0b-e33561d8" class="is-last">
        <!-- Contact Form -->
        <form method="post">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
          </div>

          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
          </div>

          <div class="form-group">
            <label for="subject">Subject:</label>
            <select id="subject" name="subject" required>
              <option value="General Inquiry">General Inquiry</option>
              <option value="Technical Support">Technical Support</option>
              <option value="Feedback">Feedback</option>
            </select>
          </div>

          <div class="form-group">
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>

          <input type="submit" name="submit" value="Submit">
        </form>

      </div>
    </div>
  </div>
</div>

<div class="container-medium padding-huge">
  <div class="align-center text-align-center max-width-xmedium">
    <h2>Get started now</h2>
    <div class="spacer-medium"></div>
    <div class="text-size-xmedium text-colour-blue max-width-semi align-center">
      Create powerful online surveys with our user-friendly yet advanced survey software.<br>
    </div>
  </div>
  <div class="spacer-xlarge"></div>
  <div class="cta-holder is-centred">
    <a href="./index.php" class="button is-green w-button">Get started</a>
  </div>
</div>

<?php
include "footer.php";
?>