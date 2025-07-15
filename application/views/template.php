<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Project Monitoring System</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css">
  <!-- Fontastic Custom icon font-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontastic.css">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.default.css" id="theme-stylesheet">
  <!-- Datatables -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/DataTables/datatables.min.css">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.3.0/print.js"></script>
</head>

<body>
  <div class="page">
    <!-- Main Navbar-->
    <header class="header">
      <nav class="navbar">
        <div class="container-fluid">
          <div class="navbar-holder d-flex align-items-center justify-content-between">
            <!-- Navbar Header-->
            <div class="navbar-header">
              <!-- Navbar Brand --><a href="#" class="navbar-brand">
                <div class="brand-text brand-big"><span>PMS</span></div>
                <div class="brand-text brand-small">pms</div>
              </a>
              <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
            </div>
            <!-- Navbar Menu -->
            <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
              <!-- Logout    -->
              <li class="nav-item"><a href="<?php echo base_url('index.php/admin/logout') ?>" class="nav-link logout">Logout<i class="fa fa-power-off"></i></a></li>

            </ul>
          </div>
        </div>
      </nav>
    </header>
    <div class="page-content d-flex">
      <!-- Side Navbar -->
      <nav class="side-navbar text-light bg-dark">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">

          <?php $a = $this->session->userdata('userid');
          if ($a > 0) { ?>
            <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/avatar.png" alt="User Icon" class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4 text-light"><?= $this->session->userdata('fullname') ?></h1>
              <p><?= $this->session->userdata('level') ?></p>
              <a href="#change" data-toggle="modal">Change Password</a>
            </div>
          <?php } else { ?>
            <div class="avatar"><img src="<?php echo base_url(); ?>assets/img/guest.jpg" alt="User Icon" class="img-fluid rounded-circle"></div>
            <div class="title">
              <h1 class="h4 text-light"><?= $this->session->userdata('fullname') ?></h1>
            </div>
          <?php } ?>
        </div>
        <!-- Sidebar Navidation Menus-->
        <hr>
        <ul class="list-unstyled">
          <li>
            <a class="active" href="<?php echo base_url('index.php/Dashboard'); ?>">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <?php
          $mauth = $this->session->userdata('autho');
          if (strpos($mauth, '100') > -1) {
            echo '                                          
                  <li><a href="' . base_url('index.php/Road') . '"><i class="fa fa-car"></i><span>Road Management</span></a></li>';
          }
          if (strpos($mauth, '110') > -1) {
            echo '                                          
                  <li><a href="' . base_url('index.php/Project') . '"><i class="fa fa-bus"></i><span>Package Management</span></a></li>';
          }
          if (strpos($mauth, '120') > -1) {
            echo '                                          
                  <li><a href="' . base_url('index.php/Item') . '"><i class="fa fa-book"></i><span>Item Management</span></a></li>';
          }
          if (strpos($mauth, '130') > -1) {
            echo '                                          
                  <li><a href="' . base_url('index.php/Section') . '"><i class="fa fa-credit-card-alt"></i><span>Section Management</span></a></li>';
          }
          if (strpos($mauth, '150') > -1) {
            echo '                                          
                  <li><a href="' . base_url('index.php/Schedule') . '"><i class="fa fa-bullseye"></i><span>Location Item Management </span></a></li>';
          }
          if (strpos($mauth, '160') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Stage') . '"><i class="fa fa-bars"></i><span>Stage item Management </span></a></li>';
          }
          if (strpos($mauth, '170') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Weightage') . '"><i class="fa fa-bandcamp"></i><span>Weightage Management</span></a></li>';
          }
          if (strpos($mauth, '180') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Financial') . '"><i class="fa fa-dollar"></i><span>Financial Progress</span></a></li>';
          }
          if (strpos($mauth, '190') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Maintenance') . '"><i class="fa fa-truck"></i><span>Maintenance  Activity</span></a></li>';
          }
          if (strpos($mauth, '200') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Report') . '"><i class="fa fa-print"></i><span>Reports</span></a></li>';
          }
          if (strpos($mauth, '210') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/user') . '"><i class="fa fa-users"></i><span>User Management</span></a></li>';
          }
          if (strpos($mauth, '220') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Payflow') . '"><i class="fa fa-dollar"></i><span>Payment Flow Management</span></a></li>';
          }
          if (strpos($mauth, '230') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Hindrance') . '"><i class="fa fa-bug"></i><span>Hindrance</span></a></li>';
          }
          if (strpos($mauth, '240') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Photo') . '"><i class="fa fa-image"></i><span>Resource Management</span></a></li>';
          }
          if (strpos($mauth, '250') > -1) {
            echo ' 
                    <li><a href="' . base_url('index.php/Punchlist') . '"><i class="fa fa-book"></i><span>Punch List Management</span></a></li>';
          }
          if (strpos($mauth, '260') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Drawings') . '"><i class="fa fa-book"></i><span>Drawing Management</span></a></li>';
          }
          if (strpos($mauth, '270') > -1) {
            echo ' 
                    <li><a href="' . base_url('index.php/Rfi') . '"><i class="fa fa-book"></i><span>Request for Inspection</span></a></li>';
          }
          if (strpos($mauth, '290') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/Contractor') . '"><i class="fa fa-book"></i><span>Contractor Management</span></a></li>';
          }
          if (strpos($mauth, '300') > -1) {
            echo ' 
                  <li><a href="' . base_url('index.php/PaymentMethod') . '"><i class="fa fa-inr"></i><span>Payment Accept</span></a></li>';
          }
          ?>
        </ul>
      </nav>
      <div class="content-inner">
        <?php
        $this->load->view($content);
        ?>
      </div>
      <div class="modal fade" id="change">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              Change User Password
            </div>
            <form action="<?= base_url('index.php/user/user_update') ?>" method="post">
              <div class="modal-body">
                <div class="form-group row">
                  <div class="col-sm-3 offset-1"><label>Enter New password</label></div>
                  <div class="col-sm-7">
                    <input type="password" name="npassword" id="npassword" required class="form-control" onchange="javascript:checkmatch()" ;>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-3 offset-1"><label>Re-enter Password</label></div>
                  <div class="col-sm-7">
                    <input type="Text" name="rpassword" id="rpassword" required class="form-control" onchange="javascript:checkmatch()" ;>
                  </div>
                </div>
                <p style="font-size:20px;color:red;" id="msg1"></p>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  <input type="submit" name="change" value="Update" class="btn btn-success">
                </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    function checkmatch() {
      var a = document.getElementById("npassword").value;
      var b = document.getElementById("rpassword").value;
      if (a == b) {
        document.getElementById("msg1").innerHTML = '';
      } else {
        document.getElementById("msg1").innerHTML = "Both password not matched";
      }

    }
  </script>

  <!-- JavaScript files-->
  <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js"> </script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/DataTables/datatables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"> </script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>

  <!-- Main File-->
  <script src="<?php echo base_url(); ?>assets/js/front.js"></script>
</body>

</html>