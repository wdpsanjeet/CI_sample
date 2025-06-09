<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
        input[type=file] {
  cursor: pointer;
  height: 34px;
  overflow: hidden;
}

input[name='added_by_img']:before {
  line-height: 32px;
  content: 'Person Pic';
  display: inline-block;
  background: white;
  text-align: center;
}

input[name='thumbnail']:before {
  line-height: 32px;
  content: 'Blog Pic';
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
              <form action="<?php echo base_url('useraccount/do-add-blogs')?>" id="do-add-blogs-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->blogs_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">
                      <div class="row">
                          <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="tag_name" value="<?php echo  isset($model) ? $model->tag_name : '' ?>" class="form-control" placeholder="Tag name">
                        <span class="text-danger"></span>
                    </div>
                          </div>
                      <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="title" value="<?php echo  isset($model) ? $model->title : '' ?>" class="form-control" placeholder="Title">
                        <span class="text-danger"></span>
                    </div>
                          </div>
                          </div>
                      <div class="form-group">
                        <textarea class="form-control" name="description" value="<?php echo  isset($model) ? $model->description : '' ?>" placeholder="Description"><?php echo  isset($model) ? $model->description : '' ?></textarea>
                        <span class="text-danger"></span>
                    </div>
                       
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="added_by" value="<?php echo  isset($model) ? $model->added_by : '' ?>" class="form-control" placeholder="Person name">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="added_by_img" class="form-control" placeholder="Product Pic">
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="thumbnail" class="form-control" placeholder="Blog Pic">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      
                    </div>

                  </div>
                  
                </div>
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> BLOG</button>
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
    $(document).on('submit', '#do-add-blogs-form', function (event) {
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
                        $('#do-add-blogs-form').find('.alert-success').html(resp.message).show();
                        $('#do-add-blogs-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-blogs-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
