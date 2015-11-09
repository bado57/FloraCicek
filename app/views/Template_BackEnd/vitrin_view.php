<script src="<?php echo SITE_JS; ?>/vitrin.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Vitrin
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
                                    <input name="normalSira" type="hidden" value="" >
                                        <h3 class="box-title"><span id=vitrinustbaslik>Yeni</span> Vitrin</h3>
                                        <div class="box-tools pull-right">
                                            <button id="formToggleVitrin" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <form class="row urunForm">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="vitrinbaslik">Başlık</label>
                                                        <input type="text" class="form-control" id="vitrinbaslik" name="vitrinbaslik" placeholder="Başlık">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vitrinaltbaslik">Alt Başlık</label>
                                                        <input type="text" class="form-control" id="vitrinaltbaslik" name="vitrinaltbaslik" placeholder="Alt Başlık">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vitrinbuttonyazi">Buton Yazısı</label>
                                                        <input type="text" class="form-control" id="vitrinbuttonyazi" name="vitrinbuttonyazi" placeholder="Buton Yazısı">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="vitrinadres">Adres (URL)</label>
                                                        <input type="text" class="form-control" id="vitrinadres" name="vitrinadres" placeholder="Adres (URL)">
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
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="vitrinresim">Vitrin Resmi</label>
                                                        <input id="vitrinresim" name="vitrinresim" class="form-control" type="file" />
                                                        <div id="image-holder" style="height:290px; width:100%; margin-top:10px;"></div>
                                                    </div>
                                                </div><!-- /.col -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="vitrinyazi">Vitrin Yazısı</label>
                                                        <textarea rows="14" class="form-control" id="vitrinyazi" name="vitrinyazi" placeholder="Vitrin Yazısı"></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="vitrinkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                        <input id="vitrinvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                    </div>
                                                </div><!-- /.col -->
                                            </form><!-- /.row -->
                                        </div><!-- /.box-body -->
                                        </div>
                                        <!-- LİSTE -->
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Vitrinler</h3>
                                            </div>
                                            <div class="box-body">
                                                <table id="vitrinTable" class="table table-bordered table-hover">
                                                    <thead style="background:#e6e6e6;">
                                                        <tr>
                                                            <th>Vitrin Başlığı</th>
                                                            <th class="hidden-xs">Aktiflik</th>
                                                            <th class="hidden-xs">Sıra</th>
                                                            <th class="text-right">İşlemler</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="vitrintbody" class="">
                                                        <?php for ($vitrin = 0; $vitrin < count($model); $vitrin++) { ?>
                                                            <tr id="<?php echo $model[$vitrin]['ID']; ?>">
                                                                <td id="vitrinad<?php echo $model[$vitrin]['ID']; ?>"><?php echo $model[$vitrin]['Baslik']; ?></td>
                                                                <td id="vitrinaktif<?php echo $model[$vitrin]['ID']; ?>" data-aktif="<?php echo $model[$vitrin]['Aktif']; ?>" class="hidden-xs"><?php echo $model[$vitrin]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                <td id="vitrinsira<?php echo $model[$vitrin]['ID']; ?>" class="hidden-xs"><?php echo $model[$vitrin]['Sira']; ?></td>
                                                                <td class="text-right">
                                                                    <a id="vitrinduzenle" href="#" class="btn btn-warning btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                    <a id="vitrinSil" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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
                                        <!-- /SCRIPT -->