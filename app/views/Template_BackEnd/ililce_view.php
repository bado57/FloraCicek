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
                                <h3 class="box-title">İl / İlçe Düzenle</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
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
                                            <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                <option>Aktif</option>
                                                <option>Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group" style="padding-top:30px;">
                                            <input id="kaydet" type="submit" value="Kaydet" class="btn btn-primary pull-right" />
                                            <input id="vazgec" type="reset" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                        </div>
                                    </div><!-- /.col -->
                                </form><!-- /.row -->
                                <form class="row" id="ilceForm">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="iladi">İl</label>
                                            <input type="text" class="form-control" id="iladi" name="iladi" placeholder="İl Adı" disabled>
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
                                            <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                <option>Aktif</option>
                                                <option>Pasif</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="ekucret">Ek Ücret (TL)</label>
                                            <input type="text" class="form-control" id="ekucret" name="ekucret" placeholder="Ek Ücret (TL)">
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
                                <h3 class="box-title">İller / İlçeler</h3>
                            </div>
                            <div class="box-body">
                                <table class="table table-bordered table-hover TreeGrid">
                                    <thead style="background:#e6e6e6;">
                                        <tr>
                                            <th>İl / İlçe</th>
                                            <th>Aktiflik</th>
                                            <th>Ek Ücret</th>
                                            <th class="text-right">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody class="">
                                        <tr class="treegrid-1">
                                            <td><b>Kayseri</b></td>
                                            <td>Aktif</td>
                                            <td></td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="treegrid-2 treegrid-parent-1">
                                            <td>Melikgazi</td>
                                            <td>Aktif</td>
                                            <td>15 TL</td>
                                            <td class="text-right">
                                                <a href="#" class="btn btn-info btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <tr class="treegrid-3 treegrid-parent-1">
                                            <td>Kocasinan</td>
                                            <td>Aktif</td>
                                            <td>10 TL</td>
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
        
        

