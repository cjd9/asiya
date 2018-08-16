	   	<script src="<?php print base_url(); ?>js/jquery-1.11.1.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery-ui-1.10.3.min.js"></script>
        <script src="<?php print base_url(); ?>js/bootstrap.min.js"></script>
        <script src="<?php print base_url(); ?>js/modernizr.min.js"></script>
        <script src="<?php print base_url(); ?>js/pace.min.js"></script>
        <script src="<?php print base_url(); ?>js/retina.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.cookies.js"></script>

		<script src="<?php print base_url(); ?>js/jquery.autogrow-textarea.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.mousewheel.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.tagsinput.min.js"></script>
        <script src="<?php print base_url(); ?>js/toggles.min.js"></script>
        <script src="<?php print base_url(); ?>js/bootstrap-timepicker.min.js"></script>
        <script src="<?php print base_url(); ?>js/jquery.maskedinput.min.js"></script>
        <script src="<?php print base_url(); ?>js/select2.min.js"></script>
        <script src="<?php print base_url(); ?>js/colorpicker.js"></script>
        <script src="<?php print base_url(); ?>js/dropzone.min.js"></script>

        <script src="<?php print base_url(); ?>js/jquery.dataTables.min.js"></script>
        <script src="<?php print base_url(); ?>js/dataTables.bootstrap.js"></script>
	<script src="<?php print base_url(); ?>js/dataTables.responsive.js"></script>
        <script src="<?php print base_url(); ?>js/select2.min.js"></script>

		<script src="<?php print base_url(); ?>js/wysihtml5-0.3.0.min.js"></script>
        <script src="<?php print base_url(); ?>js/bootstrap-wysihtml5.js"></script>
				<script src="<?php echo base_url();?>js/toastr/toastr.min.js" type="text/javascript"></script>
				<script src="<?php echo base_url();?>/js/Jcrop/js/jquery.Jcrop.min.js" type="text/javascript"></script>
				<script src="<?php echo base_url();?>/js/Jcrop/js/jquery.color.js" type="text/javascript"></script>

		<!-- Start Validation JS---->
		<!--<script src="<?php echo base_url();?>assets/validation/js/jquery-1.8.2.min.js"></script>-->

		<script src="<?php echo base_url();?>js/my_js/validation/languages/jquery.validationEngine-en.js"></script>
		<script src="<?php echo base_url();?>js/my_js/validation/jquery.validationEngine.js"></script>
		<script src="<?php echo base_url();?>js/bootbox.min.js"></script>
		<script src="<?php echo base_url();?>js/jquery.diyslider.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.js" integrity="sha256-59IZ5dbLyByZgSsRE3Z0TjDuX7e1AiqW5bZ8Bg50dsU=" crossorigin="anonymous"></script>
		<script src="<?php print base_url(); ?>js/custom.js"></script>

		<script src="<?php echo base_url();?>js/my_js/master.js"></script>
		<!-- End Validation JS---->

		<script>
		$(document).ready(function()
		{
			$("select.select2-container").select2();

			$('.datepicker').datepicker({
				changeMonth: true,
				changeYear: true,
				yearRange: '1945:2050',
				dateFormat: 'dd-mm-yy'
			});

			$("body").on("hidden.bs.modal", '.modal', function()
			{
				$(this).removeData('bs.modal');
			});

			// function to update the staff work shift -
			$("#staff_work_shift").click( function () {

				var work_shift_field = $(this);

				var work_shift = work_shift_field.attr("data-id");;

				//alert(work_shift);

				var result = confirm('You want to Update Work Shift?');

				if(result)
				{
					$.ajax({
							url: "<?php print base_url(); ?>login/update_work_shift",
							type: "post",
							async:false,
							cache:false,
							//dataType:'json',
							data:{ work_shift:work_shift },
							success: function (res)
							{
								//alert(res);

								// check if user work shift is successfully updated -
								if(res != 0)
								{
									// reload current page after staff work shift update -
									window.location = "<?php echo current_url(); ?>";
								}
							}
					});
				}

			});
		});

		jQuery(document).ready(function()
		{
			jQuery('#basicTable').DataTable(
			{
				responsive: true,
				"autoWidth": false,
				"order": []
			});
			jQuery('#basicTableEval').DataTable(
			{
				responsive: true,
				"autoWidth": false,

			});

			jQuery('#basicTable1').DataTable(
			{
				responsive: true,
				"autoWidth": false
			});

			// Tags Input
			jQuery('#tags').tagsInput({width:'auto'});

			// Textarea Autogrow
			jQuery('#autoResizeTA').autogrow();

			// Form Toggles
			jQuery('.toggle').toggles({on: true});

			$(document).ready(function(){
				    var $remaining = $('#remaining'),
				        $messages = $remaining.next();

				    $('#msg , #message').keyup(function(){
				        var chars = this.value.length,
				            messages = Math.ceil(chars / 160),
				            remaining = messages * 160 - (chars % (messages * 160) || messages * 160);

				        $remaining.text(remaining + ' characters remaining');
				        $messages.text(messages + ' message(s)');
				    });
				});
		
		});
        </script>

		<script>
		// function to password validate form -
		function paass_validate()
		{
			var flag = 0;

			if($('#current_password').val() == '')
			{
				//$('#msg1').addClass('error').text('This Field is Required');
				flag = 1;
			}

			if($('#new_password').val() == '')
			{
				//$('#msg2').addClass('error').text('This Field is Required');
				flag = 1;
			}

			if($('#confirm_password').val() == '')
			{
				//$('#msg3').addClass('error').text('This Field is Required');
				flag = 1;
			}

			if(flag == 1)
			{
				return false;
			}
		}
		</script>

		<script>
		// function to validate current password -
		$('#current_password').on('change', function(e)
		{
			$('#error_msg').text('');

			var current_password = $('#current_password').val();

			if(current_password == '' || current_password == null)
			{
				return false;
			}

			// ajax work -
			$.ajax({
					url: "<?php print base_url(); ?>login/check_current_password",
					type: "post",
					async:false,
					cache:false,
					dataType:'json',
					data: { 'current_password' : current_password },
					success: function (data)
					{
						if(data == 0)
						{
							$('#error_msg').text('Invalid Current Password.');
							$('#current_password').val('');
						}
					}
				});
		});

		// function to compare new password and confirm passsword -
		$('#confirm_password').on('change', function(e)
		{
			$('#error_msg1').text('');

			var new_password = $('#new_password').val();
			var confirm_password = $('#confirm_password').val();

			if(new_password != '' || confirm_password != '')
			{
				if(new_password !== confirm_password)
				{
					$('#error_msg1').text('New Password & Confirm Password Not Match.');
					$('#confirm_password').val('');
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		});

		// code to check password strength - Date - 21-04-2015
		// Ref - https://www.hscripts.com/scripts/JavaScript/password-checker.php
		var pass_strength;

		function IsEnoughLength(str,length)
		{
			if ((str == null) || isNaN(length))return false;else if (str.length < length)
				return false;
			else
				return true;
		}

		function HasMixedCase(passwd)
		{
			if(passwd.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
				return true;
			else
				return false;
		}

		function HasNumeral(passwd)
		{
			if(passwd.match(/[0-9]/))
				return true;
			else
				return false;
		}

		function HasSpecialChars(passwd)
		{
			if(passwd.match(/.[!,@,#,$,%,^,&,*,?,_,~]/))
				return true;
			else
				return false;
		}

		//Show Password Strength with Colour
		function CheckPasswordStrength(pwd)
		{
			if (IsEnoughLength(pwd,14) && HasMixedCase(pwd) && HasNumeral(pwd) && HasSpecialChars(pwd))
				pass_strength = "Password Strength : <b><font style='color:olive'>Very strong</font></b>";

			else if (IsEnoughLength(pwd,8) && HasMixedCase(pwd) && (HasNumeral(pwd) || HasSpecialChars(pwd)))
				pass_strength = "Password Strength : <b><font style='color:Blue'>Strong</font></b>";

			else if (IsEnoughLength(pwd,8) && HasNumeral(pwd))
				pass_strength = "Password Strength : <b><font style='color:Green'>Good</font></b>";

			else
				pass_strength = "Password Strength : <b><font style='color:red'>Weak</font></b>";

			document.getElementById('pwd_strength').innerHTML = pass_strength;
		}

		</script>
