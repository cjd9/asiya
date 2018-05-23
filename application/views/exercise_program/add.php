<?php $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>
<link href="<?php print base_url(); ?>exercise.css" rel="stylesheet">

			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-pencil"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Exercise Program</a></li>

								</ul>
								<h4>Add Exercise Program </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<div class="row">
							<div class="col-md-12">
								<form id="add_exercise_program_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Exercise Program </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<?php
												$sql = "SELECT exercise_id FROM  exercise_program WHERE is_deleted = 0 ORDER BY exercise_id DESC LIMIT 1";

												$rs = $this->db->query($sql);

												if($rs->num_rows() > 0)
												{
													$x = $rs->row()->exercise_id;

													$x = $this->mastermodel->get_auto_no($x);
												}
												else
												{
													$x = 'EXER0001';
												}
											?>

											<input type="hidden" id="exercise_id" name="exercise_id" class="form-control validate[required]" value="<?php echo $x; ?>" />

											<div class="form-group">
												<div class="col-sm-7">
													<label class="col-md-4 control-label">Patient Name <span class="asterisk">*</span></label>
													<div class="col-sm-7">
														<select id="patient_id" name="patient_id" data-placeholder="Choose Patient " class="select2-container width100p">
															<option value=""> </option>
															<?php
																foreach ($rscontact_list->result() as $r)
																{
																	echo "<option value='".$r->patient_id."'>".$r->p_fname.' '.$r->p_mname.' '.$r->p_lname."</option>";
																}
															?>
														</select>
														<span id="msg1" class="" style="color:#FF0000"></span>
													</div>
												</div>

												<div class="col-sm-5">
													<label class="col-sm-4 control-label">Date of Upload</label>
													<div class="col-sm-5">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="date_of_upload" value="<?php echo date('d-m-Y')?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->


											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">Description<span class="asterisk">*</span></label>
													<div class="col-sm-10">
														<textarea rows="10" name="exercise_program" id="exercise_program" class="form-control validate[required]"></textarea>
													</div>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">File Expiry Date<span class="asterisk">*</span></label>
													<div class="col-sm-4">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control datepicker" name="expiry_date" placeholder="dd-mm-yyyy" id="expiry_date">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->
                      <br>
											<!-- <div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">File<span class="asterisk">*</span></label>
													<div class="col-sm-8" id="file_upload">
														<input type="file" id="exercise_program_file" name="exercise_program_file[]" class=""/>
													</div>
													<div class="col-sm-2">
														<button type="button" class="btn btn-primary btn-sm" id="add_more">
															 <span class="glyphicon glyphicon-plus"> <b>Upload More</b></span>
														</button>
													</div>
												</div>
											</div><!-- form-group --> 

											<div class="form-group">
												<div class="col-sm-12">
													<label class="col-md-2 control-label">Choose Tag<span class="asterisk">*</span></label>
													<div class="col-sm-6">
														  <select id="tag" name="tag" data-placeholder="Choose One" class="select2-container width100p">
															<option value=""></option>
									<?php foreach($video_list as $vid){?>
																<option value="<?php echo $vid['tag']?>"><?php echo $vid['tag']?></option>
									<?php } ?>
														</select>
														<span id="msg1" class="" style="color:#FF0000"></span>
													</div>
												</div>
												</div>
                      <br>
                  			  <div class="form-group" id="video-append">


										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>exercise_program" class="btn btn-dark">Cancel</a>
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
		        <script src="<?php print base_url(); ?>js/jquery.validate.min.js"></script>
  <script src="<?php print base_url(); ?>js/jquery.validate.min.js"></script>


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

				$(wrapper).append('<span style="display:inline;"><input type="file" name="exercise_program_file[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span><br>'); //add input box
			}
		});

		$("span.remove_field").live("click", function(e)
		{
			// user click on remove text
			e.preventDefault();

			$(this).parent('span').remove();
			x--;
		});

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
									 		$('.datepicker').datepicker({
												changeMonth: true,
												changeYear: true,
												yearRange: '1945:2050',
												dateFormat: 'yy-mm-dd',
												 minDate: 0
											});
												jQuery.validator.addClassRules("required-field", {
											        required: true,
											    });
								 },
								 beforeSend: function ()
								 {
								 }
						 });
		});


		$("#add_exercise_program_form").validate({
				  rules: {
				    expiry_date: {
				      required: true

				    }
				  }
				});


	});

	</script>

    </body>
</html>
