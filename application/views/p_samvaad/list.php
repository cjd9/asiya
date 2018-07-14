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
														
                            
							 
									<?php $cnt = 0; foreach($rseducation_program->result() as $row) : ?>
									 <div class="card col-md-4" >
									 	<div class="col-sm-6" >
			                              <img src="/education_thumbnail/<?php echo $row->thumbnail;  ?>" onerror="this.src='/images/logo-new.png';" alt="Avatar" style="width: 100%">
			                            </div>
			                            <div class="col-sm-6" >
			                            	<h6 class=""><b><?php echo $row->title; ?></b></h6>

											<p class=""><?php echo substr(strip_tags($row->education_program_desc), 0, 100);  ?></p>
											<a href="/p_samvaad/view/<?php echo $row->pk; ?>">Read more>>> </a>
			                            </div>
			                              </div>
									  
									<?php endforeach ; ?>
								
							
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