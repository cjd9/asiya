
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
                      <?php $unique=array(); $cnt = 0; foreach($rsactivity_program->result() as $row) : ?>
                  <?php if(!in_array($row->activity_id,$unique)){ $unique[] =$row->activity_id ; ?>  
                      <div class="alert alert-success">
                        <strong>Activity <?php echo $row->activity_id  ?></strong>   <br><?php echo substr($row->activity_program, 0, 100) ?> ....<a href="<?php print base_url(); ?>p_activity_program/view/<?php echo $row->activity_id; ?>" >Read more >>></a>

                      </div>
                   <?php } endforeach ; ?>

                     <?php if($this->session->flashdata('message')) { echo flash_message(); } ?>


                        <div align="center">
                          <?php if($rspatient_enquiry['count'] != 0) 
                          { ?>
							             <div class="alert alert-info">
                        <strong>New Patient Inquiry </strong>   <br>You have <?php echo $rspatient_enquiry['count']?> new inquiry from your patient....<a href="<?php print base_url(); ?>patient_enquiry" >Inqury page</a>

                      </div>
                      <?php } ?>
						     </div>

                <div class="row festival-bday">
                          <div class = "col-sm-6">
                              <h4 class ="text-center panel-heading" style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Birthday's today</h4>

                      <?php if(!empty($birthday_today)) {
                           foreach($birthday_today as $today){ ?>
                            <div class="card col-md-3" >
                              <img src="/patient_upload_data/<?php echo $today['patient_id'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">

                                <h6 class="text-center"><b><?php echo $today['p_fname'].' '.$today['p_lname'];;  ?></b></h6>
                              </div>


                      <?php  }
                    }else{ ?>
                      <p><strong>No Birthdays Today</strong></p>
                    <?php }  ?>
                        </div>

                   <div class = "col-sm-6">
                       <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Festivals Today</h4>
                       <?php if(!empty($festival_today)) {
                         foreach($festival_today as $today){ ?>
                         <div class="card col-md-3" >
                           <img src="/images/festival.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="width: 100%">

                             <h6 class="text-center"><b><?php echo $today['festival_name']; ?></b></h6>

                        </div>
                      <?php  }
                    }else{ ?>
                      <p><strong>No Festivals Today</strong></p>
                    <?php }  ?>
                    </div>
                </div>
                        <div class="row appointments">
                          <div class = "col-sm-6">
                              <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Today's Appointments </h4>

                      <?php if(!empty($today_appointment)) {
                           foreach($today_appointment as $today){ ?>
                            <div class="card col-md-3" id="today_appiontments">
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
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Patients per month<button class="bg-green pull-right" data-toggle="collapse" data-target="#line-chart-patient" ><i class="fa fa-minus"></i></button></h4>
                    <div id="line-chart-patient" class="collapse" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

                 </div>
                  <div class="col-sm-6">
                     <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Fees Collected <button class="bg-green pull-right" data-toggle="collapse" data-target="#line-chart" ><i class="fa fa-minus"></i></button></h4>

                      <div id="line-chart" class="collapse" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>

                  </div>
                </div>
                <div class ="row chart">

                  <div class="col-sm-12">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Treatment Patient Footfall <button class="bg-green pull-right" data-toggle="collapse" data-target="#areachart" ><i class="fa fa-minus"></i></button></h4>
                     <div class="collapse" id="areachart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>  

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
});

Highcharts.chart('line-chart-patient', {
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
  series: [<?php echo $json3;?>]
});



Highcharts.chart('areachart', {
  chart: {
    type: 'area'
  },
  title: {
    text: ''
  },
  xAxis: {
    categories: ['Jan', 'Feb', 'March', 'April', 'May' ,'June' ,'July' ,'Aug' ,'Sep' ,'Oct' ,'Nov' ,'Dec'],
    tickmarkPlacement: 'on',
    title: {
      enabled: false
    }
  },
  yAxis: {
    title: {
      text: 'Total'
    },
    labels: {
      formatter: function () {
        return this.value
      }
    }
  },
  tooltip: {
    split: true,
    valueSuffix: ''
  },
  plotOptions: {
    area: {
      stacking: 'normal',
      lineColor: '#666666',
      lineWidth: 1,
      marker: {
        lineWidth: 1,
        lineColor: '#666666'
      }
    }
  },
  series: [<?php echo $json2.','.$json3;?>]
});

</script>
