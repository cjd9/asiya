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
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Patient Details</b></h3>
						</div><!-- panel-heading -->

						<div class="panel-body">
							<div class="row">

							<?php
								$r = $rscontact_list->row();
							 ?>

							 <div class="row text-center padding-bottom-30">
								 <div class="profile-avatar-wrapper border-radius-50 pos-relative teel margin-bottom-10 display-inline-block">
												 <input type="hidden" name="image-x" required>
												 <input type="hidden" name="image-y" required>
												 <input type="hidden" name="image-x2" required>
												 <input type="hidden" name="image-y2" required>
												 <input type="hidden" name="crop-w" required>
												 <input type="hidden" name="crop-h" required>
												 <input type="hidden" name="image-w" required>
												 <input type="hidden" name="image-h" required>
												 <div class="overflow-hidden profile-pic-preview-wrapper border-radius-50 teel">
														 <img class="profile-pic" <?php echo $this->session->userdata('user_type') ? 'has-profile-pic' : '' ?> src="<?php echo $this->session->userdata('userid') ? base_url(PROFILE_PIC_UPLOAD_PATH . $r->patient_id . '.jpg') : base_url('public/images/avatar2.png') ?>" old-src="<?php echo $this->session->userdata('userid') ? base_url(PROFILE_PIC_UPLOAD_PATH . $this->session->userdata('userid') . '.jpg') : base_url('public/images/avatar2.png') ?>"/>
												 </div>
												
								 </div>
						 </div>
								<div class="form-group">
								  <div class="col-sm-6">
										<label class="col-md-4 control-label"><b>Patient ID</b></label>
										<b>:</b> <?php echo $r->patient_id; ?>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-6 control-label"><b>Date Of Registration</b></label>
										<b>:</b ><?php echo date("d-m-Y",strtotime($r->date_of_registration)); ?>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Patient Name</b></label>
											<b>:</b> <?php echo ucwords($r->p_fname.' '.$r->p_mname.' '.$r->p_lname); ?>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Date Of Birth</b></label>
											<b>: </b><?php echo date("d-m-Y",strtotime($r->p_dob)); ?>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Gender</b></label>
											<b>:</b> <?php if ($r->p_gender=="Male") { echo 'Male'; } ?>
													 <?php if ($r->p_gender=="Female") { echo 'Female'; } ?>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Religion</b></label>
											<b>:</b> <?php print $this->db->get_where('religion', array('pk' => $r->p_religion_id))->row()->religion; ?>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Occupation</b></label>
											<b>:</b> <?php echo $r->p_occupation; ?>
									</div>

									
								</div><!-- form-group -->

								<hr />

								<h5><u><b>Contact Details</b></u></h5>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Email</b></label>
											<b>:</b> <?php echo $r->p_email_id; ?>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Phone No.</b></label>
											<b>:</b> <?php echo $r->p_phone_no; ?>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">

									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Contact No.</b></label>
											<b>:</b> <?php echo $r->p_contact_no; ?>
									</div>
								</div><!-- form-group -->

								<hr />

								<h5><u><b>Address Details</b></u></h5>

								<div class="form-group">
									<div class="col-sm-12">
										<label class="col-sm-2 control-label"><b>Address</b></label>
											<b>:</b> <?php echo $r->p_address; ?>
									</div>
								</div>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>City</b></label>
										<b>:</b> <?php echo $r->p_city; ?>
									</div>
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>State</b></label>
										<b>:</b> <?php echo $r->p_state; ?>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-4 control-label"><b>Zip</b></label>
												<b>:</b> <?php echo $r->p_zip; ?>
										</div><!-- form-group -->
									</div>
								</div><!-- form-group -->

								<hr />

								<h5><u><b>Emergency Contact Details</b></u></h5>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label"><b>Name</b></label>
											<b>: </b><?php echo $r->p_emergency_name; ?>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											<label class="col-sm-4 control-label"><b>Contact No.</b></label>
												<b>:</b> <?php echo $r->p_emergency_contact; ?>
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
