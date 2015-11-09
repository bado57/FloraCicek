<script src="<?php echo SITE_JS; ?>/vitrin.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<style type="text/css">
    .hidden-first {
        display: none;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Sayfalar
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
                                                <h3 class="box-title"><span id=sayfaustbaslik>Yeni</span> Sayfa</h3>
                                                <div class="box-tools pull-right">
                                                    <button id="formToggleSayfa" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                                </div>
                                                </div>
                                                <div class="box-body">
                                                    <form class="row urunForm">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <div class="row">
                                                                    <div class="col-sm-6 col-xs-12">
                                                                        <label for="sayfaturu">Sayfa Türü</label>
                                                                        <select class="form-control select2" id="sayfaturu" name="sayfaturu" style="width: 100%;">
                                                                            <option value="0">Seçiniz</option>
                                                                            <option value="kategori" id="sayfkategori">Sayfa Kategorisi</option>
                                                                            <option value="sayfa" id="altsayfakat">Alt Sayfa</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-6 col-xs-12 hidden-first visible-all">
                                                                        <label for="sayfaadi">Sayfa Adı</label>
                                                                        <input type="text" class="form-control" id="sayfaadi" name="sayfaadi" placeholder="Sayfa Adı">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group hidden-first visible-all">
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
                                                            <div class="form-group hidden-first visible-sayfa">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <label for="ustSayfa">Üst Sayfa</label>
                                                                        <select class="form-control select2" id="ustSayfa" name="ustSayfa" style="width: 100%;">
                                                                            <option id="0select2" value="0">Seçiniz</option>
                                                                            <?php for ($ustsayfa = 0; $ustsayfa < count($model[1]); $ustsayfa++) { ?>
                                                                                <option value="<?php echo $model[1][$ustsayfa]['ID']; ?>"><?php echo $model[1][$ustsayfa]['Adi']; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group hidden-first visible-sayfa">
                                                                <div class="row">
                                                                    <div class="col-sm-12 col-xs-12">
                                                                        <label for="sayfaresim">Sayfa Resmi</label>
                                                                        <input id="sayfaresim" name="sayfaresim" class="form-control" type="file" />
                                                                        <div id="image-holder" style="height:290px; width:100%; margin-top:10px;"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.col -->
                                                        <div class="col-md-8">
                                                            <div class="form-group hidden-first visible-sayfa">
                                                                <label for="sayfayazisi">Sayfa Yazısı</label>
                                                                <textarea class="form-control" id="sayfayazisi" name="sayfayazisi" style="height:100px;resize: none;"></textarea>
                                                            </div>
                                                            <div class="form-group hidden-first visible-all">
                                                                <input id="sayfakaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                                <input id="vazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                            </div>
                                                        </div><!-- /.col -->
                                                    </form><!-- /.row -->
                                                </div><!-- /.box-body -->
                                                </div>
                                                <!-- LİSTE -->
                                                <div class="box box-info">
                                                    <div class="box-header with-border">
                                                        <h3 class="box-title">Sayfalar</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <table id="sayfaTable" class="table table-bordered table-hover TreeGrid">
                                                            <thead style="background:#e6e6e6;">
                                                                <tr>
                                                                    <th>Sayfa Adı</th>
                                                                    <th>Aktiflik</th>
                                                                    <th>Sıra</th>
                                                                    <th class="text-right">İşlemler</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="" id="sayfatbody">
                                                                <?php for ($ustsayfa = 0; $ustsayfa < count($model[1]); $ustsayfa++) { ?>
                                                                    <tr id="<?php echo $model[1][$ustsayfa]['ID']; ?>" class="treegrid-<?php echo $model[1][$ustsayfa]['ID']; ?>" data-ust="0">
                                                                        <td id="sayfaad<?php echo $model[1][$ustsayfa]['ID']; ?>" data-sayfaad="<?php echo $model[1][$ustsayfa]['Adi']; ?>"><b><?php echo $model[1][$ustsayfa]['Adi']; ?></b></td>
                                                                        <td id="sayfadurum<?php echo $model[1][$ustsayfa]['ID']; ?>" data-aktif="<?php echo $model[1][$ustsayfa]['Aktif']; ?>"><?php echo $model[1][$ustsayfa]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                        <td id="sayfasira<?php echo $model[1][$ustsayfa]['ID']; ?>"><?php echo $model[1][$ustsayfa]['Sira']; ?></td>
                                                                        <td class="text-right">
                                                                            <a id="SayfaDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                            <a id="SayfaSilme" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                    <?php for ($altsayfa = 0; $altsayfa < count($model[2][$ustsayfa]); $altsayfa++) { ?>
                                                                        <tr id="<?php echo $model[2][$ustsayfa][$altsayfa]['ID']; ?>" class="treegrid-<?php echo $model[2][$ustsayfa][$altsayfa]['ID']; ?> treegrid-parent-<?php echo $model[1][$ustsayfa]['ID']; ?>" data-ust="<?php echo $model[1][$ustsayfa]['ID']; ?>">
                                                                            <td id="sayfaad<?php echo $model[2][$ustsayfa][$altsayfa]['ID']; ?>" data-sayfaad="<?php echo $model[2][$ustsayfa][$altsayfa]['Adi']; ?>"><?php echo $model[2][$ustsayfa][$altsayfa]['Adi']; ?></td>
                                                                            <td id="sayfadurum<?php echo $model[2][$ustsayfa][$altsayfa]['ID']; ?>" data-aktif="<?php echo $model[2][$ustsayfa][$altsayfa]['Aktif']; ?>"><?php echo $model[2][$ustsayfa][$altsayfa]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                            <td id="sayfasira<?php echo $model[2][$ustsayfa][$altsayfa]['ID']; ?>"><?php echo $model[2][$ustsayfa][$altsayfa]['Sira']; ?></td>
                                                                            <td class="text-right">
                                                                                <a id="SayfaDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                                <a id="SayfaSilme" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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

                                                <!-- CK Editor (app.js'den sonra gelecek.) -->
                                                <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
                                                <script type="text/javascript">
                                                    CKEDITOR.replace('sayfayazisi', {
                                                        height: 330,
                                                        width: '100%'
                                                    });
                                                </script>
