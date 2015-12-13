<?php

class AdminVitrin extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->ajaxCall();
    }

    public function ajaxCall() {
        //session güvenlik kontrolü
        $form = $this->load->otherClasses('Form');

        if ($_POST && $_SERVER["HTTP_X_REQUESTED_WITH"] == "XMLHttpRequest") {
            $sonuc = array();
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");

            $form->post("tip", true);
            $tip = $form->values['tip'];

            Switch ($tip) {

                case "vitrinSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deletevitrin = $Panel_Model->vitrinDelete($ID);
                    if ($deletevitrin) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;

                case "vitrinDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $vitrinListe = array();

                    $vitrinListe = $Panel_Model->panelVitrinListe($ID);
                    foreach ($vitrinListe as $vitrinListee) {
                        $vitrinlist['ID'] = $vitrinListee['vitrin_ID'];
                        $vitrinlist['Resim'] = $vitrinListee['vitrin_resimpath'];
                        $vitrinlist['Baslik'] = $vitrinListee['vitrin_baslik'];
                        $vitrinlist['Yazi'] = $vitrinListee['vitrin_yazi'];
                        $vitrinlist['Url'] = $vitrinListee['vitrin_url'];
                        $vitrinlist['Aktif'] = $vitrinListee['vitrin_aktiflik'];
                        $vitrinlist['Sira'] = $vitrinListee['vitrin_sira'];
                        $vitrinlist['AltBaslik'] = $vitrinListee['vitrin_altbaslik'];
                        $vitrinlist['Button'] = $vitrinListee['vitrin_buttonyazi'];
                    }

                    $sonuc["result"] = $vitrinlist;
                    break;

                case "vitrinEkle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("sira", true);
                    $form->post("degisecekID", true);
                    $form->post("maksSira", true);
                    $form->post("aktiflik", true);
                    $baslik = $_POST['baslik'];
                    $yazi = $_POST['yazi'];
                    $sira = $form->values['sira'];
                    $degisecekID = $form->values['degisecekID'];
                    $sonUstSira = $form->values['maksSira'];
                    $altbaslik = $_POST['altbaslik'];
                    $buttonyazi = $_POST['buttonyazi'];
                    $aktiflik = $form->values['aktiflik'];
                    $adres = $_POST['adres'];

                    if ($baslik == "") {
                        $sonuc["hata"] = "Lütfen Vitrin Başlığını Giriniz.";
                    } else {
                        if ($buttonyazi == "") {
                            $sonuc["hata"] = "Lütfen Buton Yazısını Giriniz.";
                        } else {
                            if ($adres == "") {
                                $sonuc["hata"] = "Lütfen Url Giriniz.";
                            } else {
                                if ($sira <= 0) {
                                    $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                } else {
                                    $realName = $_FILES['file']['name'];
                                    if ($realName == "") {
                                        $sonuc["hata"] = "Lütfen Resim Seçiniz";
                                    } else {
                                        $image = new Upload($_FILES['file']);
                                        //oranlama
                                        $width = $image->image_src_x;
                                        $height = $image->image_src_y;
                                        $oran = $width / $height;
                                        if ($oran < 1) {
                                            $newheight = 400;
                                            $newwidth = round($height * $oran);
                                        } else if ($oran == 1) {
                                            $newheight = 400;
                                            $newwidth = 500;
                                        } else {
                                            $newheight = round($width / $oran);
                                            $newwidth = 500;
                                        }
                                        if ($image->uploaded) {
                                            // sadece resim formatları yüklensin
                                            $image->allowed = array('image/*');
                                            $image->image_min_height = 250;
                                            $image->image_min_width = 250;
                                            $image->image_max_height = 2000;
                                            $image->image_max_width = 2000;
                                            $image->file_new_name_body = time();
                                            $image->file_name_body_pre = 'flora_';
                                            $image->image_resize = true;
                                            $image->image_ratio_crop = false;
                                            $image->image_x = $width;
                                            $image->image_y = $height;
                                            $image->image_watermark = 'images/watermark.png';
                                            $image->image_watermark_position = 'B';

                                            $image->Process("vitrin");
                                            if ($image->processed) {
                                                if ($degisecekID > 0) {//değişecek vardır
                                                    if ($form->submit()) {
                                                        $data = array(
                                                            'vitrin_sira' => $sonUstSira + 1
                                                        );
                                                    }
                                                    $vitrinUpdate = $Panel_Model->vitrinSiraUpdate($data, $degisecekID);
                                                    if ($vitrinUpdate) {
                                                        if ($form->submit()) {
                                                            $dataV = array(
                                                                'vitrin_resimpath' => $image->file_dst_name,
                                                                'vitrin_anaresim' => $realName,
                                                                'vitrin_baslik' => $baslik,
                                                                'vitrin_yazi' => $yazi,
                                                                'vitrin_url' => $adres,
                                                                'vitrin_aktiflik' => $aktiflik,
                                                                'vitrin_sira' => $sira,
                                                                'vitrin_altbaslik' => $altbaslik,
                                                                'vitrin_buttonyazi' => $buttonyazi
                                                            );
                                                        }
                                                        $result = $Panel_Model->vitrinekle($dataV);
                                                        if ($result) {
                                                            $sonuc["result"] = "1";
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    if ($form->submit()) {
                                                        $dataV = array(
                                                            'vitrin_resimpath' => $image->file_dst_name,
                                                            'vitrin_anaresim' => $realName,
                                                            'vitrin_baslik' => $baslik,
                                                            'vitrin_yazi' => $yazi,
                                                            'vitrin_url' => $adres,
                                                            'vitrin_aktiflik' => $aktiflik,
                                                            'vitrin_sira' => $sira,
                                                            'vitrin_altbaslik' => $altbaslik,
                                                            'vitrin_buttonyazi' => $buttonyazi
                                                        );
                                                    }
                                                    $result = $Panel_Model->vitrinekle($dataV);
                                                    if ($result) {
                                                        $sonuc["result"] = "1";
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                }
                                            } else {
                                                $sonuc["hata"] = $image->error;
                                            }
                                        } else {
                                            $sonuc["hata"] = $image->error;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "vitrinDuzenle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("ID", true);
                    $form->post("sira", true);
                    $form->post("degisecekID", true);
                    $form->post("maksSira", true);
                    $form->post("aktiflik", true);
                    $form->post("resimKontrol", true);
                    $form->post("newImage", true);
                    $form->post("normalSira", true);
                    $baslik = $_POST['baslik'];
                    $id = $form->values['ID'];
                    $yazi = $_POST['yazi'];
                    $sira = $form->values['sira'];
                    $degisecekID = $form->values['degisecekID'];
                    $sonUstSira = $form->values['maksSira'];
                    $altbaslik = $_POST['altbaslik'];
                    $buttonyazi = $_POST['buttonyazi'];
                    $aktiflik = $form->values['aktiflik'];
                    $adres = $_POST['adres'];
                    $resimKontrol = $form->values['resimKontrol'];
                    $newImage = $form->values['newImage'];
                    $normalSira = $form->values['normalSira'];

                    if ($baslik == "") {
                        $sonuc["hata"] = "Lütfen Vitrin Başlığını Giriniz.";
                    } else {
                        if ($buttonyazi == "") {
                            $sonuc["hata"] = "Lütfen Buton Yazısını Giriniz.";
                        } else {
                            if ($adres == "") {
                                $sonuc["hata"] = "Lütfen Url Giriniz.";
                            } else {
                                if ($sira <= 0) {
                                    $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                } else {
                                    if ($resimKontrol == 0) {
                                        $sonuc["hata"] = "Lütfen Ürün Resmi Giriniz.";
                                    } else {
                                        if ($newImage == 0) {//yeni resim eklenmemiş
                                            if ($degisecekID > 0) {//değişecek vardır
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'vitrin_sira' => $normalSira
                                                    );
                                                }
                                                $vitrinUpdate = $Panel_Model->vitrinSiraUpdate($data, $degisecekID);
                                                if ($vitrinUpdate) {
                                                    if ($form->submit()) {
                                                        $dataV = array(
                                                            'vitrin_baslik' => $baslik,
                                                            'vitrin_yazi' => $yazi,
                                                            'vitrin_url' => $adres,
                                                            'vitrin_aktiflik' => $aktiflik,
                                                            'vitrin_sira' => $sira,
                                                            'vitrin_altbaslik' => $altbaslik,
                                                            'vitrin_buttonyazi' => $buttonyazi
                                                        );
                                                    }
                                                    $result = $Panel_Model->vitrinUpdate($dataV, $id);
                                                    if ($result) {
                                                        $sonuc["result"] = "1";
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                if ($form->submit()) {
                                                    $dataV = array(
                                                        'vitrin_baslik' => $baslik,
                                                        'vitrin_yazi' => $yazi,
                                                        'vitrin_url' => $adres,
                                                        'vitrin_aktiflik' => $aktiflik,
                                                        'vitrin_sira' => $sira,
                                                        'vitrin_altbaslik' => $altbaslik,
                                                        'vitrin_buttonyazi' => $buttonyazi
                                                    );
                                                }
                                                $result = $Panel_Model->vitrinUpdate($dataV, $id);
                                                if ($result) {
                                                    $sonuc["result"] = "1";
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            }
                                        } else {
                                            $realName = $_FILES['file']['name'];
                                            $image = new Upload($_FILES['file']);
                                            //oranlama
                                            $width = $image->image_src_x;
                                            $height = $image->image_src_y;
                                            $oran = $width / $height;
                                            if ($oran < 1) {
                                                $newheight = 400;
                                                $newwidth = round($height * $oran);
                                            } else if ($oran == 1) {
                                                $newheight = 400;
                                                $newwidth = 500;
                                            } else {
                                                $newheight = round($width / $oran);
                                                $newwidth = 500;
                                            }
                                            if ($image->uploaded) {
                                                // sadece resim formatları yüklensin
                                                $image->allowed = array('image/*');
                                                $image->image_min_height = 250;
                                                $image->image_min_width = 250;
                                                $image->image_max_height = 2000;
                                                $image->image_max_width = 2000;
                                                $image->file_new_name_body = time();
                                                $image->file_name_body_pre = 'flora_';
                                                $image->image_resize = true;
                                                $image->image_ratio_crop = false;
                                                $image->image_x = $width;
                                                $image->image_y = $height;

                                                $image->Process("vitrin");
                                                if ($image->processed) {
                                                    if ($degisecekID > 0) {//değişecek vardır
                                                        if ($form->submit()) {
                                                            $data = array(
                                                                'vitrin_sira' => $normalSira
                                                            );
                                                        }
                                                        $vitrinUpdate = $Panel_Model->vitrinSiraUpdate($data, $degisecekID);
                                                        if ($vitrinUpdate) {
                                                            if ($form->submit()) {
                                                                $dataV = array(
                                                                    'vitrin_resimpath' => $image->file_dst_name,
                                                                    'vitrin_anaresim' => $realName,
                                                                    'vitrin_baslik' => $baslik,
                                                                    'vitrin_yazi' => $yazi,
                                                                    'vitrin_url' => $adres,
                                                                    'vitrin_aktiflik' => $aktiflik,
                                                                    'vitrin_sira' => $sira,
                                                                    'vitrin_altbaslik' => $altbaslik,
                                                                    'vitrin_buttonyazi' => $buttonyazi
                                                                );
                                                            }
                                                            $result = $Panel_Model->vitrinUpdate($dataV, $id);
                                                            if ($result) {
                                                                $sonuc["result"] = "1";
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        if ($form->submit()) {
                                                            $dataV = array(
                                                                'vitrin_resimpath' => $image->file_dst_name,
                                                                'vitrin_anaresim' => $realName,
                                                                'vitrin_baslik' => $baslik,
                                                                'vitrin_yazi' => $yazi,
                                                                'vitrin_url' => $adres,
                                                                'vitrin_aktiflik' => $aktiflik,
                                                                'vitrin_sira' => $sira,
                                                                'vitrin_altbaslik' => $altbaslik,
                                                                'vitrin_buttonyazi' => $buttonyazi
                                                            );
                                                        }
                                                        $result = $Panel_Model->vitrinUpdate($dataV, $id);
                                                        if ($result) {
                                                            $sonuc["result"] = "1";
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    }
                                                } else {
                                                    $sonuc["hata"] = $image->error;
                                                }
                                            } else {
                                                $sonuc["hata"] = $image->error;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "sabitIcerikEkle":

                    $telefon = $_POST['telefon'];
                    $fax = $_POST['fax'];
                    $iletisimmail = $_POST['iletisimmail'];
                    $harita = $_POST['harita'];
                    $facebook = $_POST['facebook'];
                    $twitter = $_POST['twitter'];
                    $instagram = $_POST['instagram'];
                    $googleplus = $_POST['googleplus'];
                    $adres = $_POST['adres'];
                    $yoneticimail = $_POST['yoneticimail'];
                    $yoneticimailek = $_POST['yoneticimailek'];
                    $uyelikSoz = $_POST['uyelikSoz'];
                    $onBilgi = $_POST['onBilgi'];
                    $mesafeliSatis = $_POST['mesafeliSatis'];
                    $gizlilikSoz = $_POST['gizlilikSoz'];
                    $hizmetSoz = $_POST['hizmetSoz'];
                    $teslimatSart = $_POST['teslimatSart'];
                    $form->post("newimage", true);
                    $newImage = $form->values['newImage'];

                    $ayarSelect = $Panel_Model->panelsabiticerikler();
                    foreach ($ayarSelect as $ayarSelectt) {
                        $ayarlist['ID'] = $ayarSelectt['sbt_id'];
                    }
                    if (count($ayarSelect) > 0) {//güncelleme olmalı
                        if ($newImage == 0) {//yeni resim eklenmemiş
                            if ($form->submit()) {
                                $dataA = array(
                                    'sbt_uyeliksoz' => $uyelikSoz,
                                    'sbt_hzmtsoz' => $hizmetSoz,
                                    'sbt_gzllksoz' => $gizlilikSoz,
                                    'sbt_mesafelistssoz' => $mesafeliSatis,
                                    'sbt_tslmatsart' => $teslimatSart,
                                    'sbt_onbilgilendirmeform' => $onBilgi,
                                    'sbt_telefon' => $telefon,
                                    'sbt_fax' => $fax,
                                    'sbt_adres' => $adres,
                                    'sbt_haritaiframe' => $harita,
                                    'sbt_iletisimmail' => $iletisimmail,
                                    'sbt_yonetmail2' => $yoneticimailek,
                                    'sbt_yonetmail1' => $yoneticimail,
                                    'sbt_face' => $facebook,
                                    'sbt_twit' => $twitter,
                                    'sbt_instag' => $instagram,
                                    'sbt_gplus' => $googleplus
                                );
                            }
                            $result = $Panel_Model->sabitIcerikUpdate($dataA, $ayarlist['ID']);
                            if ($result) {
                                $sonuc["result"] = "1";
                            } else {
                                $sonuc["hata"] = "Tekrar Deneyiniz";
                            }
                        } else {
                            $realName = $_FILES['file']['name'];
                            $image = new Upload($_FILES['file']);
                            //oranlama
                            $width = $image->image_src_x;
                            $height = $image->image_src_y;
                            if ($image->uploaded) {
                                // sadece resim formatları yüklensin
                                $image->allowed = array('image/*');
                                $image->image_min_height = 100;
                                $image->image_min_width = 100;
                                $image->image_max_height = 2000;
                                $image->image_max_width = 2000;
                                $image->file_new_name_body = time();
                                $image->file_name_body_pre = 'flora_';
                                $image->image_resize = true;
                                $image->image_ratio_crop = false;
                                $image->image_x = $width;
                                $image->image_y = $height;

                                $image->Process("vitrin");
                                if ($image->processed) {
                                    if ($form->submit()) {
                                        $dataA = array(
                                            'sbt_telefon' => $telefon,
                                            'sbt_fax' => $fax,
                                            'sbt_adres' => $adres,
                                            'sbt_haritaiframe' => $harita,
                                            'sbt_iletisimmail' => $iletisimmail,
                                            'sbt_yonetmail2' => $yoneticimailek,
                                            'sbt_yonetmail1' => $yoneticimail,
                                            'sbt_face' => $facebook,
                                            'sbt_twit' => $twitter,
                                            'sbt_instag' => $instagram,
                                            'sbt_gplus' => $googleplus,
                                            'sbt_logo' => $image->file_dst_name,
                                            'sbt_logoreal' => $realName,
                                        );
                                    }
                                    $result = $Panel_Model->sabiticerikekle($dataA);
                                    if ($result) {
                                        $sonuc["result"] = "1";
                                    } else {
                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                    }
                                } else {
                                    $sonuc["hata"] = $image->error;
                                }
                            } else {
                                $sonuc["hata"] = $image->error;
                            }
                        }
                    } else {//insert olmalı
                        $realName = $_FILES['file']['name'];
                        $image = new Upload($_FILES['file']);
                        //oranlama
                        $width = $image->image_src_x;
                        $height = $image->image_src_y;
                        if ($image->uploaded) {
                            // sadece resim formatları yüklensin
                            $image->allowed = array('image/*');
                            $image->image_min_height = 100;
                            $image->image_min_width = 100;
                            $image->image_max_height = 2000;
                            $image->image_max_width = 2000;
                            $image->file_new_name_body = time();
                            $image->file_name_body_pre = 'flora_';
                            $image->image_resize = true;
                            $image->image_ratio_crop = false;
                            $image->image_x = $width;
                            $image->image_y = $height;

                            $image->Process("vitrin");
                            if ($image->processed) {
                                if ($form->submit()) {
                                    $dataA = array(
                                        'sbt_telefon' => $telefon,
                                        'sbt_fax' => $fax,
                                        'sbt_adres' => $adres,
                                        'sbt_haritaiframe' => $harita,
                                        'sbt_iletisimmail' => $iletisimmail,
                                        'sbt_yonetmail2' => $yoneticimailek,
                                        'sbt_yonetmail1' => $yoneticimail,
                                        'sbt_face' => $facebook,
                                        'sbt_twit' => $twitter,
                                        'sbt_instag' => $instagram,
                                        'sbt_gplus' => $googleplus,
                                        'sbt_logo' => $image->file_dst_name,
                                        'sbt_logoreal' => $realName,
                                    );
                                }
                                $result = $Panel_Model->sabiticerikekle($dataA);
                                if ($result) {
                                    $sonuc["result"] = "1";
                                } else {
                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                }
                            } else {
                                $sonuc["hata"] = $image->error;
                            }
                        } else {
                            $sonuc["hata"] = $image->error;
                        }
                    }

                    break;

                case "blogSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deleteblog = $Panel_Model->blogDelete($ID);
                    if ($deleteblog) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;

                case "blogEkle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("aktiflik", true);
                    $baslik = $_POST['baslik'];
                    $yazi = $_POST['yazi'];
                    $aktiflik = $form->values['aktiflik'];
                    $yil = date("Y");
                    $ay = date("m");
                    if ($ay[0] == 0) {
                        $ay = $ay[1];
                    }
                    if ($baslik == "") {
                        $sonuc["hata"] = "Lütfen Blog Başlığını Giriniz.";
                    } else {
                        if ($yazi == "") {
                            $sonuc["hata"] = "Lütfen Blog Yazısını Giriniz.";
                        } else {
                            $blogtr = $form->turkce_kucult_tr($baslik);
                            $benzersizListe = $Panel_Model->blogBenzersizKontrol($blogtr);
                            foreach ($benzersizListe as $benzersizListee) {
                                $benzersiz['ID'] = $benzersizListee['blog_ID'];
                            }
                            if ($benzersiz['ID'] > 0) {
                                $sonuc["hata"] = "Blog Başlığı Daha Önce Girilmiş Tekrar Deneyiniz.";
                            } else {
                                $realName = $_FILES['file']['name'];
                                if ($realName == "") {
                                    $sonuc["hata"] = "Lütfen Resim Seçiniz";
                                } else {
                                    $image = new Upload($_FILES['file']);
                                    //oranlama
                                    $width = $image->image_src_x;
                                    $height = $image->image_src_y;
                                    if ($image->uploaded) {
                                        // sadece resim formatları yüklensin
                                        $image->allowed = array('image/*');
                                        $image->image_min_height = 250;
                                        $image->image_min_width = 250;
                                        $image->image_max_height = 2000;
                                        $image->image_max_width = 2000;
                                        $image->file_new_name_body = time();
                                        $image->file_name_body_pre = 'flora_';
                                        $image->image_resize = false;
                                        $image->image_ratio_crop = false;
                                        $image->image_x = $width;
                                        $image->image_y = $height;
                                        //$image->image_watermark = 'images/watermark.png';
                                        //$image->image_watermark_position = 'B';

                                        $image->Process("blogum");
                                        if ($image->processed) {
                                            if ($form->submit()) {
                                                $dataB = array(
                                                    'blog_baslik' => $baslik,
                                                    'blog_benzersizbaslik' => $blogtr,
                                                    'blog_yazi' => $yazi,
                                                    'blog_resim' => $image->file_dst_name,
                                                    'blog_resimreal' => $realName,
                                                    'blog_aktiflik' => $aktiflik,
                                                    'blog_ay' => $ay,
                                                    'blog_yil' => $yil
                                                );
                                            }
                                            $result = $Panel_Model->blogekle($dataB);
                                            if ($result) {
                                                $sonuc["result"] = "1";
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $sonuc["hata"] = $image->error;
                                        }
                                    } else {
                                        $sonuc["hata"] = $image->error;
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "blogDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $blogListe = array();

                    $blogListe = $Panel_Model->panelBlogDetayListe($ID);
                    foreach ($blogListe as $blogListee) {
                        $bloglist['ID'] = $blogListee['blog_ID'];
                        $bloglist['Baslik'] = $blogListee['blog_baslik'];
                        $bloglist['Yazi'] = $blogListee['blog_yazi'];
                        $bloglist['Resim'] = $blogListee['blog_resim'];
                        $bloglist['Aktif'] = $blogListee['blog_aktiflik'];
                    }

                    $sonuc["result"] = $bloglist;
                    break;

                case "blogDuzenle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("ID", true);
                    $form->post("resimKontrol", true);
                    $form->post("newImage", true);
                    $form->post("aktiflik", true);

                    $baslik = $_POST['baslik'];
                    $normalbaslik = $_POST['normalbaslik'];
                    $id = $form->values['ID'];
                    $yazi = $_POST['yazi'];
                    $aktiflik = $form->values['aktiflik'];
                    $resimKontrol = $form->values['resimKontrol'];
                    $newImage = $form->values['newImage'];
                    if ($baslik == "") {
                        $sonuc["hata"] = "Lütfen Blog Başlığını Giriniz.";
                    } else {
                        if ($baslik == $normalbaslik) {
                            if ($yazi == "") {
                                $sonuc["hata"] = "Lütfen Blog Yazısını Giriniz.";
                            } else {
                                if ($resimKontrol == 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Resmi Giriniz.";
                                } else {
                                    if ($newImage == 0) {//yeni resim eklenmemiş
                                        if ($form->submit()) {
                                            $dataB = array(
                                                'blog_baslik' => $baslik,
                                                'blog_benzersizbaslik' => $blogtr,
                                                'blog_yazi' => $yazi,
                                                'blog_aktiflik' => $aktiflik
                                            );
                                        }
                                        $result = $Panel_Model->blogUpdate($dataB, $id);
                                        if ($result) {
                                            $sonuc["result"] = "1";
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $realName = $_FILES['file']['name'];
                                        $image = new Upload($_FILES['file']);
                                        //oranlama
                                        $width = $image->image_src_x;
                                        $height = $image->image_src_y;
                                        if ($image->uploaded) {
                                            // sadece resim formatları yüklensin
                                            $image->allowed = array('image/*');
                                            $image->image_min_height = 250;
                                            $image->image_min_width = 250;
                                            $image->image_max_height = 2000;
                                            $image->image_max_width = 2000;
                                            $image->file_new_name_body = time();
                                            $image->file_name_body_pre = 'flora_';
                                            $image->image_resize = true;
                                            $image->image_ratio_crop = false;
                                            $image->image_x = $width;
                                            $image->image_y = $height;
                                            //$image->image_watermark = 'images/watermark.png';
                                            //$image->image_watermark_position = 'B';

                                            $image->Process("blogum");
                                            if ($image->processed) {
                                                if ($form->submit()) {
                                                    $dataB = array(
                                                        'blog_baslik' => $baslik,
                                                        'blog_benzersizbaslik' => $blogtr,
                                                        'blog_yazi' => $yazi,
                                                        'blog_resim' => $image->file_dst_name,
                                                        'blog_resimreal' => $realName,
                                                        'blog_aktiflik' => $aktiflik
                                                    );
                                                }
                                                $result = $Panel_Model->blogUpdate($dataB, $id);
                                                if ($result) {
                                                    $sonuc["result"] = "1";
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = $image->error;
                                            }
                                        } else {
                                            $sonuc["hata"] = $image->error;
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($yazi == "") {
                                $sonuc["hata"] = "Lütfen Blog Yazısını Giriniz.";
                            } else {
                                if ($resimKontrol == 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Resmi Giriniz.";
                                } else {
                                    $blogtr = $form->turkce_kucult_tr($baslik);
                                    $benzersizListe = $Panel_Model->blogBenzersizKontrol($blogtr);
                                    foreach ($benzersizListe as $benzersizListee) {
                                        $benzersiz['ID'] = $benzersizListee['blog_ID'];
                                    }
                                    if ($benzersiz['ID'] > 0) {
                                        $sonuc["hata"] = "Sayfa Adı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                    } else {
                                        if ($newImage == 0) {//yeni resim eklenmemiş
                                            if ($form->submit()) {
                                                $dataB = array(
                                                    'blog_baslik' => $baslik,
                                                    'blog_benzersizbaslik' => $blogtr,
                                                    'blog_yazi' => $yazi,
                                                    'blog_aktiflik' => $aktiflik
                                                );
                                            }
                                            $result = $Panel_Model->blogUpdate($dataB, $id);
                                            if ($result) {
                                                $sonuc["result"] = "1";
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $realName = $_FILES['file']['name'];
                                            $image = new Upload($_FILES['file']);
                                            //oranlama
                                            $width = $image->image_src_x;
                                            $height = $image->image_src_y;
                                            if ($image->uploaded) {
                                                // sadece resim formatları yüklensin
                                                $image->allowed = array('image/*');
                                                $image->image_min_height = 250;
                                                $image->image_min_width = 250;
                                                $image->image_max_height = 2000;
                                                $image->image_max_width = 2000;
                                                $image->file_new_name_body = time();
                                                $image->file_name_body_pre = 'flora_';
                                                $image->image_resize = true;
                                                $image->image_ratio_crop = false;
                                                $image->image_x = $width;
                                                $image->image_y = $height;
                                                //$image->image_watermark = 'images/watermark.png';
                                                //$image->image_watermark_position = 'B';

                                                $image->Process("blogum");
                                                if ($image->processed) {
                                                    if ($form->submit()) {
                                                        $dataB = array(
                                                            'blog_baslik' => $baslik,
                                                            'blog_benzersizbaslik' => $blogtr,
                                                            'blog_yazi' => $yazi,
                                                            'blog_resim' => $image->file_dst_name,
                                                            'blog_resimreal' => $realName,
                                                            'blog_aktiflik' => $aktiflik
                                                        );
                                                    }
                                                    $result = $Panel_Model->blogUpdate($dataB, $id);
                                                    if ($result) {
                                                        $sonuc["result"] = "1";
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = $image->error;
                                                }
                                            } else {
                                                $sonuc["hata"] = $image->error;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "sayfaDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $sayfaListe = array();

                    $sayfaListe = $Panel_Model->panelSayfaDetayListe($ID);
                    foreach ($sayfaListe as $sayfaListee) {
                        $sayfalist['ID'] = $sayfaListee['sabitsayfaid'];
                        $sayfalist['Resim'] = $sayfaListee['sayfa_Resim'];
                        $sayfalist['Yazi'] = $sayfaListee['sayfa_Yazi'];
                    }

                    $sonuc["result"] = $sayfalist;
                    break;

                case "sayfaSil":
                    $form->post("ustID", true);
                    $form->post("ID", true);
                    $form->post("altkatvar", true);
                    $ustID = $form->values['ustID'];
                    $ID = $form->values['ID'];
                    $altkatvar = $form->values['altkatvar'];

                    if ($ustID != 0) {//alt kategoridir
                        $deletealt = $Panel_Model->altSayfaDelete($ID);
                        if ($deletealt) {
                            $sonuc["cevap"] = "Başarıyla silinmiştir.";
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                        }
                    } else {//üst kategoridir
                        if ($altkatvar > 0) {
                            $deletealt = $Panel_Model->ustAltSayfaDelete($ID);
                            if ($deletealt) {
                                $deleteust = $Panel_Model->altSayfaDelete($ID);
                                if ($deleteust) {
                                    $sonuc["cevap"] = "Başarıyla silinmiştir.";
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $deleteust = $Panel_Model->altSayfaDelete($ID);
                            if ($deleteust) {
                                $sonuc["cevap"] = "Başarıyla silinmiştir.";
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                            }
                        }
                    }
                    break;

                case "sayfaEkle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("sira", true);
                    $form->post("kategoriSayi", true);
                    $form->post("durum", true);
                    $form->post("ustSayfa", true);
                    $form->post("degisecekID", true);
                    $form->post("sonUstSira", true);
                    $sayfaTuru = $_POST['sayfaTuru'];
                    $sayfaAdi = $_POST['sayfaAdi'];
                    $sira = $form->values['sira'];
                    $kategoriSayi = $form->values['kategoriSayi'];
                    $durum = $form->values['durum'];
                    $ustSayfa = $form->values['ustSayfa'];
                    $degisecekID = $form->values['degisecekID'];
                    $sonUstSira = $form->values['sonUstSira'];
                    $cke = $_POST["cke"];
                    if ($sayfaTuru == "0") {
                        $sonuc["hata"] = "Lütfen Sayfa Türü Seçiniz.";
                    } else {
                        if ($sayfaTuru == "sayfa") {
                            if ($sayfaAdi == "") {
                                $sonuc["hata"] = "Lütfen Sayfa Adını Giriniz.";
                            } else {
                                if ($sira <= 0) {
                                    $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                } else {
                                    if ($ustSayfa == 0) {
                                        $sonuc["hata"] = "Lütfen Üst Sayfa Seçiniz.";
                                    } else {
                                        if ($cke == "") {
                                            $sonuc["hata"] = "Lütfen Sayfa Yazısını Giriniz.";
                                        } else {
                                            $sayfatr = $form->turkce_kucult_tr($sayfaAdi);
                                            $benzersizListe = $Panel_Model->sayfaBenzersizKontrol($sayfatr);
                                            foreach ($benzersizListe as $benzersizListee) {
                                                $benzersiz['ID'] = $benzersizListee['sabitsayfaid'];
                                            }
                                            if ($benzersiz['ID'] > 0) {
                                                $sonuc["hata"] = "Sayfa Adı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                            } else {
                                                $realName = $_FILES['file']['name'];
                                                if ($realName == "") {
                                                    $sonuc["hata"] = "Lütfen Resim Seçiniz";
                                                } else {
                                                    $image = new Upload($_FILES['file']);
                                                    //oranlama
                                                    $width = $image->image_src_x;
                                                    $height = $image->image_src_y;
                                                    $oran = $width / $height;
                                                    if ($oran < 1) {
                                                        $newheight = 400;
                                                        $newwidth = round($height * $oran);
                                                    } else if ($oran == 1) {
                                                        $newheight = 400;
                                                        $newwidth = 500;
                                                    } else {
                                                        $newheight = round($width / $oran);
                                                        $newwidth = 500;
                                                    }
                                                    if ($image->uploaded) {
                                                        // sadece resim formatları yüklensin
                                                        $image->allowed = array('image/*');
                                                        $image->image_min_height = 250;
                                                        $image->image_min_width = 250;
                                                        $image->image_max_height = 2000;
                                                        $image->image_max_width = 2000;
                                                        $image->file_new_name_body = time();
                                                        $image->file_name_body_pre = 'flora_';
                                                        $image->image_resize = true;
                                                        $image->image_ratio_crop = false;
                                                        $image->image_x = $width;
                                                        $image->image_y = $height;
                                                        //image->image_watermark = 'images/watermark.png';
                                                        //$image->image_watermark_position = 'B';

                                                        $image->Process("sayfa");
                                                        if ($image->processed) {
                                                            if ($degisecekID > 0) {//değişecek vardır
                                                                if ($form->submit()) {
                                                                    $data = array(
                                                                        'sbtsayfa_Sira' => $sonUstSira + 1
                                                                    );
                                                                }
                                                                $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                if ($sayfaUpdate) {
                                                                    if ($form->submit()) {
                                                                        $dataS = array(
                                                                            'sayfa_UstID' => $ustSayfa,
                                                                            'sayfa_Resim' => $image->file_dst_name,
                                                                            'sayfa_RealResim' => $realName,
                                                                            'sayfa_Yazi' => $cke,
                                                                            'sbtsayfa_Sira' => $sira,
                                                                            'sbtsayfa_Aktiflik' => $durum,
                                                                            'sbtsayfa_Adi' => $sayfaAdi,
                                                                            'sbtsayfa_bnzrszAd' => $sayfatr
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->sayfaekle($dataS);
                                                                    if ($result) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                if ($form->submit()) {
                                                                    $dataS = array(
                                                                        'sayfa_UstID' => $ustSayfa,
                                                                        'sayfa_Resim' => $image->file_dst_name,
                                                                        'sayfa_RealResim' => $realName,
                                                                        'sayfa_Yazi' => $cke,
                                                                        'sbtsayfa_Sira' => $sira,
                                                                        'sbtsayfa_Aktiflik' => $durum,
                                                                        'sbtsayfa_Adi' => $sayfaAdi
                                                                    );
                                                                }
                                                                $result = $Panel_Model->sayfaekle($dataS);
                                                                if ($result) {
                                                                    $sonuc["result"] = "1";
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = $image->error;
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = $image->error;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//kategori
                            if ($kategoriSayi > 3) {
                                $sonuc["hata"] = "3 ' ten fazla üst kategori eklenemez.";
                            } else {
                                if ($sayfaAdi == "") {
                                    $sonuc["hata"] = "Lütfen Sayfa Adını Giriniz.";
                                } else {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        $sayfatr = $form->turkce_kucult_tr($sayfaAdi);
                                        $benzersizListe = $Panel_Model->sayfaBenzersizKontrol($sayfatr);
                                        foreach ($benzersizListe as $benzersizListee) {
                                            $benzersiz['ID'] = $benzersizListee['sabitsayfaid'];
                                        }
                                        if ($benzersiz['ID'] > 0) {
                                            $sonuc["hata"] = "Sayfa Adı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                        } else {
                                            if ($degisecekID > 0) {//değişecek vardır
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'sbtsayfa_Sira' => $sonUstSira + 1
                                                    );
                                                }
                                                $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                if ($sayfaUpdate) {
                                                    if ($form->submit()) {
                                                        $dataS = array(
                                                            'sayfa_UstID' => 0,
                                                            'sayfa_Resim' => "",
                                                            'sayfa_RealResim' => "",
                                                            'sayfa_Yazi' => "",
                                                            'sbtsayfa_Sira' => $sira,
                                                            'sbtsayfa_Aktiflik' => $durum,
                                                            'sbtsayfa_Adi' => $sayfaAdi,
                                                            'sbtsayfa_bnzrszAd' => $sayfatr
                                                        );
                                                    }
                                                    $result = $Panel_Model->sayfaekle($dataS);
                                                    if ($result) {
                                                        $sonuc["result"] = "1";
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                if ($form->submit()) {
                                                    $dataS = array(
                                                        'sayfa_UstID' => 0,
                                                        'sayfa_Resim' => "",
                                                        'sayfa_RealResim' => "",
                                                        'sayfa_Yazi' => "",
                                                        'sbtsayfa_Sira' => $sira,
                                                        'sbtsayfa_Aktiflik' => $durum,
                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                    );
                                                }
                                                $result = $Panel_Model->sayfaekle($dataS);
                                                if ($result) {
                                                    $sonuc["result"] = "1";
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "sayfaDuzenle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("ID", true);
                    $form->post("sira", true);
                    $form->post("normalSira", true);
                    $form->post("durum", true);
                    $form->post("ustSayfa", true);
                    $form->post("normalUstID", true);
                    $form->post("degisecekID", true);
                    $form->post("sonUstSira", true);
                    $form->post("resimKontrol", true);
                    $form->post("newImage", true);
                    $ID = $form->values['ID'];
                    $sayfaTuru = $_POST['sayfaTuru'];
                    $sayfaAdi = $_POST['sayfaAdi'];
                    $normalSayfaAdi = $_POST['normalSayfaAdi'];
                    $sira = $form->values['sira'];
                    $normalSira = $form->values['normalSira'];
                    $durum = $form->values['durum'];
                    $ustSayfa = $form->values['ustSayfa'];
                    $normalUstID = $form->values['normalUstID'];
                    $degisecekID = $form->values['degisecekID'];
                    $sonUstSira = $form->values['sonUstSira'];
                    $resimKontrol = $form->values['resimKontrol'];
                    $newImage = $form->values['newImage'];
                    $cke = $_POST["cke"];

                    if ($sayfaTuru == "0") {
                        $sonuc["hata"] = "Lütfen Sayfa Türü Seçiniz.";
                    } else {
                        if ($sayfaTuru == "sayfa") {
                            if ($sayfaAdi == "") {
                                $sonuc["hata"] = "Lütfen Sayfa Adını Giriniz.";
                            } else {
                                if ($sayfaAdi == $normalSayfaAdi) {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        if ($ustSayfa == 0) {
                                            $sonuc["hata"] = "Lütfen Üst Sayfa Seçiniz.";
                                        } else {
                                            if ($cke == "") {
                                                $sonuc["hata"] = "Lütfen Sayfa Yazısını Giriniz.";
                                            } else {
                                                if ($newImage == 0) {//yeni resim eklenmemiş
                                                    if ($degisecekID > 0) {//değişecek vardır
                                                        if ($normalUstID == $ustSayfa) {
                                                            if ($form->submit()) {
                                                                $data = array(
                                                                    'sbtsayfa_Sira' => $normalSira
                                                                );
                                                            }
                                                            $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                            if ($sayfaUpdate) {
                                                                if ($form->submit()) {
                                                                    $dataS = array(
                                                                        'sayfa_UstID' => $ustSayfa,
                                                                        'sayfa_Yazi' => $cke,
                                                                        'sbtsayfa_Sira' => $sira,
                                                                        'sbtsayfa_Aktiflik' => $durum,
                                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                                    );
                                                                }
                                                                $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                if ($result) {
                                                                    $sonuc["result"] = "1";
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            }
                                                        } else {
                                                            if ($form->submit()) {
                                                                $data = array(
                                                                    'sbtsayfa_Sira' => $sonUstSira + 1
                                                                );
                                                            }
                                                            $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                            if ($sayfaUpdate) {
                                                                if ($form->submit()) {
                                                                    $dataS = array(
                                                                        'sayfa_UstID' => $ustSayfa,
                                                                        'sayfa_Yazi' => $cke,
                                                                        'sbtsayfa_Sira' => $sira,
                                                                        'sbtsayfa_Aktiflik' => $durum,
                                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                                    );
                                                                }
                                                                $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                if ($result) {
                                                                    $sonuc["result"] = "1";
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        if ($form->submit()) {
                                                            $dataS = array(
                                                                'sayfa_UstID' => $ustSayfa,
                                                                'sayfa_Yazi' => $cke,
                                                                'sbtsayfa_Sira' => $sira,
                                                                'sbtsayfa_Aktiflik' => $durum,
                                                                'sbtsayfa_Adi' => $sayfaAdi,
                                                                'sbtsayfa_bnzrszAd' => $sayfatr
                                                            );
                                                        }
                                                        $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                        if ($result) {
                                                            $sonuc["result"] = "1";
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    }
                                                } else {
                                                    $realName = $_FILES['file']['name'];
                                                    if ($realName == "") {
                                                        $sonuc["hata"] = "Lütfen Resim Seçiniz";
                                                    } else {
                                                        error_log("burda");
                                                        $image = new Upload($_FILES['file']);
                                                        //oranlama
                                                        $width = $image->image_src_x;
                                                        $height = $image->image_src_y;
                                                        $oran = $width / $height;
                                                        if ($oran < 1) {
                                                            $newheight = 400;
                                                            $newwidth = round($height * $oran);
                                                        } else if ($oran == 1) {
                                                            $newheight = 400;
                                                            $newwidth = 500;
                                                        } else {
                                                            $newheight = round($width / $oran);
                                                            $newwidth = 500;
                                                        }
                                                        if ($image->uploaded) {
                                                            // sadece resim formatları yüklensin
                                                            $image->allowed = array('image/*');
                                                            $image->image_min_height = 250;
                                                            $image->image_min_width = 250;
                                                            $image->image_max_height = 2000;
                                                            $image->image_max_width = 2000;
                                                            $image->file_new_name_body = time();
                                                            $image->file_name_body_pre = 'flora_';
                                                            $image->image_resize = true;
                                                            $image->image_ratio_crop = false;
                                                            $image->image_x = $width;
                                                            $image->image_y = $height;
                                                            //$image->image_watermark = 'images/watermark.png';
                                                            //$image->image_watermark_position = 'B';

                                                            $image->Process("sayfa");
                                                            if ($image->processed) {
                                                                if ($degisecekID > 0) {//değişecek vardır
                                                                    if ($normalUstID == $ustSayfa) {
                                                                        if ($form->submit()) {
                                                                            $data = array(
                                                                                'sbtsayfa_Sira' => $normalSira
                                                                            );
                                                                        }
                                                                        $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                        if ($sayfaUpdate) {
                                                                            if ($form->submit()) {
                                                                                $dataS = array(
                                                                                    'sayfa_UstID' => $ustSayfa,
                                                                                    'sayfa_Resim' => $image->file_dst_name,
                                                                                    'sayfa_RealResim' => $realName,
                                                                                    'sayfa_Yazi' => $cke,
                                                                                    'sbtsayfa_Sira' => $sira,
                                                                                    'sbtsayfa_Aktiflik' => $durum,
                                                                                    'sbtsayfa_Adi' => $sayfaAdi,
                                                                                    'sbtsayfa_bnzrszAd' => $sayfatr
                                                                                );
                                                                            }
                                                                            $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                            if ($result) {
                                                                                $sonuc["result"] = "1";
                                                                            } else {
                                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($form->submit()) {
                                                                            $data = array(
                                                                                'sbtsayfa_Sira' => $sonUstSira + 1
                                                                            );
                                                                        }
                                                                        $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                        if ($sayfaUpdate) {
                                                                            if ($form->submit()) {
                                                                                $dataS = array(
                                                                                    'sayfa_UstID' => $ustSayfa,
                                                                                    'sayfa_Resim' => $image->file_dst_name,
                                                                                    'sayfa_RealResim' => $realName,
                                                                                    'sayfa_Yazi' => $cke,
                                                                                    'sbtsayfa_Sira' => $sira,
                                                                                    'sbtsayfa_Aktiflik' => $durum,
                                                                                    'sbtsayfa_Adi' => $sayfaAdi,
                                                                                    'sbtsayfa_bnzrszAd' => $sayfatr
                                                                                );
                                                                            }
                                                                            $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                            if ($result) {
                                                                                $sonuc["result"] = "1";
                                                                            } else {
                                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                            }
                                                                        }
                                                                    }
                                                                } else {
                                                                    if ($form->submit()) {
                                                                        $dataS = array(
                                                                            'sayfa_UstID' => $ustSayfa,
                                                                            'sayfa_Resim' => $image->file_dst_name,
                                                                            'sayfa_RealResim' => $realName,
                                                                            'sayfa_Yazi' => $cke,
                                                                            'sbtsayfa_Sira' => $sira,
                                                                            'sbtsayfa_Aktiflik' => $durum,
                                                                            'sbtsayfa_Adi' => $sayfaAdi,
                                                                            'sbtsayfa_bnzrszAd' => $sayfatr
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                    if ($result) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = $image->error;
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = $image->error;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        if ($ustSayfa == 0) {
                                            $sonuc["hata"] = "Lütfen Üst Sayfa Seçiniz.";
                                        } else {
                                            if ($cke == "") {
                                                $sonuc["hata"] = "Lütfen Sayfa Yazısını Giriniz.";
                                            } else {
                                                $sayfatr = $form->turkce_kucult_tr($sayfaAdi);
                                                $benzersizListe = $Panel_Model->sayfaBenzersizKontrol($sayfatr);
                                                foreach ($benzersizListe as $benzersizListee) {
                                                    $benzersiz['ID'] = $benzersizListee['sabitsayfaid'];
                                                }
                                                if ($benzersiz['ID'] > 0) {
                                                    $sonuc["hata"] = "Sayfa Adı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                                } else {
                                                    if ($newImage == 0) {//yeni resim eklenmemiş
                                                        if ($degisecekID > 0) {//değişecek vardır
                                                            if ($normalUstID == $ustSayfa) {
                                                                if ($form->submit()) {
                                                                    $data = array(
                                                                        'sbtsayfa_Sira' => $normalSira
                                                                    );
                                                                }
                                                                $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                if ($sayfaUpdate) {
                                                                    if ($form->submit()) {
                                                                        $dataS = array(
                                                                            'sayfa_UstID' => $ustSayfa,
                                                                            'sayfa_Yazi' => $cke,
                                                                            'sbtsayfa_Sira' => $sira,
                                                                            'sbtsayfa_Aktiflik' => $durum,
                                                                            'sbtsayfa_Adi' => $sayfaAdi,
                                                                            'sbtsayfa_bnzrszAd' => $sayfatr
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                    if ($result) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                }
                                                            } else {
                                                                if ($form->submit()) {
                                                                    $data = array(
                                                                        'sbtsayfa_Sira' => $sonUstSira + 1
                                                                    );
                                                                }
                                                                $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                if ($sayfaUpdate) {
                                                                    if ($form->submit()) {
                                                                        $dataS = array(
                                                                            'sayfa_UstID' => $ustSayfa,
                                                                            'sayfa_Yazi' => $cke,
                                                                            'sbtsayfa_Sira' => $sira,
                                                                            'sbtsayfa_Aktiflik' => $durum,
                                                                            'sbtsayfa_Adi' => $sayfaAdi,
                                                                            'sbtsayfa_bnzrszAd' => $sayfatr
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                    if ($result) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                }
                                                            }
                                                        } else {
                                                            if ($form->submit()) {
                                                                $dataS = array(
                                                                    'sayfa_UstID' => $ustSayfa,
                                                                    'sayfa_Yazi' => $cke,
                                                                    'sbtsayfa_Sira' => $sira,
                                                                    'sbtsayfa_Aktiflik' => $durum,
                                                                    'sbtsayfa_Adi' => $sayfaAdi,
                                                                    'sbtsayfa_bnzrszAd' => $sayfatr
                                                                );
                                                            }
                                                            $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                            if ($result) {
                                                                $sonuc["result"] = "1";
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        }
                                                    } else {
                                                        $realName = $_FILES['file']['name'];
                                                        if ($realName == "") {
                                                            $sonuc["hata"] = "Lütfen Resim Seçiniz";
                                                        } else {
                                                            error_log("burda");
                                                            $image = new Upload($_FILES['file']);
                                                            //oranlama
                                                            $width = $image->image_src_x;
                                                            $height = $image->image_src_y;
                                                            $oran = $width / $height;
                                                            if ($oran < 1) {
                                                                $newheight = 400;
                                                                $newwidth = round($height * $oran);
                                                            } else if ($oran == 1) {
                                                                $newheight = 400;
                                                                $newwidth = 500;
                                                            } else {
                                                                $newheight = round($width / $oran);
                                                                $newwidth = 500;
                                                            }
                                                            if ($image->uploaded) {
                                                                // sadece resim formatları yüklensin
                                                                $image->allowed = array('image/*');
                                                                $image->image_min_height = 250;
                                                                $image->image_min_width = 250;
                                                                $image->image_max_height = 2000;
                                                                $image->image_max_width = 2000;
                                                                $image->file_new_name_body = time();
                                                                $image->file_name_body_pre = 'flora_';
                                                                $image->image_resize = true;
                                                                $image->image_ratio_crop = false;
                                                                $image->image_x = $width;
                                                                $image->image_y = $height;
                                                                //$image->image_watermark = 'images/watermark.png';
                                                                //$image->image_watermark_position = 'B';

                                                                $image->Process("sayfa");
                                                                if ($image->processed) {
                                                                    if ($degisecekID > 0) {//değişecek vardır
                                                                        if ($normalUstID == $ustSayfa) {
                                                                            if ($form->submit()) {
                                                                                $data = array(
                                                                                    'sbtsayfa_Sira' => $normalSira
                                                                                );
                                                                            }
                                                                            $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                            if ($sayfaUpdate) {
                                                                                if ($form->submit()) {
                                                                                    $dataS = array(
                                                                                        'sayfa_UstID' => $ustSayfa,
                                                                                        'sayfa_Resim' => $image->file_dst_name,
                                                                                        'sayfa_RealResim' => $realName,
                                                                                        'sayfa_Yazi' => $cke,
                                                                                        'sbtsayfa_Sira' => $sira,
                                                                                        'sbtsayfa_Aktiflik' => $durum,
                                                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                                                    );
                                                                                }
                                                                                $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                                if ($result) {
                                                                                    $sonuc["result"] = "1";
                                                                                } else {
                                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                                }
                                                                            }
                                                                        } else {
                                                                            if ($form->submit()) {
                                                                                $data = array(
                                                                                    'sbtsayfa_Sira' => $sonUstSira + 1
                                                                                );
                                                                            }
                                                                            $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                                                            if ($sayfaUpdate) {
                                                                                if ($form->submit()) {
                                                                                    $dataS = array(
                                                                                        'sayfa_UstID' => $ustSayfa,
                                                                                        'sayfa_Resim' => $image->file_dst_name,
                                                                                        'sayfa_RealResim' => $realName,
                                                                                        'sayfa_Yazi' => $cke,
                                                                                        'sbtsayfa_Sira' => $sira,
                                                                                        'sbtsayfa_Aktiflik' => $durum,
                                                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                                                    );
                                                                                }
                                                                                $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                                if ($result) {
                                                                                    $sonuc["result"] = "1";
                                                                                } else {
                                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                                }
                                                                            }
                                                                        }
                                                                    } else {
                                                                        if ($form->submit()) {
                                                                            $dataS = array(
                                                                                'sayfa_UstID' => $ustSayfa,
                                                                                'sayfa_Resim' => $image->file_dst_name,
                                                                                'sayfa_RealResim' => $realName,
                                                                                'sayfa_Yazi' => $cke,
                                                                                'sbtsayfa_Sira' => $sira,
                                                                                'sbtsayfa_Aktiflik' => $durum,
                                                                                'sbtsayfa_Adi' => $sayfaAdi,
                                                                                'sbtsayfa_bnzrszAd' => $sayfatr
                                                                            );
                                                                        }
                                                                        $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                                        if ($result) {
                                                                            $sonuc["result"] = "1";
                                                                        } else {
                                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                        }
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = $image->error;
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = $image->error;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        } else {//kategori
                            $sayfatr = $form->turkce_kucult_tr($sayfaAdi);
                            $benzersizListe = $Panel_Model->sayfaBenzersizKontrol($sayfatr);
                            foreach ($benzersizListe as $benzersizListee) {
                                $benzersiz['ID'] = $benzersizListee['sabitsayfaid'];
                            }
                            if ($benzersiz['ID'] > 0) {
                                $sonuc["hata"] = "Sayfa Adı Daha Önce Girilmiş Tekrar Deneyiniz.";
                            } else {
                                if ($sayfaAdi == "") {
                                    $sonuc["hata"] = "Lütfen Sayfa Adını Giriniz.";
                                } else {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        if ($degisecekID > 0) {//değişecek vardır
                                            if ($form->submit()) {
                                                $data = array(
                                                    'sbtsayfa_Sira' => $normalSira
                                                );
                                            }
                                            $sayfaUpdate = $Panel_Model->sayfaSiraUpdate($data, $degisecekID);
                                            if ($sayfaUpdate) {
                                                if ($form->submit()) {
                                                    $dataS = array(
                                                        'sayfa_UstID' => 0,
                                                        'sayfa_Resim' => "",
                                                        'sayfa_RealResim' => "",
                                                        'sayfa_Yazi' => "",
                                                        'sbtsayfa_Sira' => $sira,
                                                        'sbtsayfa_Aktiflik' => $durum,
                                                        'sbtsayfa_Adi' => $sayfaAdi,
                                                        'sbtsayfa_bnzrszAd' => $sayfatr
                                                    );
                                                }
                                                $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                                if ($result) {
                                                    $sonuc["result"] = "1";
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            if ($form->submit()) {
                                                $dataS = array(
                                                    'sayfa_UstID' => 0,
                                                    'sayfa_Resim' => "",
                                                    'sayfa_RealResim' => "",
                                                    'sayfa_Yazi' => "",
                                                    'sbtsayfa_Sira' => $sira,
                                                    'sbtsayfa_Aktiflik' => $durum,
                                                    'sbtsayfa_Adi ' => $sayfaAdi,
                                                    'sbtsayfa_bnzrszAd' => $sayfatr
                                                );
                                            }
                                            $result = $Panel_Model->sayfaUpdate($dataS, $ID);
                                            if ($result) {
                                                $sonuc["result"] = "1";
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    break;
                default :
                    header("Location:" . SITE_URL);
                    break;
            }
            echo json_encode($sonuc);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}
?>

