<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="dash-tbl">
              <div class="row">
              <div class="col-md-8">
                <div class="dash-tbl-topbar d-flex">
          			<div class="select-wrap">
          				<label>Status:</label>
          				<div class="dropdown" id="Enabled">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonEnabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <?php echo (isset($filterDriverStatus) && $filterDriverStatus!='')?$filterDriverStatus:'All';?>
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:;">All</a>
						    <a class="dropdown-item" href="javascript:;">Enabled</a>
						    <a class="dropdown-item" href="javascript:;">Disabled</a>
						  </div>
						</div>
          			</div>
          			<div class="select-wrap">
          				<label>Online:</label>
          				<div class="dropdown" id="Online">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonOnline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <?php echo (isset($filterDriverOnlineStatus) && $filterDriverOnlineStatus!='')?$filterDriverOnlineStatus:'All';?>
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:;">All</a>
						    <a class="dropdown-item" href="javascript:;">Yes</a>
						    <a class="dropdown-item" href="javascript:;">No</a>
						  </div>
						</div>
          			</div>
                    <div class="select-wrap">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" id="name" name="name" value="<?php echo (isset($filterDriverName) && $filterDriverName!='')?$filterDriverName:'';?>" class="form-control input_user" value="" placeholder="Driver name">

                                        </div>
                                        <span class="text-danger"></span>
                                        
                                    </div>
          			
          		</div>
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <a href="<?php echo base_url('useraccount/add-driver').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Driver</a>
                  </div>
                  
                </div>
              </div>
            </div>
          		
          		<table>
          			<thead>
          				<tr>
          					<th></th>
          					<th>Name</th>
          					<th>Mob No</th>
          					<th>Vehicle number</th>
          					<th>Kms driven</th>
          					<th>Paid</th>
          					<th>Pending</th>
          					<th>Trips</th>
          					<th>Enable/Disable</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($drivers['total']>0){
                                        foreach($drivers['result'] as $list){
                                            $paid_pending= $this->all_function->get_driver_total_paid_pending($list->driver_id);
                                            $total_driven = $this->all_function->get_driver_total_driven($list->driver_id);
                                            $total_driven_trip = $this->all_function->get_driver_total_driven_trip($list->driver_id);
                                        ?>
          				<tr>	
          					<td>
          						<div class="status <?php echo ($list->online_status=='1')?'online':'ofline';?>">
          							<div class="status-inn">
          							</div>
          						</div>
          					</td>
                                                <td><a href="<?php echo base_url('useraccount/view-driver/').$list->driver_id.'.html'?>"><strong><?php echo $list->name;?></strong></a></td>
          					<td><?php echo $list->phone;?></td>
          					<td><?php echo $list->truck_number;?></td>
          					<td><?php echo ($total_driven!='')?$total_driven:'0';?></td>
          					<td><?php echo ($paid_pending->total_paid!='')?$paid_pending->total_paid:'0';?> </td>
          					<td><?php echo $paid_pending->total_amount-$paid_pending->total_paid;?></td>
          					<td><?php echo ($total_driven_trip!='')?$total_driven_trip:'0';?></td>
          					<td>
	      						 <div class="checkbox switcher">
							      <label for="test_<?php echo $list->driver_id?>">
							        <input type="checkbox" id="test_<?php echo $list->driver_id?>" value="<?php echo $list->status;?>" <?php echo ($list->status=='1')?'checked':'';?>>
							        <span><small></small></span>
							      </label>
							    </div>
          					</td>
          					<td>
          						<a href="<?php echo base_url('useraccount/edit-driver/').$list->driver_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          						<a href="<?php echo base_url('useraccount/routes/').$list->driver_id.'.html'?>" class="truck"><i class="fa fa-truck" aria-hidden="true"></i></a>
          					</td>
          				</tr>
                                        <?php 
                                        }
                                        }?>
          				
          			</tbody>
          		</table>
          	</div>


        </div>
      </div>
    </div>
      <form action="" method="get" id="filter-form">
          <input type="hidden" name="filterDriverStatus" id="filterDriverStatus" value="<?php echo (isset($filterDriverStatus) && $filterDriverStatus!='')?$filterDriverStatus:'All';?>" />
          <input type="hidden" name="filterDriverPaymentStatus" id="filterDriverPaymentStatus" value="<?php echo (isset($filterDriverPaymentStatus) && $filterDriverPaymentStatus!='')?$filterDriverPaymentStatus:'All';?>" />
                        <input type="hidden" name="filterDriverOnlineStatus" id="filterDriverOnlineStatus" value="<?php echo (isset($filterDriverOnlineStatus) && $filterDriverOnlineStatus!='')?$filterDriverOnlineStatus:'All';?>" />
                        <input type="hidden" name="filterDriverName" id="filterDriverName" value="<?php echo (isset($filterDriverName) && $filterDriverName!='')?$filterDriverName:'';?>" />
      </form>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('change', '[type="checkbox"]', function () {
        var enable_status = '0';
         if ($(this).prop('checked')==true){ 
            enable_status = '1';
        }
        var formData = new FormData();
        formData.append('enable_status', enable_status);
        formData.append('driver_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/drivers-status-update');?>',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (resp) {
                
            }
        }).fail(function () {
        });
    });
    });
    $('#Enabled .dropdown-menu a').click(function(){
    $(this).parent().parent().find('button').text($(this).text());
    $("#filterDriverStatus").val($(this).text());
    $("#filter-form").submit();
  });
  $('#Paid .dropdown-menu a').click(function(){
    $(this).parent().parent().find('button').text($(this).text());
    $("#filterDriverPaymentStatus").val($(this).text());
    $("#filter-form").submit();
  });
  $('#Online .dropdown-menu a').click(function(){
    $(this).parent().parent().find('button').text($(this).text());
    $("#filterDriverOnlineStatus").val($(this).text());
    $("#filter-form").submit();
  });
  $(document).on('keypress',function(e) {
    if(e.which == 13) {
       $("#filterDriverName").val( $("#name").val());
       $("#filter-form").submit();
    }
});
    </script>
  </body>
</html>
