<script src="<?php echo SITE_FRONT_JS ?>/userform.js"></script>
<script src="<?php echo SITE_FRONT_JS ?>/jquery.validate.js"></script>
<link href="<?php echo SITE_FRONT_CSS ?>/bootstrap.vertical-tabs.css" rel="stylesheet" type="text/css"/>
<div class="body-content">
    <!--iç sayfa-->
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <ul class="nav nav-tabs tabs-left">
                        <li ><a href="<?php echo SITE_URL ?>/Home/login" data-icon="fa-sign-in" role="tab" ><?php echo $data["UyeGiris"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL ?>/Home/bireysel" data-icon="fa-user" role="tab" ><?php echo $data["BirUye"]; ?></a></li>
                        <li class="active"><a href="<?php echo SITE_URL ?>/Home/kurumsal" data-icon="fa-briefcase" role="tab" ><?php echo $data["KurUye"]; ?></a></li>
                        <li class="formicon text-center hidden-sm hidden-xs" style="padding-top:40px; text-indent:-10px;">
                            <i class="fa fa-sign-in" style="font-size:70px; color:#808080;"></i>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div class="tab-content">
                        <div class="tab-pane" id="uyegiris">
                        </div>
                        <div class="tab-pane" id="bireysel">
                        </div>
                        <div class="tab-pane active" id="kurumsal">
                            <form id="kuruyeform">
                                <div class="col-sm-6">
                                    <div class="login-form">
                                        <!--login form-->
                                        <h2><?php echo $data["KurUye"]; ?></h2>
                                        <div class="form">
                                            <input type="text" id="kurAdSoyad" name="kurAdSoyad" placeholder="<?php echo $data["AdSoyad"]; ?>" />
                                            <input type="email" id="kurEmail" name="kurEmail" placeholder="<?php echo $data["Email"]; ?>" />
                                            <input type="password" id="kurSifre" name="kurSifre" placeholder="<?php echo $data["Sifre"]; ?>" />
                                            <input type="password" id="kurSifreTekrar" name="kurSifreTekrar" placeholder="<?php echo $data["SifreTkrar"]; ?>" />
                                            <span>
                                                <input id="kmp-bireysel" type="checkbox" class="checkbox" checked>
                                                    <?php echo $data["KmpnyaYnlk"]; ?>
                                            </span>
                                            <p></p>
                                            <span>
                                                <input id="uyesoz-bireysel" name="kurUyeSoz" type="checkbox" class="checkbox">
                                                    <a role="button" data-toggle="modal" data-target="#uyelikSozlesmesi" style="color:#FE980F;"><?php echo $data["UyelikSoz"]; ?></a> <?php echo $data["OkuKabul"]; ?>.
                                            </span>
                                            <button type="button" id="kuruyeol" class="btn btn-default"><?php echo $data["KayıtOl"]; ?></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="login-form">
                                        <div class="form" style="padding-top:21px;">
                                            <input type="text" id="kurAdi" name="kurAdi" required placeholder="<?php echo $data["KurAdi"]; ?>" />
                                            <input type="text" id="kurVDaire" name="kurVDaire" required placeholder="<?php echo $data["VergiDaire"]; ?>" />
                                            <input type="text" id="kurVNo" name="kurVNo" required placeholder="<?php echo $data["VergiNo"]; ?>" />
                                            <input type="text" id="kurVTel" name="kurVTel" required placeholder="<?php echo $data["Telefon"]; ?>" />
                                            <textarea id="adres" rows="3" placeholder="<?php echo $data["Adres"]; ?>"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </form>
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

