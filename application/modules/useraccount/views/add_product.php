<!doctype html>
<html lang="en">
  <?php $this->load->view('partial/header_script'); ?>
    <style>
        .jszvzQ {
    display: flex;
    -webkit-box-pack: justify;
    justify-content: space-between;
    -webkit-box-align: center;
    align-items: center;
    height: 125px;
    margin: 0px 12px;
}
.bqXZKj {
    display: flex;
    -webkit-box-align: center;
    align-items: center;
}
.kiNLFp {
    display: flex;
    flex-direction: row;
}

.eBdTHk {
    display: flex;
    -webkit-box-align: center;
    align-items: center;
    -webkit-box-pack: center;
    justify-content: center;
    position: relative;
    width: 18px;
    height: 18px;
    background: rgb(2, 177, 176);
    border-radius: 1px;
}
.fYNUve {
    height: 12px;
    width: 12px;
    visibility: visible;
}
.hNreIX {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    margin: 0px 14px 0px 27px;
}
.cBfRCw {
    display: flex;
}
.eKdlPh {
    font-weight: bold;
    font-size: 24px;
    line-height: 29px;
}

.infine-scroll {
  max-height: 500px;
  padding: 1rem;
  overflow-y: auto;
  direction: ltr;
  scrollbar-color: #d4aa70 #e4e4e4;
  scrollbar-width: thin;
}

.infine-scroll::-webkit-scrollbar {
  width: 20px;
}

.infine-scroll::-webkit-scrollbar-track {
  background-color: #e4e4e4;
  border-radius: 100px;
}

