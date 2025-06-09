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
              <form action="<?php echo base_url('useraccount/do-add-purchase')?>" id="do-add-order-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                     <div class="row">
                      <div class="col-md-6"> 
                    <div class="form-group">
                        <select class="form-control" name="org_id" id="org_id">
                            <option value="">Select Organisation</option>
                            <?php foreach($fav_contacts['result'] as $list){?>
                                <option value="<?php echo $list->org_id?>"><?php echo $list->name.'('.$list->phone.')'?></option>
                            <?php }?>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                  </div>
                         
                         
                         <div class="col-md-6">
                        <div class="input-group date" data-provide="datepicker">
                                                <input type="text" name="delivery_date" value="" id="delivery_date" class="form-control datepicker" placeholder="Delivery Date">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                      </div>
                </div>
                    
                  <h3>Sales Item</h3>
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
                                <th class="text-center">Remove Row</th>
                              </tr>
                            </thead>
                            <tbody id="tbody">

                            </tbody>
                          </table>
                        </div>
                        <button class="btn btn-md btn-primary" 
                          id="addBtn" type="button">
                            Add new
                        </button>
                      
                    </div>
                  <br /><br /><br />
                  <div class="row">
                      <div class="col-md-2"> 
                    <div class="form-group">
                        <label for="exampleInputEmail1">Grand Total</label>
                    </div>
                  </div>
                      <div class="col-md-3"> 
                    <div class="form-group">
                        <input class="form-control" type="text" id="grand_total" name="grand_total" disabled="disabled" />
                        <span class="text-danger"></span>
                    </div>
                  </div>
                  </div>
                  
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> Purchase</button>
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
                        window.location.href='<?php echo base_url('useraccount/purchase').'.html';?>';
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        if(key=='client_latitude'){
                            $('#do-add-order-form').find('[name="searchInput"]').closest('.form-group').find('.text-danger').html(val);
                        }
                        $('#do-add-order-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    
    </script>
    <script>
    $(document).ready(function () {
  
      // Denotes total number of rows
      var rowIdx = 0;
  
      // jQuery button click event to add a row
      $('#addBtn').on('click', function () {
  
        // Adding a row inside the tbody.
        $('#tbody').append(`<tr id="R${++rowIdx}">
             <td class="row-index text-center">
             <p>${rowIdx}.</p>
             </td>
             <td class="text-center">
                <select class="form-control" name="product_id[]" onchange="getVarthakProductDetail(this)">
            <option value="">select product</option>
            <?php foreach($varthak_product as $list){?>
            <option value="<?php echo $list->product_id?>"><?php echo $list->item_name?></option>
            <?php }?>
            </select>
                </td>
            <td class="text-center">
                <input type="text" class="form-control" name="price[]"  onblur="changePrice(this)"/>
                </td>
            <td class="text-center">
                <input type="text" class="form-control" name="quantity[]" onblur="changePrice(this)"/>
                </td>
            <td class="text-center">
                <input type="text" class="form-control" name="total_price[]" disabled="disabled"/>
                </td>
              <td class="text-center">
                <button class="btn btn-danger remove"
                  type="button">Remove</button>
                </td>
              </tr>`);
      });
  
      // jQuery button click event to remove a row.
      $('#tbody').on('click', '.remove', function () {
  
        // Getting all the rows next to the row
        // containing the clicked button
        var child = $(this).closest('tr').nextAll();
  
        // Iterating across all the rows 
        // obtained to change the index
        child.each(function () {
  
          // Getting <tr> id.
          var id = $(this).attr('id');
  
          // Getting the <p> inside the .row-index class.
          var idx = $(this).children('.row-index').children('p');
  
          // Gets the row number from <tr> id.
          var dig = parseInt(id.substring(1));
  
          // Modifying row index.
          idx.html(`${dig - 1}`+'.');
  
          // Modifying row id.
          $(this).attr('id', `R${dig - 1}`);
        });
  
        // Removing the current row.
        $(this).closest('tr').remove();
        grandTotal();
        // Decreasing total number of rows by 1.
        rowIdx--;
      });
      
    });
    function getVarthakProductDetail(obj){
        var url = '<?php echo base_url('useraccount/get-product-detail-by-id');?>';
        var rowObj = $(obj);
        var data = new FormData();
        data.append('product_id', $(obj).val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    rowObj.parent().parent().find('input[name="price[]"]').val(resp.selling_price);
                    rowObj.parent().parent().find('input[name="quantity[]"]').val(resp.quantity);
                    rowObj.parent().parent().find('input[name="total_price[]"]').val(resp.total_price);
                    grandTotal();
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-order-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    }
    
    function changePrice(obj){
        var changed_price= $(obj).parent().parent().find('input[name="price[]"]').val();
        var quantity = $(obj).parent().parent().find('input[name="quantity[]"]').val();
        $(obj).parent().parent().find('input[name="total_price[]"]').val(changed_price*quantity);
        grandTotal();
    }
    
    function grandTotal(){
        var sum = 0;
        $('input[name="total_price[]"]').each(function() {
            sum += Number($(this).val());
        });
        $("#grand_total").val(sum);
    }
  </script>
  </body>
</html>
