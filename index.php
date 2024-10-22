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
<!DOCTYPE html>
<html data-wf-page="63ece81ba4a783765134aad6" lang="en">

<head>
  <meta charset="utf-8">
  <title>Online Survey Software - SurveyEase</title>
  <meta content="width=device-width, initial-scale=1" name="viewport">

  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">

  <link rel="stylesheet" href="assets/user/main_web/style.css">
</head>

<?php
include "header.php";
?>
<div class="section-home-hero padding-huge bottom-shadow">
  <div class="container-medium horizontal-flex">
    <div class="col_45">
      <div class="max-width-medium">
        <h1>Create and Analyze Surveys with SurveyEase</h1>
        <div class="spacer-small"></div>
        <div class="text-size-xmedium text-colour-blue">Welcome to SurveyEase, your go-to platform for fast and easy
          survey creation. Whether you're a student or professional, design, share, and analyze surveys effortlessly.
          Get started now and gain insights in minutes!</div>
      </div>
      <div class="spacer-large"></div>
      <div class="cta-holder">
        <a href="Survey" class="button w-button">Get started</a>
        <div class="horizontal-spacer-xmedium"></div>
      </div>
    </div>
    <div class="col_60">
      <img src="assets/user/main_web/image/banner.svg" alt="Header graphic containing survey questions"
        class="image_home-hero">
    </div>
  </div>

