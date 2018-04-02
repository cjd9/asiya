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
         $("#search_patient_form").validationEngine({promptPosition: "topRight: -100"});
      
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
                        url: "<?php print base_url(); ?>index.php/contact_list/share_patient",
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
                              window.location = "<?php echo base_url().'index.php/contact_list'; ?>";
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
         
    
      // assign delete id to hidden field
      function delete_1(id)
      {
         $('#delete_pk').val(id);
      }
      // delete record
      function delete_2()
      {
         var id = $('#delete_pk').val();
         window.location = "<?php echo $deleteaction; ?>/"+id;
      }

});