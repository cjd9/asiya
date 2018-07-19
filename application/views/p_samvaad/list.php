<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>
         <style>
               .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px; /* 5px rounded corners */
            height: 175px;
        }

        /* Add rounded corners to the top left and the top right corner of the image */
        img {
            border-radius: 5px 5px 0 0;
        }
       </style>
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
			                              <img src="/education_thumbnail/<?php echo $row->thumbnail;  ?>" onerror="this.src='/images/Asiya.png';" alt="Avatar" style="width: 100%">
			                            </div>
			                            <div class="col-sm-6" >
			                            	<h6 class=""><b><?php echo $row->title; ?></b></h6>

											<p class=""><?php echo substr(strip_tags($row->education_program_desc), 0, 50);  ?></p>
											<a class="btn btn-primary" href="/p_samvaad/view/<?php echo $row->pk; ?>">Read more>> </a>
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