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
                        <h4><?php echo  isset($model) ? 'Edit' : 'Add' ?> Blogs </h4>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <form  action="<?php echo  base_url('index.php/admin/blogs/store') ?>" method="post" id="edit_blogs" >
                                            <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->blogs_id : '' ?>" />
                                            <div class="row">
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="name" class="block"><stong>Blogs Title *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="postal_code" name="title" type="text" class="form-control" value="<?php echo  isset($model) ? $model->title : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6" style="">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="name" class="block"><stong>Added By *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input id="postal_code" name="added_by" type="text" class="form-control" value="<?php echo  isset($model) ? $model->added_by : '' ?>">
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="title" class="block"><stong>Description  *</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <textarea  name="description" id="smeernoteeditor" class="form-control"><?php echo isset($model->description) ? $model->description : '' ?></textarea>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                            <?php if (isset($model->thumbnail) && !empty($model->thumbnail)): ?>
                                                
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <image src="<?php echo site_url() . 'uploads/blogs/original/' . $model->thumbnail ?>" style="max-height: 150px;"/>
                                                            </div>
                                                            <span class="help-block col-sm-12"></span>
                                                        </div>
                                                    </div>
                                                
                                            <?php endif; ?>
                                            <div class="col-lg-6">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <label for="title" class="block"><stong>Blog Image</stong></label>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <input type='file' name="thumbnail" class="form-control" accept="image/*"/>
                                                        </div>
                                                        <span class="help-block col-sm-12"></span>
                                                    </div>
                                                </div>
                                                </div>
                                            
                                            
                                            <!-- end of row -->
                                            <div class="text-center">
                                                <a id="back_btn" style="display:none;" href="<?php echo  base_url('index.php/admin/blogs') ?>" class="btn btn-dark waves-effect waves-light m-r-20">Back</a>
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


