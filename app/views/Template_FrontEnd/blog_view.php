<section>
    <div class="container" style="margin-bottom: 60px; margin-top: 45px;">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>YAYINLAR</h2>
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
                    </div><!--/category-products-->
                </div>
            </div>
            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Son Haberler</h2>
                    <?php for ($h = 0; $h < count($model[0]); $h++) { ?>
                        <div class="single-blog-post col-sm-12">
                            <h3><?php echo $model[0][$h]['Baslik']; ?></h3>
                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-calendar"></i> <?php echo $model[0][$h]['Tarih']; ?></li>
                                    <li><i class="fa fa-clock-o"></i> <?php echo $model[0][$h]['Saat']; ?></li>
                                </ul>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                <a href="<?php echo $model[0][$h]['Url']; ?>">
                                    <img class="img-responsive" src="<?php echo SITE_BLOG ?>/<?php echo $model[0][$h]['Resim']; ?>" alt="" />
                                </a>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <p><?php echo strlen($model[0][$h]['Yazi']) > 335 ? substr($model[0][$h]['Yazi'], 0, 335) . "..." : $model[0][$h]['Yazi']; ?></p>
                                <a  class="btn btn-primary" href="<?php echo $model[0][$h]['Url']; ?>">Devamını Oku</a>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="pagination-area">
                        <ul class="pagination">
                            <li><a href="" class="active">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href=""><i class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>	
        </div>
    </div>
</section>

