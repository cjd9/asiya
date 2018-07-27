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
			top: -70px;
			right: 0px;
			text-align: center;
		}
    .tbl {background-color:#000;}
    .tbl td,th,caption{background-color:#fff}

	  </style>
	</head>
	<body style="border:5px double; height:160%;">
		<div id="header">
			<div style="=top:30px;"><img src="<?php echo base_url(); ?>images/Asiya.jpg"  /> </div><h4 style="text-align: center;  ">Staff Name: <?php echo $rsstaff['s_fname'].' '.$rsstaff['s_lname'] ?></h4>
			<hr style="margin-left:35px; margin-right:35px;" />
		</div>
		<br /><br /><br /><br />

		<div>
      <br /><br />

             <div style="text-align: center; margin-left:15px; width:95%;">
                <table cellspacing="2" class="tbl" style=" border:2px double;  width:100%;">
                <tr>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Patient Details</th>
                  <th>Mobile</th>
                </tr>
                <?php
                        foreach($rstime_slots as $slot) {

                               foreach($rsschedule as $apt) {
                                 if($apt['time_slot_id'] == $slot['pk'])  {                      ?>
                                 <tr>
                                   <td><?php echo $apt['date_of_appointment']; ?></td>
                                   <td><?php echo $slot['time_slot']; ?></td>
                                   <td><?php echo $apt['p_fname'].' '.$apt['p_lname']; ?></td>
                                   <td><?php echo $apt['p_contact_no']; ?></td>
                                 </tr>


                         <?php }
                             }
                           }
                         ?>


          </table>
        </div>




				<br> <br><br> <br>




		</div>
	</body>
</html>
