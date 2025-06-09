<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
      ul.progress_bar{
  
  width: 100%;
  padding: 0 40px 0 0;
  height: 2em;
  margin: 0;
  font-size: 15px; /* change font size only to scale*/
}

ul.progress_bar li{
  
  float: left;
  height: 100%;
  list-style: none;
  position: relative;
  margin: 0;
  padding: 0;
}

ul.progress_bar li span.completed{
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  background: #fa00ab;
  height: .4em;
  z-index: 1;
}
ul.progress_bar li span.inprogress{
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  background: #9a9699;
  height: .4em;
  z-index: 1;
}
ul.progress_bar_text{
  margin-bottom: 20px;
  width: 100%;
  padding: 0 40px 0 0;
  height: 2em;
  margin: 0 0 20px 0;
  font-size: 15px; /* change font size only to scale*/
}

ul.progress_bar_text li{
  float: left;
  height: 100%;
  list-style: none;
  position: relative;
  margin: 0;
  padding: 0;
}

ul.progress_bar_text li span{
  position: absolute;
  display: block;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  margin: auto;
  
  height: .4em;
  z-index: 1;
}

ul.progress_bar li.activated:before{
  background: #fff;
  border: 0.3em solid #fa00ab;
  box-sizing: border-box;
}


ul.progress_bar li.completed:before{
    content: '';
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    background: #b5b1b4;
    width: 2em;
    height: 2em;
    border-radius: 2em;
    z-index: 2;
}
ul.progress_bar li.inprogress:before{
    content: '';
    display: block;
    position: absolute;
    left: 0;
    top: 0;
    background: #c3c0c2;
    width: 2em;
    height: 2em;
    border-radius: 2em;
    z-index: 2;
}

ul.progress_bar li:last-child:after{
    content: '';
    display: block;
    position: absolute;
    right: -2em;
    top: 0;
    background: #b5b1b4;
    width: 2em;
    height: 2em;
    border-radius: 2em;
    z-index: 2;
}

/*ul.progress_bar_text li:last-child:after{
    content: 'Warehouse';
    display: block;
    position: absolute;
    right: -2em;
    top: 10px;
    width: 2em;
    height: 2em;
    border-radius: 2em;
    z-index: 2;
    margin-right: 40px;
}*/
.gm-style .gm-style-iw-c {
        background-color: #fa00ab !important;
    }
    .gm-style-iw-d{
        overflow: hidden !important;
        padding-bottom: 10px !important;
        color: white !important;
    }
    .gm-style .gm-style-iw-t::after {
    background: linear-gradient(
45deg,rgb(250 0 171) 50%,rgba(255,255,255,0) 51%,rgba(255,255,255,0) 100%) !important;
    }

    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.standalone.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="dash-tbl">
          		<div class="dash-tbl-topbar d-flex">
          			<div class="dash-tbl-topbar d-flex">
                                    <form method="post" action="" id="filter-trip-form">
          			<div class="select-wrap">
                                        <label>Delivery Date:</label>
                                        <div class="dropdown">
                                            
                                            <div class="input-group date" data-provide="datepicker">
                                                <input type="text" name="trip_date" value="<?php echo $trip_date;?>" id="trip_date" class="form-control datepicker" placeholder="Select Date">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
          		</div>
          		</div>
          		<table>
          			<thead>
          				<tr>
          					<th>Route</th>
          					<th>Driver</th>
          					<th>Mob No</th>
                                                <th>Started</th>
                                                <th>End</th>
          					<th>Status</th>
                                                <th>&nbsp;</th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php 
                                            if($driver_trips['total']!=0){
                                                
                                            foreach($driver_trips['result'] as $list){
                                                    ?>
          				<tr>	
          					
          					<td><?php echo $list->route_name;?></td>
          					<td><?php echo $list->driver_name;?></td>
                                                <td><?php echo $list->driver_phone;?></td>
                                                <td><?php echo date('d/M/Y',strtotime($list->assigned_date));?><br><?php echo date('h:i:s A',strtotime($list->trip_start_time))?></td>
                                                <td><?php echo date('d/M/Y',strtotime($list->assigned_date));?><br><?php echo date('h:i:s A',strtotime($list->trip_end_time))?></td>
                                                <td>
          						<button type="button" class="btn <?php echo ($list->is_trip_completed=='1')?'btn-success':'btn-warning';?>"><?php echo ($list->is_trip_completed=='1')?'Completed':'In Progress';?></button>
          					</td>
                                                <td>
                                                    <img onclick="OpenMapwrapper(this)" src="<?php echo base_url().'themes/useraccount/images/arrow-down.png';?>" data-id="<?php echo $list->assigned_trip_id;?>" />
                                                </td>
          				</tr>
                                        
                                            <?php }
                                            
                                            }?>
          				
          			</tbody>
          		</table>
          	</div>


        </div>
      </div>
    </div>
      <!-- add delivery Modal -->
