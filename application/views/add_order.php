<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-order')?>" id="do-add-order-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->order_id : '' ?>" />
                  <input type="hidden" name="client_id" value="<?php echo  isset($model) ? $model->client_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                  <div class="dash-box">
                      <p><strong>Order Detail</strong></p>
                      <p><strong>Invoice ID :</strong><?php echo $model->invoice_id;?></p>
                      <p><strong>Total :</strong><?php echo $model->total_price;?></p>      
          		</div>
                            </div>
                        <div class="col-md-4">
                  <div class="dash-box">
                      <p><strong>Shipping Detail</strong></p>
                      <p><?php echo $model->shipping_address;?></p>
                            
          		</div>
                            </div>
                        <div class="col-md-4">
                  <div class="dash-box">
                      <p><strong>Customer Detail</strong></p>
                      <p><?php echo $model->company_name;?></p>
                      <p><?php echo $model->client_mobile;?></p>
                            
          		</div>
                            </div>
                    </div>
                      <?php foreach($order_detail['result'] as $list){?>
                      <div class="single-thread">
                      <div class="option-box">
                          <strong>Product :</strong> <?php echo $list->product_name;?> | <strong>Quantity :</strong> <?php echo $list->quantity;?> | <strong>Price :</strong> <?php echo $list->product_price;?> | <strong>Total Price :</strong> <?php echo $list->total_price;?>
					</div>
                    </div>
                      <?php }?>
                      <?php if($model->order_status=='1'){?>
                      <div class="row">
                          <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control" name="order_status">
                            <option value="">Select Status</option>
                            <option value="4">Cancel</option>
                            <option value="2">Confirm</option>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                          </div>
                      <div class="col-md-6">
<!--                    <div class="form-group">
                        <input type="date" name="delivery_date" value="" class="form-control" placeholder="Delivery Date">
                        <span class="text-danger"></span>
                    </div>-->
                          </div>
                          </div>
                      <?php }?>
                  </div>
                    
                </div>
                  <?php if($model->order_status=='1'){?>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> ORDER</button>
                </div>
                  <?php }?>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-add-order-form', function (event) {
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
                        location.reload();
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-order-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
