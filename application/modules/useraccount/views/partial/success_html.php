<?php if($this->session->flashdata('flash_errmsg')):?>
                                <div class="alert alert-danger icons-alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <i class="icofont icofont-close-line-circled"></i>
                                                                    </button>
                                                                    <p><strong>Danger! </strong><?php echo $this->session->flashdata('flash_errmsg');?> </p>
                                                                </div>
                                    <?php endif;?>
                                <?php if($this->session->flashdata('flash_succmsg')):?>
                                <div class="alert alert-success icons-alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <i class="icofont icofont-close-line-circled"></i>
                                                                    </button>
                                                                    <p><?php echo $this->session->flashdata('flash_succmsg');?></p>
                                                                </div>
                                    <?php endif;?>