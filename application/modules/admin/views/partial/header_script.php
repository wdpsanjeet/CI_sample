<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Brandket</title>
        <!-- Site title -->
  <link rel="icon" href="<?php echo base_url().'themes/frontend/images/'?>favicon.ico" type="image/gif">
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#">
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="#">
        <!-- Favicon icon -->
        <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/bower_components/bootstrap/css/bootstrap.min.css">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/icon/icofont/css/icofont.css">
        <!-- Menu-Search css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/pages/menu-search/css/component.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/notie/dist/notie.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/js/datatable/dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/jquery-confirm.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/js/lobibox/lobibox.css">
         <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>themes/backend/assets/css/style.css">
        <?php
        $ci_class = $this->router->fetch_class();
        if ($ci_class == 'cms' || $ci_class == 'blogs'):
            ?>
            <link href="<?php echo base_url() ?>themes/backend/assets/wysiwyg-editor-summernote/dist/summernote-bs4.css" rel="stylesheet" type="text/css">
        <?php elseif($ci_class == 'order'): ?>
             <link href="<?php echo base_url() ?>themes/backend/assets/js/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css">
        <?php endif; ?>
        <script>
            var site_url = '<?php echo base_url(); ?>';
        </script>
    </head>
    <body>
        <?php $this->load->view('partial/left_menu'); ?>