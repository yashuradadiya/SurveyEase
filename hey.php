<?php require("script.php"); ?>
<?php

$random_number = rand(1000, 9999);
    $sub = "Verify Your Email with SurveyEase";
    $message = '
    <div style="color: #000;!important">
      <h2>Welcome to SurveyEase!</h2>
      <p>Dear yashu,</p>
      <p>To complete your sign-up process, please verify your email address by using the following One-Time Password (OTP):</p>
      <p><strong>Your OTP: '.$random_number.'</strong></p>
      <p>Thank you for choosing <strong>SurveyEase!</strong></p>
    </div>
    ';
    // $responce = sendMail($email,$sub,"OTP");
$responce = sendMail('radadiyayashvi09@gmail.com', $sub, $message);

echo $responce;
?>