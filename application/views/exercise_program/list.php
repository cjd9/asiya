<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-child"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Exercise Program</li>
                                </ul>
                                <h4>Exercise Program</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					<!-- Modal -->
					<div class="modal fade" id="myModal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
									<h4 class="modal-title" id="myModalLabel">Delete Exercise Program details</h4>
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
                      	 <a href="<?php print base_url(); ?>index.php/exercise_program/add">
					  	 	<button class="btn btn-primary"><i class="fa fa-pencil"></i> Add Exercise</button>
						 </a>
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Exercise Program</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
														
                            <div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th>#</th>
											<th>Upload Date</th>
											<th>Patient ID</th>
											<th>Patient Name</th>
											<th>Patient Gender</th>
											<th>Expiry Date</th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
									
									<tbody>
									<?php $cnt = 0; foreach($rsexercise_program->result() as $row) : ?>
										<tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo date("d-m-Y",strtotime($row->date_of_upload)); ?></td>
											<td><?php echo $row->patient_id; ?></td>
											<td>
											<?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo ucwords($row1->p_fname.' '.$row1->p_lname); ?>
											</td>
											<td><?php echo $row1->p_gender; ?></td>
											<td><?php echo date("d-m-Y",strtotime($row->expiry_date)); ?></td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>index.php/exercise_program/view/<?php echo $row->exercise_id; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg">
														<i class="fa fa-search"></i> View
													</a>
													
													<a href="<?php print base_url(); ?>index.php/exercise_program/edit/<?php echo $row->exercise_id; ?>" class="btn btn-info btn-sm">
														<i class="fa fa-edit"></i> Edit									        
													</a>
													
													<button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal_delete" onclick="delete_1('<?php echo $row->exercise_id; ?>')">
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