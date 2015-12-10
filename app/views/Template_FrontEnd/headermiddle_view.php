<div class="header-middle hidden-xs hidden-sm">
    <!--header-middle-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="logo pull-left" style="text-align:center;">
                    <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_VITRIN . '/' . $model[8]["logo"]; ?>" alt="" /></a>
                </div>
            </div>
            <?php if (Session::get("KRol") == 2 || Session::get("KRol") == 1) { ?>
                <div class="kurumsalol col-sm-2" style="visibility: hidden;"></div>
            <?php } else { ?>
                <a href="<?php echo SITE_URL ?>/Home/kurumsal" data-form="3" class="kurumsalol col-sm-2 padding-right" style="margin-top:7px;">
                </a>
            <?php } ?>
            <div class="col-sm-6">
                <div class="shop-menu pull-right">
                    <ul class="nav navbar-nav">
                        <?php if (Session::get("KID") > 0) { ?>
                            <li><a><i class="fa fa-user"></i><?php echo $data["Hosgeldiniz"]; ?> <?php echo Session::get("KAdSoyad"); ?></a></li>
                            <li><a id="cikisYap"><i class="fa fa-sign-out"></i>Çıkış Yap</a></li>
                        <?php } else { ?>
                            <li><a href="<?php echo SITE_URL ?>/Home/login"><i class="fa fa-sign-in"></i> <?php echo $data["GirisYap"]; ?></a></li>
                            <li><a href="<?php echo SITE_URL ?>/Home/bireysel"><i class="fa fa-user"></i> <?php echo $data["UyeOl"]; ?></a></li>
                        <?php } ?>
                        <li>
                            <div class="input-group spSearch">
                                <input type="text" id="siparisTakip" class="form-control" placeholder="<?php echo $data["SiparisTakip"]; ?>" style="padding:3px 10px; height:28px;">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" data-toggle="modal" id="siparisArama" data-target="#spDetayModal" type="button" style="padding:3px 10px;"><i class="fa fa-search"></i></button>
                                    </span>
                            </div>
                        </li>
                        <li class="hidden-lg hidden-md">
                            <div class="navbar-header pull-right" style="margin-bottom:-20px; padding-left:10px;">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12" style="margin-top:12px;">
                <div class="pull-right">
                    <ul class="kurumsalMenu" style="padding-right:0;">
                        <li><a href="<?php echo SITE_URL; ?>"><?php echo $data["Anasayfa"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL . "/sayfa-hakkimizda" ?>" id="sesso" data-url="StaticPager" data-method="index"><?php echo $data["Kurumsal"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>"><?php echo $data["Iletisim"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL . "/Home/Contact" ?>" style="font-size:26px; color:#b51e91;"><i class="fa fa-phone"></i> <?php echo $model[8]["telefon"]; ?></a></li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div><!--/header-middle-->