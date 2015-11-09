<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Yönetim Paneli
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Anasayfa</a></li>
            <li class="active">Yönetim Paneli</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="#">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3><?php echo $model[2]; ?></h3>
                            <p>Yeni Sipariş</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <div class="small-box-footer">Detaylar <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </a>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="#">
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>53<sup style="font-size: 20px">%</sup></h3>
                            <p>Mail Dönüşü</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <div class="small-box-footer">Detaylar <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </a>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="#">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3><?php echo $model[0]; ?></h3>
                            <p>Yeni Bireysel Üye</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <div class="small-box-footer">Detaylar <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </a>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <a href="#">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3><?php echo $model[1]; ?></h3>
                            <p>Yeni Kurumsal Üye</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-briefcase"></i>
                        </div>
                        <div class="small-box-footer">Detaylar <i class="fa fa-arrow-circle-right"></i></div>
                    </div>
                </a>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <!-- Main row -->
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-shopping-cart"></i> Son Siparişler <span class="hidden-xs">| <small class="ml10 text-red"><i class="fa fa-square"></i> Beklemede</small> <small class="ml10 text-yellow"><i class="fa fa-square"></i> Hazırlanıyor</small> <small class="ml10 text-green"><i class="fa fa-square"></i> Gönderildi</small></span></h3>
                        <a href="#" class="btn btn-sm btn-success pull-right"><i class="fa fa-angle-right"></i> Tümünü Gör</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="sonsiparisler" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ürün Adı</th>
                                    <th class="hidden-xs">Tarih</th>
                                    <th>Teslimat Yeri</th>
                                    <th class="hidden-xs">Tutar</th>
                                    <th class="hidden-xs">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($model[5] as $urunModel) { ?>
                                    <?php if ($urunModel["Durum"] == 0) { ?>
                                        <tr class="danger">
                                            <td class="text-center"><a href="#"><i class="fa fa-search"></i></a></td>
                                            <td class="text-left">Cam Vazoda 7 Gül</td>
                                            <td class="hidden-xs">
                                                <?php echo $urunModel["Tarih"] ?>
                                            </td>
                                            <td><?php echo $urunModel["Sehir"] ?> <?php echo $urunModel["Ilce"] ?></td>
                                            <td class="hidden-xs"><?php echo $urunModel["TopTutar"] ?> TL</td>
                                            <td class="hidden-xs">Beklemede</td>
                                        </tr>
                                    <?php } else if ($urunModel["Durum"] == 1) { ?>
                                        <tr class="warning">
                                            <td class="text-center"><a href="#"><i class="fa fa-search"></i></a></td>
                                            <td class="text-left">Cam Vazoda 7 Gül</td>
                                            <td class="hidden-xs">
                                                <?php echo $urunModel["Tarih"] ?>
                                            </td>
                                            <td><?php echo $urunModel["Sehir"] ?> <?php echo $urunModel["Ilce"] ?></td>
                                            <td class="hidden-xs"><?php echo $urunModel["TopTutar"] ?> TL</td>
                                            <td class="hidden-xs">Hazırlanıyor</td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr class="success">
                                            <td class="text-center"><a href="#"><i class="fa fa-search"></i></a></td>
                                            <td class="text-left">Cam Vazoda 7 Gül</td>
                                            <td class="hidden-xs">
                                                <?php echo $urunModel["Tarih"] ?>
                                            </td>
                                            <td><?php echo $urunModel["Sehir"] ?> <?php echo $urunModel["Ilce"] ?></td>
                                            <td class="hidden-xs"><?php echo $urunModel["TopTutar"] ?> TL</td>
                                            <td class="hidden-xs">Gönderildi</td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-xs-12 col-sm-6">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><i class="fa fa-user"></i> Son Üyeler <span class="hidden-xs">| <small class="ml10 text-aqua"><i class="fa fa-square"></i> kurumsal</small> <small class="ml10"><i class="fa fa-square"></i> Bireysel</small></span></h3>
                        <a href="#" class="btn btn-sm btn-success pull-right"><i class="fa fa-angle-right"></i> Tümünü Gör</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="sonuyeler" class="table table-responsive table-bordered table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ad Soyad</th>
                                    <th>Email</th>
                                    <th class="hidden-xs">Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($model[4] as $uyeModel) { ?>
                                    <?php if ($uyeModel["Rol"] == 0) { ?>
                                        <tr>
                                            <td class="text-center"><a href="#"><i class="fa fa-search"></i></a></td>
                                            <td class="text-left"> <?php echo $uyeModel["AdSoyad"]; ?></td>
                                            <td>
                                                <?php echo $uyeModel["EPosta"]; ?>
                                            </td>
                                            <td class="hidden-xs">Bireysel</td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr class="info">
                                            <td class="text-center"><a href="#"><i class="fa fa-search"></i></a></td>
                                            <td class="text-left"> <?php echo $uyeModel["AdSoyad"]; ?></td>
                                            <td>
                                                <?php echo $uyeModel["EPosta"]; ?>
                                            </td>
                                            <td class="hidden-xs">Kurumsal</td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row (main row) -->
    </section><!-- /.content -->
</div><!-- /İÇ SAYFA -->