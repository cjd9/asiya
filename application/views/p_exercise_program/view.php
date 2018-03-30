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
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Exercise Program</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
							
							<?php  
								$r = $rsexercise_program->row();
							 ?>
								<h4><u><b>Patient Details</b></u></h4>
								<div class="form-group">
									<label class="col-md-2 control-label"><b>ID</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo $r->patient_id; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Name</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo ucwords($row1->p_fname.' '.$row1->p_lname); ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Gender</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo $row1->p_gender; ?>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Contact No.</b></label>
								  	<div class="col-sm-6">
										<b>:</b> <?php echo $row1->p_contact_no; ?>
									</div>
								</div><!-- form-group -->
								
								<h4><u><b>Exercise Program Details</b></u></h4>
								
								<div class="form-group table-responsive">
								<label class="col-md-2 control-label"><b>File</b></label>
									<div class="col-sm-6">
										<table class="table table-striped table-bordered responsive">
											<tr style="text-align:center">
												<th>File Name</th>
											</tr>
											<?php foreach($rsexercise_program->result() as $r2) { ?>
											<tr>
												<td>
													<a href="<?php echo base_url().'exercise_program_file/'.$r2->exercise_program_file; ?>" target="_blank">
														<?php echo $r2->exercise_program_file; ?>
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
								
								<div class="form-group">
									<label class="col-md-2 control-label"><b>Description</b></label>
								  	<div class="col-sm-10">
										<b>:</b> <?php echo $r->exercise_program; ?>
									</div>
								</div><!-- form-group -->
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>