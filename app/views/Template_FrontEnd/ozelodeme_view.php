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
                <div class="wizard activeStep"><div class="step">1</div> <span><?php echo $data["OdeBilgi"]; ?></span></div>
                <div class="wizard"><div class="step"><i class="fa fa-check"></i></div> <span><?php echo $data["OdeOnay"]; ?></span></div>
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
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="kart">
                                    <br />
                                    <div class="col-sm-12 login-form">
                                        <h2><?php echo $data["KartBilgi"]; ?></h2>
                                    </div>
                                    <form method="post" action="https://entegrasyon.asseco-see.com.tr/fim/est3Dgate" id="urunozelkartodeme">
                                        <div class="col-sm-6 col-xs-12 xsMarginBottom">
                                            <div class="login-form">
                                                <div class="form">
                                                    <p><?php echo $data["KartNum"]; ?></p>
                                                    <input id="kartno" name="pan" type="text" placeholder="Kart Numarası" data-inputmask='"mask": "9999999999999999"' data-mask maxlength="16" />
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
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                                <option value="24">24</option>
                                                                <option value="25">25</option>
                                                                <option value="26">26</option>
                                                                <option value="27">27</option>
                                                                <option value="28">28</option>
                                                                <option value="29">29</option>
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
                                                    <input id="oid" name="oid" type="text" placeholder="Varsa Sipariş Numarası" />
                                                    <input id="amount" name="amount" type="text" placeholder="Ödenecek Tutar (TL)" />
                                                    <textarea id="aciklama" name="desc1" rows="3" placeholder="Açıklama"></textarea>
                                                    <input type="hidden" name="clientid" value="<?php echo $model[5][0]['ClientID']; ?>">
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
                                                                                                    <button class="btn btn-primary" id="spKartTamamla"><i class="fa fa-angle-right"></i> Ödeme Yap</button>
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
                                                                                                    </div>
                                                                                                    </div>
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

                                                                                                            $('[data-toggle="tooltip"]').tooltip();

                                                                                                            // Kredi kartı formu

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
                                                                                                        });
                                                                                                    </script>


