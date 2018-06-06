<?php  $this->load->view('include/header'); ?>

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
									<li><a href="#">Festival</a></li>

								</ul>
								<h4>Edit Festival </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<?php
							$r = $rsfestival->row();
						 ?>

						<div class="row">
							<div class="col-md-12">
								<form id="edit_festival_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->festival_id; ?>"/>

								<div class="panel panel-default">
									<div class ="panel-heading">

										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit Festival </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<input type="hidden" id="festival_id" name="festival_id" class="form-control validate[required]" value="<?php echo $r->festival_id; ?>" />
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
                      <div class="form-group">
                       <label class="col-sm-2 control-label">Festival Name<span class="asterisk">*</span></label>
                       <div class="col-sm-6">
                         <input type="text" name="festival_name" value = "<?php echo $r->festival_name; ?>" id="festival_name" class="form-control validate[required]">
                       </div>
                     </div>
                     <div class="form-group">

                         <label class="col-sm-2 control-label">Religion Name<span class="asterisk">*</span></label>
                         <div class="col-sm-5">
                           <select id="religion_id" multiple="multiple" name="religion_id[]" data-placeholder="Choose Religion " class="select2-container width100p">
                             <option value=""></option>
                             <?php
                               foreach ($religion_list->result() as $rl)
                               {
                                 echo "<option value='".$rl->pk."'>".$rl->religion."</option>";
                               }
                             ?>
                           </select>
                           <span id="msg1" class="" style="color:#FF0000"></span>
                         </div>

                     </div><!-- form-group -->
											<div class="form-group">
												<label class="col-sm-2 control-label">Date</label>
												<div class="col-sm-3">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input type="text" class="form-control datepicker" name="date" value="<?php echo date("d-m-Y",strtotime($r->date)); ?>">
													</div><!-- input-group -->
												</div>

											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-2 control-label">Description </label>
												<div class="col-sm-10">
													<textarea rows="10" name="message" id="message" class="form-control validate[required]"><?php echo $r->message; ?></textarea> </textarea>
												</div>
											</div><!-- form-group -->





										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>festival" class="btn btn-dark">Cancel</a>
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
			$("#edit_activity_program_form").validationEngine({promptPosition: "topRight: -100"});
		});
	</script>

	<script>
  var datasel =<?php echo json_encode(explode(',',$rsfestival->result_array()[0]['religion_id'])) ?>;
	$(document).ready(function()
	{
  
    $('#religion_id').select2({}).select2('val', datasel);
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

	//************************************************************************************************

	// function to delete xray report file using ajax -
	$('.btn-delete').on('click', function()
	{
		var res = confirm('You Want To Delete This File?');

		if(res)
		{
			var row = $(this);

			// get id of that record -
			var id = row.attr('data-value');

			$.ajax({
					url: "<?php print base_url(); ?>activity_program/delete_activity_program_file",
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

							// remove deleted row -
							row.closest('tr').remove();
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
