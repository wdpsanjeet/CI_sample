<!doctype html>
<html lang="en">
    <?php $this->load->view('partial/header_script'); ?>
    <body>
        <div class="body_sec">
            <?php $this->load->view('partial/left_menu'); ?>
            <div class="rgt_sidebar">
                <div class="rgt_tophead">
                    <?php $this->load->view('partial/top_header'); ?>


                    <div class="rgt-sidebar-body">

                        <div class="dash-frm-wrap" style="margin-bottom: 50px;">
                            <from action="" method="post">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="row">
                                            <div class="col-md-6 edituserprofile">
                                                <img src="<?php echo base_url();?>themes/useraccount/images/userimg.png" class="userimg"><a style="padding-left: 10px"><strong>change profile picture</strong></a>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>

                                        </div>
                                        <div class="row"> &nbsp;</div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="name" value="<?php echo $user->name;?>" class="form-control" placeholder="First Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input type="text" name="email" value="<?php echo $user->email;?>" class="form-control" placeholder="Email">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <input type="text" name="present_address" value="<?php echo $user->present_address;?>" class="form-control" placeholder="Location">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control"  name="biography" value="<?php echo $user->biography;?>" placeholder="Bio"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="interest" value="<?php echo $user->interest;?>" class="form-control" placeholder="Interest">
                                        </div>

                                    </div>
                                    <div class="col-md-5">

                                        <div class="frm-map">
                                            <img src="<?php echo base_url() ?>themes/useraccount/images/profileupdate_art.png">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mt-3">
                                    <button type="submit">UPDATE ACCOUNT</button>
                                </div>
                            </from>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <?php $this->load->view('partial/footer_script'); ?>  

    </body>
</html>
