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
			<h2><img src="<?php echo base_url(); ?>images/Asiya.jpg height="550%" width="15%"/> <b>Asiya Center of Physiotherapy & Rehabilitation</b></h2>
			<hr style="margin-left:35px; margin-right:35px;" />
		</div>
		<br /><br /><br /><br />

		<div>
			<?php
				$r = $rstreatment->row();
			?>
			<p>
		  		<div style="margin-top:390px;">
					<h2 align="center"><b>Bill Receipt</b></h2>
				</div>

				<table width="80%" cellpadding="4" border="0" align="center" style="top: 110px; border-collapse:collapse">
					<tbody>
						<tr>
							<td width="18%" style="vertical-align:text-top">Patient ID</td>
							<td width="45%">: <?php echo $r->patient_id; ?></td>
							<td width="18%" style="vertical-align:text-top" align="right">Billing Date</td>
							<td width="19%">: <?php echo date("d-m-Y"); ?>.</td>
						</tr>

						<tr>
							<td width="18%" style="vertical-align:text-top">Patient Name</td>
							<td colspan="3">:
								<?php $r1 = $this->db->get_where('contact_list', array('patient_id' => $r->patient_id))->row(); echo ucwords($r1->p_fname.' '.$r1->p_lname); ?>
							.</td>
						</tr>
					</tbody>
				</table>

				<br>

				<br>

				<table width="80%" cellpadding="4" border="1" align="center" style="top: 110px; border-collapse:collapse">
					<thead>
						<tr>
							<th><b>#</b></th>
							<th><b>Treatment ID</b></th>
							<th><b>Treatment Date</b></th>
							<th><b>Fees</b></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$cnt = 0;

							$total_fees = 0.00;

							foreach($rstreatment->result() as $row)
							{
								$total_fees = $total_fees + ($row->treatment_fees);
						?>
						<?php //$cnt = 0; foreach($rstreatment->result() as $row) : ?>
						<tr align="center">
							<td style="text-align:center"><?php echo ++$cnt; ?></td>
							<td><?php echo $row->treatment_id; ?></td>
							<td><?php echo $this->mastermodel->date_convert($row->date_of_treatment,'dmy'); ?></td>
							<td align="right"><?php echo number_format((float)$row->treatment_fees, 2, '.', ''); ?></td>
						</tr>
						<?php //endforeach ; ?>
						 <?php
						 	}
						 ?>
						<tr>
							<td colspan="3" align="right"><b>Total  </b></td>
							<td style="text-align:right"><b><?php echo number_format((float)$total_fees, 2, '.', ''); ?></b></td>
						</tr>
					</tbody>
				</table>

				<div style="position:absolute; bottom:90;">
					<table style="width:40%;" border="0" align="right">
						  <tr>
							<td align="left"><div align="center">------------------------</div></td>
						  </tr>
						  <tr>
							<td align="right"><div align="center"><b>Authorized  By</b></div></td>
						  </tr>
  					</table>
				</div>

			</p>
		</div>
	</body>
</html>
