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
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.default.css">
   
  </head>
  <body>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info align-items-center">
                <div class="d-flex flex-column justify-content-center align-items-center h-50">
                  <h1 class="text-center">Project Monitoring System (PMS)</h1>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <?php                         
                        $notification = $this->session->flashdata('message');
                        if($notification != NULL)
                        {
                          echo '
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                              '.$notification.'
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                              </div>
                          ';
                        } 
                    ?>
                  <form method="post" class="form-validate" action="<?php echo base_url('index.php/Admin/proses_login') ?>">
                        <h2 class="text-center mb-4 text-secondary">Login to PMS</h2>                      
                    <div class="form-group">
                      <input id="username" type="text" name="username" placeholder="User Id"  data-msg="Please enter your username" class="input-material">
                    </div>
                    <div class="form-group">
                      <input id="password" type="password" name="password" placeholder="Password"  data-msg="Please enter your password" class="input-material">
                    </div>

                   
                    <div class="d-flex align-items-center justify-content-end">
                       <a href="#forgetpass" data-toggle="modal" class="text-decoration-none fw-bold mr-3">Forget Password</a>
                       <input type="submit" name="submit" class="btn btn-primary " value="Login">
                       &nbsp; &nbsp; 
                       <input type="submit" name="guest" class="btn btn-success " value="Guest Login">                        
                    </div>                  
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" id="forgetpass">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				  Change user password
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
					</button>
				</div>
				<form action="<?=base_url('index.php/Admin/password_reset')?>" method="post">
					<div class="modal-body">
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Email</label></div>
							<div class="col-sm-6">
								<input type="text" name="email" required class="form-control">
							</div>
              <div class="col-sm-2">	
              <input type="submit" name="mail" value="OTP" class="btn btn-success">
							</div>
						</div>            
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Enter OTP</label></div>
							<div class="col-sm-7">
								<input type="text" name="otp"  class="form-control">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>New Password</label></div>
							<div class="col-sm-7">
								<input type="password" name="password"  class="form-control">
							</div>
						</div>		
          	<div class="form-group row">
							<div class="col-sm-3 offset-1"><label>Re-Type Password</label></div>
							<div class="col-sm-7">
								<input type="password" name="password"  class="form-control">
							</div>
						</div>		  			
					<div class="modal-footer justify-content-between">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<input type="submit" name="save" value="Save" class="btn btn-success">
					</div>
				</form>
			</div>
		</div>
	</div>
  

    <!-- JavaScript files-->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/popper.js/umd/popper.min.js"> </script>
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="<?php echo base_url(); ?>assets/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    
  </body>
</html>