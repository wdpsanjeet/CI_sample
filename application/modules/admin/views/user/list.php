<?php $this->load->view('partial/header_script');
?>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">

            <!-- tab content start -->
            <div class="tab-content">
                <!-- tab panel personal start -->
                <!-- personal card start -->
                <div class="card">

                    <div class="card-block">
                        <div class="block-title">
<!--                            <a id="add_btn" href="<?php echo base_url('admin/user/add'); ?>" class="btn btn-sm btn-primary pull-right">
                                <i class="fa fa-plus"></i> Add User</a>-->
                            <h4>View User Listing</h4>
                        </div>
                        <!-- end of view-info -->
                        <div class="edit-info">
                            <div class="row">
                                <hr>
                                <div class="col-lg-12">
                                    <div class="card-header">
                                    </div>
                                    <div class="card-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="user-table" class="table table-striped table-hover table-bordered nowrap datatable">
                                                <thead>
                                                    <tr>
                                                        <th>Sl.No</th>
                                                        <th>name</th>
                                                        <th>email</th>
                                                        <th>phone</th>
                                                        <th>Postal Code</th>
                                                        <th>Update At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- end of edit info -->
                            </div>
                            <!-- end of col-lg-12 -->
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

   