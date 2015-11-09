<section id="advertisement">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div id="katID" data-value="<?php echo $model[0][0]['katID']; ?>" style="display:none"></div>
                <div id="katTip" data-value="<?php echo $model[0][0]['katTip']; ?>" style="display:none"></div>
                <p class="SayfaBaslik"><?php echo $model[0][0]['katAd']; ?></p>
            </div>
            <div class="col-sm-9">
                <p><?php echo $model[0][0]['katYazi']; ?></p>
            </div>
        </div>
        <div class="col-sm-12 filtre" id="tabClick">
            <div class="row">
                <div id="tab" class="col-sm-3 col-xs-3 text-center" style="border-right: 1px solid #e6e6e6;">
                    <a id="urunTab" data-tab="1" class="filtreBtn active"><?php echo $data["CokSatan"]; ?></a>
                </div>
                <div class="col-sm-3 col-xs-3 text-center" style="border-right: 1px solid #e6e6e6;">
                    <a id="urunTab" data-tab="2" class="filtreBtn"><?php echo $data["UcuzPahali"]; ?></a>
                </div>
                <div class="col-sm-3 col-xs-3 text-center" style="border-right: 1px solid #e6e6e6;">
                    <a id="urunTab" data-tab="3" class="filtreBtn"><?php echo $data["PahaliUcuz"]; ?></a>
                </div>
                <div class="col-sm-3 col-xs-3 text-center">
                    <a id="urunTab" data-tab="4" class="filtreBtn"><?php echo $data["AZ"]; ?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container" id="tabs-container">
        <div class="row">
            <div class="col-sm-12 p0">
                <div class="features_items" id="features_items">
                    <?php foreach ($model[1] as $urunModel) { ?>
                        <div class="col-sm-3 col-xs-6">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <div class="imgThumb">
                                            <img src="<?php echo SITE_PRODUCT ?>/<?php echo $urunModel['urunResim']; ?>" alt="Türkiye Flora Çiçek <?php echo $urunModel['urunAd'] ?>" />
                                        </div>
                                        <p><?php echo $urunModel['urunAd'] ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $urunModel['urunKod'] ?></small></p>
                                        <h2><?php echo $urunModel['KID'] == 0 ? $urunModel['urunFiyat'] . " TL" : "<span>" . $urunModel['urunFiyat'] . " TL </span>  " . ($urunModel['urunFiyat'] - (round(($urunModel['urunFiyat'] * $urunModel['KYuzde']) / 100))) . " TL"; ?></h2>
                                        <a href="<?php echo $urunModel['urunUrl']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>