<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
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
    <script
      src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOGGLE_MAP_KEY;?>&callback=initMap"
      async
    ></script>
    <script>
    function initMap() {
  const uluru = { lat: <?php echo $model->client_latitude;?>, lng: <?php echo $model->client_longitude;?> };
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 13,
    center: uluru,
    
  });
  const contentString ="<p><?php echo $model->client_address;?></p>";
  const infowindow = new google.maps.InfoWindow({
    content: contentString,
  });
  const marker = new google.maps.Marker({
    position: uluru,
    map,
    title: "<?php echo $model->client_city;?> (<?php echo $model->client_state;?>)",
    icon: '<?php echo base_url() ?>themes/useraccount/images/mapmarker.png'
  });

  marker.addListener("click", () => {
    infowindow.open({
      anchor: marker,
      map,
      shouldFocus: false,
    });
  });
}
    </script>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
                <div class="row">
                    <div class="col-md-7" style="background-color: #ffebf9;">

                    <div class="row mt-3">
                      <div class="col-md-3">
                          <strong>Client:</strong>
                      </div>
                      <div class="col-md-6">
                        <strong><?php echo $model->company_name;?></strong>
                      </div>
                        <div class="col-md-3 viewclientprofile text-right">
                        <img src="<?php echo base_url();?>themes/useraccount/images/userimg.png" class="userimg">
                      </div>
                    </div>
                    
                    <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Address:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->client_address;?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Mob No:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->client_mobile;?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>City:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->client_city;?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>State:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo $model->client_state;?></strong>
                      </div>
                    </div>
                      <div class="row mt-3">
                      <div class="col-md-3">
                        <strong>Last Delivery Date and Time:</strong>
                      </div>
                      <div class="col-md-9">
                        <strong><?php echo (isset($LastDeliveryDate->delivered_at))?date('d/M/Y',strtotime($LastDeliveryDate->delivered_at)):'No Last Delivery Yet';?></strong>
                      </div>
                    </div>
                      
                  </div>
                  <div class="col-md-5">
                    
                    <div class="">
                      <div class="map" id="map" style="width: 100%; height: 300px;margin-top: 10px"></div>
                    </div>
                  </div>
                </div>
                <div class="form-group mt-3 def-btn">
                    <a href="<?php echo base_url('useraccount/deliveries/').$client_id.'.html'?>">View Deliveries</a>
                </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      
  </body>
</html>
