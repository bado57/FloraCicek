<div id="contact-page" class="container" style="margin-top:20px;padding-top: 30px;">
    <div class="bg">
        <div class="row">    		
            <div class="col-sm-12">    			   			
                <h2 class="title text-center">İLETİŞİM</h2>
                <iframe class="contact-map" src="<?php echo $model[8]["iframe"]; ?>" width="100%" height="385"></iframe>
            </div>			 		
        </div>    	
        <div class="row">  	
            <div class="col-sm-8">
                <div class="contact-form">
                    <h2 class="title text-center">BİZE YAZIN</h2>
                    <div class="status alert alert-success" style="display: none"></div>
                    <?php if (Session::get("KID") <= 0) { ?>
                        <div class="form-group col-md-6">
                            <input type="text" id="iletisimname" name="name" class="form-control" required="required" placeholder="Ad Soyad">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" id="iletisimemail" name="email" class="form-control" required="required" placeholder="Email">
                        </div>
                    <?php } ?>
                    <div class="form-group col-md-12">
                        <input type="text" id="iletisimsubject" name="subject" class="form-control" required="required" placeholder="Konu">
                    </div>
                    <div class="form-group col-md-12">
                        <textarea name="message" id="iletisimmessage" required="required" class="form-control" rows="8" placeholder="Mesajınız"></textarea>
                    </div>                        
                    <div class="form-group col-md-12">
                        <input type="button" id="iletisimsubmit" name="submit" class="btn btn-primary pull-right" value="Gönder">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="contact-info">
                    <h2 class="title text-center">ADRES</h2>
                    <address>
                        <p><b>Nur Flora Çiçekçilik</b></p>
                        <p><?php echo $model[8]["adres"]; ?></p>
                        <hr>
                        <p><i class="fa fa-phone-square"></i> <?php echo $model[8]["telefon"]; ?></p>
                        <p><i class="fa fa-print"></i> <?php echo $model[8]["fax"]; ?></p>
                        <p><i class="fa fa-envelope-square"></i> <?php echo $model[8]["mail"]; ?></p>
                    </address>
                    <div class="social-networks">
                        <h2 class="title text-center">SOSYAL MEDYA</h2>
                        <ul>
                            <li>
                                <a href="<?php echo $model[8]["face"]; ?>" target="_blank"><i class="fa fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo $model[8]["twit"]; ?>" target="_blank"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo $model[8]["gplus"]; ?>" target="_blank"><i class="fa fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="<?php echo $model[8]["instag"]; ?>" target="_blank"><i class="fa fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>    			
        </div>  
    </div>	
</div>
