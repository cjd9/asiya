<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="glyphicon glyphicon-phone"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">SAMVAAD</a></li>
									
								</ul>
								<h4>Send SMS Notification</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<div class="row">
							<div class="col-md-12">
								<form id="add_contact_allocation_form" action="<?php echo $saveaction; ?>" method="post">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-phone"></i> <b>Send SMS Notification</b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
										
											<?php $r = $rseducation_program->row(); ?>
											
											<input type="hidden" name="education_program_pk" id="" value="<?php echo $r->pk; ?>" />
										
											<div class="form-group">
												<label class="col-sm-2 control-label"></label>
												<label class="col-sm-2 control-label"><strong>Description</strong> </label>
												<div class="col-sm-6">
													<strong>:</strong> <?php echo $r->education_program_desc; ?>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-sm-2 control-label"></label>
												<label class="col-sm-2 control-label"><strong>Attached File </strong></label>
												<div class="col-sm-6">
													<strong>:</strong> <?php echo $r->education_program_file; ?>
												</div>
											</div><!-- form-group -->
											
											<hr />
											
											<div class="table-responsive">
												<label class="col-sm-2 control-label"></label>
												<div class="col-sm-8" align="center">
													<table id="basicTable" class="table table-bordered">
														<thead>
														  <tr>
															<th colspan="6"><div align="center">Patient Contact List</div></th>
														  </tr>
														  <tr>
															<th class="text-center"><input type="checkbox" name="select_all" id="select_all" class="topic" value="1" onclick="sub_c(this.checked);" /></th>
															<th>Patient ID</th>
															<th>Patient Name</th>
															<th>Patient Gender</th>
															<th>Patient Contact No.</th>
														  </tr>
														</thead>
														<tbody>
														   <?php foreach($rscontact_list->result() as $row) : ?>
														   <tr>
																<td class="text-center"><input type="checkbox" name="patient_id[]" id="" value="<?php echo $row->patient_id; ?>" /></td>
																<td><?php echo $row->patient_id; ?></td>
																<td><?php echo $row->p_fname.' '.$row->p_mname.' '.$row->p_lname; ?></td>
																<td><?php echo $row->p_gender; ?></td>
																<td><?php echo $row->p_contact_no; ?></td>
														  	</tr>
														  <?php endforeach ; ?>
														</tbody>
													</table>
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Send</button>
											<a href="<?php print base_url(); ?>index.php/education_program" class="btn btn-dark">Cancel</a>
										</div>
									  </div>
									</div><!-- panel-footer -->  
								</div><!-- panel -->
								</form>
								
							</div><!-- col-md-6 -->
						</div><!--row -->
					</div><!-- contentpanel -->
					
				</div><!-- mainpanel -->
			</div><!-- mainwrapper -->
		</section>  
		
		<?php $this->load->view('include/footer'); ?>
		
	<script>
	//select all checkboxes
	function sub_c(str) 
	{
		formblock = document.getElementById('add_contact_allocation_form');
		forminputs = formblock.getElementsByTagName('input');
		
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
	
	<script>
		$(document).ready(function()
		{
			$("#add_contact_allocation_form").validationEngine({promptPosition: "topRight: -100"});
			
			// select box validations -
			$('#add_contact_allocation_form').on('submit', function() {
			
				var id_list = [];
				 
				$('input[name="patient_id[]"]:checked').each(function(){
					id_list.push($(this).val());
				});
	
				// check if record selected -
				if(id_list.length === 0)
				{
					alert ("Please Select Patient to Send SMS.");
					//e.preventDefault();
					
					return false;
				}
				
			});	
		
		}); 
	</script>
	
    </body>
</html>