<?php $this->load->view('include/header'); ?>
 
<?php $this->load->view('include/left'); ?>
        
			<div class="mainpanel">
					<div class="pageheader">
						<div class="media">
							<div class="pageicon pull-left">
								<i class="fa fa-envelope-o"></i>
							</div>
							<div class="media-body">
								<ul class="breadcrumb">
									<li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
									<li><a href="#">Email</a></li>
									
								</ul>
								<h4>Send Email </h4>
							</div>
						</div><!-- media -->
					</div><!-- pageheader -->
					
					<div class="contentpanel">
					
						<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
						
						<div class="row">
							<div class="col-md-12">
							
								<div class="alert alert-success" style="display:none" id="email_sent_msg">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                    <p>Email Sent Successfully.</p>
                                </div>
							
								<form id="send_email_form" action="<?php //echo $saveaction; ?>" method="post" enctype="multipart/form-data">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										
										<h3 class="panel-title"><i class="glyphicon glyphicon-pencil"></i> <b>Send New Email </b></h3>
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
												</div><span id="msg1" class="" style="color:#FF0000"></span>
												
												<div class="col-sm-5">
													<div class="input-group">
														<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
														<input type="text" name="patient_email" id="patient_email" class="form-control" placeholder="Patient Email" value="" readonly>
													</div><!-- input-group -->
												</div>
												
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> CC </label>
												<div class="col-sm-10">
													<div class="ckbox ckbox-default">
														<input value="1" id="checkboxDefault" type="checkbox" name="is_cc">
														<label for="checkboxDefault"></label>[ To Admin ]
													</div>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Subject<span class="asterisk">*</span></label>
												<div class="col-sm-10">
													<input type="text" name="email_subject" id="email_subject" class="form-control validate[required]" placeholder="Enter email subject">
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Message<span class="asterisk">*</span></label>
												<div class="col-sm-10">
													<textarea id="wysiwyg" name="msg" placeholder="Enter text here..." class="form-control validate[required]" rows="10"></textarea>
												</div>
											</div><!-- form-group -->
											
											<div class="form-group">
												<label class="col-md-2 control-label"> Attachment</label>
												<div class="col-sm-10">
													<input type="file" id="attachment_file_name" name="attachment_file_name" class="form-control" />
												</div>
											</div><!-- form-group -->
											
										</div><!-- row -->
									</div><!-- panel-body -->
									
									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Send</button>
											<a href="<?php print base_url(); ?>index.php/email" class="btn btn-dark">Cancel</a>
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
			$("#send_email_form").validationEngine({promptPosition: "topRight: -100"});
			
			// HTML5 WYSIWYG Editor
            jQuery('#wysiwyg').wysihtml5({color: true,html:true});
			
			// select box validations -
			$('#send_email_form').on('submit', function(e) 
			{
				e.preventDefault();
			
				$('#msg1').text('');
				
				if($('#patient_id').val() == '' || $('#patient_id').val() == null)
				{
					$('#msg1').text('This field is required');
					return false;
				}
				
				// check if this patient having email id -
				if($('#patient_email').val() == '')
				{
					alert("Email id for this Patient is not present.");
					return false;
				}
				
				//data to be sent to server        
				var m_data = new FormData();   
				 
				m_data.append( 'patient_id', $('select[name=patient_id]').val());
				m_data.append( 'patient_email', $('input[name=patient_email]').val());
				m_data.append( 'email_subject', $('input[name=email_subject]').val());
				m_data.append( 'msg', $('textarea[name=msg]').val());
				m_data.append( 'attachment_file_name', $('input[name=attachment_file_name]')[0].files[0]);
				
				// check if CC checkbox checked -
				if($('input[name=is_cc]').is(':checked'))
				{
					m_data.append( 'is_cc', $('input[name=is_cc]').val());
				}
				 
				$.ajax({
						url: '<?php echo base_url(); ?>index.php/email/send',
						data: m_data,
						processData: false,
						contentType: false,
						type: 'POST',
						dataType:'json',
						success: function(response){
						
							//alert(response);
							
							if(response)
							{
								//alert('Email Sent Successfully.');
								
								$("#email_sent_msg p").text('Email Sent Successfully.');
								$("#email_sent_msg").removeClass('alert-danger').addClass('alert-success').show();
								
								// redirect to list page after 5 seconds -
								setTimeout("window.location.href = '<?php print base_url(); ?>index.php/email';", 5000);
							}
							else
							{	
								//alert('Email Sent Error.');
								
								$("#email_sent_msg p").text('Email Sent Error.');
								$("#email_sent_msg").removeClass('alert-success').addClass('alert-danger').show();
								
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
						url: "<?php print base_url(); ?>index.php/email/get_patient_email",
						type: "post",
						async:false,
						cache:false,
						//dataType:'json',
						data:{ patient_id:patient_id },
						success: function (res) 
						{
							//alert(res);
							
							// check if email is present -
							if(res != 0)
							{
								//alert(res);
								
								// append email id to field -
								$("#patient_email").val(res);
							}
							else
							{
								alert("Email id for this Patient is not present.");
								
								$("#patient_email").val('');
							}
						}
				});
				
			});
		
		}); 
	</script>
	
    </body>
</html>