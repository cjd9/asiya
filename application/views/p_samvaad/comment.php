	
	<div class="modal-body">
	 
		<div class="contentpanel">
				
			<div class="row">
				<div class="col-md-12">
					
					<div class="panel panel-success-head">
						<div class="panel-heading">
							<!-- panel-btns -->
							<button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
							
							<h3 class="panel-title"><i class="fa fa-comments"></i> <b>Comment Details</b></h3>
							  
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
							
								<form id="add_comment_form" method="post" action="<?php echo $commentaction; ?>" enctype="multipart/form-data">
									<input type="hidden" name="samvaad_id" id="samvaad_id"  value="<?php echo $id; ?>"/>
						
									<div class="form-group"><!-- Start form-group -->
										<div class="col-sm-12">
										<label><b>Comment</b></label>
											<textarea class="form-control validate[required]" rows="3" name="comment" id="comment"></textarea>
										</div>
									</div>
									
									<div class="form-group"><!-- Start form-group -->
										<div class="col-sm-12">
											<div class="row pull-right">
												<button class="btn btn-xs btn-rounded btn-warning mr5"><i class="fa fa-comments"></i> Comment</button>
												<button type="reset" class="btn btn-xs btn-rounded btn-dark">Cancel</button>
											</div>
										</div>
									</div>
									
								</form>
								
								<div class="form-group"><!-- Start form-group -->
									<div class="col-sm-12">
									<label><b><u>Comment List</u></b></label>
										<div class="table-responsive">
											<table id="basicTable1" class="table table-bordered table-striped responsive" width="100%">
												<thead>
													<tr >
													  	<th width="3%"><div align="center">#</div></th>
														<th>User Name</th>
														<th>User</th>
														<th>Comment</th>
														<th>Date</th>
														
													</tr>
												</thead>
												<tbody>
													<?php $cnt = 0; foreach($rssamvaad_comment->result() as $row) : ?>
												   	<tr>
														<td align="center"><?php echo ++$cnt; ?></td>
														<td>
															<?php 
																if($row->user_type == 'A')
																{
																	$row1 = $this->db->get_where('staff_details', array('pk' => $row->comment_by))->row(); 
																	echo ucwords($row1->s_fname.' '.$row1->s_lname); 
																	//echo ' -[As a Admin]';
																}
																else if($row->user_type == 'S')
																{
																	$row2 = $this->db->get_where('staff_details', array('pk' => $row->comment_by))->row(); 
																	echo ucwords($row2->s_fname).' '.ucwords($row2->s_lname); 
																	//echo ' -[As a Staff]';
																}
																else if($row->user_type == 'P')
																{
																	$row3 = $this->db->get_where('contact_list', array('pk' => $row->comment_by))->row(); 
																	echo ucwords($row3->p_fname.' '.$row3->p_lname); 
																	//echo ' -[As a Patient]';
																}
															?>
														</td>
														<td>
															<?php 
																if($row->user_type == 'A')
																{
																	echo 'Admin';
																}
																else if($row->user_type == 'S')
																{
																	echo 'Staff';
																}
																else if($row->user_type == 'P')
																{
																	echo 'Patient';
																}
															?>
														</td>
														<td><?php echo wordwrap($row->comment,80,"<br>\n",TRUE); ?></td>
														<td><?php echo date("d-m-Y",strtotime($row->comment_on)); ?></td>
														
												  	</tr>	
												  	<?php endforeach ; ?>
												</tbody>
											</table>
										</div>
									</div>
								</div><!-- End form-group -->
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						
					</div><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>
	
	<script src="<?php print base_url(); ?>js/jquery.dataTables.min.js"></script>
	<script src="http://cdn.datatables.net/plug-ins/725b2a2115b/integration/bootstrap/3/dataTables.bootstrap.js"></script>
	<script src="http://cdn.datatables.net/responsive/1.0.1/js/dataTables.responsive.js"></script>
	<script src="<?php print base_url(); ?>js/select2.min.js"></script>
	
	<!-- Start Validation JS---->
	<!--<script src="<?php echo base_url();?>assets/validation/js/jquery-1.8.2.min.js"></script>-->
	<script src="<?php echo base_url();?>js/my_js/validation/languages/jquery.validationEngine-en.js"></script>
	<script src="<?php echo base_url();?>js/my_js/validation/jquery.validationEngine.js"></script>
	
	<script src="<?php echo base_url();?>js/my_js/master.js"></script>
	<!-- End Validation JS---->	
		
	<script>
		jQuery(document).ready(function()
		{
			jQuery('#basicTable1').DataTable(
			{
				responsive: true,
				"autoWidth": false
			});
		});
	</script>
	
	<script>
	//$.noConflict();
	$(document).ready(function()
	{
		$("#add_comment_form").validationEngine({promptPosition: "topRight: -100"});
	}); 
</script>