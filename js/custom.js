var imageCount=0;
var jcrop_api, profile_pic_xhr;
var minimumProfilePicSize = 200 * 200;
var profilePicMinCropSize = {width: 200, height: 200};
var toastrShowDuration = 2000;
var teethGroupNumber = 1;

jQuery(document).ready(function() {

   "use strict";

   // Tooltip
   jQuery('.tooltips').tooltip({ container: 'body'});

   // Popover
   jQuery('.popovers').popover();

   // Show panel buttons when hovering panel heading
   jQuery('.panel-heading').hover(function() {
      jQuery(this).find('.panel-btns').fadeIn('fast');
   }, function() {
      jQuery(this).find('.panel-btns').fadeOut('fast');
   });

   // Close Panel
   jQuery('.panel .panel-close').click(function() {
      jQuery(this).closest('.panel').fadeOut(200);
      return false;
   });

   // Minimize Panel
   jQuery('.panel .panel-minimize').click(function(){
      var t = jQuery(this);
      var p = t.closest('.panel');
      if(!jQuery(this).hasClass('maximize')) {
         p.find('.panel-body, .panel-footer').slideUp(200);
         t.addClass('maximize');
         t.find('i').removeClass('fa-minus').addClass('fa-plus');
         jQuery(this).attr('data-original-title','Maximize Panel').tooltip();
      } else {
         p.find('.panel-body, .panel-footer').slideDown(200);
         t.removeClass('maximize');
         t.find('i').removeClass('fa-plus').addClass('fa-minus');
         jQuery(this).attr('data-original-title','Minimize Panel').tooltip();
      }
      return false;
   });

   jQuery('.leftpanel .nav .parent > a').click(function() {

      var coll = jQuery(this).parents('.collapsed').length;

      if (!coll) {
         jQuery('.leftpanel .nav .parent-focus').each(function() {
            jQuery(this).find('.children').slideUp('fast');
            jQuery(this).removeClass('parent-focus');
         });

         var child = jQuery(this).parent().find('.children');
         if(!child.is(':visible')) {
            child.slideDown('fast');
            if(!child.parent().hasClass('active'))
               child.parent().addClass('parent-focus');
         } else {
            child.slideUp('fast');
            child.parent().removeClass('parent-focus');
         }
      }
      return false;
   });


   // Menu Toggle
   jQuery('.menu-collapse').click(function() {
      if (!$('body').hasClass('hidden-left')) {
         if ($('.headerwrapper').hasClass('collapsed')) {
            $('.headerwrapper, .mainwrapper').removeClass('collapsed');
         } else {
            $('.headerwrapper, .mainwrapper').addClass('collapsed');
            $('.children').hide(); // hide sub-menu if leave open
         }
      } else {
         if (!$('body').hasClass('show-left')) {
            $('body').addClass('show-left');
         } else {
            $('body').removeClass('show-left');
         }
      }
      return false;
   });

   // Add class nav-hover to mene. Useful for viewing sub-menu
   jQuery('.leftpanel .nav li').hover(function(){
      $(this).addClass('nav-hover');
   }, function(){
      $(this).removeClass('nav-hover');
   });

   // For Media Queries
   jQuery(window).resize(function() {
      hideMenu();
   });

   hideMenu(); // for loading/refreshing the page
   function hideMenu() {

      if($('.header-right').css('position') == 'relative') {
         $('body').addClass('hidden-left');
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      } else {
         $('body').removeClass('hidden-left');
      }

      // Seach form move to left
      if ($(window).width() <= 360) {
         if ($('.leftpanel .form-search').length == 0) {
            $('.form-search').insertAfter($('.profile-left'));
         }
      } else {
         if ($('.header-right .form-search').length == 0) {
            $('.form-search').insertBefore($('.btn-group-notification'));
         }
      }
   }

   collapsedMenu(); // for loading/refreshing the page
   function collapsedMenu() {

      if($('.logo').css('position') == 'relative') {
         $('.headerwrapper, .mainwrapper').addClass('collapsed');
      } else {
         $('.headerwrapper, .mainwrapper').removeClass('collapsed');
      }
   }


   //Conatct list js

   $(document).ready(function()
      {
         // form Validation
         //$("#search_patient_form").validationEngine({promptPosition: "topRight: -100"});

         // show staff field to share -
         $('.btn_share1').on('click', function() {

            $(this).hide();

            $(this).next(".staff_field").show();
            $(this).next(".staff_field").next(".btn_share2").show();
            $(this).next(".staff_field").next().next(".btn_share3").show();
         });

         // share selected patient with selected staff -
         $('.btn_share2').on('click', function() {

            var assign_staff_id = $(this).parent("td").find("select.assign_staff_id").val();

            if(assign_staff_id == '' || assign_staff_id == null)
            {
               alert("Please Select Staff to Share Patient.");
               return false;
            }
            else
            {
               var ans = confirm("You Want to Share this Patient?");

               if(ans)
               {
                  var patient_id =  $(this).parent("td").find(".patient_id").val();

                  //alert(assign_staff_id);
                  //alert(patient_id);

                  // get patient's contact no. using ajax -
                  $.ajax({
                        url: "/contact_list/share_patient",
                        type: "post",
                        async:false,
                        cache:false,
                        //dataType:'json',
                        data:{ assign_staff_id:assign_staff_id, patient_id:patient_id },
                        success: function (res)
                        {
                           // check if patient successfully shared -
                           if(res != 0)
                           {
                              alert("Patient Shared Successfully.");

                              // submit hidden form to load same page with staff patient list -
                              window.location = "/contact_list";
                           }
                        }
                  });
               }
               else
               {
                  return false;
               }
            }

         });

         // hide sharing field -
         $('.btn_share3').on('click', function() {

            $(this).parent("td").find(".staff_field").hide();
            $(this).parent("td").find(".btn_share2").hide();
            $(this).parent("td").find(".btn_share3").hide();

            $(this).parent("td").find(".btn_share1").show();
         });

         // follow selected patient with current login staff -
         $('.btn_follow').on('click', function() {

            var ans = confirm("You Want to Follow this Patient?");

            if(ans)
            {
               var patient_id =  $(this).parent("div").next(".patient_id").val();

               //alert(patient_id);

               $.ajax({
                     url: "<?php print base_url(); ?>index.php/contact_list/follow_patient",
                     type: "post",
                     async:false,
                     cache:false,
                     //dataType:'json',
                     data:{ patient_id:patient_id },
                     success: function (res)
                     {
                        // check if patient successfully shared -
                        if(res != 0)
                        {
                           alert("Patient Added to Contact List Successfully.");

                           // submit hidden form to load same page with staff patient list -
                           window.location = "<?php echo base_url().'index.php/contact_list'; ?>";
                        }
                     }
               });
            }
            else
            {
               return false;
            }

         });

      });

      // function to update the patient status -
      $("span.status").click( function () {

         var status_field = $(this);

         var patient_status = status_field.text();
         var id = status_field.attr("id");

         //alert(patient_status);
         //alert(id);


         bootbox.confirm({
                title: "Update Patient?",
                message: "You want to Update Status of this Patient?.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Confirm'
                    }
                },
                callback: function (result) {
                    if(result)
                  {
                        $.ajax({
                              url: "/contact_list/update_status",
                              type: "post",
                              async:false,
                              cache:false,
                              //dataType:'json',
                              data:{ id:id, patient_status:patient_status },
                              success: function (res)
                              {
                                 //alert(res);

                                 // check if user status is successfully updated -
                                 if(res != 0)
                                 {
                                    // change the label of status updated -
                                    if(patient_status == 'Active')
                                    {
                                       status_field.text('Inactive').removeClass('label-success').addClass('label-danger');
                                    }
                                    else
                                    {
                                       status_field.text('Active').removeClass('label-danger').addClass('label-success');
                                    }
                                 }
                              }
                        });
                 }
                }
            });



      });

      $(document).on('change', 'input[name="profile_pic"]', function (e) {
       var formID = $(this).closest('form').attr('id');
       console.log($(this).attr('name'));
       profilePicSelectHandler(formID, $(this).attr('name'));
   });

   $(document).on('click', '#cancel-profile-pic-change', function (e) {
       e.preventDefault();

       if (typeof profile_pic_xhr == 'undefined') {
           $('#' + thisFormID + ' input[name="profile_pic"]').val('');
           $('#' + thisFormID + ' .profile-pic-preview-wrapper img').attr('src', $('#' + thisFormID + ' .profile-pic-preview-wrapper img').attr('old-src')).css({
               'max-width': '100%',
               'width': 'auto',
               'margin-left': 0,
               'margin-top': 0,
               'height': 'auto',
           });
           $('#profile-photo-modal').modal('hide');
       } else {
           //abort the ajax for updating profile pic
           profile_pic_xhr.abort();
           $('#save-profile-pic-details').text('Save & Close').removeAttr('disabled');
           profile_pic_xhr = undefined;
       }
   });

   $(document).on('click', '#save-profile-pic-details', function (e) {
       var ele = $(this);

       //check if user has cropped the image before uploading
       if (!$('#' + thisFormID + ' input[name="image-x"]').val()) {
           var message = 'Please crop the image before uploading';
           showToastr(message, 'error', true, 2000);
           return;
       }

       if (typeof $('#' + thisFormID).attr('save-instantly') !== 'undefined') {
           var formData = new FormData(document.getElementById(thisFormID));

           ele.text('Saving...').attr('disabled', 'disabled');

           profile_pic_xhr = $.ajax({
               url: $('#' + thisFormID).attr('action'),
               type: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               complete: function () {
                   ele.text('Save & Close').removeAttr('disabled');
               },
               success: function (response) {
                   $('#profile-photo-modal').modal('hide');
               },
               error: function (response) {
                   showToastr("Error occurred while updating profile picture.", 'error', true, 2000);
               }
           });
       } else {
           $('#profile-photo-modal').modal('hide');
       }

   }

 );
});
 $(window).scroll(function (e) {

    var position = $(window).scrollTop();

    /*if ( $(e.target).is('#main-aside-nav, #main-aside-nav *') ) return false;
     else {
     $('#main-aside-nav').removeClass('active');
     }*/

});

