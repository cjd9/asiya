<div class="modal fade" id="myModal_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title" id="myModalLabel">Profile Setting</h4>
      </div>
      <div class="modal-body">
        <form id="edit_staff_form" action="<?php echo base_url(); ?>login/edit_profile" method="post" enctype="multipart/form-data" onSubmit="">
        <input type="hidden" name="edit_pk" id="edit_pk"  value="<?php echo $r->pk; ?>"/>

          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label">Name</label>
              <div class="col-sm-3">
                <input type="text" id="s_fname" name="s_fname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_fname; ?>"/>
              </div>
              <div class="col-sm-3">
                <input type="text" id="s_mname" name="s_mname" class="form-control" value="<?php echo $r->s_mname; ?>"/>
              </div>
              <div class="col-sm-3">
                <input type="text" id="s_lname" name="s_lname" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_lname; ?>"/>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-4 control-label">Date Of Birth</label>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                  <input type="text" class="form-control datepicker" name="s_dob" id="s_dob" value="<?php echo date("d-m-Y",strtotime($r->s_dob)); ?>">
                </div><!-- input-group -->
              </div>
            </div>
          </div><!-- form-group -->

          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label">Gender<span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <select id="select-templating1" name="s_gender" data-placeholder="Choose One" class="select2-container width100p">
                  <option value="">Choose One</option>
                  <option value="Male" <?php if($r->s_gender == "Male") { ?> selected="selected" <?php } ?>>Male</option>
                  <option value="Female" <?php if($r->s_gender == "Female") { ?> selected="selected" <?php } ?>>Female</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-4 control-label">Religion<span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <select id="s_religion_id" name="s_religion_id" data-placeholder="Choose Religion " class="select2-container width100p">
                  <option value=""></option>
                  <?php
                    foreach ($rsreligion->result() as $r1)
                    {
                  ?>
                  <option value="<?php echo $r1->pk; ?>" <?php if($r1->pk == $r->s_religion_id) { ?> selected="selected" <?php } ?>><?php echo $r1->religion; ?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
            </div>
          </div><!-- form-group -->

          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label"> Photo <span class="asterisk">*</span></label>
              <div class="col-sm-9">
                <input type="file" id="staff_photo" name="staff_photo" class="form-control" value="" />
              </div>
            </div>
          </div><!-- form-group -->

          <h4>Contact Details</h4><hr />

          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label">Email<span class="asterisk">*</span></label>
              <div class="col-sm-9">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                  <input type="email" id="s_email_id" name="s_email_id" class="form-control" value="<?php echo $r->s_email_id; ?>"/>
                </div><!-- input-group -->
              </div>
            </div>

            <div class="col-sm-6">
              <label class="col-sm-4 control-label">Contact No.<span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
                  <input type="text" id="s_contact_no" name="s_contact_no" class="form-control" maxlength="10" value="<?php echo $r->s_contact_no; ?>"/>
                </div><!-- input-group -->
              </div>
            </div>
          </div><!-- form-group -->

          <h4>Address Details</h4><hr />

          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label">Address<span class="asterisk">*</span></label>
              <div class="col-sm-9">
                <textarea rows="2" name="s_address" id="s_address" class="form-control validate[required]"><?php echo $r->s_address; ?></textarea>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-sm-4 control-label">City<span class="asterisk">*</span></label>
                <div class="col-sm-6">
                  <input type="text" id="s_city" name="s_city" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_city; ?>"/>
                </div>
              </div><!-- form-group -->
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-sm-4 control-label">State<span class="asterisk">*</span></label>
                <div class="col-sm-6">
                  <input type="text" id="s_state" name="s_state" class="form-control validate[required],custom[onlyLetterSp]" value="<?php echo $r->s_state; ?>"/>
                </div>
              </div><!-- form-group -->
            </div>
          </div><!-- form-group -->


          <div class="form-group">
            <div class="col-sm-6">
              <label class="col-sm-3 control-label">Zip<span class="asterisk">*</span></label>
              <div class="col-sm-6">
                <input type="text" id="s_zip" name="s_zip" class="form-control" maxlength="7" value="<?php echo $r->s_zip; ?>"/>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-sm-4 control-label">Upload Resume<span class="asterisk">*</span></label>
                <div class="col-sm-6">
                  <input type="file" id="staff_resume" name="staff_resume" class="form-control" />
                </div>
              </div><!-- form-group -->
            </div>
          </div><!-- form-group -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Profile</button> &nbsp;
            <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal-Profile -->
