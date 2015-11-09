<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="features_items">
                    <!--features_items-->
                    <?php if (count($model[5]) > 0) { ?>
                        <h2 class="title text-center"><?php echo $data["EkUrun"]; ?></h2>
                        <?php foreach ($model[5][0] as $ekurunModel) { ?>
                            <div class="col-sm-3 col-xs-6">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <div class="imgThumb">
                                                <img src="<?php echo SITE_PRODUCT ?>/<?php echo $ekurunModel['EkResim']; ?>" alt="Türkiye Flora Çiçek <?php echo $ekurunModel['EkAdi']; ?>" />
                                            </div>
                                            <p><?php echo $ekurunModel['EkAdi']; ?><br /> <small><?php echo $data["UrunKod"]; ?> : <?php echo $ekurunModel['EkKod']; ?></small></p>
                                            <h2><?php echo $ekurunModel['EkKmpID'] == 0 ? $ekurunModel['NormalEkFiyat'] . " TL" : "<span>" . $ekurunModel['NormalEkFiyat'] . " TL </span>  " . $ekurunModel['EkFiyat'] . " TL"; ?></h2>
                                            <a href="<?php echo $ekurunModel['EkUrl']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i><?php echo $data["SiparisVer"]; ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div><!--features_items-->
            </div>
        </div>
    </div>
</section>
<!--iç sayfa sonu-->
