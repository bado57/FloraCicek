<section>
    <div class="container" style="margin-bottom: 60px; margin-top: 45px;">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>KURUMSAL</h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <?php
                        for ($ustkat = 0; $ustkat < count($model[6]); $ustkat++) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $model[6][$ustkat]['ID']; ?>">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            <?php echo $model[6][$ustkat]['Adi']; ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="<?php echo $model[6][$ustkat]['ID']; ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            <?php
                                            for ($altkat = 0; $altkat < count($model[7][$ustkat]); $altkat++) {
                                                ?>
                                                <?php if ($model[7][$ustkat][$altkat]['ID'] > 0) { ?>
                                                    <li><a href="<?php echo $model[7][$ustkat][$altkat]['Url']; ?>"><?php echo $model[7][$ustkat][$altkat]['Adi']; ?></a></li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <hr>
                        <?php if (Session::get("KRol") == "") { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="<?php echo SITE_URL ?>/Home/kurumsal">Kurumsal Üyelik</a></h4>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="<?php echo SITE_URL ?>/Home/bireysel">Bireysel Üyelik</a></h4>
                                </div>
                            </div>
                        <?php } else if (Session::get("KID") == 0) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="<?php echo SITE_URL ?>/Home/kurumsal">Kurumsal Üyelik</a></h4>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center"><?php echo $model[9][0]["Adi"]; ?></h2>
                    <div class="single-blog-post">
                        <?php if ($model[9][0]["Resim"] != '') { ?>
                            <img class="img-responsive" src="<?php echo SITE_SAYFA ?>/<?php echo $model[9][0]["Resim"]; ?>" alt="Türkiye Flora Çiçek-"<?php echo $model[9][0]["Adi"]; ?> />
                        <?php } ?>
                        <h3><?php echo $model[9][0]["Adi"]; ?></h3>
                        <?php echo $model[9][0]["Yazi"]; ?>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</section>