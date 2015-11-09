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
                                <h3 class="box-title">Yeni Banka Hesabı</h3>
                                <div class="box-tools pull-right">
                                    <button id="formToggle" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
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
                                                <option>Aktif</option>
                                                <option>Pasif</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input id="kaydet" type="submit" value="Kaydet" class="btn btn-primary pull-right" />
                                            <input id="vazgec" type="reset" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
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
                                <table class="table table-bordered table-hover">
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
                                        <tr>
                                            <td><b>Garanti Bankası</b></td>
                                            <td class="hidden-xs">Anayurt Şubesi (23856)</td>
                                            <td>0962563</td>
                                            <td class="hidden-xs">TR80 0006 2000 0045 0850 9703 62</td>
                                            <td class="hidden-xs">Sedat Yazır - Flora Çiçekçilik</td>
                                            <td class="hidden-xs">Aktif</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
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
        $(function() {
            $(".select2").select2();
            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        });
        
        $(document).ready(function (){
            $("#vazgec").on("click", function () {
                $("#formToggle").click();
            });
        });
    </script>