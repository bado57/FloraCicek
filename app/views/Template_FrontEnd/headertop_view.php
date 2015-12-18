<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="kayseri çiçek siparişi, çiçek gönderme hizmetleri, kayseri çiçek hizmeti" />
        <meta name="keywords" content="kayseri çiçek, kayseri çiçek siparişi, kaliteli çiçek siparişi, çiçek gönderme hizmeti" />
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
                    <script src="<?php echo SITE_JS ?>/jquery.fittext.js"></script>
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
                        <!-- Order Details -->
                    <div class="modal fade" id="spDetayModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-shopping-cart"></i> Sipariş Bilgileri</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <!-- Sipariş Durumu -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="spHeadingDurum">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spDtyDurum" aria-expanded="true" aria-controls="spDtyDurum">
                                                        Son Durum
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="spDtyDurum" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="spHeadingDurum">
                                                <div class="panel-body">
                                                    <p id="sipDurum"></p>
                                                    <!-- Admin notu varsa -->
                                                    <p id="sipAdminNot"></p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Sipariş Durumu -->
                                        <!-- Sipariş Özeti -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="spHeadingOzet">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spDtyOzet" aria-expanded="false" aria-controls="spDtyDurum">
                                                        Sipariş Özeti
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="spDtyOzet" class="panel-collapse collapse" role="tabpanel" aria-labelledby="spHeadingOzet">
                                                <div class="panel-body">
                                                    <table id="siparisbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                        <tr>
                                                            <td><b>Sipariş No</b></td>
                                                            <td class="sipno"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Sipariş Tarihi</b></td>
                                                            <td class="siptarih"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gönderen</b></td>
                                                            <td class="gndad"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Alan</b></td>
                                                            <td class="aliciad"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Toplam Tutar</b></td>
                                                            <td><b><span class="siptutar"></span> TL</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Ödeme</b></td>
                                                            <td class="sipOdeme"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Sipariş Özeti -->
                                        <!-- Sipariş Ürünler -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="spHeadingUrun">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spDtyUrun" aria-expanded="false" aria-controls="spDtyDurum">
                                                        Ürünler
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="spDtyUrun" class="panel-collapse collapse" role="tabpanel" aria-labelledby="spHeadingUrun">
                                                <div class="panel-body">
                                                    <table id="urunbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    <b>Ürün Kodu / Adı</b>
                                                                </th>
                                                                <th>
                                                                    <b>Birim Fiyatı</b>
                                                                </th>
                                                                <th>
                                                                    <b>Miktar</b>
                                                                </th>
                                                                <th>
                                                                    <b>Tutar</b>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="urunSip">
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="4" class="text-right"><b>Toplam : <span class="uruntoplamtutar"></span> TL</b></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Sipariş Ürünler -->
                                        <!-- Sipariş Gönderen Bilgileri -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="spHeadingGonderen">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spDtyGonderen" aria-expanded="false" aria-controls="spDtyDurum">
                                                        Gönderici Bilgileri
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="spDtyGonderen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="spHeadingGonderen">
                                                <div class="panel-body">
                                                    <table id="müsteribilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                        <tr>
                                                            <td><b>Ad Soyad</b></td>
                                                            <td class="gndad"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Telefon</b></td>
                                                            <td class="gndtel"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Email</b></td>
                                                            <td class="gndmail"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Üyelik Durumu</b></td>
                                                            <td><span class="gndtip"></span></td>
                                                        </tr>
                                                    </table>
                                                    <!-- Varsa Fatura bilgileri -->
                                                    <h4>Fatura Bilgileri</h4>
                                                    <table id="faturabilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                        <tr>
                                                            <td><b>Ünvan</b></td>
                                                            <td class="ftrunvn"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>TC No</b></td>
                                                            <td class="ftrtc"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Vergi D.</b></td>
                                                            <td class="ftrvdaire"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Vergi No</b></td>
                                                            <td class="ftrvno"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Adres</b></td>
                                                            <td class="ftradres"></td>
                                                        </tr>
                                                    </table>
                                                    <!-- End Varsa Fatura bilgileri -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Sipariş Gönderen Bilgileri -->
                                        <!-- Sipariş Teslimat Bilgileri -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab" id="spHeadingTeslimat">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#spDtyTeslimat" aria-expanded="false" aria-controls="spDtyDurum">
                                                        Teslimat Bilgileri
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="spDtyTeslimat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="spHeadingTeslimat">
                                                <div class="panel-body">
                                                    <table id="teslimatbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                        <tr>
                                                            <td><b>Alıcı</b></td>
                                                            <td class="aliciad"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Telefon</b></td>
                                                            <td class="alicitel"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Teslimat Tarihi</b></td>
                                                            <td><span class="tslmttarih"></span> (<span class="tslmsaat"></span>)</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gideceği Yer</b></td>
                                                            <td class="tslimtyer"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Adres</b></td>
                                                            <td class="tslimtadres"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Adres Tarifi</b></td>
                                                            <td class="tslmtadrestrf"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Sipariş Notu</b></td>
                                                            <td class="tslmtnot"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kart Mesajı</b></td>
                                                            <td class="tslmtkartmsj"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Kart İsim</b></td>
                                                            <td class="tslmtkartisim"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>İsim Göster</b></td>
                                                            <td class="tslmtisimgrnme"></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Gönderim Nedeni</b></td>
                                                            <td class="tslmtgndndn"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Sipariş Teslimat Bilgileri -->
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <header id="header">
                        <!-- Mobil Menü -->
                        <div id="headermobile" class="hidden-md hidden-lg">
                            <nav class="navbar navbar-header navbar-collapse-mobile">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <a class="navbar-brand padding-right" style="max-width:60% !important;" href="<?php echo SITE_URL ?>"><img src="<?php echo SITE_VITRIN . '/' . $model[8]["logo"]; ?>" style="max-width:100% !important;" alt="Türkiye Flora Çiçek Logo" /></a>
                                        <button id="mCollapse" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbarMobile" style="margin-top:20px;">
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                            <span class="icon-bar"></span>
                                        </button>
                                        <a id="orderLink" href="<?php echo SITE_URL; ?>" class="navbar-toggle"  style="margin-top:20px; padding: 7px 12px; background-color: #e6e6e6; display: none;"><i class="fa fa-home"></i></a>
                                    </div>
                                    <div class="collapse navbar-collapse" id="navbarMobile" style="position: relative; max-height: 800px !important;">
                                        <ul class="nav navbar-nav">
                                            <li><li class="active"><a href="<?php echo SITE_URL; ?>">ANASAYFA</a></li></li>
                                            <li class="dropdown">
                                                <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> <?php echo $data["AmacaGore"] ?></a>
                                                <ul role="menu" class="dropdown-menu">
                                                    <?php foreach ($model[0] as $etiketModel) { ?>
                                                        <li><a href="<?php echo $etiketModel['etiketUrl']; ?>"><?php echo $etiketModel['etiketAd']; ?></a></li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                                <li class="dropdown">
                                                    <a class="dropdown-toggle" data-toggle="dropdown" href=""><span class="caret"></span> <?php echo $model[1][$ustkat]['Adi']; ?></a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <?php for ($altkat = 0; $altkat < count($model[2][$ustkat]); $altkat++) { ?>
                                                            <?php if ($model[2][$ustkat][$altkat]['ID'] != '') { ?>
                                                                <li><a href="<?php echo $model[2][$ustkat][$altkat]['Url']; ?>"><?php echo $model[2][$ustkat][$altkat]['Adi']; ?></a></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <?php if (count($model[3]) > 0) { ?>
                                                <li class="dropdown">
                                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span> <?php echo $data["Kampanya"] ?></a>
                                                    <ul role="menu" class="dropdown-menu">
                                                        <?php foreach ($model[3] as $etiketModel) { ?>
                                                            <li><a href="<?php echo $etiketModel['Url']; ?>"><?php echo $etiketModel['Adi']; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                </li>
                                            <?php } ?>
                                            <li><a href="blog"><?php echo $data["Blog"] ?></a></li>
                                            <li><a href="<?php echo SITE_URL . "/sayfa-hakkimizda" ?>" id="sesso" data-url="StaticPager" data-method="index"><?php echo $data["Kurumsal"]; ?></a></li>
                                            <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>"><?php echo $data["Iletisim"]; ?></a></li>
                                            <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>" style="font-size:26px; color:#b51e91;"><i class="fa fa-phone"></i> <?php echo $model[8]["telefon"]; ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                            <div class="col-xs-12 col-sm-12 mobile_login_menu">
                                <div class="col-xs-12">
                                    <div class="row">
                                        <div class="btn-group text-center" role="group" style="width:100%;">
                                            <a href="<?php echo SITE_URL ?>/Home/bireysel" role="button" class="btn btn-default col-xs-6"><span class="glyphicon glyphicon-user"></span> Üye Ol</a>
                                            <a href="<?php echo SITE_URL ?>/Home/login" role="login" class="btn btn-default col-xs-6"><span class="glyphicon glyphicon-log-in"></span> Giriş Yap</a>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="input-group col-xs-12">
                                    <input type="text" class="form-control" placeholder="<?php echo $data["SiparisTakip"]; ?>">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" data-toggle="modal" data-target="#spDetayModal" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <!-- End Mobil Menü -->
                        <!-- Browser Menü -->                          
                        <div class="header_top hidden-xs hidden-sm">
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
                        </div>

