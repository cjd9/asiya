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
									<li><a href="#">Patient Registration</a></li>

								</ul>
								<h4>View Patient </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<?php
							$r = $rscontact_list->row();
						 ?>

						<div class="row ">
							<div class="col-md-12">
								<form id="edit_patient_form"  method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" disabled name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<a href="<?php echo base_url().'contact_list'; ?>" type="button" class="btn btn-default btn-sm">
								          <span class="glyphicon glyphicon-arrow-left"></span> Back
								        </a>

										<h3 class="panel-title text-center"><i class="glyphicon glyphicon-edit"></i> <b>Edit Patient </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
                    <div class="row text-center padding-bottom-30"">
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
										<div class="row">

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-md-3 control-label">Patient  ID</label>
													<div class="col-sm-6">
														<input type="text" id="patient_id" name="patient_id" class="form-control validate[required]" value="<?php echo $r->patient_id; ?>" readonly />
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Registration</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" disabled name="date_of_registration" id="date_of_registration" value="<?php echo date("d-m-Y",strtotime($r->date_of_registration)); ?>" />
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Patient Name</label>
													<div class="col-sm-3">
														<input type="text" id="p_fname" disabled name="p_fname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->p_fname; ?>"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="p_mname" disabled name="p_mname" class="form-control" value="<?php echo $r->p_mname; ?>"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="p_lname" disabled name="p_lname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->p_lname; ?>"/>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Birth</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" disabled name="p_dob" id="p_dob" value="<?php echo date("d-m-Y",strtotime($r->p_dob)); ?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Gender</label>
													<div class="col-sm-6">
														  <select id="select-templating1" disabled name="p_gender" data-placeholder="Choose One" class="select2-container width100p">
															<option value=""></option>
															<option value="Male" <?php if($r->p_gender == "Male") { ?> selected="selected" <?php } ?>>Male</option>
															<option value="Female" <?php if($r->p_gender == "Female") { ?> selected="selected" <?php } ?>>Female</option>
														</select>
														<span id="msg2" class="" style="color:#FF0000"></span>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Religion</label>
													<div class="col-sm-6">
														<select id="p_religion_id" disabled name="p_religion_id" data-placeholder="Choose Religion " class="select2-container width100p">
															<option value=""></option>
															<?php
																foreach ($rsreligion->result() as $r1)
																{
															?>
															<option value="<?php echo $r1->pk; ?>" <?php if($r1->pk == $r->p_religion_id) { ?> selected="selected" <?php } ?>>
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
													<label class="col-md-3 control-label">Occupation</label>
													<div class="col-sm-6">
														<input type="text" id="" disabled name="p_occupation" class="form-control validate[required]" value="<?php echo $r->p_occupation; ?>"/>
													</div>
												</div>

												
											</div><!-- form-group -->

											<hr />

											<h5><u><b>Contact Details</b></u></h5>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Email</label>
													<div class="col-sm-9">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input type="email" id="p_email_id" disabled name="p_email_id" class="form-control" value="<?php echo $r->p_email_id; ?>"/>
														</div><!-- input-group -->
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Phone No.</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
															<input type="text" id="p_phone_no"disabled  name="p_phone_no" class="form-control" maxlength = "12" value="<?php echo $r->p_phone_no; ?>"/>
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">

												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Contact No.</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
															<input type="text" id="p_contact_no" disabled name="p_contact_no" class="form-control" maxlength = "10" value="<?php echo $r->p_contact_no; ?>"/>
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<hr />

											<h5><u><b>Address Details</b></u></h5>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Address</label>
													<div class="col-sm-9">
														<textarea rows="2" disabled name="p_address" id="p_address" class="form-control validate[required]"><?php echo $r->p_address; ?></textarea>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">City</label>
														<div class="col-sm-6">
															<input type="text" id="p_city" disabled name="p_city" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->p_city; ?>"/>
														</div>
													</div><!-- form-group -->
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">State</label>
														<div class="col-sm-6">
															<input type="text" id="p_state" disabled disabled name="p_state" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->p_state; ?>"/>
														</div>
													</div><!-- form-group -->
												</div>

											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<div class="form-group">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Zip</label>
														<div class="col-sm-6">
															<input type="text" id="p_zip" disabled name="p_zip" class="form-control" maxlength="7" value="<?php echo $r->p_zip; ?>"/>
														</div>
													</div><!-- form-group -->
												</div>
											</div><!-- form-group -->

											<hr />

											<h5><u><b>Emergency Contact Details</b></u></h5>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Name</label>
													<div class="col-sm-9">
														<input type="text" id="p_emergency_name" disabled name="p_emergency_name" class="form-control" value="<?php echo $r->p_emergency_name; ?>"/>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Contact No.</label>
														<div class="col-sm-6">
															<div class="input-group">
																<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
																<input type="text" id="p_emergency_contact" disabled name="p_emergency_contact" class="form-control" maxlength = "10" value="<?php echo $r->p_emergency_contact; ?>"/>
															</div><!-- input-group -->
														</div>
													</div><!-- form-group -->
												</div>

											</div><!-- form-group -->


										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
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
		//$.noConflict();
		$(document).ready(function()
		{
			$("#edit_patient_form").validationEngine({promptPosition: "topRight: -100"});

			/*$("#p_dob").datepicker({ dateFormat: 'dd-mm-yy' });
			$("#date_of_registration").datepicker({dateFormat:'dd-mm-yy'});*/

			// select box validations -
			$('#add_patient_form').on('submit', function() {

				$('#msg2').text('');

				if($('#select-templating1').val() == '' || $('#select-templating1').val() == null)
				{
					$('#msg2').text('This field is required');
					return false;
				}

			});

		});
	</script>
  <?php
      $this->load->view('helpers/profile_pic_upload_modal.php');
  ?>
    </body>
</html>
