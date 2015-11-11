<script src="<?php echo SITE_JS; ?>/siparis.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Banka
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
                                    <h3 class="box-title"><span id=bankaustbaslik>Yeni</span> Banka Hesabı</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleBanka" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="bankaadi">Banka Adı</label>
                                                    <input type="text" class="form-control" id="bankaadi" name="bankaadi" placeholder="Banka Adı">
                                                </div>
                                                <div class="form-group">
                                                    <label for="subeadi">Şube Adı / Kodu</label>
                                                    <input type="text" class="form-control" id="subeadi" name="subeadi" placeholder="Şube Adı">
                                                </div>
                                            </div><!-- /.col -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="hesapno">Hesap No</label>
                                                    <input type="text" class="form-control" id="hesapno" name="hesapno" placeholder="Hesap No">
                                                </div>
                                                <div class="form-group">
                                                    <label for="ibanno">Iban No</label>
                                                    <input type="text" class="form-control" id="ibanno" name="ibanno" placeholder="Iban No">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="alici">Alıcı</label>
                                                    <input type="text" class="form-control" id="alici" name="alici" placeholder="Alıcı">
                                                </div>
                                                <div class="form-group">
                                                    <label for="aktiflik">Aktiflik</label>
                                                    <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="bankakaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                    <input id="bankavazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                </div>
                                            </div><!-- /.col -->
                                        </form><!-- /.row -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Hesaplar</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="bankaTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Banka</th>
                                                        <th class="hidden-xs">Şube</th>
                                                        <th>Hesap No</th>
                                                        <th class="hidden-xs">Iban</th>
                                                        <th class="hidden-xs">Alıcı</th>
                                                        <th class="hidden-xs">Aktiflik</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php for ($banka = 0; $banka < count($model); $banka++) { ?>
                                                        <tr id="<?php echo $model[$banka]['ID']; ?>">
                                                            <td id="bankaad<?php echo $model[$banka]['ID']; ?>"><b><?php echo $model[$banka]['Adi']; ?></b></td>
                                                            <td id="bankasube<?php echo $model[$banka]['ID']; ?>" class="hidden-xs"><?php echo $model[$banka]['Sube']; ?></td>
                                                            <td id="bankahesap<?php echo $model[$banka]['ID']; ?>"><?php echo $model[$banka]['HesapNo']; ?></td>
                                                            <td id="bankaiban<?php echo $model[$banka]['ID']; ?>" class="hidden-xs"><?php echo $model[$banka]['IbanNo']; ?></td>
                                                            <td id="bankaalici<?php echo $model[$banka]['ID']; ?>" class="hidden-xs"><?php echo $model[$banka]['Alici']; ?></td>
                                                            <td id="bankaaktif<?php echo $model[$banka]['ID']; ?>" data-aktif="<?php echo $model[$banka]['Aktif']; ?>" class="hidden-xs"><?php echo $model[$banka]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                            <td class="text-right">
                                                                <a id="bankaduzenle" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                <a id="bankasil" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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

                                    <!-- page script -->
                                    <script type="text/javascript">
                                        $(function () {
                                            $(".select2").select2();
                                            //iCheck for checkbox and radio inputs
                                            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                                                checkboxClass: 'icheckbox_minimal-blue',
                                                radioClass: 'iradio_minimal-blue'
                                            });
                                        });

                                        $(document).ready(function () {
                                            $("#vazgec").on("click", function () {
                                                $("#formToggle").click();
                                            });
                                        });
                                    </script>