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
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add SAMVAAD</b></h3>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">

											<div class="form-group">
												<label class="col-md-1 control-label"> Description<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<textarea  name="education_program_desc" id="education_program_desc" class="" rows="10" cols="80"></textarea>
												</div>
											</div><!-- form-group -->

											<div class="form-group">
												<label class="col-md-1 control-label"> File<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="file" id="education_program_file" name="education_program_file" class="form-control" />
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
    <script src="<?php print base_url(); ?>js/ckeditor.js"></script>

	<script>

		$(document).ready(function()

		  {
          CKEDITOR.basePath = CKEDITOR.basePath +'ckeditor/';
           window.CKEDITOR_BASEPATH = CKEDITOR.basePath;
        CKEDITOR.replace( 'education_program_desc' );
			//$("#add_education_program_form").validationEngine({promptPosition: "topRight: -100"});
		});
	</script>

    </body>
</html>
