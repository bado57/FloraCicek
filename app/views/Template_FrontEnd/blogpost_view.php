<section>
    <div class="container" style="margin-bottom: 60px; margin-top: 45px;">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2><?php echo $data["Blog"]; ?></h2>
                    <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                        <?php for ($i = 0; $i < count($model[1]); $i++) { ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordian" href="#<?php echo $model[1][$i][0]['Ay']; ?>">
                                            <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                            <?php echo $model[1][$i][0]['Ay']; ?> <?php echo $model[1][$i][0]['Yil']; ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="<?php echo $model[1][$i][0]['Ay']; ?>" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <ul>
                                            <?php for ($f = 0; $f < count($model[1][$i]); $f++) { ?>
                                                <li><a href="<?php echo $model[1][$i][$f]['Url']; ?>"><?php echo $model[1][$i][$f]['Baslik']; ?> </a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <div class="single-blog-post col-sm-12">
                            <h3><i class="fa fa-angle-right"></i> <?php echo $model[0][0]['Baslik']; ?></h3>
                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-calendar"></i> <?php echo $model[0][0]['Tarih']; ?></li>
                                    <li><i class="fa fa-clock-o"></i> <?php echo $model[0][0]['Saat']; ?></li>
                                </ul>
                            </div>
                            <img class="img-responsive" src="<?php echo SITE_BLOG ?>/<?php echo $model[0][0]['Resim']; ?>" alt="" />
                            <br/>
                            <p><?php echo $model[0][0]['Yazi']; ?></p>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</section>

