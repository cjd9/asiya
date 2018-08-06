<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;">
	  	<style>
		@page
		{
			margin:50px;
		}
		#header
		{
			position: fixed;
			left: 0px;
			top: -40px;
			right: 0px;
			text-align: center;
		}

	  </style>
	</head>
	<body style="border:5px double; height:98%;">
		<div id="header" style="margin-top:30px;">
			<h2><img src="<?php echo base_url(); ?>images/Asiya.jpg" height="550%"/> </h2>
			<hr style="margin-left:35px; margin-right:35px; text-align: center;" />
		</div>

		<br /><br /><br /><br /><br /><br />

		<?php
			$r = $rscontact_list->row();
		?>
		<div>

			<table  border="0" align="center">
				<tr>
					<td width="19%"><b>Registration ID</b></td>
					<td width="40%"><b>:</b> <?php echo $r->patient_id; ?></td>
					<td width="20%"></td>
					<td width="30%"><b>Date of Registration</b></td>
					<td width="15%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->date_of_registration)); ?></td>
				</tr>
			</table>
			<hr style="margin-left:35px; margin-right:35px;" />

			<table  border="0" align="center">
				<tr>
					<td width="10%"></td>
					<td width="40%"></td>

					<td width="50%" rowspan="2" valign="top">
						<?php if(file_exists(FCPATH .'patient_upload_data/'. $r->patient_id.'.jpg')) { ?>
					  	<img src="<?php print base_url(PROFILE_PIC_UPLOAD_PATH . $r->patient_id) ;  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';"height="90" width="90" />
					  	<?php } else { ?>
					 	<img alt="" src="<?php print base_url(); ?>images/default_man_photo.jpg"  height="90" width="90" />
					  	<?php } ?>
					</td>
				</tr>
			</table>


			<table width="90%"cellpadding="4"  border="0" align="center">
				<tr>
					<th height="44" colspan="5"  cellspacing="10" ><b><u>PATIENT INFORMATION</u></b></th>
				</tr>
				
				
				<tr>
					<td width="15%"><b>Patient Name</b></td>
					<td width="40%"><b>:</b><?php echo ucwords($r->p_fname.' '.$r->p_mname.' '.$r->p_lname); ?></td>
					<td width="15%"><b>DOB</b></td>
					<td width="25%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->p_dob)); ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Gender</b></td>
					<td width="43%"><b>:</b>
						<?php if ($r->p_gender=="Male") { echo 'Male'; } ?>
						<?php if ($r->p_gender=="Female") { echo 'Female'; } ?>
					</td>
					<td width="15%"><b>Age</b></td>
					<td width="25%"><b>:</b> <?php echo $r->age; ?> Years</td>
				</tr>
				<tr>
					<td width="15%"><b>Religion</b></td>
					<td width="43%"><b>:</b> <?php print $this->db->get_where('religion', array('pk' => $r->p_religion_id))->row()->religion; ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Occupation</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_occupation; ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Email ID</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_email_id; ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Landline No.</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_phone_no; ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Mobile No.</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_contact_no; ?></td>
				</tr>
				<tr>
					<td width="15%"><b>Referred By.</b></td>
					<td width="43%"><b>:</b> <?php echo $r->referred_by; ?></td>
				</tr>

		</table>
		<table width="90%"cellpadding="4"  border="0" align="center">
			<tr>
								<td width="15% rowspan="3" valign="top"" ><b>Address</b></td>
								<td width="80% rowspan="3" valign="top"" ><b>:</b> <?php echo wordwrap($r->p_address,70,"<br>\n").','.$r->p_city.','.$r->p_state.'-'.$r->p_zip ; ?></td>
			</tr>

		</table>


			<table width="90%"cellpadding="4"  border="0" align="center">
				<tr>
					<th height="47" colspan="5"  cellspacing="10"><b><u><?php echo strtoupper("Emergency Contact Details"); ?></u></b></th>
				</tr>
				<tr>
					<td width="15%"><b>Name</b></td>
					<td width="40%"><b>:</b><?php echo ucwords($r->p_emergency_name); ?></td>
					<td width="20%"><b>Mobile No.</b></td>
					<td width="20%"><b>:</b> <?php echo $r->p_emergency_contact; ?></td>
				</tr>
			</table>

		</div>
	</body>
</html>
