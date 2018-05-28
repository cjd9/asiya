<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-volume-up"></i>
                            </div>
                            <div class="media-body">
                                <!--<ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Education Program</li>
                                </ul>-->
                                <h4>SAMVAAD</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
					
					
                   <div class="contentpanel">
                     
					   <br /><br />
							
                        <div class="panel panel-primary-head">
                            <div class="panel-heading">
                                <h4 class="panel-title"><b>SAMVAAD</b></h4>
                            </div><!-- panel-heading -->
                           <br />
						    
							<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>
														
                            <div class="table-responsive">
								<table id="basicTable" class="table table-striped table-bordered">
									<thead class="">
										<tr>
											<th><div align="center">#</div></th>
											<th width="">Program Description</th>
											<th>Program File</th>
											<th><div align="center">Comment</div></th>
										</tr>
									</thead>
							 
									<tbody>
									<?php $cnt = 0; foreach($rseducation_program->result() as $row) : ?>
									   <tr>
											<td align="center"><?php echo ++$cnt; ?></td>
											<td><?php echo wordwrap($row->education_program_desc,80,"<br>\n",TRUE); ?></td>
											<td>
												<a href="<?php echo base_url().'education_program_file/'.$row->education_program_file; ?>" target="_blank">
													<?php echo $row->education_program_file; ?>												
												</a>											
											</td>
											<td>
												<div align="center">
													<a href="<?php print base_url(); ?>p_samvaad/comment_box/<?php echo $row->pk; ?>"  class="btn btn-sm btn-bordered btn-default" data-toggle="modal" data-target=".bs-example-modal-lg">
												  	<i class="fa fa-comments"></i> Comment
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
      
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('p_include/footer'); ?>
	
    </body>
</html>