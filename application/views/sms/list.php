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
                                    <li>SMS</li>
                                </ul>
                                <h4>SMS</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->

					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete SMS</h4>
								</div>
								<div class="modal-body">
									You want to delete this record ?
									<input type="hidden" name="delete_pk" id="delete_pk" value="" />
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_2()">Yes</button>
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

                   <div class="contentpanel">
                      	 <a href="<?php print base_url(); ?>index.php/sms/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Send SMS</button>
						 </a>
					   <br /><br />

					   	<div class="alert alert-success" style="display:none" id="email_sent_msg">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
							<p>Email Sent Successfully.</p>
						</div>

                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>SMS</b></h4>
                            </div><!-- panel-heading -->
                           <br />

							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

                            <div class="table-responsive">

							<table id="basicTable" class="table table-striped table-bordered">
                                <thead class="">
                                    <tr>
                                        <th>#</th>
										<th>Patient ID</th>
                                        <th>Patient Name</th>
                                        <th>Sent By</th>
										<th>Sent On</th>
										<th><div align="center">Status</div></th>
										<th><div align="center">Action</div></th>
                                    </tr>
                                </thead>

                                <tbody>
								<?php $cnt = 0; foreach($rssms->result() as $row) : ?>
								   <tr>
										<td align="center"><?php echo ++$cnt; ?></td>
                                        <td><?php echo $row->patient_id; ?></td>
                                        <td>
											<?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo ucwords($row1->p_fname.' '.$row1->p_lname); ?>
										</td>
                                        <td><?php $r = $this->db->get_where('staff_details', array('pk' => $row->sent_by))->row(); echo $r->s_fname.' '.$r->s_lname; ?></td>
										<td><?php echo $row->sent_on; ?></td>
										<!--<td class="text-center"><?php if($row->sms_status == 'S') { echo '<span class="label label-success status">Sent</span>'; } else { echo '<span class="label label-danger status">Pending</span>'; } ?></td>-->
										<td class="text-center"><strong><?php echo $row->sms_status; ?></strong></td>
                                        <td>
											<div align="center">
												<a href="<?php print base_url(); ?>index.php/sms/view/<?php echo $row->pk; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg">
										     		<i class="fa fa-search"></i> View
										    	</a>

												<button class="btn btn-info btn-sm" onclick="resend_sms(<?php echo $row->pk; ?>)">
													<i class="fa fa-send"></i> Resend
												</button>

												<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal_delete" onclick="delete_1(<?php echo $row->pk; ?>)">
													<i class="fa fa-trash-o"></i> Delete
												</button>
											</div>
									 	</td>
                                  </tr>
									<?php endforeach ; ?>
								</tbody>
                            </table>
							</div>

							<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
            					<div class="modal-dialog modal-lg">
									<div class="modal-content">

									</div>
								</div>
							</div>

                        </div><!-- panel -->

                    </div><!-- contentpanel -->

                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>

	 <script>
	 	// function to resen sms to patient -
		function resend_sms(id)
		{
			var res = confirm("You want to Re-Send SMS to this Patient?");

			if(res)
			{
				$.ajax({
						url: "<?php print base_url(); ?>index.php/sms/resend_sms",
						type: "post",
						async:false,
						cache:false,
						//dataType:'json',
						data:{ id:id },
						success: function (res)
						{
							//alert(res);

							// check if sms sent successfully -
							if(res)
							{
								//alert('SMS Sent Successfully.');

								$("#sms_sent_msg p").text('SMS Re-Sent Successfully.');
								$("#sms_sent_msg").removeClass('alert-danger').addClass('alert-success').show();

								// redirect to list page after 5 seconds -
								setTimeout("window.location.href = '<?php print base_url(); ?>index.php/sms';", 5000);
							}
							else
							{
								//alert('SMS Sent Error.');

								$("#sms_sent_msg p").text('SMS Re-Sent Error.');
								$("#sms_sent_msg").removeClass('alert-success').addClass('alert-danger').show();

								return false;
							}
						}
				});
			}
			else
			{
				return false;
			}
		}

		// assign delete id to hidden field
		function delete_1(id)
		{
			$('#delete_pk').val(id);
		}
		// delete record
		function delete_2()
		{
			var id = $('#delete_pk').val();
			window.location = "<?php echo $deleteaction; ?>/"+id;
		}
	</script>

    </body>
</html>
