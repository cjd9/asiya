<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
<div class="mainpanel">
		<div class="pageheader">
			<div class="media">
				<div class="pageicon pull-left">
					<i class="fa fa-edit"></i>
				</div>
				<div class="media-body">
					<ul class="breadcrumb">
						<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
						<li><a href="#">Treatment Details</a></li>
						
					</ul>
					<h4>Edit Treatment</h4>
				</div>
			</div><!-- media -->
		</div><!-- pageheader -->
		
		<div class="contentpanel">
		
			<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
			
			<?php  
				$r = $rstreatment->row();
			 ?>
			
			<div class="row">
				<div class="col-md-12">
					<form id="edit_treatment_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
					<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-btns">
								<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
								<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
							</div><!-- panel-btns -->
							<h3 class="panel-title"><i class="glyphicon glyphicon-edit"></i> <b>Edit Treatment</b></h3>
						</div><!-- panel-heading -->
						
						<div class="panel-body">
							<div class="row">
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-md-3 control-label">Treatment ID</label>
										<div class="col-sm-8">
											<input type="text" id="treatment_id" name="treatment_id" class="form-control validate[required]" value="<?php echo $r->treatment_id; ?>" readonly />
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Date Of Treatment</label>
										<div class="col-sm-8">
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input type="text" class="form-control datepicker" name="date_of_treatment" id="date_of_treatment" value="<?php echo date("d-m-Y",strtotime($r->date_of_treatment)); ?>" />
											</div><!-- input-group -->
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Patient Name<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<select id="patient_id" name="patient_id" data-placeholder="Choose Patient " class="select2-container width100p">
												<option value=""></option>
												<?php foreach ($rscontact_list->result() as $r1) 
													{
												?>
												<option value="<?php echo $r1->patient_id; ?>" <?php if($r1->patient_id == $r->patient_id) { ?> selected="selected" <?php } ?>>
													<?php echo $r1->p_fname.' '.$r1->p_mname.' '.$r1->p_lname; ?>
												</option>
												<?php	
													}		
												?>
											</select>
											<span id="msg1" class="" style="color:#FF0000"></span>
										</div>
									</div>
								</div><!-- form-group -->
								
								<hr />
								<h4><u><b>Plan of Care</b></u></h4>
								
								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Short Term Goals<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" name="short_term_goal" id="short_term_goal"><?php echo $r->short_term_goal; ?></textarea>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Long Term Goals<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" name="long_term_goal" id="long_term_goal"><?php echo $r->long_term_goal; ?></textarea>
										</div>
									</div>
								</div><!-- form-group -->
								
								<div class="form-group">
									
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Next Therapy Plan<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" name="next_therapy_plan" id="next_therapy_plan"><?php echo $r->next_therapy_plan; ?></textarea>
										</div>
									</div>
									
									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Fees<span class="asterisk">*</span></label>
										<div class="col-sm-3">
											<input type="text" class="form-control" name="treatment_fees" id="treatment_fees" value="<?php echo $r->treatment_fees; ?>" />
										</div>
									</div>
								</div><!-- form-group -->
								
								<hr />
								<h4><b><u>Treatment Therapy </u></b></h4>
								
								<div class="form-group responsive">
									<div class="col-sm-12 table-responsive">
									<table class="table table-dark mb30 responsive">
										<thead>
											<tr>
												<th><div align="center">Manual Therapy</div></th>
												<th><div align="center">Exercise Therapy</div></th>
												<th><div align="center">Electro Therapy</div></th>
												<th><div align="center">Others</div></th>
												<th><div align="center">Notes</div></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><textarea class="form-control" rows="20" name="maual_therapy" id="maual_therapy"><?php echo $r->maual_therapy; ?></textarea></td>
												<td><textarea class="form-control" rows="20" name="exercise_therapy" id="exercise_therapy"><?php echo $r->exercise_therapy; ?></textarea></td>
												<td><textarea class="form-control" rows="20" name="electro_therapy" id="electro_therapy"><?php echo $r->electro_therapy; ?></textarea></td>
												<td><textarea class="form-control" rows="20" name="other_therapy" id="other_therapy"><?php echo $r->other_therapy; ?></textarea></td>
												<td><textarea class="form-control" rows="20" name="notes_therapy" id="notes_therapy"><?php echo $r->notes_therapy; ?></textarea></td>
											</tr>
										</tbody>
									</table>
									</div>
								</div>	
								
							</div><!-- row -->
						</div><!-- panel-body -->
						
						<div class="panel-footer">
						  <div class="row">
							<div class="col-sm-7 col-sm-offset-4">
								<button class="btn btn-primary mr5">Submit</button>
								<a href="<?php print base_url(); ?>index.php/treatment" class="btn btn-dark">Cancel</a>
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
		$(document).ready(function()
		{
			$("#edit_treatment_form").validationEngine({promptPosition: "topRight: -100"});
			
			// select box validations -
			$('#edit_treatment_form').on('submit', function() {
			
				$('#msg1').text('');
				
				if($('#patient_id').val() == '' || $('#patient_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}
				
			});	
		
		}); 
	</script>
	
    </body>
</html>