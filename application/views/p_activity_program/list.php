<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-gears"></i>
                            </div>
                            <div class="media-body">
                               <!-- <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Activity Program</li>
                                </ul>-->
                                <h4>Activity Program</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					<?php 
						if($rsactivity_program->num_rows() > 0)
						{
					?>
                    
                   <div class="contentpanel">
                      	
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>Activity Program</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
														
                            <div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th><div align="center">#</div></th>
											<th>Activity</th>
											<th><div align="center">Action</div></th>
										</tr>
									</thead>
									
									<tbody>
									<?php $unique=array(); $cnt = 0; foreach($rsactivity_program->result() as $row) : ?>
									<?php if(!in_array($row->activity_id,$unique)){ $unique[] =$row->activity_id ; ?>										<tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo wordwrap($row->activity_program,200,"<br>\n",TRUE); ?></td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>p_activity_program/view/<?php echo $row->activity_id; ?>" class="btn btn-success btn-sm mr5" >
														<i class="fa fa-search"></i> View Details
													</a>
													
												</div>
											</td>
										</tr>
									<?php } endforeach ; ?>
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

							<h1 align="center"><b>No Activity Record Found.</b></h1>';
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