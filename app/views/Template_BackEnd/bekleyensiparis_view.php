<script src="<?php echo SITE_JS; ?>/siparis.js" type="text/javascript"></script>
<script src="<?php echo SITE_JS; ?>/icpanel.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Siparişler <span class="text-danger"> / <?php echo $model[2]; ?> Bekleyen</span>
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <div class="col-xs-12">
                <!-- EKLEME DÜZENLEME FORMU -->
                <div class="box box-success collapsed-box">
                    <div class="box-header with-border">
                        <input name="kapaliacik" type="hidden" value="0" >
                            <input name="duzenleme" type="hidden" value="" >
                                <input name="duzenlemeID" type="hidden" value="" >
                                    <h3 class="box-title"><i class="fa fa-shopping-cart"></i> <span id=siparisustbaslik></span> Sipariş Detayı</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleSiparis" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="row urunForm">
                                            <div class="col-md-3">
                                                <div class="box box-success">
                                                    <div class="box-header with-border text-green">
                                                        Sipariş Bİlgileri
                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="padding:0;">
                                                        <table id="siparisbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                            <tr>
                                                                <td><b>Sipariş No</b></td>
                                                                <td class="sipno"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sipariş Tarihi</b></td>
                                                                <td class="siptarih"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Toplam Tutar</b></td>
                                                                <td><b><span class="siptutar"></span> TL</b></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Ödeme</b></td>
                                                                <td class="sipOdeme"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="box box-success">
                                                    <div class="box-header with-border text-green">
                                                        Ürünler
                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="padding:0;">
                                                        <table id="urunbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>
                                                                        <b>Ürün Kodu / Adı</b>
                                                                    </th>
                                                                    <th>
                                                                        <b>Birim Fiyatı</b>
                                                                    </th>
                                                                    <th>
                                                                        <b>Miktar</b>
                                                                    </th>
                                                                    <th>
                                                                        <b>Tutar</b>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="urunSip">
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <td colspan="4" class="text-right"><b>Toplam : <span class="uruntoplamtutar"></span> TL</b></td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="box box-info">
                                                    <div class="box-header with-border text-aqua">
                                                        Müşteri / Üye Bilgileri
                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="padding:0;">
                                                        <table id="müsteribilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                            <tr>
                                                                <td><b>Ad Soyad</b></td>
                                                                <td class="gndad"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Telefon</b></td>
                                                                <td class="gndtel"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Email</b></td>
                                                                <td class="gndmail"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Üyelik Durumu</b></td>
                                                                <td><span class="gndtip"></span></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="box box-info">
                                                    <div class="box-header with-border text-aqua">
                                                        Fatura Bilgileri
                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="padding:0;">
                                                        <table id="faturabilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                            <tr>
                                                                <td><b>Ünvan</b></td>
                                                                <td class="ftrunvn"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>TC No</b></td>
                                                                <td class="ftrtc"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Vergi D.</b></td>
                                                                <td class="ftrvdaire"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Vergi No</b></td>
                                                                <td class="ftrvno"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Adres</b></td>
                                                                <td class="ftradres"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="box box-danger">
                                                    <div class="box-header with-border text-red">
                                                        Teslimat Bilgileri
                                                        <div class="box-tools pull-right">
                                                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                    <div class="box-body" style="padding:0;">
                                                        <table id="teslimatbilgileri" class="table table-responsive table-hover table-condensed table-bordered" style="margin-bottom:0;">
                                                            <tr>
                                                                <td><b>Alıcı</b></td>
                                                                <td class="aliciad"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Telefon</b></td>
                                                                <td class="alicitel"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Teslimat Tarihi</b></td>
                                                                <td><span class="tslmttarih"></span> (<span class="tslmsaat"></span>)</td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Gideceği Yer</b></td>
                                                                <td class="tslimtyer"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Adres</b></td>
                                                                <td class="tslimtadres"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Adres Tarifi</b></td>
                                                                <td class="tslmtadrestrf"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Sipariş Notu</b></td>
                                                                <td class="tslmtnot"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Kart Mesajı</b></td>
                                                                <td class="tslmtkartmsj"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Kart İsim</b></td>
                                                                <td class="tslmtkartisim"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>İsim Göster</b></td>
                                                                <td class="tslmtisimgrnme"></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Gönderim Nedeni</b></td>
                                                                <td class="tslmtgndndn"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <h4>Sipariş Durumu</h4>
                                                <hr />
                                                <div class="form-group">
                                                    <label for="siparisdurum">Sipariş Durumu</label>
                                                    <select class="form-control select2" id="siparisdurum" name="siparisdurum" style="width: 100%;">
                                                        <option value="-1">Seçiniz</option>
                                                        <option value="0">Bekliyor</option>
                                                        <option value="1">Hazırlanıyor</option>
                                                        <option value="4">Kuryeye Verildi</option>
                                                        <option value="3">Kargoya Verildi</option>
                                                        <option value="2">Teslim Edildi</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="siparisaciklama">Sipariş Açıklaması</label>
                                                    <textarea rows="3" class="form-control nock" id="siparisaciklama" name="siparisaciklama" placeholder="Sipariş Açıklaması" style="resize: none"></textarea>
                                                </div>
                                                <div class="kargoForm form-group" style="display:none;">
                                                    <label for="kargofirma">Kargo Firması</label>
                                                    <select class="form-control select2" id="kargofirma" name="kargofirma" style="width: 100%;">
                                                        <option value="-1">Seçiniz</option>
                                                        <?php for ($kargo = 0; $kargo < count($model[1]); $kargo++) { ?>
                                                            <option value="<?php echo $model[1][$kargo]['ID']; ?>"><?php echo $model[1][$kargo]['Adi']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="kargoForm form-group" style="display:none;">
                                                    <label for="kargotakipno">Kargo Takip No</label>
                                                    <input type="text" class="form-control" id="kargotakipno" name="kargotakipno" placeholder="Kargo Takip No" />
                                                </div>
                                                <div class="form-group">
                                                    <input id="sipariskaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                    <input id="siparisvazgec" type="button" value="Kapat" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                    <input data-print-target=".printable" data-print-title="Sipariş Detayı" type="button" value="Yazdır" class="printBtn btn btn-warning pull-right" style="margin-right: 10px;"/>
                                                </div>
                                            </div>
                                        </form><!-- /.row -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Siparişler</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="siparisTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Sipariş No</th>
                                                        <th>Tarih</th>
                                                        <th>Kimden</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <?php for ($siparis = 0; $siparis < count($model[0]); $siparis++) { ?>
                                                        <?php if ($model[0][$siparis]["Durum"] == 0) { ?>
                                                            <tr id="<?php echo $model[0][$siparis]['ID']; ?>" data-durum="<?php echo $model[0][$siparis]["Durum"]; ?>" class="text-red">
                                                            <?php } else if ($model[0][$siparis]["Durum"] == 1) { ?>
                                                            <tr id="<?php echo $model[0][$siparis]['ID']; ?>" data-durum="<?php echo $model[0][$siparis]["Durum"]; ?>" class="text-orange">
                                                            <?php } else { ?>
                                                            <tr id="<?php echo $model[0][$siparis]['ID']; ?>" data-durum="<?php echo $model[0][$siparis]["Durum"]; ?>" class="text-green">
                                                            <?php } ?>
                                                            <td><?php echo $model[0][$siparis]["No"]; ?></td>
                                                            <td><?php echo $model[0][$siparis]["Tarih"]; ?></td>
                                                            <?php if ($model[0][$siparis]["Tip"] == 0) { ?>
                                                                <td><i class="fa fa-user"></i> <?php echo $model[0][$siparis]["Ad"]; ?></td>
                                                    <?php } else if ($model[0][$siparis]["Tip"] == 1) { ?>
                                                        <td><i class="fa fa-admin"></i> <?php echo $model[0][$siparis]["Ad"]; ?></td>
                                                    <?php } else if ($model[0][$siparis]["Tip"] == 2) { ?>
                                                        <td><i class="fa fa-briefcase"></i> <?php echo $model[0][$siparis]["Ad"]; ?></td>
                                                    <?php } else if ($model[0][$siparis]["Tip"] == 3) { ?>
                                                        <td><i class="fa fa-square"></i> <?php echo $model[0][$siparis]["Ad"]; ?></td>
                                                    <?php } ?>
                                                    <td class="text-right">
                                                        <a id="siparisduzenle" class="btn btn-primary btn-sm" title="İşlemler"><i class="fa fa-search"></i></a>
                                                    </td>
                                                    </tr>
                                                <?php } ?>
                                                </tbody>
                                            </table>
                                        </div><!-- /.box-body -->
                                    </div><!-- /.box -->
                                    </div>
                                    </div><!-- /.row (main row) -->
                                    </section><!-- /.content -->
                                    </div><!-- /İÇ SAYFA -->


                                    <!-- /İÇ SAYFA -->
                                    <div class="printable" style="width:21cm; height:auto; padding: 1.1cm; background: #fff; border:2px solid #e6e6e6; font-family: Arial; display: none;">
                                        <table style="width:100%;">
                                            <tr>
                                                <td><img src="https://www.turkiyefloracicek.com/vitrin/logo.png" alt="www.turkiyefloracicek.com" style="width:auto; height: 1cm;" /></td>
                                            <td valign="middle" style="font-size: 12pt;"><div style="text-align: right;">Sipariş Detayı : 458962 </div></td>
                                            </tr>
                                        </table>
                                        <br/>
                                        <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; margin-bottom: 0.2cm;"></div>
                                        <table style="width:100%;">
                                            <tr>
                                                <td valign="top" style="width: 33%;">
                                            <div style="padding: 0.2cm; border:1px solid #e6e6e6; height: 100%;">
                                                <font style="font-size: 10pt; font-weight: bold; color: #D20F0F;">Sipariş Bilgileri</font> <br/>
                                                <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; padding-bottom: 0.2cm;"></div>
                                                <font style="font-size: 9pt;line-height: 14pt;">
                                                <b>Sipariş No :</b> <span class="sipno"></span> <br/>
                                                <b>Sipariş Tarihi :</b> <span class="siptarih"></span> <br/>
                                                <b>Sipariş Saati :</b> <span class="tslmsaat"></span> <br/>
                                                <b>Toplam Tutar :</b> <span class="siptutar"></span> TL <br/>
                                                <b>Ödeme Şekli :</b> <span class="sipOdeme"></span> <br/>
                                                <b>Kart Mesajı :</b> <span class="tslmtkartmsj"></span> <br/>
                                                <b>Kart İsim :</b> <span class="tslmtkartisim"></span> <br/>
                                                <b>Kart İsmi :</b> <span class="tslmtisimgrnme"></span> <br/>
                                                <b>Sipariş Notu :</b> <span class="tslmtnot"></span> <br/>
                                                </font>
                                            </div>
                                            </td>

                                            <td valign="top" style="padding-left: 0.2cm; width: 33%;">
                                            <div style="padding: 0.2cm; border:1px solid #e6e6e6; height: 100%;"> 
                                                <font style="font-size: 10pt; font-weight: bold; color: #D20F0F;">Teslimat Bilgileri</font> <br/>
                                                <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; padding-bottom: 0.2cm;"></div>
                                                <font style="font-size: 9pt;line-height: 14pt;">
                                                <b>Alıcı Ad Soyad :</b> <span class="aliciad"></span> <br/>
                                                <b>Telefon :</b> <span class="alicitel"></span> <br/>
                                                <b>Adres :</b> <b class="tslimtyer">Ev</b> <span class="tslimtadres"></span> <br/>
                                                <b>Adres Tarifi :</b> <span class="tslmtadrestrf"></span> <br/>
                                                <b>Teslimat Tarihi :</b> <span class="tslmttarih"></span> <br/>
                                                <b>Teslimat Saati :</b> <span class="tslmsaat"></span> <br/>
                                                </font>
                                            </div>
                                            </td>
                                            <td valign="top" style="padding-left: 0.2cm; width: 33%;">
                                            <div style="padding: 0.2cm; border:1px solid #e6e6e6; height: 100%;">
                                                <font style="font-size: 10pt; font-weight: bold; color: #D20F0F;">Gönderici Bilgileri</font> <br/>
                                                <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; padding-bottom: 0.2cm;"></div>
                                                <font style="font-size: 9pt;line-height: 14pt;">
                                                <b>Ad Soyad :</b> <span class="gndad"></span> <br/>
                                                <b>Üyelik :</b> <span class="gndtip"></span> <br/>
                                                <b>Telefon :</b> <span class="gndtel"></span> <br/>
                                                <b>E-mail :</b> <span class="gndmail"></span> <br/>
                                                <b>Fatura Ünvanı :</b> <span class="ftrunvn"></span> <br/>
                                                <b>TC Kimlik No :</b> <span class="ftrtc"></span> <br/>
                                                <b>Vergi Dairesi :</b> <span class="ftrvdaire"></span> <br/>
                                                <b>Vergi No :</b> <span class="ftrvno"></span> <br/>
                                                <b>Fatura Adresi :</b> <span class="ftradres"></span> <br/>
                                                </font>
                                            </div>
                                            </td>
                                            </tr>
                                        </table>
                                        <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; margin-bottom: 0.2cm;"></div>
                                        <table style="width:100%;">
                                            <tr>
                                                <td valign="top">
                                                    <font style="font-size: 10pt; font-weight: bold; color: #D20F0F;">Ürün Bilgileri</font> <br/>
                                            <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; padding-bottom: 0.2cm;"></div>
                                            </td>
                                            </tr>
                                            <tr>
                                                <td valign="top" id="urunSipPrint"></td>
                                            </tr>
                                        </table>
                                        <div style="border-bottom: 1px solid #e6e6e6; height: 0.2cm; margin-bottom: 0.2cm;"></div>
                                        <table style="width:100%; border:0.1cm solid #e6e6e6;">
                                            <tr>
                                                <td class="spPrintFooter" style="font-size: 9pt;"></td>
                                                <td style="text-align: right;">
                                                    <b class="spTotalFooter"></b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>