<?php $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>

		<div class="mainpanel">
			<div class="pageheader">
				<div class="media">
					<div class="pageicon pull-left">
						<i class="fa fa-calendar"></i>
					</div>
					<div class="media-body">
						<ul class="breadcrumb">
							<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
							<li><a href="#">Home</a></li>

						</ul>
						<h4>Appointment Schedule</h4>
					</div>
				</div><!-- media -->
			</div><!-- pageheader -->

			<div class="contentpanel">

				<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

				<div class="row">
					<div class="col-md-12">

						<div class="panel panel-default">
								<div class="panel-heading">
									
									<h3 class="panel-title"><span class="glyphicon glyphicon-export"></span> <b>Export Appointment Schedule</b></h3>
								</div><!-- panel-heading -->

								<div class="panel-body">
									<div class="row">

									<form id="export_appointment_schedule_form" action="<?php echo base_url().'index.php/appointment_schedule/export_schedule'; ?>" method="post">

										<div class="form-group">
											<div class="col-sm-4">
												<label class="col-sm-5 control-label">Select Date<span class="asterisk">*</span> </label>
												<div class="col-sm-7">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input type="text" class="form-control validate[required]" name="schedule_date" id="datepicker" value="">
													</div><!-- input-group -->
												</div>
											</div>

											<div class="col-sm-4">
												<label class="col-sm-4 control-label">Work Shift<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<select id="schedule_work_shift" name="schedule_work_shift" data-placeholder="Choose Shift " class="select2-container width100p">
														<option value=""></option>
														<option value="M">Morning</option>
														<option value="E">Evening</option>
													</select>
													<span id="msg3" style="color:#FF0000"></span>
												</div>

												<div class="col-sm-2">
													<button class="btn btn-success btn-bordered" name="export_schedule" id="export_schedule">
														<span class="glyphicon glyphicon-export"></span> Export Schedule
													</button>
												</div>

											</div>
										</div><!-- form-group -->

									</form>
							</div><!-- panel -->

						</div><!-- row -->
					</div><!-- panel-body -->

					<div class="row">
					<div class="col-md-12">

							<div class="panel panel-default">
								<div class="panel-heading">
									<div class="panel-btns">
										<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
										<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
									</div><!-- panel-btns -->
									<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Appointment Schedule</b></h3>
								</div><!-- panel-heading -->

								<div class="panel-body">
									<div class="row">

									<form id="add_appointment_schedule_form" action="<?php echo $saveaction; ?>" method="post">

										<div class="form-group">
											<div class="col-sm-4">
												<label class="col-sm-5 control-label">Appointment Date<span class="asterisk">*</span> </label>
												<div class="col-sm-7">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input type="text" class="form-control validate[required]" name="date_of_appointment" id="date_of_appointment" value="<?php if(isset($date_of_appointment)) { echo $date_of_appointment; } ?>">
													</div><!-- input-group -->
												</div>
											</div>

											<div class="col-sm-4">
												<label class="col-sm-3 control-label">Staff Name<span class="asterisk">*</span></label>
												<div class="col-sm-8">
													<select id="staff_id" name="staff_id" data-placeholder="Choose Staff" class="select2-container width100p">
														<option value=""> </option>
														<?php foreach ($rsstaff_list->result() as $r) { ?>
															<option value="<?php echo $r->pk; ?>" <?php if(isset($staff_id) && $staff_id == $r->pk) { ?> selected="selected"<?php } ?>><?php echo $r->s_fname.' '.$r->s_mname.' '.$r->s_lname; ?></option>
														<?php } ?>
													</select>
													<span id="msg1" style="color:#FF0000"></span>
												</div>
											</div>

											<div class="col-sm-4">
												<label class="col-sm-3 control-label">Work Shift<span class="asterisk">*</span></label>
												<div class="col-sm-5">
													<select id="work_shift" name="work_shift" data-placeholder="Choose Shift " class="select2-container width100p">
														<option value=""></option>
														<option value="M" <?php if(isset($work_shift) && $work_shift == "M") { ?> selected="selected"<?php } ?>>Morning</option>
														<option value="E" <?php if(isset($work_shift) && $work_shift == "E") { ?> selected="selected"<?php } ?>>Evening</option>
													</select>
													<span id="msg2" style="color:#FF0000"></span>
												</div>

												<div class="col-sm-2">
													<button class="btn btn-primary" name="get_schedule" id="get_schedule">Get Schedule</button>
												</div>

											</div>
										</div><!-- form-group -->

									</form>

										<br />

										<?php if(isset($staff_id) && isset($work_shift) && isset($user_gender)) { ?>

										<div class="form-group responsive">
											<div class="col-sm-12 table-responsive" align="center">
												<table class="table table-bordered table-striped mb30 responsive" id="">
													<thead>
														<tr>
															<?php
																if($work_shift == 'M')
																{
																	$work_shift = 'Morning';
																}
																else
																{
																	$work_shift = 'Evening';
																}
															?>
															<th colspan="5"><div align="center">Appointment Schedule (<?php echo $user_gender; ?>) - <?php echo $work_shift; ?></div></th>
														</tr>
														<tr>
															<th><div align="center">Time Slots</div></th>
															<th><div align="center">Patient Name</div></th>
															<th><div align="center">Patient Contact No.</div></th>
															<th><div align="center">Action</div></th>
														</tr>
													</thead>

													<tbody>
														<?php foreach($rstime_slots->result() as $row) { ?>

														<?php
															if($rsappointment_schedule->num_rows() > 0)	// if minimum 1 appointment is booked -
															{
																foreach($rsappointment_schedule->result() as $r)
																{
																	// check if appointment booking is already exists -
																	if($row->pk == $r->time_slot_id)
																	{
																		$appointment_id = $r->pk;

																		$p_fname = $r->p_fname;
																		$p_lname = $r->p_lname;
																		$p_contact_no = $r->p_contact_no;

																		break; // will leave the foreach loop and also "break" the if statement
																	}
																	else
																	{
																		$appointment_id = '';

																		$p_fname = '';
																		$p_lname = '';
																		$p_contact_no = '';
																	}
																}
														?>

														<tr>
															<td align="center"><?php echo $row->time_slot; ?>
																<input type="hidden" name="time_slot_id" class="time_slot_id" value="<?php echo $row->pk; ?>" />
															</td>

															<td>
																<input type="hidden" name="appointment_id" class="appointment_id" value="<?php echo $appointment_id; ?>" />

																<div class="col-sm-6">
																	<input type="text" class="form-control validate[required] p_fname" name="p_fname" value="<?php echo $p_fname; ?>" placeholder="Full Name" <?php if($appointment_id != '') { ?>disabled<?php } ?> />
																</div>
																<div class="col-sm-6">
																	<input type="text" class="form-control validate[required] p_lname" name="p_lname" value="<?php echo $p_lname; ?>" placeholder="Patient ID" <?php if($appointment_id != '') { ?>disabled<?php } ?> />
																</div>
															</td>
															<td>
																<div class="col-sm-12">
																	<input type="text" class="form-control validate[required] p_contact_no" name="p_contact_no" value="<?php echo $p_contact_no; ?>" placeholder="Contact No." <?php if($appointment_id != '') { ?>disabled<?php } ?> />
																</div>
															</td>
															<td>
																<div align="center">
																	<button class="btn btn-primary btn-xs btn-confirm <?php if($appointment_id != '') { ?>disabled<?php } ?>">Confirm</button>
																	<button class="btn btn-success btn-xs btn-edit <?php if($appointment_id == '') { ?>disabled<?php } ?>">Edit</button>
																	<button class="btn btn-warning btn-xs btn-cancel <?php if($appointment_id == '') { ?>disabled<?php } ?>">Cancel</button>
																	<button class="btn btn-danger btn-xs btn-sms-email <?php if($appointment_id == '') { ?>disabled<?php } ?>">SMS/EMail</button>
																</div>
															</td>
														</tr>

														<?php
															}
															else	// if minimum 1 appointment is not booked -
															{
														?>

														<tr>
															<input type="hidden" name="appointment_id" class="appointment_id" value="" />

															<td align="center"><?php echo $row->time_slot; ?> <input type="hidden" name="time_slot_id" class="time_slot_id" value="<?php echo $row->pk; ?>" /> </td>
															<td>
																<div class="col-sm-6">
																	<input type="text" class="form-control validate[required] p_fname" name="p_fname" value="" placeholder="Full Name" />
																</div>
																<div class="col-sm-6">
																	<input type="text" class="form-control validate[required] p_lname" name="p_lname" value="" placeholder="Patient ID" />
																</div>
															</td>
															<td><input type="text" class="form-control validate[required] p_contact_no" name="p_contact_no" value="" placeholder="Contact No." /></td>
															<td>
																<div align="center">
																	<button class="btn btn-primary btn-xs btn-confirm">Confirm</button>
																	<button class="btn btn-success btn-xs btn-edit disabled">Edit</button>
																	<button class="btn btn-warning btn-xs btn-cancel disabled">Cancel</button>
																	<button class="btn btn-danger btn-xs btn-sms-email disabled">SMS/EMail</button>
																</div>
															</td>
														</tr>

														<?php
															}
														}
														?>

													</tbody>
												</table>
											</div>
										</div>

										<?php } ?>

									</div><!-- row -->
								</div><!-- panel-body -->

					</div><!-- col-md-12 -->
				</div><!--row -->
			</div><!-- contentpanel -->

		</div><!-- mainpanel -->
	</div><!-- mainwrapper -->
