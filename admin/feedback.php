<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
  header("location:index.php");
} {
  $con = mysqli_connect("localhost", "root", "", "online_survey_system");
  $feedback_sql = "SELECT * FROM user_feedback";
  $feedback_res = mysqli_query($con, $feedback_sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Feedbackes & Queries - Admin</title>

  <link href="../assets/panel/css/jquery.dataTables.min.css">
  <link href="../assets/panel/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/nprogress/nprogress.css" rel="stylesheet">
  <link href="../assets/panel/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
  <link href="../assets/panel/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
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
            <div class="col-md-12 col-sm-12 ">
              <div class="x_panel">
                <div class="x_title">
                  <h2>User Feedback & Queries</h2>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="card-box table-responsive">
                        <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Subject</th>
                              <th>Message</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $cnt = 1;
                            while ($row = mysqli_fetch_assoc($feedback_res)) {
                              ?>
                              <tr>
                                <td><?php echo $cnt; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['Email']; ?></td>
                                <td><?php echo $row['Subject']; ?></td>
                                <td><?php echo $row['Message']; ?></td>
                              </tr>
                              <?php $cnt++;
                            } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/panel/vendors/jquery/dist/jquery.min.js"></script>
  <script src="../assets/panel/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/panel/vendors/fastclick/lib/fastclick.js"></script>
  <script src="../assets/panel/vendors/nprogress/nprogress.js"></script>
  <script src="../assets/panel/vendors/iCheck/icheck.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../assets/panel/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
  <script src="../assets/panel/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
  <script src="../assets/panel/vendors/jszip/dist/jszip.min.js"></script>
  <script src="../assets/panel/vendors/pdfmake/build/pdfmake.min.js"></script>
  <script src="../assets/panel/vendors/pdfmake/build/vfs_fonts.js"></script>
  <script src="../assets/panel/build/js/custom.min.js"></script>
</body>

</html>