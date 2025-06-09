/* global notie, site_url */
'use strict'
function ajaxindicatorstart() {
    if (jQuery('body').find('#resultLoading').attr('id') != 'resultLoading') {
        jQuery('body').append('<div id="resultLoading" style="display:none;"><div><i style="font-size: 46px;color: #2ec6d0;" class="fa fa-spinner fa-spin fa-2x fa-fw" aria-hidden="true"></i></div><div class="bg"></div></div>');
    }
    jQuery('#resultLoading').css({
        'width': '100%',
        'height': '100%',
        'position': 'fixed',
        'z-index': '10000000',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto'
    });
    jQuery('#resultLoading .bg').css({
        'background': '#ffffff',
        'opacity': '0.8',
        'width': '100%',
        'height': '100%',
        'position': 'absolute',
        'top': '0'
    });
    jQuery('#resultLoading>div:first').css({
        'width': '250px',
        'height': '75px',
        'text-align': 'center',
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'right': '0',
        'bottom': '0',
        'margin': 'auto',
        'font-size': '16px',
        'z-index': '10',
        'color': '#ffffff'
    });
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeIn(300);
    jQuery('body').css('cursor', 'wait');
}

function ajaxindicatorstop() {
    jQuery('#resultLoading .bg').height('100%');
    jQuery('#resultLoading').fadeOut(300);
    jQuery('body').css('cursor', 'default');
}


function success_msg(msg, time = 6) {
    notie.alert({
        type: 'success',
        text: '<i class="fa fa-check"></i> ' + msg,
        time: time
    });
}
function error_msg(msg, time = 6) {
    notie.alert({
        type: 'error',
        text: '<i class="fa fa-times"></i> ' + msg,
        time: time
    });
}

