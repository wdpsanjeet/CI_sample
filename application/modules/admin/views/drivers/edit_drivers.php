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
                        <h4><?php echo  isset($model) ? 'Edit' : 'Add' ?> Driver</h4>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <form  action="<?php echo base_url('index.php/admin/drivers/store') ?>" method="post" id="edit_cms">
                                            <input type="hidden" name="cid" value="<?php echo isset($model) ? $model->driver_id : '' ?>" />
                                            <div class="row">
                                                
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="phone" class="block"><stong>Phone *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="phone" name="phone" type="text" class="form-control" value="<?php echo  isset($model) ? $model->phone : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="truck_number" class="block"><stong>Truck number *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="truck_number" name="truck_number" type="text" class="form-control" value="<?php echo  isset($model) ? $model->truck_number : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="name" class="block"><stong>Name *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="name" name="name" type="text" class="form-control" value="<?php echo  isset($model) ? $model->name : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="company_code" class="block"><stong>company code *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="company_code" name="company_code" type="text" class="form-control" value="<?php echo  isset($model) ? $model->company_code : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-lg-6" style="">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="name" class="block"><stong>Status</stong></label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <select class="form-control" name="status">
                                                                    <option value="1" <?php echo (isset($model) && $model->status=='1')?' selected="selected"':'';?>>Active</option>
                                                                    <option value="0" <?php echo (isset($model) && $model->status=='0')?' selected="selected"':'';?>>In-active</option>
                                                            </select>
                                                            </div>
                                                            <span class="help-block col-sm-12"></span>
                                                        </div>
                                                </div>
                                            </div>
                                            
                                                
                                            
                                            
                                            <!-- end of row -->
                                            <div class="text-center">
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
</script>

