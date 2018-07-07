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
									<li><a href="#">SAMVAAD</a></li>

								</ul>
								<h4>Add SAMVAAD</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel">

						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<div class="row">
							<div class="col-md-12">
								<form id="add_education_program_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">

								<div class="panel panel-default">
									<div class="panel-heading">

										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add SAMVAAD</b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">
											<div class="form-group">
												<label class="col-md-1 control-label">Title<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<input type="text" name="title" id="title" class="form-control validate[required]">
												</div>
											</div><!-- form-group -->
											<div class="form-group">
												<label class="col-md-1 control-label"> Description<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<textarea  name="education_program_desc" id="education_program_desc" class="" ></textarea>
												</div>
											</div><!-- form-group -->
											<div class="form-group">

													<label class="col-md-1 control-label"> Date<span class="asterisk">*</span></label>
													<div class="col-sm-6">
													<input type="text" class="form-control validate[required]" name="samvaad_date" id="samvaad_date" value="<?php echo date('d-m-Y')?>">
													</div>
											</div>

											<div class="form-group">
												<label class="col-md-1 control-label"> File<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="file" id="education_program_file" accept=".jpg,.png,.pdf" name="education_program_file" class="form-control" />
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-1 control-label"> Thumbnail<span class="asterisk"></span></label>
												<div class="col-sm-6">
													<input type="file" id="thumbnail" accept=".jpg,.png" name="thumbnail" class="form-control" />
												</div>
											</div><!-- form-group -->

										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>education_program" class="btn btn-dark">Cancel</a>
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
    <!-- <script src="<?php print base_url(); ?>js/ckeditor.js"></script> -->

		<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.css" rel="stylesheet">
		<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js"></script>

	<script>

		$(document).ready(function()

		  {
					  	$(function () {
			    $('input[type=file]').change(function () {
			        var val = $(this).val().toLowerCase(),
			            regex = new RegExp("(.*?)\.(docx|doc|pdf|xml|bmp|ppt|xls|jpg|png|bmp|jpeg)$");

			        if (!(regex.test(val))) {
			            $(this).val('');
			            alert('Please select any one of docx|doc|pdf|xml|bmp|ppt|xls|jpg|png|jpeg file format');
			        }
			    });

					$('#samvaad_date').datepicker(
					{
						changeMonth: true,
						changeYear: true,
						yearRange: '1945:2050',
						dateFormat: 'dd-mm-yy',
						minDate: 0
						//minDate: 0	// disable all previous dates
					});
			});

			$('#education_program_desc').summernote({
		        placeholder: 'Edit Your Text Here ... ',
		        
				tabsize: 2,
		        height: 200,
			    theme: 'lumen'
				
     		 });

			//$("#add_education_program_form").validationEngine({promptPosition: "topRight: -100"});
		});
	</script>
<style>
    .panel-heading .btn-group {
    	margin-bottom: 0 !important;
    }
</style>
    </body>
</html>
