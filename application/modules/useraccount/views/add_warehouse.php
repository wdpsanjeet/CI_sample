<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
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
    
    #searchInput:focus {
      border-color: #4d90fe;
    }
      .input-controls {
      margin-top: 10px;
      border: 1px solid transparent;
      border-radius: 2px 0 0 2px;
      box-sizing: border-box;
      -moz-box-sizing: border-box;
      height: 32px;
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOGGLE_MAP_KEY;?>&region=in&libraries=places,geocoder"></script>
        <script>
/* script */
function initialize() {
    var postal_code='';
   var latlng = new google.maps.LatLng(<?php echo isset($model->warehouse_lat)?$model->warehouse_lat:'17.39165726448401'?>,<?php echo isset($model->warehouse_long)?$model->warehouse_long:'78.43752262024394'?>);
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
    var input = document.getElementById('searchInput');
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
   document.getElementById('warehouse_lat').value = lat;
   document.getElementById('warehouse_long').value = lng;
  // document.getElementById('postal_code').value = postal_code;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-warehouse')?>" id="do-add-warehouse-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->warehouse_id : '' ?>" />
                  <input type="hidden" name="warehouse_lat" id="warehouse_lat" value="<?php echo  isset($model) ? $model->warehouse_lat : '' ?>" />
                  <input type="hidden" name="warehouse_long" id="warehouse_long" value="<?php echo  isset($model) ? $model->warehouse_long : '' ?>" />
                <div class="row">
                  <div class="col-md-7">

                    <div class="form-group">
                        <input type="text" name="warehouse_name" value="<?php echo  isset($model) ? $model->warehouse_name : '' ?>" class="form-control" placeholder="Warehouse Name">
                        <span class="text-danger"></span>
                    </div>
                    
                    <div class="form-group">
                        <textarea class="form-control" name="warehouse_address" value="<?php echo  isset($model) ? $model->warehouse_address : '' ?>" placeholder="Address"><?php echo  isset($model) ? $model->warehouse_address : '' ?></textarea>
                        <span class="text-danger"></span>
                    </div>
                    

                  </div>
                  <div class="col-md-5">
                    <div class="form-group">
                        <input id="searchInput" name="searchInput"  value="<?php echo isset($model->warehouse_address)?$model->warehouse_address:''?>" type="text" class="form-control input-controls" autofocus="autofocus" placeholder="Geo Location" value="">
                        <span class="text-danger"></span>
                    </div>
                    <div class="">
                      <div class="map" id="map" style="width: 100%; height: 300px;margin-top: 10px"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> Warehouse</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-add-warehouse-form', function (event) {
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
                        $('#do-add-warehouse-form').find('.alert-success').html(resp.message).show();
                        $('#do-add-warehouse-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        if(key=='warehouse_lat'){
                            $('#do-add-warehouse-form').find('[name="searchInput"]').closest('.form-group').find('.text-danger').html(val);
                        }
                        $('#do-add-warehouse-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    
    </script>
  </body>
</html>
