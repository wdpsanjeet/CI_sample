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
</style>

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
                                        <label>Date:</label>
                                        <div class="dropdown">
                                            
                                            <div class="input-group date" data-provide="datepicker">
                                                <input type="text" name="trip_date" value="<?php echo $trip_date;?>" id="trip_date" class="form-control datepicker" placeholder="Select Date">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="select-wrap">
                                        
                                    </div>

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
                                <form id="do-confirm-plan-form" action="<?php echo base_url('useraccount/do-confirm-plan');?>" method="post">
                                <div class="row"><span class="alert alert-danger" style="display:none;width:95%"></span></div>
                                <?php 
                                            if($added_client_deliveries_assigned['total']!=0){
                                                $current_route=0;
                                                $i=0;
                                                $j=0;
                                            foreach($added_client_deliveries_assigned['result'] as $list){
                                                if($current_route!=$list->route_id){
                                                    $j++;
                                                    $is_driver_assigned= $this->all_function->is_all_location_assigned_driver($list->route_id);
                                                    $route_name=$this->all_function->get_route_name($list->route_id);
                                                    ?>
                                                    <div class="row">
                                                        
                                    <div class="col-md-12">
                                        <div class="dash-cont-box" id="route_box_<?php echo $list->deliveries_id?>" style="margin-bottom: 50px; background-color: #FAFAFA;">
                                            <div class="row" style="padding:10px"> <div class="col-md-4"  style="padding:10px"><?php echo $route_name;?></div><div class="col-md-7 <?php echo ($is_driver_assigned)?'drivernassignboxgreen':'drivernassignbox';?>" id="driver_assigned_box_<?php echo $list->route_id;?>" style="padding:10px"><div class="row"><div class="col-md-8">Driver: <span id="driver_name_route_<?php echo $list->route_id;?>"><?php echo ($is_driver_assigned)?$list->driver_name.' '.$list->driver_phone:'Not Assigned';?></span></div><div class="col-md-4 text-right"><i class="fa fa-edit add_driver" aria-hidden="true" data-toggle="modal" data-target="#addDriversModel"><input type="hidden" name="route_id" value="<?php echo $list->route_id;?>" /></i>&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-trash" aria-hidden="true" onclick="deleteRoute(this,'<?php echo $list->route_id?>')"></i></div></div></div><div class="col-md-1"><img onclick="routeToggle(this)" src="<?php echo base_url().'themes/useraccount/images/arrow-down.png';?>" data-id="<?php echo $j;?>" /></div></div>
                                            <div id="sortable-row-<?php echo $j;?>">
                                                <?php }
                                                $location_name = '';
                                                $location_mobile = '';
                                                $location_address = '';
                                                if($list->type==0){
                                                    $location_name = $list->company_name;
                                                    $location_mobile = $list->client_mobile;
                                                    $location_address = $list->client_address;
                                                    $type_image='dicon1.png';
                                                }else{
                                                    $location_name = $list->customer_name;
                                                    $location_mobile = $list->mobile_number;
                                                    $location_address = $list->address;
                                                    $type_image='dicon2.png';
                                                }
                                                
                                                ?>
                                
                                                
                                            
                                            <div class="tbl-box d-flex">
                                                <div class="tbl-boxleft">
                                                    <img src="<?php echo base_url() ?>themes/useraccount/images/<?php echo $type_image;?>">
                                                    <input class="deliveries_id" type="hidden" name="order_list[<?php echo $list->route_id?>][<?php echo $list->deliveries_id?>]" value="<?php echo $list->deliveries_id?>"/>
                                                </div>
                                                <div class="tbl-boxright d-flex">
                                                    <span class="bdr-alloc-r"><?php echo $location_name;?></span>
                                                    <span class="bdr-r"><?php echo $location_mobile;?></span>
                                                    <span class="bdr-addr"><?php echo $location_address;?></span>
                                                    <span class="bdr-addrpin"  style="padding-right: 30px;"><i class="fa fa-map-marker fa-map-green" aria-hidden="true"></i></span>
                                                    
                                                </div>
                                                <div class="tbl-delete-box">
                                                    <i class="fa fa-trash fa-2x" aria-hidden="true" onclick="deleteDeliveries(this,'<?php echo $list->deliveries_id?>')"></i>
                                                </div>
                                            </div>
                                            
                                            
                                        
                                <?php 
                                $current_route=$list->route_id;
                                $i++;
                                if(isset($added_client_deliveries_assigned['result'][$i]->route_id)){
                                if($list->route_id!=$added_client_deliveries_assigned['result'][$i]->route_id){?>
                                                
                                                </div>
                                            <div class="select-wrap text-left">
                                        <label>Time:</label>
                                        <div class="dropdown">
                                            <input type="text" name="trip_start[<?php echo $list->route_id?>]" class="form-control timepicker" placeholder="Start time">
                                        </div>
                                        <div class="dropdown">
                                            <input type="text" name="trip_end[<?php echo $list->route_id?>]" class="form-control timepicker" placeholder="End time">
                                        </div>
                                        <div style="float:right"><input type="checkbox" name="is_come_warehouse[]" value="<?php echo $list->route_id?>" onchange="updateWarehouseReturn(this)" />&nbsp;Is it come to Warehouse?</div>
                                    </div>
                                            <div class="link-btn text-right"><a class="" id="assign_warehouse" style="margin-right: 5px;"  href="javascript:;" onclick="assignWarehouse('<?php echo $list->route_id;?>')"> Assign Warehouse</a><a class="" href="javascript:;" onclick="OpenMapwrapper(this)" data-id="1"> Route Map</a></div>
                                    </div>
                                    </div>
                                </div>
                                            <?php }
                                            
                                }else{?>
                                
                                    </div>
                            <div class="select-wrap text-left">
                                        <label>Time:</label>
                                        <div class="dropdown">
                                            <input type="text" name="trip_start[<?php echo $list->route_id?>]" id="trip_start_time" class="form-control timepicker trip_start" placeholder="Start time">
                                        </div>
                                        <div class="dropdown">
                                            <input type="text" name="trip_end[<?php echo $list->route_id?>]" id="trip_end_time" class="form-control timepicker trip_end" placeholder="End time">
                                        </div>
                                        <div style="float:right"><input type="checkbox" name="is_come_warehouse[]" value="<?php echo $list->route_id?>"  onchange="updateWarehouseReturn(this)"/>&nbsp;Is it come to Warehouse?</div>
                                    </div>
                            <div class="link-btn text-right"><a class="" id="assign_warehouse" style="margin-right: 5px;"  href="javascript:;" onclick="assignWarehouse('<?php echo $list->route_id;?>')"> Assign Warehouse</a><a class="" href="javascript:;" onclick="OpenMapwrapper(this)"  data-id="2"> Route Map</a></div>
                                   </div>
                                    </div>
                                </div>
                             <?php  }
                                            }
                                            }?>
                    <div class="link-btn text-right"><a class="" id="assign_deliveries_trip" href="javascript:;" onclick="confirmPlan()"> Confirm Plan</a></div>
                </div>
            <button type="submit" name="allocation_confirm" id="allocation_confirm" value="1" style="display:none" /></button>
                            </form>
                            <div class="col-md-5">
                                <div class="form-group">
                                    
                                </div>
                                <div class="" id="show_map_route_view">
                                    
                                    <img class="route-map" src="<?php echo base_url() ?>themes/useraccount/images/map1.png"/>
                                </div>
                            </div>
                        </div>





                    </div>


                </div>
            </div>
        </div>
        <div class="modal fade dash-modal" id="addDriversModel" tabindex="-1" role="dialog" aria-labelledby="addDriversModelTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="addDriversModelTitle">Drivers </h5><div class="modelrgt"><form class="ms-auto search-form d-none d-md-block" action="#">
              <div class="form-group">
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="search" class="form-control" placeholder="search..." id="driver_srchbox">
              </div>
    </form></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-add-deliveries-driver')?>" id="do-add-deliveries-driver-form" method="post">
            <input type="hidden" name="assigned_route" id="assigned_route" value="" />
            <div id="driver_listbox">
            <?php $i=0; foreach($drivers['result'] as $list){
                if(($i%2)==0 || $i==0){?>
        	<div class="row top-row">
                <?php }?>
        		<div class="col-md-6">
        			<div class="form-check">
                                    <input type="radio" class="form-check-input" name="drivers" id="exampleRadiosDriver_<?php echo $list->driver_id?>" value="<?php echo $list->driver_id?>">
                                    <label class="form-check-label" for="exampleRadiosDriver_<?php echo $list->driver_id?>"><?php echo $list->name?>&nbsp;<?php echo $list->phone?></label>
        			</div>
        		</div>
            <?php $i++;
            if(($i%2)==0){?>
                </div>
            <?php }
                }?>
            <?php if(($drivers['total']%2)!=0){?>
                </div>
            <?php }?>
    </div>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-right">
        				<button type="submit">Add Drivers</button>
        			</div>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
        <a data-toggle="modal" data-target="#addWarehouseModel" id="hiddenBtnWarehouseModel">fdgdfgdfg</a>
        <div class="modal fade dash-modal" id="addWarehouseModel" tabindex="-1" role="dialog" aria-labelledby="addWarehouseModelTitle" aria-hidden="false">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="addWarehouseModelTitle">Warehouse </h5><div class="modelrgt"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> 
      </div>
      <div class="modal-body">
        <form action="<?php echo base_url('useraccount/do-add-deliveries-warehouse')?>" id="do-add-deliveries-warehouse-form" method="post">
            <input type="hidden" name="assigned_route_warehouse" id="assigned_route_warehouse" value="" />
            <?php $i=0; foreach($warehouse['result'] as $list){
                if(($i%2)==0 || $i==0){?>
        	<div class="row top-row">
                <?php }?>
        		<div class="col-md-6">
        			<div class="form-check">
                                    <input type="radio" class="form-check-input" name="warehouse" id="exampleWarehouse<?php echo $list->warehouse_id?>" value="<?php echo $list->warehouse_id?>">
                                    <label class="form-check-label" for="exampleWarehouse<?php echo $list->warehouse_id?>"><?php echo $list->warehouse_name?></label>
        			</div>
        		</div>
            <?php $i++;
            if(($i%2)==0){?>
                </div>
            <?php }
                }?>
            <?php if(($warehouse['total']%2)!=0){?>
                </div>
            <?php }?>
        	<div class="row">
        		<div class="col-md-12">
        			<div class="form-group text-right">
        				<button type="submit">Add Warehouse</button>
        			</div>
        		</div>
        	</div>
        </form>
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
</div>
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
    
    function OpenMapwrapper(obj) {
    var deleveriesArray = [];
    var id = $(obj).data('id');
    var deleveriesObj = $(obj).parent().parent().attr('id');
    $("#"+deleveriesObj +" .deliveries_id").each(function(){
        deleveriesArray.push($(this).val());
    });
    
    if ($('#openMapawrapper_' + id).length > 0) {
        $('.mapwrapperclass').remove();
        // $('#openMapawrapper_' + id).parents('tr').remove();
    } else {
        $('.mapwrapperclass').remove();
        

        //$('#openMapawrapper_' + id).html(contentLoader);
        $.ajax({
            url: '<?php echo base_url('useraccount/show-map-route')?>',
            type: 'POST',
            dataType: 'json',
            data: { route_id: id,trip_date:$("#trip_date").val(),deleveries_ids:JSON.stringify(deleveriesArray)},
            success: function (resp) {
                if (resp.routes && resp.routes.length > 0) {
                    var content = ``;
                    
                    content += `<div class="iframe-maps">
                        <div class="near-by-map" id="map" style="width: 100% !important;height: 50vh;"></div>
                    </div>`;
                    $('#show_map_route_view').html(content);
                    initialize();
                    addMarkerFromJson(resp.routes);
                    var dynaHight = $('#show_map_route_view').height();
                    $('#map').css('height', dynaHight);
                }
            }
        }).fail(function () {

        });
    }

}
    </script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/useraccount/js/map.js"></script>
