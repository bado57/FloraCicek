<?php

class Genel extends Controller {

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

                case "urunTab":
                    $form->post("tab", true);
                    $form->post("katID", true);
                    $form->post("katTip", true);
                    $tab = $form->values['tab'];
                    $katID = $form->values['katID'];
                    $katTip = $form->values['katTip'];
                    if ($katTip == 0) {//amaca göre olan kateoriler içindir
                        if ($tab == 1) {//çok satanlar
                            //etiket-ürün id listeleme
                            $etiketurunid = $Panel_Model->kategorietiketurunid($katID);
                            foreach ($etiketurunid as $etiketurunidd) {
                                $urunId[] = $etiketurunidd['urunetiket_UrunID'];
                            }
                            if (count($urunId) > 0) {
                                //kategoriye ait ürünleri listeleme
                                $uruniddizi = implode(',', $urunId);
                                //kategoriye ait ürünleri listeleme
                                $kategoriurunListe = $Panel_Model->etiketuruncslistele($uruniddizi);

                                //kampanyalı ürünlerin listesi
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                    }
                                }
                                //kampanyalı ürünler için 
                                if (count($kampanyaId) > 0) {
                                    $kampanyadizi = implode(',', $kampanyaId);
                                    $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                    $kmpny = 0;
                                    foreach ($kampanyalar as $kampanyalarr) {
                                        $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                        $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                        $kmpny++;
                                    }
                                }
                                $ku = 0;
                                if (count($urunkampanya) > 0) {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                            if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                                $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                                $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                            }
                                            $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                            $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                            $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                            $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                            $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                            $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        }
                                        $ku++;
                                    }
                                } else {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        $ku++;
                                    }
                                }
                            }
                        } else if ($tab == 2) {//ucuzdan pahalıya
                            //etiket-ürün id listeleme
                            $etiketurunid = $Panel_Model->kategorietiketurunid($katID);
                            foreach ($etiketurunid as $etiketurunidd) {
                                $urunId[] = $etiketurunidd['urunetiket_UrunID'];
                            }
                            if (count($urunId) > 0) {
                                //kategoriye ait ürünleri listeleme
                                $uruniddizi = implode(',', $urunId);
                                //kategoriye ait ürünleri listeleme
                                $kategoriurunListe = $Panel_Model->etiketurunuplistele($uruniddizi);

                                //kampanyalı ürünlerin listesi
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                    }
                                }
                                //kampanyalı ürünler için 
                                if (count($kampanyaId) > 0) {
                                    $kampanyadizi = implode(',', $kampanyaId);
                                    $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                    $kmpny = 0;
                                    foreach ($kampanyalar as $kampanyalarr) {
                                        $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                        $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                        $kmpny++;
                                    }
                                }
                                $ku = 0;
                                if (count($urunkampanya) > 0) {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                            if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                                $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                                $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                            }
                                            $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                            $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                            $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                            $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                            $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                            $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        }
                                        $ku++;
                                    }
                                } else {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        $ku++;
                                    }
                                }
                            }
                        } else if ($tab == 3) {//pahalıdan ucuza
                            //etiket-ürün id listeleme
                            $etiketurunid = $Panel_Model->kategorietiketurunid($katID);
                            foreach ($etiketurunid as $etiketurunidd) {
                                $urunId[] = $etiketurunidd['urunetiket_UrunID'];
                            }
                            if (count($urunId) > 0) {
                                //kategoriye ait ürünleri listeleme
                                $uruniddizi = implode(',', $urunId);
                                //kategoriye ait ürünleri listeleme
                                $kategoriurunListe = $Panel_Model->etiketurunpulistele($uruniddizi);

                                //kampanyalı ürünlerin listesi
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                    }
                                }
                                //kampanyalı ürünler için 
                                if (count($kampanyaId) > 0) {
                                    $kampanyadizi = implode(',', $kampanyaId);
                                    $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                    $kmpny = 0;
                                    foreach ($kampanyalar as $kampanyalarr) {
                                        $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                        $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                        $kmpny++;
                                    }
                                }
                                $ku = 0;
                                if (count($urunkampanya) > 0) {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                            if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                                $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                                $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                            }
                                            $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                            $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                            $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                            $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                            $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                            $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        }
                                        $ku++;
                                    }
                                } else {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $$kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        $ku++;
                                    }
                                }
                            }
                        } else if ($tab == 4) {//a-dan z-ye
                            //etiket-ürün id listeleme
                            $etiketurunid = $Panel_Model->kategorietiketurunid($katID);
                            foreach ($etiketurunid as $etiketurunidd) {
                                $urunId[] = $etiketurunidd['urunetiket_UrunID'];
                            }
                            if (count($urunId) > 0) {
                                //kategoriye ait ürünleri listeleme
                                $uruniddizi = implode(',', $urunId);
                                //kategoriye ait ürünleri listeleme
                                $kategoriurunListe = $Panel_Model->etiketurunazlistele($uruniddizi);

                                //kampanyalı ürünlerin listesi
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                    }
                                }
                                //kampanyalı ürünler için 
                                if (count($kampanyaId) > 0) {
                                    $kampanyadizi = implode(',', $kampanyaId);
                                    $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                    $kmpny = 0;
                                    foreach ($kampanyalar as $kampanyalarr) {
                                        $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                        $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                        $kmpny++;
                                    }
                                }
                                $ku = 0;
                                if (count($urunkampanya) > 0) {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                            if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                                $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                                $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                            }
                                            $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                            $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                            $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                            $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                            $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                            $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        }
                                        $ku++;
                                    }
                                } else {
                                    foreach ($kategoriurunListe as $kategoriurunListee) {
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                        $ku++;
                                    }
                                }
                            }
                        }
                    } else if ($katTip == 1) {//normal kategoriler içindir
                        if ($tab == 1) {//çok satanlar
                            //kategoriye ait ürünleri listeleme
                            $kategoriurunListe = $Panel_Model->kategoricsurunlistele($katID);

                            //kampanyalı ürünlerin listesi
                            foreach ($kategoriurunListe as $kategoriurunListee) {
                                if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                }
                            }
                            //kampanyalı ürünler için 
                            if (count($kampanyaId) > 0) {
                                $kampanyadizi = implode(',', $kampanyaId);
                                $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                $kmpny = 0;
                                foreach ($kampanyalar as $kampanyalarr) {
                                    $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                    $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                    $kmpny++;
                                }
                            }
                            $ku = 0;
                            if (count($urunkampanya) > 0) {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                        if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                            $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                            $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                        }
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    }
                                    $ku++;
                                }
                            } else {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 2) {//ucuzdan pahalıya
                            //kategoriye ait ürünleri listeleme
                            $kategoriurunListe = $Panel_Model->kategoriupurunlistele($katID);

                            //kampanyalı ürünlerin listesi
                            foreach ($kategoriurunListe as $kategoriurunListee) {
                                if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                }
                            }
                            //kampanyalı ürünler için 
                            if (count($kampanyaId) > 0) {
                                $kampanyadizi = implode(',', $kampanyaId);
                                $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                $kmpny = 0;
                                foreach ($kampanyalar as $kampanyalarr) {
                                    $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                    $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                    $kmpny++;
                                }
                            }
                            $ku = 0;
                            if (count($urunkampanya) > 0) {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                        if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                            $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                            $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                        }
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    }
                                    $ku++;
                                }
                            } else {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 3) {//pahalıdan ucuza
                            //kategoriye ait ürünleri listeleme
                            $kategoriurunListe = $Panel_Model->kategoripuurunlistele($katID);

                            //kampanyalı ürünlerin listesi
                            foreach ($kategoriurunListe as $kategoriurunListee) {
                                if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                }
                            }
                            //kampanyalı ürünler için 
                            if (count($kampanyaId) > 0) {
                                $kampanyadizi = implode(',', $kampanyaId);
                                $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                $kmpny = 0;
                                foreach ($kampanyalar as $kampanyalarr) {
                                    $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                    $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                    $kmpny++;
                                }
                            }
                            $ku = 0;
                            if (count($urunkampanya) > 0) {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                        if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                            $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                            $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                        }
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    }
                                    $ku++;
                                }
                            } else {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 4) {//AdanZye
                            //kategoriye ait ürünleri listeleme
                            $kategoriurunListe = $Panel_Model->kategoriazurunlistele($katID);

                            //kampanyalı ürünlerin listesi
                            foreach ($kategoriurunListe as $kategoriurunListee) {
                                if ($kategoriurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $kampanyaId[] = $kategoriurunListee['urun_kmpnyaid'];
                                }
                            }
                            //kampanyalı ürünler için 
                            if (count($kampanyaId) > 0) {
                                $kampanyadizi = implode(',', $kampanyaId);
                                $kampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                $kmpny = 0;
                                foreach ($kampanyalar as $kampanyalarr) {
                                    $urunkampanya[$kmpny]['ID'] = $kampanyalarr['kampanya_ID'];
                                    $urunkampanya[$kmpny]['Yuzde'] = $kampanyalarr['kampanya_indirimyuzde'];
                                    $kmpny++;
                                }
                            }
                            $ku = 0;
                            if (count($urunkampanya) > 0) {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    for ($kmp = 0; $kmp < count($urunkampanya); $kmp++) {
                                        if ($urunkampanya[$kmp]['ID'] == $kategoriurunListee['urun_kmpnyaid']) {
                                            $kategorilist[$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                            $kategorilist[$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                                        }
                                        $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                        $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                        $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                        $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                        $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                        $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    }
                                    $ku++;
                                }
                            } else {
                                foreach ($kategoriurunListe as $kategoriurunListee) {
                                    $kategorilist[$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        }
                    } else if ($katTip == 2) {
                        if ($tab == 1) {//çok satanlar
                            //kampanyalı kategori listeleme
                            $katkampanyaListe = $Panel_Model->katkampanyadetaylistele($katID, date("Y/m/d"));
                            foreach ($katkampanyaListe as $katkampanyaListee) {
                                $katYuzde = $katkampanyaListee['kampanya_indirimyuzde'];
                            }

                            if ($katYuzde > 0) {
                                $kmpurunListe = $Panel_Model->katkampanyaurunlistele($katID);
                                $ku = 0;
                                foreach ($kmpurunListe as $kmpurunListee) {
                                    $kategorilist[$ku]['KID'] = $katID;
                                    $kategorilist[$ku]['KYuzde'] = $katYuzde;
                                    $kategorilist[$ku]['urunID'] = $kmpurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kmpurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kmpurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kmpurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kmpurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kmpurunListee['urun_benzad'] . "-" . $kmpurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 2) {//ucuzdan pahalıya
                            //kampanyalı kategori listeleme
                            $katkampanyaListe = $Panel_Model->katkampanyadetaylistele($katID, date("Y/m/d"));
                            foreach ($katkampanyaListe as $katkampanyaListee) {
                                $katYuzde = $katkampanyaListee['kampanya_indirimyuzde'];
                            }

                            if ($katYuzde > 0) {
                                $kmpurunListe = $Panel_Model->katkampanyaupurunlistele($katID);
                                $ku = 0;
                                foreach ($kmpurunListe as $kmpurunListee) {
                                    $kategorilist[$ku]['KID'] = $katID;
                                    $kategorilist[$ku]['KYuzde'] = $katYuzde;
                                    $kategorilist[$ku]['urunID'] = $kmpurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kmpurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kmpurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kmpurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kmpurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kmpurunListee['urun_benzad'] . "-" . $kmpurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 3) {//pahalıdan ucuza
                            //kampanyalı kategori listeleme
                            $katkampanyaListe = $Panel_Model->katkampanyadetaylistele($katID, date("Y/m/d"));
                            foreach ($katkampanyaListe as $katkampanyaListee) {
                                $katYuzde = $katkampanyaListee['kampanya_indirimyuzde'];
                            }

                            if ($katYuzde > 0) {
                                $kmpurunListe = $Panel_Model->katkampanyapuurunlistele($katID);
                                $ku = 0;
                                foreach ($kmpurunListe as $kmpurunListee) {
                                    $kategorilist[$ku]['KID'] = $katID;
                                    $kategorilist[$ku]['KYuzde'] = $katYuzde;
                                    $kategorilist[$ku]['urunID'] = $kmpurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kmpurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kmpurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kmpurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kmpurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kmpurunListee['urun_benzad'] . "-" . $kmpurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        } else if ($tab == 4) {//AdanZye
                            //kampanyalı kategori listeleme
                            $katkampanyaListe = $Panel_Model->katkampanyadetaylistele($katID, date("Y/m/d"));
                            foreach ($katkampanyaListe as $katkampanyaListee) {
                                $katYuzde = $katkampanyaListee['kampanya_indirimyuzde'];
                            }

                            if ($katYuzde > 0) {
                                $kmpurunListe = $Panel_Model->katkampanyaazurunlistele($katID);
                                $ku = 0;
                                foreach ($kmpurunListe as $kmpurunListee) {
                                    $kategorilist[$ku]['KID'] = $katID;
                                    $kategorilist[$ku]['KYuzde'] = $katYuzde;
                                    $kategorilist[$ku]['urunID'] = $kmpurunListee['urun_ID'];
                                    $kategorilist[$ku]['urunKod'] = $kmpurunListee['urun_kodu'];
                                    $kategorilist[$ku]['urunFiyat'] = $kmpurunListee['urun_fiyat'];
                                    $kategorilist[$ku]['urunResim'] = $kmpurunListee['urun_anaresim'];
                                    $kategorilist[$ku]['urunAd'] = $kmpurunListee['urun_adi'];
                                    $kategorilist[$ku]['urunUrl'] = $kmpurunListee['urun_benzad'] . "-" . $kmpurunListee['urun_benzersizkod'];
                                    $ku++;
                                }
                            }
                        }
                    }


                    $sonuc["result"] = $kategorilist;
                    break;
                case "ebulten":
                    $form->post("email", true);
                    $email = $form->values['email'];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                        $emailValidate = $form->mailControl1($email);
                        if ($emailValidate == 1) {
                            $mailliste = $Panel_Model->ebultenDbKontrol($email);
                            if (count($mailliste) <= 0) {
                                if (Session::get("KID") > 0) {
                                    if ($form->submit()) {
                                        $data = array(
                                            'mailhavuz_KID' => Session::get("KID"),
                                            'mailhavuz_Rol' => Session::get("KRol"),
                                            'mailhavuz_Mail' => $email
                                        );
                                    }
                                    $resultMail = $Panel_Model->mailHavuzInsert($data);
                                    if ($resultMail) {
                                        Session::set("EBulten", $resultMail);
                                        $sonuc["result"] = "Tebrikler e-bültene kayıt oldunuz";
                                    } else {
                                        $sonuc["hata"] = "Bir hata oluştu tekrar deneyiniz";
                                    }
                                } else {
                                    if ($form->submit()) {
                                        $data = array(
                                            'mailhavuz_KID' => 0,
                                            'mailhavuz_Rol' => 3,
                                            'mailhavuz_Mail' => $email
                                        );
                                    }
                                    $resultMail = $Panel_Model->mailHavuzInsert($data);
                                    if ($resultMail) {
                                        Session::set("EBulten", $resultMail);
                                        $sonuc["result"] = "Tebrikler e-bültene kayıt oldunuz";
                                    } else {
                                        $sonuc["hata"] = "Bir hata oluştu tekrar deneyiniz";
                                    }
                                }
                            } else {
                                $sonuc["hata"] = "Bu mail adresi zaten kayıtlıdır! Tekrar deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                    }
                    break;
                case "urunDetay":
                    $form->post("urunID", true);
                    $form->post("ilText", true);
                    $form->post("ilceText", true);
                    $form->post("semtText", true);
                    $form->post("mahText", true);
                    $form->post("tarih", true);
                    $form->post("saat", true);
                    $form->post("ilID", true);
                    $form->post("ilceID", true);
                    $form->post("semtID", true);
                    $form->post("mahID", true);
                    $form->post("saatID", true);
                    $form->post("pKodu", true);
                    $urunID = $form->values['urunID'];
                    $ilText = $form->values['ilText'];
                    $ilceText = $form->values['ilceText'];
                    $tarihim = $form->values['tarih'];
                    $saatText = $form->values['saat'];
                    $ilID = $form->values['ilID'];
                    $ilceID = $form->values['ilceID'];
                    $saatID = $form->values['saatID'];
                    $pKodu = $form->values['pKodu'];
                    Session::set("SipIl", $ilText);
                    Session::set("SipIlID", $ilID);
                    Session::set("SipIlce", $ilceText);
                    Session::set("SipIlceID", $ilceID);
                    Session::set("SipPKodu", $pKodu);

                    $tarih = explode("/", $tarihim);
                    $newTarih = $tarih[0] . "." . $tarih[1] . "." . $tarih[2];
                    $gun = date('D', strtotime("$tarih[1]/$tarih[0]/$tarih[2]"));
                    $simdikiGun = $form->gunogrenme("$gun");
                    if ($urunID > 0) {
                        if ($ilID > 0) {
                            if ($ilceID > 0) {
                                if ($tarihim != '') {
                                    if ($saatText != '') {
                                        $explSaat = explode(" - ", $saatText);
                                        date_default_timezone_set('Europe/Istanbul');
                                        $nowdate = date('H:i');
                                        if ($nowdate > $explSaat[0]) {
                                            $sonuc["hata"] = "Lütfen İleri Saatleri Seçiniz";
                                        } else {
                                            $ilceliste = $Panel_Model->urunIlceFiyatListele($ilceID);
                                            foreach ($ilceliste as $ilcelistee) {
                                                $ilcefiyat = $ilcelistee['ilce_ekucret'];
                                                $ilceadi = $ilcelistee['ilce_adi'];
                                            }
                                            unset($_SESSION['EkUrunID']);
                                            $newAdres = $ilText . ' ' . $ilceadi;
                                            Session::set("SipID", $urunID);
                                            Session::set("SipAdres", $newAdres);
                                            Session::set("SipIlceFiyat", $ilcefiyat);
                                            Session::set("SipTarih", $newTarih);
                                            Session::set("SipSaat", $saatText);
                                            Session::set("SipGun", $simdikiGun);
                                            $sonuc["result"] = 1;
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Saat Aralığı Seçiniz";
                                    }
                                } else {
                                    $sonuc["hata"] = "Lütfen Tarih Seçiniz";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen İlçe Seçiniz";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen İl Seçiniz";
                        }
                    } else {
                        $sonuc["hata"] = "Bir Hata Oluştu";
                    }
                    break;
                case "urunIl":
                    $sehirliste = $Panel_Model->urunIlListele();
                    $s = 0;
                    foreach ($sehirliste as $sehirlistee) {
                        $sehirList[$s]["ID"] = $sehirlistee['sehir_id'];
                        $sehirList[$s]["Ad"] = $sehirlistee['sehir_adi'];
                        $s++;
                    }
                    $sonuc["result"] = $sehirList;
                    break;
                case "urunIlce":
                    $form->post("ilid", true);
                    $ilid = $form->values['ilid'];
                    $ilceliste = $Panel_Model->urunIlceListele($ilid);
                    $i = 0;
                    foreach ($ilceliste as $ilcelistee) {
                        $ilceList[$i]["ID"] = $ilcelistee['ilce_id'];
                        $ilceList[$i]["Ad"] = $ilcelistee['ilce_adi'];
                        $ilceList[$i]["EkUcret"] = $ilcelistee['ilce_ekucret'];
                        $i++;
                    }
                    $sonuc["result"] = $ilceList;
                    break;
                /*
                  case "urunSemt":
                  $form->post("ilceid", true);
                  $ilceid = $form->values['ilceid'];
                  $semtliste = $Panel_Model->urunSemtListele($ilceid);
                  $s = 0;
                  foreach ($semtliste as $semtlistee) {
                  $semtList[$s]["ID"] = $semtlistee['semt_ilceID'];
                  $semtList[$s]["Ad"] = $semtlistee['semt_ad'];
                  $s++;
                  }
                  $sonuc["result"] = $semtList;
                  break;
                  case "urunMahalle":
                  $form->post("semtid", true);
                  $semtid = $form->values['semtid'];
                  $mahalleliste = $Panel_Model->urunMahalleListele($semtid);
                  $m = 0;
                  foreach ($mahalleliste as $mahallelistee) {
                  $mahalleList[$m]["ID"] = $mahallelistee['flora_mahalleID'];
                  $mahalleList[$m]["Ad"] = $mahallelistee['flora_mahallead'];
                  $m++;
                  }
                  $sonuc["result"] = $mahalleList;
                  break;
                  case "urunPKodu":
                  $form->post("mahid", true);
                  $mahid = $form->values['mahid'];
                  $pkoduliste = $Panel_Model->urunPKoduListele($mahid);
                  foreach ($pkoduliste as $pkodulistee) {
                  $pkoduList["ID"] = $pkodulistee['pkID'];
                  $pkoduList["Kod"] = $pkodulistee['pk_kod'];
                  }
                  $sonuc["result"] = $pkoduList;
                  break;
                 */
                case "girisYap":
                    if (Session::get("KID") > 0) {
                        $sonuc["result"] = 1;
                        $sonuc["giris"] = "Giriş Yapmışsınız, Yönlendiriliyorsunuz";
                    } else {
                        $form->post("email", true);
                        $form->post("sifre", true);
                        $email = $form->values['email'];
                        $sifre = $form->values['sifre'];
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            if ($sifre != '') {
                                $realSifre = $form->userSifreOlustur($email, $sifre);
                                $kullaniciliste = $Panel_Model->girisSorgu($email, $realSifre);
                                if (count($kullaniciliste) > 0) {
                                    //mail havuzuna kayıt oldu ise, session oluşturuyoruz
                                    $mailliste = $Panel_Model->ebultenDbKontrol($email);
                                    if (count($mailliste) > 0) {
                                        Session::set("EBulten", $mailliste[0]['mailhavuz_ID']);
                                    }

                                    foreach ($kullaniciliste as $kullanicilistee) {
                                        $id = $kullanicilistee['kullanici_id'];
                                        $ad = $kullanicilistee['kullanici_adSoyad'];
                                        $eposta = $kullanicilistee['kullanici_eposta'];
                                        $rol = $kullanicilistee['kullanici_rol'];
                                        $adres = $kullanicilistee['kullanici_adres'];
                                        $kurVNo = $kullanicilistee['kullanici_vergino'];
                                        $kurVDaire = $kullanicilistee['kullanici_vergid'];
                                    }
                                    if ($rol == 1) {
                                        $sonuc["result"] = 1;
                                    } else {
                                        $sonuc["result"] = 0;
                                    }
                                    Session::set("KID", $id);
                                    Session::set("KRol", $rol);
                                    Session::set("KAdSoyad", $ad);
                                    Session::set("KEposta", $eposta);
                                    //kurumsal veriler
                                    Session::set("KurVergiNo", $kurVNo);
                                    Session::set("KurVerDaire", $kurVDaire);
                                    Session::set("KurFAdres", $adres);
                                    $sonuc["result"] = 1;
                                } else {
                                    $sonuc["hata"] = "Kullanıcı Bilgilerinizi Kontrol Ediniz!";
                                }
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                        }
                    }
                    break;
                case "sifreHatirlat":
                    $form->post("email", true);
                    $form->post("randomsayi", true);
                    $email = $form->values['email'];
                    $randomsayi = $form->values['randomsayi'];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                        $kullaniciliste = $Panel_Model->emailDbKontrol($email);
                        if (count($kullaniciliste) > 0) {
                            if ($randomsayi != '') {
                                if ($randomsayi == Session::get("guvenlikKod")) {
                                    foreach ($kullaniciliste as $kullanicilistee) {
                                        $id = $kullanicilistee['kullanici_id'];
                                        $ad = $kullanicilistee['kullanici_adSoyad'];
                                        $sifre = $kullanicilistee['kullanici_realsifre'];
                                    }
                                    $resultMail = $form->sHatirlatMailGonder($email, $ad, $sifre);
                                    if ($resultMail == 1) {
                                        $sonuc["result"] = "Mailiniz gönderilmiştir. Lütfen $email adresini kontrol ediniz";
                                    } else {
                                        $sonuc["hata"] = "Bir hata oluştu! Tekrar deneyiniz";
                                    }
                                } else {
                                    $sonuc["hata"] = "Toplama işlemi sonucu yanlış! Tekrar deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen toplama işlemi sonucunu yazınız.";
                            }
                        } else {
                            $sonuc["hata"] = "Bu mail adresi kayıtlı değildir! Tekrar deneyiniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                    }
                    break;
                case "birUye":
                    $form->post("adSoyad", true);
                    $form->post("email", true);
                    $form->post("sifre", true);
                    $form->post("sifreTkrar", true);
                    $form->post("kmpnya", true);
                    $form->post("uyesoz", true);
                    $adSoyad = $form->values['adSoyad'];
                    $email = $form->values['email'];
                    $sifre = $form->values['sifre'];
                    $sifreTkrar = $form->values['sifreTkrar'];
                    $kmpnya = $form->values['kmpnya'];
                    $uyesoz = $form->values['uyesoz'];
                    if ($kmpnya == "true") {
                        $kmpnya = 1;
                    } else {
                        $kmpnya = 0;
                    }
                    if ($adSoyad != '') {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($email);
                            if ($emailValidate == 1) {
                                $kullaniciliste = $Panel_Model->emailDbKontrol($email);
                                if (count($kullaniciliste) > 0) {
                                    if ($sifre != '') {
                                        if ($sifre == $sifreTkrar) {
                                            if ($uyesoz == "true") {
                                                $realSifre = $form->userSifreOlustur($email, $sifre);
                                                if ($form->submit()) {
                                                    $data = array(
                                                        'kullanici_adSoyad' => $adSoyad,
                                                        'kullanici_eposta' => $email,
                                                        'kullanici_sifre' => $realSifre,
                                                        'kullanici_realsifre' => $sifre,
                                                        'kullanici_rol' => 0,
                                                        'kullanici_kampanyamesaj' => $kmpnya
                                                    );
                                                }
                                                $result = $Panel_Model->birUye($data);
                                                if ($result) {
                                                    Session::set("KID", $result);
                                                    Session::set("KRol", 0);
                                                    Session::set("KAdSoyad", $adSoyad);
                                                    Session::set("KEposta", $eposta);
                                                    $sonuc["result"] = 1;
                                                } else {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz!";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Üyelik Sözleşmesini Kabul Ediniz!";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Şifreler Uyuşmuyor.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Şifreyi Unutmayınız.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bu mail daha önce kullanılmış başka bir mail adresi deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Ad ve Soyadınızı Giriniz!";
                    }
                    break;
                case "kurUye":
                    $form->post("adSoyad", true);
                    $form->post("email", true);
                    $form->post("sifre", true);
                    $form->post("sifreTkrar", true);
                    $form->post("kmpnya", true);
                    $form->post("uyesoz", true);
                    $form->post("kurAdi", true);
                    $form->post("kurVDaire", true);
                    $form->post("kurVNo", true);
                    $form->post("kurVTel", true);
                    $form->post("adres", true);
                    $adSoyad = $form->values['adSoyad'];
                    $email = $form->values['email'];
                    $sifre = $form->values['sifre'];
                    $sifreTkrar = $form->values['sifreTkrar'];
                    $kmpnya = $form->values['kmpnya'];
                    $uyesoz = $form->values['uyesoz'];
                    $kurAdi = $form->values['kurAdi'];
                    $kurVDaire = $form->values['kurVDaire'];
                    $kurVNo = $form->values['kurVNo'];
                    $kurVTel = $form->values['kurVTel'];
                    $adres = $form->values['adres'];
                    if ($kmpnya == "true") {
                        $kmpnya = 1;
                    } else {
                        $kmpnya = 0;
                    }
                    if ($adSoyad != '') {
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                            $emailValidate = $form->mailControl1($email);
                            if ($emailValidate == 1) {
                                $kullaniciliste = $Panel_Model->emailDbKontrol($email);
                                if (count($kullaniciliste) > 0) {
                                    if ($sifre != '') {
                                        if ($sifre == $sifreTkrar) {
                                            if ($kurAdi != '') {
                                                if ($kurVDaire != '') {
                                                    if ($kurVNo != '') {
                                                        if ($kurVTel != '') {
                                                            if ($uyesoz == "true") {
                                                                $realSifre = $form->userSifreOlustur($email, $sifre);
                                                                if ($form->submit()) {
                                                                    $data = array(
                                                                        'kullanici_adSoyad' => $adSoyad,
                                                                        'kullanici_eposta' => $email,
                                                                        'kullanici_sifre' => $realSifre,
                                                                        'kullanici_realsifre' => $sifre,
                                                                        'kullanici_kurumadi' => $kurAdi,
                                                                        'kullanici_vergid' => $kurVDaire,
                                                                        'kullanici_vergino' => $kurVNo,
                                                                        'kullanici_kurumtel' => $kurVTel,
                                                                        'kullanici_adres' => $adres,
                                                                        'kullanici_rol' => 2,
                                                                        'kullanici_kampanyamesaj' => $kmpnya
                                                                    );
                                                                }
                                                                $result = $Panel_Model->kurUye($data);
                                                                if ($result) {
                                                                    Session::set("KID", $result);
                                                                    Session::set("KRol", 2);
                                                                    Session::set("KAdSoyad", $adSoyad);
                                                                    Session::set("KEposta", $eposta);
                                                                    //kurumsal veriler
                                                                    Session::set("KurVergiNo", $kurVNo);
                                                                    Session::set("KurVerDaire", $kurVDaire);
                                                                    Session::set("KurFAdres", $adres);
                                                                    $sonuc["result"] = 1;
                                                                } else {
                                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz!";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Üyelik Sözleşmesini Kabul Ediniz!";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Lütfen Kurum Telefon Numarasını Giriniz!";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Lütfen Kurum Vergi Dairesi No Giriniz!";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Lütfen Kurum Vergi Dairesini Giriniz!";
                                                }
                                            } else {
                                                $sonuc["hata"] = "Lütfen Kurum Adını Giriniz!";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Şifreler Uyuşmuyor.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Şifreyi Unutmayınız.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bu mail daha önce kullanılmış başka bir mail adresi deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Ad ve Soyadınızı Giriniz!";
                    }
                    break;
                case "orderekurun":
                    $ekurunID = $_REQUEST['ekurunID'];
                    $ekuruniddizi = implode(',', $ekurunID);
                    if (count($ekurunID) > 0) {
                        Session::set("EkUrunID", $ekuruniddizi);
                    } else {
                        unset($_SESSION['EkUrunID']);
                    }
                    if (Session::get("KID") > 0) {
                        $sonuc["result"] = 1;
                    } else {
                        $sonuc["result"] = 0;
                    }

                    break;
                case "teslimatBilgi":
                    $form->post("gndadsoyad", true);
                    $form->post("gndmail", true);
                    $form->post("gndtel", true);
                    $form->post("gndndnTxt", true);
                    $form->post("gndndnID", true);
                    $form->post("alcadsoyad", true);
                    $form->post("alctel", true);
                    $form->post("alcgityertext", true);
                    $form->post("alcgityerid", true);
                    $form->post("alcadres", true);
                    $form->post("alcadresdetay", true);
                    $form->post("okfis", true);
                    $form->post("okfatura", true);
                    $form->post("ftrunvan", true);
                    $form->post("vd", true);
                    $form->post("vn", true);
                    $form->post("tcno", true);
                    $form->post("ftradres", true);
                    $form->post("kartisim", true);
                    $form->post("kartmesaj", true);
                    $form->post("onaylama", true);
                    $gndadsoyad = $form->values['gndadsoyad'];
                    $gndmail = $form->values['gndmail'];
                    $gndtel = $form->values['gndtel'];
                    $gndndnTxt = $form->values['gndndnTxt'];
                    $gndndnID = $form->values['gndndnID'];
                    $alcadsoyad = $form->values['alcadsoyad'];
                    $alctel = $form->values['alctel'];
                    $alcgityertext = $form->values['alcgityertext'];
                    $alcgityerid = $form->values['alcgityerid'];
                    $alcadres = $form->values['alcadres'];
                    $alcadresdetay = $form->values['alcadresdetay'];
                    $okfis = $form->values['okfis'];
                    $okfatura = $form->values['okfatura'];
                    $ftrunvan = $form->values['ftrunvan'];
                    $vd = $form->values['vd'];
                    $vn = $form->values['vn'];
                    $tcno = $form->values['tcno'];
                    $ftradres = $form->values['ftradres'];
                    $kartisim = $form->values['kartisim'];
                    $kartmesaj = $form->values['kartmesaj'];
                    $onaylama = $form->values['onaylama'];
                    $ekurunID = $_REQUEST['ekurunID'];
                    $ekuruniddizi = implode(',', $ekurunID);
                    $kisiID = Session::get("KID");
                    $ilText = Session::get("SipIl");
                    $ilID = Session::get("SipIlID");
                    $ilceText = Session::get("SipIlce");
                    $ilceID = Session::get("SipIlceID");
                    $semtText = Session::get("SipSemt");
                    $semtID = Session::get("SipSemtID");
                    $mahText = Session::get("SipMah");
                    $mahID = Session::get("SipMahID");
                    $pKodu = Session::get("SipPKodu");
                    $tarih = Session::get("SipTarih");
                    $gun = Session::get("SipGun");
                    $saat = Session::get("SipSaat");
                    if ($gndadsoyad != '') {
                        if ($gndmail != '') {
                            if ($gndtel != '') {
                                if ($alcadsoyad != '') {
                                    if ($alctel != '') {
                                        if ($alcadres != '') {
                                            if ($okfatura == "true") {
                                                if ($ftrunvan != '') {
                                                    if ($vd != '') {
                                                        if ($vn != '') {
                                                            if ($tcno != '') {
                                                                if ($ftradres != '') {
                                                                    if ($onaylama == "true") {
                                                                        if ($form->submit()) {
                                                                            $data = array(
                                                                                'siparis_aliciadsoyad' => $alcadsoyad,
                                                                                'siparis_alicitel' => $alctel,
                                                                                'siparis_aliciadres' => $alcadres,
                                                                                'siparis_aliciadrestarif' => $alcadresdetay,
                                                                                'siparis_gndid' => $gndndnID,
                                                                                'siparis_gndtext' => $gndndnTxt,
                                                                                'siparis_yerid' => $alcgityerid,
                                                                                'siparis_yertext' => $alcgityertext,
                                                                                'siparis_kartisim' => $kartisim,
                                                                                'siparis_kartmesaj' => $kartmesaj,
                                                                                'siparis_isimgorunme' => 0,
                                                                                'siparis_gonderenID' => $kisiID,
                                                                                'siparis_gonderenAdSoyad' => $gndadsoyad,
                                                                                'siparis_gonderenTel' => $gndtel,
                                                                                'siparis_gondereneposta' => $gndmail,
                                                                                'siparis_gonderennotu' => '',
                                                                                'siparis_gonderensms' => 0,
                                                                                'siparis_gonderenepostaalma' => 0,
                                                                                'siparis_gonderensmseposta' => 0,
                                                                                'siparis_faturaunvan' => $ftrunvan,
                                                                                'siparis_faturatc' => $tcno,
                                                                                'siparis_faturaadres' => $ftradres,
                                                                                'siparis_faturavergidaire' => $vd,
                                                                                'siparis_vergino' => $vn,
                                                                                'siparis_sehir' => $ilText,
                                                                                'siparis_sehirID' => $ilID,
                                                                                'siparis_ilce' => $ilceText,
                                                                                'siparis_ilceID' => $ilceID,
                                                                                'siparis_semt' => $semtText,
                                                                                'siparis_semtID' => $semtID,
                                                                                'siparis_mahalle' => $mahText,
                                                                                'siparis_mahalleID' => $mahID,
                                                                                'siparis_postakodu' => $pKodu,
                                                                                'siparis_saat' => $saat,
                                                                                'siparis_gun' => $gun,
                                                                                'siparis_tarih' => $tarih,
                                                                                'siparis_kargofirmaid' => 0,
                                                                                'siparis_kargotakipno' => '',
                                                                                'siparis_kargotarih' => '',
                                                                                'siparis_toplamtutar' => 0,
                                                                                'siparis_adminnotu' => '',
                                                                                'siparis_durum' => 0
                                                                            );
                                                                        }
                                                                        $result = $Panel_Model->sipTeslimat($data);
                                                                        if ($result) {
                                                                            if (count($ekurunID) > 0) {
                                                                                unset($_SESSION['EkUrunID']);
                                                                                Session::set("EkUrunID", $ekuruniddizi);
                                                                                Session::set("SipGeciciUrunID", $result);
                                                                            } else {
                                                                                unset($_SESSION['EkUrunID']);
                                                                            }
                                                                            if (Session::get("KID") > 0) {
                                                                                $sonuc["result"] = 1;
                                                                            } else {
                                                                                $sonuc["result"] = 0;
                                                                            }
                                                                        } else {
                                                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz";
                                                                        }
                                                                    } else {
                                                                        $sonuc["hata"] = "Lütfen Bilgileriniz Onaylayınız!";
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Lütfen Fatura Adresini Giriniz!";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Lütfen Kimlik Numarısını Giriniz!";
                                                            }
                                                        } else {
                                                            $sonuc["hata"] = "Lütfen Vergi Numarısını Giriniz!";
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Lütfen Vergi Dairesini Giriniz!";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Lütfen Vergi Ünvanını Giriniz!";
                                                }
                                            } else {
                                                if ($onaylama == "true") {
                                                    if ($form->submit()) {
                                                        $data = array(
                                                            'siparis_aliciadsoyad' => $alcadsoyad,
                                                            'siparis_alicitel' => $alctel,
                                                            'siparis_aliciadres' => $alcadres,
                                                            'siparis_aliciadrestarif' => $alcadresdetay,
                                                            'siparis_gndid' => $gndndnID,
                                                            'siparis_gndtext' => $gndndnTxt,
                                                            'siparis_yerid' => $alcgityerid,
                                                            'siparis_yertext' => $alcgityertext,
                                                            'siparis_kartisim' => $kartisim,
                                                            'siparis_kartmesaj' => $kartmesaj,
                                                            'siparis_isimgorunme' => 0,
                                                            'siparis_gonderenID' => $kisiID,
                                                            'siparis_gonderenAdSoyad' => $gndadsoyad,
                                                            'siparis_gonderenTel' => $gndtel,
                                                            'siparis_gondereneposta' => $gndmail,
                                                            'siparis_gonderennotu' => '',
                                                            'siparis_gonderensms' => 0,
                                                            'siparis_gonderenepostaalma' => 0,
                                                            'siparis_gonderensmseposta' => 0,
                                                            'siparis_faturaunvan' => '',
                                                            'siparis_faturatc' => '',
                                                            'siparis_faturaadres' => '',
                                                            'siparis_faturavergidaire' => '',
                                                            'siparis_vergino' => '',
                                                            'siparis_sehir' => $ilText,
                                                            'siparis_sehirID' => $ilID,
                                                            'siparis_ilce' => $ilceText,
                                                            'siparis_ilceID' => $ilceID,
                                                            'siparis_semt' => $semtText,
                                                            'siparis_semtID' => $semtID,
                                                            'siparis_mahalle' => $mahText,
                                                            'siparis_mahalleID' => $mahID,
                                                            'siparis_postakodu' => $pKodu,
                                                            'siparis_saat' => $saat,
                                                            'siparis_gun' => $gun,
                                                            'siparis_tarih' => $tarih,
                                                            'siparis_kargofirmaid' => 0,
                                                            'siparis_kargotakipno' => '',
                                                            'siparis_kargotarih' => '',
                                                            'siparis_toplamtutar' => 0,
                                                            'siparis_adminnotu' => '',
                                                            'siparis_durum' => 0
                                                        );
                                                    }

                                                    $result = $Panel_Model->sipTeslimat($data);
                                                    if ($result) {
                                                        if (count($ekurunID) > 0) {
                                                            Session::set("EkUrunID", $ekuruniddizi);
                                                            Session::set("SipGeciciUrunID", $result);
                                                        } else {
                                                            unset($_SESSION['EkUrunID']);
                                                        }
                                                        if (Session::get("KID") > 0) {
                                                            $sonuc["result"] = 1;
                                                        } else {
                                                            $sonuc["result"] = 0;
                                                        }
                                                    } else {
                                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Lütfen Bilgileriniz Onaylayınız!";
                                                }
                                            }
                                        } else {
                                            $sonuc["hata"] = "Lütfen Alıcı Adresini Giriniz!";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Alıcı Telefon Numarısını Giriniz!";
                                    }
                                } else {
                                    $sonuc["hata"] = "Lütfen Alıcı Ad Soyadını Giriniz!";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen Gönderici Telefon Numarasını Giriniz!";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Gönderici Mailini Giriniz!";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Gönderici Ad Soyadını Giriniz!";
                    }
                    break;
                case "cikisYap":
                    unset($_SESSION['KID']);
                    unset($_SESSION['KRol']);
                    unset($_SESSION['KAdSoyad']);
                    unset($_SESSION['KEposta']);
                    unset($_SESSION['KurVergiNo']);
                    unset($_SESSION['KurVerDaire']);
                    unset($_SESSION['KurFAdres']);
                    unset($_SESSION['Class']);
                    unset($_SESSION['Kategori']);
                    unset($_SESSION['ID']);
                    unset($_SESSION['Method']);
                    Session::destroy();
                    $sonuc["result"] = 1;
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

