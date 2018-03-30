<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>
                
              <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-comments"></i>
                            </div>
                            <div class="media-body">
                                <!--<ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Clinical Meetings</li>
                                </ul>-->
                                <h4>Patient Enquiry</h4>
                            </div>
                        </div><!-- media -->
                   	</div><!-- pageheader -->
                    
                   	<div class="contentpanel">
                      	
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>View Enquiry</b></h4>
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
											<th>Shift</th>
											<th>Enquiry By</th>
											<th><div align="center">Status</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
									<?php $cnt = 0; foreach($rspatient_enquiry->result() as $row) : ?>
									   <tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->p_fname.' '.$row->p_lname; ?></td>
											<td><?php echo $row->p_contact_no; ?></td>
											<td><?php echo $row->problem; ?></td>
											<td><?php echo date("d-m-Y", strtotime($row->appointment_date)); ?></td>
											<!--<td><?php //echo $this->db->get_where('time_slot_master', array('pk' => $row->appointment_time))->row()->time_slot; ?></td>-->
											<td><?php echo $row->appointment_time; ?></td>
											<td><?php if($row->shift == 'M') { echo 'Morning'; } else { echo 'Evening'; } ?></td>
											<td><?php $r = $this->db->get_where('contact_list', array('pk' => $row->added_by_user))->row(); echo $r->p_fname.' '.$r->p_lname; ?></td>
											<td>
											<div align="center">
												<div class="input-group">
												<form id="update_appt_status_form" name="update_appt_status_form" action="<?php echo base_url(); ?>index.php/patient_enquiry/update_appt_status" method="post">
													<input type="hidden" name="pk" id="pk" value="<?php echo $row->pk; ?>" />	
													<select id="status" name="status" data-placeholder="Choose Shift " class="select2-container width100p" onchange="this.form.submit()">
														<?php if($row->status == 'PE') { ?><option value="PE" selected="selected">Pending</option><?php } ?>
														<?php if($row->status != 'CA') { ?><option value="CO" <?php if($row->status == 'CO') { ?> selected="selected"<?php } ?>>Confirm</option><?php } ?>
														<option value="CA" <?php if($row->status == 'CA') { ?> selected="selected"<?php } ?>>Cancel</option>
													</select>
												</form>
												</div>
											</div>
											</td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>index.php/patient_enquiry/view/<?php echo $row->pk; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="fa fa-search"></i> View </a>
												</div>
											</td>
									  </tr>
									<?php endforeach ; ?>
									</tbody>
								</table>
							</div>
							
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
            					<div class="modal-dialog modal-lg">
									<div class="modal-content">
									 
									</div>
								</div>    
							</div>
							
                        </div><!-- panel -->
      
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>
	
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
	</script>
	
    </body>
</html>