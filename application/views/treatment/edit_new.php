<?php $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>
<?php
$edit_treatment_html = '';
  $edit_treatment_html .= '<div class="col-sm-12 table-responsive">
    <table class="table table-dark mb30 responsive">
      <thead>
        <tr>

          <th><div align="center">Therapy</div></th>
          <th><div align="center">Repetitions</div></th>
          <th><div align="center">Sets</div></th>
          <th><div align="center">Hold Time</div></th>

          <th><div align="center">Add</div></th>
        </tr>
      </thead>';
foreach($rstreatment->result_array() as $treatment_meta) {
  $edit_treatment_html .= '
      <tbody>
        <tr>
          <td><input class="form-control" placeholder="Therapy Name" disabled name="edit_treatment['.$treatment_meta["treatment_id"].'][therapy]" id="maual_therapy" value='.$treatment_meta["therapy"].' ></input></td>
          <td><input type="number" disabled name = "edit_treatment['.$treatment_meta["treatment_id"].'][reps]" class="form-control" value="'.$treatment_meta["reps"].'" placeholder="No of Reps"/></td>

          <td><input type="number" disabled name = "edit_treatment['.$treatment_meta["treatment_id"].'][sets]" class="form-control" value="'.$treatment_meta["sets"].'"placeholder="No of Sets"/></td>
          <td><input type="number" disabled name = "edit_treatment['.$treatment_meta["treatment_id"].'][time]" class="form-control" value="'.$treatment_meta["time"].'"placeholder="Hold time in mins"/>
          <input type="hidden" value = '.$treatment_meta['id'].'</td>
          <td><button href= "" class="form-control add-btn" id="" style="z-index:0">+</button></td>

        </tr>
      </tbody>';

}
   $edit_treatment_html .= '</table>
  </div>';

?>
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
					<h4>View Treatment</h4>
				</div>
			</div><!-- media -->
		</div><!-- pageheader -->

		<div class="contentpanel">

			<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

			<?php
				$r = $rstreatment->result()[0];

			 ?>

			<div class="row">
				<div class="col-md-12">
					<form id="edit_treatment_form" action="<?php echo $editaction; ?>" method="post" enctype="multipart/form-data" onSubmit="return validate()">
					<input type="hidden" disabled name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-btns">
								<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
								<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
							</div><!-- panel-btns -->
							<a href="<?php echo base_url().'treatment'; ?>" type="button" class="btn btn-default btn-sm">
					          <span class="glyphicon glyphicon-arrow-left "></span> Back
					        </a>
							<h3 class="panel-title text-center"><i class="glyphicon glyphicon-edit"></i> <b>View Treatment</b></h3>
						</div><!-- panel-heading -->

						<div class="panel-body">
							<div class="row">

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-md-3 control-label">Treatment ID</label>
										<div class="col-sm-8">
											<input type="text" id="treatment_id" disabled name="treatment_id" class="form-control validate[required]" value="<?php echo $r->treatment_id; ?>" readonly />
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Date Of Treatment</label>
										<div class="col-sm-8">
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input type="text" class="form-control datepicker" disabled name="date_of_treatment" id="date_of_treatment" value="<?php echo date("d-m-Y",strtotime($r->date_of_treatment)); ?>" />
											</div><!-- input-group -->
										</div>
									</div>
								</div><!-- form-group -->

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Patient Name<span class="asterisk">*</span></label>
										<div class="col-sm-8">
										    <input type="text" class="form-control" disabled value=" <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo $r1->p_fname.' '.$r1->p_lname; ?>">

											<span id="msg1" class="" style="color:#FF0000"></span>
										</div>
									</div>
								</div><!-- form-group -->

								<hr />
								<div class="form-group"><!-- Start form-group -->
												<div class="col-sm-8">
													<label class="col-sm-3">Uploaded Files</label>
													<div class="col-sm-8 table-responsive">
														<table class="table table-striped table-bordered">
															<tr style="text-align:center">
																<th>File Name</th>
															</tr>
															<tr>
																<td>
																	<a href="<?php echo base_url().'treatment_image/'.$r->treatment_image; ?>" target="_blank">
																		<?php echo $r->treatment_image; ?>
																	</a>
																</td>

															</tr>

														</table>
													</div>
                                            	</div>
                                            </div>
								<h4><u><b>Plan of Care</b></u></h4>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Short Term Goals<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" disabled name="short_term_goal" id="short_term_goal"><?php echo $r->short_term_goal; ?></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Long Term Goals<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" disabled name="long_term_goal" id="long_term_goal"><?php echo $r->long_term_goal; ?></textarea>
										</div>
									</div>
								</div><!-- form-group -->

								<div class="form-group">

									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Next Therapy Plan<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control" rows="2" disabled name="next_therapy_plan" id="next_therapy_plan"><?php echo $r->next_therapy_plan; ?></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Fees<span class="asterisk">*</span></label>
										<div class="col-sm-3">
											<input type="text" class="form-control" disabled name="treatment_fees" id="treatment_fees" value="<?php echo $r->treatment_fees; ?>" />
										</div>
									</div>
								</div><!-- form-group -->

								<hr />
								<h4><b><u>Treatment Therapy </u></b></h4>

								<div class="form-group responsive">
									<div class="col-sm-12 table-responsive add-row">
								<?php echo $edit_treatment_html;?>
									</div>
								</div>

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

	<!-- <script>
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
	</script> -->

  <script>
  	$(document).ready(function()
  	{
      var count = 0;
       addRow();
  		//$("#add_treatment_form").validationEngine({promptPosition: "topRight: -100"});

  		// select box validations -
  		// $('#add_treatment_form').on('submit', function() {
      //
  		// 	$('#msg1').text('');
      //
  		// 	if($('#patient_id').val() == '' || $('#patient_id').val() == null)
  		// 	{
  		// 		$('#msg1').text('This field is required');
  		// 		return false;
  		// 	}
      //
  		// });
  function addRow(){
      $('.add-btn').on("click", function(e){

        count= count+1;
         e.preventDefault();

  }); }
  	});
  </script>

    </body>
</html>
