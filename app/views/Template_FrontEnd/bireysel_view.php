<script src="<?php echo SITE_JS ?>/userform.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<link href="<?php echo SITE_CSS ?>/bootstrap.vertical-tabs.css" rel="stylesheet" type="text/css"/>
<!-- Sipariş adımlarında açılır menünün gizlenmesi için css -->
<style type="text/css">
    #mCollapse{display: none;}
    #orderLink{display: block !important;}
    .footer-top, .footer-widget, .mobile_login_menu, .header-bottom{display: none !important;}
</style>
<!-- End Sipariş adımlarında açılır menünün gizlenmesi için css -->
<div class="body-content">
    <!--iç sayfa-->
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <ul class="nav nav-tabs tabs-left">
                        <li><a href="<?php echo SITE_URL ?>/Home/login" data-icon="fa-sign-in" role="tab" ><?php echo $data["UyeGiris"]; ?></a></li>
                        <li class="active"><a href="<?php echo SITE_URL ?>/Home/bireysel" data-icon="fa-user" role="tab" ><?php echo $data["BirUye"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL ?>/Home/kurumsal" data-icon="fa-briefcase" role="tab" ><?php echo $data["KurUye"]; ?></a></li>
                        <li class="formicon text-center hidden-sm hidden-xs" style="padding-top:40px; text-indent:-10px;">
                            <i class="fa fa-user" style="font-size:70px; color:#808080;"></i>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div class="tab-content">
                        <div class="tab-pane active" id="bireysel">
                            <div class="col-sm-6">
                                <div class="login-form">
                                    <!--login form-->
                                    <h2><?php echo $data["BirUye"]; ?></h2>
                                    <div class="form">
                                        <input type="text" id="birAdSoyad" name="birAdSoyad" placeholder="<?php echo $data["AdSoyad"]; ?>" />
                                        <input type="email" id="birEmail" name="birEmail" placeholder="<?php echo $data["Email"]; ?>" />
                                        <input type="password" id="birSifre" name="birSifre" placeholder="<?php echo $data["Sifre"]; ?>" />
                                        <input type="password" id="birSifreTekrar" name="birSifreTekrar" placeholder="<?php echo $data["SifreTkrar"]; ?>" />
                                        <span>
                                            <input id="kmp-bireysel" type="checkbox" class="checkbox" checked>
                                                <?php echo $data["KmpnyaYnlk"]; ?>
                                        </span>
                                        <p></p>
                                        <span>
                                            <input id="uyesoz-bireysel" name="birUyeSoz" type="checkbox" class="checkbox">
                                                <a role="button" data-toggle="modal" data-target="#uyelikSozlesmesi" style="color:#FE980F;"><?php echo $data["UyelikSoz"]; ?></a> <?php echo $data["OkuKabul"]; ?>.
                                        </span>
                                        <button type="input" id="biruyeol" class="btn btn-default"><?php echo $data["KayıtOl"]; ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/form-->
    <!-- Modal -->
    <div class="modal fade" id="uyelikSozlesmesi" tabindex="-1" role="dialog" aria-labelledby="uyelikSozlesmesiLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="uyelikSozlesmesiLabel">Üyelik Sözleşmesi</h4>
                </div>
                <div class="modal-body">
                    <?php echo $model[0]; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

