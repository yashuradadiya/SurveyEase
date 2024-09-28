<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "online_survey_system");
if (isset($_POST['submit'])) {
  @$name = $_POST['name'];
  @$email = $_POST['email'];
  @$contact = $_POST['contact'];
  @$password = $_POST['password'];
  @$uppercase = preg_match('@[A-Z]@', $password);
  @$lowercase = preg_match('@[a-z]@', $password);
  @$number = preg_match('@[0-9]@', $password);
  @$specialChars = preg_match('@[^\w]@', $password);
  $sql = "insert into user (Name,Contact,Email,Password) values ('$name','$contact','$email','$password');";
  mysqli_query($con, $sql);
  @$user_id = mysqli_insert_id($con) or die(mysqli_error($con));
  $_SESSION['user_id'] = $user_id;
  if (isset($_SESSION['redirect_to'])) {
    $redirect = $_SESSION['redirect_to'];
    header("location:survey.php?survey=$redirect");
    unset($_SESSION['redirect_to']);
  } else {
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
  <title>Sign-Up | Survey Creator</title>
  <link href="assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="assets/panel/vendors/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
  <div>
    <div class="login_wrapper">
      <div id="register" class="animate form login_form">
        <section class="login_content">
          <form method="post">
            <h1>Join Survey</h1>
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

              <input type="password" class="form-control" placeholder="Password" name="password" required />
            </div>
            <div>
              <button type="submit" name="submit" value="submit" class="btn btn-success btn_success btn-block">Register</button>
            </div>
            <div class="separator">
              <p class="change_link">Already a Survey Creator?
                <a href="login.php" class="to_register"> Log in </a>
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