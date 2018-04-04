<?php $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>

			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-pencil"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Evaluation</a></li>

								</ul>
								<h4>Add Evaluation</h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->

					<div class="contentpanel contentpanel-wizard">

                        <div class="row">

                            <div class="col-md-12">
                                <h5 class="lg-title"><b>Patient Evaluation</b></h5>
                                <p class="mb20"></p>

                                <!-- BASIC WIZARD -->
                                <form method="post" action="<?php echo $saveaction; ?>" id="valWizard" class="form-horizontal" enctype="multipart/form-data">
                                  <div id="rootwizard">
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
													<label class="col-sm-4">Patient Name</label>
													<div class="col-sm-8">
														<select id="patient_id" name="patient_id" data-placeholder="Choose Paitent " class="select2-container width100p">
															<option value=""> </option>
															<?php
																foreach ($rscontact_list->result() as $r)
																{
																	echo "<option value='".$r->patient_id."'>".$r->p_fname.' '.$r->p_mname.' '.$r->p_lname."</option>";
																}
															?>
														</select>
														<span id="msg1" class="" style="color:#FF0000"></span>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

                                           <div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Present Complaints</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_present_complaint" id="p_present_complaint"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Past History</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_past_history" id="p_past_history"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Aggrevating Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_aggrevating_factor" id="p_aggrevating_factor"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Relieving Factor</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_relieving_factor" id="p_relieving_factor"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-1">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault" type="checkbox" name="p_other_chkbox">
															<label for="checkboxDefault"></label>
														</div>
													</div>
													<div class="col-sm-7" style="display:none" id="p_other_evluation">
														<textarea class="form-control" name="p_other_evluation" id="p_other_evluation" rows="1"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<hr />

											<h4><b><u>Medical History :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault1"  type="checkbox" name="p_hyper_tension">
															<label for="checkboxDefault1"><b>Hyper Tension</b></label>
														</div>
													</div>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault2" type="checkbox" name="p_diabetes">
															<label for="checkboxDefault2"><b>Diabetes</b></label>
														</div>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4"></label>
													<label class="col-sm-1"><b>Height</b></label>
													<div class="col-sm-3">
														<div class="col-sm-9">
															<input type="text" name="p_height" class="form-control" id="p_height"/>
														</div>
														<div class="col-sm-1">
															Ft-In
														</div>
													</div>

													<label class="col-sm-1"><b>Weight</b></label><div class="col-sm-3">
														<div class="col-sm-9">
															<input type="text" name="p_weight" class="form-control" id="p_weight" />
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
														<textarea class="form-control" rows="1" name="p_allergies" id="p_allergies" /></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Recent Surgeries Done</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_recent_surgery_done" id="p_recent_surgery_done"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Current Medications</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_current_medication" id="p_current_medication"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_other_medical_history" id="p_other_medical_history"></textarea>
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
														<input type="text" name="p_daily_water_intake" id="p_daily_water_intake" class="form-control" />
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-2"></label>
													<label class="col-sm-2">Diet</label>
													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault3" type="checkbox" name="p_diet_veg">
															<label for="checkboxDefault3">VEG</label>
														</div>
													</div>

													<div class="col-sm-3">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault4" type="checkbox" name="p_diet_nonveg">
															<label for="checkboxDefault4">Non-VEG</label>
														</div>
													</div>
													<div class="col-sm-2">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault5" type="checkbox" name="p_diet_mix">
															<label for="checkboxDefault5">Mix</label>
														</div>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Other</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_other_general"></textarea>
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
															<input value="1" id="checkboxDefault6" type="checkbox" name="p_cigarettes">
															<label for="checkboxDefault6">Cigarettes</label>
														</div>
													</div>
                                            	</div>

												<div class="col-sm-4" id="cigarettes_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" name="cigarettes_daily_intake" id="cigarettes_daily_intake" class="form-control"  />
													</div>
                                            	</div>
												<div class="col-sm-4" id="cigarettes_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" name="cigarettes_addiction_since" id="cigarettes_addiction_since" class="form-control"  />
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault7" type="checkbox" name="p_alcohol">
															<label for="checkboxDefault7">Alcohol</label>
														</div>
													</div>
                                            	</div>

												<div class="col-sm-4" id="alcohol_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" name="alcohol_daily_intake" id="alcohol_daily_intake" class="form-control" />
													</div>
                                            	</div>
												<div class="col-sm-4" id="alcohol_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" name="alcohol_addiction_since" id="alcohol_addiction_since" class="form-control" />
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault8" type="checkbox" name="p_tobaco">
															<label for="checkboxDefault8">Tobaco</label>
														</div>
													</div>
                                            	</div>

												<div class="col-sm-4" id="tobaco_daily_intake" style="display:none">
													<label class="col-sm-6">Daily Intake Count</label>
													<div class="col-sm-3">
														<input type="text" name="tobaco_daily_intake" id="tobaco_daily_intake" class="form-control" />
													</div>
                                            	</div>
												<div class="col-sm-4" id="tobaco_addiction_since" style="display:none">
													<label class="col-sm-7">Addiction Since(in Months)</label>
													<div class="col-sm-3">
														<input type="text" name="tobaco_addiction_since" id="tobaco_addiction_since" class="form-control" />
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-4">
													<label class="col-sm-4"></label>
													<div class="col-sm-4">
														<div class="ckbox ckbox-default">
															<input value="1" id="checkboxDefault9" type="checkbox" name="p_none">
															<label for="checkboxDefault9">None</label>
														</div>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<hr />
											<h4><b><u>X-ray Scan Report :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8" id="x-ray">
													<label class="col-sm-2">Upload Report</label>
													<div class="col-sm-6" id="xray_upload">
														<input type="file" name="p_xray_report[]" />
													</div>
                                            	</div>

												<div class="col-sm-4">
													<div class="form-group">
														<div class="col-sm-2">
															<button type="button" class="btn btn-primary btn-sm" id="add_more">
																 <span class="glyphicon glyphicon-plus"> <b>Upload More</b></span>
															</button>
														</div>
													</div>
												</div>

                                            </div><!-- End form-group -->

											<hr />

											<h4><b><u>Vitamin :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-3">D3/B12</label>
													<div class="col-sm-8">
														<input type="text" name="p_vitamin" id="p_vitamin" class="form-control" />
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
														<input type="file" name="blood_investigation_report" id="blood_investigation_report"  />
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Others</label>
													<div class="col-sm-8">
														<input type="text" name="blood_investigation_other" id="blood_investigation_other" class="form-control" />
													</div>
                                            	</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->

                                            </div><!-- End form-group -->

											<hr />
											<h4><b><u>Observation:</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-12">
													<label class="col-sm-2"></label>
													<div class="col-sm-10">
														<textarea class="form-control" rows="2" name="blood_observation" id="blood_observation" ></textarea>
													</div>
												</div>
											</div><!-- End form-group -->

											<hr />
											<h4><b><u>Movements :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Special Test</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_special_test" id="p_special_test"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Range</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_range" id="p_range"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Quality</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_quality" id="p_quality"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Combined Movements</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_combined_movement" id="p_combined_movement"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_movement_notes" id="p_movement_notes"></textarea>
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
														<textarea class="form-control" rows="1" name="p_strength" id="p_strength"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Flexibility</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_flexibility" id="p_flexibility"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_muscle_notes" id="p_muscle_notes"></textarea>
													</div>
                                            	</div>
                                            </div><!-- End form-group -->
											<hr />
										    <h4><b><u>Palpation :</u></b></h4>

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4"> Tenderness</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_tenderness" id="p_tenderness"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Swelling</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_swelling" id="p_swelling"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

										   <div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Limblength Discrepancy</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_limblength" id="p_limblength"></textarea>
													</div>
                                            	</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Neural Investigation </label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="nueral_investigation" id="nueral_investigation"></textarea>
													</div>
												</div>
                                            </div><!-- End form-group -->

											<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-6">
													<label class="col-sm-4">Notes</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="p_palpation_notes" id="p_palpation_notes"></textarea>
													</div>
												</div>

												<div class="col-sm-6">
													<label class="col-sm-4">Provisional Diagnosis</label>
													<div class="col-sm-8">
														<textarea class="form-control" rows="1" name="provisional_diagnosis" id="provisional_diagnosis"></textarea>
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
											<button type="submit" class="btn btn-primary">Finish <span class="glyphicon glyphicon-ok"></span></button>
										</li>
                                    </ul>
                                  </div>
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

      var $validator = $("#valWizard").validate({
		  rules: {
		    patient_id: {
		      required: true

		    },
		    p_allergies: {
		      required: true

		    },
		    p_special_test: {
		      required: true
		    }
		  }
		});

      $('#rootwizard').bootstrapWizard({
          'tabClass': 'nav nav-pills',
          'onNext': function(tab, navigation, index) {
            var $valid = $("#valWizard").valid();
            console.log($valid);
            if (!$valid) {
              $validator.focusInvalid();
              return false;
            }
          },
          'onTabClick': function(activeTab, navigation, currentIndex, nextIndex) { alert();
            if (nextIndex <= currentIndex) {
              return;
            }
            var $valid = $("#valWizard").valid();
            if (!$valid) {
              $validator.focusInvalid();
              return false;
            }
            if (nextIndex > currentIndex+1){
             return false;
            }
          }
    });

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

				$(wrapper).append('<span style="display:inline;"><input type="file" name="p_xray_report[]" style="display:inline" />&nbsp;<span style="display:inline" class="glyphicon glyphicon-remove remove_field"></span></span>'); //add input box
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

	</script>
    </body>
</html>