function imageSelectCallback(ele, original_image_src)
{
    ele.siblings('.remove-image').removeClass('hide').find('.expand-image').attr('image-src', original_image_src);
    ele.siblings('.upload-image-wrapper').addClass('hide');


    //ele.parent().siblings('.clinic-image-upload-wrapper').find().first();
}

function resetProfilePicCropArea(destroy_thisFormID) {
    if (typeof jcrop_api !== 'undefined') {
        jcrop_api.destroy();
        jcrop_api = undefined;
        if (destroy_thisFormID)
            thisFormID = undefined;
        $('#profile-pic-crop-area').html('<div style="position:relative;max-width: 100%;margin-right:auto;margin-left:auto;"><img id="profile-pic-preview" src="" style="max-width: 100%;"></div>');
    }
}

function updateCropDetails(e) {
    $('#' + thisFormID + ' input[name="image-x"]').val(e.x);
    $('#' + thisFormID + ' input[name="image-y"]').val(e.y);
    $('#' + thisFormID + ' input[name="image-x2"]').val(e.x2);
    $('#' + thisFormID + ' input[name="image-y2"]').val(e.y2);
    $('#' + thisFormID + ' input[name="crop-w"]').val(e.w);
    $('#' + thisFormID + ' input[name="crop-h"]').val(e.h);

    /*var rW = profilePicMinCropSize.width / e.w;
     var rH = profilePicMinCropSize.height / e.h;
     $('.registration-profile-image').css("background-size", (oW*rW) + "px" + " " + (oH*rH) + "px");
     $('.registration-profile-image').css("background-position", rW * Math.round(e.x) * -1 + "px" + " " + rH * Math.round(e.y) * -1 + "px");*/

    var preview_wrapper_width = $('#' + thisFormID + ' .profile-pic-preview-wrapper').width();
    $('#' + thisFormID + ' .profile-pic-preview-wrapper').width(preview_wrapper_width).height(preview_wrapper_width);
    var rx = preview_wrapper_width / e.w;
    var ry = preview_wrapper_width / e.h;

    $('#' + thisFormID + ' .profile-pic-preview-wrapper img').css({
        width: Math.round(rx * $('#profile-pic-preview').width()) + 'px',
        height: Math.round(ry * $('#profile-pic-preview').height()) + 'px',
        marginLeft: '-' + Math.round(rx * e.x) + 'px',
        marginTop: '-' + Math.round(ry * e.y) + 'px'
    });
}

