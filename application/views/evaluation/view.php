	<div class="modal-header">
	  <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
	</div>
	
	<div class="modal-body">
	 
		<div class="contentpanel">
				
			<div class="row">
				<div class="col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<!-- panel-btns -->
							<h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <b>View Patient Evaluation Details</b></h3>
						</div><!-- panel-heading -->
					</div><!-- panel -->
						<!--<div class="panel-body">
							<div class="row">-->
							
							<?php  
								$r = $rsevaluation->row();
							 ?>
								<form method="post" action=" " id="valWizard" class="panel-wizard" enctype="multipart/form-data">
                                    <ul class="nav nav-justified nav-wizard nav-disabled-click">
                                        <li><a href="#tab1-4" data-toggle="tab"> Patient Basic Information</a></li>
										<li><a href="#tab2-4" data-toggle="tab"> Scan Report & Movements </a></li>
                                        <li><a href="#tab3-4" data-toggle="tab"> Blood Investigation </a></li>
                                        <li><a href="#tab4-4" data-toggle="tab"> Examination</a></li>
                                    </ul>
                
                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab1-4"><!-- Start tab-pane -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Patient Name</label>
													<div class="col-sm-8">
													: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
                                           	<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Present Complaints</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_present_complaint; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Past History</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_past_history; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Aggrevating Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_aggrevating_factor; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Relieving Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_relieving_factor; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-1">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_other_chkbox == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault"></label>
														</div>
													</div>
													<?php if($r->p_other_chkbox == 1) {  ?>
													<div class="col-sm-7">
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
													<div class="col-sm-5">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_hyper_tension == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly="">
															<label for="checkboxDefault1">Hyper Tension</label>
														</div>
													</div>
													<div class="col-sm-4">
														<div class="ckbox-default ckbox">
														  <input type="checkbox" <?php if($r->p_diabetes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly="">
														  <label for="checkboxDefault2">Diabetes</label>
														</div>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-2"></label>
													<label class="col-sm-2"><b>Height</b></label>
														<div class="col-sm-3">
															<b> : <?php echo $r->p_height; ?></b> Ft-In
														</div>
													<label class="col-sm-2"><b>Weight </b></label>
														<div class="col-sm-3">
															<b> : <?php echo $r->p_weight; ?></b> KG
														</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Allergies</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_allergies; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Recent Surgeries Done</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_recent_surgery_done; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Current Medications</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_current_medication; ?></textarea>
													</div>
                                            	</div>
												
												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
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
													<label class="col-sm-5">Daily Water Intake</label>
													<div class="col-sm-2">
														: <?php echo $r->p_daily_water_intake; ?>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-2">Diet</label>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_veg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault3">VEG</label>
														</div>
													</div>
													
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_nonveg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault4">Non-VEG</label>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input type="checkbox" <?php if($r->p_diet_mix == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
															<label for="checkboxDefault5">Mix</label>
														</div>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Other</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_other_general; ?></textarea>
													</div>
                                            	</div>
												<div class="col-sm-6">
													
												</div>
                                            </div><!-- End form-group -->
											
                                        </div><!-- End tab-pane -->
                                        
                                        <div class="tab-pane" id="tab2-4">
                                            
											<h4><b><u>Addictions :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_cigarettes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault6">Cigarettes</label>
													</div>
												</div>
                                            	
                                            	<?php if($r->p_cigarettes == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-7">Daily Intake Count</label>
													<div class="col-sm-3">
														: <?php echo $r->cigarettes_daily_intake; ?>
													</div>
                                            	</div>
												
												<div class="col-sm-4">
													<label class="col-sm-9">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														: <?php echo $r->cigarettes_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_alcohol == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault7">Alcohol</label>
													</div>
                                            	</div>
                                            	
												<?php if($r->p_alcohol == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-7">Daily Intake Count</label>
													<div class="col-sm-3">
														: <?php echo $r->alcohol_daily_intake; ?>
													</div>
                                            	</div>
												<div class="col-sm-4">
													<label class="col-sm-9">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														: <?php echo $r->alcohol_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input value="1" type="checkbox" <?php if($r->p_tobaco == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault8">Tobaco</label>
													</div>
                                            	</div>
                                            	
												<?php if($r->p_tobaco == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-7">Daily Intake Count</label>
													<div class="col-sm-3">
														: <?php echo $r->tobaco_daily_intake; ?>
													</div>
                                            	</div>
												<div class="col-sm-4">
													<label class="col-sm-9">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														: <?php echo $r->tobaco_addiction_since; ?>
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<label class="col-sm-2"></label>
												<div class="col-sm-2">
													<div class="ckbox ckbox-default">
														<input type="checkbox" <?php if($r->p_none == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?> readonly="">
														<label for="checkboxDefault9">None</label>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>X-ray Scan Report :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8" id="x-ray">
													<label class="col-sm-3">Upload Report</label>
													
														<?php
															// get all xray report files for this patient evaluation -
															$rsxray_report = $this->db->get_where('patient_xray_report', array('evaluation_id' => $r->pk, 'is_deleted' => 0));
															
															if($rsxray_report->num_rows() > 0)
															{
														?>
														
														 <div class="responsive col-sm-8">
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
													<label class="col-sm-4">D3/B12</label>
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
													<label class="col-sm-4">Uploaded Report</label>
													<div class="col-sm-8">
														: <a href="<?php echo base_url().'./patient_report/blood_investigation_report/'.$r->blood_investigation_report; ?>" target="_blank">
															<?php echo $r->blood_investigation_report; ?>
														  </a>
													</div>
												</div>
                                           
												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->blood_investigation_other; ?></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>Observation :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-12">
													<label class="col-sm-2"></label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->blood_observation; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<hr />
											<h4><b><u>Movements :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Special Test</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_special_test; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Range</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_range; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Quality</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_quality; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Combined Movements</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_combined_movement; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_movement_notes; ?></textarea>
													</div>
                                            	</div>
											</div>
                                           
                                        </div><!--End tab-pane -->
										
                                        <div class="tab-pane" id="tab4-4">
											
											<h4><b><u>Muscle :</u></b></h4>
											
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Strength</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_strength; ?></textarea>
													</div>
                                            	</div>
                                            
												<div class="col-sm-6">
													<label class="col-sm-4">Flexibility</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" readonly=""><?php echo $r->p_flexibility; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->
											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
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
                                        <li class="pull-right finish hide">
											<button type="button" class="btn btn-primary" data-dismiss="modal">Finish <span class="glyphicon glyphicon-ok"></span></button>
										</li>
                                   </ul>
                                    
                                </form><!-- panel-wizard -->
								
							<!--</div>--><!-- row -->
						<!--</div>--><!-- panel-body -->
						
						
					<!--</div>--><!-- panel -->
					
				</div><!-- col-md-6 -->
	
			</div><!--row -->
			   
	  </div><!-- contentpanel --> 
	 
	</div>
	
	<script src="<?php print base_url(); ?>js/bootstrap-wizard.min.js"></script>
	<script src="<?php print base_url(); ?>js/jquery.validate.min.js"></script>
	
	<script>
	jQuery(document).ready(function() {
		
		
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
	