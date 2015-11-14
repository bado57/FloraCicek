<script src="<?php echo SITE_JS ?>/jquery.zoom.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/bootstrap-switch.js" type="text/javascript"></script>
<script src="<?php echo SITE_JS ?>/urunsiparis.js" type="text/javascript"></script>
<section id="advertisementt">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="margin-top:20px;  padding-bottom:30px;">
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_IMAGES ?>/logo.png" alt="" /></a></div>
                <div class="wizard"><div class="step">1</div> <span><?php echo $data["EkUrun"]; ?></span></div>
                <?php if (Session::get("KID") > 0) { ?>
                    <div class="wizard activeStep"><div class="step">2</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } else { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["UyeGiris"]; ?></span></div>
                    <div class="wizard activeStep"><div class="step">3</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
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
                    <div class="col-sm-9">
                        <div class="row">
                            <form id="urunteslimat">
                                <div class="col-sm-6">
                                    <div class="login-form">
                                        <!--login form-->
                                        <h2><?php echo $data["GonBilgi"]; ?></h2>
                                        <div class="form" style="padding-bottom:30px;">
                                            <input name="gndadsoyad" id="gndadsoyad" value="<?php echo (Session::get("KID") > 0) ? Session::get("KAdSoyad") : ''; ?>" type="text" placeholder="<?php echo $data["AdinSoyadin"]; ?>" />
                                            <input name="gndmail" id="gndmail" type="email" value="<?php echo (Session::get("KID") > 0) ? Session::get("KEposta") : ''; ?>" placeholder="E-posta Adresiniz" />
                                            <input name="gndTel" id="gndTel" type="text" value="" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="<?php echo $data["TelNo"]; ?>" />
                                            <select name="gonderimNedeni" id="gonderimNedeni" style="margin-bottom:20px;">
                                                <option value="0"><?php echo $data["GonNeden"]; ?></option>
                                                <?php foreach ($model[3] as $yerModel) { ?>
                                                    <option value="<?php echo $yerModel["ID"]; ?>"><?php echo $yerModel["AD"]; ?></option>
                                                <?php } ?>
                                            </select>
                                            <div style="margin-top:65px;">
                                                <label class="radio-inline"><input id="fisradio" type="radio" name="optradio"  checked><?php echo $data["FisIste"]; ?></label>
                                                <label class="radio-inline"><input id="faturaradio" type="radio" name="optradio" ><?php echo $data["FaturaIste"]; ?></label>
                                            </div>
                                        </div>

                                    </div><!--/login form-->
                                </div>
                                <div class="col-sm-6">
                                    <div class="login-form">
                                        <!--login form-->
                                        <h2><?php echo $data["AliciBilgi"]; ?></h2>
                                        <div class="form" style="padding-bottom:30px;">
                                            <input id="aliciadsoyad" name="aliciadsoyad" type="text" placeholder="<?php echo $data["AdSoyad"]; ?>" required />
                                            <input id="alicitel" name="alicitel" type="text" data-inputmask='"mask": "(999) 999-9999"' data-mask placeholder="<?php echo $data["TelNo"]; ?>" />
                                            <select id="gidecegiYer" name="gidecegiYer">
                                                <option value="0"><?php echo $data["GitmeYeri"]; ?></option>
                                                <?php foreach ($model[2] as $nedenModel) { ?>
                                                    <option value="<?php echo $nedenModel["ID"]; ?>"><?php echo $nedenModel["AD"]; ?></option>
                                                <?php } ?>
                                            </select>
                                            <textarea id="aliciadres" name="aliciadres" rows="3" placeholder="<?php echo $data["Adres"]; ?>"><?php echo (Session::get("KID") > 0) ? Session::get("SipAdres") : ''; ?></textarea>
                                            <input type="text" id="aliciadresdetay" name="aliciadresdetay" placeholder="<?php echo $data["AdresTarif"]; ?>" />
                                        </div>
                                    </div><!--/login form-->
                                </div>
                                <div class="col-sm-12 faturaDiv" style="display:none;">
                                    <div class="col-sm-12" style="border-top:1px solid #e6e6e6;"></div>
                                    <div class="row">
                                        <div class="col-sm-12 login-form">
                                            <h2><?php echo $data["FaturaBilgi"]; ?></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="login-form">
                                                <div class="form" style="padding-bottom:30px;">
                                                    <input id="faturaunvan" name="faturaunvan" type="text" placeholder="<?php echo $data["FaturaUnv"]; ?>" />
                                                    <input id="vd" name="vd" type="text" placeholder="<?php echo $data["VergiDaire"]; ?>" value="<?php echo Session::get("KurVergiNo"); ?>" />
                                                    <input id="vn" name="vn" type="text" placeholder="<?php echo $data["VergiNo"]; ?>" value="<?php echo Session::get("KurVerDaire"); ?>" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="login-form">
                                                <div class="form" style="padding-bottom:30px;">
                                                    <input id="tcno" name="tcno" type="text"data-inputmask='"mask": "99999999999"' data-mask placeholder="TC Kimlik No" />
                                                    <textarea id="faturaadres" name="faturaadres" rows="4" placeholder="Fatura Adresi"><?php Session::get("KurFAdres"); ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 kartDiv">
                                    <div class="col-sm-12" style="border-top:1px solid #e6e6e6;"></div>
                                    <div class="row">
                                        <div class="col-sm-12 login-form">
                                            <h2><?php echo $data["KartBilgi"]; ?></h2>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="login-form">
                                                <div class="form" style="padding-bottom:30px;">
                                                    <textarea id="kartmesaji" name="kartmesaji" rows="4" maxlength="160" placeholder="Kartın Mesajı"></textarea>
                                                    <input id="kartisim" name="kartisim" type="text" placeholder="Karta Yazılacak İsim" />
                                                    <textarea id="siparisnotu" name="siparisnotu" rows="2" maxlength="140" placeholder="Varsa bize notunuz"></textarea>
                                                    <label class="checkbox-inline" style="margin-top:10px;"><input id="onayCheck" type="checkbox" name="onayCheck">Yazdıklarımı onaylıyorum</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="login-form">
                                                <div class="form">
                                                    <div class="sampleCard">
                                                        <div class="scMessage">
                                                        </div>
                                                        <div class="scName"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="imgThumb" style="border:1px solid #e6e6e6">
                            <img class="img-responsive" src="<?php echo SITE_PRODUCT ?>/<?php echo $model[0][0]['urunResim']; ?>" alt="" />
                        </div>
                        <div class="product-sm-information">
                            <span class="ekurun-listefiyat hidden"><?php echo Session::get("SipIlceFiyat"); ?></span>
                            <h4><?php echo $model[0][0]['urunAd'] ?></h4>
                            <p><?php echo $data["UrunKod"] ?>: <?php echo $model[0][0]['urunKod'] ?><span class="pull-right"> TL</span> <span class="urunFiyat pull-right"><?php echo $model[0][0]['urunFiyat'] ?></span></p>
                            <hr />
                            <p><?php echo Session::get("SipAdres"); ?><br /> <small><?php echo Session::get("SipTarih"); ?> <?php echo Session::get("SipGun"); ?> <span class="pull-right"><?php echo Session::get("SipSaat"); ?></span></small></p>
                            <hr />
                            <?php if (count($model[1]) > 0) { ?>
                                <ul class="ekurunler">
                                    <?php foreach ($model[1] as $ekUrunModel) { ?>
                                        <li id="uruncikar-<?php echo $ekUrunModel["EkID"] ?>" data-ekid="<?php echo $ekUrunModel["EkID"] ?>"><?php echo $ekUrunModel["EkAdi"] ?><br>
                                            <small><?php echo $data["UrunKod"] ?> : <?php echo $ekUrunModel["EkKod"] ?></small>
                                            <a role="button" class="uruncikar pull-right" data-urunid="<?php echo $ekUrunModel["EkID"] ?>" data-switch-set="state" data-switch-value="false" title="Çıkar">
                                                <i class="fa fa-times-circle"></i>
                                            </a> <span class="pull-right">
                                                <span class="ekurun-listefiyat"><?php echo $ekUrunModel["EkFiyat"] ?></span> TL </span>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <hr />
                            <p><button class="btn btn-primary nextBtn mt0" id="teslimatIleri" type="input"><i class="fa fa-angle-right"></i> <?php echo $data["Ilerle"] ?></button><span class="pull-right" style="margin-top:7px; font-size:16px;">Toplam : <strong class="spTotal">45</strong> <strong>TL</strong></span></p>
                        </div><!--/product-information-->
                    </div>
                </div><!--/product-details-->

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        fiyatTopla();
        $(document).on('change', '[name="optradio"]', function () {
            if ($(this).attr("id") == "faturaradio") {
                $(".faturaDiv").slideDown("fast");
            } else {
                $(".faturaDiv").slideUp("fast");
            }
        });

        $("#kartmesaji").keyup(function () {
            var msj = $(this).val();
            $(".scMessage").html(msj);
        });

        $("#kartisim").keyup(function () {
            var ism = $(this).val();
            $(".scName").html(ism);
        });

        $(document).on("click", ".uruncikar", function () {
            var urunid = $(this).attr("data-urunid");
            $("#uruncikar-" + urunid).remove();
            var type;
            type = $(this).data("switch-set");
            return $('.switch-state[data-urunid="' + urunid + '"]').bootstrapSwitch(type, $(this).data("switch-value"));
            fiyatTopla();
        });
    });
    function fiyatTopla() {
        var toplamFiyat = 0;
        var urunFiyat = parseFloat($(".urunFiyat").html());
        var ekurunToplam = 0;
        $(".ekurun-listefiyat").each(function () {
            var euFiyat = parseFloat($(this).html());
            ekurunToplam = ekurunToplam + euFiyat;
        });
        toplamFiyat = urunFiyat + ekurunToplam;
        toplamFiyat = toplamFiyat.toFixed(2);
        $(".spTotal").html(toplamFiyat);
    }
</script>
<!--iç sayfa sonu-->