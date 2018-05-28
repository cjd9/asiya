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
									<li><a href="#">Evaluation</a></li>

								</ul>
								<h4>View Evaluation</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel contentpanel-wizard">

                        <div class="row">

                            <div class="col-md-12">
                            	<a href="<?php echo base_url().'evaluation'; ?>" type="button" class="btn btn-default btn-sm">
								          <span class="glyphicon glyphicon-arrow-left"></span> Back
						        </a>
                                <h5 class="lg-title text-center"><b>Patient Evaluation</b></h5>
                                <p class="mb20"></p>

								<?php
									$r = $rsevaluation->row();
								 ?>

                                <!-- BASIC WIZARD -->
                                <form method="post"  id="valWizard" class="panel-wizard" enctype="multipart/form-data">
								<input type="hidden" disabled name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

                                    <ul class="nav nav-justified nav-wizard nav-disabled-click">
                                        <li><a href="#tab1-4" data-toggle="tab"><strong>Step 1:</strong> Patient Basic Information</a></li>
										<li><a href="#tab2-4" data-toggle="tab"><strong>Step 2:</strong> Scan Report And Movements </a></li>
                                        <li><a href="#tab3-4" data-toggle="tab"><strong>Step 3:</strong> Blood Investigation </a></li>
                                        <li><a href="#tab4-4" data-toggle="tab"><strong>Step 4:</strong> Examination</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="tab-pane" id="tab1-4"><!-- Start tab-pane -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"><b>Patient Name</b></label>
													<div class="col-sm-8">
														<b>: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?></b> <input type="hidden" disabled name="patient_id" id="patient_id" value="<?php echo $r->patient_id; ?>" />
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

                                           	<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Present Complaints</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled  name="p_present_complaint" id="p_present_complaint"><?php echo $r->p_present_complaint; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Past History</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1"disabled  name="p_past_history" id="p_past_history"><?php echo $r->p_past_history; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Aggrevating Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled disabled name="p_aggrevating_factor" id="p_aggrevating_factor"><?php echo $r->p_aggrevating_factor; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Relieving Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_relieving_factor" id="p_relieving_factor"><?php echo $r->p_relieving_factor; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-1">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault" type="checkbox" disabled name="p_other_chkbox" <?php if($r->p_other_chkbox== 1) { echo ' checked="checked"'; } ?> value="1">
															<label for="checkboxDefault"></label>
														</div>
													</div>

													<?php if($r->p_other_chkbox == 1) {  ?>
													<div class="col-sm-7" id="p_other_evluation">
														<textarea class="form-control" name="p_other_evluation" id="p_other_evluation" rows="1"><?php echo $r->p_other_evluation; ?></textarea>
													</div>
													<?php } else { ?>
														<div class="col-sm-7" style="display:none" id="p_other_evluation">
															<textarea class="form-control" disabled disabled disabled  disabledname="p_other_evluation" id="p_other_evluation" rows="1"></textarea>
														</div>
													<?php } ?>

												</div>
                                            </div><!-- End form-group -->

											<hr /><h4><b><u>Medical History :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault1"  type="checkbox" disabled disabled  disabledname="p_hyper_tension" <?php if($r->p_hyper_tension== 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault1"><b>Hyper Tension</b></label>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault2" type="checkbox" disabled  disabledname="p_diabetes" <?php if($r->p_diabetes== 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault2"><b>Diabetes</b></label>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4"></label>
													<label class="col-sm-1"><b>Height</b></label>
													<div class="col-sm-3">
														<div class="col-sm-9">
															<input type="text" disabled name="p_height" class="form-control" id="p_height" value="<?php echo $r->p_height;?>"/>
														</div>
														<div class="col-sm-1">
															Ft-In
														</div>
													</div>

													<label class="col-sm-1"><b>Weight</b></label><div class="col-sm-3">
														<div class="col-sm-9">
															<input type="text" disabled name="p_weight" class="form-control" id="p_weight" value="<?php echo $r->p_weight; ?>" />
														</div>
														<div class="col-sm-1">
															KG
														</div>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Allergies</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled disabled name="p_allergies" id="p_allergies" /><?php echo $r->p_allergies; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Recent Surgeries Done</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_recent_surgery_done" id="p_recent_surgery_done"><?php echo $r->p_recent_surgery_done; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Current Medications</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_current_medication" id="p_current_medication"><?php echo $r->p_current_medication; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_other_medical_history" id="p_other_medical_history"><?php echo $r->p_other_medical_history; ?></textarea>
													</div>
                                            	</div>
												<div class="col-sm-6">

												</div>
                                            </div><!-- End form-group -->

											<hr />

											<h4><b><u>General Health :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Daily Water Intake</label>
													<div class="col-sm-2">
														<input type="text" disabled name="p_daily_water_intake" id="p_daily_water_intake" class="form-control" value="<?php echo $r->p_daily_water_intake; ?>" />
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-2"></label>
													<label class="col-sm-2">Diet</label>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault3" type="checkbox" disabled name="p_diet_veg" <?php if($r->p_diet_veg== 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault3">VEG</label>
														</div>
													</div>

													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault4" type="checkbox" disabled name="p_diet_nonveg" <?php if($r->p_diet_nonveg== 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault4">Non-VEG</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault5" type="checkbox" disabled name="p_diet_mix" <?php if($r->p_diet_mix== 1) { echo ' checked="checked"'; } ?> value="1">
															<label for="checkboxDefault5">Mix</label>
														</div>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Other</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_other_general"><?php echo $r->p_other_general; ?></textarea>
													</div>
                                            	</div>
												<div class="col-sm-6">

												</div>
                                            </div><!-- End form-group -->

                                        </div><!-- End tab-pane -->

                                        <div class="tab-pane" id="tab2-4">

											<h4><b><u>Addictions :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault6" type="checkbox" disabled  name="p_cigarettes" <?php if($r->p_cigarettes == 1) { echo ' checked="checked"'; } ?> value="1">
															<label for="checkboxDefault6">Cigarettes</label>
														</div>
													</div>
                                            	</div>

												<?php if($r->p_cigarettes == 1) {  ?>
												<div class="col-sm-4" id="cigarettes_daily_intake">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="cigarettes_daily_intake" id="cigarettes_daily_intake" class="form-control" value="<?php echo $r->cigarettes_daily_intake;?>" />
													</div>
                                            	</div>

												<div class="col-sm-4" id="cigarettes_addiction_since">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="cigarettes_addiction_since" id="cigarettes_addiction_since" class="form-control" value="<?php echo $r->cigarettes_addiction_since;?>" />
													</div>
                                            	</div>
												<?php } else { ?>

												<div class="col-sm-4" id="cigarettes_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="cigarettes_daily_intake" id="cigarettes_daily_intake" class="form-control" value="<?php echo $r->cigarettes_daily_intake;?>" />
													</div>
                                            	</div>

												<div class="col-sm-4" id="cigarettes_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="cigarettes_addiction_since" id="cigarettes_addiction_since" class="form-control" value="<?php echo $r->cigarettes_addiction_since;?>" />
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault7" type="checkbox" disabled name="p_alcohol" <?php if($r->p_alcohol == 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault7">Alcohol</label>
														</div>
													</div>
                                            	</div>

												<?php if($r->p_alcohol == 1) {  ?>
												<div class="col-sm-4" id="alcohol_daily_intake">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="alcohol_daily_intake" id="alcohol_daily_intake" class="form-control" value="<?php echo $r->alcohol_daily_intake; ?>" />
													</div>
                                            	</div>
												<div class="col-sm-4" id="alcohol_addiction_since">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="alcohol_addiction_since" id="alcohol_addiction_since" class="form-control" value="<?php echo $r->alcohol_addiction_since; ?>" />
													</div>
                                            	</div>
												<?php } else { ?>
												<div class="col-sm-4" id="alcohol_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="alcohol_daily_intake" id="alcohol_daily_intake" class="form-control" />
													</div>
                                            	</div>
												<div class="col-sm-4" id="alcohol_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="alcohol_addiction_since" id="alcohol_addiction_since" class="form-control" />
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault8" type="checkbox" disabled name="p_tobaco" <?php if($r->p_tobaco == 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault8">Tobaco</label>
														</div>
													</div>
                                            	</div>
                                            	<?php if($r->p_tobaco == 1) {  ?>
												<div class="col-sm-4">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="tobaco_daily_intake" id="tobaco_daily_intake" class="form-control" value="<?php echo $r->tobaco_daily_intake; ?>" />
													</div>
                                            	</div>
												<div class="col-sm-4">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="tobaco_addiction_since" id="tobaco_addiction_since" class="form-control" value="<?php echo $r->tobaco_addiction_since; ?>" />
													</div>
                                            	</div>
												<?php } else { ?>
												<div class="col-sm-4" id="tobaco_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" disabled name="tobaco_daily_intake" id="tobaco_daily_intake" class="form-control" />
													</div>
                                            	</div>
												<div class="col-sm-4" id="tobaco_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" disabled name="tobaco_addiction_since" id="tobaco_addiction_since" class="form-control" />
													</div>
                                            	</div>
												<?php } ?>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input id="checkboxDefault9" type="checkbox" disabled name="p_none"  <?php if($r->p_none == 1) { echo 'checked="checked"'; } ?> value="1">
															<label for="checkboxDefault9">None</label>
														</div>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<hr />
											<h4><b><u>X-ray Scan Report :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8">
													<label class="col-sm-2">Uploaded Files</label>
													<?php
														// get all xray report files for this patient evaluation -
														$rsxray_report = $this->db->get_where('patient_xray_report', array('evaluation_id' => $r->pk, 'is_deleted' => 0));

														if($rsxray_report->num_rows() > 0)
														{
													?>
													<div class="col-sm-8 table-responsive">
														<table class="table table-striped table-bordered">
															<tr style="text-align:center">
																<th>File Name</th>
																<th>Action</th>
															</tr>
															<?php foreach($rsxray_report->result() as $r2) { ?>
															<tr>
																<td><a href="<?php echo base_url().'./patient_report/xray_report/'.$r2->p_xray_report; ?>" target="_blank">
																	<?php echo $r2->p_xray_report; ?></a>
																</td><th><a href="javascript:void(0)" data-value="<?php echo $r2->pk; ?>" class="btn-delete">Delete</a></th>
															</tr>
															<?php } ?>
														</table>
													</div>
													<?php
														}
													?>
                                            	</div>

                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8">
													<label class="col-sm-2">File</label>
													<div class="col-sm-8" id="xray_upload">
														<input type="file" disabled name="p_xray_report[]" />
													</div>
                                            	</div>


                                            </div><!-- End form-group -->

											<hr />
											<h4><b><u>Vitamin :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">D3/B12</label>
													<div class="col-sm-8">
														<input type="text" disabled name="p_vitamin" id="p_vitamin" class="form-control"  value="<?php echo $r->p_vitamin; ?>"/>
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
													<label class="col-sm-4">Upload Report</label>
													<div class="col-sm-8">
														<a href="<?php echo base_url().'./patient_report/blood_investigation_report/'.$r->blood_investigation_report; ?>" target="_blank">
															<b><?php echo $r->blood_investigation_report; ?></b></a>
															<input type="file" class="form-control" disabled name="blood_investigation_report" id="blood_investigation_report"/>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="blood_investigation_other"><?php echo $r->blood_investigation_other; ?></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<hr />
											<h4><b><u>Observation:</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-12">
													<label class="col-sm-2"></label>
													<div class="col-sm-10">
														<textarea class="form-control validate[required]" rows="2" disabled name="blood_observation"><?php echo $r->blood_observation; ?></textarea>
													</div>
												</div>
											</div>

											<hr />
											<h4><b><u>Movements :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Special Test</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_special_test" id="p_special_test"><?php echo $r->p_special_test; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Range</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_range" id="p_range"><?php echo $r->p_range; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Quality</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_quality" id="p_quality"><?php echo $r->p_quality; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Combined Movements</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_combined_movement" id="p_combined_movement">
															<?php echo $r->p_combined_movement; ?>
														</textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

                                            <div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_movement_notes" id="p_movement_notes">
															<?php echo $r->p_movement_notes; ?>
														</textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

                                        </div><!--End tab-pane -->

                                        <div class="tab-pane" id="tab4-4">

											<h4><b><u>Muscle :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Strength</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_strength" id="p_strength"><?php echo $r->p_strength; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Flexibility</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_flexibility" id="p_flexibility"><?php echo $r->p_flexibility; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_muscle_notes" id="p_muscle_notes"><?php echo $r->p_muscle_notes; ?></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<hr />
										    <h4><b><u>Palpation :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"> Tenderness</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_tenderness" id="p_tenderness"><?php echo $r->p_tenderness; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Swelling</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_swelling" id="p_swelling"><?php echo $r->p_swelling; ?></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

										   <div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Limblength Discrepancy</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_limblength" id="p_limblength"><?php echo $r->p_limblength; ?></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Neural Investigation </label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="nueral_investigation" id="nueral_investigation">
															<?php echo $r->nueral_investigation; ?>
														</textarea>
													</div>
												</div>
											</div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="p_palpation_notes" id="p_palpation_notes">
															<?php echo $r->p_palpation_notes; ?>
														</textarea>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Provisional Diagnosis</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" disabled name="provisional_diagnosis" id="provisional_diagnosis">
															<?php echo $r->provisional_diagnosis; ?>
														</textarea>
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
		$(document).ready(function()
		{
			$("#s_dob").datepicker({ dateFormat: 'dd-mm-yy' });
			$("#date_of_joining").datepicker({dateFormat:'dd-mm-yy'});
		});
	</script>

	<script>

	$(document).ready(function()
	{
		var max_fields      = 10; //maximum input boxes allowed
		var wrapper         = $("#xray_upload"); //Fields wrapper
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

				$(wrapper).append('<span style="display:inline;"><input type="file" disabled name="p_xray_report[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span>')
			}
		});

		$("span.remove_field").live("click", function(e)
		{
			//user click on remove text
			e.preventDefault();

			$(this).parent('span').remove();
			x--;
		});

	});

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
					url: "<?php print base_url(); ?>evaluation/delete_xray_report_file",
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
