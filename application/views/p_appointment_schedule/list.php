<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>
                
              <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <div class="media-body">
                                <!--<ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Clinical Meetings</li>
                                </ul>-->
                                <h4>Appointment Schedule</h4>
                            </div>
                        </div><!-- media -->
                   	</div><!-- pageheader -->
                    
                   	<div class="contentpanel">
                      	 <a href="<?php print base_url(); ?>p_appointment_schedule/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Take New Appointment</button>
						 </a>
						 
						 <a href="<?php print base_url(); ?>p_appointment_schedule/view_next_appt">
					  	 	<button class="btn btn-primary"><i class="fa fa-search"></i> Next Appointment Schedule</button>
						 </a>
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>View Appointments</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
                            <div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th><div align="center">#</div></th>
											<th>Patient Name</th>
											<th>Contact No.</th>
											<th>Problem</th>
											<th>Date</th>
											<th>Time</th>
											<th><div align="center">Status</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
									<?php $cnt = 0; foreach($rsappointment->result() as $row) : ?>
									   <tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->p_fname.' '.$row->p_lname; ?></td>
											<td><?php echo $row->p_contact_no; ?></td>
											<td><?php echo $row->problem; ?></td>
											<td><?php echo date("d-m-Y", strtotime($row->appointment_date)); ?></td>
											<!--<td><?php //echo $this->db->get_where('time_slot_master', array('pk' => $row->appointment_time))->row()->time_slot; ?></td>-->
											<td><?php echo $row->time_slot; ?></td>
											<td class="text-center"><?php if($row->status == 'PE') { echo '<span class="label label-warning" id="'.$row->pk.'">Pending</span>'; } else if($row->status == 'CA') { echo '<span class="label label-danger" id="'.$row->pk.'">Cancel</span>'; } else { echo '<span class="label label-success" id="'.$row->pk.'">Confirm</span>'; } ?></td>
											<td>
												<div align="center">
												<?php if($row->status == 'PE') { ?>
													<a href="<?php print base_url(); ?>p_appointment_schedule/cancel_appointment/<?php echo $row->pk; ?>" class="btn btn-warning btn-xs" onclick="return confirmation()">
														 <i class="fa fa-trash-o"></i> Cancel									        

													</a>
												<?php } ?>
												
													

												</div>
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

	<?php $this->load->view('p_include/footer'); ?>
	
	<script>
		// function for cancel confirmation -
		function confirmation()
		{
			var res = confirm("You want to cancel this Appointment?");
			
			if(res)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	
		$(document).ready(function()
		{
			// function to cancel appointment -
			$('.btn-cancel').on('click', function() 
			{
				var res = confirm('You Want To Cancel Appointment?');
				
				if(res)
				{
					var cancel_btn = $(this);
					
					var id = cancel_btn.attr("data-id");
					
					// cancel appointment details using ajax -
					$.ajax({
							url: "<?php print base_url(); ?>p_appointment_schedule/cancel_request",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ id:id },
							success: function (res) 
							{
								//alert(res);
								
								// check if appointment is successfully cancel -
								if(res != 0)
								{
									alert('Appointment Cancelled Successfully.');
								}
							}
					});
				}
				else
				{
					return false;
				}
				
			});

				$("body").on("click", "#reschedule", function ()
					 {	var cancel_btn = $(this);
					
					  var id = cancel_btn.attr("data-id"); 
					 	bootbox.prompt({
						    title: "Select a time Slot!",
						    inputType: 'select',
						    inputOptions: <?php echo $timeslot; ?>,
						    callback: function (result) {
						        console.log(result);
										$.ajax({
													type: "post",
													url: '/patient_enquiry/update_appt_status/nocheck',
													dataType: "json",
													data: {
													 status: "RE",
													 pk: id,
													 timeslot:result
												 },
													success: function(responseData) {
														if(responseData.status == 'success'){
															bootbox.alert({
																		message: "Action was successful",
																		size: 'small'
																});
														}
													}

										 });
						    }
						});

					});
		});
	</script>
	
    </body>
</html>