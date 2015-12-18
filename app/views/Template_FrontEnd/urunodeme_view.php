<script src="<?php echo SITE_JS ?>/jquery.zoom.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<script src="<?php echo SITE_JS ?>/bootstrap-switch.js" type="text/javascript"></script>
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
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_VITRIN . "/" . $model[3][0]['Logo']; ?>" alt="Turkiye Flora Çiçek Logo" /></a></div>
                <div class="wizard"><div class="step">1</div> <span><?php echo $data["EkUrun"]; ?></span></div>
                <?php if (Session::get("KID") > 0) { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard activeStep"><div class="step">3</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } else { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["UyeGiris"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard activeStep"><div class="step">4</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
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
                    <div class="col-sm-9">
                        <div class="row">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#kart" aria-controls="kart" role="tab" data-toggle="tab">Kart ile Öde</a></li>
                                <li role="presentation"><a href="#havale" aria-controls="havale" role="tab" data-toggle="tab">Havale ile Öde</a></li>
                                <li role="presentation"><a href="#telefon" aria-controls="telefon" role="tab" data-toggle="tab">Telefonda Öde</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="kart">
                                    <br />
                                    <div class="col-sm-12 login-form">
                                        <h2><?php echo $data["KartBilgi"]; ?></h2>
                                    </div>
                                    <form method="post" action="https://entegrasyon.asseco-see.com.tr/fim/est3Dgate" id="urunkartodeme">
                                        <div class="col-sm-6 col-xs-12 xsMarginBottom">
                                            <div class="login-form">
                                                <div class="form">
                                                    <p><?php echo $data["KartNum"]; ?></p>
                                                    <input id="kartno" name="pan" type="text" placeholder="Kart Numarası" data-inputmask='"mask": "9999999999999999"' data-mask maxlength="16"/>
                                                    <div class="row">
                                                        <p class="col-sm-12"><?php echo $data["SonKullanma"]; ?></p>
                                                        <div id="xsPadding" class="col-sm-6 padding-right">
                                                            <select class="form-control" name="Ecom_Payment_Card_ExpDate_Month" id="kartAy">
                                                                <option value="0"><?php echo $data["Ay"]; ?></option>
                                                                <option value="01">01</option>
                                                                <option value="02">02</option>
                                                                <option value="03">03</option>
                                                                <option value="04">04</option>
                                                                <option value="05">05</option>
                                                                <option value="06">06</option>
                                                                <option value="07">07</option>
                                                                <option value="08">08</option>
                                                                <option value="09">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <select class="form-control" name="Ecom_Payment_Card_ExpDate_Year" id="kartYil">
                                                                <option value="0"><?php echo $data["Yil"]; ?></option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <p><span data-toggle="tooltip" data-placement="right" title="Kredi kartınızın arka yüzünde bulunan imza şeridinin üstündeki numaranın son üç rakamıdır.">CVV (Nedir?)</span></p>
                                                    <input id="cvv" type="text" name="cv2" data-inputmask='"mask": "999"' data-mask placeholder="CVV" maxlength="3" />
                                                    <p><?php echo $data["CardType"]; ?></p>
                                                    <select name="cardType" id="kartType">
                                                        <option value="0"><?php echo $data["Seciniz"]; ?></option>
                                                        <option value="1">Visa</option>
                                                        <option value="2">MasterCard</option>
                                                    </select>
                                            <!-- <label class="checkbox-inline col-sm-12" style="margin-top:10px;"><input id="3dsecure" type="checkbox" name="3dsecure"><?php echo $data["3DSecure"]; ?></label> -->
                                                    <span><input id="kartSatisSoz" type="checkbox" name="kartSatisSoz" style="margin-top:3px;"> <a role="button" data-toggle="modal" data-target="#satisSozlesmesi" style="color:#FE980F;"> Mesafeli satış sözleşmesini ve</a><a role="button" data-toggle="modal" data-target="#onBilgilendirmeFormu" style="color:#FE980F;"> Ön Bilgilendirme Formunu</a> okudum, kabul ediyorum.</span>
                                                    <input type="hidden" name="clientid" value="<?php echo $model[5][0]['ClientID']; ?>">
                                                        <input type="hidden" name="amount" value="<?php echo $model[5][0]['TTutar']; ?>">
                                                            <input type="hidden" name="oid" value="<?php echo $model[5][0]['SipNumber']; ?>">	
                                                                <input type="hidden" name="okUrl" value="<?php echo $model[5][0]['okUrl']; ?>">
                                                                    <input type="hidden" name="failUrl" value="<?php echo $model[5][0]['failUrl']; ?>">
                                                                        <input type="hidden" name="rnd" value="<?php echo $model[5][0]['Rnd']; ?>" >
                                                                            <input type="hidden" name="hash" value="<?php echo $model[5][0]['Hash']; ?>" >
                                                                                <input type="hidden" name="islemtipi" value="<?php echo $model[5][0]['IslemTip']; ?>" >
                                                                                    <input type="hidden" name="taksit" value="<?php echo $model[5][0]['Taksit']; ?>" >
                                                                                        <input type="hidden" name="storetype" value="3d_pay" >	
                                                                                            <input type="hidden" name="lang" value="tr">
                                                                                                <input type="hidden" name="currency" value="949">
                                                                                                    <input type="hidden" name="firmaadi" value="Türkiye Flora Çiçek">
                                                                                                        <input type="hidden" id="bankhatamesaj" name="bankhatamesaj" value="<?php echo $model[5][0]['BankErrMsj']; ?>">
                                                                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-angle-right"></i> <?php echo $data["SiparisTamam"]; ?></button>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </form>
                                                                                                            <div class="col-sm-6 hidden-xs">
                                                                                                                <div class="creditCard">
                                                                                                                    <div class="cardNo">
                                                                                                                    </div>
                                                                                                                    <div class="cardDate">
                                                                                                                        <span class="kartAy"></span>
                                                                                                                        <span class="kartYil"></span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="creditCardBack" style="display:none;">
                                                                                                                    <div class="cvv">

                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            <div role="tabpanel" class="tab-pane" id="havale">
                                                                                                                <br />
                                                                                                                <div class="col-sm-12 login-form">
                                                                                                                    <h2>Banka Bilgileri</h2>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 col-xs-12">
                                                                                                                    <div class="login-form">
                                                                                                                        <div class="form">
                                                                                                                            <p>Banka Seçiniz</p>
                                                                                                                            <select id="banka">
                                                                                                                                <option value="0">Banka Seçiniz</option>
                                                                                                                                <?php if (count($model[4]) > 0) { ?>
                                                                                                                                    <?php foreach ($model[4] as $bankaIsımModel) { ?>
                                                                                                                                        <option value="<?php echo $bankaIsımModel["ID"] ?>"><?php echo $bankaIsımModel["Adi"] ?></option>
                                                                                                                                    <?php } ?>
                                                                                                                                <?php } ?>
                                                                                                                            </select>
                                                                                                                            <br />
                                                                                                                            <p style="color:red; font-size: 16px;"><i class="fa fa-warning"></i> Uyarı</p>
                                                                                                                            <p>Havale ya da EFT işlemlerinizde “Hesaba Havale” seçeneğini seçiniz. Havale/EFT işlemini yaparken açıklama kısmına sipariş numaranızı belirtiniz.</p>
                                                                                                                            <p>Havale işlemini ATM’den kartsız bir şekilde gerçekleştirdiyseniz, işlem sırasında size verilen referans numarasını alarak <?php echo $model[3][1]['Tel']; ?> numaralı Çağrı Merkezini arayınız.</p>
                                                                                                                            <p>Havale ödemenizi en geç 3 gün içerisinde gerçekleştirmediğiniz takdirde, siparişiniz otomatik olarak iptal olacaktır.</p>
                                                                                                                            <p>Siparişinizi tamamlamak için “Siparişi Tamamla” butonuna basınız.</p>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 col-xs-12 xsMarginBottom">
                                                                                                                    <div class="bankaBilgi">
                                                                                                                        <table class="table table-responsive table-bordered" style="margin-top:29px;">
                                                                                                                            <thead>
                                                                                                                                <tr>
                                                                                                                                    <th colspan="2">Banka Bilgileri</th>
                                                                                                                                </tr>
                                                                                                                            </thead>
                                                                                                                            <tbody class="bankainfo">
                                                                                                                                <?php if (count($model[4]) > 0) { ?>
                                                                                                                                    <?php foreach ($model[4] as $bankaTableModel) { ?>
                                                                                                                                        <tr class="b<?php echo $bankaTableModel["ID"] ?>">
                                                                                                                                            <td><b>BANKA</b></td>
                                                                                                                                            <td><?php echo $bankaTableModel["Adi"] ?></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr class="b<?php echo $bankaTableModel["ID"] ?>">
                                                                                                                                            <td><b>ŞUBE</b></td>
                                                                                                                                            <td><?php echo $bankaTableModel["Sube"] ?></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr class="b<?php echo $bankaTableModel["ID"] ?>">
                                                                                                                                            <td><b>HESAP NO</b></td>
                                                                                                                                            <td><?php echo $bankaTableModel["HesapNo"] ?></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr class="b<?php echo $bankaTableModel["ID"] ?>">
                                                                                                                                            <td><b>IBAN NO</b></td>
                                                                                                                                            <td><?php echo $bankaTableModel["IbanNo"] ?></td>
                                                                                                                                        </tr>
                                                                                                                                        <tr class="b<?php echo $bankaTableModel["ID"] ?>">
                                                                                                                                            <td><b>ALICI</b></td>
                                                                                                                                            <td><?php echo $bankaTableModel["Alici"] ?></td>
                                                                                                                                        </tr>
                                                                                                                                    <?php } ?>
                                                                                                                                <?php } ?>
                                                                                                                            </tbody>
                                                                                                                        </table>
                                                                                                                        <p>
                                                                                                                            <span><input id="havaleSatisSoz" type="checkbox" name="havaleSatisSoz"> <a role="button" data-toggle="modal" data-target="#satisSozlesmesi" style="color:#FE980F;"> Mesafeli satış sözleşmesini ve</a><a role="button" data-toggle="modal" data-target="#onBilgilendirmeFormu" style="color:#FE980F;"> Ön Bilgilendirme Formunu</a> okudum, kabul ediyorum.</span>
                                                                                                                        </p>
                                                                                                                        <button class="btn btn-primary" id="spHavaleTamamla"><i class="fa fa-angle-right"></i> Siparişi Tamamla</button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div role="tabpanel" class="tab-pane" id="telefon">
                                                                                                                <br />
                                                                                                                <div class="col-sm-12 login-form">
                                                                                                                    <h2>Telefonla Ödeme</h2>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 col-xs-12 xsMarginBottom">
                                                                                                                    <div class="login-form">
                                                                                                                        <div class="form">
                                                                                                                            <p>Ortak kullanım yapılan alanlardan internete erişim sağlayıp, siparişinizi bu şekilde gerçekleştiriyorsanız telefon ile ödeme seçeneğini tercih edebilirsiniz.</p>

                                                                                                                            <p>Siparişinizin işleme konulabilmesi için "Siparişi Tamamla" butonuna tıkladıktan sonra kredi kartı bilgilerinizi ve sipariş numaranızı aşağıda yazılı olan telefon numarasını arayarak <b>turkiyefloracicek.com</b>'a ulaştırmanız gerekmektedir.</p>
                                                                                                                            <h2><i class="fa fa-phone-square"></i> 0352 232 23 32</h2>
                                                                                                                            <p>
                                                                                                                                <span><input id="telSatisSoz" type="checkbox" name="telSatisSoz" style="margin-top:3px;"> <a role="button" data-toggle="modal" data-target="#satisSozlesmesi" style="color:#FE980F;"> Mesafeli satış sözleşmesini ve</a><a role="button" data-toggle="modal" data-target="#onBilgilendirmeFormu" style="color:#FE980F;"> Ön Bilgilendirme Formunu</a> okudum, kabul ediyorum.</span>
                                                                                                                            </p>
                                                                                                                            <button class="btn btn-primary" id="spTelefonTamamla"><i class="fa fa-angle-right"></i> Siparişi Tamamla</button>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="col-sm-6 hidden-xs">
                                                                                                                    <img id="call-center-img" src="<?php echo SITE_IMAGES ?>/call-center-2.png" alt="Türkiye Flora Çiçek Call Center" style="margin-top:-15px;" />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            </div>
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
                                                                                                                    <p><?php echo Session::get("SipAdres") . ' ( +' . Session::get("SipIlceFiyat") . ' TL)'; ?><br /> <small><?php echo Session::get("SipTarih"); ?> <?php echo Session::get("SipGun"); ?> <span class="pull-right"><?php echo Session::get("SipSaat"); ?></span></small></p>
                                                                                                                    <hr />
                                                                                                                    <?php if (count($model[1]) > 0) { ?>
                                                                                                                        <ul class="ekurunler">
                                                                                                                            <?php foreach ($model[1] as $ekUrunModel) { ?>
                                                                                                                                <li id="uruncikar-4" data-ekid="<?php echo $ekUrunModel["EkID"] ?>"><?php echo $ekUrunModel["EkAdi"] ?><br>
                                                                                                                                    <small><?php echo $data["UrunKod"] ?> : <?php echo $ekUrunModel["EkKod"] ?></small>
                                                                                                                                    <span class="pull-right">
                                                                                                                                        <span class="ekurun-listefiyat"><?php echo $ekUrunModel["EkFiyat"] ?></span> TL </span>
                                                                                                                                </li>
                                                                                                                            <?php } ?>
                                                                                                                        </ul>
                                                                                                                    <?php } ?>
                                                                                                                    <hr />
                                                                                                                    <p><span class="pull-right" style="font-size:16px;">Toplam : <strong class="spTotal">45</strong> <strong>TL</strong></span></p>
                                                                                                                </div><!--/product-information-->
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </div>
                                                                                                            </section>

                                                                                                            <!-- Modal -->
                                                                                                            <div class="modal fade" id="satisSozlesmesi" tabindex="-1" role="dialog" aria-labelledby="uyelikSozlesmesiLabel">
                                                                                                                <div class="modal-dialog" role="document">
                                                                                                                    <div class="modal-content">
                                                                                                                        <div class="modal-header">
                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                            <h4 class="modal-title" id="uyelikSozlesmesiLabel"><?php echo $data["MesafeliSatis"]; ?></h4>
                                                                                                                        </div>
                                                                                                                        <div class="modal-body">
                                                                                                                            <?php echo $model[2][0]["Mesafe"]; ?>
                                                                                                                        </div>
                                                                                                                        <div class="modal-footer">
                                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $data["Kapat"]; ?></button>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <!-- Modal -->
                                                                                                            <div class="modal fade" id="onBilgilendirmeFormu" tabindex="-1" role="dialog" aria-labelledby="onBilgilendirmeFormuLabel">
                                                                                                                <div class="modal-dialog" role="document">
                                                                                                                    <div class="modal-content">
                                                                                                                        <div class="modal-header">
                                                                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                                                            <h4 class="modal-title" id="uyelikSozlesmesiLabel"><?php echo $data["OnBilgiForm"]; ?></h4>
                                                                                                                        </div>
                                                                                                                        <div class="modal-body">
                                                                                                                            <?php echo $model[2][1]["OnBilgi"]; ?>
                                                                                                                        </div>
                                                                                                                        <div class="modal-footer">
                                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $data["Kapat"]; ?></button>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                            <script type="text/javascript">
                                                                                                                $(document).ready(function () {
                                                                                                                    fiyatTopla();
                                                                                                                    $('[data-toggle="tooltip"]').tooltip();

                                                                                                                    // Banka havale formu

                                                                                                                    $(".bankainfo").find("tr").css("display", "none");

                                                                                                                    $("#banka").on("change", function () {
                                                                                                                        $(".bankainfo").find("tr").css("display", "none");
                                                                                                                        var val = $(this).val();
                                                                                                                        if (val != "0") {
                                                                                                                            $('tr.b' + val).fadeIn();
                                                                                                                        } else {
                                                                                                                            $(".bankainfo").find("tr").css("display", "none");
                                                                                                                        }
                                                                                                                    });

                                                                                                                    // Kredi kartı formu

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

                                                                                                                    $("#kartno").keyup(function () {
                                                                                                                        var kno = $(this).val();
                                                                                                                        var knl = kno.length;
                                                                                                                        var cn = "";
                                                                                                                        if (knl < 17) {
                                                                                                                            for (var i = 0; i < knl; i++) {
                                                                                                                                cn = cn + kno[i];
                                                                                                                                if ((i + 1) % 4 == 0) {
                                                                                                                                    cn = cn + "&nbsp;&nbsp;";
                                                                                                                                }
                                                                                                                            }
                                                                                                                            $(".cardNo").html(cn);
                                                                                                                        }

                                                                                                                    });

                                                                                                                    $("#kartAy").change(function () {
                                                                                                                        var kay = $(this).val();
                                                                                                                        $(".kartAy").html(kay + " / ");
                                                                                                                    });

                                                                                                                    $("#kartYil").change(function () {
                                                                                                                        var kyil = $(this).val();
                                                                                                                        $(".kartYil").html(kyil);
                                                                                                                    });

                                                                                                                    $("#cvv").focus(function () {
                                                                                                                        $(".creditCard").css("display", "none");
                                                                                                                        $(".creditCardBack").fadeIn("slow");
                                                                                                                    });

                                                                                                                    $("#cvv").focusout(function () {
                                                                                                                        $(".creditCardBack").css("display", "none");
                                                                                                                        $(".creditCard").fadeIn("slow");
                                                                                                                    });

                                                                                                                    $("#cvv").keyup(function () {
                                                                                                                        var cvv = $(this).val();
                                                                                                                        $(".cvv").html(cvv);
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
                                                                                                                });
                                                                                                            </script>
