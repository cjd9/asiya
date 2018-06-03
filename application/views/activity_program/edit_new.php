<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							
							<div class="media-body">
								<a href="<?php echo base_url().'activity_program'; ?>" type="button" class="btn btn-default btn-sm">
								          <span class="glyphicon glyphicon-arrow-left "></span> Back
								 </a>
								
								<h4 class="text-center" style="margin-top: -30px;">View Activity Program </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<?php  
							$r = $rsactivity_program->row();
						 ?>
						
						<div class="row">
							<div class="col-md-12">
								<form id="View_activity_program_form" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input disabled  type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
								
								<div class="panel panel-default">
										<div class ="panel-heading">

										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>View Activity Program </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											<input disabled type="hidden" id="activity_id" name="activity_id" class="form-control validate[required]" value="<?php echo $r->activity_id; ?>" />
											
											<div class="form-group">
												<label class="col-sm-2 control-label">Date of Upload</label>
												<div class="col-sm-3">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input disabled disabled type="text" class="form-control datepicker" name="date_of_upload" value="<?php echo date("d-m-Y",strtotime($r->date_of_upload)); ?>">
													</div><!-- input-group -->
												</div>
												
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label">Description </label>
												<div class="col-sm-10">
													<textarea rows="10" disabled name="activity_program" id="activity_program" class="form-control validate[required]"><?php echo $r->activity_program; ?></textarea> </textarea> 
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">File Expiry Date </label>
													<div class="col-sm-3">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input disabled type="text" class="form-control datepicker" name="expiry_date" id="expiry_date" value="<?php echo date("d-m-Y",strtotime($r->expiry_date)); ?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8">
													<label class="col-sm-3">Uploaded Files</label>
													<div class="col-sm-8 table-responsive">
														<table class="table table-striped table-bordered">
															<tr style="text-align:center">
																<th>File Name</th>
																<th>Action</th>
															</tr>
															<?php foreach($rsactivity_program->result() as $r2) { ?>
															<tr>
																<td>
																	<a href="<?php echo base_url().'activity_program_file/'.$r2->activity_program_file; ?>" target="_blank">
																		<?php echo $r2->activity_program_file; ?>
																	</a>
																</td>
																<td>
																	
																</td>
															</tr>
															<?php } ?>
														</table>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										
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
		$(document).ready(function()
		{
			$("#edit_activity_program_form").validationEngine({promptPosition: "topRight: -100"});
		}); 
	</script>
	
	<script>
	
	$(document).ready(function() 
	{
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $("#file_upload"); //Fields wrapper
		var add_button      = $("#add_more"); //Add button ID
	   
		var x = 1; //initlal text box count
		
		$(add_button).click(function(e)
		{ 			
			//on add input button click
			e.preventDefault();
			
			if(x < max_fields)
			{ 
				//max input box allowed
				x++; //text box increment
				
				$(wrapper).append('<span style="display:inline;"><input type="file" name="activity_program_file[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span><br>'); //add input box
			}
		});
	   
		$("span.remove_field").live("click", function(e)
		{ 
			// user click on remove text
			e.preventDefault(); 
			
			$(this).parent('span').remove();
			x--;
		});
		
	});
	
	//************************************************************************************************
	
	// function to delete xray report file using ajax -
	$('.btn-delete').on('click', function() 
	{
		var res = confirm('You Want To Delete This File?');
		
		if(res)
		{
			var row = $(this);
			
			// get id of that record -
			var id = row.attr('data-value');
			
			$.ajax({
					url: "<?php print base_url(); ?>activity_program/delete_activity_program_file",
					type: "post",
					async:false,
					cache:false,
					//dataType:'json',
					data:{ id:id },
					success: function (res) 
					{
						//alert(res);
						
						if(res != 0)
						{
							alert('File Deleted Successfully.');
						
							// remove deleted row -
							row.closest('tr').remove();
						}
					}
			});
		}
		else
		{
			return false;
		}
		
	});
	</script>	
	
    </body>
</html>