function profilePicSelectHandler(formID, inputName, onlyPreview)
{
    thisFormID = formID;
    console.log($(this));

//    if (inputName == 'opg_image')
//    {
//
//        var userid = $('#user_id').val();
//        $.ajax({
//            type: 'post',
//            url: HOME_URL + 'treatment/insertOpgImage',
//            data: {
//                'user_id': userid,
//            },
//            success: function (res) {
//
//                image_ele.attr('data-image-src', res);
//                previewImageFromSrc(res, file_input, image_ele, callback);
//
//            }
//
//        });
//    }

    // get selected file
    var oFile = $('#' + thisFormID + ' input[name="' + inputName + '"]')[0].files[0];

    if (typeof oFile == 'undefined')
        return false;

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/bmp|image\/jpg)$/i;
    if (!rFilter.test(oFile.type)) {
        showToastr('Please select a valid image file (jpg, jpg, png, bmp are allowed).', 'error', true, 2000);
        return;
    }

    // destroy Jcrop if it is existed
    resetProfilePicCropArea(false);

    // preview element
    var oImage = document.getElementById('profile-pic-preview');

    // prepare HTML5 FileReader
    var oReader = new FileReader();
    oReader.onload = function (e) {
        // e.target.result contains the DataURL which we can use as a source of the image
        oImage.src = e.target.result;
        oImage.onload = function () { // onload event handler
            // check for image dimensions
            if (oImage.width * oImage.height < minimumProfilePicSize && typeof onlyPreview == 'undefined') {
                showToastr('Please select an image having minimum dimension 200 * 200', 'error', true, 2000);
                this.src = '';
                return;
            } else {
                if (typeof onlyPreview == 'undefined') {
                    $('#profile-photo-modal').modal({
                        backdrop: 'static',
                        keyboard: false
                    }).modal('show');

                    //$('#'+thisFormID).find('.fileupload-preview').html(oFile.name);

                    $('#' + thisFormID + ' input[name^="image-"]').val('');
                    $('#' + thisFormID + ' input[name^="crop-"]').val('');

                    //hide avatar holder
                    $('#avatar-holder').hide();
                    $('#profile-pic-crop-area').show();

                    setTimeout(function () {
                        // initialize Jcrop
                        $('#profile-pic-crop-area div').Jcrop({
                            minSize: [profilePicMinCropSize.width, profilePicMinCropSize.height], // min crop size
                            aspectRatio: 1, // keep aspect ratio 1:1
                            bgFade: true, // use fade effect
                            bgOpacity: .3, // fade opacity
                            allowMove: true,
                            onChange: updateCropDetails,
                            setSelect: [0, profilePicMinCropSize.width, profilePicMinCropSize.height, 0],
                            onSelect: updateCropDetails,
                            allowSelect: false,
                            onRelease: function () {
                                $('#' + formID + ' input[name="image-x"]').val('');
                                $('#' + formID + ' input[name="image-y"]').val('');
                            }
                        }, function () {
                            $('#profile-pic-crop-area .jcrop-holder>div').show();
                            showToastr('please crop the image and upload', 'info', true, 2000);
                            $('#' + thisFormID + ' input[name="image-w"]').val($('#profile-pic-preview').width());
                            $('#' + thisFormID + ' input[name="image-h"]').val($('#profile-pic-preview').height());
                            // Store the Jcrop API in the jcrop_api variable
                            jcrop_api = this;
                            jcrop_api.setSelect([0, 0, profilePicMinCropSize.width, profilePicMinCropSize.height]);

                            //set preview wrapper height equal to its width
                            var preview_wrapper_width = $('#' + thisFormID + ' .profile-pic-preview-wrapper').width();
                            $('#' + thisFormID + ' .profile-pic-preview-wrapper').width(preview_wrapper_width).height(preview_wrapper_width);

                            //set src image of preview
                            $('#' + thisFormID + ' .profile-pic-preview-wrapper img').attr('src', $('#profile-pic-preview').attr('src')).css('max-width', 'none').width($('#profile-pic-preview').width());
                        });
                    }, 300);
                } else {
                    $(onlyPreview).siblings('.preview').attr('src', $('#profile-pic-preview').attr('src')).removeClass('hide');
                }
            }


        };
    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

function imageSelectAndPreviewHandler(file_input, image_ele, callback, optWidth, optHeight)
{
    // get selected file
    var oFile = file_input[0].files[0];
    var image_type = oFile.type;
    if (typeof oFile == 'undefined')
        return false;

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/bmp|image\/jpg)$/i;
    if (!rFilter.test(oFile.type)) {
        //showToastr('Please select a valid image file (jpg, jpg, png, bmp are allowed).', 'error', true, 3000);
        alert('Please select a valid image file (jpg, jpg, png, bmp are allowed).');
        //image_ele.closest('li').remove();
        return;
    }

    image_ele.attr('alt', 'loading...');

    // prepare HTML5 FileReader
    var oReader = new FileReader();

    oReader.onload = function (e) {

        //$('#images-container').prepend('<li class="uploaded-img-preview"><div><img src="' + e.target.result + '"><div><a class="remove-uploaded-img" href="" image-index-"' + file_input_index + '">Remove</a></div></div></li>');

        previewImageFromSrc(e.target.result, file_input, image_ele, callback, optWidth, optHeight);

    };

    // read selected file as DataURL
    oReader.readAsDataURL(oFile);
}

