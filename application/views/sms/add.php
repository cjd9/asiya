<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="glyphicon glyphicon-phone"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">SMS</a></li>
									
								</ul>
								<h4>Send SMS </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<div class="row">
							<div class="col-md-12">
							
								<div class="alert alert-success" style="display:none" id="sms_sent_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    <p>Email Sent Successfully.</p>
                                </div>
							
								<form id="send_sms_form" action="<?php //echo $saveaction; ?>" method="post">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
											<a href="#" class="panel-minimize tooltips" data-toggle="tooltip" title="Minimize Panel"><i class="fa fa-minus"></i></a>
											<a href="#" class="panel-close tooltips" data-toggle="tooltip" title="Close Panel"><i class="fa fa-times"></i></a>
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-phone"></i> <b>Send New SMS </b></h3>
									</div><!-- panel-heading -->
									
									<div class="panel-body">
										<div class="row">
										
											<div class="form-group">
												<label class="col-md-2 control-label">Patient Name (To) <span class="asterisk">*</span></label>
												<div class="col-sm-5">
													<select id="patient_id" name="patient_id" data-placeholder="Choose Patient" class="select2-container width100p">
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
												
												<div class="col-sm-5">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
														<input type="text" name="patient_contact_no" id="patient_contact_no" class="form-control" placeholder="Patient Contact No." value="" readonly>
													</div><!-- input-group -->
												</div>
												
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Message<span class="asterisk">*</span></label>
												<div class="col-sm-10">
													<textarea id="msg" name="msg" placeholder="Enter message here..." class="form-control validate[required]" rows="3"></textarea>
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Send</button>
											<a href="<?php print base_url(); ?>sms" class="btn btn-dark">Cancel</a>
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
			$("#send_sms_form").validationEngine({promptPosition: "topRight: -100"});
			
			// select box validations -
			$('#send_sms_form').on('submit', function(e) 
			{
				e.preventDefault();
			
				$('#msg1').text('');
				
				if($('#patient_id').val() == '' || $('#patient_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}
				
				// check if this patient having email id -
				if($('#patient_contact_no').val() == '')
				{
					alert("Contact No. for this Patient is not present.");
					return false;
				}
				
				if($('#msg').val() == '')
				{
					alert("Message Must be required.");
					return false;
				}
				
				//data to be sent to server        
				var m_data = new FormData();   
				 
				m_data.append( 'patient_id', $('select[name=patient_id]').val());
				m_data.append( 'patient_contact_no', $('input[name=patient_contact_no]').val());
				m_data.append( 'msg', $('textarea[name=msg]').val());
				 
				$.ajax({
						url: '<?php echo base_url(); ?>sms/send',
						data: m_data,
						processData: false,
						contentType: false,
						type: 'POST',
						//dataType:'json',
						success: function(response){
						
							//alert(response);
							
							if(response)
							{
								//alert('Email Sent Successfully.');
								
								$("#sms_sent_msg p").text('SMS Sent Successfully.');
								$("#sms_sent_msg").removeClass('alert-danger').addClass('alert-success').show();
								
								// redirect to list page after 5 seconds -
								setTimeout("window.location.href = '<?php print base_url(); ?>sms';", 5000);
							}
							else
							{	
								//alert('Email Sent Error.');
								
								$("#sms_sent_msg p").text('SMS Sent Error.');
								$("#sms_sent_msg").removeClass('alert-success').addClass('alert-danger').show();
								
								return false;
							}
						}
				});
			});	
			
			// get patient email id -
			$('#patient_id').on('change', function(e) 
			{
				var patient_id = $(this).val();
				
				//alert(patient_id);
				
				$.ajax({
						url: "<?php print base_url(); ?>sms/get_contact_no",
						type: "post",
						async:false,
						cache:false,
						//dataType:'json',
						data:{ patient_id:patient_id },
						success: function (res) 
						{
							//alert(res);
							
							// check if conatct no. is present -
							if(res != 0)
							{
								//alert(res);
								
								// append email id to field -
								$("#patient_contact_no").val(res);
							}
							else
							{
								alert("Contact No. for this Patient is not present.");
								
								$("#patient_contact_no").val('');
							}
						}
				});
				
			});
		
		}); 
	</script>
	
    </body>
</html>