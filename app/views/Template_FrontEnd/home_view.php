<!--iç sayfa-->
<?php if (count($model[4]) > 0) { ?>
    <section id="slider" class="hidden-xs">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <?php
                            $indiccount = count($model[4]);
                            for ($indic = 1; $indic < $indiccount; $indic++) {
                                ?>
                                <li data-target="#slider-carousel" data-slide-to="<?php echo $indic; ?>"></li>
                            <?php } ?>
                        </ol>
                        <div class="carousel-inner">
                            <?php foreach ($model[4] as $vitrinModel) { ?>
                                <div class="item <?php echo $model[4][0]['ID'] == $vitrinModel['ID'] ? 'active' : ''; ?> col-xs-12">
                                    <div class="col-sm-6 col-xs-6">
                                        <h1 class="vitrinh1"><?php echo $vitrinModel['Baslik']; ?></h1>
                                        <h2 class="vitrinh2"><?php echo $vitrinModel['AltBaslik']; ?></h2>
                                        <p class="hidden-xs"><?php echo $vitrinModel['Yazi']; ?></p>
                                        <a href="<?php echo $vitrinModel['Url']; ?>" class="btn btn-default get"><?php echo $vitrinModel['BtnYazi']; ?></a>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <img vitrinImage src="<?php echo SITE_VITRIN ?>/<?php echo $vitrinModel['Path']; ?>" class="girl img-responsive" alt="<?php echo $vitrinModel['Baslik']; ?>" />
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section><!--/slider-->
<?php } ?>
<section>
    <div class="container">
        <style type="text/css">
            h2.title, .left-sidebar h2{
                color: #DE1414;
            }
        </style>
        <div class="row">
            <div class="col-sm-3 col-xs-12">
                <div class="features_items">
                    <?php if (count($model[5][0]) > 0) { ?>
                        <?php foreach ($model[5][0] as $haftaUrunModel) { ?>
                            <h2 class="title text-center"><?php echo $data["HftUrun"]; ?></h2>
                            <div class="col-sm-12">
                                <div class="product-image-wrapper" style="">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <div class="imgThumb">
                                                <img src="<?php echo SITE_PRODUCT . '/' . $haftaUrunModel['Path']; ?>" alt="Türkiye Flora Çiçek <?php echo $haftaUrunModel['Adi']; ?>" />
                                            </div>
                                            <p><?php echo $haftaUrunModel['Adi']; ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $haftaUrunModel['Kod']; ?></small></p>
                                            <h2><?php echo $haftaUrunModel['KID'] == 0 ? $haftaUrunModel['Fiyat'] . " TL" : "<span>" . $haftaUrunModel['Fiyat'] . " TL </span>  " . round(($haftaUrunModel['Fiyat'] - (($haftaUrunModel['Fiyat'] * $haftaUrunModel['KYuzde']) / 100))) . " TL"; ?></h2>
                                            <a href="<?php echo $haftaUrunModel['Url']; ?>" class="btn btn-default add-to-cart" style="margin-top:11px; background: #FE980F; color:#fff;"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-9 col-xs-12">
                <div class="recommended_items">
                    <h2 class="title text-center"><?php echo $data["YeniUrun"]; ?></h2>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner"> 
                            <?php
                            $artandeger = 0;
                            $modelyuruncount = count($model[5][1]);
                            ?>
                            <?php for ($yni = 0; $yni < count($model[5][1]); $yni+=3) { ?>
                                <div class="item <?php echo $yni == 0 ? 'active' : ''; ?>">
                                    <?php for ($ynii = 0; $ynii < 3; $ynii++) { ?>
                                        <?php if ($modelyuruncount > 0) { ?>
                                            <div class="col-sm-4">
                                                <div class="product-image-wrapper">
                                                    <div class="single-products">
                                                        <div class="productinfo text-center">
                                                            <div class="imgThumb">
                                                                <img class="yeniUrunImg" src="<?php echo SITE_PRODUCT ?>/<?php echo $model[5][1][$artandeger]['Path']; ?>" alt="Türkiye Flora Çiçek <?php echo $model[5][1][$artandeger]['Adi']; ?>" />
                                                            </div>
                                                            <p><?php echo $model[5][1][$artandeger]['Adi']; ?> <br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $model[5][1][$artandeger]['Kod']; ?></small></p>
                                                            <h2><?php echo $model[5][1][$artandeger]['KID'] == 0 ? $model[5][1][$artandeger]['Fiyat'] . " TL" : "<span>" . $model[5][1][$artandeger]['Fiyat'] . " TL </span>  " . round(($model[5][1][$artandeger]['Fiyat'] - (($model[5][1][$artandeger]['Fiyat'] * $model[5][1][$artandeger]['KYuzde']) / 100))) . " TL"; ?></h2>
                                                            <a href="<?php echo $model[5][1][$artandeger]['Url']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        $modelyuruncount--;
                                        $artandeger++;
                                    }
                                    ?> 
                                </div>
                            <?php } ?> 
                        </div>
                        <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div><!--/recommended_items-->
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 padding-right">
                <div class="features_items">
                    <!--features_items-->
                    <?php if (count($model[5][3]) > 0) { ?>
                        <h2 class="title text-center kampanyaTitle"><?php echo $data["KmpnyUrun"]; ?> <?php echo count($model[5][3]) > 20 ? '<a href="kampanyali-urunler" class="btn btn-primary btn-sm" style="margin-top:0;margin-left: 10px;">Tümünü Gör</a>' : ''; ?>  </h2>
                        <?php foreach ($model[5][3] as $kampanyaModel) { ?>
                            <div class="col-sm-3 col-xs-6">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <div class="imgThumb">
                                                <img src="<?php echo SITE_PRODUCT ?>/<?php echo $kampanyaModel['Path']; ?>" alt="Türkiye Flora Çiçek <?php echo $kampanyaModel['Adi']; ?>" />
                                            </div>
                                            <p><?php echo $kampanyaModel['Adi']; ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $kampanyaModel['Kod']; ?></small></p>
                                            <h2><span><?php echo $kampanyaModel['Fiyat']; ?> TL</span> <?php echo round(($kampanyaModel['Fiyat'] - (($kampanyaModel['Fiyat'] * $kampanyaModel['KYuzde']) / 100))); ?> TL</h2>
                                            <a href="<?php echo $kampanyaModel['Url']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else if (count($model[5][4]) > 0) {
                        ?>
                        <h2 class="title text-center kampanyaTitle"><?php echo $data["CokSatan"]; ?> <?php echo count($model[5][3]) > 20 ? '<a href="coksatan-urunler" class="btn btn-primary btn-sm" style="margin-top:0;margin-left: 10px;">Tümünü Gör</a>' : ''; ?>  </h2>
                        <?php foreach ($model[5][4] as $coksatanModel) { ?>
                            <div class="col-sm-3 col-xs-6">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <div class="imgThumb">
                                                <img src="<?php echo SITE_PRODUCT ?>/<?php echo $coksatanModel['Path']; ?>" alt="Türkiye Flora Çiçek <?php echo $coksatanModel['Adi']; ?>" />
                                            </div>
                                            <p><?php echo $coksatanModel['Adi']; ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $coksatanModel['Kod']; ?></small></p>
                                            <h2><?php echo $coksatanModel['Fiyat'] . " TL"; ?></h2>
                                            <a href="<?php echo $coksatanModel['Url']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-bottom:30px; margin-top:30px;">
            <div class="col-sm-12">
                <div class="col-sm-6" style="margin-bottom: 30px;">
                    <div class="left-sidebar">
                        <h2><?php echo $data["EkUrun"]; ?></h2>
                    </div>
                    <a href="ek-urunler">
                        <img class="img-responsive" src="<?php echo SITE_IMAGES ?>/ek-urun.jpg" alt="Türkiye Flora Çiçek Ek Ürünler Image" />
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                    <div class="left-sidebar">
                        <h2>DOĞUM GÜNÜ</h2>
                    </div>
                    <a href="dogum-gunu">
                        <img class="img-responsive" src="<?php echo SITE_IMAGES ?>/dogum-gunu.jpg" alt="Türkiye Flora Çiçek Doğum Günü Image" />
                    </a>
                </div>
                <div class="col-sm-3 col-xs-6" style="margin-bottom: 30px;">
                    <div class="left-sidebar">
                        <h2>YILDÖNÜMÜ</h2>
                    </div>
                    <a href="sevgiliye-yildonumu">
                        <img class="img-responsive" src="<?php echo SITE_IMAGES ?>/yildonumu.jpg" alt="Türkiye Flora Çiçek Yıldönümü Image" />
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
<!--iç sayfa sonu-->
