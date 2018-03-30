<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
<style type="text/css">
<!--
.style1 {
	color: #FF0000;
	font-style: italic;
}
-->
</style>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-edit"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Activity Program</a></li>
									
								</ul>
								<h4>Edit Activity Program </h4>
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
								<form id="edit_activity_program_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
								<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit Activity Program </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
											<input type="hidden" id="activity_id" name="activity_id" class="form-control validate[required]" value="<?php echo $r->activity_id; ?>" />
											
											<div class="form-group">
												<label class="col-sm-2 control-label">Date of Upload</label>
												<div class="col-sm-3">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
														<input type="text" class="form-control" name="date_of_upload" readonly="" value="<?php echo date("d-m-Y",strtotime($r->date_of_upload)); ?>">
													</div><!-- input-group -->
												</div>
												
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label">Description </label>
												<div class="col-sm-10">
													<textarea rows="10" name="activity_program" id="activity_program" class="form-control validate[required]"><?php echo $r->activity_program; ?></textarea> </textarea> 
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label">File Expiry Date </label>
													<div class="col-sm-3">
														<div class="input-group">
															<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
															<input type="text" class="form-control validate[required] datepicker" name="expiry_date" id="expiry_date" value="<?php echo date("d-m-Y",strtotime($r->expiry_date)); ?>">
														</div><!-- input-group -->
													</div>
												</div>
											</div><!-- form-group -->
											
											<!--<div class="form-group">
												<div class="col-sm-12">
												<label class="col-md-2 control-label"></label>
													<div class="col-sm-8">
														<h5 class="style1">(<b>Note</b> : At a Time Only Uploaded <b>5</b> Video Files OR At a Time Upload <b>10</b> Image Files)</h5>
													</div>
												</div>
											</div>--><!-- form-group -->
											
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
																	<a href="javascript:void(0)" data-value="<?php echo $r2->pk; ?>" class="btn-delete">Delete</a>
																</td>
															</tr>
															<?php } ?>
														</table>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8">
													<label class="col-sm-3">File</label>
													<div class="col-sm-8" id="file_upload">
														<input type="file" id="activity_program_file" name="activity_program_file[]" class=""/>
													</div>
                                            	</div>
                                            
												<div class="col-sm-2">
													<button type="button" class="btn btn-primary btn-sm" id="add_more"> 
														 <span class="glyphicon glyphicon-plus"> <b>Upload More</b></span>
													</button>
												</div>
                                            </div><!-- End form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<a href="<?php print base_url(); ?>index.php/activity_program" class="btn btn-dark">Cancel</a>
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
		//$.noConflict();
		$(document).ready(function()
		{
			$("#edit_activity_program_form").validationEngine({promptPosition: "topRight: -100"});
			
			/*$("#p_dob").datepicker({ dateFormat: 'dd-mm-yy' });
			$("#date_of_registration").datepicker({dateFormat:'dd-mm-yy'});*/
			
			// select box validations -
			
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
			
			//alert(id);
			
			$.ajax({
					url: "<?php print base_url(); ?>index.php/activity_program/delete_activity_program_file",
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