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
                <div class="defaultDiv" style="max-width:210px; margin: -9px 20px 0 0;"> <a href="<?php echo SITE_URL; ?>"><img class="img-responsive" src="<?php echo SITE_VITRIN . "/" . $model[0][0]['Logo']; ?>" alt="" /></a></div>
                <div class="wizard"><div class="step">1</div> <span><?php echo $data["EkUrun"]; ?></span></div>
                <?php if (Session::get("KID") > 0) { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } else { ?>
                    <div class="wizard"><div class="step">2</div> <span><?php echo $data["UyeGiris"]; ?></span></div>
                    <div class="wizard"><div class="step">3</div> <span><?php echo $data["TesBilgi"]; ?></span></div>
                    <div class="wizard"><div class="step">4</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <?php } ?>
                <div class="wizard activeStep"><div class="step"><i class="fa fa-check"></i></div> <span><?php echo $data["SipOnay"]; ?></span></div>
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
                                    
                                    <!--Kredi Kartı ile ödeme-->
                                    <div class="login-form" id="formgirisyap">
                                        <!--Ödeme onayı-->
                                        <h2>Siparişiniz alınmıştır. Sipariş Numaranız : <strong>056852</strong></h2>
                                        <!--End Ödeme onayı-->
                                        <!--Ödeme Hata-->
                                        <h2>Bir hata meydana geldi : "<!--Bankadan dönen koda göre mesaj yazılacak. Yetersiz Bakiye vs.-->"</h2>
                                        <!--End Ödeme Hata-->
                                        <hr/>
                                        <div class="form" style="padding-bottom:30px;">
                                            <!--Ödeme onayı-->
                                            <h4>Ödeme Türü : <b>Kredi Kartı</b> - Sipariş tutarı : <b>55 TL</b></h4>
                                            <p>Siparişiniz başarıyla tamamlanmıştır. Sipariş numaranızı kaydetmeyi unutmayınız. Bu numara ile <a href="#">Anasayfa'dan</a> siparişinizin takibini yapabilirsiniz.</p>
                                            <!--End Ödeme onayı-->
                                            <!--Ödeme Hata-->
                                            <p>Siparişinizin tamamlanması sırasında bir hata meydana geldi. Bankanızdan gelen mesaj aşağıdaki gibidir.</p>
                                            <p><b>"<!--Bankadan dönen koda göre mesaj yazılacak. Yetersiz Bakiye vs.-->"</b></p>
                                            <!--End Ödeme Hata-->
                                            <!--Üye değilse-->
                                            <p>Sitemize üye olarak bir çok avantaj ve indirimlerden yararlanabilirsiniz.</p>
                                            <button type="button" class="btn btn-default" id="uyeOl" style="position:relative; display:inline-block; margin-right:10px;"><i class="fa fa-angle-right"></i> Üye Ol</button>
                                            <!--End Üye değilse-->
                                            <button type="button" id="gotoHome" class="btn btn-success pull-right" style="position:relative; display:inline-block; background-color:#0ca40b;"><i class="fa fa-angle-left"></i> Anasayfaya dön</button>
                                        </div>
                                    </div>
                                    <!--End Kredi Kartı ile ödeme-->
                                    
                                    <!--Havale ile ödeme-->
                                    <div class="login-form" id="formgirisyap">
                                        <!--Sipariş onayı-->
                                        <h2>Siparişiniz alınmıştır. Sipariş Numaranız : <strong>056852</strong></h2>
                                        <!--End Sipariş onayı-->
                                        <!--Sipariş Hata-->
                                        <h2>Bir hata meydana geldi.</h2>
                                        <!--End Sipariş Hata-->
                                        <hr/>
                                        <div class="form" style="padding-bottom:30px;">
                                            <!--Sipariş onayı-->
                                            <h4>Ödeme Türü : <b>Banka Havalesi</b> - Sipariş tutarı : <b>55 TL</b></h4>
                                            <p>Seçmiş olduğunuz banka hesabına havale işlemi gerçekleştikten sonra siparişiniz onaylanacaktır.</p>
                                            <p><b style="color:red;"><i class="fa fa-warning"></i> Uyarı</b></p>
                                            <p>Siparişinizin onaylanması için <b style="color:red;">155225</b> olan sipariş numaranızı Adınız Soyadınız ile birlikte havale açıklamasına yazmayı unutmayınız.</p>
                                            <p>Sipariş numaranızı kaydetmeyi unutmayınız. Bu numara ile <a href="#">Anasayfa'dan</a> siparişinizin takibini yapabilirsiniz. Banka hesap bilgilerimizi görmek için lütfen seçim yapınız.</p>
                                            <select id="banka">
                                                    <option value="0">Banka Seçiniz</option>
                                                    <?php if (count($model[4]) > 0) { ?>
                                                        <?php foreach ($model[4] as $bankaIsımModel) { ?>
                                                            <option value="<?php echo $bankaIsımModel["ID"] ?>"><?php echo $bankaIsımModel["Adi"] ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                            </select>
                                            <hr/>
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
                                            </div>
                                            <!--End Sipariş onayı-->
                                            <!--Sipariş Hata-->
                                            <p>Üzgünüz. Siparişinizin alınması sırasında bir hata meydana geldi. Tekrar denemek üzere bir önceki sayfaya yönlendiriliyorsunuz.</p>
                                            <p>Tarayıcınız desteklemiyorsa bir önceki sayfaya dönmek için <a href="#"><b>buraya</b></a> tıklayınız.</p>
                                            <!--End Sipariş Hata-->
                                            <!--Üye değilse-->
                                            <p>Sitemize üye olarak bir çok avantaj ve indirimlerden yararlanabilirsiniz.</p>
                                            <button type="button" class="btn btn-default" id="uyeOl" style="position:relative; display:inline-block; margin-right:10px;"><i class="fa fa-angle-right"></i> Üye Ol</button>
                                            <!--End Üye değilse-->
                                            <button type="button" id="gotoHome" class="btn btn-success pull-right" style="position:relative; display:inline-block; background-color:#0ca40b;"><i class="fa fa-angle-left"></i> Anasayfaya dön</button>
                                        </div>
                                    </div>
                                    <!--End Havale ile ödeme-->
                                    
                                    <!--Telefonla ödeme-->
                                    <div class="login-form" id="formgirisyap">
                                        <!--Sipariş onayı-->
                                        <h2>Siparişiniz alınmıştır. Sipariş Numaranız : <strong>056852</strong></h2>
                                        <!--End Sipariş onayı-->
                                        <!--Sipariş Hata-->
                                        <h2>Bir hata meydana geldi.</h2>
                                        <!--End Sipariş Hata-->
                                        <hr/>
                                        <div class="form" style="padding-bottom:30px;">
                                            <!--Ödeme onayı-->
                                            <h4>Ödeme Türü : <b>Telefon</b> - Sipariş tutarı : <b>55 TL</b></h4>
                                            <p><b style="color:red;"><i class="fa fa-warning"></i> Uyarı</b></p>
                                            <p>Siparişinizin onaylanması için aşağıda belirtilen çağrı merkezi numaramızı arayarak kredi kartı bilgilerinizi ve <b style="color:red;">155225</b> olan sipariş numaranızı <b>turkiyefloracicek.com</b>'a iletmeniz gerekmektedir.</p>
                                            <h2><i class="fa fa-phone-square"></i> Çağrı Merkezi : <b>0352 232 23 32</b></h2>
                                            <p>Sipariş numaranızı kaydetmeyi unutmayınız. Bu numara ile <a href="#">Anasayfa'dan</a> siparişinizin takibini yapabilirsiniz.</p>
                                            <!--End Ödeme onayı-->
                                            <!--Sipariş Hata-->
                                            <p>Üzgünüz. Siparişinizin alınması sırasında bir hata meydana geldi. Tekrar denemek üzere bir önceki sayfaya yönlendiriliyorsunuz.</p>
                                            <p>Tarayıcınız desteklemiyorsa bir önceki sayfaya dönmek için <a href="#"><b>buraya</b></a> tıklayınız.</p>
                                            <!--End Sipariş Hata-->
                                            <!--Üye değilse-->
                                            <p>Sitemize üye olarak bir çok avantaj ve indirimlerden yararlanabilirsiniz.</p>
                                            <button type="button" class="btn btn-default" id="uyeOl" style="position:relative; display:inline-block; margin-right:10px;"><i class="fa fa-angle-right"></i> Üye Ol</button>
                                            <!--End Üye değilse-->
                                            <button type="button" id="gotoHome" class="btn btn-success pull-right" style="position:relative; display:inline-block; background-color:#0ca40b;"><i class="fa fa-angle-left"></i> Anasayfaya dön</button>
                                        </div>
                                    </div>
                                    <!--End Telefonla ödeme-->
                                    
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


