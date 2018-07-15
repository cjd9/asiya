<?php $this->load->view('p_include/header'); ?>
		
<?php $this->load->view('p_include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-database"></i>
							</div>
							<div class="media-body">
								<!--<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Evaluation</a></li>
									
								</ul>-->
								<h4> Evaluation</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
						<div class="panel-body">
						  <div class="row">
							
							<?php  
								if($rsevaluation->num_rows() > 0)
								{
									$r = $rsevaluation->row();
							 ?>
								<form method="post" action=" " id="valWizard" class="panel-wizard" enctype="multipart/form-data">
                                    <ul class="nav nav-justified nav-wizard nav-disabled-click">
                                        <li><a href="#tab1-4" data-toggle="tab"> <b>Patient Basic Information</b></a></li>
										<li><a href="#tab2-4" data-toggle="tab"> <b>Scan Report & Movements</b> </a></li>
                                        <li><a href="#tab3-4" data-toggle="tab"> <b>Blood Investigation</b> </a></li>
                                        <li><a href="#tab4-4" data-toggle="tab"> <b>Examination</b></a></li>
                                    </ul>
                
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab1-4"><!-- Start tab-pane -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3"><b>Patient Name</b></label>
													<div class="col-sm-8">
													<b>: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?></b>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
                                           	<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Present Complaints</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_present_complaint; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Past History</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_past_history; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Aggrevating Factor</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_aggrevating_factor; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Relieving Factor</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_relieving_factor; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Others</label>
													<div class="col-sm-1">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_other_chkbox == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault"></label>
														</div>
													</div>
													<?php if($r->p_other_chkbox == 1) {  ?>
													<div class="col-sm-8">
														<textarea class="form-control" name="" readonly="readonly"><?php echo $r->p_other_evluation; ?></textarea>
													</div>
													<?php } ?>
												</div>
                                            </div><!-- End form-group -->
											
											<hr />
											
											<h4><b><u>Medical History :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3"></label>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_hyper_tension == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly="">
															<label for="checkboxDefault1"><b>Hyper Tension</b></label>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diabetes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly="">
															<label for="checkboxDefault2"><b>Diabetes</b></label>
														</div>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3"></label>
														<label class="col-sm-1"><b>Height</b></label>
														<div class="col-sm-3">
															<b> : <?php echo $r->p_height; ?></b> Ft-In
														</div>
														<label class="col-sm-1"><b>Weight </b></label>
														<div class="col-sm-3">
															<b> : <?php echo $r->p_weight; ?></b> KG
														</div>
												</div>
                                            </div><!-- End form-group -->
											
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Allergies</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_allergies; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Recent Surgeries Done</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_recent_surgery_done; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Current Medications</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_current_medication; ?></textarea>
													</div>
                                            	</div>
												
												<div class="col-sm-6">
													<label class="col-sm-3">Others</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_other_medical_history; ?></textarea>
													</div>
                                            	</div>
												<div class="col-sm-6">
													
												</div>
                                            </div><!-- End form-group -->
											
											<hr />
											
											<h4><b><u>General Health :</u></b></h4>
																						
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Daily Water Intake</label>
													<div class="col-sm-2">
														: <?php echo $r->p_daily_water_intake; ?>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3"><b>Diet</b></label>
													<div class="col-sm-2">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_veg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault3">VEG</label>
														</div>
													</div>
													
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_nonveg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault4">Non-VEG</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_mix == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault5">Mix</label>
														</div>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Other</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_other_general; ?></textarea>
													</div>
                                            	</div>
												<div class="col-sm-6">
													
												</div>
                                            </div><!-- End form-group -->
											
                                        </div><!-- End tab-pane -->
                                        
										<!-- Start tab-pane -->
                                        <div class="tab-pane" id="tab2-4">
                                            
											<h4><b><u>Addictions :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_cigarettes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault6"><b>Cigarettes</b></label>
													</div>
												</div>
                                            	
                                            	<?php if($r->p_cigarettes == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-5"><b>Daily Intake Count</b></label>
													<div class="col-sm-3">
														<b>: </b><?php echo $r->cigarettes_daily_intake; ?>
													</div>
                                            	</div>
												
												<div class="col-sm-4">
													<label class="col-sm-7"><b>Addiction Since(in Months)</b></label>
													<div class="col-sm-3">
														<b>:</b> <?php echo $r->cigarettes_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_alcohol == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault7"><b>Alcohol</b></label>
													</div>
                                            	</div>
                                            	
												<?php if($r->p_alcohol == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-5"><b>Daily Intake Count</b></label>
													<div class="col-sm-3">
														<b>:</b> <?php echo $r->alcohol_daily_intake; ?>
													</div>
                                            	</div>
												<div class="col-sm-4">
													<label class="col-sm-7"><b>Addiction Since(in Months)</b></label>
													<div class="col-sm-3">
														<b>:</b> <?php echo $r->alcohol_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_tobaco == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault8"><b>Tobaco</b></label>
													</div>
                                            	</div>
                                            	
												<?php if($r->p_tobaco == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-5"><b>Daily Intake Count</b></label>
													<div class="col-sm-3">
														<b>:</b> <?php echo $r->tobaco_daily_intake; ?>
													</div>
                                            	</div>
												<div class="col-sm-4">
													<label class="col-sm-7"><b>Addiction Since(in Months)</b></label>
													<div class="col-sm-3">
														<b>:</b> <?php echo $r->tobaco_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input type="checkbox" <?php if($r->p_none == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault9"><b>None</b></label>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<hr />
											
											<h4><b><u>X-ray Scan Report :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-12" id="x-ray">
													<label class="col-sm-2">Upload Report</label>
													
														<?php
															// get all xray report files for this patient evaluation -
															$rsxray_report = $this->db->get_where('patient_xray_report', array('evaluation_id' => $r->pk, 'is_deleted' => 0));
															
															if($rsxray_report->num_rows() > 0)
															{
														?>
														
														 <div class="responsive col-sm-10">
															<table class="table table-striped table-bordered responsive" border="1" style="border-collapse:collapse">
																<tr style="text-align:center">
																	<th>File Name</th>
																</tr>
																<?php foreach($rsxray_report->result() as $r2) { ?>
																<tr>
																	<th>
																		<a href="<?php echo base_url().'./patient_report/xray_report/'.$r2->p_xray_report; ?>" target="_blank">
																			<?php echo $r2->p_xray_report; ?>
																		</a>
																	</th>
																</tr>
																<?php } ?>
															</table>
														</div>
														
														<?php
															}
														?>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>Vitamin :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">D3/B12</label>
													<div class="col-sm-8">
														: <?php echo $r->p_vitamin; ?>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													
												</div>
                                            </div><!-- End form-group -->
											
                                        </div><!--End tab-pane -->
                                        
										<div class="tab-pane" id="tab3-4"><!--Start tab-pane -->
                                            
											<h4><b><u>Blood Investigation :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Uploaded Report</label>
													<div class="col-sm-9">
														: <a href="<?php echo base_url().'./patient_report/blood_investigation_report/'.$r->blood_investigation_report; ?>" target="_blank">
															<?php echo $r->blood_investigation_report; ?>
														  </a>
													</div>
												</div>
                                           
												<div class="col-sm-6">
													<label class="col-sm-3">Others</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="2" readonly=""><?php echo $r->blood_investigation_other; ?></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>Observation :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-12">
													<label class="col-sm-1"></label>
													<div class="col-sm-11">
														<textarea class="form-control" rows="2" readonly=""><?php echo $r->blood_observation; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>Movements :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-2">Special Test</label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_special_test; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Range</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_range; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-2">Quality</label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_quality; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Combined Movements</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_combined_movement; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-2">Notes</label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_movement_notes; ?></textarea>
													</div>
                                            	</div>
											</div>
                                           
                                        </div><!--End tab-pane -->
										
                                        <div class="tab-pane" id="tab4-4">
											
											<h4><b><u>Muscle :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Strength</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_strength; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-3">Flexibility</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_flexibility; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">Notes</label>
													<div class="col-sm-9">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_muscle_notes; ?></textarea>
													</div>
                                            	</div>
											</div>
											<hr />
										    <h4><b><u>Palpation :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"> Tenderness</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_tenderness; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Swelling</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_swelling; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
										   
										   <div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Limblength Discrepancy</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_limblength; ?></textarea>
													</div>
                                            	</div>
                                            	
												<div class="col-sm-6">
													<label class="col-sm-4">Neural Investigation </label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->nueral_investigation; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_palpation_notes; ?></textarea>
													</div>
												</div>
												
												<div class="col-sm-6">
													<label class="col-sm-4">Provisional Diagnosis</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->provisional_diagnosis; ?></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
										   
										   
                                        </div><!--End tab-pane -->
                                    </div><!-- tab-content -->
                
                                    <ul class="list-unstyled wizard">
                                        <li class="pull-left previous">
											<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Previous</button>
										</li>
                                        <li class="pull-right next">
											<button type="button" class="btn btn-primary">Next <span class="glyphicon glyphicon-arrow-right"></span></button>
										</li>
                                       
                                   </ul>
                                    
                                </form><!-- panel-wizard -->
								
								<?php
								}
								else
								{	
								?>
									<div class="horizontally">
										
									</div>

									<h1 align="center"><b>No Evaluation Record Found.</b></h1>';
								<?php
								}
								?>
								
							 </div><!-- col-md-12 -->
                        </div><!-- row -->
                       
                    </div><!-- contentpanel -->
					
				</div><!-- mainpanel -->
			</div><!-- mainwrapper -->
		</section>  
		
		<script src="<?php print base_url(); ?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery-ui-1.10.3.min.js"></script>
        <script src="<?php print base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php print base_url(); ?>js/modernizr.min.js"></script>
        <script src="<?php print base_url(); ?>js/pace.min.js"></script>
        <script src="<?php print base_url(); ?>js/retina.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.cookies.js"></script>
        
        <script src="<?php print base_url(); ?>js/bootstrap-wizard.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.validate.min.js"></script>
        <script src="<?php print base_url(); ?>js/select2.min.js"></script>

        <script src="<?php print base_url(); ?>js/custom.js"></script>
		
		<script type="text/javascript">

			$(document).ready(function()
			{
				$("#checkboxDefault").click(function()
				{
					if($("#checkboxDefault").is(":checked") || $("#checkboxDefault").is(":checked"))
					{
						$("#p_other_evluation").show();
					} 
					else
					{
						$("#p_other_evluation").hide();
					}
				});
				
				$("#checkboxDefault6").click(function()
				{
					if($("#checkboxDefault6").is(":checked") || $("#checkboxDefault6").is(":checked"))
					{
						$("#cigarettes_daily_intake").show();
						$("#cigarettes_addiction_since").show();
					} 
					else
					{
						$("#cigarettes_daily_intake").hide();
						$("#cigarettes_addiction_since").hide();
					}
				});
				
				$("#checkboxDefault7").click(function()
				{
					if($("#checkboxDefault7").is(":checked") || $("#checkboxDefault7").is(":checked"))
					{
						$("#alcohol_daily_intake").show();
						$("#alcohol_addiction_since").show();
					} 
					else
					{
						$("#alcohol_daily_intake").hide();
						$("#alcohol_addiction_since").hide();
					}
				});
				
				$("#checkboxDefault8").click(function()
				{
					if($("#checkboxDefault8").is(":checked") || $("#checkboxDefault8").is(":checked"))
					{
						$("#tobaco_daily_intake").show();
						$("#tobaco_addiction_since").show();
					} 
					else
					{
						$("#tobaco_daily_intake").hide();
						$("#tobaco_addiction_since").hide();
					}
				});
				
			});
			
		</script>
		
	<script>

	jQuery(document).ready(function() {
		
		// This will empty first option in select to enable placeholder
		jQuery('select option:first-child').text('');
		
		// Select2
		jQuery("select").select2({
			minimumResultsForSearch: -1
		});
		
		
		// Wizard With Form Validation
		jQuery('#valWizard').bootstrapWizard({
			onTabShow: function(tab, navigation, index) {
				tab.prevAll().addClass('done');
				tab.nextAll().removeClass('done');
				tab.removeClass('done');
				
				var $total = navigation.find('li').length;
				var $current = index + 1;
				
				if($current >= $total) {
					$('#valWizard').find('.wizard .next').addClass('hide');
					$('#valWizard').find('.wizard .finish').removeClass('hide');
				} else {
					$('#valWizard').find('.wizard .next').removeClass('hide');
					$('#valWizard').find('.wizard .finish').addClass('hide');
				}
			},
			onTabClick: function(tab, navigation, index) {
				return false;
			},
			onNext: function(tab, navigation, index) {
				var $valid = jQuery('#valWizard').valid();
				if (!$valid) {
					$validator.focusInvalid();
					return false;
				}
			}
		});
		
		// Wizard With Form Validation
		var $validator = jQuery("#valWizard").validate({
			highlight: function(element) {
				jQuery(element).closest('.form-group').removeClass('has-success').addClass('has-error');
			},
			success: function(element) {
				jQuery(element).closest('.form-group').removeClass('has-error');
			}
		});
		
		
		// This will submit the basicWizard form
		//jQuery('.panel-wizard').submit(function() {    
			//alert('This will submit the form wizard');
			//return false // remove this to submit to specified action url
		//s});

	});
</script>
		
	<script>
		//$.noConflict();
		$(document).ready(function()
		{
			//$("#valWizard").validationEngine({promptPosition: "topRight: -100"});
			
			$("#s_dob").datepicker({ dateFormat: 'dd-mm-yy' });
			$("#date_of_joining").datepicker({dateFormat:'dd-mm-yy'});
			
			// select box validations -
			$('#valWizard').on('submit', function() 
			{
				$('#msg1').text('');
				
				if($('#patient_id').val() == '' || $('#patient_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}
				
			});	
		}); 
	</script>