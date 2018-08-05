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
									<li><a href="#">Video</a></li>

								</ul>
								<h4>Add Video </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<div class="row">
							<div class="col-md-12">
								<form id="add_clinical_meetings_form" action="/exercise_program/addVideoDetails" method="post" enctype="multipart/form-data" onSubmit="return validate()">

								<div class="panel panel-default">
									<div class="panel-heading">
										<a style="margin-top: -7px;" href="<?php echo base_url().'exercise_program'?>" type="button" class="btn btn-default btn-sm">
												<span class="glyphicon glyphicon-arrow-left"></span> Back
										 </a>
										<h3 class="panel-title text-center"><i class="glyphicon glyphicon-pencil"></i> <b>Add Video </b></h3>
										
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
                     				 <div class="form-group">
												<label class="col-md-3 control-label">Exercise Name<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<input type="text" name="title" id="title" class="form-control validate[required]">
												</div>
									</div><!-- form-group -->
                   				   <div class="form-group">
                      				<div class="form-group">
												<label class="col-md-3 control-label"> Exercise Description<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<textarea name="description" id="description" class="form-control validate[required]"></textarea>
												</div>
									</div><!-- form-group -->
												<label class="col-md-3 control-label">Category<span class="asterisk">*</span></label>
												<div class="col-sm-9">
						                          <select id="tag" name="tag" data-placeholder="Choose One" class="select2-container width100p">
																				<option value=""></option>
																<?php foreach($tag_master as $tag){
																	echo '<option value="'.$tag['tag'].'">'.$tag['tag'].'</option>';
																       }
																?>


						                        </select>
												</div>
											</div><!-- form-group -->


											<div class="form-group">
												<label class="col-md-3 control-label"> Upload Video<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<input type="file" id="video_file" name="video_file" class="form-control" />
												</div>
											</div><!-- form-group -->

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

	<script>
		$(document).ready(function()
		{
			$("#add_clinical_meetings_form").validationEngine({promptPosition: "topRight: -100"});
		});
		$(function () {
					    $('input[type=file]').change(function () {
					        var val = $(this).val().toLowerCase(),
					            regex = new RegExp("(.*?)\.(docxx|mp4|bmp)$");

					        if (!(regex.test(val))) {
					            $(this).val('');
					            alert('Please select any one of docx|doc|pdf|xml|bmp|ppt|xls|jpg|png|jpeg file format');
					        }
					    });
					});
	</script>

    </body>
</html>
