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
                                <i class="fa fa-plus-circle"></i> Add Products</a>
                        </div>
              <div></div>
          </div>-->
          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                <div class="dash-tbl-topbar d-flex">
          			<div class="select-wrap">
          				<label>Status:</label>
          				<div class="dropdown" id="Enabled">
						  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButtonEnabled" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    <?php echo (isset($filterOrderStatus) && $filterOrderStatus!='')?$filterOrderStatus:'All';?>
						  </button>
						  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="javascript:;">All</a>
						    <a class="dropdown-item" href="javascript:;">New</a>
						    <a class="dropdown-item" href="javascript:;">Confirmed</a>
                                                    <a class="dropdown-item" href="javascript:;">Delivered</a>
                                                    <a class="dropdown-item" href="javascript:;">Cancel</a>
						  </div>
						</div>
          			</div>
          			
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

                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Invoice id</th>
                                                <th>Company name</th>
                                                <th>Client name</th>
                                                <th>Client mobile</th>
          					<th>Shipping address</th>
                                                <th>Date</th>
                                                <th>Order Status</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($cms['total']>0){
                                        foreach($cms['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->invoice_id;?></strong></td>
                                                <td><strong><?php echo $list->company_name;?></strong></td>
                                                <td><strong><?php echo $list->client_name;?></strong></td>
                                                <td><strong><?php echo $list->client_mobile;?></strong></td>
          					<td><?php echo $list->shipping_address;?></td>
                                                <td><?php echo $list->updated_at;?></td>
                                                <td>
                                                         <?php if($list->order_status=='1'){?>
                                                             New
                                                         <?php }elseif($list->order_status=='4'){?>
                                                             Cancel
                                                         <?php }elseif($list->order_status=='2'){?>
                                                             Confirmed
                                                         <?php }elseif($list->order_status=='3'){?>
                                                             Delivered
                                                         <?php }?>
          					</td>
                                                <td style="min-width: 70px;">
          						<a href="<?php echo base_url('useraccount/edit-order/').$list->order_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
                        <input type="hidden" name="filterOrderStatus" id="filterOrderStatus" value="<?php echo (isset($filterOrderStatus) && $filterOrderStatus!='')?$filterOrderStatus:'All';?>" />
      </form>
    <?php $this->load->view('partial/footer_script'); ?>  
       <script> 
           $('#Enabled .dropdown-menu a').click(function(){
    $(this).parent().parent().find('button').text($(this).text());
    $("#filterOrderStatus").val($(this).text());
    $("#filter-form").submit();
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
