<?php if($this->session->flashdata('flash_message')):?>
<div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
        <strong>Error!</strong> <?php echo $this->session->flashdata('flash_message');?>
</div>
<?php endif;?>