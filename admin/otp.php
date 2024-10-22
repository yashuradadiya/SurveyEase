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
  if (isset($_GET['resend'])) {
    print_r($_SESSION);
    if (isset($_SESSION['otp_admin']) || isset($_SESSION['otp_admin_login'])) {
      $random_number = rand(100000, 999999);
      if (isset($_SESSION['otp_admin_login'])) {
        $sql_creator = "SELECT * FROM admin WHERE Email='" . $_SESSION['login_email'] . "' and Password='" . $_SESSION['login_password'] . "';";
        $res = mysqli_query($con, $sql_creator);
        $row = mysqli_fetch_assoc($res);
        $name = $row['Name'];
        $email = $row['Email'];
        $_SESSION['otp_admin_login'] = $random_number;
      } elseif (isset($_SESSION['otp_admin'])) {
        $_SESSION['otp_admin'] = $random_number;
        $name = $_SESSION["admin_name"];
        $email = $_SESSION["admin_email"];
      }
      $sub = "Verify Your Email with SurveyEase";
      $message = '
    <div style="color: #000;!important">
      <h2>Welcome to SurveyEase!</h2>
      <p>Dear ' . $name . ',</p>
      <p>As requested, here is your new One-Time Password (OTP) to continue with your [sign-in/sign-up] on <strong>SurveyEase</strong>:</p>
      <p><strong>Your OTP: ' . $random_number . '</strong></p>
      <p>Thank you for choosing <strong>SurveyEase!</strong></p>
    </div>
    <p>Thank you,<br>
      The SurveyEase Team<br>
    </p>
    ';
      $responce = sendMail($email, $sub, $message);
      if ($responce == 'true') {
        header("location:otp.php");
      } else {
        @$msg = $responce;
      }
    }
  }
  if (isset($_POST['submit'])) {
    $otp1 = $_POST['otp1'];
    $otp2 = $_POST['otp2'];
    $otp3 = $_POST['otp3'];
    $otp4 = $_POST['otp4'];
    $otp5 = $_POST['otp5'];
    $otp6 = $_POST['otp6'];
    $user_otp = strval($otp1) . strval($otp2) . strval($otp3) . strval($otp4) . strval($otp5) . strval($otp6);


    if (isset($_SESSION['otp_admin'])) {
      $otp = $_SESSION['otp_admin'];
      $name = $_SESSION['admin_name'];
      $email = $_SESSION['admin_email'];
      $contact = $_SESSION['admin_contact'];
      $address = $_SESSION['admin_address'];
      $password = $_SESSION['admin_password'];
      if ($user_otp == strval($otp)) {
        $sql = "insert into admin (Name,Email,Contact,Address,Password) values ('$name','$email','$contact','$address','$password');";
        $res = mysqli_query($con, $sql);
        @$admin_id = mysqli_insert_id($con);
        $_SESSION['admin_id'] = $admin_id;
        unset($_SESSION['admin_name'], $_SESSION['admin_address'], $_SESSION['admin_contact'], $_SESSION['admin_email'], $_SESSION['admin_password'], $_SESSION['otp_admin']);

      } else {
        $msg = "Please Enter Correct OTP";
      }
    } else if (isset($_SESSION['otp_admin_login'])) {
      $otp = $_SESSION['otp_admin_login'];
      $email = $_SESSION['login_email'];
      $password = $_SESSION['login_password'];

      if ($user_otp == strval($otp)) {
        $sql = "SELECT * FROM admin WHERE Email='$email' and Password='$password';";
        $res = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($res);
        $_SESSION['admin_id'] = $row['ID'];
        unset($_SESSION['login_email'], $_SESSION['login_password'], $_SESSION['otp_admin_login']);
      } else {
        $msg = "Please Enter Correct OTP";
      }
    }
    if (isset($_SESSION['user_template'])) {
      header("location:" . $_SESSION['user_template']);
    } else if (isset($_SESSION['admin_id'])) {
      header("location:dashboard.php");
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin | OTP Verification</title>
  <link href="../assets/panel/build/otp/otp.css" rel="stylesheet">
</head>

<body>
  <div class="otp-container">
  <div>
    <p>
      <?php echo @$msg; ?>
    </p>
  </div>
    <h1>OTP Verification</h1>
    <p>Please enter the 6-digit code sent to your email.</p>

    <form method="post">
      <div class="otp-input-container">
        <input type="text" maxlength="1" name="otp1" oninput="moveToNext(this, 'otp2')"
          onkeydown="moveToPrevious(event, this, null)">
        <input type="text" maxlength="1" name="otp2" oninput="moveToNext(this, 'otp3')"
          onkeydown="moveToPrevious(event, this, 'otp1')">
        <input type="text" maxlength="1" name="otp3" oninput="moveToNext(this, 'otp4')"
          onkeydown="moveToPrevious(event, this, 'otp2')">
        <input type="text" maxlength="1" name="otp4" oninput="moveToNext(this, 'otp5')"
          onkeydown="moveToPrevious(event, this, 'otp3')">
        <input type="text" maxlength="1" name="otp5" oninput="moveToNext(this, 'otp6')"
          onkeydown="moveToPrevious(event, this, 'otp4')">
        <input type="text" maxlength="1" name="otp6" oninput="moveToNext(this, null)"
          onkeydown="moveToPrevious(event, this, 'otp5')">
      </div>

      <input type="submit" class="submit-btn" name="submit" value="Submit">
    </form>

    <div class="resend">
      Didn't receive the OTP? <a href="otp.php?resend=true">Resend OTP</a>
    </div>
  </div>

  <script>
    // Function to move to the next input when the current input is filled
    function moveToNext(current, nextFieldId) {
      if (current.value.length === current.maxLength) {
        if (nextFieldId) {
          document.getElementsByName(nextFieldId)[0].focus();
        }
      }
    }

    // Function to move to the previous input when the user presses backspace and the field is empty
    function moveToPrevious(event, current, prevFieldId) {
      if (event.key === "Backspace" && current.value === "") {
        if (prevFieldId) {
          document.getElementsByName(prevFieldId)[0].focus();
        }
      }
    }
  </script>
</body>

</html>