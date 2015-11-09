<script src="<?php echo SITE_JS; ?>/vitrin.js" type="text/javascript"></script>
<!-- İÇ SAYFA -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Blog Yayınları
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
                                    <h3 class="box-title"><span id=blogustbaslik>Yeni</span> Blog</h3>
                                    <div class="box-tools pull-right">
                                        <button id="formToggleBlog" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <form class="row urunForm">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="blogbaslik">Başlık</label>
                                                    <input type="text" class="form-control" id="blogbaslik" name="blogbaslik" placeholder="Blog Başlığı">
                                                </div>
                                                <div class="form-group">
                                                    <label for="aktiflik">Aktiflik</label>
                                                    <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                        <option value="1">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="blogresim">Blog Resmi</label>
                                                    <input id="blogresim" name="blogresim" class="form-control" type="file" />
                                                    <div id="image-holder" style="height:290px; width:100%; margin-top:10px;"></div>
                                                </div>
                                            </div><!-- /.col -->
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="blogyazisi">Blog Yazısı</label>
                                                    <textarea class="form-control" id="blogyazisi" name="blogyazisi"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <input id="blogkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                    <input id="blogvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                </div>
                                            </div><!-- /.col -->
                                        </form><!-- /.row -->
                                    </div><!-- /.box-body -->
                                    </div>
                                    <!-- LİSTE -->
                                    <div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Bloglar</h3>
                                        </div>
                                        <div class="box-body">
                                            <table id="blogTable" class="table table-bordered table-hover">
                                                <thead style="background:#e6e6e6;">
                                                    <tr>
                                                        <th>Blog Başlığı</th>
                                                        <th class="hidden-xs">Aktiflik</th>
                                                        <th class="hidden-xs">Tarih</th>
                                                        <th class="text-right">İşlemler</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="blogtbody">
                                                    <?php for ($blog = 0; $blog < count($model); $blog++) { ?>
                                                        <tr id="<?php echo $model[$blog]['ID']; ?>">
                                                            <td id="blogad<?php echo $model[$blog]['ID']; ?>"><?php echo $model[$blog]['Baslik']; ?></td>
                                                            <td id="blogaktif<?php echo $model[$blog]['ID']; ?>" data-aktif="<?php echo $model[$blog]['Aktif']; ?>" class="hidden-xs"><?php echo $model[$blog]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                            <td id="blogtarih<?php echo $model[$blog]['ID']; ?>" class="hidden-xs"><?php echo $model[$blog]['Tarih']; ?></td>
                                                            <td class="text-right">
                                                                <!-- Yeni pencerede sitedeki blog detay sayfasına gidecek -->
                                                                <a id="blogduzenle" class="btn btn-primary btn-sm" title="Görüntüle" target="_blank"><i class="fa fa-eye"></i></a>
                                                                <a id="blogduzenle" class="btn btn-warning btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                <a id="blogsil" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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

                                    <!-- SCRIPT -->
                                    <!-- CK Editor (app.js'den sonra gelecek.) -->
                                    <script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
                                    <script type="text/javascript">
                                        CKEDITOR.replace('blogyazisi', {
                                            height: 330,
                                            width: '100%'
                                        });
                                    </script>