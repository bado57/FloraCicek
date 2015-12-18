<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/urunsiparis.js" type="text/javascript"></script>
<!-- Sipariş adımlarında açılır menünün gizlenmesi için css -->
<style type="text/css">
    #mCollapse{display: none;}
    #orderLink{display: block !important;}
    .footer-top, .header-middle, .footer-widget, .mobile_login_menu{display: none !important;}
</style>
<!-- End Sipariş adımlarında açılır menünün gizlenmesi için css -->
<section id="advertisementt">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="margin-top:20px;  padding-bottom:30px;">
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_VITRIN . "/" . $model[1][0]['Logo']; ?>" alt="Türkiye Flora Çiçek Logo" /></a></div>
                <div class="wizard"><div class="step">1</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <div class="wizard activeStep"><div class="step"><i class="fa fa-check"></i></div> <span><?php echo $data["OdeOnay"]; ?></span></div>
            </div>
        </div>
        <div class="col-sm-12" style="border-bottom:1px solid #e6e6e6;"></div>
    </div>
</section>
<section>
    <br />
    <div class="container" style="padding-bottom:150px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="product-details">
                    <div class="col-sm-12">
                        <div class="row">
                            <form id="formgirisyap">
                                <div class="col-sm-6 col-sm-offset-3" style="padding-top:60px;">
                                    <div class="login-form" id="formgirisyap">
                                        <!--Sipariş onayı-->
                                        <h2>Ödemeniz alınmıştır.</h2>
                                        <!--End Sipariş onayı-->
                                        <hr/>
                                        <div class="form" style="padding-bottom:30px;">
                                            <!--Ödeme onayı-->
                                            <h4>Ödeme Türü : <b>Kredi Kartı</b></h4>
                                            <h2><i class="fa fa-phone-square"></i> Çağrı Merkezi : <b><?php echo $model[1][0]['Tel']; ?></b></h2>
                                            <?php if (Session::get("KID") <= 0) { ?>
                                                <!--Üye değilse-->
                                                <p>Sitemize üye olarak bir çok avantaj ve indirimlerden yararlanabilirsiniz.</p>
                                                <button type="button" class="btn btn-default" id="uyeOl" style="position:relative; display:inline-block; margin-right:10px;"><i class="fa fa-angle-right"></i> Üye Ol</button>
                                                <!--End Üye değilse-->
                                            <?php } else { ?>
                                                <p></p>
                                                <div style="position:relative; display:inline-block; margin-right:10px;"></div>
                                            <?php } ?>
                                            <button type="button" id="gotoHomeOzelOdeme" class="btn btn-success pull-right" style="position:relative; display:inline-block; background-color:#0ca40b;"><i class="fa fa-angle-left"></i> Anasayfaya dön</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


