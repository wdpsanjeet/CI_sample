<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
        input[type=file] {
  cursor: pointer;
  height: 34px;
  overflow: hidden;
}

input[name='product_image']:before {
  line-height: 32px;
  content: 'Product Pic';
  display: inline-block;
  background: white;
  text-align: center;
}

input[type=file]::-webkit-file-upload-button {
  visibility: hidden;
}
    </style>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-product')?>" id="do-add-product-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->product_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-6">
                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" name="category_id">
                            <option value="">Select category</option>
                            <?php foreach($category['result'] as $list){?>
                            <option value="<?php echo $list->product_category_id;?>" <?php echo (isset($model) && $model->category_id==$list->product_category_id)?'selected="selected"':'';?> ><?php echo $list->category_name;?></option>
                            <?php }?>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                          </div>
                      <div class="col-md-6">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" value="<?php echo  isset($model) ? $model->product_name : '' ?>" class="form-control" placeholder="Product Name">
                        <span class="text-danger"></span>
                    </div>
                          </div>
                          </div>
                      <div class="form-group">
                        <label>Product Description</label>
                        <textarea class="form-control" name="product_description" value="<?php echo  isset($model) ? $model->product_description : '' ?>" placeholder="Product Description"><?php echo  isset($model) ? $model->product_description : '' ?></textarea>
                        <span class="text-danger"></span>
                    </div>
                      <div class="form-group">
                          <label>Small Notes</label>
                        <textarea class="form-control" name="small_note" value="<?php echo  isset($model) ? $model->small_note : '' ?>" placeholder="Small Notes"><?php echo  isset($model) ? $model->small_note : '' ?></textarea>
                        <span class="text-danger"></span>
                    </div>  
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" value="<?php echo  isset($model) ? $model->price : '' ?>" class="form-control" placeholder="Price">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="text" name="quantity_val" value="<?php echo  isset($model) ? $model->quantity_val : '' ?>" class="form-control" placeholder="Quantity">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                    </div>
                    
                    
                  </div>
                  
                </div>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> PRODUCT</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-add-product-form', function (event) {
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
                        $('#do-add-product-form').find('.alert-success').html(resp.message).show();
                        //$('#do-add-product-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-product-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
