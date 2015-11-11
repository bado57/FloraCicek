<script src="<?php echo SITE_JS; ?>/siparis.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            İl - İlçe Yönetimi
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
                                        <h3 class="box-title"><span id=ililceustbaslik>İl / İlçe</span> Düzenle</h3>
                                        <div class="box-tools pull-right">
                                            <button id="formToggleIlIlce" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                        </div>
                                        </div><!-- /.box-header -->
                                        <div class="box-body">
                                            <!-- Burada 2 tane form var. Düzenlenmek istenen il ve ilçe adları disabled olarak gelecek. Yalnızca aktiflik ve ek ücret düzenlenebilecek. -->
                                            <form class="row" id="ilForm">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="iladi">İl</label>
                                                        <input type="text" class="form-control" id="iladi" name="iladi" placeholder="İl Adı" disabled>
                                                    </div>
                                                </div><!-- /.col -->
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="aktiflik">Aktiflik</label>
                                                        <select class="form-control select2" id="ilaktiflik" name="ilaktiflik" style="width: 100%;">
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group" style="padding-top:30px;">
                                                        <input id="ilkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                        <input id="ilvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                    </div>
                                                </div><!-- /.col -->
                                            </form><!-- /.row -->
                                            <form class="row" id="ilceForm">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="ilceiladi">İl</label>
                                                        <input type="text" class="form-control" id="ilceiladi" name="ilceiladi" placeholder="İl Adı" disabled>
                                                    </div>
                                                </div><!-- /.col -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="ilceadi">İlçe</label>
                                                        <input type="text" class="form-control" id="ilceadi" name="ilceadi" placeholder="İlçe Adı" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="aktiflik">Aktiflik</label>
                                                        <select class="form-control select2" id="ilceaktiflik" name="ilceaktiflik" style="width: 100%;">
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="ekucret">Ek Ücret (TL)</label>
                                                        <input type="text" class="form-control" id="ekucret" name="ekucret" placeholder="Ek Ücret (TL)">
                                                    </div>
                                                    <div class="form-group">
                                                        <input id="ilcekaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                        <input id="ilcevazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                    </div>
                                                </div><!-- /.col -->
                                            </form><!-- /.row -->
                                        </div><!-- /.box-body -->
                                        </div>
                                        <!-- LİSTE -->
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">İller / İlçeler</h3>
                                            </div>
                                            <div class="box-body">
                                                <table id="ililceTable" class="table table-bordered table-hover TreeGrid">
                                                    <thead style="background:#e6e6e6;">
                                                        <tr>
                                                            <th>İl / İlçe</th>
                                                            <th>Aktiflik</th>
                                                            <th>Ek Ücret</th>
                                                            <th class="text-right">İşlemler</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="" id="tabletbody">
                                                        <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                                            <tr id="<?php echo $model[1][$ustkat]['ID']; ?>" class="treegrid-<?php echo $model[1][$ustkat]['ID']; ?>" data-ust="0">
                                                                <td id="ilad<?php echo $model[1][$ustkat]['ID']; ?>"><b><?php echo $model[1][$ustkat]['Adi']; ?></b></td>
                                                                <td id="ildurum<?php echo $model[1][$ustkat]['ID']; ?>" data-aktif="<?php echo $model[1][$ustkat]['Aktif']; ?>"><?php echo $model[1][$ustkat]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                <td></td>
                                                                <td class="text-right">
                                                                    <a id="IlIlceDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                </td>
                                                            </tr>
                                                            <?php for ($altkat = 0; $altkat < count($model[2][$ustkat]); $altkat++) { ?>
                                                                <tr id="<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" class="treegrid-<?php echo $model[2][$ustkat][$altkat]['ID']; ?> treegrid-parent-<?php echo $model[1][$ustkat]['ID']; ?>" data-ust="<?php echo $model[1][$ustkat]['ID']; ?>">
                                                                    <td id="ilcead<?php echo $model[2][$ustkat][$altkat]['ID']; ?>"><?php echo $model[2][$ustkat][$altkat]['Adi']; ?></td>
                                                                    <td id="ilcedurum<?php echo $model[2][$ustkat][$altkat]['ID']; ?>" data-aktif="<?php echo $model[2][$ustkat][$altkat]['Aktif']; ?>"><?php echo $model[2][$ustkat][$altkat]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                    <td id="ilceekucret<?php echo $model[2][$ustkat][$altkat]['ID']; ?>"><?php echo $model[2][$ustkat][$altkat]['EkUcret']; ?> TL</td>
                                                                    <td class="text-right">
                                                                        <a id="IlIlceDuzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
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



