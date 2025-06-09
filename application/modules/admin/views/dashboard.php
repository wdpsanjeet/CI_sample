<?php $this->load->view('partial/header_script'); 
$userdata = $this->session->userdata();
?>


<div class="page-body">
    <div class="row">
        <?php if ($userdata['admin_role'] == 'admin'): ?>
            <!-- card1 start -->
            <div class="col-md-6 col-xl-4">
                <div class="card widget-card-1">
                    <a href="#">
                        <div class="card-block-small">
                            <i class="icofont icofont-pie-chart bg-c-blue card1-icon"></i>
                            <span class="text-c-blue f-w-600">User Management</span>
                            <h4>&nbsp;</h4>

                        </div>
                    </a>
                </div>
            </div>

            <!-- card1 end -->
            <!-- card1 start -->
            <div class="col-md-6 col-xl-4">
                <div class="card widget-card-1">
                    <a href="#">
                        <div class="card-block-small">
                            <i class="icofont icofont-ui-home bg-c-pink card1-icon"></i>
                            <span class="text-c-pink f-w-600">Order Management</span>
                            <h4>&nbsp;</h4>

                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-xl-4">
                <div class="card widget-card-1">
                    <a href="<?php echo base_url('index.php/admin/contactus') ?>">
                        <div class="card-block-small">
                            <i class="icofont icofont-ui-home bg-c-green card1-icon"></i>
                            <span class="text-c-pink f-w-600">Contact Us</span>
                            <h4>&nbsp;</h4>

                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
        <!-- card1 end -->
        
    </div>
</div>
<?php $this->load->view('partial/footer'); ?>
