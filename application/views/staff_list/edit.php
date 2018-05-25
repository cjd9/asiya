<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-edit"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Staff Registration</a></li>
									
								</ul>
								<h4>Edit Staff Registration</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<?php  
							$r = $rsstaff_list->row();
						 ?>
						
						<div class="row">
							<div class="col-md-12">
								<form id="edit_staff_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit Staff Registration</b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
										
											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-md-3 control-label">Staff ID</label>
													<div class="col-sm-6">
														<input type="text" id="staff_id" name="staff_id" class="form-control validate[required]" value="<?php echo $r->staff_id; ?>" readonly />
													</div>
												</div>
												
												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Joining</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="date_of_joining" id="date_of_joining" value="<?php echo date("d-m-Y",strtotime($r->date_of_joining)); ?>" />
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->
											
											<hr />
											
											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Staff Name</label>
													<div class="col-sm-3">
														<input type="text" id="s_fname" name="s_fname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_fname; ?>"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="s_mname" name="s_mname" class="form-control" value="<?php echo $r->s_mname; ?>"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="s_lname" name="s_lname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_lname; ?>"/>
													</div>
												</div>
												
												<div class="col-sm-6">												
													<label class="col-sm-4 control-label">Date Of Birth</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="s_dob" id="s_dob" value="<?php echo date("d-m-Y",strtotime($r->s_dob)); ?>">
														</div><!-- input-group --><span id="msg3" style="color:#FF0000"></span>
													</div>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<div class="col-sm-6">	
													<label class="col-sm-3 control-label">Gender</label>
													<div class="col-sm-6">
														<select id="select-templating1" name="s_gender" data-placeholder="Choose One" class="select2-container width100p">
															<option value="">Choose One</option>
															<option value="Male" <?php if($r->s_gender == "Male") { ?> selected="selected" <?php } ?>>Male</option>
															<option value="Female" <?php if($r->s_gender == "Female") { ?> selected="selected" <?php } ?>>Female</option>
														</select>
														<span id="msg2" class="" style="color:#FF0000"></span>
													</div>
												</div>
												
												<div class="col-sm-6">												
													<label class="col-sm-4 control-label">Religion<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<select id="s_religion_id" name="s_religion_id" data-placeholder="Choose Religion " class="select2-container width100p">
															<option value=""></option>
															<?php
																foreach ($rsreligion->result() as $r1) 
																{
															?>
															<option value="<?php echo $r1->pk; ?>" <?php if($r1->pk == $r->s_religion_id) { ?> selected="selected" <?php } ?>>
															<?php echo $r1->religion; ?></option>
															<?php	
																}		
															?>
														</select>
													</div>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<div class="col-sm-6">	
													<label class="col-sm-3 control-label"> Upload Photo</label>
													<div class="col-sm-9">
														<input type="file" id="staff_photo" name="staff_photo" class="form-control" value="" />
													</div>
												</div>
											</div><!-- form-group -->
											
											<h4>Contact Details</h4><hr />
											
											<div class="form-group">
												<div class="col-sm-6">	
													<label class="col-sm-3 control-label">Email</label>
													<div class="col-sm-9">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input type="email" id="s_email_id" name="s_email_id" class="form-control" value="<?php echo $r->s_email_id; ?>"/>
														</div><!-- input-group -->
													</div>
												</div>
												
												<div class="col-sm-6">	
													<label class="col-sm-4 control-label">Contact No.</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
															<input type="text" id="s_contact_no" name="s_contact_no" class="form-control" maxlength="10" value="<?php echo $r->s_contact_no; ?>"/>
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->
											
											<h4>Address Details</h4><hr />
											
											<div class="form-group">
												<div class="col-sm-6">	
													<label class="col-sm-3 control-label">Address</label>
													<div class="col-sm-9">
														<textarea rows="2" name="s_address" id="s_address" class="form-control validate[required]"><?php echo $r->s_address; ?></textarea> 
													</div>
												</div>
												
												<div class="col-sm-6">	
													<div class="form-group">
														<label class="col-sm-4 control-label">City</label>
														<div class="col-sm-6">
															<input type="text" id="s_city" name="s_city" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_city; ?>"/>
														</div>
													</div><!-- form-group -->
												</div>
												
												<div class="col-sm-6">	
													<div class="form-group">
														<label class="col-sm-4 control-label">State</label>
														<div class="col-sm-6">
															<input type="text" id="s_state" name="s_state" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_state; ?>"/>
														</div>
													</div><!-- form-group -->
												</div>
											</div><!-- form-group -->
											
											
											<div class="form-group">
												<div class="col-sm-6">	
													<label class="col-sm-3 control-label">Zip</label>
													<div class="col-sm-6">
														<input type="text" id="s_zip" name="s_zip" class="form-control" maxlength="7" value="<?php echo $r->s_zip; ?>"/>
													</div>
												</div>
												<div class="col-sm-6">	
													<div class="form-group">
														<label class="col-sm-4 control-label">Upload Resume</label>
														<div class="col-sm-6">
															<input type="file" id="staff_resume" name="staff_resume" class="form-control" />
														</div>
													</div><!-- form-group -->
												</div>
											</div><!-- form-group -->
											
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>index.php/staff_list" class="btn btn-dark">Cancel</a>
										</div>
									  </div>
									</div><!-- panel-footer -->  
								</div><!-- panel -->
								</form>
								
							</div><!-- col-md-6 -->
						</div><!--row -->
					</div><!-- contentpanel -->
					
				</div><!-- mainpanel -->
			</div><!-- mainwrapper -->
		</section>  
						
		<?php $this->load->view('include/footer'); ?>
		
	<script>
		$(document).ready(function()
		{
			$("#edit_staff_form").validationEngine({promptPosition: "topRight: -100"});
			
			// select box validations -
			$('#add_staff_form').on('submit', function() {
			
				$('#msg2').text('');
				
				if($('#select-templating1').val() == '' || $('#select-templating1').val() == null)
				{
					$('#msg2').text('This field is required');
					return false;
				}
				
			});	
		
		}); 
	</script>
	
    </body>
</html>