.infine-scroll::-webkit-scrollbar-thumb {
  border-radius: 100px;
  background-image: linear-gradient(180deg, #d0368a 0%, #708ad4 99%);
  box-shadow: inset 2px 2px 5px 0 rgba(#fff, 0.5);
}
.dFBDzw {
    height: 70px;
    margin: 10px 0px 20px;
    padding: 0px 8px;
    overflow: auto;
    white-space: nowrap;
}
.hqMQmz {
    height: 32px;
    margin: 15px 8px;
    padding: 0px 16px;
    background: rgb(250 0 171);
    border: 0px;
    border-radius: 20px;
    font-family: "SF Pro Display";
    line-height: 16px;
    cursor: pointer;
    color: white;
    font-size: 14px;
    font-weight: 600;
    box-shadow: rgb(65 71 155 / 29%) 0px 4px 6px;
}
.ikYVhr {
    height: 32px;
    margin: 15px 8px;
    padding: 0px 16px;
    background: rgba(82, 103, 174, 0.08);
    border: 0px;
    border-radius: 20px;
    font-family: "SF Pro Display";
    font-weight: 500;
    font-size: 14px;
    line-height: 16px;
    color: rgb(82, 103, 174);
    cursor: pointer;
}
.bITjLF {
    color: rgb(255, 255, 255);
    border-radius: 6px;
    font-family: "SF Pro Display";
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.2px;
    outline: none;
    cursor: not-allowed;
    width: 146px;
    height: 32px;
    border: 0px !important;
    background: rgb(207, 214, 222) !important;
}
.bTybeV {
    background: rgb(250 0 171);
    color: rgb(255, 255, 255);
    border-radius: 6px;
    font-family: "SF Pro Display";
    font-style: normal;
    font-weight: normal;
    font-size: 14px;
    line-height: 20px;
    letter-spacing: 0.2px;
    outline: none;
    cursor: pointer;
    width: 146px;
    height: 32px;
    border: 0px !important;
}
    </style>
  <body>
<div class="body_sec">
      <?php $this->load->view('partial/left_menu'); ?>
      <div class="rgt_sidebar">
        <div class="rgt_tophead">
        	<?php $this->load->view('partial/top_header'); ?>


          <div class="rgt-sidebar-body">
              <div class="row">
              
              <div class="col-md-12">
                  <div class="sc-bHXZN dFBDzw">
                      <?php foreach($category as $list){?>
<!--                      <button class="sc-fZnpCs hqMQmz">Rice, Flour &amp; Pulses</button>-->
                          <button class="sc-fZnpCs ikYVhr" onclick="loadCategoryProduct(this,'<?php echo $list->category_id;?>')"><?php echo $list->category_name;?></button>
                      <?php }?>
                  </div>
              </div>
            </div>
              <div class="row">
              <div class="col-md-8">
                <div class="dash-tbl-topbar d-flex">
          			
                    <div class="select-wrap">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                                            <label class="form-check-label" for="flexCheckChecked" id="totalItemValue">
                                              0 items checked
                                            </label>
                                          </div>
                                        
                                    </div>
          			
          		</div>
              </div>
              <div class="col-md-4">
                <div class="dash-topbar-right d-flex">
                  <div class="topbar-right-btn">
                      <button font-size="14px" font-weight="normal" class="sc-jNMdTA bITjLF" id="addProductBtn" disabled="">Add Products</button>
                  </div>
                </div>
              </div>
            </div>

            <div class="dash-frm-wrap" style="margin-bottom: 50px;">
              <form action="<?php echo base_url('useraccount/do-add-master-product')?>" id="do-add-product-form" method="post">
                  <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                <div class="row">
                  <div class="col-md-12">
                      <div class="infine-scroll">
                          <?php foreach($varthak_products['result'] as $list){?>
                          <div class="sc-fePcYi jszvzQ">
                              <div class="sc-ePYyfT bqXZKj">
                                  <label class="sc-XhUPp kiNLFp">
                                      <input type="checkbox" name="product_id[]" value="<?php echo $list->product_id;?>" class="sc-ikPAkQ ceimHt">
                                      
                                  </label>
                                  <img src="<?php echo base_url().'uploads/varthak_product/'.$list->image_name;?>" alt="<?php echo $list->item_name;?>" class="sc-iyjaVZ hNreIX">
                                  <div class="sc-iMZFOo cBfRCw">
                                      <?php echo $list->item_name;?>
                                  </div>
                                      
                              </div>
                              <p class="sc-hFNyKf eKdlPh">₹<?php echo $list->selling_price;?></p>
                          </div>
                          <?php }?>
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
    $(document).on('submit', '#do-add-product-form', function (event) {
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
                    window.location='<?php echo base_url('useraccount/products');?>';
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-product-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    });
    });
    $(document).on('click','#addProductBtn',function() {
        $('#do-add-product-form').submit();
    });
    function loadCategoryProduct(obj,id){
        var url = '<?php echo base_url().'useraccount/search-product-by-category-id'?>';
        var $currentObj = $(obj);
        var data = id;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {id:data},
            success: function (resp) {
                if (resp.status === 200) {
                    if (resp.message) {
                        $('.infine-scroll').html('.alert-success').html(resp.message);
                        $('.sc-bHXZN .hqMQmz').removeClass('hqMQmz').addClass('ikYVhr');
                        $currentObj.removeClass('ikYVhr').addClass('hqMQmz');
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        
                        $('#do-add-product-form').find('[name="' + key + '"]').closest('.form-group').find('.text-danger').html(val);
                    });
                }
            }
        }).fail(function () {
        });
    }
    $(document).on('change','#do-add-product-form input[type="checkbox"]',function() {
        if($(this).is(":checked")) {
            //alert($(this).val());
        }
        var total=$('#do-add-product-form input[type="checkbox"]:checked').length;  
        $("#totalItemValue").text(total+' items checked');
        if(total>0){
            $("#addProductBtn").removeAttr('disabled').removeClass('bITjLF').addClass('bTybeV');
            $("#flexCheckChecked").prop("checked", true);
        }else{
            $("#addProductBtn").attr('disabled','disabled').removeClass('bTybeV').addClass('bITjLF');
            $("#flexCheckChecked").prop("checked", false);
        }
    });
    $(document).on('change','#flexCheckChecked',function() {
        if($(this).is(":checked")) {
            $('.sc-ikPAkQ').prop('checked', true);
            var total=$('#do-add-product-form input[type="checkbox"]:checked').length;  
            $("#totalItemValue").text(total+' items checked');
            if(total>0){
                $("#addProductBtn").removeAttr('disabled').removeClass('bITjLF').addClass('bTybeV');
            }else{
                $("#addProductBtn").attr('disabled','disabled').removeClass('bTybeV').addClass('bITjLF');
            }
        }else{
            $('.sc-ikPAkQ').prop('checked', false);
            var total=$('#do-add-product-form input[type="checkbox"]:checked').length;  
            $("#totalItemValue").text(total+' items checked');
            if(total>0){
                $("#addProductBtn").removeAttr('disabled').removeClass('bITjLF').addClass('bTybeV');
            }else{
                $("#addProductBtn").attr('disabled','disabled').removeClass('bTybeV').addClass('bITjLF');
            }
        }
        
    });
    </script>
  </body>
</html>
