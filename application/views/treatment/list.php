<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Treatment Details</li>
                                </ul>
                                <h4>Treatment</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete Treatment details</h4>
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
                      	 <a href="<?php print base_url(); ?>index.php/treatment/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Add Treatment</button>
						 </a>
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Treatment</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
							<div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th><div align="center">#</div></th>
											<th><div align="center">Patient ID</div></th>
											<th><div align="center">Patient Name</div></th>
											<th><div align="center">Patient Gender</div></th>
											<th><div align="center">Patient Contact No.</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
										<?php $cnt = 0; foreach($rspatient->result() as $row) : ?>
										<tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->patient_id; ?></td>
											<td><?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo $row1->p_fname.' '.$row1->p_lname; ?></td>
											<td><?php echo $row1->p_gender; ?></td>
											<td><?php echo $row1->p_contact_no; ?></td>
											<td align="center">
												<form name="get_treatments_form" id="" action="<?php print base_url(); ?>index.php/treatment" method="post">
													<input type="hidden" name="patient_id" id="" value="<?php echo $row->patient_id; ?>" />
													<button class="btn btn-success btn-sm mr5"><i class="fa fa-search"></i> View Treatments </button>
												</form>
											</td>
										</tr>
										<?php endforeach ; ?>
									</tbody>
								</table>
							</div>
							
							<?php if(isset($patient_id)) { ?>
							
							<hr />
							
							<h4 class="text-center"><b><?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row(); echo $row1->p_fname.' '.$row1->p_lname; ?></b>'s Treatment Details</h4>
							
							<hr />
							
							<div class="table-responsive">
								
								<div class="pull-right">
									<a href="javascript:void(0)" class="btn btn-primary btn-sm mr5" id="print_receipt"> <i class="fa fa-print"></i> Print Receipt </a>
								</div>
							
								<table id="basicTable1" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th class="text-center"><input type="checkbox" name="select_all" id="select_all" class="topic" value="1" onclick="sub_c(this.checked);" /></th>
											<th><div align="center">#</div></th>
											<th><div align="center">Treatment ID</div></th>
											<th><div align="center">Treatment Date</div></th>
											<th><div align="center">Fees</div></th>
											<th><div align="center">Attend By</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
										<?php $cnt = 0; foreach($rstreatment->result() as $row) : ?>
									   <tr>
											<td class="text-center"><input type="checkbox" name="treatment_id[]" id="" value="<?php echo $row->pk; ?>" class="treatment_id" /></td>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->treatment_id; ?></td>
											<td><?php echo date("d-m-Y",strtotime($row->date_of_treatment)); ?></td>
											<td>Rs. <?php echo $row->treatment_fees; ?></td>
											<td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->added_by_user))->row(); echo $r->s_fname.' '.$r->s_lname; ?></td>
											<td>
											   <div align="center">
												  <a href="<?php print base_url(); ?>treatment/view_treatment/<?php echo $row->pk; ?>" class="btn btn-info btn-sm"><i class="fa fa-search"></i> View </a>

													<a href="<?php print base_url(); ?>treatment/print_treatment/<?php echo $row->patient_id; ?>/<?php echo $row->treatment_id; ?>" class="btn btn-primary btn-sm">
														<i class="fa fa-print"></i> Print									         
												   </a> 
												   <a href="<?php print base_url(); ?>treatment/edit/<?php echo $row->pk; ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> Edit </a>
													 
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
							<?php } ?>
						
							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
            					<div class="modal-dialog modal-lg">
									<div class="modal-content">
									 
									</div>
								</div>    
							</div>
							
							<!-- Hidden Form to post selected treatment id list to print receipt -->
							<form name="print_receipt_form" id="print_receipt_form" action="<?php print base_url(); ?>index.php/treatment/print_receipt" method="post">
								<input type="hidden" name="id_list[]" id="id_list" />
							</form>
							<!-- Hidden Form to post selected treatment id list to print receipt -->
							
                        </div><!-- panel -->
      
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>
	
	 <script>
	 	$(document).ready(function()
		{	

				    $('html, body').animate({
				        scrollTop: $(document).height()
				    }, 1100);
				   
				
			// print biiling receipt for selected treatment sessions -
			$('#print_receipt').on('click', function(e) {
			
				var id_list = [];
				 
				$('input[name="treatment_id[]"]:checked').each(function(){
					id_list.push($(this).val());
				});

				// check if record selected -
				if(id_list.length === 0)
				{
					alert ("Please Select Treatment to Print Receipt.");
					e.preventDefault();
				}
				else
				{
					var res = confirm("You want Print Receipt?");
		
					if(res)
					{
						$("#id_list").val(id_list);		// append array to hidden form field
						
						$("#print_receipt_form").submit();	// submit the hidden form
					}
					else
					{
						return false;
					}
				}
				
			});	
		
		}); 
	 
	 	//select all checkboxes
		function sub_c(str) 
		{
			tableblock = document.getElementById('basicTable1');
			forminputs = tableblock.getElementsByTagName('input');
			
			for (i = 0; i < forminputs.length; i++) 
			{
				if(str == true)
				{
					forminputs[i].checked = true;
				}
				else
				{
					forminputs[i].checked = false;
				}
			}
		}
	 
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