<?php $this->load->view('partial/header_script'); ?>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">

            <!-- tab content start -->
            <div class="tab-content">
                <!-- tab panel personal start -->
                <!-- personal card start -->
                <div class="card">

                    <div class="card-block">
                        <h4>View IDs</h4>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="general-info">
                                        <form  action="<?= base_url('index.php/admin/user/submit_id') ?>" method="post" id="id_approve">
                                            <input type="hidden" name="sid" value="<?= isset($model) ? $model->id : '' ?>" />
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <?php
                                                    $front_id = $back_id = 'N/A';
                                                    if (isset($model->front_id) && $model->front_id != '') {
                                                        $front_id = '<img src="' . base_url() . 'upload/idcard/' . $model->front_id . '" alt="" class="" style="height:240px;">';
                                                    }
                                                    if (isset($model->back_id) && $model->back_id != '') {
                                                        $back_id = '<img src="' . base_url() . 'upload/idcard/' . $model->back_id . '" alt="" class="" style="height:240px;">';
                                                    }
                                                    echo $front_id;
                                                    ?>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php echo $back_id; ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="block-title d-flex justify-content-between pt-3 " style="width: 50%;">
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="radio1">
                                                                <input type="radio" class="form-check-input" id="radio1" name="id_verified" value="0" <?=($model->id_verified=='0')?'checked':''?>> Not approved
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label" for="radio2">
                                                                <input type="radio" class="form-check-input" id="radio2" name="id_verified" value="1" <?=($model->id_verified=='1')?'checked':''?>> Approved
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- end of row -->
                                            <div class="text-center">
                                                <a href="<?= base_url('index.php/admin/id-management') ?>" class="btn btn-dark waves-effect waves-light m-r-20">Back</a>
                                                <button type="submit" name="fundTransfered" value="update" class="btn btn-primary waves-effect waves-light m-r-20">Submit</button>
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
