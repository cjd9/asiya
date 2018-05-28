<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-list-alt"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Contact Allocation Details</li>
                                </ul>
                                <h4>Contact Allocation</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete Contact Allocation Details</h4>
								</div>
								<div class="modal-body">
									You want to delete this record ?
									<input type="hidden" name="delete_pk" id="delete_pk" value="" />
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_2()">Yes</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
                    
                   <div class="contentpanel">
                      	
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Contact Allocation</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
							<div class="table-responsive">
							
                            <table id="basicTable" class="table table-striped table-bordered">
                                <thead class="">
                                    <tr>
                                        <th class="text-center">#</th>
										<th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Assign Date</th>
										<th>Activity</th>
										<th><div align="center">Status</div></th>
                                    </tr>
                                </thead>
                         
                                <tbody>
								<?php $cnt = 0; foreach($rscontact_allocation->result() as $row) : ?>
								   <tr>
										<td class="text-center"><?php echo ++$cnt; ?></td>
										<td><?php echo $row->patient_id; ?></td>
                                        <td><?php $r = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo $r->p_fname.' '.$r->p_mname.' '.$r->p_lname; ?></td>
                                        <td><?php echo $this->mastermodel->date_convert($row->assign_date,'dmy'); ?></td>
										<td><?php echo $row->activity_name; ?></td>
                                        <td class="text-center">
											<?php if($row->activity_status == 'C') { echo '<span class="label label-success status" id="'.$row->pk.'">Completed</span>'; } else { echo '<span class="label label-danger status" id="'.$row->pk.'">Pending</span>'; } ?>
										</td>
                                    </tr>
								<?php endforeach ; ?>
								</tbody>
                            </table>
							
							</div>
							
                        </div><!-- panel -->
      
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>
	
	 <script>
	 	$(document).ready(function()
		{
			// function to update the user status -
			$("span.status").click( function () {
			
				var status_field = $(this);
			
				var id = status_field.attr("id");
				
				//alert(id);
				
				var result = confirm('You want to Update Status of this Activity?');
				
				if(result)
				{
					$.ajax({
							url: "<?php echo base_url(); ?>contact_allocation/update_status",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ id:id },
							success: function (res) 
							{
								//alert(res);
								
								// check if user status is successfully updated -
								if(res != 0)
								{
									window.location = "<?php echo base_url(); ?>contact_allocation";
								}
							}
					});
				}
				else
				{
					return false;
				}
			
			});			
			
		});
	 
		// assign delete id to hidden field
		function delete_1(id)
		{
			$('#delete_pk').val(id);
		}
		// delete record
		function delete_2()
		{
			var id = $('#delete_pk').val();
			window.location = "<?php echo $deleteaction; ?>/"+id;
		}
	</script>
	
    </body>
</html>