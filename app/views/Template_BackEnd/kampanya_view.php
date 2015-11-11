<script src="<?php echo SITE_JS; ?>/kampanya.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kampanya
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
                                    <h3 class="box-title"><span id=kampanyaustbaslik>Yeni</span> Kampanya</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleKampanya" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="kampanyabaslik">Kampanya Başlığı</label>
                                                            <input type="text" class="form-control" id="kampanyabaslik" name="kampanyabaslik" placeholder="Kampanya Başlığı">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="baslamatarihi">Başlama Tarihi</label>
                                                            <div class="input-group">
                                                                <input type="text" id="baslamatarihi" class="form-control" placeholder="Başlama Tarihi">
                                                                    <span class="input-group-btn">
                                                                        <button id="baslamatarihBtn" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.col -->
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="aktiflik">Aktiflik</label>
                                                            <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                                <option value="1">Aktif</option>
                                                                <option value="0">Pasif</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="bitistarihi">Bitiş Tarihi</label>
                                                            <div class="input-group">
                                                                <input type="text" id="bitistarihi" class="form-control" placeholder="Bitiş Tarihi">
                                                                    <span class="input-group-btn">
                                                                        <button id="bitistarihBtn" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="indirimyuzde">İndirim Tutarı</label>
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><b>%</b></span>
                                                                <input type="text" id="indirimyuzde" name="indirimyuzde" class="form-control" placeholder="İndirim Tutarı (%)">
                                                            </div>
                                                        </div>
                                                        <div class="form-group has-warning" style="display:none;">
                                                            <label class="control-label" id="kampanyaUyari"><i class="fa fa-warning"></i> UYARI : Seçeceğiniz kategorilerdeki tüm ürünlerde <b id="ind" style="font-size:18px;"></b> indirim yapılacak !</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kategoriler">Kategoriler</label>
                                                            <select class="form-control select2" multiple="multiple" data-placeholder="Kategori Seçiniz" id="kategoriler" name="kategoriler" style="width: 100%;">
                                                                <option>Güller</option>
                                                                <option>Orkideler</option>
                                                                <option>Buketler</option>
                                                                <option>Aranjmanlar</option>
                                                                <option>Çelenkler</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kampanyayazi">Kampanya Tanıtım Yazısı</label>
                                                    <textarea class="form-control" id="kampanyayazi" name="kampanyayazi"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input id="kampanyakaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                    <input id="kampanyavazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                </div>
                                            </div><!-- /.col -->
                                        </form><!-- /.row -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Kampanyalar</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="kampanyaTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Kampanya Başlığı</th>
                                                        <th>İndirim Tutarı</th>
                                                        <th>Durum</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($kmpnya = 0; $kmpnya < count($model); $kmpnya++) { ?>
                                                        <?php if ($model[$kmpnya]['Aktif'] == "0") { ?>
                                                            <tr id="<?php echo $model[$kmpnya]['ID']; ?>">
                                                            <?php } else { ?>
                                                            <tr id="<?php echo $model[$kmpnya]['ID']; ?>" class="text-green">
                                                            <?php } ?>
                                                            <td><b><?php echo $model[$kmpnya]['Baslik']; ?></b></td>
                                                            <td>% <?php echo $model[$kmpnya]['Yuzde']; ?></td>
                                                            <?php if ($model[$kmpnya]['Aktif'] == "0") { ?>
                                                                <td id="kampanyaaktif<?php echo $model[$kmpnya]['ID']; ?>" data-aktif="<?php echo $model[$kmpnya]['Aktif']; ?>">Bitti</td>
                                                            <?php } else { ?>
                                                                <td id="kampanyaaktif<?php echo $model[$kmpnya]['ID']; ?>" data-aktif="<?php echo $model[$kmpnya]['Aktif']; ?>">Devam Ediyor</td>
                                                            <?php } ?>
                                                            <td class="text-right">
                                                                <a id="kampanyaDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                <a id="kampanyaSil" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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

