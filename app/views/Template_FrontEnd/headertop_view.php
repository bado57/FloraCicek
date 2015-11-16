<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Türkiye Flora Çiçek</title>
    <link rel="shortcut icon" href="<?php echo SITE_IMAGES ?>/favicon.png">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <link href='https://fonts.googleapis.com/css?family=Oswald:400,300&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
                <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

                    <link href="<?php echo SITE_CSS ?>/bootstrap.min.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/font-awesome.min.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/prettyPhoto.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/price-range.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/bootstrap-switch.css" rel="stylesheet" type="text/css"/>
                    <link href="<?php echo SITE_CSS ?>/responsive.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/jquery-ui.css" rel="stylesheet" type="text/css" />
                    <link href="<?php echo SITE_PLUGINS; ?>/select2/select2.min.css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS; ?>/alertify.css" type="text/css" rel="stylesheet" />
                    <link href="<?php echo SITE_CSS ?>/main.css" rel="stylesheet" />

                    <script src="<?php echo SITE_JS ?>/jquery.js"></script>
                    <script src="<?php echo SITE_JS ?>/urun_tab.js"></script>
                    <script src="<?php echo SITE_JS ?>/jquery-ui.js" type="text/javascript"></script>
                    <script src="<?php echo SITE_JS ?>/jquery.easing.min.js" type="text/javascript"></script>
                    <script src="<?php echo SITE_JS ?>/bootstrap.min.js"></script>
                    <script src="<?php echo SITE_JS ?>/jquery.lazyload.min.js"></script>
                    <script src="<?php echo SITE_JS ?>/jquery.resizecrop-1.0.3.min.js"></script>
                    <script src="<?php echo SITE_JS ?>/jquery.scrollUp.min.js"></script>
                    <script src="<?php echo SITE_JS ?>/jquery.prettyPhoto.js"></script>
                    <script src="<?php echo SITE_JS ?>/main.js"></script>

                    <script src="<?php echo SITE_JS ?>/alertify.js" type="text/javascript"></script>
                    <script src="<?php echo SITE_PLUGINS; ?>/select2/select2.full.min.js"></script>
                    <script src="<?php echo SITE_PLUGINS; ?>/input-mask/jquery.inputmask.js"></script>
                    <script src="<?php echo SITE_PLUGINS; ?>/input-mask/jquery.inputmask.numeric.extensions.js"></script>
                    <script src="<?php echo SITE_PLUGINS; ?>/input-mask/jquery.inputmask.phone.extensions.js"></script>
                    <script src="<?php echo SITE_PLUGINS; ?>/input-mask/jquery.inputmask.extensions.js"></script>
                    <script>
                        (function (i, s, o, g, r, a, m) {
                            i['GoogleAnalyticsObject'] = r;
                            i[r] = i[r] || function () {
                                (i[r].q = i[r].q || []).push(arguments)
                            }, i[r].l = 1 * new Date();
                            a = s.createElement(o),
                                    m = s.getElementsByTagName(o)[0];
                            a.async = 1;
                            a.src = g;
                            m.parentNode.insertBefore(a, m)
                        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

                        ga('create', 'UA-67056943-1', 'auto');
                        ga('send', 'pageview');

                    </script>
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
                    </head>
                    <body>
                        <header id="headermobile" class="hidden-md hidden-lg">
                            <nav class="navbar navbar-header navbar-inverse navbar-collapse-mobile">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <a class="navbar-brand padding-right" href="<?php echo SITE_URL ?>"><img src="<?php echo SITE_FRONT_IMAGES ?>/logo.png" style="max-width:60%;" alt="" /></a>
                                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarMobile" style="margin-top:20px;">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                    </div>
                                    <div class="collapse navbar-collapse" id="navbarMobile">
                                        <ul class="nav navbar-nav">
                                            <li><li class="active"><a href="#">ANASAYFA</a></li></li>
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> <?php echo $data["AmacaGore"] ?></a>
                                                <ul role="menu" class="dropdown-menu">
                                                    <?php foreach ($model[0] as $etiketModel) { ?>
                                                        <li><a href="<?php echo SITE_URL . '/' . $etiketModel['etiketUrl']; ?>" data-url="Kategori" data-method="index" data-kategori="1" data-id="<?php echo $etiketModel['etiketID']; ?>"><?php echo $etiketModel['etiketAd']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                                <li class="dropdown">
                                                    <a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span> <?php echo $model[1][$ustkat]['Adi']; ?></a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <?php for ($altkat = 0; $altkat < count($model[2]); $altkat++) { ?>
                                                            <li><a href="<?php echo SITE_URL . '/' . $model[2][$ustkat][$altkat]['Url']; ?>" data-url="Kategori" data-method="index" data-kategori="2" data-id="<?php echo $model[2][$ustkat][$altkat]['ID']; ?>"><?php echo $model[2][$ustkat][$altkat]['Adi']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($model[3]) > 0) { ?>
                                                <li class="dropdown">
                                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> <?php echo $data["Kampanya"] ?></a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <?php foreach ($model[3] as $etiketModel) { ?>
                                                            <li><a href="<?php echo SITE_URL . '/' . $etiketModel['Url']; ?>" data-url="Home" data-method="index" data-kategori="3" data-id="<?php echo $etiketModel['ID']; ?>"><?php echo $etiketModel['Adi']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <li><a href="#">BLOG</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <div class="col-xs-12 col-sm-12 mobile_login_menu">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <a class="mobile_top_button col-xs-6" href="#"><span class="glyphicon glyphicon-user"></span> Üye Ol</a>
                                        <a class="mobile_top_button col-xs-6" href="#"><span class="glyphicon glyphicon-log-in"></span> Giriş Yap</a>
                                    </div>
                                </div>
                                <div class="input-group col-xs-6 pull-right">
                                    <input type="text" class="form-control" placeholder="<?php echo $data["SiparisTakip"]; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                </div>
                            </div>
                        </header>
                        <header id="header" class="hidden-xs hidden-sm">
                            <!--header-->
                            <div class="header_top">
                                <!--header_top-->
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="contactinfo">
                                                <ul class="nav nav-pills">
                                                    <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>"><i class="fa fa-phone-square"></i> <b><?php echo $model[8]["telefon"]; ?></b></a></li>
                                                    <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>"><i class="fa fa-envelope"></i> <?php echo $model[8]["mail"]; ?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="social-icons pull-right">
                                                <ul class="nav navbar-nav">
                                                    <li><a href="<?php echo $model[8]["face"]; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="<?php echo $model[8]["twit"]; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                                    <li><a href="<?php echo $model[8]["gplus"]; ?>" title="Google+" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                                    <li><a href="<?php echo $model[8]["instag"]; ?>" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!--/header_top-->