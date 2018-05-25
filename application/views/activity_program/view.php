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
							<h3 class="panel-title" ><i class="glyphicon glyphicon-search"></i> <b>View Activity Program</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
							
							<?php  
								$r = $rsactivity_program->row();
							 ?>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Upload Date</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo date("d-m-Y",strtotime($r->date_of_upload)); ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Description</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo $r->activity_program; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group table-responsive">
								<label class="col-md-2 control-label"><b>File</b></label>
									<div class="col-sm-6">
										<table class="table table-striped table-bordered responsive">
											<tr style="text-align:center">
												<th>File Name</th>
											</tr>
											<?php foreach($rsactivity_program->result() as $r2) { ?>
											<tr>
												<td>
													<a href="<?php echo base_url().'activity_program_file/'.$r2->activity_program_file; ?>" target="_blank">
														<?php echo $r2->activity_program_file; ?>
													</a>
												</td>
											</tr>
											<?php } ?>
										</table>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<label class="col-md-2 control-label"><b>Expiry Date</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo date("d-m-Y",strtotime($r->expiry_date)); ?>
									</div>
								</div><!-- form-group -->

							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>