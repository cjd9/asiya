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
			top: -50px; 
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
		<br /><br /><br /><br />
		
		<div>
			<?php  
			$edit_treatment_html = '';
			 $edit_treatment_html .= '
				    <table width="95%" cellpadding="4"  border="0" align="center" style="top: 200px;">
				      <thead>
				        <tr>

				          <th width="19%"><div align="center">Therapy</div></th>
				          <th width="19%"><div align="center">Repetitions</div></th>
				          <th width="19%"><div align="center">Sets</div></th>
				          <th width="19%"><div align="center">Hold Time</div></th>
				        </tr>
				      </thead>
				      <tbody>';
				foreach($rstreatment->result_array() as $treatment_meta) {
				  $edit_treatment_html .= '
				        <tr>
				          <td width="77%"><div align="center">'.$treatment_meta["therapy"].'</div></td>
				          <td width="77%"><div align="center">'.$treatment_meta["reps"].'</div></td>
				          <td width="77%"><div align="center">'.$treatment_meta["sets"].'</div></td>
				          <td width="77%"><div align="center">'.$treatment_meta["time"].'mins</div></td>

				        </tr>
				  ';

				}
				 $edit_treatment_html .= '</tbody>
				    </table>';
				$r = $rstreatment->row();
			?>
			<p>
				<table width="95%" cellpadding="4"  border="0" align="center" style="top: 110px;">
					<tr>
						<th height="46" colspan="4"><b><u>PATIENT TREATMENT DETAILS</u></b></th>
					</tr>
					<tr>
						<td width="19%" style="vertical-align:text-top">Treatment ID</td>
						<td width="47%">: <?php echo $r->treatment_id; ?></td>
						<td width="18%" style="vertical-align:text-top">Treatment Date</td>
						<td width="16%">: <?php echo date("d-m-Y",strtotime($r->date_of_treatment)); ?></td>
					</tr>
					<tr>
						<td width="19%" style="vertical-align:text-top">Patient Name</td>
						<td width="47%" colspan="3">
							: <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo ucwords($r1->p_fname.' '.$r1->p_lname); ?>
						</td>
					</tr>
				</table>
				<br> <br>
				<table width="95%" cellpadding="4"  border="0" align="center" style="top: 110px;">
					<tr>
						<th height="41" colspan="2"><b><u>PLAN OF CARE</u></b></th>
					</tr>
					<tr>
						<td width="23%" style="vertical-align:text-top">Short Term Goals</td>
						<td width="77%">: <?php echo $r->short_term_goal; ?></td>
					</tr>
					<tr>
						<td width="23%" style="vertical-align:text-top">Long Term Goals</td>
						<td width="77%">: <?php echo $r->long_term_goal; ?></td>
					</tr>
					<tr>
						<td width="23%" style="vertical-align:text-top">Next Therapy Plan</td>
						<td width="77%">: <?php echo $r->next_therapy_plan; ?></td>
					</tr>
					<tr>
						<td width="23%" style="vertical-align:text-top" >Fees</td>
						<td width="77%">: Rs. <?php echo $r->treatment_fees; ?></td>
					</tr>
				</table>
				<br> <br><br> <br>
				<h3 style="text-align:center" ><b><u>PATIENT THERAPY DETAILS</u></b></h3>

			
				<?php echo $edit_treatment_html; ?>

			</p>
		</div>
	</body>
</html>
