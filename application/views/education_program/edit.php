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
									<li><a href="#">SAMVAAD</a></li>
									
								</ul>
								<h4>Edit SAMVAAD</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<?php  
							$r = $rseducation_program->row();
						 ?>

						<div class="row">
							<div class="col-md-12">
								<form id="edit_education_program_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit SAMVAAD</b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Description</label>
												<div class="col-sm-9">
													<textarea  name="education_program_desc" id="education_program_desc" class="" rows="10" cols="80"><?php echo $r->education_program_desc; ?></textarea>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<div class="col-sm-12">
													<label class="col-md-2 control-label">File</label>
													<div class="col-sm-6">
														<input type="file" id="education_program_file" name="education_program_file" class="form-control" />
													</div>
												
													<div class="col-sm-4">
														[<label class="col-md-2 control-label"><b> File : </b></label>
														<a href="<?php echo base_url().'./education_program_file/'.$r->education_program_file; ?>" target="_blank">
															<?php echo $r->education_program_file; ?>
														</a>]
													</div>
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>index.php/education_program" class="btn btn-dark">Cancel</a>
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
			$("#edit_education_program_form").validationEngine({promptPosition: "topRight: -100"});
		}); 
	</script>

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