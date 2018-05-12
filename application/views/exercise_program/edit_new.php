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
									<li><a href="#">Exercise Program</a></li>

								</ul>
								<h4>View Exercise Program </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<?php
							$r = $rsexercise_program->row();
						 ?>

						<div class="row">
							<div class="col-md-12">
								<form id="edit_exercise_program_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" disabled name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<a href="<?php echo base_url().'exercise_program'; ?>" type="button" class="btn btn-default btn-sm">
								          <span class="glyphicon glyphicon-arrow-left "></span> Back
								        </a>
										<h3 class="panel-title text-center"><i class="glyphicon glyphicon-edit text-center"></i> <b>View Exercise Program </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<input type="hidden" id="exercise_id" disabled name="exercise_id" class="form-control validate[required]" value="<?php echo $r->exercise_id; ?>" />

											<div class="form-group">
												<div class="col-sm-7">
													<label class="col-md-4 control-label">Patient Name </label>
													<div class="col-sm-7">
													<b>: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?></b>
														<input type="hidden" disabled name="patient_id" id="patient_id" value="<?php echo $r->patient_id; ?>" />
													</div>
												</div>

												<div class="col-sm-5">
													<label class="col-sm-4 control-label">Date of Upload</label>
													<div class="col-sm-5">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" disabled name="date_of_upload" value="<?php echo date("d-m-Y",strtotime($r->date_of_upload)); ?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->

											<hr />
											<h4><b><u>Exercise Program </u></b></h4>

											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">Description </label>
													<div class="col-sm-10">
														<textarea rows="10" disabled name="exercise_program" id="exercise_program" class="form-control validate[required]"><?php echo $r->exercise_program; ?></textarea>
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">File Expiry Date </label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" disabled name="expiry_date" id="expiry_date" value="<?php echo date("d-m-Y",strtotime($r->expiry_date)); ?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->



											<div class="form-group"><!-- Start form-group -->
												<div class="form-group" id="">
													<?php	echo $html; ?>

												</div>
                                            </div><!-- End form-group -->

                      <br>
										</div><!-- row -->
										<div class = "row">
												<div class="form-group">
											
											</div>
											<div class="form-group" id="video-append">
											</div>

										</div>
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
			$("#edit_exercise_program_form").validationEngine({promptPosition: "topRight: -100"});

			// select box validations -
			$('#edit_exercise_program_form').on('submit', function()
			{
				$('#msg1').text('');

				if($('#patient_id').val() == '' || $('#patient_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}
			});

		});
	</script>

	<script>

	$(document).ready(function()
	{
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $("#file_upload"); //Fields wrapper
		var add_button      = $("#add_more"); //Add button ID

		var x = 1; //initlal text box count

		$(add_button).click(function(e)
		{
			//on add input button click
			e.preventDefault();

			if(x < max_fields)
			{
				//max input box allowed
				x++; //text box increment

				$(wrapper).append('<span style="display:inline;"><input type="file" disabled name="exercise_program_file[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span><br>'); //add input box
			}
		});

		$("span.remove_field").live("click", function(e)
		{
			// user click on remove text
			e.preventDefault();

			$(this).parent('span').remove();
			x--;
		});

	});

	//************************************************************************************************
	$("#tag").live("change", function(e)
		{
			// user click on remove text
			e.preventDefault();
			var tag = $('#tag').val();
			$.ajax({
								 url: '/exercise_program/fetchVideoByTag',
								 type: 'POST',
								 data: {tag:tag},
								 dataType: 'html',
								 success: function (result)
								 {
									 $('#video-append').empty()

									 $('#video-append').append(result)
								 },
								 beforeSend: function ()
								 {
								 }
						 });
		});

	$('#delete_video').live("click",function (e)
	{
					e.preventDefault();

		$.ajax({
					url: "<?php print base_url(); ?>/exercise_program/delete_exercise_program_file",
					type: "post",
					async:false,
					cache:false,
					//dataType:'json',
					data:{ id:$(this).val() },
					success: function (res)
					{
						//alert(res);

						if(res != 0)
						{
							alert('File Deleted Successfully.');

							// remove deleted row -
							row.closest('tr').remove();
						}
					}
			});
	});
	// function to delete xray report file using ajax -
	$('.btn-delete').on('click', function()
	{
		var res = confirm('You Want To Delete This File?');

		if(res)
		{
			var row = $(this);

			// get id of that record -
			var id = row.attr('data-value');

			//alert(id);

			$.ajax({
					url: "<?php print base_url(); ?>index.php/exercise_program/delete_exercise_program_file",
					type: "post",
					async:false,
					cache:false,
					//dataType:'json',
					data:{ id:id },
					success: function (res)
					{
						//alert(res);

						if(res != 0)
						{
							alert('File Deleted Successfully.');
							location.reload();


							// remove deleted row -
							//row.closest('tr').remove();
						}
					}
			});
		}
		else
		{
			return false;
		}

	});
	</script>

    </body>
</html>
