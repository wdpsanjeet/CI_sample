<!doctype html>
<html lang="en">
    <?php $this->load->view('partial/header_script'); ?>
    <style>
       
      
    .files input {
    outline: 2px dashed #92b0b3;
    outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear;
    padding: 120px 0px 85px 35% !important;
    text-align: center !important;
    margin: 0;
    width: 100% !important;
}
.files input:focus{     outline: 2px dashed #92b0b3;  outline-offset: -10px;
    -webkit-transition: outline-offset .15s ease-in-out, background-color .15s linear;
    transition: outline-offset .15s ease-in-out, background-color .15s linear; border:1px solid #92b0b3;
 }
.files{ position:relative}
.files:after {  pointer-events: none;
    position: absolute;
    top: 60px;
    left: 0;
    width: 50px;
    right: 0;
    height: 56px;
    content: "";
    background-image: url(<?php echo base_url() ?>themes/useraccount/images/upload_drag_btn.png);
    display: block;
    margin: 0 auto;
    background-size: 100%;
    background-repeat: no-repeat;
}
.color input{ background-color:#f1f1f1;height: 250px!important;}
.files:before {
    position: absolute;
    bottom: 10px;
    left: 0;  pointer-events: none;
    width: 100%;
    right: 0;
    height: 57px;
    content: " or drag it here. ";
    display: block;
    margin: 0 auto;
    color: #2ea591;
    font-weight: 600;
    text-transform: capitalize;
    text-align: center;
}
.pac-container{
    z-index: 99999 !important;
}
    .autocomplete-box-state{
        position: absolute;
        background-color: #fff !important;
        z-index: 999;
        width: 95%;
    }
    .autocomplete-box-state ul li {
        padding: 4px;
        border: 1px solid #ccc;
    }
    .autocomplete-box-state ul li:hover {
        background-color: #ccc;
        cursor: pointer;
    }
    #locationSearchInput:focus {
      border-color: #4d90fe;
    }
      .input-controls {
      margin-top: 10px;
      border: 1px solid transparent;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      outline: none;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    } 
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
    .gm-style-iw-t{
        right: 15px !important;
    bottom: 30px !important;
    }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOGGLE_MAP_KEY;?>&region=in&libraries=places,geocoder"></script>
        <script>
