<!-- Warning Section Ends -->
<!-- Required Jquery -->
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/bootstrap/js/bootstrap.min.js"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<!-- modernizr js -->
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/modernizr/js/modernizr.js"></script>
<!-- am chart -->
<script src="<?php echo base_url() ?>themes/backend/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?php echo base_url() ?>themes/backend/assets/pages/widget/amchart/serial.min.js"></script>
<!-- Chart js -->
<!--<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/chart.js/js/Chart.js"></script>-->
<!-- Todo js -->
<!--<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/pages/todo/todo.js "></script>-->
<!-- i18next.min.js -->
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<!-- Custom js -->
<!--<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/pages/dashboard/custom-dashboard.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/SmoothScroll.js"></script>
<script src="<?php echo base_url() ?>themes/backend/assets/js/pcoded.min.js"></script>
<script src="<?php echo base_url() ?>themes/backend/assets/js/demo-12.js"></script>
<script src="<?php echo base_url() ?>themes/backend/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/script.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/datatable/dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/jquery-confirm.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/css/notie/dist/notie.min.js"></script>

<?php
$ci_class = $this->router->fetch_class();
if ($ci_class == 'cms' || $ci_class == 'blogs'):
    ?>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/wysiwyg-editor-summernote/dist/summernote-bs4.js"></script>
<?php elseif ($ci_class == 'order'): ?>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/moment.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/bootstrap-daterangepicker/daterangepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/printThis/printThis.js"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url() ?>themes/backend/assets/js/common.js"></script>
<?php if ($this->session->flashdata('flash_succmsg')): ?>
    <script>
        success_msg('<?php echo $this->session->flashdata('flash_succmsg'); ?>', 8);
    </script>

    <?php
endif;
if ($this->session->flashdata('flash_errmsg')):
    ?>
    <script>
        error_msg('<?php echo $this->session->flashdata('flash_errmsg'); ?>');
    </script>

<?php endif; ?>
<script>
    $(document).ready(function () {
        $(".pcoded-item").show();
    });
</script>
</body>

</html>