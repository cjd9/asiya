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
										 <div class="panel-heading" style="background-color: #8cac35; color: white;">
                                 <h4 class="panel-title text-center"><b><?php echo $view['title']?></b></h4>
                     </div><!-- panel-heading -->
                     <div class="panel-body">
                        <div class="col-md-9">
					   <p><?php echo $view['education_program_desc']?></p>
                        </div>
                        <div class="col-md-3">
                            <img src="/education_thumbnail/<?php echo $view['thumbnail']  ?>" onerror="this.src='/images/logo-new.png';" alt="Avatar" style="width: 100%">

                        </div>
      				  </div>
                        <div class="form-group"><!-- Start form-group -->
                                                <div class="col-sm-8">
                                                    <label class="col-sm-3">Attachments</label>
                                                    <div class="col-sm-5 table-responsive">
                                                        <table class="table table-striped table-bordered">
                                                            <tr style="text-align:center">
                                                                <th>File Name</th>
                                                            </tr>
                                                            <?php $view['education_program_file'] = explode(",",$view['education_program_file']); foreach($view['education_program_file']  as $r2) { ?>
                                                            <tr>
                                                                <td>
                                                                    <a href="<?php echo base_url().'education_program_file/'.$r2 ?>" target="_blank">
                                                                        <?php echo $r2 ?>
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                            <?php } ?>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div><!-- End form-group -->
                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>
			</div><!-- contentpanel -->


	<?php $this->load->view('p_include/footer'); ?>

    </body>
</html>
