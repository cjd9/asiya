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
						<li><a href="#">Treatment Details</a></li>

					</ul>
					<h4>Add Treatment</h4>
				</div>
			</div><!-- media -->
		</div><!-- pageheader -->

		<div class="contentpanel">

			<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

			<div class="row">
				<div class="col-md-12">
					<form id="add_treatment_form" action="<?php echo $saveaction; ?>" method="post" enctype="multipart/form-data">

					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="panel-btns">
								<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
								<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
							</div><!-- panel-btns -->
							<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Add Treatment</b></h3>
						</div><!-- panel-heading -->

						<div class="panel-body">
							<div class="row">

								<?php
									$sql = "SELECT treatment_id FROM treatment ORDER BY treatment_id DESC LIMIT 1";

									$rs = $this->db->query($sql);

									if($rs->num_rows() > 0)
									{
										$x = $rs->row()->treatment_id;

										$x = $this->mastermodel->get_auto_no($x);
									}
									else
									{
										$x = 'ACPT0001';
									}
								?>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-md-3 control-label">Treatment ID</label>
										<div class="col-sm-8">
											<input type="text" id="treatment_id" name="treatment_id" class="form-control validate[required]" value="<?php echo $x; ?>" readonly />
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Date Of Treatment</label>
										<div class="col-sm-8">
											<div class="input-group">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
												<input type="text" class="form-control validate[required] datepicker" name="date_of_treatment" id="date_of_treatment" value="<?php echo date('d-m-Y')?>">
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
								</div><!-- form-group -->

								<hr />
								<h4><u><b>Plan of Care</b></u></h4>

								<div class="form-group">
									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Short Term Goals<span class="asterisk">*</span></label>
										<div class="col-sm-8">
											<textarea class="form-control validate[required]" rows="2" name="short_term_goal" id="short_term_goal"></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Long Term Goals</label>
										<div class="col-sm-8">
											<textarea class="form-control validate[required]" rows="2" name="long_term_goal" id="long_term_goal"></textarea>
										</div>
									</div>
								</div><!-- form-group -->

								<div class="form-group">

									<div class="col-sm-6">
										<label class="col-sm-3 control-label">Next Therapy Plan</label>
										<div class="col-sm-8">
											<textarea class="form-control validate[required]" rows="2" name="next_therapy_plan" id="next_therapy_plan"></textarea>
										</div>
									</div>

									<div class="col-sm-6">
										<label class="col-sm-4 control-label">Fees</label>
										<div class="col-sm-3">
											<input type="text" class="form-control validate[required]" name="treatment_fees" id="treatment_fees" />
										</div>
									</div>
								</div><!-- form-group -->

								<hr />
								<h4><b><u>Treatment Therapy </u></b></h4>

								<div class="form-group responsive add-row" id="">
									<div class="col-sm-12 table-responsive">
										<table class="table table-dark mb30 responsive">
											<thead>
												<tr>

                          <th><div align="center">Therapy</div></th>
                          <th><div align="center">Repitions</div></th>
                          <th><div align="center">Sets</div></th>
                          <th><div align="center">Hold Time</div></th>
                          <th><div align="center">Add</div></th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td><input class="form-control" name="treatment[0][therapy]" id="maual_therapy"></input></td>
													<td><input type="number" name = "treatment[0][reps]" class="form-control"  placeholder="No of Reps"/></textarea></td>
													<td><input type="number" name = "treatment[0][sets]" class="form-control" placeholder="No of Sets"/></textarea></td>
													<td><input type="number" name = "treatment[0][time]" class="form-control" placeholder="Hold time in mins"/></textarea></td>
													<td><button href= "" class="form-control add-btn" id="" style="z-index:0">+</button></td>
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
        <script src="<?php print base_url(); ?>js/jquery.validate.min.js"></script>

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
             $('.add-row').append(
          '     <div class="col-sm-12 table-responsive">'+
          '     <table class="table table-dark mb30 responsive">'+
          '<thead>'+
          '<tr>'+

          '<th><div align="center">Therapy</div></th>'+
          '<th><div align="center">Repitions</div></th>'+
          '<th><div align="center">Sets</div></th>'+
          '<th><div align="center">Hold Time</div></th>'+
          '<th><div align="center">Add  </div></th>'+
          '<th><div align="center">Del</div></th>'+
          '</tr>'+
          '</thead>'+
          '<tbody>'+
          '<tr>'+
          '<td><input class="form-control" name="treatment['+count+'][therapy]" id="maual_therapy"></input></td>'+
          '<td><input type="number" name = "treatment['+count+'][reps]" class="form-control"  placeholder="No of Reps"/></textarea></td>'+
          '<td><input type="number" name = "treatment['+count+'][sets]" class="form-control" placeholder="No of Sets"/></textarea></td>'+
          '<td><input type="number" name = "treatment['+count+'][time]" class="form-control" placeholder="Hold time in mins"/></textarea></td>'+
          '<td><button href= "" class="form-control add-btn" id="" style="z-index:0">+</button></td>'+
          '<td><button href= "" class="form-control add-btn" id="delete" style="z-index:0">x</button></td>'+
          '</tr>'+
          '</tbody>'+
  '     </table>'+
  '</div>');
			
			


		  $(this).html().replace(/ARRAY_INDEX/g,  1);
		  addRow();
		 
		}); 

		 deleteRow();

}
	
	$("#add_treatment_form").validate({
		  rules: {
		    treatment_fees: {
		      required: true

		    }
		  }
		});



	});

function deleteRow(){
	$('#delete').on("click",function(e){
				e.preventDefault();
				console.log($(this).closest("table").parent('div'));
				$(this).closest("table").parent('div').addClass('hide');
		});
}
</script>

    </body>
</html>
