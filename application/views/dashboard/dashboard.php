
       <style>
       @media (min-width: 768px) {
/* show 3 items */
            .carousel-inner .active,
            .carousel-inner .active + .item,
            .carousel-inner .active + .item + .item {
            display: block;
            }

            .carousel-inner .item.active:not(.item-right):not(.item-left),
            .carousel-inner .item.active:not(.item-right):not(.item-left) + .item,
            .carousel-inner .item.active:not(.item-right):not(.item-left) + .item + .item {
            transition: none;
            }

            .carousel-inner .item-next,
            .carousel-inner .item-prev {
            position: relative;
            transform: translate3d(0, 0, 0);
            }

            .carousel-inner .active.item + .item + .item + .item {
            position: absolute;
            top: 0;
            right: -33.3333%;
            z-index: -1;
            display: block;
            visibility: visible;
            }

            /* left or forward direction */
            .active.item-left + .item-next.item-left,
            .item-next.item-left + .item,
            .item-next.item-left + .item + .item,
            .item-next.item-left + .item + .item + .item {
            position: relative;
            transform: translate3d(-100%, 0, 0);
            visibility: visible;
            }

            /* farthest right hidden item must be abso position for animations */
            .carousel-inner .item-prev.item-right {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            display: block;
            visibility: visible;
            }

            /* right or prev direction */
            .active.item-right + .item-prev.item-right,
            .item-prev.item-right + .item,
            .item-prev.item-right + .item + .item,
            .item-prev.item-right + .item + .item + .item {
            position: relative;
            transform: translate3d(100%, 0, 0);
            visibility: visible;
            display: block;
            visibility: visible;
            }
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
                  <?php if($rsactivity_program->num_rows() > 0){ ?>
                     <div class="alert alert-success">
                        <strong>Activity </strong>
                       <?php $unique=array(); $cnt = 0; foreach($rsactivity_program->result() as $row) : ?>
                  <?php if(!in_array($row->activity_id,$unique)){ $unique[] =$row->activity_id ; ?>

                          <br><?php echo substr($row->activity_program, 0, 100) ?> ....<a href="<?php print base_url(); ?>activity_program/view/<?php echo $row->activity_id; ?>" >Read more >></a>


                   <?php } endforeach ;  ?>

                   </div>

                 <?php } ?>

                        <div align="center">
                          <?php if($rspatient_enquiry['count'] != 0)
                          { ?>
                           <div class="alert alert-info">
                        <strong>New Patient Inquiry </strong>   <br>You have <?php echo $rspatient_enquiry['count']?> pending inquiry from your patient....<a href="<?php print base_url(); ?>patient_enquiry" >Inqury page</a>

                      </div>
                      <?php } ?>
                 </div>

                <div class="row festival-bday">
                  <div class = "col-sm-6 container-fluid">
                        <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Today's Birthday </h4>

                <?php if(!empty($birthday_today)) {
                  $count = 1; ?>
                  <div id="myCarouselBirthday" class="carousel slide" data-ride="carousel" data-interval="false">
                   <div class="carousel-inner row w-100 mx-auto">
                      <div class="item col-md-4 active">

                         <div class="card text-center" id="">
                           <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $birthday_today[0]['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                               <div class="card-body">
                                 <h6 class="card-title"><b><?php echo $birthday_today[0]['p_fname'].' '.$birthday_today[0]['p_lname'];  ?></b></h6>
                             </div>
                         </div>
                       </div>
                  <?php   unset($birthday_today[0]); foreach($birthday_today as $today){ ?>
                    <div class="item col-md-4">

                      <div class="card text-center" id="">
                            <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $today['patient_id'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                            <div class="card-body">
                              <h6 class="card-title"><b><?php echo $today['p_fname'] .' '.$today['p_lname'];  ?></b></h6>
                          </div>
                      </div>
                    </div>
                        <?php
                         $count++; ?>

                <?php  } ?>


                     </div>
                     <a class="carousel-control-prev btn btn-primary" href="#myCarouselBirthday" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <i class="fa fa-arrow-left"></i>

                      </a>
                      <a class="carousel-control-next btn btn-primary pull-right" href="#myCarouselBirthday" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <i class="fa fa-arrow-right"></i>
                      </a>
                    </div>

              <?php }else{ ?>
                <p><strong>No Birthdays for Today</strong></p>
              <?php }  ?>
                  </div>

                  <div class = "col-sm-6 container-fluid">
                        <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Today's Festival </h4>

                <?php if(!empty($festival_today)) {
                  $count = 1; ?>
                  <div id="myCarouselFestival" class="carousel slide" data-ride="carousel" data-interval="false">
                   <div class="carousel-inner row w-100 mx-auto">
                      <div class="item col-md-4 active">

                         <div class="card text-center" id="">
                           <img class="card-img-top img-fluid" src="images/festival.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                               <div class="card-body">
                                 <h6 class="card-title"><b><?php echo $festival_today[0]['festival_name'];  ?></b></h6>
                             </div>
                         </div>
                       </div>
                  <?php   unset($festival_today[0]); foreach($festival_today as $today){ ?>
                    <div class="item col-md-4">

                      <div class="card text-center" id="">
                        <img class="card-img-top img-fluid" src="images/festival.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                            <div class="card-body">
                              <h6 class="card-title"><b><?php echo $today['festival_name'];  ?></b></h6>
                          </div>
                      </div>
                    </div>
                        <?php
                         $count++; ?>

                <?php  } ?>


                     </div>
                     <a class="carousel-control-prev btn btn-primary" href="#myCarouselFestival" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <i class="fa fa-arrow-left"></i>

                      </a>
                      <a class="carousel-control-next btn btn-primary pull-right" href="#myCarouselFestival" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <i class="fa fa-arrow-right"></i>
                      </a>
                    </div>

              <?php }else{ ?>
                <p><strong>No Festivals for Today</strong></p>
              <?php }  ?>
                  </div>
                </div>
                  <div class="row appointments" >
                        <div class = "col-sm-6 container-fluid">
                              <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Today's Appointments </h4>

                      <?php if(!empty($today_appointment)) {
                        $count = 1; ?>
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
                         <div class="carousel-inner row w-100 mx-auto">
                            <div class="item col-md-4 active">

                               <div class="card text-center" id="today_appiontments">
                                 <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $today_appointment[0]['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                                     <div class="card-body">
                                       <h6 class="card-title"><b><?php echo $today_appointment[0]['p_fname'];  ?></b></h6>
                                       <p class=" card-text" style="font-size:11px"><?php echo $today_appointment[0]['time_slot'];  ?></p>
                                   </div>
                               </div>
                             </div>
                        <?php   unset($today_appointment[0]); foreach($today_appointment as $today){ ?>
                          <div class="item col-md-4">

                            <div class="card text-center" id="today_appiontments">
                                  <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $today['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                                  <div class="card-body">
                                    <h6 class="card-title"><b><?php echo $today['p_fname'];  ?></b></h6>
                                    <p class= " card-text" style ="font-size:11px"><?php echo $today['time_slot'];  ?></p>
                                </div>
                            </div>
                          </div>
                              <?php
                               $count++; ?>

                      <?php  } ?>


                           </div>
                           <a class="carousel-control-prev btn btn-primary" href="#myCarousel" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                  <i class="fa fa-arrow-left"></i>
                            </a>
                            <a class="carousel-control-next btn btn-primary pull-right" href="#myCarousel" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <i class="fa fa-arrow-right"></i>
                            </a>
                          </div>

                    <?php }else{ ?>
                      <p><strong>No Appointments for Today</strong></p>
                    <?php }  ?>
                        </div>

                    <div class = "col-sm-6 container-fluid">
                              <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Tomorrow's Appointments </h4>

                      <?php if(!empty($tomorrow_appointment)) {
                        $count = 1; ?>
                        <div id="myCarouselTomorrow" class="carousel slide" data-ride="carousel" data-interval="false">
                         <div class="carousel-inner row w-100 mx-auto">
                            <div class="item col-md-4 active">

                               <div class="card text-center" id="tomorrow_appiontments">
                                 <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $tomorrow_appointment[0]['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                                     <div class="card-body">
                                       <h6 class="card-title"><b><?php echo $tomorrow_appointment[0]['p_fname'];  ?></b></h6>
                                       <p class=" card-text" style="font-size:11px"><?php echo $tomorrow_appointment[0]['time_slot'];  ?></p>
                                   </div>
                               </div>
                             </div>
                        <?php   unset($tomorrow_appointment[0]); foreach($tomorrow_appointment as $tomorrow){ ?>
                          <div class="item col-md-4">

                            <div class="card text-center" id="tomorrow_appiontments">
                                  <img class="card-img-top img-fluid" src="/patient_upload_data/<?php echo $tomorrow['p_lname'];  ?>.jpg" onerror="this.src='/images/default_man_photo.jpg';" alt="Avatar" style="">
                                  <div class="card-body">
                                    <h6 class="card-title"><b> <?php echo $tomorrow['p_fname'];  ?></b></h6>
                                    <p class= " card-text" style ="font-size:11px"><?php echo $tomorrow['time_slot'];  ?></p>
                                </div>
                            </div>
                          </div>
                              <?php
                               $count++; ?>

                      <?php  } ?>


                           </div>
                           <a class="carousel-control-prev btn btn-primary" href="#myCarouselTomorrow" role="button" data-slide="prev">
                              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                              <i class="fa fa-arrow-left"></i>

                            </a>
                            <a class="carousel-control-next btn btn-primary pull-right" href="#myCarouselTomorrow" role="button" data-slide="next">
                              <span class="carousel-control-next-icon" aria-hidden="true"></span>
                              <i class="fa fa-arrow-right"></i>
                            </a>
                          </div>

                    <?php }else{ ?>
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

                  <div class="col-sm-6">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Treatments vs Distinct Patients <button class="bg-green pull-right" data-toggle="collapse" data-target="#areachart" ><i class="fa fa-minus"></i></button></h4>
                     <div class="collapse" id="areachart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                 </div>
                  <div class="col-sm-6">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Working Days <button class="bg-green pull-right" data-toggle="collapse" data-target="#areachart" ><i class="fa fa-minus"></i></button></h4>
                     <div class="collapse" id="areachart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

                 </div>

                </div>
                <div class ="row chart">

                  <div class="col-sm-12">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Weekly Fee Collection <button class="bg-green pull-right" data-toggle="collapse" data-target="#line-chart-week" ><i class="fa fa-minus"></i></button></h4>
                      <div id="line-chart-week" class="collapse" style="min-width: 310px; max-width: 100%; height: 400px; margin: 0 auto"></div>

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
$(document).ready(function()
{
  $("#myCarousel",'#myCarouselTomorrow','#myCarouselBirthday','#myCarouselFestival').on("slide.bs.carousel", function(e) {
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 3;
    var totalItems = $(".item").length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
      var it = itemsPerSlide - (totalItems - idx);
      for (var i = 0; i < it; i++) {
        // append slides to end
        if (e.direction == "left") {
          $(".item")
            .eq(i)
            .appendTo(".carousel-inner");
        } else {
          $(".item")
            .eq(0)
            .appendTo($(this).find(".carousel-inner"));
        }
      }
    }
  });
});
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


Highcharts.chart('line-chart-week', {
  chart: {
    type: 'column'
  },
  title: {
    text: ''
  },
  subtitle: {
    text: 'Weekly Report'
  },
  credits: {
    enabled: false
  },
  xAxis: {
    categories: [ '1', '2', '3', '4' ,'5' ,'6' ,'7' ,'8' ,'9' ,'10' ,'11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52'
],
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
  series: [<?php echo $json5;?>]
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
      lineColor: '#666666',
      lineWidth: 1,
      marker: {
        lineWidth: 1,
        lineColor: '#666666'
      }
    }
  },
  credits: {
    enabled: false
  },
  series: [<?php echo $json2.','.$json6;?>]
});

</script>