<script>
    function routeToggle(obj){
        var id = $(obj).data('id');
        $("#sortable-row-"+id).toggle();
    }
    function assignWarehouse(route_id){
        $("#assigned_route_warehouse").val(route_id);
        $("#hiddenBtnWarehouseModel").trigger('click');
    }
    function deleteRoute(obj,id){
        $parent = $(obj).parent().parent().parent().parent().parent().parent().parent();
    $.ajax({
            url: '<?php echo base_url('useraccount/delete-route')?>',
            type: 'POST',
            dataType: 'json',
            data: {id:id},
            success: function (resp) {
                if (resp.status === 200) {
                    $parent.remove();
                } else {
                    $('.alert-danger').html(resp.message).show();
                }
            }
        }).fail(function () {
        });
    }
    function deleteDeliveries(obj,id){
    $parent = $(obj).parent().parent();
    $.ajax({
            url: '<?php echo base_url('useraccount/delete-route-deliveries')?>',
            type: 'POST',
            dataType: 'json',
            data: {id:id},
            success: function (resp) {
                if (resp.status === 200) {
                    $parent.remove();
                } else {
                    $('.alert-danger').html(resp.message).show();
                }
            }
        }).fail(function () {
        });
}
    $(document).ready(function () {
    $(document).on('submit', '#do-import-customer-order-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
        data.append('trip_date',$("#trip_date").val());
        //data.append('trip_start_time',$("#trip_start_time").val());
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
        $('#driver_srchbox').keyup(function(){
            var searchField = $(this).val();
            $.ajax({
            url: '<?php echo base_url().'useraccount/do-add-driver-search'?>',
            type: 'POST',
            dataType: 'json',
            data: {searchField:searchField},
            success: function (resp) {
                if (resp.status === 200) {
                    $("#driver_listbox").html(resp.html);
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
        //data.append('trip_start_time',$("#trip_start_time").val());
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
    $(document).on('submit', '#do-add-deliveries-driver-form', function (event) {
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
                        //$('#filter-trip-form').submit();
                        $("#driver_assigned_box_"+resp.route_driver.route_id).removeClass('drivernassignbox').addClass('drivernassignboxgreen');
                        $("#driver_name_route_"+resp.route_driver.route_id).text(resp.route_driver.driver_detail);
                        $("#addDriversModel").find('[data-dismiss="modal"]').trigger('click');
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-deliveries-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(document).on('submit', '#do-add-deliveries-warehouse-form', function (event) {
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
                        //$('#filter-trip-form').submit();
                        //$("#driver_assigned_box_"+resp.route_driver.route_id).removeClass('drivernassignbox').addClass('drivernassignboxgreen');
                        //$("#driver_name_route_"+resp.route_driver.route_id).text(resp.route_driver.driver_detail);
                        $("#addWarehouseModel").find('[data-dismiss="modal"]').trigger('click');
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-deliveries-warehouse-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(".add_driver").click(function(){
    $("#assigned_route").val($(this).find('input').val());
    
});
$(document).on('submit', '#do-confirm-plan-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        $(".trip_start").each(function(){
        if($(this).val()==''){
            $('.alert-danger').html('Please add start and end time for each trip.').show();
        }
    });
    $(".trip_end").each(function(){
        if($(this).val()==''){
            $('.alert-danger').html('Please add start and end time for each trip.').show();
        }
    });
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
                        $("#filter-trip-form").submit();
                    }
                } else {
                    $('.alert-danger').html(resp.message).show();
                }
            }
        }).fail(function () {
        });
    });
    });
    
    $(function () {
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
}).change(dateChanged)
    .on('changeDate', dateChanged);;
});

function dateChanged(ev) {
    $('#filter-trip-form').submit();
}
function openimportCustomerOrderModelBtn(){
    $("#addHocModel").find('[data-dismiss="modal"]').trigger('click');
    $("#importCustomerOrderModelHiddenBtn").trigger('click');
}

function updateWarehouseReturn(obj){
//    if($(obj).is(":checked")) {
//            alert($(obj).val());
//        }
        var url = '<?php echo base_url().'useraccount/update-warehouse-return'?>';
        
        var data = new FormData();
        data.append('trip_date',$("#trip_date").val());
        data.append('route_id',$(obj).val());
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
                        //$('#filter-trip-form').submit();
                        //$("#driver_assigned_box_"+resp.route_driver.route_id).removeClass('drivernassignbox').addClass('drivernassignboxgreen');
                        //$("#driver_name_route_"+resp.route_driver.route_id).text(resp.route_driver.driver_detail);
                        //$("#addWarehouseModel").find('[data-dismiss="modal"]').trigger('click');
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        //$('#do-add-deliveries-warehouse-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
}

$('.timepicker').timepicker({});
function confirmPlan(){
    $("#allocation_confirm").trigger('click');
}
    </script>
    <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
    <script>
  $(function() {
      <?php for($k=1;$k<=$j;$k++){?>
    $( "#sortable-row-<?php echo $k;?>" ).sortable({
	placeholder: "ui-state-highlight"
	});
      <?php }?>
        
  });
  
  </script>
    </body>
</html>
