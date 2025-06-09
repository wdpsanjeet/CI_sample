<!doctype html>
<html lang="en">
<?php $this->load->view('partial/header_script'); ?>
<body>
<?php $this->load->view('partial/withoutmenu_header'); ?>
<section class="inn-page">

<section>
    <div class="container" style="min-height: 500px">
		
            <!-- Modal -->
<div class="modal fade mail-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="<?php echo base_url(); ?>themes/frontend/images/mail-pic.png" alt="">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="mail-info-cont">
        	<h2>Thankyou for Signing Up</h2>
        	<p>Payment is successful you will get an activation link on your email within 24 hours.</p>
        </div>
      </div>
    </div>
  </div>
</div>
	</div>
</section>
</section>

<?php $this->load->view('partial/footer_script'); ?>
<script type="text/javascript">
    $(window).on('load', function() {
        $('#exampleModalCenter').modal({backdrop: 'static', keyboard: false});
    });
    $('#exampleModalCenter').on('hidden.bs.modal', function () {
    window.location='<?php echo base_url();?>';
  });
</script>
</body>
</html>