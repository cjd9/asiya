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
						<i class="glyphicon glyphicon-search"></i><b> View Sens SMS Details</b>
						</h3>
					</div><!-- panel-heading -->
					
					<?php $r = $rssms->row(); ?>
					
					<div class="panel-body">
						<div class="row">
						
							<div class="form-group">
								<label class="col-md-2 control-label">Patient Name (To)</label>
								<div class="col-sm-10">
									: <?php echo $r->patient_id; ?>
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-md-2 control-label">Patient Contact No.</label>
								<div class="col-sm-10">
									: <?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $row1->p_contact_no; ?>
								</div>
							</div><!-- form-group -->
							
							<div class="form-group">
								<label class="col-md-2 control-label">Send Message</label>
								<div class="col-sm-10">
									: <?php echo $r->msg; ?>
								</div>
							</div><!-- form-group -->
						
						</div><!-- row -->
					</div><!-- panel-body -->
				</div><!-- panel -->
				
			</div><!-- col-md-12 -->

		</div><!--row -->
		   
  	</div><!-- contentpanel --> 
</div>