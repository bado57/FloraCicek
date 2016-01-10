<script src="<?php echo SITE_JS; ?>/iletisim.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Mesajlar
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
                                <h3 class="box-title">Mesaj Detayı</h3>
                                <div class="box-tools pull-right">
                                    <button id="formToggleIletisim" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <form class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="iletadsoyad">Ad Soyad</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b><i class="fa fa-user"></i></b></span>
                                                            <input type="text" id="iletadsoyad" name="iletadsoyad" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="iletemail">E-Mail</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b><i class="fa fa-envelope-o"></i></b></span>
                                                            <input type="text" id="iletemail" name="iletemail" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="iletkonu">Konu</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b><i class="fa fa-edit"></i></b></span>
                                                            <input type="text" id="iletkonu" name="iletkonu" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="ilettarih">Tarih</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b><i class="fa fa-calendar"></i></b></span>
                                                            <input type="text" id="ilettarih" name="ilettarih" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="iletudurum">Üye Durum</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><b><i class="fa fa-info"></i></b></span>
                                                            <input type="text" id="iletudurum" name="iletudurum" class="form-control" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="mesajyazi">Mesajınız</label>
                                                <textarea class="form-control" id="mesajyazi" name="mesajyazi" disabled></textarea>
                                            </div>
                                        </div><!-- /.col -->
                                    </form><!-- /.row -->
                                </div><!-- /.box-body -->
                                </div>
                                <!-- LİSTE -->
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Mesajlar</h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="mesajTable" class="table table-bordered table-hover">
                                            <thead style="background:#e6e6e6;">
                                                <tr>
                                                    <th>Ad Soyad</th>
                                                    <th>Konu</th>
                                                    <th>Tarih</th>
                                                    <th class="text-right">İşlemler</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php for ($iletisim = 0; $iletisim < count($model); $iletisim++) { ?>
                                                    <tr id="<?php echo $model[$iletisim]['ID']; ?>">
                                                        <td><b><?php echo $model[$iletisim]['Ad']; ?></b></td>
                                                        <td><?php echo $model[$iletisim]['Konu']; ?></td>
                                                        <td><?php echo $model[$iletisim]['Tarih']; ?></td>
                                                        <td class="text-right">
                                                            <a id="mesajGoruntule" class="btn btn-info btn-sm" title="Görüntüle"><i class="fa fa-search"></i></a>                                                                </td>
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

