

                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><i class="glyphicon glyphicon-home"></i></li>
                                    <li>Patient List</li>
                                </ul>
                                <h4>Patient List</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->

					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
									<h4 class="modal-title" id="myModalLabel">Delete Patient details</h4>
								</div>
								<div class="modal-body">
									You want to delete this record ?
									<input type="hidden" name="delete_pk" id="delete_pk" value="" />
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
									<button type="button" class="btn btn-primary" data-dismiss="modal" onclick="delete_2()">Yes</button>
								</div>
							</div>
							<!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					</div>
					<!-- /.modal -->

                   <div class="contentpanel">
                      	 <a href="<?php print base_url(); ?>contact_list/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Patient Registration</button>
						 </a>
					   <br /><br />

                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Patient List</b></h4>
                            </div><!-- panel-heading -->
                           <br />

							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

              <div align="right" class="<?php echo $this->session->userdata('user_type') == 'A'? '' : 'hide' ?>">
                  <a href="<?php print base_url(); ?>index.php/contact_list/export">
                  <button class="btn btn-warning"><b><i class="glyphicon glyphicon-download"></i> Export</b></button>
                </a>
              </div>

         <div class="table-responsive">

							<div align="center">
							<!-- 	<form id="search_patient_form" action="<?php echo base_url().'contact_list'; ?>" method="post">
								<div class="form-group">

										<label class="col-sm-4 control-label" style="text-align:right"><b> Search Patient : </b></label>
										<div class="col-sm-3">
											<input type="text" class="form-control validate[required]" name="contact_no" id="contact_no" value="" placeholder="Enter Patient Mobile No.">
										</div>

										<div class="col-sm-2">
											<button class="btn btn-success btn-bordered" name="search_patient" id="search_patient"> <i class="fa fa-search"></i> <b> Search </b> </button>
										</div>

								</div><!-- form-group -->
								</form> -->
							</div><!-- panel -->

							<hr />

						   	<?php if(isset($contact_no)) { ?>

							<table id="basicTable1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                   		<th>Patient ID</th>
                                        <th>Patient Name</th>
										<th>Patient Gender</th>
										<th>Contact No.</th>
										<th><div align="center">Status</div></th>
										<th>Cur. Shared With Staff</th>
										<th><div align="center">Action</div></th>
                                    </tr>
                                </thead>

                                <tbody>
								<?php foreach($rscontact_list->result() as $row) : ?>
								   <tr>
										<td><?php echo $row->patient_id; ?></td>
                                        <td><?php echo ucwords($row->p_fname.' '.$row->p_mname.' '.$row->p_lname); ?></td>
										<td><?php echo $row->p_gender; ?></td>
										<td><?php echo $row->p_contact_no; ?></td>
										<td class="text-center"><?php if($row->p_status == 'A') { echo '<span class="label label-success status" id="'.$row->pk.'">Active</span>'; } else { echo '<span class="label label-danger status" id="'.$row->pk.'">Inactive</span>'; } ?></td>
										<td>
											<?php
												// get staff id currently attending patient -
												$staff_id = $this->db->get_where('staff_patient_master', array('patient_id' => $row->patient_id))->row()->current_assign_staff_id;

												// get staff name -
												$r = $this->db->get_where('staff_details', array('pk' => $staff_id))->row();
												echo $r->s_fname.' '.$r->s_lname;
											?>
										</td>
										<td align="center">
											<div class="form-group">
												<button class="btn btn-info btn-bordered btn-sm btn_follow"> <i class="fa fa-share-square-o"></i> <b> Follow </b> </button>
											</div>

											<input type="hidden" name="patient_id" id="" class="patient_id" value="<?php echo $row->patient_id; ?>" />
									 	</td>
                                  </tr>
									<?php endforeach ; ?>
								</tbody>
                            </table>

							<?php } else { ?>

							<table id="basicTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
										<th>Patient ID</th>
										<th>Patient Password</th>
                                        <th>Patient Name</th>
										<th>Contact No.</th>
										<th><div align="center">Status</div></th>
										<th><div align="center">Share</div></th>
										<th><div align="center">Action</div></th>
                                    </tr>
                                </thead>

                                <tbody>
								<?php $cnt = 0; foreach($rscontact_list->result() as $row) : ?>
								   <tr>
										<td align="center"><?php echo ++$cnt; ?></td>
                                        <td><?php echo $row->patient_id; ?></td>
										<td><?php echo $row->p_password; ?></td>
                                        <td><?php echo ucwords($row->p_fname.' '.$row->p_mname.' '.$row->p_lname); ?></td>
										<td><?php echo $row->p_contact_no; ?></td>
										<td class="text-center"><?php if($row->p_status == 'A') { echo '<span class="label label-success status" id="'.$row->pk.'">Active</span>'; } else { echo '<span class="label label-danger status" id="'.$row->pk.'">Inactive</span>'; } ?></td>
										<td align="center">
											<div class="form-group btn_share1">
												<button class="btn btn-warning btn-bordered btn-sm"> <i class="fa fa-share"></i> Share </button>
											</div>

											<div class="form-group col-sm-8 staff_field" style="display:none;">
												<select id="" name="assign_staff_id" data-placeholder="Choose Staff" class="select2-container width100p assign_staff_id">
													<option value=""></option>
													<?php
														foreach ($rsstaff_list->result() as $r)
														{
															echo "<option value='".$r->pk."'>".$r->s_fname.' '.$r->s_mname.' '.$r->s_lname."</option>";
														}
													?>
												</select>
											</div>

											<button class="btn btn-primary btn-sm btn_share2" style="display:none"> <i class="fa fa-check"></i> </button>

											<button class="btn btn-dark btn-sm btn_share3" style="display:none"> <i class="fa fa-times"></i> </button>

											<input type="hidden" name="patient_id" id="" class="patient_id" value="<?php echo $row->patient_id; ?>" />
									 	</td>
                                        <td align="center">

										   	<a href="<?php print base_url(); ?>contact_list/view/<?php echo $row->pk; ?>" class="btn btn-success btn-sm mr5" >
										     <i class="fa fa-search"></i> View
										    </a>

										    <a href="<?php print base_url(); ?>contact_list/print_patient_details/<?php echo $row->pk; ?>" class="btn btn-primary btn-sm">
										        <i class="fa fa-print"></i> Print
											</a>

										    <a href="<?php print base_url(); ?>contact_list/edit/<?php echo $row->pk; ?>" class="btn btn-info btn-sm">
										         <i class="fa fa-edit"></i> Edit
											</a>

                      <a class="btn btn-warning btn-sm <?php echo $this->session->userdata('user_type') == 'A'? '' : 'hide' ?>" data-toggle="modal" data-target="#myModal_delete" onclick="delete_1(<?php echo $row->pk; ?>)">
                      <i class="fa fa-trash-o"></i> Delete
                    </a>

											<!--<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal_delete" onclick="delete_1(<?php echo $row->pk; ?>)">
												<i class="fa fa-trash-o"></i> Delete
											</button>-->

										</td>
                                  </tr>
									<?php endforeach ; ?>
								</tbody>
                            </table>

							<?php } ?>

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


	 <script>

	</script>

    </body>
</html>
