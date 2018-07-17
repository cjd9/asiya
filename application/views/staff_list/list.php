<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-user-md"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Staff List</li>
                                </ul>
                                <h4>Staff List</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete Staff details</h4>
								</div>
								<div class="modal-body">
									You want to delete this record ?
									<input type="hidden" name="delete_pk" id="delete_pk" value="" />
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_2()">Yes</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->
                    
                   <div class="contentpanel">
                      	 <a href="<?php print base_url(); ?>staff_list/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Staff Registration</button>
						 </a>
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Staff List</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
							<div class="form-group table-responsive">
                            <table id="basicTable" class="table table-striped table-bordered" >
                                <thead class="">
                                    <tr>
                                        <th></th>
										<th><div align="center">Staff Photo</div></th>
										<th>Staff ID</th>
                                        <th>Staff Name</th>
                                        <th>Staff Gender</th>
										<th>Contact No.</th>
										<th>Work Shift</th>
										<th><div align="center">Status</div></th>
										<th><div align="center">Action</div></th>
                                    </tr>
                                </thead>
                         
                                <tbody>
								<?php $cnt = 0; foreach($rsstaff_list->result() as $row) : ?>
								   <tr>
										<td align="center"><?php echo ++$cnt; ?></td>
										<td>
											<div align="center">
											  <?php if($row->staff_photo) { ?>
											  <img src="<?php print base_url().'../staff_upload_data/staff_photo/'.$row->staff_photo; ?>" height="40" width="60" alt="Staff Photo" />
											  <?php } else { ?>
											  <img src="<?php print base_url(); ?>images/men.png" height="40" width="80" alt="Staff Photo" />
											  <?php } ?>										
											</div>
										</td>
										<td><?php echo $row->staff_id; ?></td>
                                        <td><?php echo $row->s_fname.' '.$row->s_mname.' '.$row->s_lname; ?></td>
                                        <td><?php echo $row->s_gender; ?></td>
										<td><?php echo $row->s_contact_no; ?></td>
										
										<td class="text-center"><?php if($row->s_work_shift == 'M') { echo '<span class="label label-info work_shift" id="'.$row->pk.'">Morning</span>'; } else { echo '<span class="label label-warning work_shift" id="'.$row->pk.'">Evening</span>'; } ?></td>
										
										<td class="text-center"><?php if($row->user_status == 'A') { echo '<span class="label label-success status" id="'.$row->pk.'">Active</span>'; } else { echo '<span class="label label-danger status" id="'.$row->pk.'">Inactive</span>'; } ?></td>
										
                                        <td>
										   <div align="center">
										   	<a href="<?php print base_url(); ?>staff_list/view/<?php echo $row->pk; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-search"></i> View										    
											</a>
										    
											 <a href="<?php print base_url(); ?>staff_list/print_staff_details/<?php echo $row->pk; ?>" class="btn btn-primary btn-sm">
										        <i class="fa fa-print"></i> Print									         
											</a>
											
										   	<a href="<?php print base_url(); ?>staff_list/edit/<?php echo $row->pk; ?>" class="btn btn-info btn-sm">
											 <i class="fa fa-edit"></i> Edit										   
											</a>
										 
										   	<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal_delete" onclick="delete_1(<?php echo $row->pk; ?>)">
												<i class="fa fa-trash-o"></i> Delete										   
											</button>
							         		</div>									 
										</td>
                                  </tr>
									<?php endforeach ; ?>
								</tbody>
                            </table>
							</div>
							
							<!-- Start POPUP Exection -->
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
            					<div class="modal-dialog modal-lg">
									<div class="modal-content">
									 
									</div>
								</div>    
							</div>
							<!-- End POPUP Exection -->
							
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
			
				var user_status = status_field.text();
				var id = status_field.attr("id");
				
				//alert(user_status);
				//alert(id);
				
				var result = confirm('You want to Update Status of this Staff?');
				
				if(result)
				{
					$.ajax({
							url: "<?php print base_url(); ?>staff_list/update_status",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ id:id, user_status:user_status },
							success: function (res) 
							{
								//alert(res);
								
								// check if user status is successfully updated -
								if(res != 0)
								{
									// change the label of status updated -
									if(user_status == 'Active')
									{
										status_field.text('Inactive').removeClass('label-success').addClass('label-danger');
									}
									else
									{
										status_field.text('Active').removeClass('label-danger').addClass('label-success');
									}
								}
							}
					});
				}
			
			});
			
			// function to update the user work shift -
			$("span.work_shift").click( function () {
			
				var work_shift_field = $(this);
			
				var work_shift = work_shift_field.text();
				var id = work_shift_field.attr("id");
				
				//alert(work_shift);
				//alert(id);
				
				var result = confirm('You want to Update Work Shift of this Staff?');
				
				if(result)
				{
					$.ajax({
							url: "<?php print base_url(); ?>staff_list/update_work_shift",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ id:id, work_shift:work_shift },
							success: function (res) 
							{
								//alert(res);
								
								// check if user work shift is successfully updated -
								if(res != 0)
								{
									// change the label of status updated -
									if(work_shift == 'Morning')
									{
										work_shift_field.text('Evening').removeClass('label-info').addClass('label-warning');
									}
									else
									{
										work_shift_field.text('Morning').removeClass('label-warning').addClass('label-info');
									}
								}
							}
					});
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