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
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Patient Treatment Details</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
							
							<?php  
								$r = $rstreatment->row();
							 ?>
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-md-4 control-label">Treatment ID</label>
										<div class="col-sm-6">
											: <?php echo $r->treatment_id; ?>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Date Of Treatment</label>
										<div class="col-sm-6">
											: <?php echo date("d-m-Y",strtotime($r->date_of_treatment)); ?>
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Patient Name</label>
										<div class="col-sm-6">
											: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?>
											<span id="msg1" class="" style="color:#FF0000"></span>
										</div>
									</div>
								</div><!-- form-group -->
								
								<hr />
								<h4><u><b>Plan of Care</b></u></h4>
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Short Term Goals</label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" readonly=""><?php echo $r->short_term_goal; ?></textarea>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Long Term Goals</label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" readonly=""><?php echo $r->long_term_goal; ?></textarea>
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Next Therapy Plan</label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" readonly=""><?php echo $r->next_therapy_plan; ?></textarea>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Fees</label>
										<div class="col-sm-3">
											<input type="text" class="form-control" readonly="" value="<?php echo $r->treatment_fees; ?>" />
										</div>
									</div>
								</div><!-- form-group -->
								
								<hr />
								<h4><b><u>Treatment Therapy </u></b></h4>
								
								<div class="form-group responsive">
									<div class="col-sm-12 table-responsive">
									<table class="table table-dark mb30 responsive">
										<thead>
											<tr>
												<th>Manual Therapy</th>
												<th>Exercise Therapy</th>
												<th>Electro Therapy</th>
												<th>Others</th>
												<th>Notes</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>
													<textarea class="form-control" rows="5" readonly=""><?php echo $r->maual_therapy; ?></textarea>
												</td>
												<td>
													<textarea class="form-control" rows="5" readonly=""><?php echo $r->exercise_therapy; ?></textarea>
												</td>
												<td>
													<textarea class="form-control" rows="5" readonly=""><?php echo $r->electro_therapy; ?></textarea>
												</td>
												<td>
													<textarea class="form-control" rows="5" readonly=""><?php echo $r->other_therapy; ?></textarea>
												</td>
												<td>
													<textarea class="form-control" rows="5" readonly=""><?php echo $r->notes_therapy; ?></textarea>
												</td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>	
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>