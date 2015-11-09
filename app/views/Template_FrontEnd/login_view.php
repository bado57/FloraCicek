<script src="<?php echo SITE_JS ?>/userform.js"></script>
<script src="<?php echo SITE_JS ?>/jquery.validate.js"></script>
<link href="<?php echo SITE_CSS ?>/bootstrap.vertical-tabs.css" rel="stylesheet" type="text/css"/>
<div class="body-content">
    <!--iç sayfa-->
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <ul class="nav nav-tabs tabs-left">
                        <li class="active"><a href="<?php echo SITE_URL ?>/Home/login" data-icon="fa-sign-in" role="tab" ><?php echo $data["UyeGiris"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL ?>/Home/bireysel" data-icon="fa-user" role="tab" ><?php echo $data["BirUye"]; ?></a></li>
                        <li><a href="<?php echo SITE_URL ?>/Home/kurumsal" data-icon="fa-briefcase" role="tab"><?php echo $data["KurUye"]; ?></a></li>
                        <li class="formicon text-center hidden-sm hidden-xs" style="padding-top:40px; text-indent:-10px;">
                            <i class="fa fa-sign-in" style="font-size:70px; color:#808080;"></i>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-10">
                    <div class="tab-content">
                        <div class="tab-pane active" id="uyegiris">
                            <form id="formgirisyap">
                                <div class="col-sm-6">
                                    <div class="login-form">
                                        <!--login form-->
                                        <h2><?php echo $data["KullaniciBilgi"]; ?></h2>
                                        <div class="form">
                                            <input type="email" id="girisemail" name="girisemail" placeholder="<?php echo $data["Email"]; ?>" />
                                            <input type="password" id="girissifre" name="girissifre" placeholder="<?php echo $data["Sifre"]; ?>" />
                                            <label class="checkbox-inline" style="margin-top:10px;"><input id="hatirlaCheck" type="checkbox" name="hatirlaCheck"><?php echo $data["BeniHatirla"]; ?></label>
                                            <a role="button" class="sfrhtr pull-right" style="margin-top:10px;"><?php echo $data["SifreUnut"]; ?></a>
                                            <button type="input" id="btnGiris" class="btn btn-default"><?php echo $data["Giris"]; ?></button>
                                        </div>
                                    </div><!--/login form-->
                                </div>
                            </form>
                            <form action="#">
                                <div class="col-sm-6">
                                    <div class="login-form sifreHatirlat" style="display:none;">
                                        <!--login form-->
                                        <h2><?php echo $data["SifreHatirla"]; ?> <a role="button" class="sfrhtrKapat pull-right"><i class="fa fa-times-circle"></i></a></h2>
                                        <div class="form">
                                            <input type="email" placeholder="<?php echo $data["EmailAdres"]; ?>" />
                                            <input type="text" placeholder="12 + 5 = ?" />
                                            <label style="margin-top:10px;">* <?php echo $data["EksiksizBilgi"]; ?></label>
                                            <button type="input" class="btn btn-default"><?php echo $data["Hatirlat"]; ?></button>
                                        </div>
                                    </div><!--/login form-->
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="bireysel">
                        </div>
                        <div class="tab-pane" id="kurumsal">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/form-->

    <script type="text/javascript">
        $(document).ready(function () {
            $(".sfrhtr").on("click", function () {
                $(".sifreHatirlat").slideToggle("fast");
            });

            $(".sfrhtrKapat").on("click", function () {
                $(".sifreHatirlat").slideUp("fast");
            });
        });
    </script>