</div>
<div class="section-tabs padding-large">
  <div class="container-medium">
    <div class="max-width-large text-align-center align-center">
      <div class="spacer-small"></div>
      <h2 class="text-align-center">Key Features</h2>
      <div class="spacer-medium"></div>
      <div class="text-size-xmedium text-colour-blue">Discover a fast, flexible platform to meet all your survey needs
        with customizable templates and real-time analytics</div>
      <div class="spacer-large"></div>
    </div>
    <div data-current="Customer Experience" data-easing="ease" data-duration-in="50" data-duration-out="50"
      class="tab-component w-tabs">
      <div class="tabs-menu-flex overflow-hidden w-tab-menu">
        <a data-w-tab="Customer Experience" data-w-id="9148c1eb-de83-e529-b4b2-2f895bdded79"
          class="button is-dark-blue-reverse w-inline-block w-tab-link w--current">
          <div>Easy Survey Creation</div>
        </a>
        <a data-w-tab="Employee Engagement" data-w-id="9148c1eb-de83-e529-b4b2-2f895bdded7c"
          class="button is-dark-blue-reverse w-inline-block w-tab-link">
          <div>Advanced Survey Management</div>
        </a>
        <a data-w-tab="Market Research" data-w-id="9148c1eb-de83-e529-b4b2-2f895bdded7f"
          class="button is-dark-blue-reverse w-inline-block w-tab-link">
          <div>Customizable Templates</div>
        </a>
        <a data-w-tab="Public Sector" data-w-id="9148c1eb-de83-e529-b4b2-2f895bdded82"
          class="button is-dark-blue-reverse w-inline-block w-tab-link">
          <div> Easy Sharing & Distribution</div>
        </a>
      </div>
      <div class="w-tab-content">
        <div data-w-tab="Customer Experience" class="tab-pane padding-medium padding-vertical w-tab-pane w--tab-active">
          <div class="pane-content height-30rem no-top-padding">
            <div class="pane-left">
              <img
                sizes="(max-width: 479px) 91vw, (max-width: 767px) 94vw, (max-width: 991px) 53vw, (max-width: 1919px) 52vw, 665.75px"
                srcset="assets/user/main_web/image/product.png" loading="lazy" alt="">
            </div>
            <div class="pane-right">
              <div class="pane-title">

              </div>
              <div class="spacer-small"></div>
              <div class="content-block_tab">
                <h3>Easy Survey Creation</h3>
                <div class="spacer-medium"></div>
                <p class="text-size-medium text-colour-blue">
                  Our platform offers an intuitive interface that simplifies survey creation. Whether you're new to
                  surveys or a seasoned pro, you can effortlessly create surveys in minutes. With drag-and-drop
                  functionality, you can quickly add questions, rearrange them, and customize your survey structure.
                  Choose from various question types like multiple choice, text, rating, and more to tailor your survey
                  to your needs. No coding or technical knowledge required!
                </p>
                <div class="spacer-small"></div>

              </div>
            </div>
          </div>
        </div>
        <div data-w-tab="Employee Engagement" class="tab-pane padding-medium padding-vertical w-tab-pane">
          <div class="pane-content height-30rem no-top-padding">
            <div class="pane-left">
              <img
                sizes="(max-width: 479px) 91vw, (max-width: 767px) 94vw, (max-width: 991px) 53vw, (max-width: 1919px) 52vw, 665.75px"
                srcset="" loading="lazy" alt="">
            </div>
            <div class="pane-right">
              <div class="pane-title">
                <img src="assets/user/main_web/image/logo1.svg" loading="lazy" alt="SmartCX logo." height="42">
              </div>
              <div class="spacer-small"></div>
              <div class="content-block_tab">
                <h3> Advanced Survey Management</h3>
                <div class="spacer-medium"></div>
                <p class="text-size-medium text-colour-blue">
                  Our dashboard lets you manage multiple surveys with ease. View all your surveys in one place, track
                  their status, and quickly access response data. You can edit live surveys, schedule when they go out,
                  or close them once you have enough responses. Duplicate surveys with one click for future projects,
                  ensuring consistent survey formats across various uses.
                </p>
                <div class="spacer-small"></div>
                <a data-w-id="9148c1eb-de83-e529-b4b2-2f895bddedaa" href="index.php"
                  class="button is-cx w-inline-block">
                  <div>Learn more</div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div data-w-tab="Market Research" class="tab-pane padding-medium padding-vertical w-tab-pane">
          <div class="pane-content height-30rem no-top-padding">
            <div class="pane-left">
              <img
                sizes="(max-width: 479px) 91vw, (max-width: 767px) 94vw, (max-width: 991px) 53vw, (max-width: 1919px) 52vw, 665.75px"
                srcset="" loading="lazy" alt="">
            </div>
            <div class="pane-right">
              <div class="pane-title">
                <img src="assets/user/main_web/image/logo2.svg" loading="lazy" width="Auto" height="42"
                  alt="SmartEX logo.">
              </div>
              <div class="spacer-small"></div>
              <div class="content-block_tab">
                <h3>Pre-made Templates & Customization</h3>
                <div class="spacer-medium"></div>
                <p class="text-size-medium text-colour-blue">Save time by using our pre-made question templates that
                  cover a range of survey types, such as customer feedback, academic research, or event evaluations.
                  These templates are fully customizable, allowing you to tweak the questions or answer formats as per
                  your requirements. You can also create your own templates for future use, making it easier to
                  standardize your surveys.</p>
                <div class="spacer-small"></div>
                <a data-w-id="9148c1eb-de83-e529-b4b2-2f895bddedbc" href="index.php"
                  class="button is-ex w-inline-block">
                  <div>Learn more</div>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div data-w-tab="Public Sector" class="tab-pane padding-medium padding-vertical w-tab-pane">
          <div class="pane-content height-30rem no-top-padding">
            <div class="pane-left">
              <img
                sizes="(max-width: 479px) 91vw, (max-width: 767px) 94vw, (max-width: 991px) 53vw, (max-width: 1919px) 52vw, 665.75px"
                srcset="" loading="lazy" alt="">
            </div>
            <div class="pane-right">
              <div class="pane-title">
                <img src="assets/user/main_web/image/logo3.svg" loading="lazy" width="Auto" height="42"
                  alt="SmartCE logo.">
              </div>
              <div class="spacer-small"></div>
              <div class="content-block_tab">
                <h3>Easy Sharing & Distribution</h3>
                <div class="spacer-medium"></div>
                <p class="text-size-medium text-colour-blue">Once your survey is ready, sharing it is simple. Distribute
                  your survey via email, social media, or direct link. Our system also generates QR codes for easy
                  offline sharing. If you’re conducting targeted surveys, you can control who gets to see the survey by
                  restricting access to a specific audience or group.</p>
                <div class="spacer-small"></div>
                <a data-w-id="9148c1eb-de83-e529-b4b2-2f895bddedce" href="index.php"
                  class="button is-ce w-inline-block">
                  <div>Learn more</div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="padding-large background-colour-grey ">
  <div class="container-medium    ">
    <div class="flex-justify-center flex-gap-3">
      <img src="assets/user/main_web/image/logo1.svg" loading="lazy" width="Auto" height="45" alt="SmartSurvey icon.">
      <img src="assets/user/main_web/image/logo2.svg" loading="lazy" width="Auto" height="45" alt="SmartCX icon.">
      <img src="assets/user/main_web/image/logo3.svg" loading="lazy" width="Auto" height="45" alt="SmartEX icon.">
      <img src="assets/user/main_web/image/logo4.svg" loading="lazy" width="Auto" height="45" alt="SmartCE icon.">
      <img src="assets/user/main_web/image/logo5.svg" loading="lazy" width="Auto" height="45" alt="SmartPX icon.">
    </div>
    <div class="spacer-large"></div>
    <h2 class="text-align-center">
      Your whole organisation.<br>One insight platform.
    </h2>
    <div class="spacer-medium"></div>
    <div class="text-rich-text align-center text-align-center max-width-large w-richtext">
      <p>Enable every department to gather data and drive meaningful change. With our secure platform and reliable
        support everyone has the power to transform insights into impactful actions.</p>
    </div>
    <div class="spacer-large"></div>
    <div class="cta-holder align-middle">
      <a href="survey/" class="button is-dark-blue w-button">Create Survey</a>
      <div class="horizontal-spacer-xmedium"></div>
      <a href="./contact.php" class="button is-dark-blue-reverse w-button">Get in touch</a>
    </div>
  </div>
