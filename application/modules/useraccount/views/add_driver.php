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

input[name='truck_pic']:before {
  line-height: 32px;
  content: 'Truck Pic';
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

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-driver')?>" id="do-add-driver-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                  <input type="hidden" name="cid" value="<?php echo  isset($model) ? $model->driver_id : '' ?>" />
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="name" value="<?php echo  isset($model) ? $model->name : '' ?>" class="form-control" placeholder="Name">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="phone" value="<?php echo  isset($model) ? $model->phone : '' ?>" class="form-control" placeholder="Phone Number">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="truck_number" value="<?php echo  isset($model) ? $model->truck_number : '' ?>" class="form-control" placeholder="Truck Number">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="personal_pic" class="form-control" placeholder="Personal Pic">
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="file" name="truck_pic" class="form-control" placeholder="Truck Pic">
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="company_code" value="<?php echo  isset($model) ? $model->company_code : '' ?>" class="form-control" placeholder="Company Code">
                            <span class="text-danger"></span>
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                      <div class="row">
                        <div class="col-md-3">
                        
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <button type="submit"><?php echo  isset($model) ? 'Update' : 'Add' ?></button>
                          <button type="reset">Reset</button>
                        </div>
                      </div>
                      <div class="col-md-3">
                        
                      </div>
                    </div>
                  </div>
                  
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
    $(document).on('submit', '#do-add-driver-form', function (event) {
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
                        $('#do-add-driver-form').find('.alert-success').html(resp.message).show();
                        $('#do-add-driver-form').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#do-add-driver-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
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
