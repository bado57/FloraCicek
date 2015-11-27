<script src="<?php echo SITE_JS ?>/jquery.zoom.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/bootstrap-switch.js" type="text/javascript"></script>
<script src="<?php echo SITE_JS ?>/urunsiparis.js" type="text/javascript"></script>
<section id="advertisementt">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="margin-top:20px;  padding-bottom:30px;">
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_VITRIN . "/" . $model[4][0]['Logo']; ?>" alt="" /></a></div>
                <div class="wizard activeStep"><div class="step">1</div> <span><?php echo $data["EkUrun"]; ?></span></div>
                <?php if (Session::get("KID") > 0) { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } else { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["UyeGiris"]; ?></span></div>
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
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-9">
                        <div class="row">
                            <?php foreach ($model[1] as $urunModel) { ?>
                                <div class="col-sm-3">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center" data-id="<?php echo $urunModel["EkID"] ?>">
                                                <p class="ekurun-id hidden"><?php echo $urunModel['EkID']; ?></p>
                                                <div class="imgThumb imgThumbEk">
                                                    <img src="<?php echo SITE_PRODUCT ?>/<?php echo $urunModel['EkResim']; ?>" alt="" />
                                                </div>
                                                <p class="ekurun-isim"><?php echo $urunModel['EkAdi']; ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $urunModel['EkKod']; ?></small></p>
                                                <p class="ekurun-fiyat hidden"><?php echo $urunModel['EkFiyat']; ?></p>
                                                <?php if (in_array($urunModel['EkID'], $model[3][0]['EkSwitch'])) { ?>
                                                    <input class="switch-state" checked  type="checkbox" data-urunid="<?php echo $urunModel["EkID"] ?>" />
                                                <?php } else { ?>
                                                    <input class="switch-state"  type="checkbox" data-urunid="<?php echo $urunModel["EkID"] ?>" />
                                                <?php } ?>
                                                <br />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="view-product" id="urun-zoom">
                            <img  class="img-responsive" src="<?php echo SITE_PRODUCT ?>/<?php echo $model[0][0]['urunResim']; ?>" alt="" />
                        </div>
                        <div class="product-sm-information">
                            <input type="hidden" value="<?php echo $model[0][0]['urunID']; ?>" id="urunID"/>
                            <input type="hidden" value="<?php echo Session::get("SipTarih"); ?>" id="urunTarih"/>
                            <input type="hidden" value="<?php echo Session::get("SipAdres"); ?>" id="urunAdres"/>
                            <span class="ekurun-listefiyat hidden"><?php echo Session::get("SipIlceFiyat"); ?></span>
                            <h4><?php echo $model[0][0]['urunAd']; ?></h4>
                            <p><?php echo $data["UrunKod"]; ?>: <?php echo $model[0][0]['urunKod']; ?> <span class="pull-right"> TL</span> <span class="urunFiyat pull-right"><?php echo $model[0][0]['urunFiyat']; ?></span></p>
                            <hr />
                            <p><?php echo Session::get("SipAdres") . ' ( +' . Session::get("SipIlceFiyat") . ' TL)'; ?><br /> <small><?php echo Session::get("SipTarih"); ?> <?php echo Session::get("SipGun"); ?> <span class="pull-right"><?php echo Session::get("SipSaat"); ?></span></small></p>
                            <hr />
                            <ul class="ekurunler">
                                <?php if (count($model[2]) > 0) { ?>
                                    <?php foreach ($model[2] as $ekUrunModel) { ?>
                                        <li id="uruncikar-<?php echo $ekUrunModel["EkID"] ?>" data-ekid="<?php echo $ekUrunModel["EkID"] ?>"><?php echo $ekUrunModel["EkAdi"] ?><br>
                                            <small><?php echo $data["UrunKod"] ?> : <?php echo $ekUrunModel["EkKod"] ?></small>
                                            <a role="button" class="uruncikar pull-right" data-urunid="<?php echo $ekUrunModel["EkID"] ?>" data-switch-set="state" data-switch-value="false" title="Çıkar">
                                                <i class="fa fa-times-circle"></i>
                                            </a> <span class="pull-right">
                                                <span class="ekurun-listefiyat"><?php echo $ekUrunModel["EkFiyat"] ?></span> TL </span>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                            <hr />
                            <p><button class="btn btn-primary nextBtn mt0" id="ekurunIlerle" type="button"><i class="fa fa-angle-right"></i> <?php echo $data["Ilerle"]; ?></button><span class="pull-right" style="margin-top:7px; font-size:16px;">Toplam : <strong class="spTotal">45</strong> <strong>TL</strong></span></p>
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
        $('#urun-zoom').zoom();
        // Ek Ürün Ekleme Çıkarma
        $(".switch-state").each(function () {
            var fiyat = $(this).parent().find(".ekurun-fiyat").html();
            var isim = $(this).parent().find(".ekurun-isim").html();
            var id = $(this).parent().attr("data-id");
            var urunid = $(this).parent().find(".ekurun-id").html();

            $(this).bootstrapSwitch({
                labelText: fiyat + " TL",
                onSwitchChange: function (event, state) {
                    switch (state) {
                        case true:
                            // Eklendiyse
                            var temp = '<li id="uruncikar-' + id + '" data-ekid="' + urunid + '">' + isim + ' <a role="button" class="uruncikar pull-right" data-urunid="' + id + '" data-switch-set="state" data-switch-value="false" title="Çıkar"><i class="fa fa-times-circle"></i></a> <span class="pull-right"><span class="ekurun-listefiyat">' + fiyat + '</span> TL </span></li>';
                            $(".ekurunler").append(temp);
                            fiyatTopla();
                            break;
                        case false:
                            // Çıkarıldıysa
                            $("#uruncikar-" + id).remove();
                            fiyatTopla();
                            break;
                        default:
                            break;
                    }
                }
            });
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