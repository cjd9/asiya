	<div class="modal-header">
	  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
	</div>
	
	<div class="modal-body">
	 
		<div class="contentpanel">
				
			<div class="row">
				<div class="col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<!-- panel-btns -->
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Email Details</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
							
							<?php $r = $rsemail->row(); ?>
					
							
								<div class="form-group">
									<label class="col-md-2 control-label">Patient ID (To)</label>
									<div class="col-sm-10">
										: <?php echo $r->patient_id; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label"> Subject</label>
									<div class="col-sm-10">
										: <?php echo $r->sub; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label">Message</label>
									<div class="col-sm-10">
										: <?php echo $r->msg; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label">Attachment</label>
									<div class="col-sm-10">
										: <a href="<?php echo base_url().'email_attachment_file/'.$r->attachment_file_name; ?>" target="_blank"> <?php echo $r->attachment_file_name; ?> </a>
									</div>
								</div><!-- form-group -->
								
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>