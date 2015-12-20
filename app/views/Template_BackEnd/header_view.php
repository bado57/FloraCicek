<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Türkiye Flora Çiçek | Yönetici Paneli</title>
    <link rel="shortcut icon" href="<?php echo SITE_IMAGES ?>/favicon.png"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo SITE_CSS; ?>/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
                <!-- Ionicons -->
                <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
                    <!-- DataTables -->
                    <link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>/datatables/dataTables.bootstrap.css">
                        <!-- Theme style -->
                        <link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>/select2/select2.min.css">
                            <link rel="stylesheet" href="<?php echo SITE_DIST; ?>/css/AdminLTE.css">
                                <!-- AdminLTE Skins. Choose a skin from the css/skins
                                     folder instead of downloading all of them to reduce the load. -->
                                <link rel="stylesheet" href="<?php echo SITE_DIST; ?>/css/skins/_all-skins.min.css">
                                    <link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>/iCheck/all.css">
                                        <link rel="stylesheet" href="<?php echo SITE_CSS; ?>/alertify.css">
                                            <!-- Select2 -->

                                            <link rel="stylesheet" href="<?php echo SITE_PLUGINS; ?>/treegrid/jquery.treegrid.css">
                                                <script src="<?php echo SITE_PLUGINS; ?>/jQuery/jQuery-2.1.4.min.js"></script>
                                                <script src="<?php echo SITE_JS; ?>/bootstrap.min.js"></script>
                                                <script src="<?php echo SITE_JS ?>/jquery-ui.js" type="text/javascript"></script>
                                                <script src="<?php echo SITE_JS; ?>/alertify.js" type="text/javascript"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/select2/select2.full.min.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/datatables/jquery.dataTables.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/datatables/dataTables.bootstrap.min.js"></script>
                                                <script src="<?php echo SITE_JS; ?>/panel.js" type="text/javascript"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/slimScroll/jquery.slimscroll.min.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/fastclick/fastclick.min.js"></script>
                                                <script src="<?php echo SITE_DIST ?>/js/app.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/ckeditor/ckeditor.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/ckfinder/ckfinder.js"></script>
                                                <script src="<?php echo SITE_PLUGINS; ?>/iCheck/icheck.min.js"></script>
                                                <script type="text/javascript" src="<?php echo SITE_PLUGINS; ?>/treegrid/jquery.treegrid.js"></script>
                                                <script type="text/javascript" src="<?php echo SITE_PLUGINS; ?>/treegrid/jquery.treegrid.bootstrap3.js"></script>
                                                <script>
                                                    var SITE_URL = "http://localhost/floracicek";
                                                    function reset() {
                                                        alertify.set({
                                                            labels: {
                                                                ok: "Tamam",
                                                                cancel: "Kapat"
                                                            },
                                                            delay: 3000,
                                                            buttonReverse: false,
                                                            buttonFocus: "ok"
                                                        });
                                                    }
                                                </script>
                                                <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                                                <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
                                                <!--[if lt IE 9]>
                                                    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                                                    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                                                <![endif]-->
                                                </head>
                                                <body class="hold-transition skin-blue sidebar-mini">
                                                <div class="wrapper">
                                                    <!-- ÜST MENÜ -->
                                                    <header class="main-header">
                                                        <!-- Logo -->
                                                        <a href="<?php echo SITE_URL; ?>/Admin/Panel" class="logo">
                                                            <!-- mini logo for sidebar mini 50x50 pixels -->
                                                            <span class="logo-mini"><b>F</b></span>
                                                            <!-- logo for regular state and mobile devices -->
                                                            <span class="logo-lg"><b>Flora</b> Çiçek</span>
                                                        </a>
                                                        <!-- Header Navbar: style can be found in header.less -->
                                                        <nav class="navbar navbar-static-top" role="navigation">
                                                            <!-- Sidebar toggle button-->
                                                            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                                                                <span class="sr-only">Toggle navigation</span>
                                                            </a>
                                                            <div class="navbar-custom-menu">
                                                                <ul class="nav navbar-nav">
                                                                    <!-- Notifications: style can be found in dropdown.less -->
                                                                    <!-- Tasks: style can be found in dropdown.less -->
                                                                    <li class="dropdown user user-menu">
                                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                                                            <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                                                                            <i class="fa fa-cog"></i>
                                                                            <?php echo Session::get("KAdSoyad"); ?>
                                                                        </a>
                                                                        <ul class="dropdown-menu">
                                                                            <!-- User image -->
                                                                            <li class="user-header">
                                                                                <img src="<?php echo SITE_DIST; ?>/img/user.jpg" class="img-circle" alt="User Image">
                                                                                    <p>
                                                                                        <?php echo Session::get("KAdSoyad"); ?>
                                                                                        <small>Site Yöneticisi</small>
                                                                                    </p>
                                                                            </li>
                                                                            <!-- Menu Footer-->
                                                                            <li class="user-footer">
                                                                                <div class="pull-left">
                                                                                    <a href="#" class="btn btn-default btn-flat">Hesap Ayarları</a>
                                                                                </div>
                                                                                <div class="pull-right">
                                                                                    <a id="panelCikisYap" class="btn btn-default btn-flat">Çıkış</a>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </nav>
                                                    </header><!-- /ÜST MENÜ -->