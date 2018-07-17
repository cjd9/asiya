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

						<div class="row">
							<div class="col-md-12">
								<form id="appointment_booking_form" action="<?php echo $saveaction; ?>" method="post">

								<div class="panel panel-default">
									<div class="panel-heading">
								<a href="<?php echo base_url().'p_appointment_schedule'; ?>" type="button" class="btn btn-default btn-sm">
								          <span class="glyphicon glyphicon-arrow-left"></span> Back
								        </a>	
										<h3 class="panel-title text-center"><i class="glyphicon glyphicon-pencil"></i> <b>Take New Appointment </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">

											<div class="form-group">
												<label class="col-md-3 control-label"> Patient Name<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<input type="text" name="p_fname" id="p_fname" data-placeholder="Enter First Name" class="form-control validate[required]">
												</div>
												<div class="col-sm-3">
													<input type="text" name="p_lname" id="p_lname" data-placeholder="Enter Last Name" class="form-control validate[required]">
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-3 control-label"> Contact No.<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<input type="text" name="p_contact_no" id="p_contact_no" data-placeholder="Enter Contact No." class="form-control validate[required]">
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-sm-3 control-label">Gender<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<select id="p_gender" name="p_gender" data-placeholder="Choose One" class="select2-container width100p">
														<option value=""></option>
														<option value="Male">Male</option>
														<option value="Female">Female</option>
													</select>
													<span id="" class="" style="color:#FF0000"></span>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-3 control-label"> What is the Patient's Problem?<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="text" name="problem" id="problem" data-placeholder="Enter Problem" class="form-control validate[required]">
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-3 control-label">When do you want the Appointemnt?<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="glyphicon glyphicon-calendar"></i>
														</span>
														<input type="text" class="form-control validate[required] datepicker" name="appointment_date" placeholder="dd-mm-yyyy" id="appointment_date">
													</div>
												</div>
											</div>

											<div class="form-group">
												<label class="col-md-3 control-label">Shift <span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<select id="shift" name="shift" data-placeholder="Choose Shift " class="select2-container width100p">
															<option value=""></option>
															<option value="M">Morning</option>
															<option value="E">Evening</option>
														</select>
														<span id="" class="" style="color:#FF0000"></span>
													</div>
												</div>

												<!-- <label class="col-md-1 control-label">Time<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<!--<select id="appointment_time" name="appointment_time" data-placeholder="Choose Shift " class="select2-container width100p">

														</select>
														<span id="" class="" style="color:#FF0000"></span>

														<input type="text" class="form-control validate[required]" name="appointment_time" placeholder="Enter Time" id="appointment_time">

													</div>
												</div> -->

                        <div class="form-group">

        										<label class="col-md-2 control-label">Apointment Time<span class="asterisk">*</span></label>
        										<div class="col-sm-3">
        											<select id="appointment_time"  name="appointment_time" data-placeholder="Choose Time" class="select2-container width100p">


        											</select>
        											<span id="msg1" class="" style="color:#FF0000"></span>
        										</div>

        								</div><!-- form-group -->
											</div>

										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>p_appointment_schedule" class="btn btn-dark">Cancel</a>
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



         $("body").on('change', '#shift', function () {
					 $("#appointment_time").html('');
           $.ajax({
           	        url: "/p_appointment_schedule/getTimeSlot",
           	        data:
           	        {
           	        	shift:$(this).val()
           	        },
           	        dataType: "html",
           	        type: "post",
           	        success: function(data)
           	        {
											$("#appointment_time").html(data);
           	        }
           	    })

         }


            );
			// function to get time slot -
			/*$('#shift, #p_gender').on('change', function()
			{
				var gender = $("#p_gender").val();
				var work_shift = $("#shift").val();

				if(gender == '' || work_shift == '')
				{
					//alert("Please Select Patient Gender First.");
					return false;
				}

				//alert(gender)
				//alert(work_shift);

				// get all time slots for selected gender and shift -
				$.ajax({
						url: "<?php print base_url(); ?>p_appointment_schedule/get_time_slot",
						type: "post",
						async:false,
						cache:false,
						dataType:'json',
						data:{ gender:gender, work_shift:work_shift },
						success: function (res)
						{
							//alert(res.length);

							$("#appointment_time").html('');

							if(res)
							{
								var option = '';

								option += '<option value="">Choose One</option>';

								for(var i = 0; i < res.length; i++)
								{
									option += '<option value="'+ res[i].pk +'">'+ res[i].time_slot +'</option>';
								}

								$("#appointment_time").append(option);
								$("#appointment_time").select2();
							}
						}
				});

			});*/

			// validate drop down when form submits -
			$("#appointment_booking_form").submit( function() {

				var gender = $('#p_gender');

				gender.next("span").text('');

				if(gender.val() == '' || gender.val() == null)
				{
					gender.next("span").text('This field is required');
					return false;
				}

				var work_shift = $('#shift');

				work_shift.next("span").text('');

				if(work_shift.val() == '' || work_shift.val() == null)
				{
					work_shift.next("span").text('This field is required');
					return false;
				}

				/*var appointment_time = $('#appointment_time');

				appointment_time.next("span").text('');

				if(appointment_time.val() == '' || appointment_time.val() == null)
				{
					appointment_time.next("span").text('This field is required');
					return false;
				}*/

			});

		});
	</script>

    </body>
</html>
