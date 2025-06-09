<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
   <style>
        input[type=file] {
  cursor: pointer;
  height: 34px;
  overflow: hidden;
}

input[name='personal_pic']:before {
  line-height: 32px;
  content: 'Personal Pic';
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
              <form action="<?php echo base_url('useraccount/do-add-staff')?>" id="do-add-staff-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->org_user_id : '' ?>" />
                <div class="row">
                  <div class="col-md-6">

                    <div class="form-group">
                        <select class="form-control" name="role_id">
                            <option value="">select role</option>
                            <?php foreach($roles as $list){?>
                            <option value="<?php echo $list->role_id?>" <?php echo (isset($model) && $model->role_id==$list->role_id)?'selected="selected"':'';?>><?php echo $list->role_name?></option>
                            <?php }?>
                        </select>
                        <span class="text-danger"></span>
                    </div>
                    
                  </div>
                    <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="phone" value="<?php echo  isset($model) ? $model->phone : '' ?>" class="form-control" placeholder="phone">
                                <span class="text-danger"></span>
                            </div>
                      </div>
                  
                </div>
                  <div class="row">
                      <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="username" value="<?php echo  isset($model) ? $model->username : '' ?>" class="form-control" placeholder="Name">
                        <span class="text-danger"></span>
                    </div>
                  </div>
                      <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="email_id" value="<?php echo  isset($model) ? $model->email : '' ?>" class="form-control" placeholder="email id">
                                <span class="text-danger"></span>
                            </div>
                      </div>
                      
                  </div>
                  
                  
                <div class="form-group mt-3">
                  <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?> Staff</button>
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
    $(document).on('submit', '#do-add-staff-form', function (event) {
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
                        $('#do-add-staff-form').find('.alert-success').html(resp.message).show();
                        $('#do-add-staff-form').trigger("reset");
                        location.reload();
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-staff-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
