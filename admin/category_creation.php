<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
}

$con = mysqli_connect("localhost", "root", "", "online_survey_system");
$sql_a = "SELECT * FROM admin;";
$res_a = mysqli_query($con, $sql_a);
if (isset($_GET['edit_catgory'])) {
  $data_id = $_GET['edit_catgory'];
  $sql_edit = "SELECT * FROM survey_category WHERE ID = " . $data_id;
  $res_edit = mysqli_query($con, $sql_edit);
  $row = mysqli_fetch_assoc($res_edit);
  if (isset($_POST['save'])) {
    $category = @$_POST['category'];
    $sql = "UPDATE survey_category set Category='$category' WHERE ID = " . $data_id;
    $res = mysqli_query($con, $sql);
    header("location:category.php");
  }
} else {

  if (isset($_POST['save'])) {
    $category = @$_POST['category'];
    $sql_int = "INSERT INTO survey_category (Category) VALUES ('$category');";
    $res_int = mysqli_query($con, $sql_int);
    header("location:category.php");
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

  <title>Admin | Category Craetion</title>
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
                  <h2>Category </h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <form method="post" novalidate enctype="multipart/form-data">
                    <div class="field item form-group">
                      <label class="col-form-label col-md-3 col-sm-3  label-align">Category
                      </label>
                      <div class="col-md-6 col-sm-6">
                        <input class="form-control" data-validate-length-range="6" data-validate-words="2"
                          name="category" value="<?php echo @$row['Category']; ?>" />
                      </div>
                    </div>
                    <div class="ln_solid">
                      <div class="form-group">
                        <div class="col-md-6 offset-md-3">
                          <button type='submit' class="btn btn-primary" name="save" value="submit">Submit</button>
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


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
  <script src="../assets/panel/vendors/validator/multifield.js"></script>
  <script src="../assets/panel/vendors/validator/validator.js"></script>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>

</body>

</html>