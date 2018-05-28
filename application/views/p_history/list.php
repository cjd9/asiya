<?php $this->load->view('p_include/header'); ?>

<?php $this->load->view('p_include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                 <i class="fa fa-history"></i>
                            </div>
                            <div class="media-body">
                               <!-- <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Treatment Details</li>
                                </ul>-->
                                <h4>History</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
                    
                   <div class="contentpanel">
                      	
					   <br /><br />
							
						<?php 
							if($rstreatment->num_rows() > 0)
							{
						?>
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Treatment</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
							
							<div class="table-responsive">
								
								<table id="basicTable1" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<!--<th class="text-center"><input type="checkbox" name="select_all" id="select_all" class="topic" value="1" onclick="sub_c(this.checked);" /></th>-->
											<th class="text-center">#</th>
											<th><div align="center">Treatment ID</div></th>
											<th><div align="center">Treatment Date</div></th>
											<th><div align="center">Fees</div></th>
											<th><div align="center">Attend By</div></th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
							 
									<tbody>
										<?php 
											$cnt = 0; 
											foreach($rstreatment->result() as $row) : 
										?>
									   <tr>
											<!--<td class="text-center"><input type="checkbox" name="treatment_id[]" id="" value="<?php echo $row->pk; ?>" class="treatment_id" /></td>-->
											<td style="text-align:center"><?php echo ++$cnt; ?></td>
											<td><?php echo $row->treatment_id; ?></td>
											<td><?php echo date("d-m-Y",strtotime($row->date_of_treatment)); ?></td>
											<td>Rs. <?php echo $row->treatment_fees; ?></td>
											<td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->added_by_user))->row(); echo $r->s_fname.' '.$r->s_lname; ?></td>
											<td>
											   <div align="center">
												   <!--<a href="<?php //print base_url(); ?>p_history/p_view_treatment/<?php //echo $row->pk; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg">
													<i class="fa fa-search"></i> View										
												   </a>
													<a href="<?php //print base_url(); ?>p_history/p_print_treatment/<?php //echo $row->patient_id; ?>/<?php //echo $row->treatment_id; ?>" class="btn btn-primary btn-sm">
														<i class="fa fa-print"></i> Treatment Details									         
												   </a> -->
												   <a href="<?php print base_url(); ?>p_history/p_billing_details/<?php echo $row->patient_id; ?>/<?php echo $row->treatment_id; ?>" class="btn btn-info btn-sm">
												   		<i class="fa fa-edit"></i> Billing Details 
													</a>
													
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
      					<?php
							}
							else
							{	
						?>
							<div class="horizontally">
								<div class="inner">
									<img src="<?php print base_url(); ?>images/bee.gif" height="200px"/>
									<!--<img src="http://www.html.am/images/html-codes/marquees/bee.gif" alt="Buzzy bee">-->
								</div>
							</div>

							<h1 align="center"><b>No Treatment Record Found.</b></h1>';
						<?php
							}
						?>
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('p_include/footer'); ?>
	
	 <script>
	 	$(document).ready(function()
		{
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
	 
	</script>
	
    </body>
</html>