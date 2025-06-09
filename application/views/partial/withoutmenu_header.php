<?php
$r_cls = $this->router->fetch_class();
$r_meth = $this->router->fetch_method();
?>
<header class="site-header">
	<div class="container">
		<div class="top-header d-flex">
			<div class="logo-section">
				<a href="javascript:;"><img src="<?php echo base_url(); ?>themes/frontend/images/logo.png" alt=""></a>
			</div>
			
		</div>
            <?php $success_msg = $this->session->userdata('success_msg');
            $flash_message = $this->session->flashdata('flash_success');
            if($success_msg!=''){
                $success = $success_msg;
            }else{
                $success = $flash_message;
            }
            ?>
            <div class="alert alert-success" role="alert" id="global_succmsg" <?php echo ($success=='')?'style="display:none;z-index: 999;margin-top:5px;"':'';?>>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> <?php echo $success;?>
            <?php $this->session->set_userdata('success_msg','');?>
        </div>
	</div>
</header>