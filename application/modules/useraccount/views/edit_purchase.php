<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.standalone.min.css" />
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                     <div class="row">
                      <div class="col-md-4"> 
                    <div class="form-group">
                        <?php echo $purchase_detail->seller_org_name;?>
                    </div>
                  </div>
                        <div class="col-md-4"> 
                             
                        </div>
                         
                         <div class="col-md-4">
                        
                      </div>
                </div>
                    
                  <h3>Purchase Item</h3>
                    <div class="row">
                        <div class="table-responsive">
                          <table class="table table-bordered">
                            <thead>
                              <tr>
                                <th class="text-center">Sl. No.</th>
                                <th class="text-center">Product</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Total</th>
                              </tr>
                            </thead>
                            <tbody id="tbody">
                                <?php $i=1;foreach($items as $list){?>
                                <tr>
                                    <td class="row-index text-center"><p><?php echo $i;?></p></td>
                                    <td class="text-center"><?php echo $list->product_name;?></td>
                                    <td class="text-center"><?php echo $list->product_price;?></td>
                                    <td class="text-center"><?php echo $list->quantity;?></td>
                                    <td class="text-center"><?php echo $list->total_price;?></td>
                                </tr>
                                <?php $i++;}?>
                                <tr>
                                    <td class="text-right" colspan="4">Total Amount=</td>
                                    <td class="text-center" colspan="4"><?php echo $purchase_detail->total_price;?></td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="4">Total Paid=</td>
                                    <td class="text-center" colspan="4"><?php echo $purchase_detail->paid;?></td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="4">Dues=</td>
                                    <td class="text-center" colspan="4"><?php echo $purchase_detail->dues;?></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                        
                      
                    </div>
                  
                  
                <div class="form-group mt-3 float-right">
                    <?php if($purchase_detail->order_status==ORDER_CREATED){?>
<!--                        In Process-->
                      <button type="submit" onclick="confirmInvoice('1');"> Accept</button> <button type="submit" onclick="confirmInvoice('0');"> Reject</button>
                    <?php }?>
                  
                </div>
                  <form action="<?php echo base_url('useraccount/add-payment')?>" id="do-add-payment-form" method="post">
                      <input type="hidden" name="is_receive" value="0" />
                      <input type="hidden" name="invoice_id" value="<?php echo $purchase_detail->purchase_id;?>" />
                  <div class="row">
                      <div class="col-md-1">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Dues Total</label>
                              <input class="form-control" type="text" id="grand_total" value="<?php echo $purchase_detail->dues;?>" name="grand_total" disabled="disabled" />
                              <span class="text-danger"></span>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Payment Type</label>
                              <div class="form-group">
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type" id="inlineRadio1" value="3">
                                <label class="form-check-label" for="inlineRadio1">Cash</label>
                              </div>
                              
                              <span class="text-danger"></span>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-2">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Amount</label>
                              <input class="form-control" type="text" id="amount" name="amount" />
                              <span class="text-danger"></span>
                          </div>
                      </div>
                      <div class="col-md-3">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Due Date</label>
                              <div class="input-group date" data-provide="datepicker">
                                  <input type="text" name="due_date" value="" id="due_date" class="form-control datepicker" placeholder="Due Date">
                                  <div class="input-group-addon">
                                      <span class="glyphicon glyphicon-th"></span>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-4">
                          <div class="form-group">
                              <label for="exampleInputEmail1">Personal Note</label>
                              <textarea class="form-control" style="height: 45px;" name="note" value="" placeholder="Type something you want here"></textarea>
                          </div>
                      </div>
                      
                  </div>
                  
                <div class="form-group mt-3 float-right">
                  <button type="submit"> Pay Now</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
      
    <?php $this->load->view('partial/footer_script'); ?>  
      <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
      <script>
          $(function () {
$('.datepicker').datepicker({
    format: 'dd/mm/yyyy',
});
});
    $(document).ready(function () {
        
        $(document).on('submit', '#do-add-payment-form', function (event) {
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
                } else if(resp.status === 500){
                    $("#add_deliveries_error").text(resp.message.trip_date).show();
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-payment-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    function confirmInvoice(isApproved){
        var url = '<?php echo base_url('useraccount/confirmPurchase');?>';
        var data = new FormData();
        data.append('purchase_id', '<?php echo $purchase_detail->purchase_id;?>');
        data.append('isApproved', isApproved);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                     
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
