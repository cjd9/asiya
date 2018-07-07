<?php if($this->session->userdata('user_type') != "P"){
	header('Location: '.base_url('dashboard'));
} ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title> :: Clinic Management System :: </title>

        <link href="<?php print base_url(); ?>css/style.default.css" rel="stylesheet">
        <link href="<?php print base_url(); ?>css/morris.css" rel="stylesheet">
		<link href="<?php print base_url(); ?>css/bootstrap-timepicker.min.css" rel="stylesheet" />
        <link href="<?php print base_url(); ?>css/select2.css" rel="stylesheet" />
		<link href="<?php print base_url(); ?>css/bootstrap-wysihtml5.css" rel="stylesheet" />
		<link href="<?php print base_url(); ?>css/marquee_animation.css" rel="stylesheet" />

		<!-- below css added for datatables -->
		<link href="<?php print base_url(); ?>css/style.datatables.css" rel="stylesheet">
        <link href="<?php print base_url(); ?>css/dataTables.responsive.css" rel="stylesheet">
		<link href="<?php print base_url(); ?>css/dataTables.bootstrap.css" rel="stylesheet">
		
		<!-- Start Validation CSS -->
		<!-- below js added for validation engine -->
		<link rel="stylesheet" href="<?php echo base_url();?>js/my_js/validation/css/validationEngine.jquery.css" type="text/css"/>
		<!-- End Validation CSS -->
		
		<!-- User Added CSS for Watermark and autocomplete in appointment schedule -->
		<link href="<?php print base_url(); ?>css/watermark.css" rel="stylesheet" />
	
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
		
    </head>

    <body>
        <header>
            <div class="headerwrapper">
                <div class="header-left">
                   <!-- <a href="#" class="logo">
                     	<img src="<?php print base_url(); ?>images/logo-2.jpg"  style="height:30px; width:280px; padding:0px 0px 0px 0px"> 
                    </a>-->
					
                    <div class="pull-right">
                        <a href="#" class="menu-collapse">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                </div><!-- header-left -->
                
                <div class="header-right">
					 <div class="pull-left">
						<!--<img src="<?php print base_url(); ?>images/logo.png" style="height:35px; width:50px;"/>-->
					</div>
					
                    <div class="pull-right">
					
						<div class="btn-group btn-group-list btn-group-notification">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            	<i class="fa fa-user"></i> <span style="color:#FFFFFF"><b><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></b></span>
                            </button>
                        </div><!-- btn-group -->
                        
                        <div class="btn-group btn-group-option">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                              <i class="fa fa-caret-down"></i>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                              <!--<li><a href="" data-toggle="modal" data-target="#myModal_pass"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>-->
							  <li><a href="" data-toggle="modal" data-target="#myModal_pass"><i class="glyphicon glyphicon-wrench"></i>Change Pasword</a></li>
                              <li class="divider"></li>
                              <li><a href="<?php echo base_url().'login/p_logout'; ?>"><i class="glyphicon glyphicon-log-out"></i>Sign Out</a></li>
                            </ul>
                        </div><!-- btn-group -->
                    </div><!-- pull-right -->
                </div><!-- header-right -->
            </div><!-- headerwrapper -->
        </header>
		
		<!-- Modal -->
		<div class="modal fade" id="myModal_pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h4 class="modal-title" id="myModalLabel">Change Password Setting</h4>
					</div>
					<div class="modal-body">
						<form id="add_change_pass" action="<?php echo base_url().'login/p_change_password'; ?>" method="post" enctype="multipart/form-data" onSubmit="return paass_validate()">
														
							<div class="form-group">
								<label class="col-sm-4 control-label">Enter Current Password</label>
								<div class="col-sm-8">
									<input type="password" name="current_password" id="current_password" class="form-control validate[required]" placeholder="Type Current Password"/>
									<span id="error_msg" class="alert-error"></span>
									
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-sm-2 control-label"></label>
								<label class="col-sm-10 control-label"><b>(Password should be Alphanumeric & Special Characters.)</b></label>	
							</div>
							
							<div class="form-group">
								<label class="col-sm-4 control-label">Enter New Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control validate[required]" placeholder="Type New Password" name="new_password" id="new_password" onkeyup='CheckPasswordStrength(this.value);'><span id='pwd_strength'></span>
									
									
								</div>
							</div><!-- form-group -->	
							
							<div class="form-group">
								<label class="col-sm-4 control-label">Confirm New Password</label>
								<div class="col-sm-8">
									<input type="password" class="form-control validate[required,equals[password]" placeholder="Type New Password Again" name="confirm_password" id="confirm_password">
									<br><span id="error_msg1" class="alert-error"></span>
									
								</div>
							</div><!-- form-group -->
						
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Update Password</button> &nbsp;
						<button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
					</div>
				</form>
				</div>

				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
