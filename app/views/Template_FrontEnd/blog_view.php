<script src="<?php echo SITE_JS; ?>/blog.js" type="text/javascript"></script>
<section>
    <div id="blogContainer" class="container" style="margin-bottom: 60px; margin-top: 45px;">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2><?php echo $data["Blog"]; ?></h2>
                    <?php if (count($model[1]) > 0) { ?>
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
                    <?php } ?>
                </div>
            </div>
            <div class="col-sm-9">
                <?php if (count($model[0]) > 0) { ?>
                    <ul class="blog-post-area" id=fullblog>
                        <div class="row">
                        <h2 class="title text-center"><?php echo $data["SonYayinlar"]; ?></h2>
                        </div>
                        <?php for ($h = 0; $h < count($model[0]); $h++) { ?>
                            <li class="single-blog-post col-sm-12 col-xs-12">
                                <div class="row">
                                <h3><?php echo $model[0][$h]['Baslik']; ?></h3>
                                <div class="post-meta">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i> <?php echo $model[0][$h]['Tarih']; ?></li>
                                        <li><i class="fa fa-clock-o"></i> <?php echo $model[0][$h]['Saat']; ?></li>
                                    </ul>
                                </div>
                                <div class="col-sm-4 col-xs-12" style="padding-left:0;">
                                    <a href="<?php echo $model[0][$h]['Url']; ?>">
                                        <img class="img-responsive" src="<?php echo SITE_BLOG ?>/<?php echo $model[0][$h]['Resim']; ?>" alt="<?php echo $model[0][$h]['Baslik']; ?>" />
                                    </a>
                                </div>
                                <div class="col-sm-8 col-xs-12">
                                    <p><?php echo strlen($model[0][$h]['Yazi']) > 335 ? substr($model[0][$h]['Yazi'], 0, 335) . "..." : $model[0][$h]['Yazi']; ?></p>
                                    <a  class="btn btn-primary" href="<?php echo $model[0][$h]['Url']; ?>">Devamını Oku</a>
                                </div>
                                <hr/>
                                </div>
                            </li>
                        <?php } ?>
                        <div id="sayfalar" class="pagination-area">
                            <ul id="ulsayfalar" class="pagination">
                            </ul>
                        </div>
                    </ul>
                <?php } ?>
            </div>	
        </div>
    </div>
</section>

