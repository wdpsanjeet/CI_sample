<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


<!--          <div class="rgt-sidebar-body">
              <div class="block-title">
                            <a href="<?php echo base_url('admin/blogs/add'); ?>" class="btn pull-right">
                                <i class="fa fa-plus-circle"></i> Add Client</a>
                        </div>
              <div></div>
          </div>-->
          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                <div class="dash-tbl-topbar d-flex">
          			
                    <div class="select-wrap">
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" id="client_name" name="client_name" value="<?php echo (isset($filterClientName) && $filterClientName!='')?$filterClientName:'';?>" class="form-control input_user" value="" placeholder="Client name">

                                        </div>
                                        <span class="text-danger"></span>
                                        
                                    </div>
          			
          		</div>
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <a href="<?php echo base_url('useraccount/add-client').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Client</a>
                  </div>
<!--                  <div class="dropdown ml-2">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Supermarket</a>
                      <a class="dropdown-item" href="#">Restaurant</a>
                      <a class="dropdown-item" href="#">Other</a>
                    </div>
                  </div>-->
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Company Name</th>
          					<th>Name</th>
          					<th>Mobile No</th>
          					<th>Address</th>
          					<th>City/District/Town</th>
          					<th>State</th>
          					<th>Trips</th>
          					<th>Enable/Disable</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($clients['total']>0){
                                        foreach($clients['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><a href="<?php echo base_url('useraccount/view-client/').$list->client_id.'.html'?>"><strong><?php echo $list->company_name;?></strong></a></td>
          					<td><?php echo $list->client_name;?></td>
          					<td><?php echo $list->client_mobile;?></td>
          					<td><?php echo $list->client_address;?></td>
          					<td><?php echo $list->client_city;?> </td>
          					<td><?php echo $list->client_state;?></td>
          					<td>10</td>
          					<td>
	      						 <div class="checkbox switcher">
							      <label for="test_<?php echo $list->client_id;?>">
							        <input type="checkbox" id="test_<?php echo $list->client_id;?>" value="<?php echo $list->status;?>" <?php echo ($list->status=='1')?'checked':'';?>>
							        <span><small></small></span>
							      </label>
							    </div>
          					</td>
                                                <td style="min-width: 70px;">
          						<a href="<?php echo base_url('useraccount/edit-client/').$list->client_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          						<a href="<?php echo base_url('useraccount/deliveries/').$list->client_id.'.html'?>" class="truck"><i class="fa fa-truck" aria-hidden="true"></i></a>
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
                        <input type="hidden" name="filterClientName" id="filterClientName" value="<?php echo (isset($filterClientName) && $filterClientName!='')?$filterClientName:'';?>" />
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
        formData.append('client_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/clients-status-update');?>',
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
    $(document).on('keypress',function(e) {
    if(e.which == 13) {
       $("#filterClientName").val( $("#client_name").val());
       $("#filter-form").submit();
    }
});
    </script>
  </body>
</html>
