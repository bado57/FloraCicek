<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo SITE_DIST; ?>/img/user.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php echo Session::get("KAdSoyad"); ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Site Yöneticisi</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">İŞLEMLER</li>
            <li class="active">
                <a href="<?php echo SITE_URL; ?>/Admin/Panel">
                    <i class="fa fa-home"></i> <span>Anasayfa</span>
                </a>
            </li>
            <li>
                <a href="<?php echo SITE_URL; ?>/Admin/Siparis">
                    <i class="fa fa-clock-o"></i> <span>Bekleyen Siparişler</span> <small class="label pull-right bg-red">1</small>
                </a>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-shopping-cart"></i> <span>Sipariş İşlemleri</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Siparis"><i class="fa fa-clock-o"></i> <span>Siparişler</span> <small class="label pull-right bg-red">1</small></a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Banka"><i class="fa fa-circle-o"></i> Banka Hesapları</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Kargo"><i class="fa fa-circle-o"></i> Kargo Firmaları</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Gonderimyeri"><i class="fa fa-circle-o"></i> Gönderim Yerleri</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Gonderimnedeni"><i class="fa fa-circle-o"></i> Gönderim Nedenleri</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Ililce"><i class="fa fa-circle-o"></i> İller & İlçeler</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo SITE_URL; ?>/Admin/Kampanya"><i class="fa fa-gift"></i> <span>Kampanya İşlemleri</span> <small class="label pull-right bg-green">2</small></a>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-cube"></i> <span>Ürün İşlemleri</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo SITE_URL; ?>/Admin/UrunKategori"><i class="fa fa-circle-o"></i> Kategoriler</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Etiket"><i class="fa fa-circle-o"></i> Etiketler</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Urun"><i class="fa fa-circle-o"></i> Ürünler</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Ek Ürünler</a></li>
                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-user"></i> <span>Üye İşlemleri</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Kurumsal Üyeler</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Bireysel Üyeler</a></li>
                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-envelope"></i> <span>Mail İşlemleri</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Yeni Mail Oluştur</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Mail Şablonları</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Kurumsal Mail Havuzu</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Bireysel Mail Havuzu</a></li>
                </ul>
            </li>
            <li class=" treeview">
                <a href="#">
                    <i class="fa fa-desktop"></i> <span>Site İşlemleri</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo SITE_URL; ?>/Admin/Vitrin"><i class="fa fa-circle-o"></i> Vitrin İşlemleri</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/SabitSayfa"><i class="fa fa-circle-o"></i> Sabit Sayfalar</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/SabitIcerik"><i class="fa fa-circle-o"></i> Sabit İçerikler</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/Admin/BlogYazi"><i class="fa fa-circle-o"></i> Blog Yazıları</a></li>
                </ul>
            </li>
            <li>
                <a href="<?php echo SITE_URL; ?>" target="_blank">
                    <i class="fa fa-arrow-circle-right"></i> <span>Siteyi Görüntüle</span></i>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside><!-- /SOL MENÜ -->