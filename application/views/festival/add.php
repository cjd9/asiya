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
									<li><a href="#">Festival</a></li>

								</ul>
								<h4>Add Festival </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<div class="row">
							<div class="col-md-12">
								<form id="add_festival_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">

								<div class="panel panel-default">
									<div class ="panel-heading">
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Festival </b></h3>

									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<?php
												$sql = "SELECT festival_id FROM religious_festivals WHERE is_deleted = 0 ORDER BY festival_id DESC LIMIT 1";

												$rs = $this->db->query($sql);

												if($rs->num_rows() > 0)
												{
													$x = $rs->row()->festival_id;

													$x = $this->mastermodel->get_auto_no($x);
												}
												else
												{
													$x = 'ACT0001';
												}
											?>

											<input type="hidden" id="festival_id" name="festival_id" class="form-control validate[required]" value="<?php echo $x; ?>" />
                      <div class="form-group">
                       <label class="col-sm-2 control-label">Festival Name<span class="asterisk">*</span></label>
                       <div class="col-sm-6">
                         <input type="text" name="festival_name" id="festival_name" class="form-control validate[required]">
                       </div>
                     </div>
											<div class="form-group">
												<label class="col-sm-2 control-label">Date<span class="asterisk">*</span></label>
												<div class="col-sm-3">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input type="text" class="form-control datepicker" name="date" value="<?php echo date('d-m-Y')?>">
													</div><!-- input-group -->
												</div>
											</div><!-- form-group -->
                      <div class="form-group">

      										<label class="col-sm-2 control-label">Religion Name<span class="asterisk">*</span></label>
      										<div class="col-sm-5">
      											<select id="religion_id" multiple="multiple" name="religion_id[]" data-placeholder="Choose Religion " class="select2-container width100p">
      												<option value=""></option>
      												<?php
      													foreach ($religion_list->result() as $r)
      													{
      														echo "<option value='".$r->pk."'>".$r->religion."</option>";
      													}
      												?>
      											</select>
      											<span id="msg1" class="" style="color:#FF0000"></span>
      										</div>

      								</div><!-- form-group -->
											<div class="form-group">
												<label class="col-md-2 control-label">Description<span class="asterisk">*</span></label>
												<div class="col-sm-10">
													<textarea rows="10" name="message" id="message" class="form-control validate[required]"></textarea>
												</div>
											</div><!-- form-group -->


										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>activity_program" class="btn btn-dark">Cancel</a>
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
			$("#add_activity_program_form").validationEngine({promptPosition: "topRight: -100"});

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

				$(wrapper).append('<span style="display:inline;"><input type="file" name="activity_program_file[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span><br>'); //add input box
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

	</script>

    </body>
</html>
