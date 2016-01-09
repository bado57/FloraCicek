<?php

class AdminGenel extends Controller {

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

                case "kategoriEkle":
                    $form->post("altKatSira", true);
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("sonUstSira", true);
                    $form->post("degisecekID", true);
                    $form->post("trID", true);
                    $katAdi = $_POST['katAdi'];
                    $ustKatText = $_POST['ustKatText'];
                    $ustKatVal = $_POST['ustKatVal'];
                    $altKatSira = $form->values['altKatSira']; //üst kateori altındaki alt kategorilerdeki son sıra
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $katYazi = $_POST['katYazi'];
                    $sonUstSira = $form->values['sonUstSira'];
                    $degisecekID = $form->values['degisecekID'];
                    $trID = $form->values['trID'];
                    if ($katAdi == "") {
                        $sonuc["hata"] = "Lütfen Kategori Adını Giriniz.";
                    } else {
                        if ($sira <= 0) {
                            $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                        } else {
                            $kattr = $form->turkce_kucult_tr($katAdi);
                            $benzersizListe = $Panel_Model->kategoriBenzersizKontrol($kattr);
                            foreach ($benzersizListe as $benzersizListee) {
                                $benzersiz['ID'] = $benzersizListee['kategori_ID'];
                            }
                            if ($benzersiz['ID'] > 0) {
                                $sonuc["hata"] = "Kategori Başlığı Daha Önce Girilmiş Tekrar Deneyiniz.";
                            } else {
                                if ($ustKatVal != 0) {//üst kategorisi olan kategori eklenilecek
                                    if ($sira <= $altKatSira) {//alt kategorisinde değişiklik olması gerekiyor
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Sira' => $altKatSira + 1
                                            );
                                        }
                                        $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $trID);
                                        if ($kategoriUpdate) {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => $ustKatVal
                                                );
                                            }
                                            $result = $Panel_Model->altKategoriEkleUstte($data);
                                            if ($result) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat,
                                                    'kategoriID' => $result,
                                                    'kategoriTip' => 1
                                                );
                                                $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $yenikat = $form->turkce_kucult_tr($katAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Adi' => $katAdi,
                                                'kategori_BenzAd' => $yenikat,
                                                'kategori_Yazi' => $katYazi,
                                                'kategori_Resim' => "",
                                                'kategori_Aktiflik' => $durum,
                                                'kategori_Sira' => $sira,
                                                'kategori_UstID' => $ustKatVal
                                            );
                                        }
                                        $result = $Panel_Model->altKategoriEkleUstte($data);
                                        if ($result) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat,
                                                'kategoriID' => $result,
                                                'kategoriTip' => 1
                                            );
                                            $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    }
                                } else {//eklenen kategori üst kategori olacak
                                    if ($sira <= $sonUstSira) {
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Sira' => $sonUstSira + 1
                                            );
                                        }
                                        $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                        if ($kategoriUpdate) {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => 0
                                                );
                                            }
                                            $result = $Panel_Model->altKategoriEkleUstte($data);
                                            if ($result) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat,
                                                    'kategoriID' => $result,
                                                    'kategoriTip' => 1
                                                );
                                                $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $yenikat = $form->turkce_kucult_tr($katAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Adi' => $katAdi,
                                                'kategori_BenzAd' => $yenikat,
                                                'kategori_Yazi' => $katYazi,
                                                'kategori_Resim' => "",
                                                'kategori_Aktiflik' => $durum,
                                                'kategori_Sira' => $sira,
                                                'kategori_UstID' => 0
                                            );
                                        }
                                        $result = $Panel_Model->altKategoriEkleUstte($data);
                                        if ($result) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat,
                                                'kategoriID' => $result,
                                                'kategoriTip' => 1
                                            );
                                            $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;
                case "kategoriDuzenle":
                    $form->post("ustKatVal", true);
                    $form->post("altKatSira", true);
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("sonUstSira", true);
                    $form->post("degisecekID", true);
                    $form->post("trID", true);
                    $form->post("duzenlenenID", true);
                    $form->post("normalSira", true);
                    $form->post("normalUstKatID", true);
                    $form->post("aynıustfarklialtSira", true);
                    $katAdi = $_POST['katAdi'];
                    $normalkatAdi = $_POST['normalkatAdi'];
                    $ustKatVal = $form->values['ustKatVal'];
                    $altKatSira = $form->values['altKatSira']; //üst kategori altındaki alt kategorilerdeki son sıra
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $katYazi = $_POST['katYazi'];
                    $sonUstSira = $form->values['sonUstSira'];
                    $degisecekID = $form->values['degisecekID'];
                    $trID = $form->values['trID'];
                    $duzenlenenID = $form->values['duzenlenenID'];
                    $normalSira = $form->values['normalSira'];
                    $normalUstKatID = $form->values['normalUstKatID'];
                    $aynıustfarklialtSira = $form->values['aynıustfarklialtSira'];
                    if ($katAdi == "") {
                        $sonuc["hata"] = "Lütfen Kategori Adınızı Giriniz";
                    } else {
                        if ($sira <= 0) {
                            $sonuc["hata"] = "Lütfen Sırasını Giriniz";
                        } else {
                            if ($katAdi == $normalkatAdi) {
                                if ($ustKatVal != 0) {//üst kategorisi olan kategori düzenlenecek
                                    if ($ustKatVal == $normalUstKatID) {//üst kategoriyi değiştirmemişse, sadece sıra değğişimleri göz önünde bulundurulacak
                                        if ($sira == $normalSira) {//sıra eşitse
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => $ustKatVal
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                if ($form->submit()) {
                                                    $dataUrun = array(
                                                        'urun_kategoriAd' => $katAdi
                                                    );
                                                }
                                                $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                if ($resultUrun) {
                                                    $dataKatIsim = array(
                                                        'kategoriAd' => $yenikat
                                                    );
                                                    $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                    if ($resultKat) {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else if ($sira <= $aynıustfarklialtSira) {
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Sira' => $normalSira
                                                );
                                            }
                                            $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                            if ($kategoriUpdate) {
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => $ustKatVal
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_kategoriAd' => $katAdi
                                                        );
                                                    }
                                                    $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                    if ($resultUrun) {
                                                        $dataKatIsim = array(
                                                            'kategoriAd' => $yenikat
                                                        );
                                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                        if ($resultKat) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => $ustKatVal
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                if ($form->submit()) {
                                                    $dataUrun = array(
                                                        'urun_kategoriAd' => $katAdi
                                                    );
                                                }
                                                $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                if ($resultUrun) {
                                                    $dataKatIsim = array(
                                                        'kategoriAd' => $yenikat
                                                    );
                                                    $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                    if ($resultKat) {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        }
                                    } else {//üst kategoriyi değişitirmişse
                                        if ($degisecekID != 0) {//başka alt kategorideki sıra ile eşleşti değişmesi gerekiyor
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Sira' => $altKatSira + 1
                                                );
                                            }
                                            $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                            if ($kategoriUpdate) {
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => $ustKatVal
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_kategoriAd' => $katAdi
                                                        );
                                                    }
                                                    $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                    if ($resultUrun) {
                                                        $dataKatIsim = array(
                                                            'kategoriAd' => $yenikat
                                                        );
                                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                        if ($resultKat) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => $ustKatVal
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                if ($form->submit()) {
                                                    $dataUrun = array(
                                                        'urun_kategoriAd' => $katAdi
                                                    );
                                                }
                                                $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                if ($resultUrun) {
                                                    $dataKatIsim = array(
                                                        'kategoriAd' => $yenikat
                                                    );
                                                    $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                    if ($resultKat) {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        }
                                    }
                                } else {//düzenlenecek kategori üst kategori olacak
                                    if ($sira == $normalSira) {
                                        $yenikat = $form->turkce_kucult_tr($katAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Adi' => $katAdi,
                                                'kategori_BenzAd' => $yenikat,
                                                'kategori_Yazi' => $katYazi,
                                                'kategori_Resim' => "",
                                                'kategori_Aktiflik' => $durum,
                                                'kategori_Sira' => $sira,
                                                'kategori_UstID' => 0
                                            );
                                        }
                                        $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                        if ($result) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat
                                            );
                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else if ($sira <= $sonUstSira) {
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Sira' => $normalSira
                                            );
                                        }
                                        $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                        if ($kategoriUpdate) {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => 0
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat
                                                );
                                                $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $yenikat = $form->turkce_kucult_tr($katAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'kategori_Adi' => $katAdi,
                                                'kategori_BenzAd' => $yenikat,
                                                'kategori_Yazi' => $katYazi,
                                                'kategori_Resim' => "",
                                                'kategori_Aktiflik' => $durum,
                                                'kategori_Sira' => $sira,
                                                'kategori_UstID' => 0
                                            );
                                        }
                                        $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                        if ($result) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat
                                            );
                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    }
                                }
                            } else {
                                $kattr = $form->turkce_kucult_tr($katAdi);
                                $benzersizListe = $Panel_Model->kategoriBenzersizKontrol($kattr);
                                foreach ($benzersizListe as $benzersizListee) {
                                    $benzersiz['ID'] = $benzersizListee['kategori_ID'];
                                }
                                if ($benzersiz['ID'] > 0) {
                                    $sonuc["hata"] = "Kategori Başlığı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                } else {
                                    if ($ustKatVal != 0) {//üst kategorisi olan kategori düzenlenecek
                                        if ($ustKatVal == $normalUstKatID) {//üst kategoriyi değiştirmemişse, sadece sıra değğişimleri göz önünde bulundurulacak
                                            if ($sira == $normalSira) {//sıra eşitse
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => $ustKatVal
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_kategoriAd' => $katAdi
                                                        );
                                                    }
                                                    $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                    if ($resultUrun) {
                                                        $dataKatIsim = array(
                                                            'kategoriAd' => $yenikat
                                                        );
                                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                        if ($resultKat) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else if ($sira <= $aynıustfarklialtSira) {
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Sira' => $normalSira
                                                    );
                                                }
                                                $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                                if ($kategoriUpdate) {
                                                    $yenikat = $form->turkce_kucult_tr($katAdi);
                                                    if ($form->submit()) {
                                                        $data = array(
                                                            'kategori_Adi' => $katAdi,
                                                            'kategori_BenzAd' => $yenikat,
                                                            'kategori_Yazi' => $katYazi,
                                                            'kategori_Resim' => "",
                                                            'kategori_Aktiflik' => $durum,
                                                            'kategori_Sira' => $sira,
                                                            'kategori_UstID' => $ustKatVal
                                                        );
                                                    }
                                                    $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                    if ($result) {
                                                        if ($form->submit()) {
                                                            $dataUrun = array(
                                                                'urun_kategoriAd' => $katAdi
                                                            );
                                                        }
                                                        $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                        if ($resultUrun) {
                                                            $dataKatIsim = array(
                                                                'kategoriAd' => $yenikat
                                                            );
                                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                            if ($resultKat) {
                                                                $sonuc["result"] = "1";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => $ustKatVal
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_kategoriAd' => $katAdi
                                                        );
                                                    }
                                                    $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                    if ($resultUrun) {
                                                        $dataKatIsim = array(
                                                            'kategoriAd' => $yenikat
                                                        );
                                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                        if ($resultKat) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            }
                                        } else {//üst kategoriyi değişitirmişse
                                            if ($degisecekID != 0) {//başka alt kategorideki sıra ile eşleşti değişmesi gerekiyor
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Sira' => $altKatSira + 1
                                                    );
                                                }
                                                $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                                if ($kategoriUpdate) {
                                                    $yenikat = $form->turkce_kucult_tr($katAdi);
                                                    if ($form->submit()) {
                                                        $data = array(
                                                            'kategori_Adi' => $katAdi,
                                                            'kategori_BenzAd' => $yenikat,
                                                            'kategori_Yazi' => $katYazi,
                                                            'kategori_Resim' => "",
                                                            'kategori_Aktiflik' => $durum,
                                                            'kategori_Sira' => $sira,
                                                            'kategori_UstID' => $ustKatVal
                                                        );
                                                    }
                                                    $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                    if ($result) {
                                                        if ($form->submit()) {
                                                            $dataUrun = array(
                                                                'urun_kategoriAd' => $katAdi
                                                            );
                                                        }
                                                        $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                        if ($resultUrun) {
                                                            $dataKatIsim = array(
                                                                'kategoriAd' => $yenikat
                                                            );
                                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                            if ($resultKat) {
                                                                $sonuc["result"] = "1";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => $ustKatVal
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_kategoriAd' => $katAdi
                                                        );
                                                    }
                                                    $resultUrun = $Panel_Model->panelkategoriurunUpdate($dataUrun, $duzenlenenID);
                                                    if ($resultUrun) {
                                                        $dataKatIsim = array(
                                                            'kategoriAd' => $yenikat
                                                        );
                                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                        if ($resultKat) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            }
                                        }
                                    } else {//düzenlenecek kategori üst kategori olacak
                                        if ($sira == $normalSira) {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => 0
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat
                                                );
                                                $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else if ($sira <= $sonUstSira) {
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Sira' => $normalSira
                                                );
                                            }
                                            $kategoriUpdate = $Panel_Model->altkategorisiraUpdate($data, $degisecekID);
                                            if ($kategoriUpdate) {
                                                $yenikat = $form->turkce_kucult_tr($katAdi);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kategori_Adi' => $katAdi,
                                                        'kategori_BenzAd' => $yenikat,
                                                        'kategori_Yazi' => $katYazi,
                                                        'kategori_Resim' => "",
                                                        'kategori_Aktiflik' => $durum,
                                                        'kategori_Sira' => $sira,
                                                        'kategori_UstID' => 0
                                                    );
                                                }
                                                $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                                if ($result) {
                                                    $dataKatIsim = array(
                                                        'kategoriAd' => $yenikat
                                                    );
                                                    $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                    if ($resultKat) {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $yenikat = $form->turkce_kucult_tr($katAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'kategori_Adi' => $katAdi,
                                                    'kategori_BenzAd' => $yenikat,
                                                    'kategori_Yazi' => $katYazi,
                                                    'kategori_Resim' => "",
                                                    'kategori_Aktiflik' => $durum,
                                                    'kategori_Sira' => $sira,
                                                    'kategori_UstID' => 0
                                                );
                                            }
                                            $result = $Panel_Model->ustkategorisiraUpdate($data, $duzenlenenID);
                                            if ($result) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat
                                                );
                                                $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
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
                case "kategoriSil":
                    $form->post("ustID", true);
                    $form->post("ID", true);
                    $form->post("altkatvar", true);
                    $ustID = $form->values['ustID'];
                    $ID = $form->values['ID'];
                    $altkatvar = $form->values['altkatvar'];

                    if ($ustID != 0) {//alt kategoridir
                        $deletealt = $Panel_Model->altKategoriDelete($ID);
                        if ($deletealt) {
                            $deletekatisim = $Panel_Model->kategoriIsimDelete($ID);
                            if ($deletekatisim) {
                                $sonuc["cevap"] = "Başarıyla silinmiştir.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                        }
                    } else {//üst kategoridir
                        if ($altkatvar > 0) {
                            $deletealt = $Panel_Model->ustAltKategoriDelete($ID);
                            if ($deletealt) {
                                $deleteust = $Panel_Model->ustKategoriDelete($ID);
                                if ($deleteust) {
                                    $deletekatisim = $Panel_Model->kategoriIsimDelete($ID);
                                    if ($deletekatisim) {
                                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                                }
                            }
                        } else {
                            $deleteust = $Panel_Model->ustKategoriDelete($ID);
                            if ($deleteust) {
                                $deletekatisim = $Panel_Model->kategoriIsimDelete($ID);
                                if ($deletekatisim) {
                                    $sonuc["cevap"] = "Başarıyla silinmiştir.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                            }
                        }
                    }
                    break;
                case "urunEkle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("urunKod", true);
                    $form->post("siraolanurun", true);
                    $form->post("urunKatVal", true);
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("degisecekurunid", true);
                    $form->post("maxSira", true);
                    $urunAdi = $_POST['urunAdi'];
                    $urunKod = $form->values['urunKod'];
                    $urunKatText = $_POST['urunKatText'];
                    $siraolanurun = $form->values['siraolanurun'];
                    $urunKatVal = $form->values['urunKatVal'];
                    $urunFiyat = $_POST['urunFiyat'];
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $urunYazi = $_POST['urunYazi'];
                    $degisecekurunid = $form->values['degisecekurunid'];
                    $maxSira = $form->values['maxSira'];
                    $urunOzellikArray = $_REQUEST['urunOzellikArray'];
                    $explodeOzellikArray = explode(",", $urunOzellikArray[0]);
                    $urunEtiketArray = $_REQUEST['urunEtiketArray'];
                    $explodeEtiketArray = explode(",", $urunEtiketArray[0]);
                    if ($urunAdi == "") {
                        $sonuc["hata"] = "Lütfen Ürün Adını Giriniz.";
                    } else {
                        if ($urunKod == "") {
                            $sonuc["hata"] = "Lütfen Ürün Kodunu Giriniz.";
                        } else {
                            if ($urunKatVal != -1) {
                                if ($urunKatVal == 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Kategorisini Giriniz.";
                                } else {
                                    if ($urunFiyat <= 0) {
                                        $sonuc["hata"] = "Lütfen Ürün Fiyatını Giriniz.";
                                    } else {
                                        if ($sira <= 0) {
                                            $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                        } else {
                                            $benzersizSayi = $form->benzersiz_Sayi(5);
                                            $benzersizListe = $Panel_Model->urunBenzersizKontrol($benzersizSayi);
                                            foreach ($benzersizListe as $benzersizListee) {
                                                $benzersiz['ID'] = $benzersizListee['urun_ID'];
                                            }
                                            if ($benzersiz['ID'] > 0) {
                                                $sonuc["hata"] = "Benzersiz Kod Oluşturulamadı Tekrar Deneyiniz.";
                                            } else {
                                                $yeniurun = $form->turkce_kucult_tr($urunAdi);
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
                                                        $newheight = 500;
                                                        $newwidth = round($height * $oran);
                                                    } else if ($oran == 1) {
                                                        $newheight = 500;
                                                        $newwidth = 500;
                                                    } else {
                                                        $newheight = round($width / $oran);
                                                        $newwidth = 500;
                                                    }
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
                                                        $image->image_x = $newwidth;
                                                        $image->image_y = $newheight;
                                                        $image->image_watermark = 'images/watermark.png';
                                                        $image->image_watermark_position = 'B';

                                                        $image->Process("products");
                                                        if ($image->processed) {
                                                            if ($explodeOzellikArray[1] > 0) {
                                                                if ($form->submit()) {
                                                                    $dataUrunHafta = array(
                                                                        'urun_hafta' => 0
                                                                    );
                                                                }
                                                                $urunHaftaUpdate = $Panel_Model->urunHaftaUpdate($dataUrunHafta);
                                                            }
                                                            if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                                if ($form->submit()) {
                                                                    $dataUrun = array(
                                                                        'urun_sira' => $maxSira + 1
                                                                    );
                                                                }
                                                                $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                                if ($urunUpdate) {
                                                                    if ($form->submit()) {
                                                                        $dataUrun = array(
                                                                            'urun_kategoriID' => $urunKatVal,
                                                                            'urun_kategoriAd' => $urunKatText,
                                                                            'urun_kodu' => $urunKod,
                                                                            'urun_benzersizkod' => $benzersizSayi,
                                                                            'urun_aciklama' => $urunYazi,
                                                                            'urun_fiyat' => $urunFiyat,
                                                                            'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                            'urun_aktiflik' => $durum,
                                                                            'urun_sira' => $sira,
                                                                            'urun_yeniurun' => $explodeOzellikArray[0],
                                                                            'urun_ekurun' => 0,
                                                                            'urun_adi' => $urunAdi,
                                                                            'urun_benzad' => $yeniurun,
                                                                            'urun_kmpnyaid' => 0,
                                                                            'urun_hafta' => $explodeOzellikArray[1],
                                                                            'urun_anaresim' => $image->file_dst_name,
                                                                            'urun_anaresimreal' => $realName,
                                                                            'urun_coksatan' => $explodeOzellikArray[2]
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->panelUrunEkle($dataUrun);
                                                                    if ($result) {
                                                                        $etiketArray = count($explodeEtiketArray);
                                                                        if ($etiketArray > 0) {
                                                                            for ($e = 0; $e < $etiketArray; $e++) {
                                                                                $etiketdata[$e] = array(
                                                                                    'urunetiket_UrunID' => $result,
                                                                                    'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                                );
                                                                            }
                                                                            $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                            if ($resultEtiket) {
                                                                                $sonuc["result"] = "1";
                                                                            } else {
                                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                            }
                                                                        } else {
                                                                            $sonuc["result"] = "1";
                                                                        }
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                if ($form->submit()) {
                                                                    $dataUrun = array(
                                                                        'urun_kategoriID' => $urunKatVal,
                                                                        'urun_kategoriAd' => $urunKatText,
                                                                        'urun_kodu' => $urunKod,
                                                                        'urun_benzersizkod' => $benzersizSayi,
                                                                        'urun_aciklama' => $urunYazi,
                                                                        'urun_fiyat' => $urunFiyat,
                                                                        'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                        'urun_aktiflik' => $durum,
                                                                        'urun_sira' => $sira,
                                                                        'urun_yeniurun' => $explodeOzellikArray[0],
                                                                        'urun_ekurun' => 0,
                                                                        'urun_adi' => $urunAdi,
                                                                        'urun_benzad' => $yeniurun,
                                                                        'urun_kmpnyaid' => 0,
                                                                        'urun_hafta' => $explodeOzellikArray[1],
                                                                        'urun_anaresim' => $image->file_dst_name,
                                                                        'urun_anaresimreal' => $realName,
                                                                        'urun_coksatan' => $explodeOzellikArray[2]
                                                                    );
                                                                }
                                                                $result = $Panel_Model->panelUrunEkle($dataUrun);
                                                                if ($result) {
                                                                    $etiketArray = count($explodeEtiketArray);
                                                                    if ($etiketArray > 0) {
                                                                        for ($e = 0; $e < $etiketArray; $e++) {
                                                                            $etiketdata[$e] = array(
                                                                                'urunetiket_UrunID' => $result,
                                                                                'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                            );
                                                                        }
                                                                        $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                        if ($resultEtiket) {
                                                                            $sonuc["result"] = "1";
                                                                        } else {
                                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                        }
                                                                    } else {
                                                                        $sonuc["result"] = "1";
                                                                    }
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
                                if ($urunFiyat <= 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Fiyatını Giriniz.";
                                } else {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        $benzersizSayi = $form->benzersiz_Sayi(5);
                                        $benzersizListe = $Panel_Model->urunBenzersizKontrol($benzersizSayi);
                                        foreach ($benzersizListe as $benzersizListee) {
                                            $benzersiz['ID'] = $benzersizListee['urun_ID'];
                                        }
                                        if ($benzersiz['ID'] > 0) {
                                            $sonuc["hata"] = "Benzersiz Kod Oluşturulamadı Tekrar Deneyiniz.";
                                        } else {
                                            $yeniurun = $form->turkce_kucult_tr($urunAdi);
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
                                                    $newheight = 500;
                                                    $newwidth = round($height * $oran);
                                                } else if ($oran == 1) {
                                                    $newheight = 500;
                                                    $newwidth = 500;
                                                } else {
                                                    $newheight = round($width / $oran);
                                                    $newwidth = 500;
                                                }
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
                                                    $image->image_x = $newwidth;
                                                    $image->image_y = $newheight;
                                                    $image->image_watermark = 'images/watermark.png';
                                                    $image->image_watermark_position = 'B';

                                                    $image->Process("products");
                                                    if ($image->processed) {
                                                        if ($explodeOzellikArray[1] > 0) {
                                                            if ($form->submit()) {
                                                                $dataUrunHafta = array(
                                                                    'urun_hafta' => 0
                                                                );
                                                            }
                                                            $urunHaftaUpdate = $Panel_Model->urunHaftaUpdate($dataUrunHafta);
                                                        }
                                                        if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                            if ($form->submit()) {
                                                                $dataUrun = array(
                                                                    'urun_sira' => $maxSira + 1
                                                                );
                                                            }
                                                            $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                            if ($urunUpdate) {
                                                                if ($form->submit()) {
                                                                    $dataUrun = array(
                                                                        'urun_kategoriID' => $urunKatVal,
                                                                        'urun_kategoriAd' => $urunKatText,
                                                                        'urun_kodu' => $urunKod,
                                                                        'urun_benzersizkod' => $benzersizSayi,
                                                                        'urun_aciklama' => $urunYazi,
                                                                        'urun_fiyat' => $urunFiyat,
                                                                        'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                        'urun_aktiflik' => $durum,
                                                                        'urun_sira' => $sira,
                                                                        'urun_yeniurun' => $explodeOzellikArray[0],
                                                                        'urun_ekurun' => 1,
                                                                        'urun_adi' => $urunAdi,
                                                                        'urun_benzad' => $yeniurun,
                                                                        'urun_kmpnyaid' => 0,
                                                                        'urun_hafta' => $explodeOzellikArray[1],
                                                                        'urun_anaresim' => $image->file_dst_name,
                                                                        'urun_anaresimreal' => $realName,
                                                                        'urun_coksatan' => $explodeOzellikArray[2]
                                                                    );
                                                                }
                                                                $result = $Panel_Model->panelUrunEkle($dataUrun);
                                                                if ($result) {
                                                                    $etiketArray = count($explodeEtiketArray);
                                                                    if ($etiketArray > 0) {
                                                                        for ($e = 0; $e < $etiketArray; $e++) {
                                                                            $etiketdata[$e] = array(
                                                                                'urunetiket_UrunID' => $result,
                                                                                'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                            );
                                                                        }
                                                                        $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                        if ($resultEtiket) {
                                                                            $sonuc["result"] = "1";
                                                                        } else {
                                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                        }
                                                                    } else {
                                                                        $sonuc["result"] = "1";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        } else {
                                                            if ($form->submit()) {
                                                                $dataUrun = array(
                                                                    'urun_kategoriID' => $urunKatVal,
                                                                    'urun_kategoriAd' => $urunKatText,
                                                                    'urun_kodu' => $urunKod,
                                                                    'urun_benzersizkod' => $benzersizSayi,
                                                                    'urun_aciklama' => $urunYazi,
                                                                    'urun_fiyat' => $urunFiyat,
                                                                    'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                    'urun_aktiflik' => $durum,
                                                                    'urun_sira' => $sira,
                                                                    'urun_yeniurun' => $explodeOzellikArray[0],
                                                                    'urun_ekurun' => 1,
                                                                    'urun_adi' => $urunAdi,
                                                                    'urun_benzad' => $yeniurun,
                                                                    'urun_kmpnyaid' => 0,
                                                                    'urun_hafta' => $explodeOzellikArray[1],
                                                                    'urun_anaresim' => $image->file_dst_name,
                                                                    'urun_anaresimreal' => $realName,
                                                                    'urun_coksatan' => $explodeOzellikArray[2]
                                                                );
                                                            }
                                                            $result = $Panel_Model->panelUrunEkle($dataUrun);
                                                            if ($result) {
                                                                $etiketArray = count($explodeEtiketArray);
                                                                if ($etiketArray > 0) {
                                                                    for ($e = 0; $e < $etiketArray; $e++) {
                                                                        $etiketdata[$e] = array(
                                                                            'urunetiket_UrunID' => $result,
                                                                            'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                        );
                                                                    }
                                                                    $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                    if ($resultEtiket) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["result"] = "1";
                                                                }
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
                    break;
                case "urunSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deleteurun = $Panel_Model->urunDelete($ID);
                    if ($deleteurun) {
                        $deleteust = $Panel_Model->urunEtiketDelete($ID);
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;
                case "urunDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $newresult = array();

                    $urunetiketListe = $Panel_Model->urunEtiketListe($ID);
                    $a = 0;
                    foreach ($urunetiketListe as $urunetiketListee) {
                        $etiketlist[$a]['EtiketID'] = $urunetiketListee['urunetiket_EtiketID'];
                        $a++;
                    }
                    $newresult[0] = $etiketlist;

                    $urunListe = $Panel_Model->panelurunDuzenlistele($ID);
                    foreach ($urunListe as $urunListee) {
                        $urunlist['ID'] = $urunListee['urun_ID'];
                        $urunlist['KatID'] = $urunListee['urun_kategoriID'];
                        $urunlist['KatAd'] = $urunListee['urun_kategoriAd'];
                        $urunlist['Kod'] = $urunListee['urun_kodu'];
                        $urunlist['Aciklama'] = $urunListee['urun_aciklama'];
                        $urunlist['Fiyat'] = $urunListee['urun_fiyat'];
                        $urunlist['NFiyat'] = $urunListee['urun_normalfiyat'];
                        $urunlist['Aktif'] = $urunListee['urun_aktiflik'];
                        $urunlist['Sira'] = $urunListee['urun_sira'];
                        $urunlist['Yeni'] = $urunListee['urun_yeniurun'];
                        $urunlist['Ek'] = $urunListee['urun_ekurun'];
                        $urunlist['Adi'] = $urunListee['urun_adi'];
                        $urunlist['HaftaUrun'] = $urunListee['urun_hafta'];
                        $urunlist['Resim'] = $urunListee['urun_anaresim'];
                        $urunlist['CokSatan'] = $urunListee['urun_coksatan'];
                    }
                    $newresult[1] = $urunlist;

                    $sonuc["result"] = $newresult;
                    break;
                case "urunDuzenle":
                    require "app/otherClasses/class.upload.php";

                    $form->post("urunID", true);
                    $form->post("urunKod", true);
                    $form->post("siraolanurun", true);
                    $form->post("urunKatVal", true);
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("degisecekurunid", true);
                    $form->post("resimKontrol", true);
                    $form->post("newImage", true);
                    $form->post("normalSira", true);
                    $urunID = $form->values['urunID'];
                    $urunAdi = $_POST['urunAdi'];
                    $urunKod = $form->values['urunKod'];
                    $urunKatText = $_POST['urunKatText'];
                    $siraolanurun = $form->values['siraolanurun'];
                    $urunKatVal = $form->values['urunKatVal'];
                    $urunFiyat = $_POST['urunFiyat'];
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $urunYazi = $_POST['urunYazi'];
                    $degisecekurunid = $form->values['degisecekurunid'];
                    $resimKontrol = $form->values['resimKontrol'];
                    $newImage = $form->values['newImage'];
                    $normalSira = $form->values['normalSira'];

                    $urunOzellikArray = $_REQUEST['urunOzellikArray'];
                    $explodeOzellikArray = explode(",", $urunOzellikArray[0]);
                    $urunEtiketArray = $_REQUEST['urunEtiketArray'];
                    $explodeEtiketArray = explode(",", $urunEtiketArray[0]);
                    if ($urunAdi == "") {
                        $sonuc["hata"] = "Lütfen Ürün Adını Giriniz.";
                    } else {
                        if ($urunKod == "") {
                            $sonuc["hata"] = "Lütfen Ürün Kodunu Giriniz.";
                        } else {
                            if ($urunKatVal != -1) {
                                if ($urunKatVal == 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Kategorisini Giriniz.";
                                } else {
                                    if ($urunFiyat <= 0) {
                                        $sonuc["hata"] = "Lütfen Ürün Fiyatını Giriniz.";
                                    } else {
                                        if ($sira <= 0) {
                                            $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                        } else {
                                            if ($resimKontrol == 0) {
                                                $sonuc["hata"] = "Lütfen Ürün Resmi Giriniz.";
                                            } else {
                                                if ($explodeOzellikArray[1] > 0) {
                                                    if ($form->submit()) {
                                                        $dataUrunHafta = array(
                                                            'urun_hafta' => 0
                                                        );
                                                    }
                                                    $urunHaftaUpdate = $Panel_Model->urunHaftaUpdate($dataUrunHafta);
                                                }
                                                $yeniurun = $form->turkce_kucult_tr($urunAdi);
                                                if ($newImage == 0) {//yeni resim eklenmemiş
                                                    if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                        if ($form->submit()) {
                                                            $dataUrun = array(
                                                                'urun_sira' => $normalSira
                                                            );
                                                        }
                                                        $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                        if ($urunUpdate) {
                                                            if ($form->submit()) {
                                                                $dataUrun = array(
                                                                    'urun_kategoriID' => $urunKatVal,
                                                                    'urun_kategoriAd' => $urunKatText,
                                                                    'urun_kodu' => $urunKod,
                                                                    'urun_aciklama' => $urunYazi,
                                                                    'urun_fiyat' => $urunFiyat,
                                                                    'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                    'urun_aktiflik' => $durum,
                                                                    'urun_sira' => $sira,
                                                                    'urun_yeniurun' => $explodeOzellikArray[0],
                                                                    'urun_ekurun' => 0,
                                                                    'urun_adi' => $urunAdi,
                                                                    'urun_benzad' => $yeniurun,
                                                                    'urun_kmpnyaid' => 0,
                                                                    'urun_hafta' => $explodeOzellikArray[1],
                                                                    'urun_coksatan' => $explodeOzellikArray[2]
                                                                );
                                                            }
                                                            $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                            if ($result) {
                                                                $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                                $etiketArray = count($explodeEtiketArray);
                                                                if ($etiketArray > 0) {
                                                                    for ($e = 0; $e < $etiketArray; $e++) {
                                                                        $etiketdata[$e] = array(
                                                                            'urunetiket_UrunID' => $urunID,
                                                                            'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                        );
                                                                    }
                                                                    $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                    if ($resultEtiket) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["result"] = "1";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        if ($form->submit()) {
                                                            $dataUrun = array(
                                                                'urun_kategoriID' => $urunKatVal,
                                                                'urun_kategoriAd' => $urunKatText,
                                                                'urun_kodu' => $urunKod,
                                                                'urun_aciklama' => $urunYazi,
                                                                'urun_fiyat' => $urunFiyat,
                                                                'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                'urun_aktiflik' => $durum,
                                                                'urun_sira' => $sira,
                                                                'urun_yeniurun' => $explodeOzellikArray[0],
                                                                'urun_ekurun' => 0,
                                                                'urun_adi' => $urunAdi,
                                                                'urun_benzad' => $yeniurun,
                                                                'urun_kmpnyaid' => 0,
                                                                'urun_hafta' => $explodeOzellikArray[1],
                                                                'urun_coksatan' => $explodeOzellikArray[2]
                                                            );
                                                        }
                                                        $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                        if ($result) {
                                                            $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                            $etiketArray = count($explodeEtiketArray);
                                                            if ($etiketArray > 0) {
                                                                for ($e = 0; $e < $etiketArray; $e++) {
                                                                    $etiketdata[$e] = array(
                                                                        'urunetiket_UrunID' => $urunID,
                                                                        'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                    );
                                                                }
                                                                $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                if ($resultEtiket) {
                                                                    $sonuc["result"] = "1";
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                $sonuc["result"] = "1";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    }
                                                } else {//yeni resim eklenmiş
                                                    $realName = $_FILES['file']['name'];
                                                    $image = new Upload($_FILES['file']);
                                                    //oranlama
                                                    $width = $image->image_src_x;
                                                    $height = $image->image_src_y;
                                                    $oran = $width / $height;
                                                    if ($oran < 1) {
                                                        $newheight = 500;
                                                        $newwidth = round($height * $oran);
                                                    } else if ($oran == 1) {
                                                        $newheight = 500;
                                                        $newwidth = 500;
                                                    } else {
                                                        $newheight = round($width / $oran);
                                                        $newwidth = 500;
                                                    }
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
                                                        $image->image_x = $newwidth;
                                                        $image->image_y = $newheight;
                                                        $image->image_watermark = 'images/watermark.png';
                                                        $image->image_watermark_position = 'B';

                                                        $image->Process("products");
                                                        if ($image->processed) {
                                                            if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                                if ($form->submit()) {
                                                                    $dataUrun = array(
                                                                        'urun_sira' => $normalSira
                                                                    );
                                                                }
                                                                $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                                if ($urunUpdate) {
                                                                    if ($form->submit()) {
                                                                        $dataUrun = array(
                                                                            'urun_kategoriID' => $urunKatVal,
                                                                            'urun_kategoriAd' => $urunKatText,
                                                                            'urun_kodu' => $urunKod,
                                                                            'urun_aciklama' => $urunYazi,
                                                                            'urun_fiyat' => $urunFiyat,
                                                                            'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                            'urun_aktiflik' => $durum,
                                                                            'urun_sira' => $sira,
                                                                            'urun_yeniurun' => $explodeOzellikArray[0],
                                                                            'urun_ekurun' => 0,
                                                                            'urun_adi' => $urunAdi,
                                                                            'urun_benzad' => $yeniurun,
                                                                            'urun_kmpnyaid' => 0,
                                                                            'urun_hafta' => $explodeOzellikArray[1],
                                                                            'urun_anaresim' => $image->file_dst_name,
                                                                            'urun_anaresimreal' => $realName,
                                                                            'urun_coksatan' => $explodeOzellikArray[2]
                                                                        );
                                                                    }
                                                                    $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                                    if ($result) {
                                                                        $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                                        $etiketArray = count($explodeEtiketArray);
                                                                        if ($etiketArray > 0) {
                                                                            for ($e = 0; $e < $etiketArray; $e++) {
                                                                                $etiketdata[$e] = array(
                                                                                    'urunetiket_UrunID' => $urunID,
                                                                                    'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                                );
                                                                            }
                                                                            $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                            if ($resultEtiket) {
                                                                                $sonuc["result"] = "1";
                                                                            } else {
                                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                            }
                                                                        } else {
                                                                            $sonuc["result"] = "1";
                                                                        }
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                if ($form->submit()) {
                                                                    $dataUrun = array(
                                                                        'urun_kategoriID' => $urunKatVal,
                                                                        'urun_kategoriAd' => $urunKatText,
                                                                        'urun_kodu' => $urunKod,
                                                                        'urun_aciklama' => $urunYazi,
                                                                        'urun_fiyat' => $urunFiyat,
                                                                        'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                        'urun_aktiflik' => $durum,
                                                                        'urun_sira' => $sira,
                                                                        'urun_yeniurun' => $explodeOzellikArray[0],
                                                                        'urun_ekurun' => 0,
                                                                        'urun_adi' => $urunAdi,
                                                                        'urun_benzad' => $yeniurun,
                                                                        'urun_kmpnyaid' => 0,
                                                                        'urun_hafta' => $explodeOzellikArray[1],
                                                                        'urun_anaresim' => $image->file_dst_name,
                                                                        'urun_anaresimreal' => $realName,
                                                                        'urun_coksatan' => $explodeOzellikArray[2]
                                                                    );
                                                                }
                                                                $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                                if ($result) {
                                                                    $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                                    $etiketArray = count($explodeEtiketArray);
                                                                    if ($etiketArray > 0) {
                                                                        for ($e = 0; $e < $etiketArray; $e++) {
                                                                            $etiketdata[$e] = array(
                                                                                'urunetiket_UrunID' => $urunID,
                                                                                'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                            );
                                                                        }
                                                                        $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                        if ($resultEtiket) {
                                                                            $sonuc["result"] = "1";
                                                                        } else {
                                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                        }
                                                                    } else {
                                                                        $sonuc["result"] = "1";
                                                                    }
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
                                if ($urunFiyat <= 0) {
                                    $sonuc["hata"] = "Lütfen Ürün Fiyatını Giriniz.";
                                } else {
                                    if ($sira <= 0) {
                                        $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                                    } else {
                                        if ($resimKontrol == 0) {
                                            $sonuc["hata"] = "Lütfen Ürün Resmi Giriniz.";
                                        } else {
                                            if ($explodeOzellikArray[1] > 0) {
                                                if ($form->submit()) {
                                                    $dataUrunHafta = array(
                                                        'urun_hafta' => 0
                                                    );
                                                }
                                                $urunHaftaUpdate = $Panel_Model->urunHaftaUpdate($dataUrunHafta);
                                            }
                                            $yeniurun = $form->turkce_kucult_tr($urunAdi);
                                            if ($newImage == 0) {//yeni resim eklenmemiş
                                                if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                    if ($form->submit()) {
                                                        $dataUrun = array(
                                                            'urun_sira' => $normalSira
                                                        );
                                                    }
                                                    $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                    if ($urunUpdate) {
                                                        if ($form->submit()) {
                                                            $dataUrun = array(
                                                                'urun_kategoriID' => $urunKatVal,
                                                                'urun_kategoriAd' => $urunKatText, 'urun_kodu' => $urunKod,
                                                                'urun_aciklama' => $urunYazi,
                                                                'urun_fiyat' => $urunFiyat,
                                                                'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                'urun_aktiflik' => $durum,
                                                                'urun_sira' => $sira,
                                                                'urun_yeniurun' => $explodeOzellikArray[0],
                                                                'urun_ekurun' => 1,
                                                                'urun_adi' => $urunAdi,
                                                                'urun_benzad' => $yeniurun,
                                                                'urun_kmpnyaid' => 0,
                                                                'urun_hafta' => $explodeOzellikArray[1],
                                                                'urun_coksatan' => $explodeOzellikArray[2]
                                                            );
                                                        }
                                                        $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                        if ($result) {
                                                            $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                            $etiketArray = count($explodeEtiketArray);
                                                            if ($etiketArray > 0) {
                                                                for ($e = 0; $e < $etiketArray; $e++) {
                                                                    $etiketdata[$e] = array(
                                                                        'urunetiket_UrunID' => $urunID,
                                                                        'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                    );
                                                                }
                                                                $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                if ($resultEtiket) {
                                                                    $sonuc["result"] = "1";
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                $sonuc["result"] = "1";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    if ($form->submit()) {
                                                        $dataUrun = array('urun_kategoriID' => $urunKatVal,
                                                            'urun_kategoriAd' => $urunKatText,
                                                            'urun_kodu' => $urunKod,
                                                            'urun_aciklama' => $urunYazi,
                                                            'urun_fiyat' => $urunFiyat,
                                                            'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                            'urun_aktiflik' => $durum,
                                                            'urun_sira' => $sira,
                                                            'urun_yeniurun' => $explodeOzellikArray[0],
                                                            'urun_ekurun' => 1,
                                                            'urun_adi' => $urunAdi,
                                                            'urun_benzad' => $yeniurun,
                                                            'urun_kmpnyaid' => 0,
                                                            'urun_hafta' => $explodeOzellikArray[1],
                                                            'urun_coksatan' => $explodeOzellikArray[2]
                                                        );
                                                    }
                                                    $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                    if ($result) {
                                                        $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                        $etiketArray = count($explodeEtiketArray);
                                                        if ($etiketArray > 0) {
                                                            for ($e = 0; $e < $etiketArray; $e++) {
                                                                $etiketdata[$e] = array(
                                                                    'urunetiket_UrunID' => $urunID,
                                                                    'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                );
                                                            }
                                                            $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                            if ($resultEtiket) {
                                                                $sonuc["result"] = "1";
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        } else {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                    }
                                                }
                                            } else {//yeni resim eklenmiş
                                                $realName = $_FILES['file']['name'];
                                                $image = new Upload($_FILES['file']);
                                                //oranlama
                                                $width = $image->image_src_x;
                                                $height = $image->image_src_y;

                                                $oran = $width / $height;
                                                if ($oran < 1) {
                                                    $newheight = 500;
                                                    $newwidth = round($height * $oran);
                                                } else if ($oran == 1) {
                                                    $newheight = 500;
                                                    $newwidth = 500;
                                                } else {
                                                    $newheight = round($width / $oran);
                                                    $newwidth = 500;
                                                }
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
                                                    $image->image_x = $newwidth;
                                                    $image->image_y = $newheight;
                                                    $image->image_watermark = 'images/watermark.png';
                                                    $image->image_watermark_position = 'B';

                                                    $image->Process("products");
                                                    if ($image->processed) {
                                                        if ($siraolanurun > 0) {//girilen ürüne ait başka sıra vardır
                                                            if ($form->submit()) {
                                                                $dataUrun = array('urun_sira' => $normalSira
                                                                );
                                                            }
                                                            $urunUpdate = $Panel_Model->urunSiraUpdate($dataUrun, $degisecekurunid);
                                                            if ($urunUpdate) {
                                                                if ($form->submit()) {
                                                                    $dataUrun = array('urun_kategoriID' => $urunKatVal,
                                                                        'urun_kategoriAd' => $urunKatText,
                                                                        'urun_kodu' => $urunKod,
                                                                        'urun_aciklama' => $urunYazi,
                                                                        'urun_fiyat' => $urunFiyat,
                                                                        'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                        'urun_aktiflik' => $durum,
                                                                        'urun_sira' => $sira,
                                                                        'urun_yeniurun' => $explodeOzellikArray[0],
                                                                        'urun_ekurun' => 1,
                                                                        'urun_adi' => $urunAdi,
                                                                        'urun_benzad' => $yeniurun,
                                                                        'urun_kmpnyaid' => 0,
                                                                        'urun_hafta' => $explodeOzellikArray[1],
                                                                        'urun_anaresim' => $image->file_dst_name,
                                                                        'urun_anaresimreal' => $realName,
                                                                        'urun_coksatan' => $explodeOzellikArray[2]
                                                                    );
                                                                }
                                                                $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                                if ($result) {
                                                                    $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                                    $etiketArray = count($explodeEtiketArray);
                                                                    if ($etiketArray > 0) {
                                                                        for ($e = 0; $e < $etiketArray; $e++) {
                                                                            $etiketdata[$e] = array(
                                                                                'urunetiket_UrunID' => $urunID,
                                                                                'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                            );
                                                                        }
                                                                        $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                        if ($resultEtiket) {
                                                                            $sonuc["result"] = "1";
                                                                        } else {
                                                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                        }
                                                                    } else {
                                                                        $sonuc["result"] = "1";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                                            }
                                                        } else {
                                                            if ($form->submit()) {
                                                                $dataUrun = array(
                                                                    'urun_kategoriID' => $urunKatVal,
                                                                    'urun_kategoriAd' => $urunKatText,
                                                                    'urun_kodu' => $urunKod,
                                                                    'urun_aciklama' => $urunYazi,
                                                                    'urun_fiyat' => $urunFiyat,
                                                                    'urun_normalfiyat' => $urunFiyat + round(($urunFiyat * 18) / 100),
                                                                    'urun_aktiflik' => $durum,
                                                                    'urun_sira' => $sira,
                                                                    'urun_yeniurun' => $explodeOzellikArray[0],
                                                                    'urun_ekurun' => 1,
                                                                    'urun_adi' => $urunAdi,
                                                                    'urun_benzad' => $yeniurun,
                                                                    'urun_kmpnyaid' => 0,
                                                                    'urun_hafta' => $explodeOzellikArray[1],
                                                                    'urun_anaresim' => $image->file_dst_name,
                                                                    'urun_anaresimreal' => $realName,
                                                                    'urun_coksatan' => $explodeOzellikArray[2]
                                                                );
                                                            }
                                                            $result = $Panel_Model->panelurunUpdate($dataUrun, $urunID);
                                                            if ($result) {
                                                                $deleteEt = $Panel_Model->urunEtiketDelete($urunID);
                                                                $etiketArray = count($explodeEtiketArray);
                                                                if ($etiketArray > 0) {
                                                                    for ($e = 0; $e < $etiketArray; $e++) {
                                                                        $etiketdata[$e] = array(
                                                                            'urunetiket_UrunID' => $urunID,
                                                                            'urunetiket_EtiketID' => $explodeEtiketArray[$e]
                                                                        );
                                                                    }
                                                                    $resultEtiket = $Panel_Model->panelMultiUrunEtiket($etiketdata);
                                                                    if ($resultEtiket) {
                                                                        $sonuc["result"] = "1";
                                                                    } else {
                                                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                                                    }
                                                                } else {
                                                                    $sonuc["result"] = "1";
                                                                }
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
                    break;
                case "etiketSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deleteetiket = $Panel_Model->etiketDelete($ID);
                    if ($deleteetiket) {
                        $deletekatisim = $Panel_Model->kategoriIsimDelete($ID);
                        if ($deletekatisim) {
                            $sonuc["cevap"] = "Başarıyla silinmiştir.";
                        }
                    }
                    break;
                case "etiketEkle":
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("maksSira", true);
                    $form->post("degisecekID", true);
                    $etiketAdi = $_POST['etiketAdi'];
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $sonUstSira = $form->values['maksSira'];
                    $degisecekID = $form->values['degisecekID'];
                    if ($etiketAdi == "") {
                        $sonuc["hata"] = "Lütfen Etiket Adını Giriniz.";
                    } else {
                        if ($sira <= 0) {
                            $sonuc["hata"] = "Lütfen Sırayı Giriniz.";
                        } else {
                            $kattr = $form->turkce_kucult_tr($etiketAdi);
                            $benzersizListe = $Panel_Model->etiketBenzersizKontrol($kattr);
                            foreach ($benzersizListe as $benzersizListee) {
                                $benzersiz['ID'] = $benzersizListee['etiket_id'];
                            }
                            if ($benzersiz['ID'] > 0) {
                                $sonuc["hata"] = "Etiket Başlığı Daha Önce Girilmiş Tekrar Deneyiniz.";
                            } else {
                                if ($degisecekID > 0) {//değişecek vardır
                                    if ($form->submit()) {
                                        $data = array(
                                            'etiket_sira' => $sonUstSira + 1
                                        );
                                    }
                                    $etiketUpdate = $Panel_Model->etiketSiraUpdate($data, $degisecekID);
                                    if ($etiketUpdate) {
                                        $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                        if ($form->submit()) {
                                            $dataE = array(
                                                'etiket_adi' => $etiketAdi,
                                                'etiket_benzad' => $yenikat,
                                                'etiket_yazi' => "",
                                                'etiket_aktiflik' => $durum,
                                                'etiket_sira' => $sira
                                            );
                                        }
                                        $result = $Panel_Model->etiketekle($dataE);
                                        if ($result) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat,
                                                'kategoriID' => $result,
                                                'kategoriTip' => 0
                                            );
                                            $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                    }
                                } else {
                                    $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                    if ($form->submit()) {
                                        $dataE = array(
                                            'etiket_adi' => $etiketAdi,
                                            'etiket_benzad' => $yenikat,
                                            'etiket_yazi' => "",
                                            'etiket_aktiflik' => $durum,
                                            'etiket_sira' => $sira
                                        );
                                    }
                                    $result = $Panel_Model->etiketekle($dataE);
                                    if ($result) {
                                        $dataKatIsim = array(
                                            'kategoriAd' => $yenikat,
                                            'kategoriID' => $result,
                                            'kategoriTip' => 0
                                        );
                                        $resultKat = $Panel_Model->kategoriIsimEkle($dataKatIsim);
                                        if ($resultKat) {
                                            $sonuc["result"] = "1";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                    }
                                }
                            }
                        }
                    }

                    break;
                case "etiketDuzenle":
                    $form->post("durum", true);
                    $form->post("sira", true);
                    $form->post("maksSira", true);
                    $form->post("degisecekID", true);
                    $form->post("normalSira", true);
                    $form->post("duzenlenenID", true);
                    $etiketAdi = $_POST['etiketAdi'];
                    $etiketNormalAdi = $_POST['etiketNormalAdi'];
                    $durum = $form->values['durum'];
                    $sira = $form->values['sira'];
                    $sonUstSira = $form->values['maksSira'];
                    $degisecekID = $form->values['degisecekID'];
                    $normalSira = $form->values['normalSira'];
                    $duzenlenenID = $form->values['duzenlenenID'];
                    if ($etiketAdi == "") {
                        $sonuc["hata"] = "Lütfen Kategori Adınızı Giriniz";
                    } else {
                        if ($sira <= 0) {
                            $sonuc["hata"] = "Lütfen Sırasını Giriniz";
                        } else {
                            if ($etiketAdi == $etiketNormalAdi) {
                                if ($sira == $normalSira) {//sıra eşitse
                                    $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                    if ($form->submit()) {
                                        $data = array(
                                            'etiket_adi' => $etiketAdi,
                                            'etiket_benzad' => $yenikat,
                                            'etiket_aktiflik' => $durum
                                        );
                                    }
                                    $resultUrun = $Panel_Model->paneletiketupdate($data, $duzenlenenID);
                                    if ($resultUrun) {
                                        $dataKatIsim = array(
                                            'kategoriAd' => $yenikat
                                        );
                                        $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                        if ($resultKat) {
                                            $sonuc["result"] = "1";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                    }
                                } else {
                                    if ($form->submit()) {
                                        $data = array(
                                            'etiket_sira' => $normalSira
                                        );
                                    }
                                    $etiketUpdate = $Panel_Model->etiketSiraUpdate($data, $degisecekID);
                                    if ($etiketUpdate) {
                                        $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'etiket_adi' => $etiketAdi,
                                                'etiket_benzad' => $yenikat,
                                                'etiket_aktiflik' => $durum,
                                                'etiket_sira' => $sira
                                            );
                                        }
                                        $resultUrun = $Panel_Model->paneletiketupdate($data, $duzenlenenID);
                                        if ($resultUrun) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat
                                            );
                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Tekrar Deneyiniz";
                                    }
                                }
                            } else {
                                $kattr = $form->turkce_kucult_tr($etiketAdi);
                                $benzersizListe = $Panel_Model->etiketBenzersizKontrol($kattr);
                                foreach ($benzersizListe as $benzersizListee) {
                                    $benzersiz['ID'] = $benzersizListee['etiket_id'];
                                }
                                if ($benzersiz['ID'] > 0) {
                                    $sonuc["hata"] = "Etiket Başlığı Daha Önce Girilmiş Tekrar Deneyiniz.";
                                } else {
                                    if ($sira == $normalSira) {//sıra eşitse
                                        $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                        if ($form->submit()) {
                                            $data = array(
                                                'etiket_adi' => $etiketAdi,
                                                'etiket_benzad' => $yenikat,
                                                'etiket_aktiflik' => $durum
                                            );
                                        }
                                        $resultUrun = $Panel_Model->paneletiketupdate($data, $duzenlenenID);
                                        if ($resultUrun) {
                                            $dataKatIsim = array(
                                                'kategoriAd' => $yenikat
                                            );
                                            $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                            if ($resultKat) {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    } else {
                                        if ($form->submit()) {
                                            $data = array(
                                                'etiket_sira' => $normalSira
                                            );
                                        }
                                        $etiketUpdate = $Panel_Model->etiketSiraUpdate($data, $degisecekID);
                                        if ($etiketUpdate) {
                                            $yenikat = $form->turkce_kucult_tr($etiketAdi);
                                            if ($form->submit()) {
                                                $data = array(
                                                    'etiket_adi' => $etiketAdi,
                                                    'etiket_benzad' => $yenikat,
                                                    'etiket_aktiflik' => $durum,
                                                    'etiket_sira' => $sira
                                                );
                                            }
                                            $resultUrun = $Panel_Model->paneletiketupdate($data, $duzenlenenID);
                                            if ($resultUrun) {
                                                $dataKatIsim = array(
                                                    'kategoriAd' => $yenikat
                                                );
                                                $resultKat = $Panel_Model->kategoriIsımDuzenle($dataKatIsim, $duzenlenenID);
                                                if ($resultKat) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Tekrar Deneyiniz";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
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

