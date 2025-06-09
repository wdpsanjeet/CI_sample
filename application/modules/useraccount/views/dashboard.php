<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Sales'],
          ['Apr','500'],
          ['May','400'],
          ['Jun','700'],
          ['Jul','800'],
          ['Aug','900'],
          ['Sep','400'],
          ['Oct','600'],
          ['Nov','900'],
          ['Dec','700'],
          ['Jan','400'],
          ['Feb','800'],
          ['Mar','900'],
        ]);

        var options = {
          chart: {
            title: 'Company Sales Performance',
            subtitle: 'Sales performance for <?php echo date('Y');?>',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Sales'],
          ['Apr','500'],
          ['May','400'],
          ['Jun','700'],
          ['Jul','800'],
          ['Aug','900'],
          ['Sep','400'],
          ['Oct','600'],
          ['Nov','900'],
          ['Dec','700'],
          ['Jan','400'],
          ['Feb','800'],
          ['Mar','900'],
        ]);

        var options = {
          chart: {
            title: 'Company Purchase Performance',
            subtitle: 'Purchase performance for <?php echo date('Y');?>',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material1'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">

          	<div class="dash-box-wrap d-flex">
          		<div class="dash-box">
          			<div class="media">
          				<div class="media-left"><img src="<?php echo base_url() ?>themes/useraccount/images/dash-icon1.png"></div>
          				<div class="media-body">
          					<h2>Total Receivables Dues</h2>
          				</div>
          				<div class="media-right">10</div>
          			</div>
          		</div>
          		<div class="dash-box">
          			<div class="media">
          				<div class="media-left"><img src="<?php echo base_url() ?>themes/useraccount/images/dash-icon1.png"></div>
          				<div class="media-body">
          					<h2>Total Payables Dues</h2>
          				</div>
          				<div class="media-right">10</div>
          			</div>
          		</div>
          		<div class="dash-box">
          			<div class="media">
          				<div class="media-left"><img src="<?php echo base_url() ?>themes/useraccount/images/dash-icon1.png"></div>
          				<div class="media-body">
          					<h2>Pending sales</h2>
          				</div>
          				<div class="media-right">10</div>
          			</div>
          		</div>
          		<div class="dash-box">
          			<div class="media">
          				<div class="media-left"><img src="<?php echo base_url() ?>themes/useraccount/images/dash-icon1.png"></div>
          				<div class="media-body">
          					<h2>Pending purchase</h2>
          				</div>
          				<div class="media-right">10</div>
          			</div>
          		</div>
          		<div class="dash-box">
          			<div class="media">
          				<div class="media-left"><img src="<?php echo base_url() ?>themes/useraccount/images/dash-icon1.png"></div>
          				<div class="media-body">
          					<h2>Reports</h2>
          				</div>
          				<div class="media-right"></div>
          			</div>
          		</div>
          	</div>

          	<div class="row">
          		<div class="col-md-6">
          			<div class="map-box" style="padding:15px">
          				<div id="columnchart_material" style="height: 400px;"></div>
          			</div>
          		</div>
          		<div class="col-md-6">
          			<div class="map-box" style="padding:15px">
          				<div id="columnchart_material1" style="height: 400px;"></div>
          			</div>
          		</div>
          	</div>

<!--          	<div class="dash-cont-box">
          		<div class="dash-cont-title">Lorem Ipsum</div>
          		<div class="row">
          			<div class="col-md-6">
          				<img src="<?php echo base_url() ?>themes/useraccount/images/graph1.jpg">
          			</div>
          			<div class="col-md-3">
          				<img src="<?php echo base_url() ?>themes/useraccount/images/graph2.jpg">
          			</div>
          			<div class="col-md-3">
          				<img src="<?php echo base_url() ?>themes/useraccount/images/graph2.jpg">
          			</div>
          		</div>
          	</div>-->
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      
  </body>
</html>
