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
                      <?php 
                      if($access_level[MODULE_ACCESS_TYPE_ADD]){
                      ?>
                      <a href="<?php echo base_url('useraccount/add-product').'.html'?>"><img src="<?php echo base_url() ?>themes/useraccount/images/plus.png"> Add Products</a>
                      <?php }?>
                  </div>
                  
                </div>
              </div>
            </div>
          		<table>
          			<thead>
          				<tr>
          					<th>Products Name</th>
          					<th>small notes</th>
          					<th>price</th>
          					<th>quantity</th>
                                                <th>Is Popular</th>
                                                <th>Is Top Item</th>
                                                <th>Is Hot Offer</th>
          					<th></th>
          				</tr>
          			</thead>
          			<tbody>
                                    <?php if($products['total']>0){
                                        
                                        foreach($products['result'] as $list){
                                        ?>
          				<tr>	
          					
                                                <td><strong><?php echo $list->product_name;?></strong></td>
          					<td><?php echo $list->small_note;?></td>
          					<td><?php echo $list->price;?></td>
          					<td><?php echo $list->quantity_val.' '.$list->quantity_unit;?></td>
                                                <td>
	      						 <div class="checkbox switcher">
							      <label for="popular_<?php echo $list->product_id;?>">
                                                                  <input type="checkbox" name="popular" id="popular_<?php echo $list->product_id;?>" value="<?php echo $list->is_popular;?>" <?php echo ($list->is_popular=='1')?'checked':'';?>>
							        <span><small></small></span>
							      </label>
							    </div>
          					</td>
                                                <td>
	      						 <div class="checkbox switcher">
							      <label for="topitem_<?php echo $list->product_id;?>">
                                                                  <input type="checkbox" name="topitem" id="topitem_<?php echo $list->product_id;?>" value="<?php echo $list->is_topitem;?>" <?php echo ($list->is_topitem=='1')?'checked':'';?>>
							        <span><small></small></span>
							      </label>
							    </div>
          					</td>
                                                <td>
	      						 <div class="checkbox switcher">
							      <label for="hotitem_<?php echo $list->product_id;?>">
                                                                  <input type="checkbox" name="hotitem" id="hotitem_<?php echo $list->product_id;?>" value="<?php echo $list->is_hotoffer;?>" <?php echo ($list->is_hotoffer=='1')?'checked':'';?>>
							        <span><small></small></span>
							      </label>
							    </div>
          					</td>
                                                <td style="min-width: 70px;">
                                                    <?php if($access_level[MODULE_ACCESS_TYPE_EDIT]){?>
          						<a href="<?php echo base_url('useraccount/edit-product/').$list->product_id.'.html'?>" class="edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
