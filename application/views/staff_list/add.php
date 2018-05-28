<?php  $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>

			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-pencil"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Staff Registration</a></li>

								</ul>
								<h4>Add Staff Registration</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<div class="row">
							<div class="col-md-12">
								<form id="add_staff_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">

								<div class="panel panel-default">
									<div class="panel-heading">
										
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Staff Registration</b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">

											<?php
												$sql = "SELECT staff_id FROM staff_details WHERE user_type = 'S' ORDER BY staff_id DESC LIMIT 1";

												$rs = $this->db->query($sql);

												if($rs->num_rows() > 0)
												{
													$x = $rs->row()->staff_id;

													$x = $this->mastermodel->get_auto_no($x);
												}
												else
												{
													$x = 'ACPS01';
												}
											?>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-md-3 control-label">Staff ID</label>
													<div class="col-sm-6">
														<input type="text" id="staff_id" name="staff_id" class="form-control validate[required]" value="<?php echo $x; ?>" readonly />
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Joining</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="date_of_joining" id="date_of_joining" placeholder="dd-mm-yyyy" value="<?php echo date('d-m-Y')?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<hr />

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Staff Name<span class="asterisk">*</span></label>
													<div class="col-sm-3">
														<input type="text" id="s_fname" name="s_fname" class="form-control validate[required],custom[onlyLetterSp]" placeholder="First Name"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="s_mname" name="s_mname" class="form-control" placeholder="Middle Name"/>
													</div>
													<div class="col-sm-3">
														<input type="text" id="s_lname" name="s_lname" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Last Name"/>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Birth<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="s_dob" placeholder="dd-mm-yyyy" id="s_dob">
														</div><!-- input-group --><span id="msg3" style="color:#FF0000"></span>
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Gender<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<select id="s_gender" name="s_gender" data-placeholder="Choose One" class="select2-container width100p">
															<option value=""></option>
															<option value="Male">Male</option>
															<option value="Female">Female</option>
														</select>
														<span id="msg1" class="" style="color:#FF0000"></span>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Religion<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<select id="s_religion_id" name="s_religion_id" data-placeholder="Choose Religion " class="select2-container width100p">
															<option value=""></option>
															<?php
																foreach ($rsreligion->result() as $r)
																{
																	echo "<option value='".$r->pk."'>".$r->religion."</option>";
																}
															?>
														</select>
														<span id="msg2" class="" style="color:#FF0000"></span>
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label"> Work Shift <span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<select id="s_work_shift" name="s_work_shift" data-placeholder="Choose One" class="select2-container width100p">
															<!--<option value=""></option>-->
															<option value="M">Morning</option>
															<option value="E">Evening</option>
														</select>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label"> Upload Photo <span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<input type="file" id="staff_photo" name="staff_photo" class="form-control" />
													</div>
												</div>
											</div><!-- form-group -->


											<h4>Contact Details</h4><hr />

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Email<span class="asterisk">*</span></label>
													<div class="col-sm-9">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input type="email" id="s_email_id" name="s_email_id" class="form-control" placeholder="Type Email ID"/>
														</div><!-- input-group -->
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Contact No.<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
															<input type="text" id="s_contact_no" name="s_contact_no" class="form-control" placeholder="Type Mobile No." maxlength = "10"/>
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<h4>Address Details</h4><hr />

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Address<span class="asterisk">*</span></label>
													<div class="col-sm-9">
														<textarea rows="2" name="s_address" id="s_address" class="form-control validate[required]"></textarea>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">City<span class="asterisk">*</span></label>
														<div class="col-sm-6">
															<input type="text" id="s_city" name="s_city" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Type City"/>
														</div>
													</div><!-- form-group -->
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">State<span class="asterisk">*</span></label>
														<div class="col-sm-6">
															<input type="text" id="s_state" name="s_state" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Type State"/>
														</div>
													</div><!-- form-group -->
												</div>
											</div><!-- form-group -->


											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Zip<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<input type="text" id="s_zip" name="s_zip" class="form-control" placeholder="Zip Code" maxlength="7"/>
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Upload Resume<span class="asterisk">*</span></label
														><div class="col-sm-6">
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
											<a href="<?php print base_url(); ?>staff_list" class="btn btn-dark">Cancel</a>
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
			$("#add_staff_form").validationEngine({promptPosition: "topRight: -100"});

			// select box validations -
			$('#add_staff_form').on('submit', function() {

				$('#msg1').text('');

				if($('#s_gender').val() == '' || $('#s_gender').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}

				$('#msg2').text('');

				if($('#s_religion_id').val() == '' || $('#s_religion_id').val() == null)
				{
					$('#msg2').text('This field is required');
					return false;
				}

			});

		});
	</script>

    </body>
</html>
