<?php $this->load->view('partial/header_script'); ?>
<?php
$selected = '';
if (isset($_GET['tab'])) {
    $selected = $_GET['tab'];
}
?>

<div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <!-- tab header start -->
            <div class="tab-header card">
                <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($selected == 'personal' || $selected == '') ? 'active' : ''; ?>" href="<?php echo base_url('index.php/admin/editProfile') ?>?tab=personal" role="tab">Personal Info</a>
                        <div class="slide"></div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($selected == 'contacts') ? 'active' : ''; ?>" href="<?php echo base_url('index.php/admin/editProfile') ?>?tab=contacts" role="tab">Change Password</a>
                        <div class="slide"></div>
                    </li>
                </ul>
            </div>
            <!-- tab header end -->
            <!-- tab content start -->
            <div class="tab-content">
                <!-- tab panel personal start -->
                <div class="tab-pane <?php echo ($selected == 'personal' || $selected == '') ? 'active' : ''; ?>" id="personal" role="tabpanel">
                    <!-- personal card start -->
                    <div class="card">

                        <div class="card-block">

                            <!-- end of view-info -->
                            <div class="edit-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <form  action="" method="post" enctype="multipart/form-data">
                                                <?php $this->load->view('partial/success_html'); ?>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="admin_name" class="block">Name *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input id="name" name="admin_name" type="text" class="form-control <?php if (form_error('admin_name')):echo 'form-control-danger';
                                                endif; ?>" value="<?php echo $admin->admin_name; ?>">
                                                                <span class="messages"><?php if (form_error('admin_name')):echo '<p class="text-danger error text-left">' . form_error('admin_name') . '</p>';
                                                endif; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="email" class="block">Email *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input id="email" name="email" type="text" class=" form-control <?php if (form_error('email')):echo 'form-control-danger';
                                                endif; ?>" value="<?php echo $admin->email; ?>">
                                                                <span class="messages"><?php if (form_error('email')):echo '<p class="text-danger error text-left">' . form_error('email') . '</p>';
                                                endif; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- end of row -->
                                                <div class="text-center">
                                                    <button type="submit" name="updatePersonalinfo" value="update" class="btn btn-primary waves-effect waves-light m-r-20">Save</button>
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

                    <!-- personal card end-->
                </div>
                <!-- tab pane personal end -->

                <!-- tab pane contact start -->
                <div class="tab-pane <?php echo ($selected == 'contacts') ? 'active' : ''; ?>" id="contacts" role="tabpanel">
                    <div class="card">
                        <div class="card-block">

                            <!-- end of view-info -->
                            <div class="edit-info">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="general-info">
                                            <form  action="" method="post">
<?php $this->load->view('partial/success_html'); ?>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="old_password" class="block">Old Password *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input id="old_password" name="old_password" type="password" class=" form-control <?php if (form_error('old_password')):echo 'form-control-danger';
endif; ?>">
                                                                <span class="messages"><?php if (form_error('old_password')):echo '<p class="text-danger error text-left">' . form_error('old_password') . '</p>';
endif; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="password" class="block">New Password *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input id="password" name="password" type="password" class=" form-control <?php if (form_error('password')):echo 'form-control-danger';
endif; ?>">
                                                                <span class="messages"><?php if (form_error('password')):echo '<p class="text-danger error text-left">' . form_error('password') . '</p>';
endif; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <label for="confirm_password" class="block"> Confirm Password *</label>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <input id="confirm_password" name="confirm_password" type="password" class=" form-control <?php if (form_error('confirm_password')):echo 'form-control-danger';
endif; ?>">
                                                                <span class="messages"><?php if (form_error('confirm_password')):echo '<p class="text-danger error text-left">' . form_error('confirm_password') . '</p>';
endif; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                                <!-- end of row -->
                                                <div class="text-center">
                                                    <button type="submit" name="updatePassword" value="update" class="btn btn-primary waves-effect waves-light m-r-20">Save</button>
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
                </div>

            </div>
            <!-- tab content end -->
        </div>
    </div>
</div>
<?php $this->load->view('partial/footer'); ?>
