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
			<h2><img src="<?php echo base_url(); ?>images/Asiya.jpg" height="550%" width="15%"/> <b>Asiya Center of Physiotherapy & Rehabilitation</b></h2>
			<hr style="margin-left:35px; margin-right:35px;" />
		</div>

		<br /><br /><br /><br /><br /><br />

		<?php
			$r = $rsstaff_list->row();
		?>
		<div>

			<table width="90%" border="0" align="center">
				<tr>
					<td width="22%"><b>Staff ID</b></td>
					<td width="66%"><b>:</b> <?php echo $r->staff_id; ?></td>
					<td width="18%" rowspan="2" valign="top">
						<?php if($r->staff_photo) { ?>
					  	<img src="<?php print base_url().'../staff_upload_data/staff_photo/'.$r->staff_photo; ?>" height="90" width="90" />
					  	<?php } else { ?>
					 	<img alt="" src="<?php print base_url(); ?>images/men.png"  height="90" width="90" />
					  	<?php } ?>
					</td>
				</tr>
				<tr>
					<td width="22%"><b>Date Of Joining</b></td>
					<td width="66%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->date_of_joining)); ?></td>
				</tr>
			</table>

			<table width="90%" cellpadding="8"  border="0" align="center">
				<tr>
					<th colspan="5"  cellspacing="10"><b><u>STAFF BASIC DETAILS</u></b></th>
				</tr>
				<tr>
					<td width="20%"><b>Staff Name</b></td>
					<td width="80%"><b>:</b> <?php echo ucwords($r->s_fname.' '.$r->s_mname.' '.$r->s_lname); ?></td>
				</tr>
				<tr>
					<td width="20%"><b>DOB</b></td>
					<td width="80%"><b>:</b> <?php echo date("d-m-Y",strtotime($r->s_dob)); ?></td>
				</tr>
				<tr>
					<td width="20%"><b>Gender</b></td>
					<td width="80%"><b>:</b>
						<?php if ($r->s_gender=="Male") { echo 'Male'; } ?>
						<?php if ($r->s_gender=="Female") { echo 'Female'; } ?>
					</td>
				</tr>
				<tr>
					<td width="20%"><b>Religion</b></td>
					<td width="80%"><b>:</b> <?php print $this->db->get_where('religion', array('pk' => $r->s_religion_id))->row()->religion; ?></td>
				</tr>
				<tr>
					<td width="20%"><b>Email ID</b></td>
					<td width="80%"><b>:</b> <?php echo $r->s_email_id; ?></td>
				</tr>
				<tr>
					<td width="20%"><b>Contact No.</b></td>
					<td width="80%"><b>:</b> <?php echo $r->s_contact_no; ?></td>
				</tr>

				<tr>
					<td width="20%" valign="top"><b>Address</b></td>
					<td width="80%" valign="top"><b>:</b> <?php echo $r->s_address; ?></td>
				</tr>
				<tr>
					<td width="20%"><b>City</b></td>
					<td width="80%"><b>:</b> <?php echo $r->s_city; ?></td>
				</tr>
				<tr>
					<td width="20%"><b>Pin</b></td>
					<td width="80%"><b>:</b> <?php echo $r->s_zip; ?></td>
				</tr>
				<tr>
					<td width="20%"><b>State</b></td>
					<td width="80%"><b>:</b> <?php echo $r->s_state; ?></td>
				</tr>

			</table>

		</div>
	</body>
</html>