$(document).ready(function () {
    $(document).on('submit', '#edit_availability', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    ajaxindicatorstop();
                } if (resp.status === 300) {
                    error_msg(resp.message);
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_availability').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('change', '#category_id', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
        var url = site_url + 'index.php/admin/masterproducts/get_subcategory';
        var data = new FormData();
        data.append('category_id',$(this).val());
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: data,
            success: function (resp) {
                if (resp.status === 200) {
                    $("#subcategory_id").html(resp.message);
                    ajaxindicatorstop();
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_storyscript', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_clienttele', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_clienttele').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_cms', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else if(resp.status === 400){
                    error_msg(resp.message);
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_address', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else if(resp.status === 400){
                    error_msg(resp.message);
                }else if(resp.status === 300){
                    error_msg(resp.message);
                }else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_tips', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_blogs', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_videoreview', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_videoreview').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_settings', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    $(document).on('submit', '#edit_presentation', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#edit_cms').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
    if ($('.datatable').length > 0) {
        $('#role-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'roles',
            order: [[3, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'role_name'},
                {data: 'status'},
                {data: 'date_added'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#storyscript-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/story-script',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "25%", "targets": 1 },
                { "width": "25%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "25%", "targets": 4 }
              ],
            columns: [
                {data: 'script_id', searchable: false},
                {data: 'script_text'},
                {data: 'script_image',searchable: false},
                {data: 'added_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#contactus-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/contactus',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "10%", "targets": 2 },
                { "width": "10%", "targets": 3 },
                { "width": "25%", "targets": 4 },
                { "width": "25%", "targets": 5 },
                { "width": "15%", "targets": 6 }
              ],
            columns: [
                {data: 'contact_id', searchable: false},
                {data: 'first_name'},
                {data: 'last_name'},
                {data: 'email_id'},
                {data: 'message'},
                {data: 'comment', searchable: false},
                {data: 'added_at', orderable: false, searchable: false}
            ]
        });
        $('#demo-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/demo',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "10%", "targets": 2 },
                { "width": "10%", "targets": 3 },
                { "width": "25%", "targets": 4 },
                { "width": "25%", "targets": 5 }
              ],
            columns: [
                {data: 'demo_id', searchable: false},
                {data: 'name'},
                {data: 'email_id'},
                {data: 'phone_number'},
                {data: 'company_name'},
                {data: 'added_at', orderable: false, searchable: false}
            ]
        });
        $('#cms-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/cms',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "20%", "targets": 2 },
                { "width": "40%", "targets": 3 },
                { "width": "15%", "targets": 4 }
              ],
            columns: [
                {data: 'cms_id', searchable: false},
                {data: 'page_name'},
                {data: 'section'},
                {data: 'type'},
                {data: 'cms_data', searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#user-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/user',
            order: [[1, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'name'},
                {data: 'email'},
                {data: 'phone'},
                {data: 'postal_code'},
                {data: 'updated_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#masterproduct-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/masterproducts',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "15%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "15%", "targets": 3 },
                { "width": "15%", "targets": 4 },
                { "width": "15%", "targets": 5 },
                { "width": "10%", "targets": 6 },
                { "width": "10%", "targets": 7 },
              ],
            columns: [
                {data: 'id', searchable: false},
                {data: 'image_name',searchable: false},
                {data: 'product_number'},
                {data: 'item_name'},
                {data: 'category_name'},
                {data: 'subcategory_name'},
                {data: 'nature_of_goods'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#drivers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/drivers',
            order: [[3, "desc"]],
            columns: [
                {data: 'driver_id', searchable: false},
                {data: 'phone'},
                {data: 'name'},
                {data: 'company_code'},
                {data: 'added_at'},
                {data: 'status'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#delivery-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/delivery',
            order: [[1, "desc"]],
            
            columns: [
                {data: 'id', searchable: false},
                {data: 'date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        var orderlistTable = $('#orders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
       url:site_url + 'index.php/admin/orders',
       data: function(data){
          // Read values
          var added_at = $('#added_at').val();
          var order_date = $('#order_date').val();
          var order_time = $('#order_time').val();
          var order_status = $('#order_status').val();
          // Append to data
          data.added_at = added_at;
          data.order_date = order_date;
          data.order_time = order_time;
          data.order_status = order_status;
       }
    },
//            ajax: site_url + 'index.php/admin/orders',
            order: [[7, "desc"]],
            
            columns: [
                {data: 'order_id', searchable: false},
                {data: 'invoice_id'},
                {data: 'user_name'},
                {data: 'user_email'},
                {data: 'user_phone'},
                {data: 'item_quantity'},
                {data: 'delivery_postalcode'},
                {data: 'added_at'},
                {data: 'order_date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $(document).on('submit', '#orderFilerForm', function (event) {
        event.preventDefault();
        orderlistTable.draw();
    });
    $(document).on('click', '#orderExportForm', function (event) {
        event.preventDefault();
        var added_at = $('#added_at').val();
          var order_date = $('#order_date').val();
          var order_time = $('#order_time').val();
          var order_status = $('#order_status').val();
        document.location.href = site_url + '/index.php/admin/orders/export?added_at='+added_at+'&order_date='+order_date+'&order_time='+order_time+'&order_status='+order_status;
    });
        $('#freekidmeals-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/freekidmeals',
            order: [[6, "desc"]],
            
            columns: [
                {data: 'order_id', searchable: false},
                {data: 'invoice_id'},
                {data: 'user_name'},
                {data: 'user_email'},
                {data: 'user_phone'},
                {data: 'delivery_postalcode'},
                {data: 'added_at'},
                {data: 'order_date'},
            ]
        });
        $('#events-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/events',
            order: [[6, "desc"]],
            
            columns: [
                {data: 'event_id', searchable: false},
                {data: 'event_title'},
                {data: 'event_date'},
                {data: 'total_kids'},
                {data: 'event_location'},
                {data: 'added_at'},
                {data: 'status'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        
        $('#staff-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/staff',
            order: [[4, "desc"]],
            
            columns: [
                {data: 'id', searchable: false},
                {data: 'phone'},
                {data: 'admin_name'},
                {data: 'email'},
                {data: 'added_at'},
                {data: 'status'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        
        $('#cancelorders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/cancelorders',
            order: [[1, "desc"]],
            
            columns: [
                {data: 'order_id', searchable: false},
                {data: 'invoice_id'},
                {data: 'user_name'},
                {data: 'user_email'},
                {data: 'user_phone'},
                {data: 'item_quantity'},
                {data: 'delivery_postalcode'},
                {data: 'order_date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#userorders-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'useraccount/orders',
            order: [[5, "desc"]],
            
            columns: [
                {data: 'order_id', searchable: false},
                {data: 'invoice_id'},
                {data: 'user_phone'},
                {data: 'item_quantity'},
                {data: 'delivery_postalcode'},
                {data: 'added_at'},
                {data: 'order_date'},
                {data: 'order_status',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#address-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'useraccount/addresses',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "70%", "targets": 1 },
                { "width": "25%", "targets": 2 }
              ],
            columns: [
                {data: 'address_id', searchable: false},
                {data: 'address'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        
        $('#tips-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/tips',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "15%", "targets": 1 },
                { "width": "75%", "targets": 2 },
                { "width": "10%", "targets": 3 }
              ],
            columns: [
                {data: 'tips_id', searchable: false},
                {data: 'tips_name'},
                {data: 'tips_ques'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#availability-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/availability',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "25%", "targets": 1 },
                { "width": "25%", "targets": 2 },
                { "width": "20%", "targets": 3 },
                { "width": "25%", "targets": 4 }
              ],
            columns: [
                {data: 'available_id', searchable: false},
                {data: 'days'},
                {data: 'start_time',searchable: false},
                {data: 'end_time',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#appointments-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/appointments',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "10%", "targets": 1 },
                { "width": "15%", "targets": 2 },
                { "width": "15%", "targets": 3 },
                { "width": "15%", "targets": 4 },
                { "width": "10%", "targets": 5 },
                { "width": "10%", "targets": 6 },
                { "width": "10%", "targets": 7 },
                { "width": "10%", "targets": 8 }
              ],
            columns: [
                {data: 'app_id', searchable: false},
                {data: 'f_name'},
                {data: 'contact_type', searchable: false},
                {data: 'email'},
                {data: 'phone'},
                {data: 'appointment_date'},
                {data: 'appointment_time'},
                {data: 'added_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#clienttele-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/clienttele',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "35%", "targets": 1 },
                { "width": "35%", "targets": 2 },
                { "width": "25%", "targets": 3 }
              ],
            columns: [
                {data: 'clienttele_id', searchable: false},
                {data: 'clienttele_logo', searchable: false},
                {data: 'added_at'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#blogs-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/blogs',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "25%", "targets": 1 },
                { "width": "25%", "targets": 2 },
                { "width": "15%", "targets": 3 },
                { "width": "15%", "targets": 4 },
                { "width": "15%", "targets": 5 }
              ],
            columns: [
                {data: 'blogs_id', searchable: false},
                {data: 'thumbnail', searchable: false},
                {data: 'title'},
                {data: 'added_by'},
                {data: 'added_date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#products-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/products',
            order: [[2, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "25%", "targets": 1 },
                { "width": "25%", "targets": 2 },
                { "width": "30%", "targets": 3 },
                { "width": "15%", "targets": 4 }
              ],
            columns: [
                {data: 'products_id', searchable: false},
                {data: 'thumbnail', searchable: false},
                {data: 'title'},
                {data: 'description'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#partners-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: site_url + 'index.php/admin/partners',
            order: [[1, "desc"]],
            
            columns: [
                {data: 'partners_id', searchable: false},
                {data: 'partners_logo', searchable: false},
                {data: 'added_date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#videoreview-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/videoreview',
            order: [[1, "desc"]],
            
            columns: [
                {data: 'video_id', searchable: false},
                {data: 'name'},
                {data: 'video_name', searchable: false},
                {data: 'added_at', searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#socialchat-table').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: site_url + 'index.php/admin/socialchat',
            order: [[1, "desc"]],
            
            columns: [
                {data: 'socialchat_id', searchable: false},
                {data: 'socialchat_logo', searchable: false},
                {data: 'added_date'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#zone-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/zone',
            order: [[2, "desc"]],
            "columnDefs": [
                { "width": "15%", "targets": 0 },
                { "width": "35%", "targets": 1 },
                { "width": "35", "targets": 2 },
                { "width": "15%", "targets": 3 }
              ],
            columns: [
                {data: 'zone_id', searchable: false},
                {data: 'name'},
                {data: 'added_at',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#postalcode-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/postalcode',
            order: [[2, "desc"]],
            columns: [
                {data: 'postalcode_id', searchable: false},
                {data: 'name'},
                {data: 'postalcode'},
                {data: 'added_at',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#coupon-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/coupon',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "5%", "targets": 0 },
                { "width": "20%", "targets": 1 },
                { "width": "10", "targets": 2 },
                { "width": "15%", "targets": 3 },
                { "width": "15%", "targets": 4 },
                { "width": "15%", "targets": 5 },
                { "width": "20%", "targets": 6 }
              ],
            columns: [
                {data: 'coupon_id', searchable: false},
                {data: 'coupon_code'},
                {data: 'discount',searchable: false},
                {data: 'times_used',searchable: false},
                {data: 'start_date',searchable: false},
                {data: 'end_date',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#servicelocation-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'index.php/admin/servicelocation',
            order: [[1, "desc"]],
            "columnDefs": [
                { "width": "10%", "targets": 0 },
                { "width": "25%", "targets": 1 },
                { "width": "25%", "targets": 2 },
                { "width": "25", "targets": 3 },
                { "width": "15%", "targets": 4 }
              ],
            columns: [
                {data: 'location_id', searchable: false},
                {data: 'name'},
                {data: 'postal_code'},
                {data: 'added_at',searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        if ($('.search-dateranger').length > 0) {
            $('.search-dateranger').daterangepicker({
                timePicker: false,
//                autoUpdateInput: false,
                startDate: moment().subtract(1, 'days'),
                endDate: moment(),
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                },

            }, );
            $('.search-dateranger').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });
            $('.search-dateranger').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });

            $(document).on('click', '.order-search-list', function () {
                var processtime = $('[name="processtime"]').val();
                var groupname = $('[name="groupname"]').val();
                var dvalue = {
                    'processtime': processtime,
                    'groupname': groupname,
                    'payment_type': $('[name="payment_type"]').val(),
                    'country': $('[name="country"]').val(),
                };
                $('#order-table').DataTable().column(3).search(JSON.stringify(dvalue)).draw();
            });

            $(document).on('click', '.earning-search-list', function () {
                var processtime = $('[name="processtime"]').val();
                var dvalue = {
                    'processtime': processtime,
                };
                $('#affearning-table').DataTable().column(3).search(JSON.stringify(dvalue)).draw();
            });
            $(document).on('click', '.traffic-search-list', function () {
                var processtime = $('[name="processtime"]').val();
                var dvalue = {
                    'processtime': processtime,
                };
                $('#afftraffic-table').DataTable().column(2).search(JSON.stringify(dvalue)).draw();
            });
            $(document).on('click', '.affpayment-search-list', function () {
                var processtime = $('[name="processtime"]').val();
                var dvalue = {
                    'processtime': processtime,
                };
                $('#affpaymentearning-table').DataTable().column(2).search(JSON.stringify(dvalue)).draw();
            });

            if ($('.traffic-search-list').length > 0) {
                $('.traffic-search-list').trigger('click');
            }
            if ($('.earning-search-list').length > 0) {
                $('.earning-search-list').trigger('click');
            }
            if ($('.affpayment-search-list').length > 0) {
                $('.affpayment-search-list').trigger('click');
            }
            var ordertable = $('#order-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: site_url + 'orders',
                sDom: 'lrtip',
//            searching: false,
//            order: [[1, "desc"]],
                columns: [
//                {data: 'id', searchable: false, orderable: false},

                    {data: 'id', searchable: false, className: "order_id_th"},
                    {data: 'payment_type', searchable: false, orderable: false, className: "payment_type_th"},
                    {data: 'customer_name', orderable: false, className: "customer_th"},
                    {
                        "className": 'details-control details_th',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    }
//                {data: 'order_title', orderable: false},
//                {data: 'qty', },
//                {data: 'extra', searchable: false, orderable: false},
//                {data: 'order_status'},
//                {data: 'action', orderable: false, searchable: false}
                ]
            });


            $('#order-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = ordertable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(formatOrderTbl(row.data())).show();
                    tr.addClass('shown');
                }
            });
            $('.order-search-list').trigger('click');
        }

        var affiliatetable = $('#affiliate-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'affiliates',
            sDom: 'lrtip',
//            searching: false,
            order: [[1, "desc"]],
            columns: [
                {data: 'sl_id', orderable: false, searchable: false},
                {data: 'id'},
                {data: 'name'},
                {
                    "className": 'details-control details_th',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#affiliate-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = affiliatetable.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(formatAffiliateOrderTbl(row.data())).show();
                tr.addClass('shown');
            }
        });



        $('#configuration-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'configuration',
            order: [[1, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'name'},
                {data: 'value'},
                {data: 'valuetype'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#social-settings-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: site_url + 'social-setting',
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'provider'},
                {data: 'key'},
                {data: 'enable'},
                {data: 'col_time'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#language-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'language',
            },
            order: [[1, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'word'},
                {data: 'en'},
                {data: 'es'},
                {data: 'fr'},
                {data: 'ru'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#blog-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'blog',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'itemcode'},
                {data: 'title'},
                {data: 'groupname'},
                {data: 'date_added'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#homewhatsnew-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'home-whatsnew',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'itemcode'},
                {data: 'title'},
                {data: 'groupname'},
                {data: 'col_time'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#homebanner-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'home-banners',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'thumb', searchable: false, orderable: false},
                {data: 'text'},
                {data: 'show_status'},
                {data: 'col_time'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#homemostpoplar-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'home-mostpoplar',
            },
            order: [[3, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'product_name'},
                {data: 'product_price'},
                {data: 'col_time'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#hometestimonial-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'home-testimoinal',
            },
            order: [[3, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'customer_name'},
                {data: 'customer_position'},
                {data: 'col_time'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#topcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'category?tab=top',
            },
            order: [[3, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'category'},
                {data: 'linktitle'},
                {data: 'title'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#secondcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'category?tab=second',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'category'},
                {data: 'parent'},
                {data: 'title'},
                {data: 'coltime', searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('change', '.secondcategory-search', function () {
            var column = $(this).data('column');
            $('#secondcategory-table').DataTable().column(column).search($(this).val()).draw();
        });

        $('#thirdcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'contentType': "application/json; charset=utf-8",
                'url': site_url + 'category?tab=third',
            },
            order: [[5, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'category'},
                {data: 'parent'},
                {data: 'secondparent', orderable: false},
                {data: 'title'},
                {data: 'coltime', searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('change', '.thirdcategory-search', function () {
            var column = $(this).data('column');
            if ($(this).data('isp')) {
                fetchCategory($(this).data('id'), $(this).data('level'), 's_');
            }
            $('#thirdcategory-table').DataTable().column(column).search($(this).val()).draw();
        });

        $('#fouthcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'category?tab=fourth',
            },
            order: [[6, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'category'},
                {data: 'parent'},
                {data: 'secondparent', orderable: false},
                {data: 'thirdparent', orderable: false},
                {data: 'title'},
                {data: 'coltime', searchable: false},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $(document).on('change', '.fourthcategory-search', function () {
            var column = $(this).data('column');
            if ($(this).data('isp')) {
                if ($(this).attr('name') == 's_top_parent') {
                    $('[name="s_second_level"]').html('<option value="">Second Level Category</option>');
                    $('[name="s_third_level"]').html('<option value="">Third Level Category</option>');
                    $('[name="s_fourth_level"]').html('<option value="">Fourth Level Category</option>');
                } else if ($(this).attr('name') == 's_second_level') {
                    $('[name="s_third_level"]').html('<option value="">Third Level Category</option>');
                    $('[name="s_fourth_level"]').html('<option value="">Fourth Level Category</option>');
                } else if ($(this).attr('name') == 's_third_level') {
                    $('[name="s_fourth_level"]').html('<option value="">Fourth Level Category</option>');
                }

                fetchCategory($(this).data('id'), $(this).data('level'), 's_');
            }
            $('#fouthcategory-table').DataTable().column(column).search($(this).val()).draw();
        });


        $('#faq-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': $('#faq-table').data('href'),
            },
            order: [[2, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'question'},
                {data: 'subsection_name'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#article-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'article',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'articlename'},
                {data: 'title'},
                {data: 'author'},
                {data: 'date_added'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#category-measonary-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'category-measonary',
            },
            order: [[6, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'parent'},
                {data: 'category_id'},
                {data: 'itemcode'},
                {data: 'title'},
                {data: 'groupname'},
                {data: 'date_added'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });
        $('#category-measonary-second-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'category-second-measonary',
            },
            order: [[4, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'parent'},
                {data: 'category_id'},
                {data: 'groupname'},
                {data: 'date_added'},
                {data: 'action', orderable: false, searchable: false}
            ]
        });

        $('#product-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                'url': site_url + 'products',
            },
            order: [[5, "desc"]],
            columns: [
                {data: 'id', searchable: false},
                {data: 'itemcode'},
                {data: 'title'},
                {data: 'category'},
                {data: 'groupname'},
                {data: 'itemtype'},
                {data: 'blog_date', orderable: false, visible: false},
                {data: 'action', orderable: false, searchable: false}
            ],
            columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div style='white-space:normal;max-width:200px;'>" + data + "</div>";
                    },
                    targets: 3
                }
            ]
        });

        $(document).on('click', '.categorymeasonary-search', function () {
            var parent_column = $('[name="s_top_parent"]').data('column');
            var column = $('[name="s_top_second"]').data('column');
            $('#category-measonary-table').DataTable().column(parent_column).search($('[name="s_top_parent"]').val());
            $('#category-measonary-table').DataTable().column(column).search($('[name="s_top_second"]').val()).draw();
        });
        $(document).on('click', '.categorymeasonary-second-search', function () {
            var parent_column = $('[name="s_top_parent"]').data('column');
            var column = $('[name="s_top_second"]').data('column');
            $('#category-measonary-second-table').DataTable().column(parent_column).search($('[name="s_top_parent"]').val());
            $('#category-measonary-second-table').DataTable().column(column).search($('[name="s_top_second"]').val()).draw();
        });

        $(document).on('click', '.product-list-search', function () {
            var top = $('[name="s_top_parent"]').val();
            var top_name = top != '' ? $('[name="s_top_parent"] :selected').text() : '';
            var second = $('[name="s_second_level"]').val();
            var third = $('[name="s_third_level"]').val();
            var fourth = $('[name="s_fourth_level"]').val();
            var blog = '^$';
            if ($('[name="s_blog"]').is(":checked")) {
                blog = '^1$';
            }
            var dvalue = '';
            if (fourth != "") {
                dvalue = fourth;

            }
            if (third != "") {
                if (dvalue == "") {
                    dvalue = third;
                } else {
                    dvalue += ',' + third;
                }
            }
            if (second != "") {
                if (dvalue == "") {
                    dvalue = second;
                } else {
                    dvalue += ',' + second;
                }
            }

            $('#product-table').DataTable().column(3).search(dvalue).column(4).search(top_name.toLowerCase()).column(6).search(blog, true, false).draw();
        });
    }

    $(document).on('change', '#measonary_top_select', function () {
        $('.categorymeanson-section').addClass('d-none');
        var option_value = $('#measonary_top_select option:selected').attr('data-linktitle');
        $('[name="groupname"]').val(option_value);
    });

    $(document).on('change', '.cmeasonary[name="category_id"]', function () {
        var option_value = $('option:selected', this).attr('value');
        var option_parent_value = $('#measonary_top_select').val();
        $('[name="parent"]').val(option_parent_value);
        $('#categorymeanson').val('');
        if (option_value == '') {
            $('.categorymeanson-section').addClass('d-none');
        } else {
            $('.categorymeanson-section').removeClass('d-none');
        }
    });

    if ($("#autoproduct").length > 0) {
        $("#autoproduct").autocomplete({
            minLength: 2,
            source: function (request, response) {
                // Fetch data
                $('.snippet_description').addClass('d-none');
                $('#render_snippet_description').val(1);
                $.ajax({
                    url: site_url + 'blog/searchproduct',
                    type: 'post',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                // Set selection
                $('#autoproduct').val(ui.item.label); // display the selected text
                $('#render_itemcode').val(ui.item.value); // save selected id to input
                if (ui.item.hasSnippest == 0) {
                    $('.snippet_description').removeClass('d-none');
                    $('#render_snippet_description').val(0);
                }
                return false;
            }
        });
    }

    if ($("#categorymeanson").length > 0) {
        $("#categorymeanson").select2({
            multiple: true,
            minimumInputLength: 3,
            ajax: {
                url: site_url + 'category-measonary/searchproduct',
                dataType: 'json',
                delay: 250,
                params: {
                    contentType: "application/json"
                },
                data: function (params) {
                    return {
                        q: params.term, // search term
                        category: $('[name="category_id"]').val(),
                        parent: $('[name="parent"]').val(),
                        groupname: $('[name="groupname"]').val(),
                    };
                },
                processResults: function (response) {
                    console.log(response);
                    return {
                        results: response
                    };
                },
                cache: true
            },
        });
    }


    $(document).on('keypress blur', '#configurename', function () {
        var str = $(this).val();
        var relplcs = str.replace(/ /g, '_');
        $('#configurename').val(relplcs);
    });

    $(document).on('keypress blur', '#writearticlename', function () {
        var str = $(this).val();
        var relplcs = str.replace(/ /g, '-');
        $('#writearticlename').val(relplcs);
    });
    $(document).on('blur', '#writearticlename', function () {
        var str = $(this).val();
        var count = (str.match(/.htm/gi) || []).length;
        if (count > 0) {
            var str = str.replace(/.htm/gi, "");
        }
        if (!str.lastIndexOf('.htm') !== -1) {
            var str = str = str + '.htm';
        }
        $('#writearticlename').val(str);
    });

    $(document).on('click', '.buttonpressed', function () {
        if ($(this).closest('form').attr('id') == 'add_role') {
            $('[name="wanttorequest"]').val($(this).val());
            $('#add_role').trigger('submit');
        }
    });

    $(document).on('submit', '#add_role', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#add_role').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('submit', '#storecategory', function (event) {
        event.preventDefault();
        var pointer = $(this);
        pointer.find('[type="submit"]').attr('disabled', 'disabled');
        $('.help-block').html('');
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
                        success_msg(resp.message);
                    }
                    $('#showCategoryPopup .modal-content').html('');
                    $('#showCategoryPopup').modal('hide');
                    if (resp.redirectUrl) {
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }
                } else if (resp.status === 400) {
                    if (resp.message) {
                        error_msg(resp.message);
                    }
                    $('#showCategoryPopup').modal('hide');
                } else {
                    $.each(resp.message, function (key, val) {
                        $('#storecategory').find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                pointer.find('[type="submit"]').removeAttr('disabled');
            }
        }).fail(function () {
            pointer.find('[type="submit"]').removeAttr('disabled');
        });
    });


    $(document).on('click', '.categorypopupshow', function () {
        $('.modal').modal('hide');
        $('#showCategoryPopup .modal-content').html('');
        ajaxindicatorstart();
        var href = $(this).data('href');
        $.ajax({
            url: href,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function (resp) {
                if (resp.status === 200) {
                    $('#showCategoryPopup .modal-content').html(resp.content);
                    $('#showCategoryPopup').modal('show');
                } else {
                    if (resp.message) {
                        error_msg(resp.message);
                    }
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });


    $(document).on('change', 'select.makecattog', function () {
        var toggleId = $(this).data('id');
        if ($(this).data('isp') && $('#' + toggleId).length > 0) {
            if ($(this).data('column')) {
                fetchCategory(toggleId, $(this).data('level'), 's_');
            } else {
                fetchCategory(toggleId, $(this).data('level'), '');
            }
        }
    });

    if ($('#smeernoteeditor').length > 0) {
        $('#smeernoteeditor').summernote({
            height: 300,
            callbacks: {
                onImageUpload: function (files) {
                    // upload image to server and create imgNode...
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            sendFile(file);
                        });
                    }
                },
                onMediaDelete: function (files) {
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            deleteFile(files[0].dataset.filename);
                        });
                    }
                }
            }
        });
    }


    ////////////////////////Product
    $(document).on('change', '.triggertoitemtype', function () {
        if ($(this).val() == 'book') {
            $('[name="product[itemtype]"]').val('book');
            $('.section-book-fieled').removeClass('d-none');
            $('.section-product-fieled').addClass('d-none');
            $('[name="product_field_for"]').val('book');
        } else {
            $('[name="product[itemtype]"]').val('product');
            $('.section-book-fieled').addClass('d-none');
            $('.section-product-fieled').removeClass('d-none');
            $('[name="product_field_for"]').val('product');
        }
    });
    $(document).on('change', 'select[name="product[itemtype]"]', function () {
        if ($(this).val() == 'book') {
            $('.section-book-fieled').removeClass('d-none');
            $('.section-product-fieled').addClass('d-none');
            $('[name="product_field_for"]').val('book');
        } else {
            $('.section-book-fieled').addClass('d-none');
            $('.section-product-fieled').removeClass('d-none');
            $('[name="product_field_for"]').val('product');
        }
    });
    $(document).on('change', '.folderchoosedir', function () {
        if ($(this).val() == 'newfolder') {
            $('.newfolder-section').removeClass('d-none');
        } else {
            $('.newfolder-section').addClass('d-none');
        }
    });
    $(document).on('click', 'button.backbtn', function () {
        var currentstep = $(this).data('step');
        if (!$(this).hasClass('update-product-tab')) {
            $('.tab-navlink').removeClass('active').addClass('disabled');
            $('.tab-pane').removeClass('show active');
        }
        if (currentstep == 2) {
            $('#home').removeClass('disabled').addClass('active');
            $('#home-tab').addClass('show active');
        } else if (currentstep == 3) {
            $('#product-field-tab').addClass('show active');
            $('#product-field').removeClass('disabled').addClass('active');
        } else if (currentstep == 4) {
            $('#product-extra-tab').addClass('show active');
            $('#product-extra').removeClass('disabled').addClass('active');
        } else if (currentstep == 5) {
            $('#product-stock-tab').addClass('show active');
            $('#product-stock').removeClass('disabled').addClass('active');
        }
    });

    $(".nav-item a[data-toggle=tab]").on("click", function (e) {
        e.preventDefault();
        var pointtab = $(this).attr('href');
        if ($(this).hasClass('update-product-tab')) {
            $('.tab-navlink').removeClass('active');
            $('.tab-pane').removeClass('show active');
            $(pointtab).addClass('show active');
            $(this).removeClass('disabled').addClass('active');
        } else {
            return false;
        }
    });



    $(document).on('click', '.third-cat-checkbox', function () {
        if ($(this).prop('checked') === true) {
            $(this).closest('ul').parent('li').find('.second-cat-checkbox').prop('checked', true);
        } else {
            if ($(this).parent('li').find('.fourth-cat-checkbox').length > 0) {
                $(this).parent('li').find('.fourth-cat-checkbox').prop('checked', false);
            }
        }
    });

    $(document).on('click', '.second-cat-checkbox', function () {
        if ($(this).prop('checked') === false) {
            if ($(this).parent('li').find('.third-cat-checkbox').length > 0) {
                $(this).parent('li').find('.third-cat-checkbox').prop('checked', false);
            }
            if ($(this).parent('li').find('.fourth-cat-checkbox').length > 0) {
                $(this).parent('li').find('.fourth-cat-checkbox').prop('checked', false);
            }
        }
    });

    $(document).on('click', '.fourth-cat-checkbox', function () {
        if ($(this).prop('checked') === true) {
            $(this).closest('ul').parent('li').find('.third-cat-checkbox').prop('checked', true);
            $(this).closest('ul').parent('li').find('.third-cat-checkbox').closest('ul').parent('li').find('.second-cat-checkbox').prop('checked', true);
        }
    });

    if ($('#tree1').length > 0) {
        $('#tree1').treed();
    }

    if ($('#Snippet_summernote').length > 0) {
        $('#Snippet_summernote').summernote({
            height: 150,
            callbacks: {
                onImageUpload: function (files) {
                    // upload image to server and create imgNode...
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            sendFileForProduct(file, $('#Snippet_summernote'));
                        });
                    }
                },
                onMediaDelete: function (files) {
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            deleteProductFile(files[0].dataset.filename);
                        });
                    }
                }
            }
        });
        $('#Long_summernote').summernote({
            height: 150,
            callbacks: {
                onImageUpload: function (files) {
                    // upload image to server and create imgNode...
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            sendFileForProduct(file, $('#Long_summernote'));
                        });
                    }
                },
                onMediaDelete: function (files) {
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            deleteProductFile(files[0].dataset.filename);
                        });
                    }
                }
            }
        });
        $('#Long_india_summernote').summernote({
            height: 150,
            callbacks: {
                onImageUpload: function (files) {
                    // upload image to server and create imgNode...
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            sendFileForProduct(file, $('#Long_india_summernote'));
                        });
                    }
                },
                onMediaDelete: function (files) {
                    if (files.length > 0) {
                        $.each(files, function (key, file) {
                            deleteProductFile(files[0].dataset.filename);
                        });
                    }
                }
            }
        });
    }

    $(document).on('click', 'button.productsavebtn', function (event) {
        event.preventDefault();
        ajaxindicatorstart();
        $('[name="wanttorequest"]').val($(this).val());
        var pointer = $('#stepform' + $(this).data('step'));
        $('.help-block').html('');
        var url = pointer.attr('action');
        var data = new FormData(pointer[0]);
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
                        success_msg(resp.message);
                    }
                    if (resp.form_step) {
                        stepForward(resp.form_step);
                    }
                    if (resp.redirectUrl) {
                        window.scroll(0, 100);
                        setTimeout(function () {
                            window.location.href = resp.redirectUrl;
                        }, 2000);
                    }

                } else {
                    $.each(resp.message, function (key, val) {
                        pointer.find('[name="' + key + '"]').closest('.form-group').find('.help-block').html(val);
                    });
                }
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $('input[name="product[usblock]"]').on('change', function () {
        $('input[name="product[usblock]"]').not(this).prop('checked', false);
    });
    $('input[name="product[indiablock]"]').on('change', function () {
        $('input[name="product[indiablock]"]').not(this).prop('checked', false);
    });


    $(document).on('click', '.add-more', function () {
        var object = $('#append-more').html();
        var totalvariation = $('#render-partial-row .variation_row').length;
//        $(object).find('.colorclassname').attr('name', 'product_variation[color][' + totalvariation + ']');
//        $(object).find('.sizeclassname').attr('name', 'product_variation[size][' + totalvariation + ']');
        $('#render-partial-row .bodypartof').removeClass('show');
        $('#render-partial-row').append(object);
        if (totalvariation == 0) {
            $('#render-partial-row .variation_row:eq(0)').find('hr').remove();
        }
        var latestVariation = $('#render-partial-row .variation_row:eq(' + totalvariation + ')');

        latestVariation.find('input').each(function (k, element) {
            var elename = $(element).attr('name') + '[' + totalvariation + ']';
            $(element).attr('name', elename);
        });

        ////card Part
        latestVariation.find('.card-header').attr('id', 'variation_heading_' + totalvariation);
        latestVariation.find('.vartiation_accordian_button').html('Variation ' + (Number(totalvariation) + 1));
        latestVariation.find('.vartiation_accordian_button').attr('data-target', '#variation_collapse_' + totalvariation);
        latestVariation.find('.vartiation_accordian_button').attr('aria-controls', 'variation_collapse_' + totalvariation);
        latestVariation.find('.bodypartof').attr('id', 'variation_collapse_' + totalvariation);
        latestVariation.find('.bodypartof').attr('aria-labelledby', 'variation_heading_' + totalvariation);



//        $('#render-partial-row .variation_row:eq(' + totalvariation + ')').find('input').attr('name', 'product_variation[color][' + totalvariation + ']');
//        $('#render-partial-row .variation_row:eq(' + totalvariation + ')').find('.colorclassname').attr('name', 'product_variation[color][' + totalvariation + ']');
//        $('#render-partial-row .variation_row:eq(' + totalvariation + ')').find('.sizeclassname').attr('name', 'product_variation[size][' + totalvariation + ']');
    });

    $(document).on('click', '.remove-addmore', function () {
        $(this).closest('.variation_row').remove();
    });

    $(document).on('click', '.product-solr-update', function () {
        ajaxindicatorstart();
        var url = '/admin_solr_adddoc_all.php';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('click', '.home-banner-update', function () {
        ajaxindicatorstart();
        var url = '/admin_cache_homepage.php?action=homebanners';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('click', '.home-blog-update', function () {
        ajaxindicatorstart();
        var url = '/admin_cache_homepage.php?action=homeblogs';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('click', '.category-update', function () {
        ajaxindicatorstart();
        var url = '/admin_cache_categorylist.php';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                var url = '/admin_cache_createmenu_all.php';
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'text',
                    success: function (resp) {

                        ajaxindicatorstop();
                    }
                }).fail(function () {
                    ajaxindicatorstop();
                });
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('click', '.languages-update', function () {
        ajaxindicatorstart();
        var url = '/admin_cache_languages.php';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });

    $(document).on('click', '.configuration-update', function () {
        ajaxindicatorstart();
        var url = '/admin_cache_configuration.php';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'text',
            success: function (resp) {
                ajaxindicatorstop();
            }
        }).fail(function () {
            ajaxindicatorstop();
        });
    });
});

function stepForward(form_step) {
    if (form_step == 2) {
        $('.tab-navlink').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('#product-field').removeClass('disabled').addClass('active');
        $('#product-field-tab').addClass('show active');
    } else if (form_step == 3) {
        $('.tab-navlink').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('#product-extra').removeClass('disabled').addClass('active');
        $('#product-extra-tab').addClass('show active');
    } else if (form_step == 4) {
        $('.tab-navlink').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('#product-stock').removeClass('disabled').addClass('active');
        $('#product-stock-tab').addClass('show active');
    } else if (form_step == 5) {
        $('.tab-navlink').removeClass('active');
        $('.tab-pane').removeClass('show active');
        $('#product-variation').removeClass('disabled').addClass('active');
        $('#product-variation-tab').addClass('show active');
    }
    window.scroll(0, 100);
}


function sendFileForProduct(file, pointer) {
    var data = new FormData();
    data.append("file", file);
    $.ajax({
        url: site_url + 'product/imageupload',
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {
            if (resp.status === 200) {
                pointer.summernote("insertImage", resp.url, resp.fname);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + " " + errorThrown);
        }
    });
}
function sendFile(file) {
    var data = new FormData();
    data.append("file", file);
    $.ajax({
        url: site_url + 'article/imageupload',
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {
            if (resp.status === 200) {
                $('#smeernoteeditor').summernote("insertImage", resp.url, resp.fname);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus + " " + errorThrown);
        }
    });
}
function deleteProductFile(filename) {
    var data = new FormData();
    data.append("filename", filename);
    data.append("filedelete", '1');
    $.ajax({
        url: site_url + 'product/imageupload',
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {

        },
    });
}

function deleteAlternativeFile(obj) {
    var data = new FormData();
    data.append("filename", $(obj).data('name'));
    data.append("filedelete", '1');
    data.append("type", $(obj).data('type'));
    if ($(obj).data('pid')) {
        data.append("itemcode", $(obj).data('pid'));
    }
    $.ajax({
        url: site_url + 'product/deletealternative',
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {
            if ($(obj).data('pid')) {
                $(obj).closest('.main-thumb-btn-conainer').find('.main-thumb').find('img').attr('src', 'https://bulma.io/images/placeholders/256x256.png');
//                $(obj).closest('.main-thumb-btn-conainer').remove();
            } else {
                $(obj).closest('.alternative-thumb').remove();
                if ($('.alternative-thumb').length === 0) {
                    $('.section-alternative').remove();
                }
            }
        },
    });
}

function deleteFile(filename) {
    data = new FormData();
    data.append("filename", filename);
    data.append("filedelete", '1');
    $.ajax({
        url: site_url + 'article/imageupload',
        data: data,
        dataType: 'json',
        cache: false,
        contentType: false,
        processData: false,
        type: 'POST',
        success: function (resp) {

        },
    });
}



function fetchCategory(placeid, level, s) {
    if (s != "") {
        var top = $('[name="s_top_parent"]').val();
        var second = $('[name="s_second_level"]').val();
        var third = $('[name="s_third_level"]').val();
    } else {
        var top = $('[name="top_parent"]').val();
        var second = $('[name="second_level"]').val();
        var third = $('[name="third_level"]').val();
    }
    $.ajax({
        url: site_url + 'category/fetchcategory',
        type: 'GET',
        dataType: 'json',
        data: {top: top, second: second, third: third, level: level},
        success: function (resp) {
            $('#' + placeid).html(resp);
        }
    });
}
function deleteAvailability(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function deleteClienttele(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function deleteTips(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function deleteBlog(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function cancelOrder(obj) {
    
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Cancel Order ',
        content: 'Are you sure to cancel this order ?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function deleteStoryscript(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}

function formatAffiliateOrderTbl(d) {
//    console.log(d.details);
    var content = `<h4>User Details</h4>
<div class="row mt-2">`;
    if (d.details !== null) {
        Object.keys(d.details).map((key) => {
            if (key != 'earnings') {
                content += `<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 d-flex justify-content-between mb-2">
    <div class="field" style="font-weight: 700;">${key.toUpperCase()}</div>
    <div class="field">${d.details[key] ? d.details[key] : 'N/A'}</div>
  </div>`;
            }
        });
    } else {
        content += `
        <p class="text-center col-sm-12">Details Not Found</p>`;
    }
    content += `</div>
        <h4 class="mt-3">Earnings <a href="${site_url}affiliate/earning/${d.id}" target="_blank" class="btn btn-info">Details</a></h4><div class="row mt-2">`;
    if (d.details['earnings'] && d.details['earnings'] !== null && d.details['earnings'].length > 0) {
        Object.keys(d.details['earnings']).map((key) => {
            content += `<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 d-flex justify-content-between mb-2">
    <div class="field" style="font-weight: 700;">${key.toUpperCase()}</div>
    <div class="field">${d.details['earnings'][key] + ' ' + key.toUpperCase()}</div>
  </div>`;

        });
    } else {
        content += `
        <p class="text-center col-sm-12">No Earning found.</p>
    `;
    }
    content += `</div>`;

    return content;
}

function formatOrderTbl(d) {
    var content = `<table class="table table-striped child-content-table" >
<thead>
    <tr>
        <th>Item</th>
        <th>Quantity</th>
        <th>Extra</th>
    </tr>
</thead>
<tbody>`;
    if (d.details !== null && d.details.length > 0) {
        d.details.map((row) => {
            content += `<tr>
        <td>${row.item}</td>
        <td>${row.qty}</td>
        <td>${row.extra}</td>
    </tr>`;
        });
    } else {
        content += `<tr >
        <td colspan="3" class="text-center">Details Not Found</td>
    </tr>`;
    }


    content += `</tbody>
</table>`;

    return content;
}


function printOrder() {
    if ($('.print-checkbox:checked').length === 0) {
        return false;
    }
    $('#mobile-collapse').trigger('click');
    var selected_columns = [];
    var hide_columns = [];
    $('.print-checkbox').each(function (k, v) {
        if ($(v).is(":checked")) {
            if ($(v).val() == 'details_th') {
                $('#order-table td.details-control').hide();
                $('#order-table td.details-control').trigger('click');
                selected_columns.push($(v).val());
            }
        } else {
            $('.' + $(v).val()).hide();
            hide_columns.push($(v).val());
        }
    });
    $('#order-table').printThis({
        afterPrint: function () {
            $('#mobile-collapse').trigger('click');
            if (selected_columns.length > 0) {
                if ($.inArray('details_th', selected_columns) !== -1) {
                    $('#order-table td.details-control').show();
                    $('#order-table td.details-control').trigger('click');
                }
            }
            if (hide_columns.length > 0) {
                $('.' + hide_columns.join(',.')).show();
                if ($.inArray('details_th', hide_columns) !== -1) {
                    $('#order-table td.details-control').show();
                }
            }

        }
    });


}


function checkItemCodeExist(obj) {
    $('.help-block').html('');
    if ($(obj).val() == '') {
        return false;
    }
    $.ajax({
        url: site_url + 'product/checkitemcode',
        data: {itemcode: $(obj).val()},
        dataType: 'json',
        cache: false,
        type: 'POST',
        success: function (resp) {
            if (resp.status === 200) {
                success_msg(resp.message);
            } else {
                $(obj).closest('.form-group').find('.help-block').html(resp.message);
            }
        }
    });
}
function deleteRole(obj) {
    var name = $(obj).data('name');
    var tb = $(obj).data('tb');
    var url = $(obj).data('href');
    $.confirm({
        title: 'Delete ' + name,
        content: 'Are you sure to delete this ' + name + '?',
        type: 'red',
        typeAnimated: true,
        buttons: {
            confirm: {
                text: '<i class="fa fa-check" aria-hidden="true"></i> Confirm',
                btnClass: 'btn-red',
                action: function () {
                    ajaxindicatorstart();
                    $.ajax({
                        url: url,
                        type: 'POST',
                        dataType: 'json',
                        success: function (resp) {
                            if (resp.status && resp.status === 200) {
                                success_msg(resp.message);
                                $('#' + tb + '-table').DataTable().ajax.reload();
                            } else {
                                error_msg(resp.message);
                            }
                            ajaxindicatorstop();
                        }
                    }).fail(function () {
                        ajaxindicatorstop();
                    });
                }
            },
            cancel: {
                btnClass: 'btn btn-primary',
            }
        }
    });
}