<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
        input[type=file] {
  cursor: pointer;
  height: 34px;
  overflow: hidden;
}


input[name='banner']:before {
  line-height: 32px;
  content: 'Picture';
  display: inline-block;
  background: white;
  text-align: center;
}

input[type=file]::-webkit-file-upload-button {
  visibility: hidden;
}
    </style>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="rgt-body-title"><?php echo $page_type;?></div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-cms')?>" id="do-add-cms-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->cms_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">
                      <?php if($model->type=='text'){?>
                      <div class="form-group">
                        <textarea class="form-control" name="cms_data" value="<?php echo  isset($model) ? $model->cms_data : '' ?>" placeholder="cms data"><?php echo  isset($model) ? $model->cms_data : '' ?></textarea>
                        <span class="text-danger"></span>
                    </div>
                      <?php }elseif($model->type=='image'){?>
                      <div class="form-group">
                            <input type="file" name="banner" class="form-control" placeholder="Pic">
                            <span class="text-danger"></span>
                        </div>
                      <?php }?>
                  </div>
                  
                </div>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> CMS</button>
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
    $(document).on('submit', '#do-add-cms-form', function (event) {
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
                        $('#do-add-cms-form').find('.alert-success').html(resp.message).show();
                        //$('#do-add-cms-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-cms-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
