<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>

          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Role</th>
          					<th>Action</th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($roles['total']>0){
                                        
                                        foreach($roles['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->role_name;?></strong></td>
                                                <td>
                                                    <?php if($access_level[MODULE_ACCESS_TYPE_EDIT]){?>
          						<a href="<?php echo base_url('useraccount/roles/permission/').$list->role_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                                        <?php }?>
          					</td>
          				</tr>
                                    <?php 
                                        }
                                        }?>
          			</tbody>
          		</table>
          	</div>

        </div>
      </div>
    </div>
    <?php $this->load->view('partial/footer_script'); ?>  
       <script>
    $(document).ready(function () {
    $(document).on('change', '[name="popular"]', function () {
        var enable_status = '0';
         if ($(this).prop('checked')==true){ 
            enable_status = '1';
        }
        var formData = new FormData();
        formData.append('enable_status', enable_status);
        formData.append('product_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/products-is-popular-update');?>',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (resp) {
                
            }
        }).fail(function () {
        });
    });
    $(document).on('change', '[name="topitem"]', function () {
        var enable_status = '0';
         if ($(this).prop('checked')==true){ 
            enable_status = '1';
        }
        var formData = new FormData();
        formData.append('enable_status', enable_status);
        formData.append('product_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/products-is-topitem-update');?>',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (resp) {
                
            }
        }).fail(function () {
        });
    });
    $(document).on('change', '[name="hotitem"]', function () {
        var enable_status = '0';
         if ($(this).prop('checked')==true){ 
            enable_status = '1';
        }
        var formData = new FormData();
        formData.append('enable_status', enable_status);
        formData.append('product_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/products-is-hotitem-update');?>',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (resp) {
                
            }
        }).fail(function () {
        });
    });
    });
    
    </script>
  </body>
</html>
