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
									<li><a href="#">Video</a></li>

								</ul>
								<h4>Edit Video </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<?php
							$r = $rsvideo->row();
						 ?>

						<div class="row">
							<div class="col-md-12">
								<form id="edit_festival_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="id" id="id"  value="<?php echo $r->id; ?>"/>

								<div class="panel panel-default">
									<div class ="panel-heading">
										<a style="margin-top: -7px;" href="<?php echo base_url().'video'?>" type="button" class="btn btn-default btn-sm">
												<span class="glyphicon glyphicon-arrow-left"></span> Back
										 </a>

										<h3 class="panel-title text-center"><i class="glyphicon glyphicon-edit"></i> <b>Edit Video </b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<input type="hidden" id="id" name="id" class="form-control validate[required]" value="<?php echo $r->id; ?>" />

                      <div class="form-group">
                       <label class="col-sm-2 control-label">Video Title<span class="asterisk">*</span></label>
                       <div class="col-sm-6">
                         <input type="text" name="title" value = "<?php echo $r->title; ?>" id="title" class="form-control validate[required]">
                       </div>
                     </div>
                     <div class="form-group">

                         <label class="col-sm-2 control-label">Tag<span class="asterisk">*</span></label>
                         <div class="col-sm-5">
                           <select id="tag" name="tag" data-placeholder="Choose Category " class="select2-container width100p">
                             <option value=""></option>
                             <?php
                               foreach ($tags->result() as $rl)
                               { ?>
                                  <option <?php echo ($rl->id == $r->tag) ? 'selected' : '';
?> value='<?php echo $rl->id ?>'><?php echo $rl->tag ?></option>;
                            <?php   } ?>
                             ?>
                           </select>
                           <span id="msg1" class="" style="color:#FF0000"></span>
                         </div>

                     </div><!-- form-group -->


											<div class="form-group">
												<label class="col-md-2 control-label">Description </label>
												<div class="col-sm-10">
													<textarea rows="10" name="description" id="description" class="form-control validate[required]"><?php echo $r->description; ?> </textarea>

												</div>
											</div><!-- form-group -->





										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>video" class="btn btn-dark">Cancel</a>
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
