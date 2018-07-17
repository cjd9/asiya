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
						 
						  <a href="<?php print base_url(); ?>p_appointment_schedule">
					  	 	<button class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back</button>
						 </a>
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>View Next Scheduled Appointments</b></h4>
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
											<th>date_of_appointment</th>
											<th>Time</th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
									<?php $cnt = 0; foreach($rsappointment->result() as $row) : ?>
									   <tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->p_fname.' '.$row->p_lname; ?></td>
											<td><?php echo $row->p_contact_no; ?></td>
											<td><?php echo date("d-m-Y", strtotime($row->date_of_appointment)); ?></td>
											<td><?php echo $this->db->get_where('time_slot_master', array('pk' => $row->time_slot_id))->row()->time_slot; ?></td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>p_appointment_schedule/cancel_appt/<?php echo $row->pk; ?>" class="btn btn-warning btn-xs <?php echo (strtotime($row->date_of_appointment) >  time() + 86400) ? '' : 'hide';
 ?>" onclick="return confirmation()">
														 <i class="fa fa-trash-o"></i> Cancel									        
													</a>
													<button class="btn btn-info btn-xs reschedule" data-id="<?php echo $row->pk; ?>" id="">
														 <i class="fa fa-send-o"></i> Reschedule									        
													</button>
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
		

			$("body").on("click", ".reschedule", function ()
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
													url: '/p_appointment_schedule/update_appt_status/nocheck',
													dataType: "json",
													data: {
													 status: "RE",
													 pk: id,
													 timeslot:result
												 },
													success: function(responseData) {
														bootbox.alert({
																		message: "Action was successful",
																		size: 'small'
																});
														location.reload();

													}

										 });
						    }
						});

					});
		});
	</script>
	
    </body>
</html>