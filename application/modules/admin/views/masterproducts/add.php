<?php $this->load->view('partial/header_script'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/select2.min.css">
<style>
    .help-block{color:red}
    .select2-container--focus{
        border: 1px solid #4680ff;
    }
    .select2-container--default .select2-selection--single{
        height: 35px;
        border: 1px solid #ccc;
        border-radius: 1px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        background-color: #ffffff;
        line-height: 15px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 32px;
    }
</style>
<style>
    .autocomplete-box-state{
        position: absolute;
        background-color: #fff !important;
        z-index: 999;
        width: 95%;
    }
    .autocomplete-box-state ul li {
        padding: 4px;
        border: 1px solid #ccc;
    }
    .autocomplete-box-state ul li:hover {
        background-color: #ccc;
        cursor: pointer;
    }
</style>
<div class="page-body">
    <div class="row">
        <div class="col-lg-12">

            <!-- tab content start -->
            <div class="tab-content">
                <!-- tab panel personal start -->
                <!-- personal card start -->
                <div class="card">

                    <div class="card-block">
                        <h4><?= isset($model) ? 'Edit' : 'Add' ?> Masterproducts <?php echo isset($model) ? 'of ' . $model->item_name : '' ?></h4>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <form  action="<?= base_url('index.php/admin/masterproducts/do-masterproducts') ?>" method="post" id="edit_cms">
                                            <input type="hidden" name="sid" value="<?= isset($model) ? $model->product_id : '' ?>" />
                                            <div class="row">
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="product_number" class="block"><stong>product_number *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="product_number" name="product_number" type="text" class="form-control" value="<?= isset($model) ? $model->product_number : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="item_name" class="block"><stong>Item name *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="item_name" name="item_name" type="text" class="form-control" value="<?= isset($model) ? $model->item_name : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="search_name" class="block"><stong>Search name</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="present_address" name="search_name" type="text" class="form-control" value="<?= isset($model) ? $model->search_name : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="category_id" class="block"><stong>Category</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="category_id" id="category_id">
                                                                <option value="">Select category</option>
                                                                    <?php foreach($category as $list){?>
                                                                        <option value="<?php echo $list->category_id;?>" <?php echo (isset($model) && $list->category_id==$model->category_id)?'selected="selected"':'';?> ><?php echo $list->category_name;?></option>
                                                                    <?php }?>
                                                            </select>
                                                            <input type="text" name="new_category" id="new_category" class="form-control" value="" style="display:none">
                                                            <a href="javascript:;" onclick="addCategory(this)" id="addCategory">Add Category</a> | <a href="javascript:;" onclick="backCategory(this)" id="backCategory" style="display:none">Back List</a>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="subcategory_id" class="block"><stong>Sub-Category</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="subcategory_id" id="subcategory_id">
                                                                   <?php if(isset($subcategory)){
                                                                       foreach($subcategory as $list){?>
                                                                           <option value="<?php echo $list->category_id;?>" <?php echo (isset($model) && $list->category_id==$model->subcategory_id)?'selected="selected"':'';?> ><?php echo $list->category_name;?></option>
                                                                    <?php   }
                                                                   }?>
                                                            </select>
                                                            <input type="text" name="new_subcategory" id="new_subcategory" class="form-control" value="" style="display:none">
                                                            <a href="javascript:;" onclick="addSubCategory(this)" id="addSubCategory">Add Sub Category</a> | <a href="javascript:;" onclick="backSubCategory(this)" id="backSubCategory" style="display:none">Back List</a>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="brand" class="block"><stong>brand</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="present_address" name="brand" type="text" class="form-control" value="<?= isset($model) ? $model->brand : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="quantity" class="block"><stong>quantity</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="present_address" name="quantity" type="text" class="form-control" value="<?= isset($model) ? $model->quantity : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="unit" class="block"><stong>unit</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="unit" name="unit" type="text" class="form-control" value="<?= isset($model) ? $model->unit : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="selling_price" class="block"><stong>Selling price</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="selling_price" name="selling_price" type="text" class="form-control" value="<?= isset($model) ? $model->selling_price : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="purchase_price" class="block"><stong>purchase price</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="purchase_price" name="purchase_price" type="text" class="form-control" value="<?= isset($model) ? $model->purchase_price : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="image_name" class="block"><stong>Image <?php echo isset($model) ? '<img src="'. base_url('uploads/varthak_product/').$model->image_name.'" style="height:50px;width:100%" />' : 'Not Available' ?></stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="image_name" name="image_name" type="file" class="form-control">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="item_group" class="block"><stong>item group</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="item_group" name="item_group" type="text" class="form-control" value="<?php isset($model) ? $model->item_group : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="product_hsn" class="block"><stong>product hsn</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="product_hsn" name="product_hsn" type="text" class="form-control" value="<?= isset($model) ? $model->product_hsn : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="EAN" class="block"><stong>EAN</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="EAN" name="EAN" type="text" class="form-control" value="<?= isset($model) ? $model->EAN : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="shelf_life" class="block"><stong>shelf life</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="shelf_life" name="shelf_life" type="text" class="form-control" value="<?= isset($model) ? $model->shelf_life : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="is_batchable" class="block"><stong>is batchable</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="is_batchable">
                                                                <option value="YES" <?php echo (isset($model) && $model->is_batchable=='YES')?'selected="selected"':'';?> >YES</option>
                                                                <option value="NO" <?php echo (isset($model) && $model->is_batchable=='NO')?'selected="selected"':'';?> >NO</option>
                                                            </select>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="is_bom_item" class="block"><stong>is bom item</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="is_bom_item">
                                                                <option value="YES" <?php echo (isset($model) && $model->is_bom_item=='YES')?'selected="selected"':'';?> >YES</option>
                                                                <option value="NO" <?php echo (isset($model) && $model->is_bom_item=='NO')?'selected="selected"':'';?> >NO</option>
                                                            </select>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="gst_percentage" class="block"><stong>gst percentage</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="gst_percentage" name="gst_percentage" type="text" class="form-control" value="<?= isset($model) ? $model->gst_percentage : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="material_type" class="block"><stong>material_type</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="material_type" name="material_type" type="text" class="form-control" value="<?= isset($model) ? $model->material_type : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="nature_of_goods_code" class="block"><stong>nature of goods code</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="nature_of_goods_code" name="nature_of_goods_code" type="text" class="form-control" value="<?= isset($model) ? $model->nature_of_goods_code : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="nature_of_goods" class="block"><stong>nature of goods</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="nature_of_goods" name="nature_of_goods" type="text" class="form-control" value="<?= isset($model) ? $model->nature_of_goods : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="active" class="block"><stong>active</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <select class="form-control" name="active">
                                                                <option value="1" <?php echo (isset($model) && $model->active=='1')?'selected="selected"':'';?> >YES</option>
                                                                <option value="0" <?php echo (isset($model) && $model->active=='0')?'selected="selected"':'';?> >NO</option>
                                                            </select>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="stock_qty" class="block"><stong>stock qty</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="stock_qty" name="stock_qty" type="text" class="form-control" value="<?= isset($model) ? $model->stock_qty : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="stock_value" class="block"><stong>stock value</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="stock_value" name="stock_value" type="text" class="form-control" value="<?= isset($model) ? $model->stock_value : '' ?>" tabindex="1">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end of row -->
                                            <div class="text-center">
                                                <a id="back_btn" style="display:none;" href="<?= base_url('index.php/admin/masterproducts') ?>" class="btn btn-dark waves-effect waves-light m-r-20">Back</a>
                                                <button id="submit_btn" type="submit" name="fundTransfered" value="update" class="btn btn-primary waves-effect waves-light m-r-20" tabindex="1">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end of edit info -->
                                </div>
                                <!-- end of col-lg-12 -->
                            </div>
                            <!-- end of row -->
                        </div>
                        <!-- end of edit-info -->
                    </div>
                    <!-- end of card-block -->
                </div>

                <!-- tab pane personal end -->

            </div>
            <!-- tab content end -->
        </div>
    </div>
</div>
<?php $this->load->view('partial/footer'); ?>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            endDate: '-1d'
        }).on('changeDate', function (e) {
            $(this).datepicker('hide');
        });
        ;
    });
    function addCategory(obj){
        $('#category_id').hide();
        $('#new_category').show();
        $('#backCategory').show();
        $(obj).attr('onclick','newCategory()').html('Add Now');
    }
    function backCategory(obj){
        $('#new_category').hide().val('');
        $('#category_id').show();
        $('#backCategory').hide();
        $('#addCategory').attr('onclick','addCategory()').html('Create New');
    }
    function newCategory(){
        var url = site_url + 'index.php/admin/masterproducts/add_category';
        var data = new FormData();
        data.append('new_category',$('#new_category').val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    $('#category_id').append(resp.message);
                    $('#category_id').show();
                    $('#new_category').hide();
                    $('#addCategory').attr('onclick','addCategory()').html('Create New');
                    $('#backCategory').hide();
                    ajaxindicatorstop();
                }
                ajaxindicatorstop();
            }
        })
    }
    function addSubCategory(obj){
        $('#subcategory_id').hide();
        $('#new_subcategory').show();
        $('#backSubCategory').show();
        $(obj).attr('onclick','newSubCategory()').html('Add Now');
    }
    function backSubCategory(obj){
        $('#new_subcategory').hide().val('');
        $('#subcategory_id').show();
        $('#backSubCategory').hide();
        $('#addSubCategory').attr('onclick','addSubCategory()').html('Create New');
    }
    function newSubCategory(){
        var url = site_url + 'index.php/admin/masterproducts/add_subcategory';
        var data = new FormData();
        data.append('new_subcategory',$('#new_subcategory').val());
        data.append('parent_id',$('#category_id').val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    $('#subcategory_id').append(resp.message);
                    $('#subcategory_id').show();
                    $('#new_subcategory').hide();
                    $('#addSubCategory').attr('onclick','addSubCategory()').html('Create New');
                    $('#backSubCategory').hide();
                    ajaxindicatorstop();
                }
                ajaxindicatorstop();
            }
        })
    }
</script>

