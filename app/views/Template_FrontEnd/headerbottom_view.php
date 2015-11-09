<div class="header-bottom">
    <!--header-bottom-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-12 menuDiv">
                    <div class="mainmenu">
                        <ul class="nav navbar-nav collapse navbar-collapse" style="padding-right:0;">
                            <li class="dropdown">
                                <a href="#"><?php echo $data["AmacaGore"] ?></a>
                                <ul role="menu" class="sub-menu">
                                    <?php foreach ($model[0] as $etiketModel) { ?>
                                        <li><a href="<?php echo $etiketModel['etiketUrl']; ?>"><?php echo $etiketModel['etiketAd']; ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php for ($ustkat = 0; $ustkat < count($model[1]); $ustkat++) { ?>
                                <li class="dropdown">
                                    <a href=""><?php echo $model[1][$ustkat]['Adi']; ?></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php for ($altkat = 0; $altkat < count($model[2][$ustkat]); $altkat++) { ?>
                                            <?php if ($model[2][$ustkat][$altkat]['ID'] != '') { ?>
                                                <li><a href="<?php echo $model[2][$ustkat][$altkat]['Url']; ?>"><?php echo $model[2][$ustkat][$altkat]['Adi']; ?></a></li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <?php if (count($model[3]) > 0) { ?>
                                <li class="dropdown">
                                    <a href="#"><?php echo $data["Kampanya"] ?></a>
                                    <ul role="menu" class="sub-menu">
                                        <?php foreach ($model[3] as $etiketModel) { ?>
                                            <li><a href="<?php echo $etiketModel['Url']; ?>"><?php echo $etiketModel['Adi']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <li class="dropdown">
                                <a href="blog"><?php echo $data["Blog"] ?></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div><!--/header-bottom-->

</header><!--/header-->

<div class="body-content">