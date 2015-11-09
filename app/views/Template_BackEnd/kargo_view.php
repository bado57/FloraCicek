<!-- İÇ SAYFA -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Kargo
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
                                <h3 class="box-title">Yeni Kargo Firması</h3>
                                <div class="box-tools pull-right">
                                    <button id="formToggle" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <form class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="kargofirmaadi">Firma Adı</label>
                                            <input type="text" class="form-control" id="kargofirmaadi" name="kargofirmaadi" placeholder="Firma Adı">
                                        </div>
                                    </div><!-- /.col -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="aktiflik">Aktiflik</label>
                                            <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                <option>Aktif</option>
                                                <option>Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="aciklama">Açıklama</label>
                                            <input type="text" class="form-control" id="aciklama" name="aciklama" placeholder="Açıklama">
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
                                <h3 class="box-title">Kargo Firmaları</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover">
                                    <thead style="background:#e6e6e6;">
                                        <tr>
                                            <th>Firma Adı</th>
                                            <th class="hidden-xs">Açıklama</th>
                                            <th>Aktiflik</th>
                                            <th class="text-right">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Aras Kargo</b></td>
                                            <td class="hidden-xs">Anlaşmamız 01/01/2017'de bitecek !</td>
                                            <td>Aktif</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>UPS Kargo</b></td>
                                            <td class="hidden-xs">Sözleşme iptal edildi.</td>
                                            <td>Pasif</td>
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
        $(document).ready(function (){
            $("#vazgec").on("click", function () {
                $("#formToggle").click();
            });
        });
    </script>

