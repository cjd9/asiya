<?php $this->load->view('p_include/header'); ?>
 
<?php $this->load->view('p_include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-pencil"></i>
							</div>
							<div class="media-body">
								<!--<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Clinical Meetings</a></li>
								</ul>-->
								<h4>Appointment Schedule </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<?php $row = $rsappointment->row(); ?>
						
						<div class="row">
							<div class="col-md-12">
								<form id="appointment_booking_form" action="<?php echo $cancelaction; ?>" method="post">
								<input type="hidden" name="pk" id="pk" value="<?php echo $row->pk; ?>" />
								<div class="panel panel-default">
									<div class="panel-heading">
										
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Cancel Appointment </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Patient Name<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<?php echo $row->p_fname.' '.$row->p_lname; ?>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Contact No.<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<?php echo $row->p_contact_no; ?>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-sm-2 control-label">Gender<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<?php echo $row->p_gender; ?>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> What is the Patient's Problem?<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<?php echo $row->problem; ?>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label">When do you want the Appointemnt?<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<?php echo $row->appointment_date; ?>
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-2 control-label">Shift <span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<?php if($row->shift == 'M') { echo 'Morning'; } else { echo 'Evening'; } ?>
													</div>
												</div>
												
												<label class="col-md-1 control-label">Time<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<?php echo $this->db->get_where('time_slot_master', array('pk' => $row->appointment_time))->row()->time_slot; ?>
													</div>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Reason<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="text" name="reason_by_patient" id="reason_by_patient" class="form-control validate[required]">
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>index.php/p_appointment_schedule" class="btn btn-dark">Cancel</a>
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
						
		<?php $this->load->view('p_include/footer'); ?>
		
	<script>
		$(document).ready(function()
		{
			$("#appointment_booking_form").validationEngine({promptPosition: "topRight: -100"});
		}); 
	</script>
	
    </body>
</html>