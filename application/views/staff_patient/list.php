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
                                    <li>Staff - Patient Master</li>
                                </ul>
                                <h4>Staff - Patient Master</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
                   <div class="contentpanel">
				   
				   		<!--<a href="http://localhost/doctor_portal/admin/index.php/contact_list/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Patient Registration</button>
						 </a>-->
						 
					   <br /><br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Staff - Patient Master</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
							<div class="table-responsive">
							
                            <table id="basicTable" class="table table-striped table-bordered">
                                <thead class="">
                                    <tr>
                                        <th class="text-center">#</th>
										<th>Staff ID</th>
                                        <th>Staff Name</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                         
                                <tbody>
								<?php $cnt = 0; foreach($rscontact_allocation->result() as $row) : ?>
								   <tr>
										<td class="text-center"><?php echo ++$cnt; ?></td>
                                        <td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->current_assign_staff_id))->row(); echo $r->staff_id; ?></td>
                                        <td><?php echo $r->s_fname.' '.$r->s_lname; ?></td>
                                        <td>
											<form name="get_patients_form" class="get_patients_form" id="" action="<?php print base_url(); ?>index.php/staff_patient" method="post">
												<input type="hidden" name="staff_id" id="" class="staff_id" value="<?php echo $row->current_assign_staff_id; ?>" />
												<button class="btn btn-success btn-sm mr5"><i class="fa fa-search"></i> View Patient List </button>
											</form>
										</td>
                                    </tr>
								<?php endforeach ; ?>
                            </table>
							
							</div>
							
							<?php if(isset($staff_id)) { ?>
							
							<hr />
							
							<h4 class="text-center"><b><?php $row1 = $this->db->get_where('staff_details', array('pk' => $staff_id))->row(); echo $row1->s_fname.' '.$row1->s_lname; ?></b>'s Patient List</h4>
							
							<hr />
							
							<div class="table-responsive">
							
								<table id="basicTable1" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th><div align="center">#</div></th>
											<th><div align="center">Patient ID</div></th>
											<th><div align="center">Patient Name</div></th>
											<th><div align="center">Patient Contact No.</div></th>
											<th><div align="center">Status</div></th>
											<th><div align="center">Sharing History</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
										<?php $cnt = 0; foreach($rspatient->result() as $row) : ?>
										<tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											 <td><?php echo $row->patient_id; ?></td>
											<td><?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo $row1->p_fname.' '.$row1->p_lname; ?></td>
											<td><?php echo $row1->p_contact_no; ?></td>
											<td class="text-center"><?php if($row1->p_status == 'A') { echo '<span class="label label-success status" id="'.$row->pk.'">Active</span>'; } else { echo '<span class="label label-danger status" id="'.$row->pk.'">Inactive</span>'; } ?></td>
											<td align="center">
												<a href="<?php print base_url(); ?>index.php/staff_patient/view/<?php echo $row->pk; ?>" class="btn btn-primary btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg"> <i class="fa fa-search"></i> Sharing History </a>
											</td>
											<td align="">
												<div class="form-group col-sm-3 btn_share1">
													<button class="btn btn-success btn-sm mr5"> <i class="fa fa-share"></i> Share Patient </button>
												</div>
												
												<div class="form-group col-sm-6 staff_field" style="display:none">
													<select id="" name="assign_staff_id" data-placeholder="Choose Staff" class="select2-container width100p assign_staff_id">
														<option value=""></option>
														<?php
															foreach ($rsstaff_list->result() as $r) 
															{
																echo "<option value='".$r->pk."'>".$r->s_fname.' '.$r->s_mname.' '.$r->s_lname."</option>";
															}		
														?>
													</select>
												</div>
												
												<div class="form-group col-sm-2 btn_share2" style="display:none">
													<button class="btn btn-primary btn-sm mr5"> <i class="fa fa-check"></i> Share </button>
												</div>
												
												<div class="form-group col-sm-2 btn_share3" style="display:none">
													<button class="btn btn-dark btn-sm mr5"> <i class="fa fa-times"></i> Cancel </button>
												</div>
												
												<input type="hidden" name="patient_id" id="" class="patient_id" value="<?php echo $row->patient_id; ?>" />
												
											</td>
										</tr>
										<?php endforeach ; ?>
									</tbody>
								</table>
							</div>
							
							<!-- Hidden Form to reload the page after sharing patient with staff -->
							<form name="get_patients_reload" class="" id="get_patients_reload" action="<?php print base_url(); ?>index.php/staff_patient" method="post">
								<input type="hidden" name="staff_id" id="" class="staff_id" value="<?php echo $staff_id; ?>" />
							</form>
							<!-- Hidden Form to post selected treatment id list to print receipt -->
							
							<?php } ?>
							
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
	 	$(document).ready(function()
		{
			// show staff field to share -
			$('.btn_share1').on('click', function() {
			
				$(this).hide();
				
				$(this).next(".staff_field").show();
				$(this).next(".staff_field").next(".btn_share2").show();
				$(this).next(".staff_field").next().next(".btn_share3").show();
			});	
			
			// share selected patient with selected staff -
			$('.btn_share2').on('click', function() {
			
				var assign_staff_id = $(this).parent("td").find("select.assign_staff_id").val();
				
				if(assign_staff_id == '' || assign_staff_id == null)
				{
					alert("Please Select Staff to Share Patient.");
					return false;
				}
				else
				{
					var ans = confirm("You Want to Share this Patient?");
					
					if(ans)
					{
						var patient_id =  $(this).parent("td").find(".patient_id").val();
						
						//alert(assign_staff_id);
						//alert(patient_id);
					
						// get patient's contact no. using ajax -
						$.ajax({
								url: "<?php echo base_url(); ?> staff_patient/share_patient",
								type: "post",
								async:false,
								cache:false,
								//dataType:'json',
								data:{ assign_staff_id:assign_staff_id, patient_id:patient_id },
								success: function (res) 
								{
									// check if patient successfully shared -
									if(res != 0)
									{
										alert("Patient Shared Successfully.");
									
										// submit hidden form to load same page with staff patient list -
										$("#get_patients_reload").submit();
									}
								}
						});
					}
					else
					{
						return false;
					}
				}

			});	
			
			// hide sharing field -
			$('.btn_share3').on('click', function() {
			
				$(this).parent("td").find(".staff_field").hide();
				$(this).parent("td").find(".btn_share2").hide();
				$(this).parent("td").find(".btn_share3").hide();
				
				$(this).parent("td").find(".btn_share1").show();
			});
			
			// function to update the patient status -
			$("span.status").click( function () {
			
				var status_field = $(this);
			
				var patient_status = status_field.text();
				var id = status_field.attr("id");
				
				//alert(patient_status);
				//alert(id);
				
				var result = confirm('You want to Update Status of this Patient?');
				
				if(result)
				{
					$.ajax({
							url: "<?php print base_url(); ?>index.php/contact_list/update_status",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ id:id, patient_status:patient_status },
							success: function (res) 
							{
								//alert(res);
								
								// check if user status is successfully updated -
								if(res != 0)
								{
									// change the label of status updated -
									if(patient_status == 'Active')
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
		
		});
	</script>
	
    </body>
</html>