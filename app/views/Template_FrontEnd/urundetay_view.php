<script src="<?php echo SITE_JS ?>/jquery.zoom.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/urun_detay.js"></script>
<section>
    <br />
    <div class="container">
        <div class="row">
            <div class="col-sm-12 padding-right">
                <div class="product-details">
                    <!--product-details-->
                    <div class="col-sm-4">
                        <div class="imgThumb view-product" id="urun-zoom">
                            <img class="img-responsive" src="<?php echo SITE_PRODUCT ?>/<?php echo $model[0]['urunResim']; ?>" alt="" />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="product-information">
                            <h2><?php echo $model[0]['urunAd']; ?></h2>
                            <p>Ürün Kodu: <?php echo $model[0]['urunKod']; ?></p>
                            <?php if ($model[0]['KID'] > 0) { ?>
                                <p class="indirim"><?php echo $data["IndirimUrun"] ?></p>
                            <?php } ?>

                            <div class="fiyat">
                                <?php if ($model[0]['KID'] > 0) { ?>
                                    <span>
                                        <?php echo $model[0]['urunFiyat']; ?> TL
                                    </span>
                                    <h3><?php echo ($model[0]['urunFiyat'] - (round(($model[0]['urunFiyat'] * $model[0]['KYuzde']))) / 100); ?> TL</h3>
                                <?php } else { ?>
                                    <h3><?php echo $model[0]['urunFiyat']; ?> TL</h3>
                                <?php } ?>
                            </div>
                            <p><?php echo $model[0]['urunAciklama']; ?></p>

                        </div><!--/product-information-->
                    </div>
                    <div class="col-sm-4">
                        <form id="furunsiparis">
                            <input type="hidden" name="urunID" value="<?php echo $model[0]['urunID']; ?>" id="urunID" class="form-control">
                                <div class="form-group">
                                    <select name="sehirSec" id="sehirSec" class="form-control select2">
                                        <option value="0"><?php echo $data["IlSec"] ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="ilceSec" id="ilceSec" class="form-control select2">
                                        <option value="0"><?php echo $data["IlceSec"] ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="semtSec" id="semtSec" class="form-control select2">
                                        <option value="0"><?php echo $data["SemtSec"] ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select name="mahalleSec" id="mahalleSec" class="form-control select2">
                                        <option value="0"><?php echo $data["MahalleSec"] ?></option>
                                    </select>
                                </div>
                                <div class="form-group" id="postaKoduDiv" style="display:none">
                                    <input type="text" name="postaKoduSec" id="postaKoduSec" class="form-control" disabled>
                                        <input type="hidden" name="postaKodu" value="" id="postaKodu" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input type="text" name="tarihSec"  id="tarihSec" class="form-control" placeholder="<?php echo $data["GonTarih"] ?>">
                                                        <span class="input-group-btn">
                                                            <button id="tarihSecBtn" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select name="saatSec" id="saatSec" class="form-control">
                                                    <option value="0"><?php echo $data["SaatAra"] ?></option>
                                                    <option value="1">08:00 - 10:00</option>
                                                    <option value="2">10:00 - 12:00</option>
                                                    <option value="3">12:00 - 14:00</option>
                                                    <option value="4">14:00 - 16:00</option>
                                                    <option value="5">16:00 - 18:00</option>
                                                </select>
                                            </div>
                                            <button type="button" id="urunSipVer" class="btn btn-fefault cart">
                                                <i class="fa fa-shopping-cart"></i>
                                                <?php echo $data["SiparisVer"] ?>
                                            </button>
                                            </form>
                                            </div>
                                            </div><!--/product-details-->

                                            </div>
                                            </div>
                                            </div>
                                            </section>
                                            <section id="advertisement">
                                                <div class="container">
                                                    <div class="row">
                                                        <div class="col-sm-12">

                                                        </div>
                                                    </div>
                                                </div>
                                            </section>

                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#urun-zoom').zoom();
                                                    $("#tarihSec").datepicker();
                                                    $(document).on("click", "#tarihSecBtn", function () {
                                                        $("#tarihSec").focus();
                                                    });
                                                });
                                            </script>