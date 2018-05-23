<section>
	<div class="mainwrapper">
		<div class="leftpanel">
			<div class="media profile-left">
				<a class="pull-left profile-thumb" href="#">
					<?php if($this->session->userdata('user_photo')) { ?>
						<img class="img-circle" src="<?php print base_url(); ?>./staff_upload_data/staff_photo/<?php print $this->session->userdata('user_photo'); ?>" height="35" width="15"/>
					<?php } else { ?>
						<img class="img-circle" src="<?php print base_url(); ?>images/men.png"/>
					<?php } ?>
				</a>
				<div class="media-body">
					<h4 class="media-heading"><b><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></b></h4>
					<small class="text-muted"><b>Staff User</b></small>
				</div>
			</div><!-- media -->
	
	<h5 class="leftpanel-title">
		<b>
			<span style="color:#476A34">
				<span class="glyphicon glyphicon-calendar"></span>
			</span>
			<span class="style2" style="color:#683A5E">
			<?php
				print date('D, d-M-Y');
			?>
	    	</span>
		</b>
		<b>
			<span style="color:#476A34">
				<span class="fa fa-clock-o"></span>
			</span>
			<span class="style2" style="color:#683A5E">
			<?php
				print date('h:i A');
			?>
			</span> 
		</b>
	</h5>
	
	<ul class="nav nav-pills nav-stacked">
		<li <?php if(current_url() == base_url().'dashboard') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'dashboard'; ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'contact_list' || current_url() == base_url().'contact_list/add' || strpos(current_url(), base_url().'contact_list/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'contact_list'; ?>"><i class="fa fa-book"></i> <span>Patient List</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'evaluation' || current_url() == base_url().'evaluation/add' || strpos(current_url(), base_url().'evaluation/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'evaluation'; ?>"><i class="fa fa-database"></i> <span>Evaluation</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'treatment' || current_url() == base_url().'treatment/add' || strpos(current_url(), base_url().'treatment/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'treatment'; ?>"><i class="fa fa-file-text-o"></i> <span>Treatment</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'appointment_schedule' || current_url() == base_url().'appointment_schedule/add' || strpos(current_url(), base_url().'appointment_schedule/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'appointment_schedule'; ?>"><i class="fa fa-calendar"></i> <span>Appointment Schedule</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'exercise_program' || current_url() == base_url().'exercise_program/add' || strpos(current_url(), base_url().'exercise_program/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'exercise_program'; ?>"><i class="fa fa-child"></i> <span>Excercise Program</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'clinical_meetings' || current_url() == base_url().'clinical_meetings/add' || strpos(current_url(), base_url().'clinical_meetings/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'clinical_meetings'; ?>"><i class="fa fa-hospital-o"></i> <span>Clinical Meetings</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'contact_allocation' || current_url() == base_url().'contact_allocation/add' || strpos(current_url(), base_url().'contact_allocation/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'contact_allocation'; ?>"><i class="fa fa-list-alt"></i> <span>Contact Allocation</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'education_program' || current_url() == base_url().'education_program/add' || strpos(current_url(), base_url().'education_program/edit/') !== false || strpos(current_url(), base_url().'education_program/sms/') !== false || strpos(current_url(), base_url().'education_program/email/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'education_program'; ?>"><i class="fa fa-volume-up"></i> <span>SAMVAAD - <small>A Healthy Communication</small> </span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'activity_program' || current_url() == base_url().'activity_program/add' || strpos(current_url(), base_url().'activity_program/edit/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'activity_program'; ?>"><i class="fa fa-gears"></i> <span>Activity Program</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'email' || current_url() == base_url().'email/add' || strpos(current_url(), base_url().'email/edit/') !== false || strpos(current_url(), base_url().'email/view/') !== false || strpos(current_url(), base_url().'email/forward/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'email'; ?>"><i class="fa fa-envelope-o"></i> <span>Email</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'sms' || current_url() == base_url().'sms/add' || strpos(current_url(), base_url().'sms/edit/') !== false || strpos(current_url(), base_url().'sms/view/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'sms'; ?>"><i class="glyphicon glyphicon-phone"></i> <span>SMS</span></a>
		</li>
		
		<li>
			<a href=""><i class="glyphicon glyphicon-hand-up"></i> <span>Attendance</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'patient_enquiry' || current_url() == base_url().'patient_enquiry/add' || strpos(current_url(), base_url().'patient_enquiry/cancel/') !== false) {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'patient_enquiry'; ?>"><i class="fa fa-comments"></i> <span>Patient Enquiry</span></a>
		</li>
		
	</ul>
	
</div><!-- leftpanel -->
