<?php $this->load->view('include/header'); ?>

	<?php $this->load->view('include/left'); ?>

                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-download"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-download"></i></a></li>
                                    <li>Import Festivals</li>
                                </ul>
                                <h4>Import Festivals</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->

                    <div class="contentpanel">


						<br /><br />

                     	<?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

                        <div class="row">
							<div class="col-md-12">
								<form id="database_restore_form" action="<?php echo base_url(); ?>festival/import_cal" method="post" enctype="multipart/form-data">

								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="panel-btns">
										</div><!-- panel-btns -->
										<h3 class="panel-title"><i class="glyphicon glyphicon-upload"></i> <b>Import iCal Calendar</b></h3>
                    <h5 class="alert alert-info"><b>Note</b>* :Download ical from <a target="_blank" href="https://www.calendarlabs.com/ical-calendar/holidays/"> this link </a> <b>ONLY</b> for Indian holidays.</h5>
									</div><!-- panel-heading -->

									<div class="panel-body">
										<div class="row">

											<div class="form-group">
												<label class="col-md-3 control-label"> Select File<span class="asterisk">*</span></label>
												<div class="col-sm-6">
													<input type="file" id="ical" accept=".ics" name="ical" class="form-control" />
												</div>
											</div><!-- form-group -->

										</div><!-- row -->
									</div><!-- panel-body -->

									<div class="panel-footer">
									  <div class="row">
										<div class="col-sm-7 col-sm-offset-4">
											<button class="btn btn-primary mr5">Submit</button>
											<!--<a href="http://localhost/doctor_portal/admin/index.php/education_program" class="btn btn-dark">Cancel</a>-->
										</div>
									  </div>
									</div><!-- panel-footer -->
								</div><!-- panel -->
								</form>

							</div><!-- col-md-6 -->
						</div><!--row -->

                    </div><!-- contentpanel -->

                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>

	<?php $this->load->view('include/footer'); ?>

    </body>
</html>
<script>
$(function () {
        $('input[type=file]').change(function () {
            var val = $(this).val().toLowerCase(),
                regex = new RegExp("(.*?)\.(ics)$");

            if (!(regex.test(val))) {
                $(this).val('');
                alert('Please selectonly .ics file format');
            }
        });
    });
</script>