function imageSelectAndWatermark(file_input, image_ele, callback, onlyPreview)
{
    var oFile = file_input[0].files[0];

    var image_type = oFile.type;
    if (typeof oFile == 'undefined')
        return false;

    // check for image type (jpg and png are allowed)
    var rFilter = /^(image\/jpeg|image\/png|image\/bmp|image\/jpg)$/i;
    if (!rFilter.test(oFile.type)) {
        //showToastr('Please select a valid image file (jpg, jpg, png, bmp are allowed).', 'error', true, 3000);
        alert('Please select a valid image file (jpg, jpg, png, bmp are allowed).');
        //image_ele.closest('li').remove();
        return;
    }

    image_ele.attr('alt', 'loading...');

    // prepare HTML5 FileReader
    var oReader = new FileReader();

    oReader.onload = function (e) {

        var image = e.target.result;
        var treatment_id = $('#treatment_id').val();

        /*$.blockUI({
            message: '<i class="fa fa-spinner fa-spin"></i> Please Wait...'
        });*/

        $.ajax({
            type: 'post',
            url: HOME_URL + 'treatment/storeImageFile',
            data: {
                'image': image,
                'image_type': image_type,
                'treatment_id': treatment_id,
                'uploads_folder': file_input.attr('upload-folder'),
            },
            success: function (res) {
                if ( typeof file_input.attr('only-preview') !== 'undefined' ) {
                    image_ele.attr('src', res).removeClass('hide');
                    window[callback](file_input, res);
                    return;
                }

                image_ele.attr('data-image-src', res);
                previewImageFromSrc(res, file_input, image_ele, callback);

            },
            complete: function (reponse) {
                /*$.unblockUI();*/
            }

        });
    }

    // read selected file as DataURL
    oReader.readAsDataURL(oFile)
}

