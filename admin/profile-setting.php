<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
}

$con = mysqli_connect("localhost", "root", "", "online_survey_system");
$sql_a = "SELECT * FROM admin;";
$res_a = mysqli_query($con, $sql_a);
if (isset($_SESSION['admin_id'])) {
  $data_id = $_SESSION['admin_id'];
  $sql_edit = "SELECT * FROM admin WHERE ID = " . $data_id;
  $res_edit = mysqli_query($con, $sql_edit);
  $row = mysqli_fetch_assoc($res_edit);
  if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['phone'];
    $address = $_POST['address'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], '../assets/panel/images/admin_image/' . $image);
    if ($_FILES['image']['name'] == "") {
      $image = $row['Image'];
    }
    $sql = "update admin set Name='$name',Email='$email',Contact=$contact,Address='$address',Image='$image' WHERE ID = " . $data_id;
    $res = mysqli_query($con, $sql);
    header("location:profile.php");
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

  <title>Admin | Profile-Setting </title>
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php
      include("sidebar.php");
      ?>
      <div class="right_col" role="main">
        <div class="">
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-sm-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Profile - Setting </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form method="post" novalidate enctype="multipart/form-data">
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Name
                      </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" data-validate-length-range="6" data-validate-words="2" name="name"
                          value="<?php echo @$row['Name']; ?>" />
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Email </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" name="email" class='email' type="email"
                          value="<?php echo @$row['Email']; ?>" />
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Telephone
                      </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="tel" class='tel' name="phone" required='required'
                          value="<?php echo @$row['Contact']; ?>" data-validate-length-range="8,20" />
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Address
                      </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" data-validate-length-range="3" data-validate-words="1"
                          name="address" value="<?php echo @$row['Address']; ?>" />
                      </div>
                    </div>
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Image
                      </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="file" name="image" value="<?php echo @$row['Image']; ?>" />
                      </div>
                    </div>
                    <div class="ln_solid">
                      <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                          <button type='submit' class="btn btn-primary" name="save" value="submit">Submit</button>
                          <button type='reset' class="btn btn-success">Reset</button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer>
    <div class="pull-right">
      Copyright &copy; 2024 <a href="../../SurveyEase/">SurveyEase</a>
    </div>
    <div class="clearfix"></div>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="../assets/panel/vendors/validator/multifield.js"></script>
  <script src="../assets/panel/vendors/validator/validator.js"></script>
  <script>
    function hideshow() {
      var password = document.getElementById("password1");
      var slash = document.getElementById("slash");
      var eye = document.getElementById("eye");

      if (password.type === 'password') {
        password.type = "text";
        slash.style.display = "block";
        eye.style.display = "none";
      }
      else {
        password.type = "password";
        slash.style.display = "none";
        eye.style.display = "block";
      }

    }
  </script>

  <script>
    var validator = new FormValidator({
      "events": ['blur', 'input', 'change']
    }, document.forms[0]);
    document.forms[0].onsubmit = function (e) {
      var submit = true,
        validatorResult = validator.checkAll(this);
      console.log(validatorResult);
      return !!validatorResult.valid;
    };
    document.forms[0].onreset = function (e) {
      validator.reset();
    };
    $('.toggleValidationTooltips').change(function () {
      validator.settings.alerts = !this.checked;
      if (this.checked)
        $('form .alert').remove();
    }).prop('checked', false);

  </script>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>

</body>

</html>