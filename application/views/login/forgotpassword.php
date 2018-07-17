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
					 <a class="btn btn-primary btn-metro" href="http://asiya.co.in/" style="color: white"><b><span class="fa fa-home"></span> HOME</b></a>
				</h5></b>
			</div>
			<div align="center" style="margin-top:3%">
			</div>
			<div class="panel panel-signin" style="background-color: white; max-width: 425px;" />

				<div class="panel panel-signin fgp">
					<div class="panel-body">
						<div class="logo text-center">
							<img src="<?php print base_url(); ?>images/Asiya.png">
							<h3 class="text-left" style="font-weight:500">Forgot Password</h3>
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
								<input type="text" name="email_mobile" id="email_mobile" class="form-control" placeholder="Mobile No">
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
									 <button type="submit" class="btn btn-success btn-metro" style="color: white;"> <b>SUBMIT</b></i></button>
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