</div>
<div class="section-angled-shape"></div>
<div class="padding-large">
  <div class="section-how-are-we-different">
    <div class="container-medium">
      <div class="max-width-large text-align-center align-center">
        <h2>How It Works?</h2>
        <div class="spacer-medium"></div>
        <div class="text-size-xmedium text-colour-blue">We will help you collect the information you need quickly and
          easily. Trust us to safeguard your data and provide the support you need, when you need it.</div>
      </div>
      <div class="spacer-gigantic"></div>
      <div class="grid_3-col">
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189c8a-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/Sample_User_Icon.png" loading="lazy" alt="">
            </div>
            <h4>Step 1:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Sign Up or Log In to your account </p>
          </div>
        </div>
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189c93-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/Improvement.png" loading="lazy" alt="">
            </div>
            <h4>Step 2:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Create a new survey or choose a template from our library.</p>
          </div>
        </div>
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189c9c-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/simplicity.png" loading="lazy" alt="">
            </div>
            <h4>Step 3:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Customize your questions and answer types.</p>
          </div>
        </div>
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189ca5-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/pngtree-black-chemical-monomer-cartoon-image_1268045.jpg"
                loading="lazy" alt="">
            </div>
            <h4>Step 4:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Share your survey and gather responses in real-time</p>
          </div>
        </div>
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189cae-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/pngtree-positive-feedback-line-icon-vector-png-image_5199523.jpg"
                loading="lazy" alt="">
            </div>
            <h4>Step 5:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Get responces from Respodents with sharing Surveys</p>
          </div>
        </div>
        <div id="w-node-_98e68fbd-5890-bc5b-d76e-419859189cb7-59189c80" class="feature-item">
          <div class="feature-item_head">
            <div class="fa-icon-container_small">
              <img src="assets/user/main_web/image/expertise.png" loading="lazy" alt="">
            </div>
            <h4>Step 6:</h4>
          </div>
          <div class="feature-item_body">
            <p class="text-size-regular text-colour-blue">Analyze results with detailed reports and data visualization.
            </p>
          </div>
        </div>
      </div>
      <div class="safe-hands_block">
        <div class="safe-hands_flex">
          <div class="div-line"></div>
          <div class="small-flex">
            <img src="assets/user/main_web/image/hand.svg" loading="lazy" alt="Icon of a hand holding a heart"
              class="icon-medium">
            <div>You &#x27;re in safe hands</div>
          </div>
          <div class="div-line"></div>
        </div>
        <img src="assets/user/main_web/imgae/c_logo.png  " loading="lazy" width="888"
          sizes="(max-width: 479px) 91vw, (max-width: 767px) 94vw, (max-width: 991px) 92vw, 888px" alt=""
          class="safe-hands-logos">
      </div>
    </div>
  </div>
</div>
<div class="padding-large">
  <div class="section-how-are-we-different">
    <div class="container-medium">
      <div class="max-width-large text-align-center align-center">
        <h2>Give Feedback</h2>
        <div class="spacer-medium"></div>
        <div class="text-size-xmedium text-colour-blue">We will help you collect the information you need quickly and
          easily. Trust us to safeguard your data and provide the support you need, when you need it.</div>
      </div>
      <div class="section-map padding-huge">
<style>
  form {
  display: flex;
  flex-direction: row;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  padding: 20px;
  background-color: #fff; /* Background color for the form */
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Shadow effect */
  border-radius: 8px; /* Optional: rounded corners */
}

.form-group {
  display: flex;
  flex-direction: column;
  width: 23%;
  margin-bottom: 10px;
}

label {
  margin-bottom: 5px;
  color: #263146;
}

input[type="text"],
input[type="email"],
select,
textarea {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
  border: 2px solid #263146;
}

input[type="submit"] {
  padding: 10px 20px;
  background-color: #263146;
  color: white;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #1b2534;
}

/* Ensure textarea spans correctly */
textarea {
  resize: vertical;
}

/* Optional styling for focused inputs */
input[type="text"]:focus,
input[type="email"]:focus,
select:focus,
textarea:focus {
  outline: none;
  border-color: #1b2534;
}

</style>
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
</div>
<?php
include "footer.php";
?>