	<div class="modal-header">
	  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
	</div>
	
	<div class="modal-body">
	 
		<div class="contentpanel">
				
			<div class="row">
				<div class="col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<!-- panel-btns -->
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Staff Details</b></h3>
						</div><!-- panel-heading -->
						<?php  
							$r = $rsstaff_list->row();
						 ?>
						<div class="panel-body">
							<div class="row">
							
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-md-3 control-label">Staff ID</label>
										<div class="col-sm-6">
											: <?php echo $r->staff_id; ?>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Date Of Joining</label>
										<div class="col-sm-6">
											<div class="input-group">
												: <?php echo date("d-m-Y",strtotime($r->date_of_joining)); ?>
											</div><!-- input-group -->
										</div>
									</div>
								</div><!-- form-group -->
								
								<hr />
								
								<div class="form-group">
									<div class="col-sm-6">	
										<label class="col-sm-3 control-label"> Staff Photo</label>
										<div class="col-sm-6">: 
										  <?php if($r->staff_photo) { ?>
										  <img src="<?php print base_url().'../staff_upload_data/staff_photo/'.$r->staff_photo; ?>" height="40" width="80"  />
										  <?php } else { ?>
										  <img alt="" src="<?php print base_url(); ?>images/men.png" height="40" width="80" />
										  <?php } ?>										
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Staff Name</label>
										<div class="col-sm-6">
											: <?php echo $r->s_fname.' '.$r->s_mname.' '.$r->s_lname; ?>
										</div>
									</div>
									
									<div class="col-sm-6">												
										<label class="col-sm-4 control-label">Date Of Birth</label>
										<div class="col-sm-6">
											: <?php echo date("d-m-Y",strtotime($r->s_dob)); ?>
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<div class="col-sm-6">	
										<label class="col-sm-3 control-label">Gender</label>
										<div class="col-sm-6">
											: <?php if ($r->s_gender=="Male") { echo 'Male'; } ?>
											<?php if ($r->s_gender=="Female") { echo 'Female'; } ?>
										</div>
									</div>
									
									<div class="col-sm-6">												
										<label class="col-sm-4 control-label">Religion </label>
										<div class="col-sm-6">
											<b>:</b> <?php print $this->db->get_where('religion', array('pk' => $r->s_religion_id))->row()->religion; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<div class="col-sm-6">	
										<label class="col-sm-3 control-label">Email</label>
										<div class="col-sm-9">
											: <?php echo $r->s_email_id; ?>
										</div>
									</div>
									
									<div class="col-sm-6">	
										<label class="col-sm-4 control-label">Contact No.</label>
										<div class="col-sm-6">
											: <?php echo $r->s_contact_no; ?>
										</div>
									</div>
								</div><!-- form-group -->
								
								<h4>Address Details</h4><hr />
								
								<div class="form-group">
									<div class="col-sm-6">	
										<div class="form-group">
											<label class="col-sm-3 control-label">Address</label>
											<div class="col-sm-9">
												: <?php echo $r->s_address; ?> 
											</div>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<div class="col-sm-6">	
										<div class="form-group">
											<label class="col-sm-3 control-label">City</label>
											<div class="col-sm-6">
												: <?php echo $r->s_city; ?> 
											</div>
										</div><!-- form-group -->
									</div>	
									<div class="col-sm-6">	
										<label class="col-sm-4 control-label">State</label>
										<div class="col-sm-6">
											: <?php echo $r->s_state; ?>
										</div>
									</div>
								</div><!-- form-group -->
								
								
								<div class="form-group">
									<div class="col-sm-6">	
										<label class="col-sm-3 control-label">Zip</label>
										<div class="col-sm-6">
											: <?php echo $r->s_zip; ?> 
										</div>
									</div>
									<div class="col-sm-6">	
										<div class="form-group">
											<label class="col-sm-4 control-label">Upload Resume</label>
											<div class="col-sm-6">
												: <a href="<?php print base_url().'../staff_upload_data/staff_resume/'.$r->staff_resume; ?>" target="_blank">
												  <?php echo $r->staff_resume; ?></a>
											</div>
										</div><!-- form-group -->
									</div>
								</div><!-- form-group -->
								
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>