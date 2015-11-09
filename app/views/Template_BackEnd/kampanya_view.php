<!-- İÇ SAYFA -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Kampanya
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
                                <h3 class="box-title">Yeni Kampanya</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <form class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="kampanyabaslik">Kampanya Başlığı</label>
                                                    <input type="text" class="form-control" id="kampanyabaslik" name="kampanyabaslik" placeholder="Kampanya Başlığı">
                                                </div>
                                                <div class="form-group">
                                                    <label for="baslamatarihi">Başlama Tarihi</label>
                                                    <div class="input-group">
                                                        <input type="text" id="baslamatarihi" class="form-control" placeholder="Başlama Tarihi">
                                                        <span class="input-group-btn">
                                                            <button id="baslamatarihBtn" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div><!-- /.col -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="aktiflik">Aktiflik</label>
                                                    <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                        <option>Aktif</option>
                                                        <option>Pasif</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="bitistarihi">Bitiş Tarihi</label>
                                                    <div class="input-group">
                                                        <input type="text" id="bitistarihi" class="form-control" placeholder="Bitiş Tarihi">
                                                        <span class="input-group-btn">
                                                            <button id="bitistarihBtn" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="indirimyuzde">İndirim Tutarı</label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><b>%</b></span>
                                                        <input type="text" id="indirimyuzde" name="indirimyuzde" class="form-control" placeholder="İndirim Tutarı (%)">
                                                    </div>
                                                </div>
                                                <div class="form-group has-warning" style="display:none;">
                                                    <label class="control-label" id="kampanyaUyari"><i class="fa fa-warning"></i> UYARI : Seçeceğiniz kategorilerdeki tüm ürünlerde <b id="ind" style="font-size:18px;"></b> indirim yapılacak !</label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kategoriler">Kategoriler</label>
                                                    <select class="form-control select2" multiple="multiple" data-placeholder="Kategori Seçiniz" id="kategoriler" name="kategoriler" style="width: 100%;">
                                                        <option>Güller</option>
                                                        <option>Orkideler</option>
                                                        <option>Buketler</option>
                                                        <option>Aranjmanlar</option>
                                                        <option>Çelenkler</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kampanyayazi">Kampanya Tanıtım Yazısı</label>
                                            <textarea class="form-control" id="kampanyayazi" name="kampanyayazi"></textarea>
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
                                <h3 class="box-title">Kampanyalar</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover">
                                    <thead style="background:#e6e6e6;">
                                        <tr>
                                            <th>Kampanya Başlığı</th>
                                            <th>İndirim Tutarı</th>
                                            <th>Durum</th>
                                            <th class="text-right">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aktif olanlarda "text-green" class'ı var... -->
                                        <tr class="text-green">
                                            <td><b>Öğretmenler Günü</b></td>
                                            <td>% 10</td>
                                            <td>Devam Ediyor</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Anneler Günü</b></td>
                                            <td>% 15</td>
                                            <td>Bitti</td>
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

        $(document).ready(function () {

            $("#baslamatarihi").datepicker({
                dateFormat: 'dd/mm/yy',
                onClose: function (selectedDate) {
                    $("#bitistarihi").datepicker("option", "minDate", selectedDate);
                }
            });

            $("#bitistarihi").datepicker({
                dateFormat: 'dd/mm/yy',
                onClose: function (selectedDate) {
                    $("#baslamatarihi").datepicker("option", "maxDate", selectedDate);
                }
            });

            $(document).on("click", "#baslamatarihBtn", function () {
                $("#baslamatarihi").focus();
            });

            $(document).on("click", "#bitistarihBtn", function () {
                $("#bitistarihi").focus();
            });

            $("#indirimyuzde").on("keyup", function () {
                var val = $(this).val();
                if (val != "") {
                    $("#ind").html("% " + val);
                    $(".has-warning").fadeIn();
                } else {
                    $("#ind").html("");
                    $(".has-warning").fadeOut();
                }
                
            });

        });
    </script>

