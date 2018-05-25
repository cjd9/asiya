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
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Patient Sharing History</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
					 	
							<?php $row = $rssharing_details->row(); ?>
								<div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th>Patient ID</th>
											<th>Patient Name</th>
											<th>Reg. By</th>
											<th>Prev. Shared Staff & Date</th>
											<th>Cur. Shared Staff & Date</th>
										</tr>
									</thead>
							 
									<tbody>
									   <tr>
											<td><?php echo $row->patient_id; ?></td>
											<td>
												<?php $r = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo $r->p_fname.' '.$r->p_mname.' '.$r->p_lname; ?>
											</td>
											<td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->added_by_user))->row(); echo $r->s_fname.' '.$r->s_lname; ?></td>
											<td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->old_assign_staff_id))->row(); echo $r->s_fname.' '.$r->s_lname; ?>, <?php echo $this->mastermodel->date_convert($row->old_assign_date,'dmy'); ?> </td>
											<td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->current_assign_staff_id))->row(); echo $r->s_fname.' '.$r->s_lname; ?>, <?php echo $this->mastermodel->date_convert($row->current_assign_date,'dmy'); ?></td>
										</tr>
									</tbody>
								</table>
								</div>
							</div><!-- row -->
						</div><!-- panel-body -->
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>