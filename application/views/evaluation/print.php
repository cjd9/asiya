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
		<div id="header" style="margin-top:45px;">
			<h2><img src="<?php echo base_url(); ?>images/Asiya.jpg" style=' height="550%" '/></h2>
			<hr style="margin-left:35px; margin-right:35px;" />

		</div>
		<br /><br /><br /><br /><br />
		<?php  
			$r = $rsevaluation->row();
		?>
		<div style="margin-top:35px;">
			<p>
				<table width="95%" cellpadding="4"  border="0" align="center" style="top: 110px;">
					<tr>
						<th colspan="2"><b><u>PATIENT INFORMATION</u></b></th>
					</tr>
					
					<tr>
						<td width="25%" style="vertical-align:text-top">Patient Name</td>
						<td width="75%">- <?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo ucwords($r1->p_fname.' '.$r1->p_lname); ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Present Complaints</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_present_complaint; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Past History</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_past_history; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Aggrevating Factor</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_aggrevating_factor; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Relieving Factor</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_relieving_factor; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Others</td>
						<td width="75%" style="vertical-align:text-top">- <input type="checkbox" <?php if($r->p_other_chkbox == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>	
					</tr>
					<tr>
						<td width="25%"><b></b></td>
						<td width="75%" style="vertical-align:text-top">- 
							<?php 
								if($r->p_other_chkbox == 1) 
								{  
							?>
								<?php echo $r->p_other_evluation; ?>
							<?php 
								} 
							?>			
						</td>	
					</tr>
				</table>
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="8"  cellspacing="10"><b><u>MEDICAL HISTORY</u></b></th>
					</tr>
					
					<tr>
						<td width="5%">
							<div align="right">
								<input type="checkbox" <?php if($r->p_hyper_tension == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly="">
							</div>
						</td>
						<td width="18%">Hyper Tension</td>
						<td width="3%"><input type="checkbox" <?php if($r->p_diabetes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>  readonly=""></td>
						<td width="21%">Diabetes</td>
						<td width="4%">Height</td>
						<td width="17%"><b>: <?php echo $r->p_height; ?></b> Ft-In</td>
						<td width="6%">Weight</td>
						<td width="26%"><b>: <?php echo $r->p_weight; ?></b> KG</td>
					</tr>
				</table>
				
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<td width="25%" style="vertical-align:text-top">Allergies</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_allergies; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Recent Surgeries Done</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_recent_surgery_done; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Current Medications</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_current_medication; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Others</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_other_medical_history; ?></td>	
					</tr>
				</table>
				
				<table width="95%"  cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="7"  cellspacing="10"><b><u>GENERAL HEALTH</u></b></th>
					</tr>
					<tr>
						<td>Daily Water Intake</td>
						<td colspan="7">- <?php echo $r->p_daily_water_intake; ?></td>
					</tr>
					<tr>
						<td width="25%">Diet</td>
						<td width="4%">- <input type="checkbox" <?php if($r->p_diet_veg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="26%">VEG</td>
						<td width="4%"> <input type="checkbox" <?php if($r->p_diet_nonveg == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="25%">Non-VEG</td>
						<td width="4%"> <input type="checkbox" <?php if($r->p_diet_mix == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="12%">Mix</td>
					</tr>
					<tr>
						<td>Other</td>
						<td colspan="7">- <?php echo $r->p_other_general; ?></td>
					</tr>
				</table>
			</p>
			
			<p style="page-break-before: always; margin-top:35px;">
			<br /><br /><br /><br />
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="6" cellspacing="10"><b><u>ADDICTIONS</u></b></th>
					</tr>
					<tr>
						<td width="2%"><input type="checkbox" <?php if($r->p_cigarettes == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="14%">Cigarettes</td>
						<?php if($r->p_cigarettes == 1) {  ?>
						<td width="13%"><div align="right">Daily Intake Count</div></td>
						<td width="4%">- <?php echo $r->cigarettes_daily_intake; ?></td>
						<td width="20%"> <div align="right">Addiction Since(in Months)</div></td>
						<td width="4%">- <?php echo $r->cigarettes_addiction_since; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td width="2%"><input type="checkbox" <?php if($r->p_alcohol == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="14%">Alcohol</td>
						<?php if($r->p_alcohol == 1) {  ?>
						<td width="13%"><div align="right">Daily Intake Count</div></td>
						<td width="4%">- <?php echo $r->alcohol_daily_intake; ?></td>
						<td width="20%"> <div align="right">Addiction Since(in Months)</div></td>
						<td width="4%">- <?php echo $r->alcohol_addiction_since; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td width="2%"><input type="checkbox" <?php if($r->p_tobaco == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="14%">Tobaco</td>
						<?php if($r->p_tobaco == 1) {  ?>
						<td width="13%"><div align="right">Daily Intake Count</div></td>
						<td width="4%">- <?php echo $r->tobaco_daily_intake; ?></td>
						<td width="20%"> <div align="right">Addiction Since(in Months)</div></td>
						<td width="4%">- <?php echo $r->tobaco_addiction_since; ?></td>
						<?php } ?>
					</tr>
					<tr>
						<td width="2%"><input type="checkbox" <?php if($r->p_none == 1) { echo 'value="1"'; ?> checked="checked" <?php } ?>></td>
						<td width="14%">None</td>
					</tr>
				</table>
	
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2"  cellspacing="10"><b><u>X-RAY SCAN REPORT</u></b></th>
					</tr>
					<tr>
						<td colspan="2" style="vertical-align:text-top">Report</td>
					</tr>
					<?php
						// get all xray report files for this patient evaluation -
						$rsxray_report = $this->db->get_where('patient_xray_report', array('evaluation_id' => $r->pk, 'is_deleted' => 0));
						
						if($rsxray_report->num_rows() > 0)
						{
							foreach($rsxray_report->result() as $r2)
							{
					?>
					<tr>
						<td width="13%" style="vertical-align:text-top"></td>
						<td width="87%" style="vertical-align:text-top">- <?php echo $r2->p_xray_report; ?></td>
					</tr>
					<?php
							}
						}
					?>
				</table>
				
				<table width=95%"" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2"  cellspacing="10"><b><u>VITAMIN</u></b></th>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">D3/B12</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_vitamin; ?></td>
					</tr>
				</table>
				
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2" cellspacing="10"><b><u>BLOOD INVESTIGATION</u></b></th>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Reports</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->blood_investigation_report; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Other</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->blood_investigation_other; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Observation</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->blood_observation; ?></td>
					</tr>
				</table>
			</p>
			
			<p style="page-break-before: always; margin-top:35px;">
			<br /><br /><br /><br />
				<table width="95%" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2" cellspacing="10"><b><u>MOVEMENT</u></b></th>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Special Test</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_special_test; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Range</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_range; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Quality</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_quality; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Combined Movements</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_combined_movement; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Notes</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_movement_notes; ?></td>
					</tr>
				</table>
				
				<table width=95%"" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2" cellspacing="10"><b><u>MUSCLE</u></b></th>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Strength</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_strength; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Flexibility</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_flexibility; ?></td>
					</tr>
					<tr>
						<td width="25%" style="vertical-align:text-top">Notes</td>
						<td width="75%" style="vertical-align:text-top">- <?php echo $r->p_muscle_notes; ?></td>
					</tr>
				</table>
				
				<table width=95%"" cellpadding="4"  border="0" align="center">
					<tr>
						<th colspan="2" cellspacing="10"><b><u>PALPATION</u></b></th>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Tenderness</td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->p_tenderness; ?></td>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Swelling</td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->p_swelling; ?></td>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Limblength Discrepancy</td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->p_limblength; ?></td>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Neural Investigation </td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->nueral_investigation; ?></td>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Notes</td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->p_palpation_notes; ?></td>
					</tr>
					<tr>
						<td width="27%" style="vertical-align:text-top">Provisional Diagnosis</td>
						<td width="73%" style="vertical-align:text-top">- <?php echo $r->provisional_diagnosis; ?></td>
					</tr>
					
				</table>
			</p>
		</div>
	</body>
</html>
