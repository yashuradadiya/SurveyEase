<?php
try {
  require("../script.php");
} catch (Exception $e) {
  $msg = "something Went Wrong";
}
?>
<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "online_survey_system");
if (isset($_POST['submit'])) {
  @$name = $_POST['name'];
  @$email = $_POST['email'];
  @$contact = $_POST['contact'];
  @$address = $_POST['address'];
  @$password = $_POST['password'];
  @$uppercase = preg_match('@[A-Z]@', $password);
  @$lowercase = preg_match('@[a-z]@', $password);
  @$number = preg_match('@[0-9]@', $password);
  @$specialChars = preg_match('@[^\w]@', $password);

  $sql_select = "SELECT * FROM admin WHERE Email='$email';";
  $res_select = mysqli_query($con, $sql_select);
  $cnt = mysqli_num_rows($res_select);
  if ($cnt <= 0) {
    $random_number = rand(100000, 999999);
    $sub = "Verify Your Email with SurveyEase";
    $message = '
    <div style="color: #000;!important">
      <h2>Welcome to SurveyEase!</h2>
      <p>Dear '.$name.',</p>
      <p>To complete your sign-up process, please verify your email address by using the following One-Time Password (OTP):</p>
      <p><strong>Your OTP: '.$random_number.'</strong></p>
      <p>Thank you for choosing <strong>SurveyEase!</strong></p>
    </div>
    <p>Thank you,<br>
      The SurveyEase Team<br>
    </p>
    ';
    $responce = sendMail($email,$sub,$message);
    if ($responce=='true'){
      $_SESSION['otp_survey'] = $random_number;
      $_SESSION['admin_name'] = $name;
      $_SESSION['admin_email'] = $email;
      $_SESSION['admin_contact'] = $contact;
      $_SESSION['admin_address'] = $address;
      $_SESSION['admin_password'] = $password;
      $_SESSION['admin_sub'] = $sub;
      header("location:otp.php");
    }else {
      @$msg = $responce;
    }
  } else {
    $_SESSION['msg'] = "You are already registered";
    $_SESSION['email'] = $email;
    header("location:index.php");
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
  <title>Sign-up | Admin</title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/animate.css/animate.min.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
  <div>
    <div class="login_wrapper">
      <div id="register" class="animate form login_form">
        <section class="login_content">
          <form method="post">
            <h1>Admin Register</h1>
            <div>
              <input type="text" class="form-control" placeholder="User name" name="name" required />
            </div>
            <div>
              <input type="text" name="contact" class="form-control" placeholder="Contact Number" required />
            </div>
            <div>
              <div>
                <input type="email" class="form-control" placeholder="Email" name="email" required>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Address" name="address" required>
              </div>
              <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>
            <div>
              <button type="submit" name="submit" value="submit" class="btn btn-success btn-block">Register</button>
            </div>
            <div class="separator">
              <p class="change_link">Already Admin ?
                <a href="index.php" class="to_register"> Log in </a>
              </p>
              <div class="clearfix"></div>
              <br />
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
</body>
</html>