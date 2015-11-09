<script src="<?php echo SITE_JS; ?>/icpanel.js" type="text/javascript"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Kategoriler
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
                                    <input name="duzenlemeUstID" type="hidden" value="" >
                                        <input name="normalSira" type="hidden" value="" >
                                            <input name="normalUstKategori" type="hidden" value="" >
                                                <input name="normalKategoriAd" type="hidden" value="" >
                                                    <h3 class="box-title"><span id=katustbaslik>Yeni</span> Kategori</h3>
                                                    <div class="box-tools pull-right">
                                                        <button id="btnkayanekleme" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                    </div>
                                                    </div><!-- /.box-header -->
                                                    <div class="box-body" id="kayanekleme">
                                                        <form class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="kategoriadi">Kategori Adı</label>
                                                                    <input type="text" class="form-control" id="kategoriadi" name="kategoriadi" placeholder="Kategori Adı">
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="ustkategori">Üst Kategori</label>
                                                                    <select class="form-control select2" id="ustkategori" name="ustkategori" style="width: 100%;">
                                                                        <option id="0select2" value="0">Üst Kategori Yok</option>
                                                                        <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                                                            <option value="<?php echo $model[1][$ustkat]['ID']; ?>"><?php echo $model[1][$ustkat]['Adi']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-sm-6 col-xs-12">
                                                                            <label for="aktiflik">Aktiflik</label>
                                                                            <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                                                <option value="1">Aktif</option>
                                                                                <option value="0">Pasif</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-6 col-xs-12">
                                                                            <label for="sira">Sıra</label>
                                                                            <input type="number" min="1" class="form-control" id="sira" name="sira" placeholder="Sıra">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div><!-- /.col -->
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="kategoriyazisi">Kategori Yazısı</label>
                                                                    <textarea rows="6" class="form-control" id="kategoriyazisi" name="kategoriyazisi" placeholder="Kategori Yazısı" style="resize: none;"></textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <input id="kaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                                    <input id="vazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                                </div>
                                                            </div><!-- /.col -->
                                                        </form><!-- /.row -->
                                                    </div><!-- /.box-body -->
                                                    </div>
                                                    <!-- LİSTE -->
                                                    <div class="box box-info">
                                                        <div class="box-header with-border">
                                                            <h3 class="box-title">Kategoriler</h3>
                                                        </div>
                                                        <div class="box-body">
                                                            <table class="table table-bordered table-hover TreeGrid">
                                                                <thead style="background:#e6e6e6;">
                                                                    <tr>
                                                                        <th>Kategori Adı</th>
                                                                        <th>Aktiflik</th>
                                                                        <th>Sıra</th>
                                                                        <th class="text-right">İşlemler</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="" id="tabletbody">
                                                                    <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                                                        <tr id="<?php echo $model[1][$ustkat]['ID']; ?>" class="treegrid-<?php echo $model[1][$ustkat]['ID']; ?>" data-ust="0">
                                                                    <input name="<?php echo $model[1][$ustkat]['ID']; ?>" type="hidden" value="<?php echo $model[1][$ustkat]['Yazi']; ?>" >
                                                                        <td id="katad<?php echo $model[1][$ustkat]['ID']; ?>" data-katad="<?php echo $model[1][$ustkat]['Adi']; ?>"><b><?php echo $model[1][$ustkat]['Adi']; ?></b></td>
                                                                        <td id="katdurum<?php echo $model[1][$ustkat]['ID']; ?>" data-aktif="<?php echo $model[1][$ustkat]['Aktif']; ?>"><?php echo $model[1][$ustkat]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                        <td id="katsira<?php echo $model[1][$ustkat]['ID']; ?>"><?php echo $model[1][$ustkat]['Sira']; ?></td>
                                                                        <td class="text-right">
                                                                            <a id="KatDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                            <a id="KatSilme" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                                                        </td>
                                                                        </tr>
                                                                        <?php for ($altkat = 0; $altkat < count($model[2][$ustkat]); $altkat++) { ?>
                                                                            <tr id="<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" class="treegrid-<?php echo $model[2][$ustkat][$altkat]['ID']; ?> treegrid-parent-<?php echo $model[1][$ustkat]['ID']; ?>" data-ust="<?php echo $model[1][$ustkat]['ID']; ?>">
                                                                            <input name="<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" type="hidden" value="<?php echo $model[2][$ustkat][$altkat]['Yazi']; ?>" >
                                                                                <td id="katad<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" data-katad="<?php echo $model[2][$ustkat][$altkat]['Adi']; ?>"><?php echo $model[2][$ustkat][$altkat]['Adi']; ?></td>
                                                                                <td id="katdurum<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" data-aktif="<?php echo $model[2][$ustkat][$altkat]['Aktif']; ?>"><?php echo $model[2][$ustkat][$altkat]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                                <td id="katsira<?php echo $model[2][$ustkat][$altkat]['ID']; ?>"><?php echo $model[2][$ustkat][$altkat]['Sira']; ?></td>
                                                                                <td class="text-right">
                                                                                    <a id="KatDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                                    <a id="KatSilme" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                                                                </td>
                                                                                </tr>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                        </tbody>
                                                                        </table>
                                                                        </div><!-- /.box-body -->
                                                                        </div><!-- /.box -->
                                                                        </div>
                                                                        </div><!-- /.row (main row) -->
                                                                        </section><!-- /.content -->
                                                                        </div><!-- /İÇ SAYFA -->