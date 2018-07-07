<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> :: Clinic Management System -  Login :: </title>

        <link href="<?php print base_url(); ?>css/staff_login_style.default.css" rel="stylesheet">
		<link href="<?php print base_url(); ?>css/select2.css" rel="stylesheet" />

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

	</head>
<style>
select {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    padding: 5px;

    width: 156.8px;
}

</style>
	<body class="signin">
		<section>
			<div align="left">
				<b><h5>
						<a href="<?php print base_url(); ?>" ><b>&nbsp;&nbsp;&nbsp;<span class="fa fa-home"></span> HOME</b></a>
				</h5></b>
			</div>
			<div align="center" style="margin-top:3%">
				<h1 class="style1" style="text-transform:uppercase"> <b>Asiya Center of Physiotherapy & Rehabilitation</b></h1>
			</div>
			<div class="panel panel-signin" style="border:15px solid rgba(150, 150, 146, 0.24)" />

				<div class="panel panel-signin">
					<div class="panel-body">
						<div class="logo text-center" style="margin-top:-110px">
							<img src="<?php print base_url(); ?>images/sp_logo.png">
							<h4><b>Enter your Email ID or Mobile No</b></h4>
						</div>

						<?php if($this->session->flashdata('message') != '' )
						{
						?>
							<p class="text-center"><?php echo flash_message(); ?></p>
						<?php
						}
						?>

						<div class="mb30"></div>

						<form action="<?php echo base_url().'login/forgot_password_reset'; ?>" id="main_form" method="post">
							<div class="input-group mb15">
								<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
								<input type="text" name="email_mobile" id="email_mobile" class="form-control" placeholder="Email or Mobile">
							</div><!-- input-group -->

							
              <div class="input-group mb15">
								<span class="input-group-addon"><i class="glyphicon glyphicon-tag"></i></span>
                  <select class="form-control" name="user_type">
                    <option value="P">Patient</option>
                    <option value="S">Staff</option>
                 </select>
							</div><!-- input-group -->

							<div class="clearfix">
								<div class="pull-right">
									 <button type="submit" class="btn btn-success btn-metro"><b>SUBMIT</b> <i class="fa fa-unlock ml5"></i></button>
								</div>
							</div>
						</form>
					</div><!-- panel-body -->
				</div><!-- panel -->
			</div>
		</section>

	<script src="<?php print base_url(); ?>js/jquery-1.11.1.min.js"></script>
	<script src="<?php print base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
	<script src="<?php print base_url(); ?>js/jquery-ui-1.10.3.min.js"></script>
	<script src="<?php print base_url(); ?>js/bootstrap.min.js"></script>
	<script src="<?php print base_url(); ?>js/modernizr.min.js"></script>
	<script src="<?php print base_url(); ?>js/pace.min.js"></script>
	<script src="<?php print base_url(); ?>js/retina.min.js"></script>
	<script src="<?php print base_url(); ?>js/jquery.cookies.js"></script>
	<script src="<?php print base_url(); ?>js/select2.min.js"></script>

	<script src="<?php print base_url(); ?>js/custom.js"></script>
  <script>

    $('body').on('click','#select_form',function(){
       $('#main_form').attr('action',$(this).val())
});
  </script>

	</body>
</html>