</section>

	<?php $this->load->view('include/footer'); ?>

	<script>

		$(document).ready(function()
		{
			// form Validation
			$("#add_appointment_schedule_form").validationEngine({promptPosition: "topRight: -100"});

			$("#export_appointment_schedule_form").validationEngine({promptPosition: "topRight: -100"});

			// Show datepicker with previous dates hidden -
			$('#datepicker,#date_of_appointment').datepicker(
			{
				changeMonth: true,
				changeYear: true,
				yearRange: '1945:2050',
				dateFormat: 'dd-mm-yy',
				minDate: 0
				//minDate: 0	// disable all previous dates
			});

			// select box validations -
			$('#add_appointment_schedule_form').on('submit', function()
			{
				$('#msg1').text('');

				if($('#staff_id').val() == '' || $('#staff_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}

				$('#msg2').text('');

				if($('#work_shift').val() == '' || $('#work_shift').val() == null)
				{
					$('#msg2').text('This field is required');
					return false;
				}
			});

			// select box validations -
			$('#export_appointment_schedule_form').on('submit', function()
			{
				$('#msg3').text('');

				if($('#schedule_work_shift').val() == '' || $('#schedule_work_shift').val() == null)
				{
					$('#msg3').text('This field is required');
					return false;
				}
			});

			// function to confirm appointment -
			$('.btn-confirm').live('click', function()
			{
				var confirm_btn = $(this);

				// get booking details -
				var date_of_appointment = $("#date_of_appointment").val();
				var staff_id = $("#staff_id").val();
				var work_shift = $("#work_shift").val();

				//var appointment_id = $(this).closest('tr').find('.appointment_id').val();

				var time_slot_id = confirm_btn.closest('tr').find('.time_slot_id').val();

				var p_fname = confirm_btn.closest('tr').find('.p_fname').val();
				var p_lname = confirm_btn.closest('tr').find('.p_lname').val();
				var p_contact_no = confirm_btn.closest('tr').find('.p_contact_no').val();

				// remove error validate from field if its not empty -
				confirm_btn.closest('tr').find('div').removeClass('has-error');

				// validate fields -
				if(date_of_appointment == '' || staff_id == '' || work_shift == '')
				{
					return false;
				}

				if(p_fname == '')
				{
					confirm_btn.closest('tr').find('.p_fname').parent('div').addClass('has-error');

					return false;
				}



				/*if(p_contact_no == '')
				{
					confirm_btn.closest('tr').find('.p_contact_no').parent('div').addClass('has-error');

					return false;
				}*/

				bootbox.confirm({
                title: "Update Patient?",
                message: "'You Want To Confirm Appointment?'?.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
				if(result)
				{
					//alert('Confirm Appointment...');

					// save appointment details using ajax -
					$.ajax({
							url: "<?php print base_url(); ?>index.php/appointment_schedule/confirm_appointment",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ date_of_appointment:date_of_appointment, staff_id:staff_id, work_shift:work_shift, time_slot_id:time_slot_id, p_fname:p_fname, p_lname:p_lname, p_contact_no:p_contact_no },
							success: function (res)
							{
								//alert(res);

								// check if appointment is successfully save -
								if(res != 0)
								{
									bootbox.alert("Appointment Saved Successfully!");

									// disable confirm button -
									confirm_btn.addClass('disabled');

									// enable edit button -
									confirm_btn.closest('tr').find('.btn-edit').removeClass('disabled');

									// enable cancel button -
									confirm_btn.closest('tr').find('.btn-cancel').removeClass('disabled');

									// enable sms/email button -
									confirm_btn.closest('tr').find('.btn-sms-email').removeClass('disabled');

									// disable input fields after successful save -
									confirm_btn.closest('tr').find('.p_fname').attr('disabled', 'disabled');
									confirm_btn.closest('tr').find('.p_lname').attr('disabled', 'disabled');
									confirm_btn.closest('tr').find('.p_contact_no').attr('disabled', 'disabled');

									// append new current record insert id to hidden field appointment_id -
									confirm_btn.closest('tr').find('.appointment_id').val(res);
								}
							}
					});

				}
				else
				{
					return false;
				}
                }
            });




			});

			// function to show record editable -
			$('.btn-edit').live('click', function()
			{
				//alert('Edit Appointment Booking...');

				var edit_btn = $(this);

				// change Edit button label to Update -
				edit_btn.text('Update');

				// enable input fields for update -
				edit_btn.closest('tr').find('.p_fname').removeAttr('disabled');
				edit_btn.closest('tr').find('.p_lname').removeAttr('disabled');
				edit_btn.closest('tr').find('.p_contact_no').removeAttr('disabled');

				// change the class of Edit button -
				edit_btn.removeClass('btn-edit');
				edit_btn.addClass('btn-update');
			});

			// function to update appointment -
			$('.btn-update').live('click', function()
			{
				var update_btn = $(this);

				// get booking details -
				var date_of_appointment = $("#date_of_appointment").val();
				var staff_id = $("#staff_id").val();
				var work_shift = $("#work_shift").val();

				var appointment_id = update_btn.closest('tr').find('.appointment_id').val();

				var time_slot_id = update_btn.closest('tr').find('.time_slot_id').val();

				var p_fname = update_btn.closest('tr').find('.p_fname').val();
				var p_lname = update_btn.closest('tr').find('.p_lname').val();
				var p_contact_no = update_btn.closest('tr').find('.p_contact_no').val();

				// remove error validate from filed if its not empty -
				update_btn.closest('tr').find('div').removeClass('has-error');

				// validate fields -
				if(date_of_appointment == '' || staff_id == '' || work_shift == '')
				{
					return false;
				}

				if(p_fname == '')
				{
					update_btn.closest('tr').find('.p_fname').parent('div').addClass('has-error');

					return false;
				}

				if(p_lname == '')
				{
					update_btn.closest('tr').find('.p_lname').parent('div').addClass('has-error');

					return false;
				}

				/*if(p_contact_no == '')
				{
					update_btn.closest('tr').find('.p_contact_no').parent('div').addClass('has-error');

					return false;
				}*/

				/*alert(date_of_appointment);
				alert(staff_id);
				alert(work_shift);

				alert(appointment_id);

				alert(time_slot_id);

				alert(p_fname);
				alert(p_lname);
				alert(p_contact_no);*/

				var res = confirm('You Want To Update Appointment?');

				if(res)
				{
					//alert('Update Appointment...');

					// update appointment details using ajax -
					$.ajax({
							url: "<?php print base_url(); ?>index.php/appointment_schedule/update_appointment",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ date_of_appointment:date_of_appointment, staff_id:staff_id, work_shift:work_shift, appointment_id:appointment_id, time_slot_id:time_slot_id, p_fname:p_fname, p_lname:p_lname, p_contact_no:p_contact_no },
							success: function (res)
							{
								//alert(res);

								// check if appointment is successfully update -
								if(res != 0)
								{
									alert('Appointment Updated Successfully.');

									// change update button label to Edit after successful update -
									update_btn.text('Edit');

									// change the class of edit button -
									update_btn.removeClass('btn-update');
									update_btn.addClass('btn-edit');

									// disable input fields after successful update -
									update_btn.closest('tr').find('.p_fname').attr('disabled', 'disabled');
									update_btn.closest('tr').find('.p_lname').attr('disabled', 'disabled');
									update_btn.closest('tr').find('.p_contact_no').attr('disabled', 'disabled');
								}
							}
					});

				}
				else
				{
					return false;
				}

			});

			// function to cancel appointment -
			$('.btn-cancel').on('click', function()
			{
				var res = confirm('You Want To Cancel Appointment?');

				if(res)
				{
					var cancel_btn = $(this);

					var appointment_id = cancel_btn.closest('tr').find('.appointment_id').val();

					//alert(appointment_id);

					//alert('Cancel Appointment...');

					// cancel appointment details using ajax -
					$.ajax({
							url: "<?php print base_url(); ?>index.php/appointment_schedule/cancel_appointment",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ appointment_id:appointment_id },
							success: function (res)
							{
								//alert(res);

								// check if appointment is successfully cancel -
								if(res != 0)
								{
									alert('Appointment Cancelled Successfully.');

									// enable Confirm button and disable Edit button -
									cancel_btn.closest('tr').find('.btn-confirm').removeClass('disabled');
									cancel_btn.closest('tr').find('.btn-edit').addClass('disabled');

									// disable Cancel button -
									cancel_btn.closest('tr').find('.btn-cancel').addClass('disabled');

									// disable sms/email button -
									cancel_btn.closest('tr').find('.btn-sms-email').addClass('disabled');

									// enable input fields and make empty -
									cancel_btn.closest('tr').find('.p_fname').removeAttr('disabled').val('');
									cancel_btn.closest('tr').find('.p_lname').removeAttr('disabled').val('');
									cancel_btn.closest('tr').find('.p_contact_no').removeAttr('disabled').val('');

									// remove appointment id from hidden field of cancel appointment -
									cancel_btn.closest('tr').find('.appointment_id').val('');
								}
							}
					});
				}
				else
				{
					return false;
				}

			});

			// function to send SMS/EMail to Patient -
			$('.btn-sms-email').on('click', function()
			{
				var res = confirm('You Want To Send SMS/Email?');

				if(res)
				{
					// show loader -
					//showProgress('SMS/Email Sending...');

					var sms_email_btn = $(this);

					var appointment_id = sms_email_btn.closest('tr').find('.appointment_id').val();

					//alert(appointment_id);

					//alert('SMS/Email Sending...');

					// send SMS/Email to Patient using ajax -
					$.ajax({
							url: "<?php print base_url(); ?>index.php/appointment_schedule/send_sms_email",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ appointment_id:appointment_id },
							success: function (res)
							{
								//alert(res);

								// check if appointment is successfully cancel -
								if(res != 0)
								{
									// hide loader -
									//hideProgress();

									alert('SMS/Email Sent Successfully.');

								}
							}
					});
				}
				else
				{
					return false;
				}

			});

			// function to get patient's contact no. on change of patient fname or lname -


			// get patient's contact no. on focus on contact no. field -

			// get patient contact no. -
			function get_contact_no(p_fname, p_lname)
			{
				var result = '';

				$.ajax({
						url: "<?php print base_url(); ?>index.php/appointment_schedule/get_contact_no",
						type: "post",
						async:false,
						cache:false,
						//dataType:'json',
						data:{ p_fname:p_fname, p_lname:p_lname },
						success: function (res)
						{
							//alert(res);

							// check if appointment is successfully cancel -
							if(res != 0)
							{
								//alert(res);

								// append mobile no. to current patient details field -
								//row.closest('tr').find('.p_contact_no').val(res);

								result = res;
							}
						}
				});

				return result;
			}

		});

		// Ref - http://code.runnable.com/UdQOiCHniSpKAAV1/add-autocomplete-to-input-box-form-using-jquery

		/* list of first and last names should go in this list. This is the source of the auto complete which will be populated in the text box */
		var data =
		<?php
			// get patient fname form table -
			$rsfname = $this->db->query("SELECT pk,CONCAT(p_fname, ' ', p_lname)  as label, patient_id FROM contact_list, (SELECT @a:= 0) AS a WHERE contact_list.is_deleted = 0");
			echo json_encode($rsfname->result());

		?>


		var data1 =
		<?php
			// get patient lname form table -
			$rsfname = $this->db->query("SELECT pk, CONCAT(p_fname, ' ', p_lname)  as fullname, patient_id as label FROM contact_list, (SELECT @a:= 0) AS a WHERE contact_list.is_deleted = 0");
			echo json_encode($rsfname->result());
		?>

		var data2 =
		<?php
			// get patient lname form table -
			$rsfname = $this->db->query("SELECT pk,  p_contact_no as label, CONCAT(p_fname, ' ', p_lname)  as fullname, patient_id FROM contact_list, (SELECT @a:= 0) AS a WHERE contact_list.is_deleted = 0");
			echo json_encode($rsfname->result());
		?>


		$(document).ready( function () {
			function get_contact_no(pk)
			{
				var result = '';

				$.ajax({
						url: "<?php print base_url(); ?>index.php/appointment_schedule/get_contact_no",
						type: "post",
						async:false,
						cache:false,
						//dataType:'json',
						data:{ pk:pk },
						success: function (res)
						{
							//alert(res);

							// check if appointment is successfully cancel -
							if(res != 0)
							{
								//alert(res);

								// append mobile no. to current patient details field -
								//row.closest('tr').find('.p_contact_no').val(res);

								result = res;
							}
						}
				});

				return result;
			}
				/* binding the text box with the jQuery Auto complete function. */
				$( ".p_fname" ).autocomplete({
				  /*Source refers to the list of first names that are available in the auto complete list. */
				  source:data,
				  /* auto focus true means, the first item in the auto complete list is selected by default. therefore when the user hits enter,
				  it will be loaded in the textbox */
				  autoFocus: true ,
					select: function (event, ui) {
						// var last_name = data1[ui.item.sno-1].label;
						 var row = $(this);

						 var p_fname = row.closest('tr').find('.p_fname').val();
						// row.closest('tr').find('.p_lname').val(last_name);

						 //alert(p_fname);
						 //alert(p_lname);


							 // get patient's contact no. using ajax -
							 res = get_contact_no(ui.item.pk);


							 // append mobile no. to current patient details field -
							 row.closest('tr').find('.p_contact_no').val(res);
							 row.closest('tr').find('.p_lname').val(ui.item.patient_id);



					}

				});

				$( ".p_lname" ).autocomplete({
				  /*Source refers to the list of last names that are available in the auto complete list. */
				  source:data1,
				  /* auto focus true means, the first item in the auto complete list is selected by default. therefore when the user hits enter,
				  it will be loaded in the textbox */
				  autoFocus: true ,
					select: function (event, ui) {
						// var last_name = data1[ui.item.sno-1].label;
						 var row = $(this);

						 var p_fname = row.closest('tr').find('.p_fname').val();
						// row.closest('tr').find('.p_lname').val(last_name);

						 //alert(p_fname);
						 //alert(p_lname);


							 // get patient's contact no. using ajax -
							 res = get_contact_no(ui.item.pk);


							 // append mobile no. to current patient details field -
							 row.closest('tr').find('.p_contact_no').val(res);
							 row.closest('tr').find('.p_fname').val(ui.item.fullname);



					}

				});

				$( ".p_contact_no" ).autocomplete({
				  /*Source refers to the list of last names that are available in the auto complete list. */
				  source:data2,
				  /* auto focus true means, the first item in the auto complete list is selected by default. therefore when the user hits enter,
				  it will be loaded in the textbox */
				  autoFocus: true ,
					select: function (event, ui) {
						// var last_name = data1[ui.item.sno-1].label;
						 var row = $(this);

						 var p_fname = row.closest('tr').find('.p_contact_no').val();
						// row.closest('tr').find('.p_lname').val(last_name);

						 //alert(p_fname);
						 //alert(p_lname);


							 // get patient's contact no. using ajax -
							 res = get_contact_no(ui.item.pk);


							 // append mobile no. to current patient details field -
							 row.closest('tr').find('.p_lname').val(ui.item.patient_id);
							 row.closest('tr').find('.p_fname').val(ui.item.fullname);



					}

				});
		});

	</script>

    </body>
</html>
