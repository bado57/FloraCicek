<script src="<?php echo SITE_JS; ?>/icpanel.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Etiketler
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
                                        <h3 class="box-title"><span id=etiketustbaslik>Yeni</span> Etiket</h3>
                                        <div class="box-tools pull-right">
                                            <button id="formToggleEtiket" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <form class="row urunForm">
                                                <div class="col-md-12">                                        
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-sm-4 col-xs-12">
                                                                <label for="etiketadi">Etiket Adı</label>
                                                                <input type="text" class="form-control" id="etiketadi" name="etiketadi" placeholder="Etiket Adı">
                                                            </div>
                                                            <div class="col-sm-3 col-xs-12">
                                                                <label for="aktiflik">Aktiflik</label>
                                                                <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                                    <option value="1">Aktif</option>
                                                                    <option value="0">Pasif</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3 col-xs-12">
                                                                <label for="sira">Sıra</label>
                                                                <input type="number" min="1" class="form-control" id="sira" name="sira" placeholder="Sıra">
                                                            </div>
                                                            <div class="col-sm-2 col-xs-12">
                                                                <input id="etiketkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" style="margin-top:25px;" />
                                                                <input id="etiketvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px; margin-top:25px;" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.col -->
                                            </form><!-- /.row -->
                                        </div><!-- /.box-body -->
                                        </div>
                                        <!-- LİSTE -->
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Etiketler</h3>
                                            </div>
                                            <div class="box-body">
                                                <table id="urunTable" class="table table-bordered table-hover">
                                                    <thead style="background:#e6e6e6;">
                                                        <tr>
                                                            <th>Etiket Adı</th>
                                                            <th class="hidden-xs">Aktiflik</th>
                                                            <th class="hidden-xs">Sıra</th>
                                                            <th class="text-right">İşlemler</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="etikettbody" class="">
                                                        <?php for ($etiket = 0; $etiket < count($model); $etiket++) { ?>
                                                            <tr id="<?php echo $model[$etiket]['ID']; ?>">
                                                                <td id="etiketad<?php echo $model[$etiket]['ID']; ?>"><?php echo $model[$etiket]['Adi']; ?></td>
                                                                <td id="etiketdurum<?php echo $model[$etiket]['ID']; ?>" data-aktif="<?php echo $model[$etiket]['Aktif']; ?>" class="hidden-xs"><?php echo $model[$etiket]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                <td id="etiketsira<?php echo $model[$etiket]['ID']; ?>" class="hidden-xs"><?php echo $model[$etiket]['Sira']; ?></td>
                                                                <td class="text-right">
                                                                    <a id="etiketduzenle" data-id="<?php echo $model[$etiket]['ID']; ?>" class="btn btn-warning btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                    <a id="etiketsil" data-id="<?php echo $model[$etiket]['ID']; ?>" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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