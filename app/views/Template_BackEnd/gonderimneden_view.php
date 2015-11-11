<script src="<?php echo SITE_JS; ?>/siparis.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gönderim Nedeni
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
                                    <h3 class="box-title"><span id=nedenustbaslik>Yeni</span> Gönderim Nedeni</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleNeden" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="gonderimnedenadi">İsim</label>
                                                    <input type="text" class="form-control" id="gonderimnedenadi" name="gonderimnedenadi" placeholder="Gönderim Nedeni">
                                                </div>
                                            </div><!-- /.col -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="aktiflik">Aktiflik</label>
                                                    <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group" style="padding-top:30px;">
                                                    <input id="nedenkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                    <input id="nedenvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                </div>
                                            </div><!-- /.col -->
                                        </form><!-- /.row -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Gönderim Nedenleri</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="nedenTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Adı</th>
                                                        <th>Aktiflik</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($neden = 0; $neden < count($model); $neden++) { ?>
                                                        <tr id="<?php echo $model[$neden]['ID']; ?>">
                                                            <td id="nedenad<?php echo $model[$neden]['ID']; ?>"><b><?php echo $model[$neden]['Adi']; ?></b></td>
                                                            <td id="nedenaktif<?php echo $model[$neden]['ID']; ?>" data-aktif="<?php echo $model[$neden]['Aktif']; ?>"><?php echo $model[$neden]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                            <td class="text-right">
                                                                <a id="nedenduzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                <a id="nedensil" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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

