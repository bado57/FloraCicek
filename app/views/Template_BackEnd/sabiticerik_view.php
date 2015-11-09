<script src="<?php echo SITE_JS; ?>/vitrin.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ayarlar
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <div class="col-xs-12">
                <!-- SABİT İÇERİK FORMU -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Web Site Bilgileri</h3>
                    </div>
                    <div class="box-body">
                        <form class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="telefon">Telefon</label>
                                    <input type="text" class="form-control" id="telefon" name="telefon" placeholder="Telefon" value="<?php echo $model[0]["Tel"]; ?>">
                                        <input type="hidden" name="hidtelefon" value="<?php echo $model[0]["Tel"]; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="fax">Fax</label>
                                                <input type="text" class="form-control" id="fax" name="fax" placeholder="Fax" value="<?php echo $model[0]["Fax"]; ?>">
                                                    <input type="hidden" name="hidfax" value="<?php echo $model[0]["Fax"]; ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="iletisimmail">İletişim Email</label>
                                                            <input type="email" class="form-control" id="iletisimmail" name="iletisimmail" placeholder="İletişim Emaili" value="<?php echo $model[0]["IletMail"]; ?>">
                                                                <input type="hidden" name="hidemail" value="<?php echo $model[0]["IletMail"]; ?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="harita">Harita iFrame</label>
                                                                        <input type="text" class="form-control" id="harita" name="harita" placeholder="Harita iFrame" value="<?php echo $model[0]["IFrame"]; ?>">
                                                                            <input type="hidden" name="hidharita" value="<?php echo $model[0]["IFrame"]; ?>">
                                                                                </div>
                                                                                </div><!-- /.col -->
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label for="facebook"><i class="fa fa-facebook-square"></i> Facebook</label>
                                                                                        <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Facebook Bağlantısı" value="<?php echo $model[0]["Face"]; ?>">
                                                                                            <input type="hidden" name="hidfacebook" value="<?php echo $model[0]["Face"]; ?>">
                                                                                                </div>
                                                                                                <div class="form-group">
                                                                                                    <label for="twitter"><i class="fa fa-twitter-square"></i> Twitter</label>
                                                                                                    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter Bağlantısı" value="<?php echo $model[0]["Twit"]; ?>">
                                                                                                        <input type="hidden" name="hidtwitter" value="<?php echo $model[0]["Twit"]; ?>">
                                                                                                            </div>
                                                                                                            <div class="form-group">
                                                                                                                <label for="instagram"><i class="fa fa-instagram"></i> İnstagram</label>
                                                                                                                <input type="text" class="form-control" id="instagram" name="instagram" placeholder="İnstagram Bağlantısı" value="<?php echo $model[0]["Instagram"]; ?>">
                                                                                                                    <input type="hidden" name="hidinstagram" value="<?php echo $model[0]["Instagram"]; ?>">
                                                                                                                        </div>
                                                                                                                        <div class="form-group">
                                                                                                                            <label for="googleplus"><i class="fa fa-google-plus-square"></i> Google +</label>
                                                                                                                            <input type="text" class="form-control" id="googleplus" name="googleplus" placeholder="Google + Bağlantısı" value="<?php echo $model[0]["GPlus"]; ?>">
                                                                                                                                <input type="hidden" name="hidgoogleplus" value="<?php echo $model[0]["GPlus"]; ?>">
                                                                                                                                    </div>
                                                                                                                                    </div><!-- /.col -->
                                                                                                                                    <div class="col-md-4">
                                                                                                                                        <div class="form-group" style="margin-bottom:10px;">
                                                                                                                                            <label for="adres">Adres</label>
                                                                                                                                            <textarea class="form-control" id="adres" name="adres" rows="5"><?php echo $model[0]["Adres"]; ?></textarea>
                                                                                                                                            <input type="hidden" name="hidadres" value="<?php echo $model[0]["Adres"]; ?>">
                                                                                                                                        </div>
                                                                                                                                        <div class="form-group">
                                                                                                                                            <label for="yoneticimail">Yönetici Takip Maili</label>
                                                                                                                                            <input type="email" class="form-control" id="yoneticimail" name="yoneticimail" placeholder="Yönetici Takip Maili" value="<?php echo $model[0]["YMail1"]; ?>">
                                                                                                                                                <input type="hidden" name="hidyoneticimail" value="<?php echo $model[0]["YMail1"]; ?>">
                                                                                                                                                    </div>
                                                                                                                                                    <div class="form-group">
                                                                                                                                                        <label for="yoneticimailek">Yönetici Takip Maili 2</label>
                                                                                                                                                        <input type="email" class="form-control" id="yoneticimailek" name="yoneticimailek" placeholder="Yönetici Takip Maili 2" value="<?php echo $model[0]["YMail2"]; ?>">
                                                                                                                                                            <input type="hidden" name="hidyoneticimailek" value="<?php echo $model[0]["YMail2"]; ?>">
                                                                                                                                                                </div>
                                                                                                                                                                <div class="form-group">
                                                                                                                                                                    <input id="sabiticerikkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                                                                                                                                    <input id="sabiticerikvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                                                                                                                                </div>
                                                                                                                                                                </div><!-- /.col -->
                                                                                                                                                                </form>
                                                                                                                                                                </div><!-- /.box-body -->
                                                                                                                                                                </div><!-- /.box -->
                                                                                                                                                                </div>
                                                                                                                                                                </div><!-- /.row (main row) -->
                                                                                                                                                                </section><!-- /.content -->
                                                                                                                                                                </div><!-- /İÇ SAYFA -->