<script src="<?php echo SITE_JS ?>/jquery.zoom.js"></script>
<script src="<?php echo SITE_JS ?>/bootstrap-switch.js" type="text/javascript"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/urunsiparis.js" type="text/javascript"></script>
<section id="advertisementt">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="margin-top:20px;  padding-bottom:30px;">
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_IMAGES ?>/logo.png" alt="" /></a></div>
                <div class="wizard"><div class="step">1</div> <span><?php echo $data["EkUrun"]; ?></span></div>
                <?php if (Session::get("KID") > 0) { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } else { ?>
                    <div class="wizard activeStep"><div class="step">2</div> <span><?php echo $data["UyeGiris"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">4</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } ?>
                <div class="wizard"><div class="step"><i class="fa fa-check"></i></div> <span><?php echo $data["SipOnay"]; ?></span></div>
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
                    <!--product-details-->
                    <div class="col-sm-12">
                        <div class="row">
                            <form id="formgirisyap">
                                <div class="col-sm-6 col-sm-offset-3" style="padding-top:60px;">
                                    <div class="login-form" id="formgirisyap">
                                        <!--login form-->
                                        <h2><?php echo $data["KullaniciBilgi"] ?></h2>
                                        <div class="form" style="padding-bottom:30px;">
                                            <input type="email" id="girisemail" name="girisemail" placeholder="<?php echo $data["Email"]; ?>" />
                                            <input type="password" id="girissifre" name="girissifre" placeholder="<?php echo $data["Sifre"]; ?>" />
                                            <button type="button" class="btn btn-default" id="btnGiris" style="position:relative; display:inline-block; margin-right:10px;"><i class="fa fa-angle-right"></i> <?php echo $data["GirisYap"]; ?></button>
                                            <button type="button" id="btnGirisYapma" class="btn btn-success pull-right" style="position:relative; display:inline-block; background-color:#0ca40b;"><i class="fa fa-angle-right"></i> <?php echo $data["UyeDevamEt"]; ?></button>
                                        </div>
                                    </div><!--/login form-->
                                </div>
                                <div class="col-sm-6"></div>
                            </form>
                        </div>
                    </div>
                </div><!--/product-details-->

            </div>
        </div>
    </div>
</section>