<input type="hidden" class="field" id="locality" disabled="true" value="59.4370" name="city" />
<input type="hidden" class="field" id="administrative_area_level_1" value="24.7536" name="state" disabled="true" />
<input type="hidden" class="field" id="country" name="country" disabled="true" />
<input type="hidden" name="map_offset" value="0" />
<input type="hidden" name="has_click" value="0" />
<input type="hidden" name="zoom_level" value="10" />
    <?php $this->load->view('partial/footer_script'); ?> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
      <script>
    var map_key = '<?php echo GOGGLE_MAP_KEY;?>';
    
    var full_url = '<?php echo base_url();?>';
    var map_icon_custome = '<?php echo base_url();?>themes/useraccount/images/mapicon.png';
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/useraccount/js/createHTMLMapMarker.js"></script>
    <script>
    var contentLoader = '<div class="col-sm-12 text-center insideLoader"><div style="margin: 5%;font-size: 18px;"><i class="fa fa-cog fa-spin" aria-hidden="true"></i> Fetching...</div></div>';
    function OpenMapwrapper(obj) {
    var id = $(obj).data('id');
    
    if ($('#openMapawrapper_' + id).length > 0) {
        $('.mapwrapperclass').remove();
        // $('#openMapawrapper_' + id).parents('tr').remove();
    } else {
        $('.mapwrapperclass').remove();
        $(`
             <tr class="mapwrapperclass"><td colspan="7"><div id="openMapawrapper_${id}"></div></td></tr>
        `).insertAfter($(obj).closest('tr'));

        $('#openMapawrapper_' + id).html(contentLoader);
        $.ajax({
            url: '<?php echo base_url('useraccount/show-map-livetracking')?>',
            type: 'POST',
            dataType: 'json',
            data: { route_id: id},
            success: function (resp) {
                if (resp.routes && resp.routes.length > 0) {
                    var content = `<div class="row"><div class="col-sm-12">`+resp.progress_bar+`
</div>
</div><div class="row">
                    <div class="col-sm-6">
                    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Company</th>
      <th scope="col">Mobile</th>
      <th scope="col">Address</th>
      <th scope="col">KM</th>
      <th scope="col">Amount</th>    
    </tr>
  </thead>
  <tbody>
    
                    `;
                    resp.routes.forEach(element => {
                        if(element.company_name!=''){
                        content += `<tr>
      <td scope="row">${element.company_number}</td>
      <td>${element.company_name}</td>
      <td>${element.client_mobile}</td>
      <td>${element.address}</td>
      <td>${element.distance}</td>
      <td>${element.amount}</td>
    </tr>`;
      }              
      });
                    content += `
                    </tbody></table></div>
                    <div class="col-sm-6"><div class="iframe-maps">
                        <div class="near-by-map" id="map" style="width: 100% !important;height: 50vh;"></div>
                    </div></div> `;
                    $('#openMapawrapper_' + id).html(content);
                    initialize();
                    addMarkerFromJson(resp.routes);
                    var dynaHight = $('#openMapawrapper_' + id).height();
                    $('#map').css('height', dynaHight);
                }
            }
        }).fail(function () {

        });
    }

}
$(function () {
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
}).change(dateChanged)
    .on('changeDate', dateChanged);;
});
function dateChanged(ev) {
    $('#filter-trip-form').submit();
}
$('.timepicker').timepicker({});
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/useraccount/js/map_tracking.js"></script>
  </body>
</html>
