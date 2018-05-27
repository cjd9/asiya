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
									<li><a href="#">Clinical Meetings</a></li>
									
								</ul>
								<h4>Edit Clinical Meetings </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<?php  
							$r = $rsclinical_meetings->row();
						 ?>

						<div class="row">
							<div class="col-md-12">
								<form id="edit_clinical_meetings_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										
										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit Clinical Meetings </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											
											<div class="form-group">
												<label class="col-md-3 control-label"> Meetings Description</label>
												<div class="col-sm-9">
													<input type="text" name="clinical_meetings_desc" id="clinical_meetings_desc" class="form-control validate[required]" value="<?php echo $r->clinical_meetings_desc; ?>" />
												</div>
											</div><!-- form-group -->
											<div class="form-group">
											
												<label class="col-md-3 control-label"> Date<span class="asterisk">*</span></label>
												<div class="col-sm-6">
												<input type="text" class="form-control validate[required] datepicker" name="meeting_date" id="meeting_date" value="<?php echo date('d-m-Y')?>">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label"> Meetings File</label>
												<div class="col-sm-5">
													<input type="file" id="clinical_meetings_file" name="clinical_meetings_file" class="form-control" />
												</div>
												<label class="col-md-1 control-label" style="text-align:right"><b> File : </b></label>
												<div class="col-sm-3">
													<a href="<?php echo base_url().'clinical_meetings_file/'.$r->clinical_meetings_file; ?>" target="_blank">
														<?php echo $r->clinical_meetings_file; ?>
													</a>
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>index.php/clinical_meetings" class="btn btn-dark">Cancel</a>
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
				$('#meeting_date').datepicker(
					{
						changeMonth: true,
						changeYear: true,
						yearRange: '1945:2050',
						dateFormat: 'dd-mm-yy',
						minDate: 0
						//minDate: 0	// disable all previous dates
					});


			$(function () {
					    $('input[type=file]').change(function () {
					        var val = $(this).val().toLowerCase(),
					            regex = new RegExp("(.*?)\.(docx|doc|pdf|xml|bmp|ppt|xls|jpg|png|bmp|jpeg)$");

					        if (!(regex.test(val))) {
					            $(this).val('');
					            alert('Please select any one of docx|doc|pdf|xml|bmp|ppt|xls|jpg|png|jpeg file format');
					        }
					    });
					});
			$("#edit_clinical_meetings_form").validationEngine({promptPosition: "topRight: -100"});
		}); 
	</script>
	
    </body>
</html>