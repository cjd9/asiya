<?php $this->load->view('p_include/header'); ?>
        
	<?php $this->load->view('p_include/left'); ?>
                
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Dashboard</li>
                                </ul>
                                <h4>Dashboard</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->
                    
                    <div class="contentpanel">
					
                     <?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

						<br /><br />

                        <div align="center">
							<!--<p><img src="<?php echo base_url(); ?>images/logo-1.jpg" height="50" width="60"/></p>-->
							<h1><b>WELCOME</b></h1>
							<h4><b>To</b></h4>
							<h1><b>Asiya Center of Physiotherapy & Rehabilitation</b></h1>
						</div>
                    
                    </div><!-- contentpanel -->
                    
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('p_include/footer'); ?>
	
    </body>
</html>