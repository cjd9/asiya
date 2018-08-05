<?php $this->load->view('include/header'); ?>

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
									<li><a href="#">Patient Registration</a></li>

								</ul>
								<h4>Add Patient </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>



						<div class="row">
							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">

										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Patient </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
												<div class="text-center padding-top-30 padding-bottom-30">
												                      <div class="profile-avatar-wrapper border-radius-50 pos-relative teel margin-bottom-10 display-inline-block">
												                            <form id="add_patient_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" save-instantly>
												                              <input type="hidden" name="image-x">
												                              <input type="hidden" name="image-y">
												                              <input type="hidden" name="image-x2">
												                              <input type="hidden" name="image-y2">
												                              <input type="hidden" name="crop-w">
												                              <input type="hidden" name="crop-h">
												                              <input type="hidden" name="image-w">
												                              <input type="hidden" name="image-h">
												                              <div class="overflow-hidden profile-pic-preview-wrapper border-radius-50 teel">
												                                  <img class="profile-pic"  id="profilepicview" />
												                   <img class="profile-pic" src="<?php echo base_url('images/default_man_photo.jpg') ?>"/>

												                              </div>

												                              <a class="edit-icon v-align-contents no-form teel pos-absolute">
												                              	<i class="glyphicon glyphicon-pencil"></i>
												                                  <span></span>
												                                  <input type="file" accept=".jpg,.jpeg,.png" name="profile_pic" id="profile_pic" class="pos-absolute width-100 height-100 top-0"/>
												                              </a>
												                      </div>
												              </div>
											<?php
												$sql = "SELECT patient_id FROM contact_list ORDER BY patient_id DESC LIMIT 1";

												$rs = $this->db->query($sql);

												if($rs->num_rows() > 0)
												{
													$x = $rs->row()->patient_id;

													$x = $this->mastermodel->get_auto_no($x);
												}
												else
												{
													$x = 'ACP0001';
												}
											?>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-md-3 control-label">Patient  ID</label>
													<div class="col-sm-6">
														<input type="text" id="patient_id" name="patient_id" class="form-control validate[required]" value="<?php echo $x; ?>" readonly />
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Registration</label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control" name="date_of_registration" id="date_of_registration" value="<?php echo date('d-m-Y')?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Patient Name<span class="asterisk">*</span></label>
													<div class="col-sm-3">
														<input type="text" pattern="[A-Za-z]+" oninvalid="setCustomValidity('Invalid characters in this field, Enter only alphabets')" oninput="setCustomValidity('')" id="p_fname" name="p_fname" class="form-control validate[required],custom[onlyLetterSp]" placeholder="First Name"/>
                            <span id="p_fname_err" class="err" style="color:#FF0000"></span>

													</div>
													<div class="col-sm-3">
														<input type="text" id="p_mname" name="p_mname" class="form-control" placeholder="Middle Name"/>
													</div>
													<div class="col-sm-3">
														<input type="text" pattern="[A-Za-z]+" oninvalid="setCustomValidity('Invalid characters in this field, Enter only alphabets')" oninput="setCustomValidity('')" id="p_lname" name="p_lname" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Last Name"/>
                            <span id="p_lname_err" class="err" style="color:#FF0000"></span>

                        	</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Date Of Birth<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control" name="p_dob" placeholder="dd-mm-yyyy" id="p_dob">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Gender<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														  <select id="p_gender" name="p_gender" data-placeholder="Choose One" class="select2-container width100p">
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
														<select id="p_religion_id" name="p_religion_id" data-placeholder="Choose Religion " class="select2-container width100p">
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
													<label class="col-md-3 control-label">Occupation</label>
													<div class="col-sm-6">
														<input type="text" id="p_occupation" name="p_occupation" class="form-control validate[required]" placeholder="Ex.-Farmer,Dr,Police"/>
													</div>
												</div>
												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Age</label>
													<div class="col-sm-6">
														<input type="text" id="p_age" class="form-control validate[required]" readonly/>
													</div>
												</div>


											</div><!-- form-group -->

											<hr />

											<h5><u><b>Contact Details</b></u></h5>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Email<span class="asterisk"></span></label>
													<div class="col-sm-9">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
															<input type="text"     id="p_email_id" name="p_email_id" class="form-control" placeholder="Type Email ID"/>
															 <span id="p_email_err" class="err" style="color:#FF0000"></span>

														</div><!-- input-group -->
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Landline No.<span class="asterisk"></span></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
															<input type="numbertext" id="p_phone_no" name="p_phone_no" class="form-control" placeholder="Landline No." maxlength = "12"/>

														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Referred By</label>
													<div class="col-sm-9">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
															<input type="text"  id="referred_by" name="referred_by" class="form-control" placeholder="Referred By"/>

														</div><!-- input-group -->
						        	                      <span id="referred_by" class="err" style="color:#FF0000"></span>

													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4 control-label">Mobile No.<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
															<input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" id="p_contact_no" name="p_contact_no" class="form-control" placeholder="Type Mobile No." maxlength = "10"/>

														</div><!-- input-group -->
						        	                      <span id="p_contact_no_err" class="err" style="color:#FF0000"></span>

													</div>
												</div>
											</div><!-- form-group -->

											<hr />

											<h5><u><b>Address Details</b></u></h5>

											<div class="form-group">
												<div class="col-md-6">
													<label class="col-sm-3 control-label">Address<span class="asterisk">*</span></label>
													<div class="col-sm-9">
														<textarea rows="2" name="p_address" id="p_address" class="form-control validate[required]"></textarea>
						                            <span id="p_address_err" class="err" style="color:#FF0000"></span>

						                          </div>
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">City<span class="asterisk">*</span></label>
														<div class="col-sm-6">
															<input type="text" pattern="[A-Za-z]+" oninvalid="setCustomValidity('Invalid characters in this field, Enter only alphabets')" oninput="setCustomValidity('')" id="p_city" name="p_city" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Type City"/>
                              									<span id="p_city_err" class="err" style="color:#FF0000"></span>

														</div>
													</div><!-- form-group -->
												</div>

												<div class="col-md-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">State<span class="asterisk">*</span></label>
														<div class="col-sm-6">
															<input type="text" pattern="[A-Za-z]+" oninvalid="setCustomValidity('Invalid characters in this field, Enter only alphabets')" oninput="setCustomValidity('')" id="p_state" name="p_state" class="form-control validate[required],custom[onlyLetterSp]" placeholder="Type State"/>
                             								 <span id="p_state_err" class="err" style="color:#FF0000"></span>

														</div>
													</div><!-- form-group -->
												</div>

											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-md-6">
													<div class="form-group">
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Zip<span class="asterisk"></span></label>
														<div class="col-sm-6">
															<input type="text" id="p_zip" oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');"  name="p_zip" class="form-control" placeholder="Type Zip Code" maxlength="6"/>
														</div>
													</div><!-- form-group -->
												</div>
											</div><!-- form-group -->

											<hr />

											<h5><u><b>Emergency Contact Details</b></u></h5>

											<div class="form-group">
												<div class="col-sm-6">
													<label class="col-sm-3 control-label">Name<span class="asterisk"></span></label>
													<div class="col-sm-9">
														<input type="text" id="p_emergency_name" name="p_emergency_name" class="form-control" placeholder="Type Emergency Contact Person Name"/>
													</div>
												</div>

												<div class="col-sm-6">
													<div class="form-group">
														<label class="col-sm-4 control-label">Contact No.<span class="asterisk"></span></label>
														<div class="col-sm-6">
															<div class="input-group">
																<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
																<input type="number" id="p_emergency_contact" name="p_emergency_contact" class="form-control" placeholder="Type Contact No." maxlength = "10"/>
															</div><!-- input-group -->
														</div>
													</div><!-- form-group -->
												</div>

											</div><!-- form-group -->


										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button id="csubmit" class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>contact_list" class="btn btn-dark">Cancel</a>
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
		//$.noConflict();
		function validateEmail(inputtxt) {
		    var emailid = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		    if(inputtxt.match(emailid))
		    {
		        return true;
		    }
		    else
		    {
		        return false;
   			 }
   		}

		$(document).ready(function()
		{
			//$("#add_patient_form").validationEngine({promptPosition: "topRight: -100"});

			$("#p_dob").datepicker({ dateFormat: 'dd-mm-yy',maxDate:0 ,changeMonth: true,
				changeYear: true,yearRange: "-100:+0"});
			$("#date_of_registration").datepicker({dateFormat:'dd-mm-yy',maxDate:0,changeMonth: true,
				changeYear: true});

			$('#p_dob').on('change', function() {
			   dob = new Date($(this).val());
				 
				  $.ajax({
                            url: "/contact_list/getAge",
                            type: "post",
                           
                            dataType:'json',
                            data:{ date:$(this).val() },
                            success: function (res)
                            {
                              	$('#p_age').val(res.date);

                            }
                      });
				
			})
						// select box validations -
			$('#add_patient_form').on('submit', function()

			{
				$('#csubmit').prop('disabled',true);

				$valid = true;
				$('.err').text('');
				$('#msg1').text('');

				if($('#p_gender').val() == '' || $('#p_gender').val() == null)
				{
					$('#msg1').text('This field is required');
					$valid = false;
				}

				$('#msg2').text('');

				if($('#p_religion_id').val() == '' || $('#p_religion_id').val() == null)
				{
					$('#msg2').text('This field is required');
					$valid = false;
				}
        $('#p_fname_err').text('');

        if($('#p_fname').val() == '' || $('#p_fname').val() == null)
				{
					$('#p_fname_err').text('This field is required');
					$valid = false;
				}
        $('#p_lname_err').text('');

        if($('#p_lname').val() == '' || $('#p_lname').val() == null)
				{
					$('#p_lname_err').text('This field is required');
					$valid = false;
				}
        $('#p_address_err').text('');

        if($('#p_address').val() == '' || $('#p_address').val() == null)
        {
          $('#p_address_err').text('This field is required');
          $valid = false;
        }

        if ( validateEmail($('#p_email_id').val()) == false  && $('#p_email_id').val() != '' )
        {
            $valid = false;
          $('#p_email_err').text('Enter a valid email ID');
        }

        $('#p_contact_no').text('');

        if($('#p_contact_no').val() == '' || $('#p_contact_no').val() == null)
        {
          $('#p_contact_no_err').text('This field is required');
          $valid = false;
        }

        if($('#p_contact_no').val().length != 10 )
        {
          $('#p_contact_no_err').text('Mobile number should be of 10 digits only');
          $valid = false;
        }

        $('#p_city_err').text('');

        if($('#p_city').val() == '' || $('#p_city').val() == null)
        {
          $('#p_city_err').text('This field is required');
          $valid = false;
        }

        $('#p_state_err').text('');

        if($('#p_state').val() == '' || $('#p_state').val() == null)
        {
          $('#p_state_err').text('This field is required');
          $valid = false;
        }

        if(!$valid){
        	$('#csubmit').prop('disabled',false);

        	return false;
        }
        	

			});

			function calculate_age(birth_day,birth_month,birth_year)
				{
					today_date = new Date();
			    today_year = today_date.getFullYear();
			    today_month = today_date.getMonth();
			    today_day = today_date.getDate();
			    age = today_year - birth_year;

			    if ( today_month < (birth_month - 1))
			    {
			        age--;
			    }
			    if (((birth_month - 1) == today_month) && (today_day < birth_day))
			    {
			        age--;
			    }
			    return age
				}


		});
	</script>
  <?php
      $this->load->view('helpers/profile_pic_upload_modal.php');
  ?>

    </body>
</html>