function previewImageFromSrc(src, file_input, image_ele, callback, optWidth, optHeight)
{
    var img;
    img = document.createElement("img");
    img.src = src;

    img.onload = function () {
        var canvas, ctx, resizeInfo, thumbnail, _ref, _ref1, _ref2, _ref3;

        canvas = document.createElement("canvas");
        ctx = canvas.getContext('2d');

        resizeInfo = thumnailResizeInfo(img, optWidth, optHeight);

        if (resizeInfo.trgWidth == null) {
            resizeInfo.trgWidth = resizeInfo.optWidth;
        }
        if (resizeInfo.trgHeight == null) {
            resizeInfo.trgHeight = resizeInfo.optHeight;
        }

        canvas.width = resizeInfo.trgWidth;
        canvas.height = resizeInfo.trgHeight;

        drawImageIOSFix(ctx, img, (_ref = resizeInfo.srcX) != null ? _ref : 0, (_ref1 = resizeInfo.srcY) != null ? _ref1 : 0, resizeInfo.srcWidth, resizeInfo.srcHeight, (_ref2 = resizeInfo.trgX) != null ? _ref2 : 0, (_ref3 = resizeInfo.trgY) != null ? _ref3 : 0, resizeInfo.trgWidth, resizeInfo.trgHeight);
        thumbnail = canvas.toDataURL("image/png");

        image_ele.attr('src', thumbnail).removeClass('hide');

        if (typeof callback !== 'undefined') {
            window[callback](file_input, src);
        }
        //image_input_index = image_input_index + 1;
        //$('#images-container').append('<li class="uploaded-img-preview"><div><img src="' + thumbnail + '"><div><a class="remove-uploaded-img" href="" image-index-"' + file_input_index + '">Remove</a></div></div><input type="file" name="images[' + file_input_index + '][file]" id="image-input-' + file_input_index + '" class="upload-image pos-absolute"><input type="hidden" class="image-order-input" name="images[' + file_input_index + '][order]"></li>');
    };
}

