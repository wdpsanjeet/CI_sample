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
                        <h4>Edit Settings </h4>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <form  action="<?php echo  base_url('index.php/admin/settings/store') ?>" method="post" id="edit_settings">
                                            <div class="row">
                                                <?php foreach ($all_settings as $k => $v) { 
                                                    
                                                    ?>
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="name" class="block"><stong><?php echo $v->slug_name;?> *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <?php if($v->input_type=='textarea'){?>
                                                            <textarea  name="<?php echo $v->slug_name;?>" class="form-control" style="min-height: 55px;"><?php echo $v->slug_data;?></textarea>
                                                            <?php }elseif($v->input_type=='select_box'){?>
                                                                <select class="form-control" name="<?php echo $v->slug_name;?>">
                                                                    <option value="1" <?php echo ($v->slug_data=='1')?' selected="selected"':'';?>>Yes</option>
                                                                    <option value="0" <?php echo ($v->slug_data=='0')?' selected="selected"':'';?>>No</option>
                                                            </select>
                                                            <?php }elseif($v->input_type=='date'){?>
                                                                <input type="date" name="<?php echo $v->slug_name;?>" class="form-control datetimepicker-input" value="<?php echo $v->slug_data;?>"/>
                                                            <?php }?>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <?php }?>
                                            </div>
                                            
                                            <!-- end of row -->
                                            <div class="text-center">
                                                <a id="back_btn" style="display:none;" href="<?php echo  base_url('index.php/admin/settings') ?>" class="btn btn-dark waves-effect waves-light m-r-20">Back</a>
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


