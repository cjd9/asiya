<?php $this->load->view('p_include/header'); ?>

	<?php $this->load->view('p_include/left'); ?>


       <style>
               .card {
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 5px; /* 5px rounded corners */
            height: 165px;
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
                      <?php if(!empty($rsactivity_program->result_array())){ ?>
                      <div class="alert alert-success">
                        <strong>Activity </strong>
                       <?php $unique=array(); $cnt = 0; foreach($rsactivity_program->result() as $row) : ?>
                  <?php if(!in_array($row->activity_id,$unique)){ $unique[] =$row->activity_id ; ?>

                          <br><?php echo substr($row->activity_program, 0, 100) ?> ....<a href="<?php print base_url(); ?>p_activity_program/view/<?php echo $row->activity_id; ?>" >Read more >></a>


                    <?php } endforeach ; ?>

                   <?php } ?>

                   </div>



                        <div align="center">
                            <!--<p><img src="<?php echo base_url(); ?>images/logo-1.jpg" height="50" width="60"/></p>-->
                <!--            <h1><b>WELCOME</b></h1>
                            <h4><b>To</b></h4>
                            <h1><b>Asiya Center of Physiotherapy & Rehabilitation</b></h1> -->
                        </div>


                        <div class="row appointments">
                          <div class = "col-sm-6">
                              <h4 class ="text-center panel-heading" style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Upcoming Appointments</h4>

                      <?php if(!empty($today_appointment)) { ?>

                              <table class="table table- table-responsive">
                                  <thead>
                                    <tr>
                                      <th>Date</th>
                                      <th>Time</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                             <?php foreach($today_appointment as $today){ ?>
                                  <tr>
                                    <td><?php echo $today['date_of_appointment'];  ?></td>
                                    <td><?php echo $today['time_slot'];  ?></td>
                                  </tr>
                             <?php } ?>
                                  </tbody>
                            </table>

                      <?php
                    }else{ ?>
                      <p><strong>No Appointments yet</strong></p>
                    <?php }  ?>
                        </div>

                   <div class = "col-sm-6">
                       <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Your Homework</h4>
                   <?php if(!empty($rsexercise_program)) { ?>

                      <table class="table table- table-responsive">

                                  <thead>
                                    <tr>
                                      <th>Description</th>
                                      <th>Expiry Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                             <?php foreach($rsexercise_program as $today){ ?>
                                  <tr>
                                    <td><?php echo substr($today['exercise_program'], 0, 100) ?> ....<a href="<?php print base_url(); ?>p_exercise_program/view/<?php echo $today['exercise_id']; ?>" >Go To Homework</a> </td>
                                    <td><?php echo $today['expiry_date'];  ?></td>
                                  </tr>
                             <?php } ?>
                                  </tbody>
                      </table>

                   <?php }else{ ?>
                      <p><strong>No Homework yet</strong></p>
                    <?php }  ?>
                    </div>
                 </div>

                 <div class ="row chart">

                  <div class="col-sm-12">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Samvaad Program</h4>

                     <?php $cnt = 0; foreach($rseducation_program->result() as $row) : ?>
                   <div class="card col-md-4" >
                    <div class="col-sm-6" >
                                    <img src="/education_thumbnail/<?php echo $row->thumbnail;  ?>" onerror="this.src='/images/Asiya.png';" alt="Avatar" style="width: 100%">
                                  </div>
                                  <div class="col-sm-6" >
                                    <h6 class=""><b><?php echo $row->title; ?></b></h6>

                      <p class=""><?php echo substr(strip_tags($row->education_program_desc), 0, 80);  ?></p>
                      <a href="/p_samvaad/view/<?php echo $row->pk; ?>">Read more>>> </a>
                                  </div>
                    </div>

                  <?php endforeach ; ?>
                  </div>
                </div>
                <div class ="row chart">

                  <div class="col-sm-6">
                    <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Monthly Treatments</h4>
                     <div id="line-chart-treatment" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                     <h5 class="text-center"> Your Total treatments till date: <b><?php echo $total_t_date['count'];?></b></h5>
                 </div>
                  <div class="col-sm-6">
                     <h4 class ="text-center panel-heading"  style="background-color: #8cac35;color: white; padding-bottom: 10px; padding-top: 5px;">Monthly Billing</h4>

                      <div id="line-chart" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                      <h5 class="text-center"> Your Total Fee till date: Rs.<b><?php echo $total_f_date['fee']?></b></h5>
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

Highcharts.chart('line-chart-treatment', {
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
  series: [<?php echo $json2;?>]
});



Highcharts.chart('areachart', {
  chart: {
    type: 'area'
  },
  title: {
    text: 'Historic and Estimated Worldwide Population Growth by Region'
  },
  subtitle: {
    text: 'Source: Wikipedia.org'
  },
  xAxis: {
    categories: ['1750', '1800', '1850', '1900', '1950', '1999', '2050'],
    tickmarkPlacement: 'on',
    title: {
      enabled: false
    }
  },
  yAxis: {
    title: {
      text: 'Billions'
    },
    labels: {
      formatter: function () {
        return this.value / 1000;
      }
    }
  },
  tooltip: {
    split: true,
    valueSuffix: ' millions'
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
  series: [{
    name: 'Asia',
    data: [502, 635, 809, 947, 1402, 3634, 5268]
  }, {
    name: 'Africa',
    data: [106, 107, 111, 133, 221, 767, 1766]
  }]
});

</script>


	<?php $this->load->view('p_include/footer'); ?>

    </body>
</html>
