<!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?php echo base_url() ?>themes/useraccount/js/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>themes/useraccount/js/popper.min.js"></script>
    <script src="<?php echo base_url() ?>themes/useraccount/js/bootstrap.min.js" ></script>

    <!-- Custom JS -->
    <script src="<?php echo base_url() ?>themes/useraccount/js/aos.js" ></script>
    <script src="<?php echo base_url() ?>themes/useraccount/js/owl.carousel.js" ></script>
    <script src="<?php echo base_url() ?>themes/useraccount/js/custom.js" ></script>

    <script type="text/javascript">
        AOS.init({
            easing: 'ease-in-out-sine'
          });
    </script>

    <script>
    $(document).ready(function(){
      $(".bd_toggle").click(function(){
        $("body").toggleClass("bodysidebar");
      });
    });
    function ShowSideBarProfileSetting(obj){
        if ($(obj).parent().parent().parent().find('.user-plate').hasClass( "plate-show" )){
            $(obj).parent().parent().parent().find('.user-plate').removeClass('plate-show');
        } else {
            $(obj).parent().parent().parent().find('.user-plate').addClass('plate-show');
        }
        
    }
    
    function CloseSetting(){
        $("#navbarDropdown").trigger('click');
    }
    
    function loadNewOrganisation(org_id){
        var url = '<?php echo base_url('useraccount/reset-0rganisation').'.html';?>';
        
        var data = new FormData();
        data.append('org_id', org_id);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                        location.reload();
                    }
                }
            }
        }).fail(function () {
        });
    }
    </script>