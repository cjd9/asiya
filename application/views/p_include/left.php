<section>
	<div class="mainwrapper">
		<div class="leftpanel">
			<div class="media profile-left">
				<a class="pull-left profile-thumb" href="#">
                                           <div class="overflow-hidden profile-pic-preview-wrapper border-radius-50 teel">
     
                  <img class="profile-pic" <?php echo $this->session->userdata('user_type') ? 'has-profile-pic' : '' ?> src="<?php echo $this->session->userdata('userid') ? base_url(PROFILE_PIC_UPLOAD_PATH . $this->session->userdata('patient_id') . '.jpg') : base_url('public/images/avatar2.png') ?>" old-src="<?php echo $this->session->userdata('userid') ? base_url(PROFILE_PIC_UPLOAD_PATH . $this->session->userdata('userid') . '.jpg') : base_url('public/images/avatar2.png') ?>" onerror="this.src='/images/default_man_photo.jpg';"/>
              </div>
				</a>
				<div class="media-body">
					<h4 class="media-heading"><b><?php echo $this->session->userdata('first_name').' '.$this->session->userdata('last_name'); ?></b></h4>
					<small class="text-muted"><b>Patient Panel</b></small>
				</div>
			</div><!-- media -->
	
	<!--<h5 class="leftpanel-title">Navigation</h5>-->
	
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
		<li <?php if(current_url() == base_url().'p_dashboard') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_dashboard'; ?>"><i class="fa fa-home"></i> <span>Dashboard</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'p_history') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_history'; ?>"><i class="fa fa-history"></i> <span>History Details</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'p_appointment_schedule' || current_url() == base_url().'p_appointment_schedule/add' || strpos(current_url(), base_url().'p_appointment_schedule/cancel/') !== false || current_url() == base_url().'p_appointment_schedule/view_next_appt') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_appointment_schedule'; ?>"><i class="fa fa-calendar"></i> <span>Appointment</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'p_exercise_program') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_exercise_program'; ?>"><i class="fa fa-child"></i> <span>Excercise Program</span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'p_samvaad') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_samvaad'; ?>"><i class="fa fa-volume-up"></i> <span>SAMVAAD - <small>A Healthy Communication</small> </span></a>
		</li>
		
		<li <?php if(current_url() == base_url().'p_activity_program') {?> class="active" <?php } ?>>
			<a href="<?php echo base_url().'p_activity_program'; ?>"><i class="fa fa-gears"></i> <span>Activity Program</span></a>
		</li>
	</ul>
	
</div><!-- leftpanel -->
