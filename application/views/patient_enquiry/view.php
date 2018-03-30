<div class="modal-header">
  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
</div>

<div class="modal-body">
	<div class="contentpanel">
		<div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">
						<i class="fa fa-comments"></i><b> View Patient Appointment Enquiry Details</b>
						</h3>
					</div><!-- panel-heading -->
					
					<?php $r = $rspatient_enquiry->row(); ?>
					
					<div class="panel-body">
						<div class="row">
						
							<div class="form-group">
								<label class="col-md-3 control-label">Appointment Confirm By</label>
								<div class="col-sm-9">
									: <?php if($r->confirm_by_staff != 0) { $row1 = $this->db->get_where('staff_details', array('pk' => $r->confirm_by_staff))->row(); echo $row1->s_fname.' '.$row1->s_lname; } ?>
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-md-3 control-label">Confirm On</label>
								<div class="col-sm-9">
									: <?php echo $r->confirm_on; ?>
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-md-3 control-label">Appointment Cancel By</label>
								<div class="col-sm-9">
									: <?php  if($r->cancelled_by_staff != 0) { $row2 = $this->db->get_where('staff_details', array('pk' => $r->cancelled_by_staff))->row(); echo $row2->s_fname.' '.$row2->s_lname; } ?>
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-md-3 control-label">Cancelled On</label>
								<div class="col-sm-9">
									: <?php echo $r->cancelled_on; ?>
								</div>
							</div><!-- form-group -->
						
						</div><!-- row -->
					</div><!-- panel-body -->
				</div><!-- panel -->
				
			</div><!-- col-md-12 -->

		</div><!--row -->
		   
  	</div><!-- contentpanel --> 
</div>