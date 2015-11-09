<script src="<?php echo SITE_JS; ?>/icpanel.js" type="text/javascript"></script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Ürünler
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
                                        <input name="normalUstKategori" type="hidden" value="" >
                                            <h3 class="box-title"><span id=urunustbaslik>Yeni</span> Ürün</h3>
                                            <div class="box-tools pull-right">
                                                <button id="formToggle" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                            </div>
                                            </div><!-- /.box-header -->
                                            <div class="box-body">
                                                <form class="row urunForm" id="urunForm">
                                                    <div class="col-md-6">                                        
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="urunadi">Ürün Adı</label>
                                                                    <input type="text" class="form-control" id="urunadi" name="urunadi" placeholder="Ürün Adı">
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="urunkodu">Ürün Kodu</label>
                                                                    <input type="text" class="form-control" id="urunkodu" name="urunkodu" placeholder="Ürün Kodu">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="urunkategori">Kategorisi</label>
                                                                    <select class="form-control select2" id="urunkategori" name="urunkategori" style="width: 100%;">
                                                                        <option id="0select2" value="0">Seçiniz</option>
                                                                        <?php for ($kat = 0; $kat < count($model[0]); $kat++) { ?>
                                                                            <option value="<?php echo $model[0][$kat]['ID']; ?>"><?php echo $model[0][$kat]['Adi']; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="urunfiyat">Fiyatı <span style="color:red;">(TL - KDV Hariç)</span></label>
                                                                    <input type="text" class="form-control" id="urunfiyat" name="urunfiyat" placeholder="Fiyatı (TL)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="aktiflik">Aktiflik</label>
                                                                    <select class="form-control select2" id="aktiflik" name="aktiflik" style="width: 100%;">
                                                                        <option value="1">Aktif</option>
                                                                        <option value="0">Pasif</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6 col-xs-12">
                                                                    <label for="sira">Sıra</label>
                                                                    <input type="number" min="1" class="form-control" id="sira" name="sira" placeholder="Sıra">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row" style="margin-top:15px;" id="urunOzellik">
                                                                <label class="col-sm-3 col-xs-6">
                                                                    <input data-islem="1" id="yeniurun" name="yeniurun" type="checkbox" class="minimal"> <span style="margin-left:5px;">Yeni Ürün</span>
                                                                </label>
                                                                <label class="col-sm-3 col-xs-6">
                                                                    <input data-islem="2" id="ekurun" name="ekurun" type="checkbox" class="minimal"> <span style="margin-left:5px;">Ek Ürün</span>
                                                                </label>
                                                                <label class="col-sm-3 col-xs-6">
                                                                    <input data-islem="3" id="haftaninurunu" name="haftaninurunu" type="checkbox" class="minimal"> <span style="margin-left:5px;">Haftanın Ürünü</span>
                                                                </label>
                                                                <label class="col-sm-3 col-xs-6">
                                                                    <input data-islem="4" id="coksatan" name="coksatan" type="checkbox" class="minimal"> <span style="margin-left:5px;">Çok Satanlar</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <!-- Etiket Seçimi -->
                                                        <div class="form-group">
                                                            <div class="row" style="margin-top:20px;" id="etiketozellik">
                                                                <div class="col-sm-12">
                                                                    <label class="col-sm-12" style="padding-left:0; padding-bottom:5px; border-bottom:1px solid #e6e6e6; margin-bottom:10px; color:#ff0000;"><i class="fa fa-tag"></i> Ürün Etiketleri</label>
                                                                </div>
                                                                <?php for ($etiket = 0; $etiket < count($model[1]); $etiket++) { ?>
                                                                    <label class="col-sm-3 col-xs-6">
                                                                        <input name="label" id="<?php echo $model[1][$etiket]['ID']; ?>" type="checkbox" class="minimal"> <span style="margin-left:5px;"><?php echo $model[1][$etiket]['Adi']; ?></span>
                                                                    </label>
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                    </div><!-- /.col -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="urunresim">Ürün Resmi</label>
                                                            <input id="urunresim" name="urunresim" class="form-control" type="file" />
                                                            <div id="image-holder" style="height:290px; width:100%; margin-top:10px;"></div>
                                                        </div>
                                                    </div><!-- /.col -->
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="urunyazisi">Ürün Tanıtım Yazısı</label>
                                                            <textarea rows="14" class="form-control" id="urunyazisi" name="urunyazisi" placeholder="Ürün Tanıtım Yazısı" style="resize: none;"></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <input id="urunkaydet" type="button" value="Kaydet" class="btn btn-primary pull-right" />
                                                            <input id="urunvazgec" type="button" value="Vazgeç" class="btn btn-default pull-right" style="margin-right:10px;" />
                                                        </div>
                                                    </div><!-- /.col -->
                                                </form><!-- /.row -->
                                            </div><!-- /.box-body -->
                                            </div>
                                            <!-- LİSTE -->
                                            <div class="box box-info">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title">Ürünler</h3>
                                                </div>
                                                <div class="box-body">
                                                    <table id="urunTable" class="table table-bordered table-hover">
                                                        <thead style="background:#e6e6e6;">
                                                            <tr>
                                                                <th>Ürün Kodu</th>
                                                                <th>Ürün Adı</th>
                                                                <th class="hidden-xs">Kategori</th>
                                                                <th class="hidden-xs">Aktiflik</th>
                                                                <th class="hidden-xs">Sıra</th>
                                                                <th class="hidden-xs">Kampanyalı</th>
                                                                <th class="hidden-xs">Yeni Ürün</th>
                                                                <th class="hidden-xs">Ek Ürün</th>
                                                                <th class="hidden-xs">Çok Satan</th>
                                                                <th class="hidden-xs">Haftanın Ürünü</th>
                                                                <th class="text-right">İşlemler</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="urunTbodyTable" class="">
                                                            <?php for ($urun = 0; $urun < count($model[2]); $urun++) { ?>
                                                                <tr id="<?php echo $model[2][$urun]['ID']; ?>" data-katid="<?php echo $model[2][$urun]['KatID']; ?>">
                                                                    <td id="urunkod<?php echo $model[2][$urun]['ID']; ?>"><?php echo $model[2][$urun]['Kod']; ?></td>
                                                                    <td id="urunad<?php echo $model[2][$urun]['ID']; ?>"><?php echo $model[2][$urun]['Adi']; ?></td>
                                                                    <td id="urunkatAd<?php echo $model[2][$urun]['ID']; ?>" class="hidden-xs" ><?php echo $model[2][$urun]['KatAd']; ?></td>
                                                                    <td id="urundurum<?php echo $model[2][$urun]['ID']; ?>" class="hidden-xs"><?php echo $model[2][$urun]['Aktif'] == 1 ? "Aktif" : "Pasif"; ?></td>
                                                                    <td id="urunsira<?php echo $model[2][$urun]['ID']; ?>" class="hidden-xs"><?php echo $model[2][$urun]['Sira']; ?></td>
                                                                    <td id="urunkmpnya<?php echo $model[2][$urun]['ID']; ?>" data-kmpnya="<?php echo $model[2][$urun]['Kampanya']; ?>" class="hidden-xs"><i class="fa fa-<?php echo $model[2][$urun]['Kampanya'] == 1 ? "check" : "times"; ?>"></i></td>
                                                            <td id="urunyeni<?php echo $model[2][$urun]['ID']; ?>" data-yeni="<?php echo $model[2][$urun]['Yeni']; ?>" class="hidden-xs"><i class="fa fa-<?php echo $model[2][$urun]['Yeni'] == 1 ? "check" : "times"; ?>"></i></td>
                                                            <td id="urunek<?php echo $model[2][$urun]['ID']; ?>" data-ek="<?php echo $model[2][$urun]['Ek']; ?>" class="hidden-xs"><i class="fa fa-<?php echo $model[2][$urun]['Ek'] == 1 ? "check" : "times"; ?>"></i></td>
                                                            <td id="uruncok<?php echo $model[2][$urun]['ID']; ?>" data-cok="<?php echo $model[2][$urun]['CokSatan']; ?>" class="hidden-xs"><i class="fa fa-<?php echo $model[2][$urun]['CokSatan'] == 1 ? "check" : "times"; ?>"></i></td>
                                                            <td id="urunhafta<?php echo $model[2][$urun]['ID']; ?>" data-hafta="<?php echo $model[2][$urun]['HaftaUrun']; ?>" class="hidden-xs"><i class="fa fa-<?php echo $model[2][$urun]['HaftaUrun'] == 1 ? "check" : "times"; ?>"></i></td>
                                                            <td class="text-right">
                                                                <a id="urunDuzenle" data-id="<?php echo $model[2][$urun]['ID']; ?>" class="btn btn-warning btn-sm" title="Düzenle"><i class="fa fa-edit"></i></a>
                                                                <a id="urunSil" data-id="<?php echo $model[2][$urun]['ID']; ?>" class="btn btn-danger btn-sm" title="Sil"><i class="fa fa-trash"></i></a>
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