<?php
session_start();
if (isset($_SESSION['user_id'])) {
   header("location:index.php");
} else {
   @$msg = '';
   $con = mysqli_connect("localhost", "root", "", "online_survey_system");
   if (isset($_POST['login'])) {
      @$email = $_POST['email'];
      @$password = $_POST['password'];
      $sql = "select * from user where Email='$email' and Password='$password';";
      $res = mysqli_query($con, $sql);
      $cnt = mysqli_num_rows($res);
      if ($cnt == 0) {
         @$msg = "Invalid Email or Password";
      } else {
         $row = mysqli_fetch_assoc($res);
         $_SESSION['user_id'] = $row['ID'];
         if (isset($_SESSION['redirect_to'])) {
            $redirect = $_SESSION['redirect_to'];
            header("location:survey.php?survey=$redirect");
         } else {
            header("location:index.php");
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
   <title>Login | Survey Creator</title>
   <link href="assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <link href="assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
   <link href="assets/panel/vendors/animate.css/animate.min.css" rel="stylesheet">
   <link href="assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="login">
   <div>
      <div class="login_wrapper">
         <div class="animate form login_form">
            <section class="login_content">
               <?php
               if (@$msg) {
                  echo $msg;
               }
               ?>
               <form method="post">
                  <h1>Access Survey</h1>
                  <div>
                     <input type="email" class="form-control" placeholder="Email" name="email"
                        value="<?php echo @$emails; ?>" required />
                  </div>
                  <div>
                     <input type="password" class="form-control" placeholder="password" name="password" required />
                  </div>
                  <div>
                     <button type="submit" name="login" value="submit" class="btn btn-success btn_success btn-block">Login</button>
                  </div>
                  <div class="clearfix"></div>
                  <div class="separator">
                     <p class="change_link">New Reapodent?
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