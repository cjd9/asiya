<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-child"></i>
                            </div>
                            <div class="media-body">
                                <!--<ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Exercise Program</li>
                                </ul>-->
                                <h4>Exercise Program</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					<?php 
						if($rsexercise_program->num_rows() > 0)
						{
					?>
                    
                   <div class="contentpanel">
                      	
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
											<!--<th>Uploaded Date</th>-->
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
											<!--<td><?php echo date("d-m-Y",strtotime($row->date_of_upload)); ?></td>-->
											<td><?php echo $row->patient_id; ?></td>
											<td>
											<?php $row1 = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row(); echo ucwords($row1->p_fname.' '.$row1->p_lname); ?>
											</td>
											<td><?php echo $row1->p_gender; ?></td>
											<td><?php echo date("d-m-Y",strtotime($row->expiry_date)); ?></td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>exercise_program/view/<?php echo $row->exercise_id; ?>" class="btn btn-success btn-sm mr5" data-toggle="modal" data-target=".bs-example-modal-lg">
														<i class="fa fa-search"></i> View Details
													</a>
													
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
      					<?php
							}
							else
							{	
						?>
							<div class="horizontally">
								<div class="inner">
									<img src="<?php print base_url(); ?>images/bee.gif" height="200px"/>
									<!--<img src="http://www.html.am/images/html-codes/marquees/bee.gif" alt="Buzzy bee">-->
								</div>
							</div>

							<h1 align="center"><b>No Exercise Record Found.</b></h1>';
						<?php
							}
						?>
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('p_include/footer'); ?>
	
    </body>
</html>