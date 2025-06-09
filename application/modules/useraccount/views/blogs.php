<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


<!--          <div class="rgt-sidebar-body">
              <div class="block-title">
                            <a href="<?php echo base_url('admin/blogs/add'); ?>" class="btn pull-right">
                                <i class="fa fa-plus-circle"></i> Add Products</a>
                        </div>
              <div></div>
          </div>-->
          <div class="dash-tbl">
          		<div class="row">
              <div class="col-md-8">
                
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <?php 
                      if($access_level[MODULE_ACCESS_TYPE_ADD]){
                      ?>
                      <a href="<?php echo base_url('useraccount/add-blogs').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Blog</a>
                      <?php }?>
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Title</th>
          					<th>Tag</th>
          					<th>Added by</th>
          					<th>Added date</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($blogs['total']>0){
                                        foreach($blogs['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->title;?></strong></td>
          					<td><?php echo $list->tag_name;?></td>
          					<td><?php echo $list->added_by;?></td>
          					<td><?php echo date('d/m/Y',strtotime($list->added_date));?></td>
                                                
                                                <td style="min-width: 70px;">
                                                    <?php if($access_level[MODULE_ACCESS_TYPE_EDIT]){?>
          						<a href="<?php echo base_url('useraccount/edit-blogs/').$list->blogs_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
        formData.append('blogs_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/blogs-is-popular-update');?>',
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
        formData.append('blogs_id', $(this).attr('id'));
        $.ajax({
            url: '<?php echo base_url('useraccount/blogs-is-topitem-update');?>',
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
