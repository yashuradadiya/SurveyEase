<?php
try {
  require("../script.php");
} catch (Exception $e) {
  $msg = "something Went Wrong";
}
?>
<?php
session_start();
if (isset($_SESSION['admin_id'])) {
  header("location:dashboard.php");
} else {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  if (isset($_SESSION['msg'])) {
    $msg = $_SESSION['msg'];
    $emails = $_SESSION['email'];
    unset($_SESSION['msg']);
    unset($_SESSION['email']);
  }
  if (isset($_POST['login'])) {
    @$email = $_POST['email'];
    @$password = $_POST['password'];
    $sql = "SELECT * FROM admin WHERE Email='$email' and Password='$password';";
    $res = mysqli_query($con, $sql);
    $cnt = mysqli_num_rows($res);
    $row = mysqli_fetch_assoc($res);
    if ($cnt == 0) {
      $msg = "Invalid Email or Password";
    } else {

      $random_number = rand(100000, 999999);
      $sub = "Your OTP for Signing In to SurveyEase";
      $message = '
        <div style="color: #000;!important">
          <p>Dear ' . $row['Name'] . ',</p>
          <p>To securely sign in to your <strong>SurveyEase</strong> account, please use the following One-Time Password (OTP):</p>
          <p><strong>Your OTP: ' . $random_number . '</strong></p>
          <p>If you did not request this, please ignore this email or contact our support team for assistance.</p>
        </div>
        <p>Thank you,<br>
            The SurveyEase Team<br>
        </p>
    ';
      $responce = sendMail($email, $sub, $message);
      if ($responce == 'true') {
        $_SESSION['otp_admin_login'] = $random_number;
        $_SESSION['login_email'] = $email;
        $_SESSION['login_password'] = $password;
        header("location:otp.php");
      } else {
        @$msg = $responce;
      }

    }
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
  <title>Admin | Login</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
<script src="../script_form.js"></script>
  <div>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <?php
          if (@$msg) {
            echo $msg;
          }
          ?>
          <form method="post" onsubmit="return validateForm('surveyForm')">
            <h1>Admin Login</h1>
            <div>
              <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo @$emails; ?>"
                required />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>
            <div>
              <button type="submit" name="login" value="submit" class="btn btn_success btn-block">Login</button>
            </div>
            <div class="clearfix"></div>
            <div class="separator">
              <p class="change_link">New Admin?
                <a href="signup.php" class="to_register"> Create Account </a>
              </p>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>

</html>