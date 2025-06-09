<?php
$user_name = $this->session->userdata('user_name');
$user_email = $this->session->userdata('user_email');
$sub_domain = $this->session->userdata('sub_domain');
$organisation_list = $this->all_function->all_organisation_by_userid($this->session->userdata('user_id'));
?>
<style>
    .text-draft {
    color: #879697;
}
.grid-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-gap: 20px;
}
.grid-container:hover{
   background-color:#268ddd;
   color: white;
}
.radio-custom {
    opacity: 0;
    position: absolute;   
}

.radio-custom, .radio-custom-label {
    display: inline-block;
    vertical-align: middle;
    margin: 5px;
    cursor: pointer;
}

.radio-custom-label {
    position: relative;
}

.radio-custom + .radio-custom-label:before {
    content: '';
    background: green;
    border: 2px solid #ddd;
    display: inline-block;
    vertical-align: middle;
    width: 25px;
    height: 25px;
    padding: 2px;
    margin-right: 10px;
    text-align: center;
}


.radio-custom + .radio-custom-label:before {
    border-radius: 50%;
}

.radio-custom:checked + .radio-custom-label:before {
    content: "\f00c";
    font-family: 'FontAwesome';
    color: #fff;
}

.radio-custom:focus + .radio-custom-label {
  outline: 1px solid #ddd; /* focus style */
}
</style>
<div class="d-flex">
          <button class="bd_toggle" type="button">
            <span></span>
          </button>
    <h3 style="margin-left: 30px;"><?php echo $page_title?></h3>
          <div class="topheadrgt">
            <ul class="navul navbar-nav mr-auto d-felx flex-wrap align-items-center">
              <li class="nav-item dropdown topusersec">
                <a href="javascript:;" onclick="ShowSideBarProfileSetting(this)" id="navbarDropdown">
                  <img src="<?php echo base_url() ?>themes/useraccount/images/userimg.png" class="userimg">
                </a>
              </li>
            </ul>
            <div class="user-plate">
                <a href="javascript:;" onclick="CloseSetting()" class="plate-close"><img src="<?php echo base_url() ?>themes/useraccount/images/close-button-png-30238.png" class="userimg"></a>
                <div class="user-info-sec">
                  <div class="user-avater"><img src="<?php echo base_url() ?>themes/useraccount/images/userimg.png" class="userimg"></div>
                  <div class="avater-title"><?php echo $user_name;?></div>
                  <div class="avater-mail"><?php echo $user_email;?></div>
                  <div class="avater-sign d-flex justify-content-center">
                      <a href="<?php echo base_url($sub_domain.'/index').'.html';?>" target="_blank">Web site</a> | <a href="<?php echo base_url('useraccount/edit-profile').'.html';?>">My Account</a> | <a href="<?php echo base_url('logout').'.html';?>">Sign Out</a>
                  </div>
                </div>
                <div class="user-info-bottom">
                    <span class="" style="float: left;">MY ORGANIZATIONS</span>
                    <div style="float: right;"><a href="<?php echo base_url('useraccount/organisation-list').'.html';?>" style="color: #2a74be"><i class="fa fa-cog" aria-hidden="true"></i> Manage</a></div>
                </div>
                <div>
                    <?php foreach($organisation_list as $list){?>
                    <div class="grid-container" onclick="loadNewOrganisation('<?php echo $list->org_id?>');">

                    <div class="grid-child purple" style="text-align: left;padding: 20px;font-size: 13px;">
                        <?php echo $list->org_name?><br>
                        <i>Organization ID: <?php echo $list->company_code?></i>
                    </div>
                        <?php if($list->default_organisation=='1'){?>
                    <div class="grid-child green" style="text-align: right;padding: 20px;font-size: 13px;">
                        <div>
            <input id="radio-1" class="radio-custom" name="radio-group" type="radio" checked>
            <label for="radio-1" class="radio-custom-label"></label>
        </div>
                    </div>
                        <?php }?>

                </div>
                    <?php }?>
                    
                </div>
              </div>
          </div>
		</div>