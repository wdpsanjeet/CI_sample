<!doctype html>
<html lang="en">
<?php $this->load->view('partial/header_script'); ?>
<body>
<?php $this->load->view('partial/header'); ?>
    <div class="body_wrapper">
        <?php $this->load->view('partial/header_menu'); ?>
  <section class="breadcrumb_area">
            <img class="breadcrumb_shap" src="<?php echo base_url().'themes/frontend/'?>img/breadcrumb/banner_bg.png" alt="">
            <div class="container">
                <div class="breadcrumb_content text-center">
                    <h1 class="f_p f_700 f_size_50 w_color l_height50 mb_20">Contact Us</h1>
					<p class="f_400 w_color f_size_16 l_height26">Have any questions? We'd love to hear from you.</p>
                </div>
            </div>
        </section>

        <section class="contact_info_area sec_pad bg_color">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 pr-0">
                        <div class="contact_info_item">
                            <h6 class="f_p f_size_20 t_color3 f_500 mb_20">Address</h6>
                            <p class="f_400 f_size_15">36/5 Somasandrapalya Road, 27th Main Rd, Bengaluru, Karnataka 560102</p>
                        </div>
                        <div class="contact_info_item">
                            <h6 class="f_p f_size_20 t_color3 f_500 mb_20">Contact Info</h6>
                            <p class="f_400 f_size_15"><span class="f_400 t_color3">Phone:</span> <a
                                    href="tel:3024437488">(+91) 9632559955</a></p>
                            <p class="f_400 f_size_15"><span class="f_400 t_color3">Email:</span> <a
                                    href="mailto:saasland@gmail.com">contact@varthak.io</a></p>
                        </div>
                    </div>
                    <div class="col-lg-8 offset-lg-1">
                        <div class="mapbox">
                            <div id="mapBox" class="row m0" data-lat="12.899779878021194" data-lon="77.64962225470052" data-zoom="12"
                                data-info="36/5 Somasandrapalya Road, 27th Main Rd, Bengaluru, Karnataka 560102"
                                data-marker="" data-mlat="12.899795565113733" data-mlon="77.64956324624319">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="contact_form">
                    <h2 class="f_p f_size_22 t_color3 f_600 l_height28 mt_100 mb_40">Leave a Message</h2>
                    <form action="<?php echo base_url('contact-form')?>" class="contact_form_box" method="post" id="contactForm"
                        novalidate="novalidate">
                        <div class="row"><span class="alert alert-success" style="display:none;width:95%"></span></div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group text_box">
                                    <input type="text" id="name" name="name" placeholder="Your Name">
                                    <span class="text-light bg-dark"></span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group text_box">
                                    <input type="text" name="email_id" id="email_id" placeholder="Your Email">
                                    <span class="text-light bg-dark"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text_box">
                                    <input type="text" id="message" name="message" placeholder="Subject">
                                    <span class="text-light bg-dark"></span>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group text_box">
                                    <textarea name="comment" id="comment" cols="30" rows="10"
                                        placeholder="Enter Your Message . . ."></textarea>
                                    <span class="text-light bg-dark"></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn_three">Send Message</button>
                    </form>
                    <div id="success">Your message succesfully sent!</div>
                    <div id="error">Opps! There is something wrong. Please try again</div>
                </div>
            </div>
        </section>
<?php $this->load->view('partial/footer'); ?>
</div>
    
<?php $this->load->view('partial/footer_script'); ?>
     <script>
    $(document).ready(function () {
    $(document).on('submit', '#contactForm', function (event) {
        event.preventDefault();
        $('.text-light').html('');
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
                        $('#contactForm').find('.alert-success').html(resp.message).show();
                        $('#contactForm').trigger("reset");
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#contactForm').find('[name="' + key + '"]').closest('.form-group').find('.text-light').html(val);
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