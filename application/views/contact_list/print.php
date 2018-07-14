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
		<div id="header">
			<h2><img src="<?php echo base_url(); ?>images/logo-new.png" height="550%" width="15%"/> <b>Asiya Center of Physiotherapy & Rehabilitation</b></h2>
			<hr style="margin-left:35px; margin-right:35px;" />
		</div>
		
		<br /><br /><br /><br /><br /><br />
		
		<?php  
			$r = $rscontact_list->row();
		?>
		<div>
		
			<table width="90%" border="0" align="center">
				<tr>
					<td width="19%"><b>Registration ID</b></td>
					<td width="40%"><b>:</b> <?php echo $r->patient_id; ?></td>
					<td width="24%"><b>Date of Registration</b></td>
					<td width="17%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->date_of_registration)); ?></td>
				</tr>
			</table>
			
			<hr style="margin-left:35px; margin-right:35px;" />
			
			<table width="90%"cellpadding="4"  border="0" align="center">
				<tr>
					<th height="44" colspan="5"  cellspacing="10" ><b><u>PATIENT INFORMATION</u></b></th>
				</tr>
				<tr>
					<td width="19%"><b>Patient Name</b></td>
					<td width="40%"><b>:</b><?php echo ucwords($r->p_fname.' '.$r->p_mname.' '.$r->p_lname); ?></td>
					<td width="15%"><b>DOB</b></td>
					<td width="25%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->p_dob)); ?></td>
				</tr>
				<tr>
					<td width="19%"><b>Gender</b></td>
					<td width="43%"><b>:</b>
						<?php if ($r->p_gender=="Male") { echo 'Male'; } ?>
						<?php if ($r->p_gender=="Female") { echo 'Female'; } ?>				
					</td>
					<td width="15%"><b>Age</b></td>
					<td width="25%"><b>:</b> <?php echo $r->p_age; ?> Year</td>
				</tr>
				<tr>
					<td width="19%"><b>Religion</b></td>
					<td width="43%"><b>:</b> <?php print $this->db->get_where('religion', array('pk' => $r->p_religion_id))->row()->religion; ?></td>
				</tr>
				<tr>
					<td width="19%"><b>Occupation</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_occupation; ?></td>
				</tr>
				<tr>
					<td width="19%"><b>Email ID</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_email_id; ?></td>
				</tr>
				<tr>
					<td width="19%"><b>Landline No.</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_phone_no; ?></td>
				</tr>
				<tr>
					<td width="19%"><b>Mobile No.</b></td>
					<td width="43%"><b>:</b> <?php echo $r->p_contact_no; ?></td>
				</tr>
			
				<tr>
					<td width="14%" rowspan="3" valign="top"><b>Address</b></td>
					<td width="53%" rowspan="3" valign="top"><b>:</b> <?php echo $r->p_address; ?></td>
					<td width="10%"><b>City</b></td>
					<td width="23%"><b>:</b> <?php echo $r->p_city; ?></td>
				</tr>
				<tr>
					<td width="10%"><b>State</b></td>
					<td width="23%"><b>:</b> <?php echo $r->p_state; ?></td>
				</tr>
				<tr>
					<td width="10%"><b>Pin</b></td>
					<td width="23%"><b>:</b> <?php echo $r->p_zip; ?></td>
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
