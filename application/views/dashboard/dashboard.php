
       <style>
               .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px; /* 5px rounded corners */
        }

        /* Add rounded corners to the top left and the top right corner of the image */
        img {
            border-radius: 5px 5px 0 0;
        }
       </style>
                <div class="mainpanel">
                    <div class="pageheader">
                      <div class="media">
                            <div class="pageicon pull-left">
                                <i class="fa fa-home"></i>
                            </div>
                            <div class="media-body">
                                <ul class="breadcrumb">
                                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                                    <li>Dashboard</li>
                                </ul>
                                <h4>Dashboard</h4>
                            </div>
                        </div><!-- media -->
                    </div><!-- pageheader -->


                    <div class="contentpanel">

                     <?php if($this->session->flashdata('message')) { echo flash_message(); } ?>


                        <div align="center">
							<!--<p><img src="<?php echo base_url(); ?>images/logo-1.jpg" height="50" width="60"/></p>-->
				<!-- 			<h1><b>WELCOME</b></h1>
							<h4><b>To</b></h4>
							<h1><b>Asiya Center of Physiotherapy & Rehabilitation</b></h1> -->
						</div>      

                <div class="row festival-bday">
                          <div class = "col-sm-6">
                              <h4 class ="text-center panel-heading" style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Birthday's today</h4>

                      <?php if(!empty($today_appointment)) {
                           foreach($today_appointment as $today){ ?>
                            <div class="card col-md-3" >
                              <img src="/patient_upload_data/<?php echo $today['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">
                            
                                <h6 class="text-center"><b><?php echo $today['p_fname'];  ?></b></h6>
                              </div>

                           
                      <?php  }
                    }else{ ?>
                      <p><strong>No Birthdays Today</strong></p>
                    <?php }  ?>
                        </div>
                  
                   <div class = "col-sm-6">
                       <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Festivals Today</h4>
                       <?php if(!empty($tomorrow_appointment)) {
                         foreach($tomorrow_appointment as $tomorrow){ ?>
                         <div class="card col-md-3" >
                           <img src="/patient_upload_data/<?php echo $tomorrow['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">
                         
                             <h6 class="text-center"><b><?php echo 'Diwali' ; ?></b></h6>
                         
                        </div>
                      <?php  }
                    }else{ ?>
                      <p><strong>No Festivals Today</strong></p>
                    <?php }  ?>
                    </div>
                </div>
                        <div class="row appointments">
                          <div class = "col-sm-6">
                              <h4 class ="text-center panel-heading" style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Today's Appointments</h4>

                      <?php if(!empty($today_appointment)) {
                           foreach($today_appointment as $today){ ?>
                            <div class="card col-md-3" >
                              <img src="/patient_upload_data/<?php echo $today['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">
                              
                                <h6 class="text-center"><b><?php echo $today['p_fname'];  ?></b></h6>
                                <p style ="font-size:11px"><?php echo $today['time_slot'];  ?></p>
                              

                            </div>
                      <?php  }
                    }else{ ?>
                      <p><strong>No Appointments for Today</strong></p>
                    <?php }  ?>
                        </div>
                  
                   <div class = "col-sm-6">
                       <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Tomorrows's Appointments</h4>
                       <?php if(!empty($tomorrow_appointment)) {
                         foreach($tomorrow_appointment as $tomorrow){ ?>
                         <div class="card col-md-3" >
                           <img src="/patient_upload_data/<?php echo $tomorrow['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">
                             <h6 class="text-center"><b><?php echo $tomorrow['p_fname'];  ?></b></h6>
                             <p style ="font-size:11px"><?php echo $tomorrow['time_slot'];  ?></p>
                         
                        </div>
                      <?php  }
                    }else{ ?>
                      <p><strong>No Appointments for Tomorrow</strong></p>
                    <?php }  ?>
                    </div>
                </div>
                <div class ="row chart">

                  <div class="col-sm-6">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Monthly Appointments</h4>

                 </div>
                  <div class="col-sm-6">
                     <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Fees Collected</h4>

                      <div id="line-chart" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

                  </div>
                </div>
                    </div><!-- contentpanel -->

                </div><!-- mainpanel -->
            </div><!-- mainwrapper -->
        </section>


    </body>
</html>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script>

Highcharts.chart('line-chart', {
  chart: {
    type: 'column'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: 'Monthly Report'
  },
  xAxis: {
    categories: ['Jan', 'Feb', 'March', 'April', 'May' ,'June' ,'July' ,'Aug' ,'Sep' ,'Oct' ,'Nov' ,'Dec'],
    title: {
      text: null
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: '',
      align: 'high'
    },
    labels: {
      overflow: 'justify'
    }
  },
  // tooltip: {
  //   valueSuffix: ' thousand'
  // },
  plotOptions: {
    bar: {
      dataLabels: {
        enabled: true
      }
    }
  },
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'top',
    x: -40,
    y: 80,
    floating: true,
    borderWidth: 1,
    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
    shadow: true
  },
  credits: {
    enabled: false
  },
  series: [<?php echo $json;?>]
});</script>
