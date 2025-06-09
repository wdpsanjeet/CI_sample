<!doctype html>
<html lang="en">
<?php $this->load->view('ecommerce/partial/header_script'); ?>
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
   var latlng = new google.maps.LatLng(<?php echo isset($model->client_latitude)?$model->client_latitude:'17.39165726448401'?>,<?php echo isset($model->client_longitude)?$model->client_longitude:'78.43752262024394'?>);
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
   document.getElementById('client_latitude').value = lat;
   document.getElementById('client_longitude').value = lng;
  // document.getElementById('postal_code').value = postal_code;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<body>

<section class="inner-body login-account loginform_page p-5">
    <div class="container">
      <div class="row no-gutters shadow-lg">
        <div class="col-md-12 bg-white left_col">
            <div class="form_update_comp"> 
              <div class="logo_form"><img src="<?php echo base_url(); ?>themes/ecommerce/images/logo.png" alt=""></div>
              
              <div class="form-style">
                  <form action="<?php echo base_url($domain_name.'/ecomm-do-update-company-information').'.html';?>" method="post" id="do-signup">
                      <input type="hidden" name="client_latitude" id="client_latitude" value="<?php echo  isset($model) ? $model->client_latitude : '' ?>" />
                  <input type="hidden" name="client_longitude" id="client_longitude" value="<?php echo  isset($model) ? $model->client_longitude : '' ?>" />
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Company Name" class="form-control" name="company_name" id="company_name" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Your Name" class="form-control" name="client_name" id="client_name" aria-describedby="emailHelp">  
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Contact Number" class="form-control" name="shop_phone" id="shop_phone" aria-describedby="emailHelp">   
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Address Line 1" class="form-control" name="client_address_1" id="client_address" aria-describedby="emailHelp">  
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Address Line 2" class="form-control" name="client_address_2" id="client_address" aria-describedby="emailHelp">  
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Area" class="form-control" name="client_area" id="client_area" aria-describedby="emailHelp">   
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">  
                                  <select class="form-control" name="client_state" id="client_state">
                                      <option value="">Select state</option>
                                      <?php foreach($states as $list){?>
                                      <option value="<?php echo $list->city_state;?>"><?php echo $list->city_state;?></option>
                                      <?php }?>
                                  </select>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">
                                  <select class="form-control" name="client_city" id="client_city">
                                      <option value="">Select city</option>
                                  </select>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          
                          
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Pincode" class="form-control" name="client_pincode" id="client_pincode" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Enter Your GST Number" class="form-control" name="gst_number" id="gst_number" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          
                      </div>
                      
                      <div class="row">
                          
                          <div class="col-md-6">
                              <div class="form-group pb-2">
                                  <select class="form-control" name="shop_type">
                                      <option value="">Shop Type</option>
                                      <?php foreach($shop_type as $list){?>
                                      <option value="<?php echo $list->shop_type;?>"><?php echo $list->type_name;?></option>
                                      <?php }?>
                                  </select>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <input type="text" placeholder="Geo Location" class="form-control input-controls" id="searchInput" name="searchInput" aria-describedby="emailHelp"> 
                                  <span class="text-danger"></span>
                              </div>
                              <div class="map" id="map" style="display:none"></div>
                          </div>
                          
                      </div>
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="whatappCheck" name="is_whatapp_yes" value="1" checked="checked">
                                    <label class="form-check-label" for="whatappCheck">I want to receive communications from Brandket on Whastapp</label>
                                  </div>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group pb-2">    
                                  <div class="form-check">
                                      <input type="checkbox" class="form-check-input" id="TCCheck" name="tc_check" checked="checked">
                                    <label class="form-check-label" for="TCCheck">I agree to Brandket Terms& Condition</label>
                                  </div>
                                  <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      
                    <div class="row align-items-center">
                      <div class="col-sm-6">
                        <button type="submit" class="signup_btn">Submit</button>
                      </div>
<!--                      <div class="col-sm-6 text-right">
                        <a href="#" class="forgot_pass">Forgot Password?</a>
                      </div>-->
                    </div>
                </form>            
              </div>
            </div>
            
        </div>
                
      </div>
   </div>
  </section>
<?php $this->load->view('ecommerce/partial/footer_script'); ?>
    <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-signup', function (event) {
        event.preventDefault();
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
                    window.location = '<?php echo base_url($domain_name.'/index').'.html';?>';
                } else {
                    $.each(resp.message, function (key, val) {
                        if(key=='client_latitude'){
                            $('#do-signup').find('[name="searchInput"]').closest('.form-group').find('.text-danger').html(val);
                        }
                        $('#do-signup').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    $(document).on('change', '#client_state', function (event) {
        event.preventDefault();
        var url = '<?php echo base_url($domain_name).'/ecomm-city-list-by-state';?>';
        var state = $(this).val();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {id:state},
            success: function (resp) {
                if (resp.status === 200) {
                    $("#client_city").html(resp.html);
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-signup').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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