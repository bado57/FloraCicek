</div>

<footer id="footer">
    <!--Footer-->
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <div class="companyinfo">
                        <img class="img-responsive" src="<?php echo SITE_IMAGES ?>/footer-logo.png" alt="" />
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <div class="iframe-img">
                                <img src="<?php echo SITE_IMAGES ?>/ssl-secure-logo.png" alt="" />
                            </div>
                            <p>256 Bit</p>
                            <h2>SSL Secure</h2>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <div class="iframe-img">
                                <img src="<?php echo SITE_IMAGES ?>/master-card.png" alt="" />
                            </div>
                            <p>Master</p>
                            <h2>Card</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <div class="iframe-img">
                                <img src="<?php echo SITE_IMAGES ?>/visa-card.png" alt="" />
                            </div>
                            <p>Visa</p>
                            <h2>Card</h2>
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="video-gallery text-center">
                            <div class="iframe-img">
                                <img src="<?php echo SITE_IMAGES ?>/guvenli-alisveris.png" alt="" />
                            </div>
                            <p>Güvenli</p>
                            <h2>Alışveriş</h2>
                        </div>
                    </div>
                </div>
                <?php if (Session::get("KRol") == 2 || Session::get("KRol") == 1) { ?>

                <?php } else { ?>
                    <div class="col-sm-3">
                        <div class="address">
                            <a href="<?php echo SITE_URL ?>/Home/kurumsal">
                                <img src="<?php echo SITE_IMAGES ?>/map.png" alt="" />
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="footer-widget">
        <div class="container">
            <div class="row">
                <?php for ($ustkat = 0; $ustkat < count($model[6]); $ustkat++) { ?>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2><?php echo $model[6][$ustkat]['Adi']; ?></h2>
                            <ul class="nav nav-pills nav-stacked">
                                <?php for ($altkat = 0; $altkat < count($model[7][$ustkat]); $altkat++) { ?>
                                    <?php if ($model[7][$ustkat][$altkat]['ID'] > 0) { ?>
                                        <li><a href="<?php echo $model[7][$ustkat][$altkat]['Url']; ?>"><?php echo $model[7][$ustkat][$altkat]['Adi']; ?></a></li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-sm-2">
                    <div class="single-widget">
                        <h2>İletişim</h2>
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="<?php echo SITE_URL . '/Home/Contact'; ?>">Adres Bilgileri</a></li>
                            <li><a href="<?php echo SITE_URL . '/Home/Contact'; ?>">İletişim Formu</a></li>
                            <li><a href="<?php echo SITE_URL . '/Home/Contact'; ?>">Harita</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-sm-offset-1">
                    <div class="single-widget">
                        <?php if (Session::get("EBulten") <= 0) { ?>
                            <h2 id="h2ebulten">E-Bülten</h2>
                            <div class="searchform" id="divebulten">
                                <input id="inputebulten" type="email" required placeholder="E-mail adresiniz" />
                                <button id="btnebulten" type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>E-mail adresinizle üye olun,<br />kampanya ve indirimlerden yararlanın! </p>
                            </div>
                        <?php } ?>
                        <div class="social-icons">
                            <ul class="nav navbar-nav">
                                <li><a href="<?php echo $model[8]["face"]; ?>" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="<?php echo $model[8]["twit"]; ?>" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="<?php echo $model[8]["gplus"]; ?>" title="Google+" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="<?php echo $model[8]["instag"]; ?>" title="Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function () {
            $("[data-mask]").inputmask();
        });
    </script>
