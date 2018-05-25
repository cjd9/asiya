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
									<li><a href="#">Clinical Meetings</a></li>
									
								</ul>
								<h4>Add Clinical Meetings </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<div class="row">
							<div class="col-md-12">
								<form id="add_clinical_meetings_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Clinical Meetings </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											
										<div class="form-group">
												<label class="col-md-3 control-label"> Meetings Description<span class="asterisk">*</span></label>
												<div class="col-sm-9">
													<input type="text" name="clinical_meetings_desc" id="clinical_meetings_desc" class="form-control validate[required]">
												</div>
										</div><!-- form-group -->
										<div class="form-group">
											
												<label class="col-md-3 control-label"> Date<span class="asterisk">*</span></label>
												<div class="col-sm-6">
												<input type="text" class="form-control validate[required] datepicker" name="meeting_date" id="date_of_treatment" value="<?php echo date('d-m-Y')?>">
												</div>
										</div>
											<div class="form-group">
												<label class="col-md-3 control-label"> Meetings File<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="file" id="clinical_meetings_file" name="clinical_meetings_file" class="form-control" />
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>clinical_meetings" class="btn btn-dark">Cancel</a>
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
	</script>
	
    </body>
</html>