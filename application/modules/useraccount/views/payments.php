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
                      
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Invoice</th>
          					<th>org name</th>
          					<th>amount</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($payments['total']>0){
                                        
                                        foreach($payments['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->purchase_invoice;?></strong></td>
          					<td><?php echo $list->org_name;?></td>
          					<td><?php echo $list->amount;?></td>
                                                <td>
                                                    <?php if($list->payment_status==PAYMENT_CREATED){?>
                                                        <button type="button" class="btn btn-success" onclick="confirmPayment('<?php echo $list->id;?>','1');">Approve</button> <button type="button" class="btn btn-danger" onclick="confirmPayment('<?php echo $list->id;?>','0');">Reject</button>
                                                    <?php }elseif($list->payment_status==PAYMENT_APPROVED){?>
                                                        <button type="button" class="btn btn-secondary">Approved</button>
                                                    <?php }else{?>
                                                        <button type="button" class="btn btn-secondary">Rejected</button>
                                                    <?php }?>
	      						 
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
    <?php $this->load->view('partial/footer_script'); ?>  
       <script>
    $(document).ready(function () {
   
    });
    function confirmPayment(id,isApproved){
        var url = '<?php echo base_url('useraccount/confirm-payment');?>';
        var data = new FormData();
        data.append('id', id);
        data.append('approve', isApproved);
        data.append('is_receive', '0');
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                     location.reload();
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-order-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    }
    </script>
  </body>
</html>
