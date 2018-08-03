<?php #print_r($logs->result()); die;?>
<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>

                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-hospital-o"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Logs</li>
                                </ul>
                                <h4>Logs</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->

					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete Logs details</h4>
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



                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Logs</b></h4>
                            </div><!-- panel-heading -->
                           <br />

							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

                            <div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>

											<th>Date</th>
											<th>Title</th>
											<th>Patient ID</th>
											<th>Patient Name</th>
											<th>Sms</th>
											<th>Email</th>
											<th>Sms Sent</th>
											<th>Email Sent</th>

										</tr>
									</thead>

									<tbody>
									<?php $cnt = 0; foreach($logs->result() as $row) : ?>
									   <tr>
											<td><?php echo date(('d-m-Y H:i:s'),strtotime($row->date_created)); ?></td>
											<td>
												<?php echo $row->title; ?>
											</td>
											<td>
												<?php echo $row->patient_id; ?>
											</td>
											<td>
												<?php echo $row->patient_name; ?>
											</td>
											<td>
											   <?php echo $row->sms; ?>
										    </td>
										    <td>
											   <?php echo $row->email; ?>
										    </td>
										    <td>
											   <?php echo $row->sms_sent; ?>
										    </td>
										    <td>
											   <?php echo $row->email_sent; ?>
										    </td>
									  </tr>
									<?php endforeach ; ?>
									</tbody>
								</table>
							</div>

                        </div><!-- panel -->

                    </div><!-- contentpanel -->

                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>

	 <script>
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
