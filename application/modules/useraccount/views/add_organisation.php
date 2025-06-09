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
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-organisation')?>" id="do-add-organisation-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->org_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">

                    <div class="form-group">
                        <input type="text" name="org_name" value="<?php echo  isset($model) ? $model->org_name : '' ?>" class="form-control" placeholder="Organisation name">
                        <span class="text-danger"></span>
                    </div>
                    
                  </div>
                  
                </div>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> Organisation</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
      <script>
    $(document).ready(function () {
    $(document).on('submit', '#do-add-organisation-form', function (event) {
        event.preventDefault();
        $('.text-danger').html('');
        var url = $(this).attr('action');
        
        var data = new FormData($(this)[0]);
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
                        $('#do-add-organisation-form').find('.alert-success').html(resp.message).show();
                        $('#do-add-organisation-form').trigger("reset");
                        location.reload();
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-organisation-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    
    </script>
  </body>
</html>