function thumnailResizeInfo(file, optWidth, optHeight)
{
    console.log(file.height);
    var info, srcRatio, trgRatio;
    info = {
        srcX: 0,
        srcY: 0,
        srcWidth: file.width,
        srcHeight: file.height
    };
    srcRatio = file.width / file.height;
    info.optWidth = typeof optWidth == 'undefined' ? 100 : optWidth;
    info.optHeight = typeof optHeight == 'undefined' ? 100 : optHeight;
    if ((info.optWidth == null) && (info.optHeight == null)) {
        info.optWidth = info.srcWidth;
        info.optHeight = info.srcHeight;
    } else if (info.optWidth == null) {
        info.optWidth = srcRatio * info.optHeight;
    } else if (info.optHeight == null) {
        info.optHeight = (1 / srcRatio) * info.optWidth;
    }
    trgRatio = info.optWidth / info.optHeight;
    if (file.height < info.optHeight || file.width < info.optWidth) {
        info.trgHeight = info.srcHeight;
        info.trgWidth = info.srcWidth;
    } else {
        if (srcRatio > trgRatio) {
            info.srcHeight = file.height;
            info.srcWidth = info.srcHeight * trgRatio;
        } else {
            info.srcWidth = file.width;
            info.srcHeight = info.srcWidth / trgRatio;
        }
    }
    info.srcX = (file.width - info.srcWidth) / 2;
    info.srcY = (file.height - info.srcHeight) / 2;
    return info;
}

detectVerticalSquash = function (img) {
    var alpha, canvas, ctx, data, ey, ih, iw, py, ratio, sy;
    iw = img.naturalWidth;
    ih = img.naturalHeight;
    canvas = document.createElement("canvas");
    canvas.width = 1;
    canvas.height = ih;
    ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    data = ctx.getImageData(0, 0, 1, ih).data;
    sy = 0;
    ey = ih;
    py = ih;
    while (py > sy) {
        alpha = data[(py - 1) * 4 + 3];
        if (alpha === 0) {
            ey = py;
        } else {
            sy = py;
        }
        py = (ey + sy) >> 1;
    }
    ratio = py / ih;
    if (ratio === 0) {
        return 1;
    } else {
        return ratio;
    }
};

drawImageIOSFix = function (ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    var vertSquashRatio;
    vertSquashRatio = detectVerticalSquash(img);
    return ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
};

function showToastr(message, type, closeButton, timeOut, title) {
    toastr.clear();
    toastr.options.timeOut = timeOut;
    toastr.options.preventDuplicates = true;
    toastr.options.closeButton = closeButton;

    if (typeof title !== 'undefined') {
        if (type == 'error')
            toastr.error(message, title);
        if (type == 'info')
            toastr.info(message, title);
        if (type == 'success')
            toastr.success(message, title);
    } else {
        if (type == 'error')
            toastr.error(message);
        if (type == 'info')
            toastr.info(message);
        if (type == 'success')
            toastr.success(message);
    }
}

function convertCanvasToImage(canvas) {
    var image = new Image();
    image.src = canvas.toDataURL("image/png");
    return image.src;
}


      // assign delete id to hidden field
      function delete_1(id)
      {
         $('#delete_pk').val(id);
      }
      // delete record
      function delete_2()
      {
         var id = $('#delete_pk').val();
         window.location = "/contact_list/delete/"+id;
      }
