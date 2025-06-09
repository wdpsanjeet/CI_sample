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
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <?php 
                      if($access_level[MODULE_ACCESS_TYPE_ADD]){
                      ?>
                      <a href="<?php echo base_url('useraccount/add-sales').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Sale</a>
                      <a href="<?php echo base_url('useraccount/receivables-list').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Receivables</a>
                      <?php }?>
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Sales Date</th>
          					<th>Sales Invoice</th>
          					<th>Organisation Name</th>
                                                <th>Phone </th>
          					<th>Total Price</th>
          					<th>Dues</th>
                                                <th>Status</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($sales['total']>0){
                                        
                                        foreach($sales['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><?php echo $list->invoice_date;?></td>
          					<td><?php echo $list->sales_invoice ;?></td>
          					<td><?php echo $list->purchaser_org_name;?></td>
          					<td><?php echo $list->client_phone;?></td>
          					<td><?php echo $list->total_price;?> </td>
          					<td><?php echo $list->dues;?></td>
                                                <td><?php 
                                                if($list->order_status==ORDER_CREATED){
                                                    $status_text='Waiting';
                                                }elseif($list->order_status==ORDER_APPROVED){
                                                    $status_text='Approved';
                                                }elseif($list->order_status==ORDER_REJECTED){
                                                    $status_text='Canceled';
                                                }
                                                echo $status_text;?>
                                                </td>
                                                <td><a href="<?php echo base_url('useraccount/edit-sales/').$list->sale_id?>.html" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></td>
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
    
    </script>
  </body>
</html>
