<script src="<?php echo SITE_JS; ?>/uye.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kurumsal Üyeler 
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
                                    <h3 class="box-title"><span id=kuyeustbaslik>Üye</span> Bilgileri</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleKurumsalUye" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body" id="uyeBilgiler">
                                        <div class="col-md-1 hidden-xs text-center" style="background-color: #61696D; padding: 30px 15px;">
                                            <i class="fa fa-briefcase" style="font-size: 80px; color: #e6e6e6;"></i>
                                        </div><!-- /.col -->
                                        <div class="col-md-3 col-xs-12">
                                            <table class="table table-responsive table-hover table-bordered table-condensed">
                                                <thead class="bg-gray-light">
                                                    <tr>
                                                        <th colspan="2"><b>Üyelik Bilgileri</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><b>Ad Soyad</b></td>
                                                        <td>Sn. <b id="kuyeadSoyad"></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Durum</b></td>
                                                        <td>Kurumsal Üye</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Üyelik Tarihi</b></td>
                                                        <td id="kuyetarih"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Kurum Adı</b></td>
                                                        <td id="kuyekurumad"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Kurum Telefon</b></td>
                                                        <td id="kuyekurumtel"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>E-mail</b></td>
                                                        <td id="kuyeemail"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Telefon</b></td>
                                                        <td id="kuyetel"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Adres</b></td>
                                                        <td id="kuyeadres"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Vergi Dairesi</b></td>
                                                        <td id="kuyevd"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Vergi No</b></td>
                                                        <td id="kuyevno"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-8 col-xs-12" id="uyelikBilgiSiparis">
                                            <table class="table table-responsive table-hover table-bordered table-condensed">
                                                <thead class="bg-gray-light">
                                                    <tr>
                                                        <th colspan="4" class="text-danger"><i class="fa fa-warning" style="margin-right: 8px;"></i> <span id="headtoplamSip"></span> alışverişte toplam <span id="headtoplamTutar"></span> TL tutarında satış yapıldı.</th>
                                                </tr>
                                                <tr>
                                                    <th><b>Sipariş No</b></th>
                                                    <th><b>Tarih</b></th>
                                                    <th><b>Toplam Tutar</b></th>
                                                    <th><b>İşlemler</b></th>
                                                </tr>
                                                </thead>
                                                <tbody id="kurSipTable">
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <input id="uyeDetayKapat" type="button" value="Kapat" class="btn btn-default pull-right" />
                                            </div>
                                        </div><!-- /.col -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Kurumsal Üye Listesi</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="kuyeTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Ad Soyad</th>
                                                        <th class="hidden-xs">E-Posta</th>
                                                        <th class="hidden-xs">Telefon</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="">
                                                    <?php for ($kuye = 0; $kuye < count($model); $kuye++) { ?>
                                                        <tr id="<?php echo $model[$kuye]['ID']; ?>">
                                                            <td><?php echo $model[$kuye]['Adi']; ?></td>
                                                            <td class="hidden-xs"><?php echo $model[$kuye]['EPosta']; ?></td>
                                                            <td class="hidden-xs"><?php echo $model[$kuye]['Tel']; ?></td>
                                                            <td class="text-right">
                                                                <a id="kuyeDetay" class="btn btn-primary btn-sm" title="Üye Detayları"><i class="fa fa-eye"></i></a>
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