/* script */
function initialize() {
    var postal_code='';
   var latlng = new google.maps.LatLng(17.39165726448401,78.43752262024394);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13,
      disableDefaultUI: true,
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29),
      icon: '<?php echo base_url() ?>themes/useraccount/images/mapmarker.png'
   });
    var input = document.getElementById('locationSearchInput');
    //map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    //autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();   
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        for (var i = 0; i < place.address_components.length; i++) {
      for (var j = 0; j < place.address_components[i].types.length; j++) {
        if (place.address_components[i].types[j] == "postal_code") {
          postal_code = place.address_components[i].long_name;

        }
      }
    }
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
       
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);          
    
        bindDataToForm(postal_code,place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);
       
    });
    // this function will work on marker move event into map 
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) { 
              for (var i = 0; i < results[0].address_components.length; i++) {
      for (var j = 0; j < results[0].address_components[i].types.length; j++) {
        if (results[0].address_components[i].types[j] == "postal_code") {
          postal_code = results[0].address_components[i].long_name;

        }
      }
    }
              bindDataToForm(postal_code,results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(postal_code,address,lat,lng){
    
   //document.getElementById('location').value = address;
   //document.getElementById('address').value = address;
   document.getElementById('customer_latitude').value = lat;
   document.getElementById('customer_longitude').value = lng;
  // document.getElementById('postal_code').value = postal_code;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.standalone.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    
    <body>
        <div class="body_sec">
            <?php $this->load->view('partial/left_menu'); ?>
            <div class="rgt_sidebar">
                <div class="rgt_tophead">
                    <?php $this->load->view('partial/top_header'); ?>


                    <div class="rgt-sidebar-body">
                        <div class="row">
                            <div class="col-md-8">
                                <form method="post" action="" id="filter-trip-form">
                                <div class="dash-tbl-topbar d-flex" style="margin-bottom: 30px;">
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
<!--                                    <div class="select-wrap">
                                        <label>Time:</label>
                                        <div class="dropdown">
                                            <input type="text" name="trip_start_time" id="trip_start_time" class="form-control timepicker" placeholder="Start time">
                                        </div>
                                        <div class="dropdown">
                                            <input type="text" name="trip_end_time" id="trip_end_time" class="form-control timepicker" placeholder="End time">
                                        </div>
                                    </div>-->

                                </div>
                                </form>
                            </div>
                            <div class="col-md-4">
                                <div class="dash-topbar-right d-flex">
                                    <div class="topbar-right-btn">
                                        <a href="#" data-toggle="modal" data-target="#addDeliveriesModel"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Bulk</a>
                                        <a href="#" data-toggle="modal" data-target="#addHocModel"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Adhoc</a>
                                    </div>
                                    <div class="dropdown ml-2">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Group
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Paid</a>
                                            <a class="dropdown-item" href="#">Unpaid</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7">
                                <form id="assign-deliveries-route-form" action="<?php echo base_url('useraccount/assign-deleiveries-route')?>" method="post">
                                    <input type="hidden" name="trip_date" value="<?php echo $trip_date;?>">
                                    <strong><i>Please select delivery date and assign route.</i></strong><br><br>
                                <div class="rgt-body-title">Bulk <span><img src="<?php echo base_url() ?>themes/useraccount/images/dicon1.png"></span></div>
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <div class="dash-cont-box" style="margin-bottom: 50px; background-color: #FAFAFA;">
                                            <?php 
                                            if($added_client_deliveries['total']!=0){
                                            foreach($added_client_deliveries['result'] as $list){?>
                                            
                                            <div class="tbl-box d-flex">
                                                <div class="tbl-boxleft">
                                                    <img src="<?php echo base_url() ?>themes/useraccount/images/dicon1.png">
                                                </div>
                                                <div class="tbl-boxright d-flex">
                                                    <span class="bdr-r"><marquee scrollamount="1" style="width: 70px;"><?php echo $list->company_name;?></marquee></span>
                                                    <span class="bdr-r"><?php echo $list->client_mobile;?></span>
                                                    <span class="bdr-addr"><?php echo $list->client_address;?></span>
                                                    <span class="bdr-addrpin"><i class="fa fa-map-marker fa-map-green" aria-hidden="true" onclick="OpenMapwrapper(this)" data-id="<?php echo $list->deliveries_id;?>"></i></span>
                                                    <span>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Route
                                                            </button>
                                                            <input type="hidden" class="deliveries" name="deliveries_master[<?php echo $list->deliveries_id;?>]" value="">
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <?php 
                                            if($routes['total']!=0){
                                            foreach($routes['result'] as $route){?>
                                                                <a class="dropdown-item" href="javascript:;" id="route_<?php echo $route->route_id;?>"><?php echo $route->route_name;?></a>
                                                                <?php }
                                            }
                                                                ?>
                                                                <hr />
                                                                <a class="dropdown-item add_route_btn" id="<?php echo $list->deliveries_id;?>" data-toggle="modal" data-target="#addRouteModel">Add Route</a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php }
                                            }else{?>
                                            <p>No Trips are Added</p>
                                           <?php }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="rgt-body-title">Adhoc <span><img src="<?php echo base_url() ?>themes/useraccount/images/dicon2.png"></span></div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="dash-cont-box" style="margin-bottom: 50px; background-color: #FAFAFA;">
                                            <?php 
                                            if($added_customer_deliveries['total']!=0){
                                            foreach($added_customer_deliveries['result'] as $list){?>
                                            
                                            <div class="tbl-box d-flex">
                                                <div class="tbl-boxleft">
                                                    <img src="<?php echo base_url() ?>themes/useraccount/images/dicon2.png">
                                                </div>
                                                <div class="tbl-boxright d-flex">
                                                    <span class="bdr-r"><marquee scrollamount="1" style="width: 70px;"><?php echo $list->customer_name;?></marquee></span>
                                                    <span class="bdr-r"><?php echo $list->mobile_number;?></span>
                                                    <span class="bdr-addr"><?php echo $list->address;?></span>
                                                    <span class="bdr-addrpin"><i class="fa fa-map-marker fa-map-green" onclick="OpenMapwrapper(this)" data-id="<?php echo $list->deliveries_id;?>" aria-hidden="true"></i></span>
                                                    <span>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                Route
                                                            </button>
                                                            <input type="hidden" class="deliveries" name="deliveries_master[<?php echo $list->deliveries_id;?>]" value="">
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                <?php 
                                            if($routes['total']!=0){
                                            foreach($routes['result'] as $route){?>
                                                                <a class="dropdown-item" href="javascript:;" id="route_<?php echo $route->route_id;?>"><?php echo $route->route_name;?></a>
                                                                <?php }
                                            }
                                                                ?>
                                                                <hr />
                                                                <a class="dropdown-item add_route_btn" id="<?php echo $list->deliveries_id;?>" data-toggle="modal" data-target="#addRouteModel">Add Route</a>
                                                            </div>
                                                        </div>
                                                    </span>
                                                </div>
                                            </div>
                                            <?php }
                                            }else{?>
                                            <p>No Trips are Added</p>
                                           <?php }
                                            ?>
                                        </div>
                                        <div class="link-btn text-right"><a class="gray" id="assign_deliveries_trip" href="#"> Assign</a></div>
                                    </div>
                                </div>
                            </form>
                            </div>
                            <div class="col-md-5">
                                <div class="row"><div class="col-md-12" style="margin-top:50px;">&nbsp;</div></div>
                                <div class="row"><div class="col-md-12">
                                        
                                        <div id="show_map_route_view">
                                            <img class="route-map" style="min-height: 500px;" src="<?php echo base_url() ?>themes/useraccount/images/map1.png"/>
                                </div></div></div>
                                
                            </div>
                        </div>





                    </div>


                </div>
            </div>
        </div>
        <!-- add route Modal -->
<div class="modal fade dash-modal" id="importCustomerOrderModel" tabindex="-1" role="dialog" aria-labelledby="importCustomerOrderModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="importCustomerOrderModelTitle">Import Orders </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-import-customer-order')?>" id="do-import-customer-order-form" method="post">
            <div class="row top-row">
        		<div class="col-md-12">
        			<div class="form-group files color">
                                    <a href="<?php echo base_url().'uploads/customer_order/customerOrderImportSampleFile.xlsx';?>">Download Sample File</a>
                                    <input type="file" name="uploadFile" class="form-control" multiple="">
              </div>
        		</div>
        		
        	</div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-center">
                                    <button type="submit" name="submit" value="submit">Submit</button>
        			</div>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
        <a href="#" data-toggle="modal" id="importCustomerOrderModelHiddenBtn" data-target="#importCustomerOrderModel" style="display:none"></a>
        <!-- add hoc Modal -->
<div class="modal fade dash-modal" id="addHocModel" tabindex="-1" role="dialog" aria-labelledby="addHocModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="addHocModelTitle">Adhoc </h5><div class="ml-auto topbar-right-btn">
              <a href="javascript:;" onclick="openimportCustomerOrderModelBtn()">Import</a>
            </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-add-hoc')?>" id="do-add-hoc-form" method="post">
            <input type="hidden" name="customer_latitude" id="customer_latitude" value="" />
            <input type="hidden" name="customer_longitude" id="customer_longitude" value="" />
            <div class="row top-row">
                <div class="col-md-8">
                    <div class="row top-row">
        		<div class="col-md-6">
        			<div class="form-group">
                                    <input type="text" name="order_id" class="form-control" placeholder="Order Id">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group text-center">
        				<input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
        			</div>
        		</div>
        		</div>
                    <div class="row top-row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<input type="text" name="mobile_number" class="form-control" placeholder="Mobile Number">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group text-center">
        				<input type="text" name="pin_code" class="form-control" placeholder="Pin code">
        			</div>
        		</div>
        		</div>
                    <div class="row top-row">
        		<div class="col-md-12">
        			<div class="form-group">
                                    <textarea style="height:100px" class="form-control" name="address" value="" placeholder="Address"></textarea>
        			</div>
        		</div>
        		
        		</div>
                    <div class="row top-row">
        		<div class="col-md-12">
        			<div class="form-group">
        				<textarea style="height:100px" name="order_detail" class="form-control" placeholder="Order Details"></textarea>
        			</div>
        		</div>
        		
        		</div>
                    </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <input id="locationSearchInput" name="locationSearchInput"  value="" type="text" class="form-control input-controls" autofocus="autofocus" placeholder="Geo Location" value="">
                        <span class="text-danger"></span>
                    </div>
                    <div class="">
                      <div class="map" id="map" style="width: 100%; height: 300px;margin-top: 10px"></div>
                    </div>
                </div>
        	</div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-left">
        				<button type="submit">Add</button>
                                        <a href="#" class="cancel">Clear</a>
        			</div>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- add route Modal -->
<div class="modal fade dash-modal" id="addRouteModel" tabindex="-1" role="dialog" aria-labelledby="addRouteModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="addRouteModelTitle">Create new route </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-add-route')?>" id="do-add-route-form" method="post">
            <input type="hidden" name="deliveries_id" id="deliveries_id" value="">
            <div class="row top-row">
        		<div class="col-md-12">
        			<div class="form-group">
                                    <input type="text" name="route_name" id="route_name" class="form-control" placeholder="Route name">
        			</div>
        		</div>
        		
        	</div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-center">
        				<button type="submit">Ok</button>
                                        <a href="#" class="cancel">Cancel</a>
        			</div>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- add delivery Modal -->
<div class="modal fade dash-modal" id="addDeliveriesModel" tabindex="-1" role="dialog" aria-labelledby="addDeliveriesModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="addDeliveriesModelTitle">Deliveries </h5><div class="modelrgt"><form class="ms-auto search-form d-none d-md-block" action="#">
              <div class="form-group">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="search" class="form-control" placeholder="search..." id="deliveries_srchbox">
              </div>
    </form></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
        <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-add-deliveries')?>" id="do-add-deliveries-form" method="post">
            <div class="row"><span class="alert alert-danger" id="add_deliveries_error" style="display:none;width:95%"></span></div>
            <div id="deliveries_listbox">
            <?php $i=0; foreach($clients['result'] as $list){
                if(($i%3)==0 || $i==0){?>
        	<div class="row top-row">
                <?php }?>
        		<div class="col-md-4">
        			<div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="deliveries[]" id="exampleCheck<?php echo $list->client_id?>" value="<?php echo $list->client_id?>">
                                        <label class="form-check-label" for="exampleCheck<?php echo $list->client_id?>"><?php echo $list->company_name?></label>
                                        <p><?php echo $list->client_address?></p>
        			</div>
        		</div>
            <?php $i++;
            if(($i%3)==0){?>
                </div>
            <?php }
                }?>
            <?php if(($clients['total']%3)!=0){?>
                </div>
            <?php }?>
    </div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-right">
        				<button type="submit">Add Deliveries</button>
        			</div>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>

        <?php $this->load->view('partial/footer_script'); ?>  

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
    $(document).ready(function () {
        $('#deliveries_srchbox').keyup(function(){
            var searchField = $(this).val();
            $.ajax({
            url: '<?php echo base_url().'useraccount/do-add-deliveries-search'?>',
            type: 'POST',
            dataType: 'json',
            data: {searchField:searchField},
            success: function (resp) {
                if (resp.status === 200) {
                    $("#deliveries_listbox").html(resp.html);
                } 
            }
        }).fail(function () {
        });
        });
    $(document).on('submit', '#do-add-deliveries-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        data.append('trip_date',$("#trip_date").val());
        data.append('trip_start_time',$("#trip_start_time").val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                        $('#filter-trip-form').submit();
                    }
                } else if(resp.status === 500){
                    $("#add_deliveries_error").text(resp.message.trip_date).show();
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-deliveries-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(document).on('submit', '#do-add-route-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                        $('#do-add-route-form').trigger('reset');
                        $("#addRouteModel").find('[data-dismiss="modal"]').trigger('click');
                        //var selected_route_obj = $("#deliveries_id").val();
                        $(".dropdown-menu").each(function(){
                            $(this).prepend('<a class="dropdown-item" href="javascript:;" id="route_'+resp.route_list.route_id+'">'+resp.route_list.route_name+'</a>');
                        });
                        
                        //$("#"+selected_route_obj).parent().prepend('<a class="dropdown-item" href="#">'+resp.route_list.route_name+'</a>');
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-route-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(document).on('submit', '#do-add-hoc-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        data.append('trip_date',$("#trip_date").val());
        data.append('trip_start_time',$("#trip_start_time").val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                       $('#filter-trip-form').submit();
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-hoc-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(document).on('submit', '#do-import-customer-order-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        data.append('trip_date',$("#trip_date").val());
        data.append('trip_start_time',$("#trip_start_time").val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                       $('#filter-trip-form').submit();
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-hoc-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(".add_route_btn").click(function(){
        //alert($(this).attr("id"));
        $("#deliveries_id").val($(this).attr("id"));
    });
    });
    $(function () {
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
}).change(dateChanged)
    .on('changeDate', dateChanged);;
});
$(function(){

    $("#assign-deliveries-route-form .dropdown-menu a").click(function(){

      $(this).parent().parent().find('button').text($(this).text());
      $(this).parent().parent().find('button').val($(this).text());
      var fields = $(this).attr('id').split('route_');
      var route_selected_id = fields[1];
      $(this).parent().parent().find('input').val(route_selected_id);
      var assignbtnEnable=true;
      $(".deliveries").each(function(){
        // Test if the div element is empty
        if($(this).val()==''){
           assignbtnEnable=false;
        }
    });
    if(assignbtnEnable){
        $("#assign_deliveries_trip").removeClass('gray');
        $("#assign_deliveries_trip").attr('onclick','submitAssignPlan()')
    }
   });

});
function dateChanged(ev) {
    $('#filter-trip-form').submit();
}
$('.timepicker').timepicker({});
function openimportCustomerOrderModelBtn(){
    $("#addHocModel").find('[data-dismiss="modal"]').trigger('click');
    $("#importCustomerOrderModelHiddenBtn").trigger('click');
}

function submitAssignPlan(){
    $("#assign-deliveries-route-form").submit();
}

    </script>
    <script>
    var map_key = '<?php echo GOGGLE_MAP_KEY;?>';
    
    var full_url = '<?php echo base_url();?>';
    var map_icon_custome = '<?php echo base_url();?>themes/useraccount/images/mapicon.png';
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/useraccount/js/createHTMLMapMarker.js"></script>
    <script>
    
    function OpenMapwrapper(obj) {
    var id = $(obj).data('id');
    
    if ($('#openMapawrapper_' + id).length > 0) {
        $('.mapwrapperclass').remove();
        // $('#openMapawrapper_' + id).parents('tr').remove();
    } else {
        $('.mapwrapperclass').remove();
        

        //$('#openMapawrapper_' + id).html(contentLoader);
        $.ajax({
            url: '<?php echo base_url('useraccount/show-map-deliveries')?>',
            type: 'POST',
            dataType: 'json',
            data: { deleveries_id: id},
            success: function (resp) {
                if (resp.routes && resp.routes.length > 0) {
                    var content = ``;
                    
                    content += `<div class="iframe-maps">
                        <div class="near-by-map" id="map" style="width: 100% !important;height: 50vh;"></div>
                    </div>`;
                    $('#show_map_route_view').html(content);
                    initialize();
                    addMarkerFromJson(resp.routes);
                    $('#map').css('height', '600');
                }
            }
        }).fail(function () {

        });
    }

}

    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/useraccount/js/deliveries_map.js"></script>
    </body>
</html>
