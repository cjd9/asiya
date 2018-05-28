<?php $this->load->view('include/header'); ?>

<?php $this->load->view('include/left'); ?>

<?php
$edit_treatment_html = '';
$edit_treatment_html .= ' <div class="col-sm-12 table-responsive">
   
        <table class="table table-dark mb30 responsive">
      <thead>
        <tr>

          <th><div align="center">Therapy</div></th>
          <th><div align="center">Repetitions </div></th>
          <th><div align="center">Sets</div></th>
          <th><div align="center">Hold Time</div></th>
          <th><div align="center">Add</div></th>
        </tr>
      </thead>
      <tbody>';
      $count = 0;
foreach($rstreatment->result_array() as $treatment_meta) { 

	$edit_treatment_html .= '<tr>
          <td><input class="form-control" placeholder="Therapy Name" name="edit_treatment['.$treatment_meta["id"].'][therapy]" id="maual_therapy" value='.$treatment_meta["therapy"].' ></input></td>
          <td><input type="number" name = "edit_treatment['.$treatment_meta["id"].'][reps]" class="form-control" value="'.$treatment_meta["reps"].'" placeholder="No of Reps"/></td>
          <td><input type="number" name = "edit_treatment['.$treatment_meta["id"].'][sets]" class="form-control" value="'.$treatment_meta["sets"].'"placeholder="No of Sets"/></td>
          <td><input type="number" name = "edit_treatment['.$treatment_meta["id"].'][time]" class="form-control" value="'.$treatment_meta["time"].'"placeholder="Hold time in mins"/>
          <input type="hidden" name = "edit_treatment['.$treatment_meta["id"].'][id]" value = "'.$treatment_meta['id'].'"</td>
          <td><button href= "" class="form-control add-btn" id="add-btn-'.$count.'" style="z-index:0">+</button></td>
          

        </tr>
      ';
      $count= $count + 1;

}
  $edit_treatment_html .= '</tbody>
    </table>
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
					<h4>Edit Treatment</h4>
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
					<input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

					<div class="panel panel-default">
						<div class="panel-heading">
							
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
									<div class="col-sm-12 table-responsive add-row">
								<?php echo $edit_treatment_html;?>
									</div>
								</div>

							</div><!-- row -->
						</div><!-- panel-body -->

						<div class="panel-footer">
						  <div class="row">
							<div class="col-sm-7 col-sm-offset-4">
								<button class="btn btn-primary mr5">Submit</button>
								<a href="<?php print base_url(); ?>treatment" class="btn btn-dark">Cancel</a>
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
  	{ var count = <?php  echo $count-1; ?>;

  		for (i = 0; i < count; i++) {

     $('#add-btn-'+i).prop('disabled', true);

  		}

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
     $('#add-btn-'+count).on("click", function(e){

        count= count+1;
         e.preventDefault();
               $('.add-row').append(
            '     <div class="col-sm-12 table-responsive">'+
            '     <table class="table table-dark mb30 responsive">'+
            '<tbody>'+
            '<tr>'+
            '<td><input class="form-control" placeholder="Therapy Name" name="treatment['+count+'][therapy]" id="maual_therapy"></input></td>'+
            '<td><input type="number" name = "treatment['+count+'][reps]" class="form-control"  placeholder="No of Reps"/></textarea></td>'+
            '<td><input type="number" name = "treatment['+count+'][sets]" class="form-control" placeholder="No of Sets"/></textarea></td>'+
            '<td><input type="number" name = "treatment['+count+'][time]" class="form-control" placeholder="Hold time in mins"/></textarea></td>'+
            '<td><button href= "" class="form-control add-btn" id="add-btn-'+count+'"  style="z-index:0">+</button></td>'+
            '</tr>'+
            '</tbody>'+
    '     </table>'+
    '</div>');
    $(this).html().replace(/ARRAY_INDEX/g,  1);
    addRow();
  }); }
  	});
  </script>

    </body>
</html>
