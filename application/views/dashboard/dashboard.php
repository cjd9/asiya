        
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
                    
                    <div id="line-chart" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>


                    <div class="contentpanel">
					
                     <?php if($this->session->flashdata('message')) { echo flash_message(); } ?>

                        <br /><br />

                        <div align="center">
							<!--<p><img src="<?php echo base_url(); ?>images/logo-1.jpg" height="50" width="60"/></p>-->
				<!-- 			<h1><b>WELCOME</b></h1>
							<h4><b>To</b></h4>
							<h1><b>Asiya Center of Physiotherapy & Rehabilitation</b></h1> -->
						</div>
                        <div class="row">
                        <div class = "col-sm-12">
                              <h2 class ="text-center panel-heading" style="background-color: #8cac35;color: white;">Today's Appointments</h2> 

                            <div class="card" style="width:20%">
                              <img src="/patient_upload_data/ACP0309.jpg" alt="Avatar" style="width: 100%">
                              <div class="container">
                                <h4><b>John Doe</b></h4> 
                                <h5>9.30pm</h5> 
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class ="row>"
                   <div class = "col-sm-12">
                       <h2 class ="text-center panel-heading" style="background-color: #8cac35;color: white;">Tomorrows's Appointments</h2> 

                         <div class="card" style="width:20%">
                          <img src="/images/default_man_photo.jpg" alt="Avatar" style="width:100%">
                          <div class="container">
                            <h4><b>John Doe</b></h4> 
                            <h5>9.30pm</h5> 
                          </div>
                        </div>
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
    type: 'bar'
  },
  title: {
    text: 'Historic World Population by Region'
  },
  subtitle: {
    text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
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
      text: 'Population (millions)',
      align: 'high'
    },
    labels: {
      overflow: 'justify'
    }
  },
  tooltip: {
    valueSuffix: ' millions'
  },
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
  series: [{name:'treatment',data:[0,3,0,0,4,0,0,0,0,0,0,0]},{name:'fee',data:[0,2.4,0,0,1.2,0,0,0,0,0,0,0]}]
});</script>

