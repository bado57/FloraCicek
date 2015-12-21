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
                    $newTarih = $tarih[0] . "/" . $tarih[1] . "/" . $tarih[2];
                    $gun = date('D', strtotime("$tarih[1]/$tarih[0]/$tarih[2]"));
                    $simdikiGun = $form->gunogrenme("$gun");
                    if ($urunID > 0) {
                        if ($ilID > 0) {
                            if ($ilceID > 0) {
                                if ($tarihim != '') {
                                    if ($saatText != '') {
                                        date_default_timezone_set('Europe/Istanbul');
                                        $nowtarihim = date('d/m/Y');
                                        if ($nowtarihim == $tarihim) {
                                            $explSaat = explode(" - ", $saatText);
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
                                if (count($kullaniciliste) <= 0) {
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
                                if (count($kullaniciliste) <= 0) {
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
                    $form->post("siparisnotu", true);
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
                    $siparisnotu = $form->values['siparisnotu'];
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
                    $tarih = Session::get("SipTarih");
                    $gun = Session::get("SipGun");
                    $saat = Session::get("SipSaat");
                    if ($gndadsoyad != '') {
                        if ($gndmail != '') {
                            if (!filter_var($gndmail, FILTER_VALIDATE_EMAIL) === false) {
                                $emailValidate = 1;
                                //$emailValidate = $form->mailControl1($gndmail);
                                if ($emailValidate == 1) {
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
                                                                                //ürün kodu oluşturulmakta
                                                                                $benzersizSayi = $form->benzersiz_Sayi(6);
                                                                                $benzersizListe = $Panel_Model->siparisBenzersizKontrol($benzersizSayi);
                                                                                foreach ($benzersizListe as $benzersizListee) {
                                                                                    $benzersiz['ID'] = $benzersizListee['siparis_ID'];
                                                                                }
                                                                                if ($benzersiz['ID'] > 0) {
                                                                                    $sonuc["hata"] = "Siparis Kodu Oluşturulamadı Tekrar Deneyiniz.";
                                                                                } else {
                                                                                    if ($kartisim != "") {
                                                                                        $siparisIsimGorunme = 1;
                                                                                    } else {
                                                                                        $siparisIsimGorunme = 0;
                                                                                    }
                                                                                    if ($form->submit()) {
                                                                                        $data = array(
                                                                                            'siparis_No' => $benzersizSayi,
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
                                                                                            'siparis_isimgorunme' => $siparisIsimGorunme,
                                                                                            'siparis_gonderenID' => $kisiID,
                                                                                            'siparis_gonderenkur' => Session::get("KRol"),
                                                                                            'siparis_gonderenAdSoyad' => $gndadsoyad,
                                                                                            'siparis_gonderenTel' => $gndtel,
                                                                                            'siparis_gondereneposta' => $gndmail,
                                                                                            'siparis_gonderennotu' => $siparisnotu,
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
                                                                                            //geçici-sipariş id si
                                                                                            unset($_SESSION['SipGeciciUrunID']);
                                                                                            Session::set("SipGeciciUrunID", $result);
                                                                                        } else {
                                                                                            unset($_SESSION['EkUrunID']);
                                                                                        }
                                                                                        if (Session::get("KID") > 0) {
                                                                                            Session::set("Odeme", 1);
                                                                                            unset($_SESSION['SipKodu']);
                                                                                            Session::set("SipKodu", $benzersizSayi);
                                                                                            //mesafeli satış sözleşmesi için
                                                                                            Session::set("AliciAdSoyad", $gndadsoyad);
                                                                                            Session::set("AliciPhone", $gndtel);
                                                                                            Session::set("AliciMail", $gndmail);
                                                                                            $sonuc["result"] = 1;
                                                                                        } else {
                                                                                            Session::set("Odeme", 1);
                                                                                            unset($_SESSION['SipKodu']);
                                                                                            Session::set("SipKodu", $benzersizSayi);
                                                                                            //mesafeli satış sözleşmesi için
                                                                                            Session::set("AliciAdSoyad", $gndadsoyad);
                                                                                            Session::set("AliciPhone", $gndtel);
                                                                                            Session::set("AliciMail", $gndmail);
                                                                                            $sonuc["result"] = 1;
                                                                                        }
                                                                                    } else {
                                                                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz";
                                                                                    }
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
                                                        //ürün kodu oluşturulmakta
                                                        $benzersizSayi = $form->benzersiz_Sayi(6);
                                                        $benzersizListe = $Panel_Model->siparisBenzersizKontrol($benzersizSayi);
                                                        foreach ($benzersizListe as $benzersizListee) {
                                                            $benzersiz['ID'] = $benzersizListee['siparis_ID'];
                                                        }
                                                        if ($benzersiz['ID'] > 0) {
                                                            $sonuc["hata"] = "Siparis Kodu Oluşturulamadı Tekrar Deneyiniz.";
                                                        } else {
                                                            if ($onaylama == "true") {
                                                                if ($kartisim != "") {
                                                                    $siparisIsimGorunme = 1;
                                                                } else {
                                                                    $siparisIsimGorunme = 0;
                                                                }
                                                                if ($form->submit()) {
                                                                    $data = array(
                                                                        'siparis_No' => $benzersizSayi,
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
                                                                        'siparis_isimgorunme' => $siparisIsimGorunme,
                                                                        'siparis_gonderenID' => $kisiID,
                                                                        'siparis_gonderenkur' => Session::get("KRol"),
                                                                        'siparis_gonderenAdSoyad' => $gndadsoyad,
                                                                        'siparis_gonderenTel' => $gndtel,
                                                                        'siparis_gondereneposta' => $gndmail,
                                                                        'siparis_gonderennotu' => $siparisnotu,
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
                                                                        //geçici-sipariş id si
                                                                        unset($_SESSION['SipGeciciUrunID']);
                                                                        Session::set("SipGeciciUrunID", $result);
                                                                    } else {
                                                                        unset($_SESSION['EkUrunID']);
                                                                    }
                                                                    if (Session::get("KID") > 0) {
                                                                        Session::set("Odeme", 1);
                                                                        unset($_SESSION['SipKodu']);
                                                                        Session::set("SipKodu", $benzersizSayi);
                                                                        //mesafeli satış sözleşmesi için
                                                                        Session::set("AliciAdSoyad", $gndadsoyad);
                                                                        Session::set("AliciPhone", $gndtel);
                                                                        Session::set("AliciMail", $gndmail);
                                                                        $sonuc["result"] = 1;
                                                                    } else {
                                                                        Session::set("Odeme", 1);
                                                                        unset($_SESSION['SipKodu']);
                                                                        Session::set("SipKodu", $benzersizSayi);
                                                                        //mesafeli satış sözleşmesi için
                                                                        Session::set("AliciAdSoyad", $gndadsoyad);
                                                                        Session::set("AliciPhone", $gndtel);
                                                                        Session::set("AliciMail", $gndmail);
                                                                        $sonuc["result"] = 1;
                                                                    }
                                                                } else {
                                                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz";
                                                                }
                                                            } else {
                                                                $sonuc["hata"] = "Lütfen Bilgileriniz Onaylayınız!";
                                                            }
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
                                    $sonuc["hata"] = "Mailiniz kullanımda değildir. Lütfen başka bir mail deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen geçerli bir email adresi giriniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Gönderici Mailini Giriniz!";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Gönderici Ad Soyadını Giriniz!";
                    }
                    break;
                case "havaleSiparis":
                    $form->post("hss", true);
                    $form->post("bankaVal", true);
                    $hss = $form->values['hss'];
                    $bankaVal = $form->values['bankaVal'];
                    if ($bankaVal != 0) {
                        if ($hss == "true") {
                            $urunid = Session::get("SipID");
                            //ürünlerin toplam fiyatı için
                            $urunToplamFiyat = 0;
                            //ilçe fiyatını ekliyorum
                            $urunToplamFiyat = $urunToplamFiyat + Session::get("SipIlceFiyat");
                            $urunAdet = 0;
                            //Ürün Detayı
                            $urunListe = $Panel_Model->urundetaysiparis($urunid);

                            //kampanyalı ürünlerin listesi
                            foreach ($urunListe as $urunListee) {
                                if ($urunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $kampanyaId = $urunListee['urun_kmpnyaid'];
                                }
                            }

                            //kampanyalı ürünler için 
                            if (count($kampanyaId) > 0) {
                                $kampanya = $Panel_Model->urunkampanya($kampanyaId, date("Y/m/d"));
                                foreach ($kampanya as $kampanyaa) {
                                    $urunkampanya[0]['ID'] = $kampanyaa['kampanya_ID'];
                                    $urunkampanya[0]['Yuzde'] = $kampanyaa['kampanya_indirimyuzde'];
                                }
                            }
                            if (count($urunkampanya) > 0) {
                                foreach ($urunListe as $urunListee) {
                                    $siparislist[0][0]['KID'] = $urunkampanya[0]['ID'];
                                    $siparislist[0][0]['urunID'] = $urunListee['urun_ID'];
                                    $siparislist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                                    $siparislist[0][0]['urunFiyat'] = round($urunListee['urun_fiyat'] - (($urunListee['urun_fiyat'] * $urunkampanya[0]['Yuzde']) / 100));
                                    $urunToplamFiyat = $urunToplamFiyat + $siparislist[0][0]['urunFiyat'];
                                    $urunAdet++;
                                    $siparislist[0][0]['urunAd'] = $urunListee['urun_adi'];
                                    $siparislist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                                }
                            } else {
                                foreach ($urunListe as $urunListee) {
                                    $siparislist[0][0]['urunID'] = $urunListee['urun_ID'];
                                    $siparislist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                                    $siparislist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                                    $urunToplamFiyat = $urunToplamFiyat + $siparislist[0][0]['urunFiyat'];
                                    $urunAdet++;
                                    $siparislist[0][0]['urunAd'] = $urunListee['urun_adi'];
                                    $siparislist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                                }
                            }

                            //Ek Ürünler varsa Onun Dizisi
                            $ekUrunDizi = Session::get("EkUrunID");
                            if (count($ekUrunDizi) > 0) {
                                //ek ürünleri listeleme
                                $ekurunListe = $Panel_Model->ekurunbazilistele($ekUrunDizi);
                                //kampanyalı ürünlerin listesi
                                foreach ($ekurunListe as $ekurunListee) {
                                    if ($ekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        $ekkampanyaId[] = $ekurunListee['urun_kmpnyaid'];
                                    }
                                }
                                //kampanyalı ürünler için 
                                if (count($ekkampanyaId) > 0) {
                                    $kampanyadizi = implode(',', $ekkampanyaId);
                                    $ekkampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                    $kmpny = 0;
                                    foreach ($ekkampanyalar as $ekkampanyalarr) {
                                        $ekurunkampanya[$kmpny]['ID'] = $ekkampanyalarr['kampanya_ID'];
                                        $ekurunkampanya[$kmpny]['Yuzde'] = $ekkampanyalarr['kampanya_indirimyuzde'];
                                        $kmpny++;
                                    }
                                }

                                $uek = 0;
                                foreach ($ekurunListe as $ekurunListee) {
                                    if ($ekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                        for ($ku = 0; $ku < count($ekurunkampanya); $ku++) {
                                            if ($ekurunkampanya[$ku]['ID'] == $ekurunListee['urun_kmpnyaid']) {
                                                $siparislist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                                $siparislist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                                $siparislist[1][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                                                $urunToplamFiyat = $urunToplamFiyat + $siparislist[1][$uek]['EkFiyat'];
                                                $urunAdet++;
                                                $siparislist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                                $siparislist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                            }
                                        }
                                    } else {
                                        $siparislist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                        $siparislist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                        $siparislist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                                        $urunToplamFiyat = $urunToplamFiyat + $siparislist[1][$uek]['EkFiyat'];
                                        $urunAdet++;
                                        $siparislist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                        $siparislist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                    }
                                    $uek++;
                                }
                            }
                            $sipID = Session::get("SipGeciciUrunID");
                            $siparisliste = $Panel_Model->geciciSiparis($sipID);
                            if (count($siparisliste) > 0) {
                                $data = array(
                                    'siparis_No' => $siparisliste[0]["siparis_No"],
                                    'siparis_aliciadsoyad' => $siparisliste[0]["siparis_aliciadsoyad"],
                                    'siparis_alicitel' => $siparisliste[0]["siparis_alicitel"],
                                    'siparis_aliciadres' => $siparisliste[0]["siparis_aliciadres"],
                                    'siparis_aliciadrestarif' => $siparisliste[0]["siparis_aliciadrestarif"],
                                    'siparis_gndid' => $siparisliste[0]["siparis_gndid"],
                                    'siparis_gndtext' => $siparisliste[0]["siparis_gndtext"],
                                    'siparis_yerid' => $siparisliste[0]["siparis_yerid"],
                                    'siparis_yertext' => $siparisliste[0]["siparis_yertext"],
                                    'siparis_kartisim' => $siparisliste[0]["siparis_kartisim"],
                                    'siparis_kartmesaj' => $siparisliste[0]["siparis_kartmesaj"],
                                    'siparis_isimgorunme' => $siparisliste[0]["siparis_isimgorunme"],
                                    'siparis_gonderenID' => $siparisliste[0]["siparis_gonderenID"],
                                    'siparis_gonderenkur' => $siparisliste[0]["siparis_gonderenkur"],
                                    'siparis_gonderenAdSoyad' => $siparisliste[0]["siparis_gonderenAdSoyad"],
                                    'siparis_gonderenTel' => $siparisliste[0]["siparis_gonderenTel"],
                                    'siparis_gondereneposta' => $siparisliste[0]["siparis_gondereneposta"],
                                    'siparis_gonderennotu' => $siparisliste[0]["siparis_gonderennotu"],
                                    'siparis_gonderensms' => $siparisliste[0]["siparis_gonderensms"],
                                    'siparis_gonderenepostaalma' => $siparisliste[0]["siparis_gonderenepostaalma"],
                                    'siparis_gonderensmseposta' => $siparisliste[0]["siparis_gonderensmseposta"],
                                    'siparis_faturaunvan' => $siparisliste[0]["siparis_faturaunvan"],
                                    'siparis_faturatc' => $siparisliste[0]["siparis_faturatc"],
                                    'siparis_faturaadres' => $siparisliste[0]["siparis_faturaadres"],
                                    'siparis_faturavergidaire' => $siparisliste[0]["siparis_faturavergidaire"],
                                    'siparis_vergino' => $siparisliste[0]["siparis_vergino"],
                                    'siparis_sehir' => $siparisliste[0]["siparis_sehir"],
                                    'siparis_sehirID' => $siparisliste[0]["siparis_sehirID"],
                                    'siparis_ilce' => $siparisliste[0]["siparis_ilce"],
                                    'siparis_ilceID' => $siparisliste[0]["siparis_ilceID"],
                                    'siparis_saat' => $siparisliste[0]["siparis_saat"],
                                    'siparis_gun' => $siparisliste[0]["siparis_gun"],
                                    'siparis_tarih' => $siparisliste[0]["siparis_tarih"],
                                    'siparis_kargofirmaid' => $siparisliste[0]["siparis_kargofirmaid"],
                                    'siparis_kargotakipno' => $siparisliste[0]["siparis_kargotakipno"],
                                    'siparis_kargotarih' => $siparisliste[0]["siparis_kargotarih"],
                                    'siparis_toplamtutar' => $urunToplamFiyat,
                                    'siparis_odemetip' => 1, //havale ile ödeme
                                    'siparis_bankaID' => $bankaVal, //banka ID
                                    'siparis_adminnotu' => $siparisliste[0]["siparis_adminnotu"],
                                    'siparis_durum' => $siparisliste[0]["siparis_durum"]
                                );

                                $result = $Panel_Model->sipRealInsert($data);
                                if ($result) {
                                    //ana ürünü ekliyorum
                                    if (count($siparislist[0]) > 0) {
                                        $dataAnaUrun = array(
                                            'siparisurun_siparisID' => $result,
                                            'siparisurun_urunID' => $siparislist[0][0]['urunID'],
                                            'siparisurun_ad' => $siparislist[0][0]['urunAd'],
                                            'siparisurun_kod' => $siparislist[0][0]['urunKod'],
                                            'siparisurun_miktar' => 1,
                                            'siparisurun_tutar' => $siparislist[0][0]['urunFiyat'],
                                            'siparisurun_tip' => 0,
                                            'siparisurun_resim' => $siparislist[0][0]['urunResim']
                                        );
                                        $resultAnaUrun = $Panel_Model->sipAnaUrunInsert($dataAnaUrun);
                                        if ($resultAnaUrun) {
                                            //ek ürün varsa ekliyorum
                                            $ekurunlerCount = count($siparislist[1]);
                                            if ($ekurunlerCount > 0) {
                                                for ($ekk = 0; $ekk < $ekurunlerCount; $ekk++) {
                                                    $ekurundata[$ekk] = array(
                                                        'siparisurun_siparisID' => $result,
                                                        'siparisurun_urunID' => $siparislist[1][$ekk]['EkID'],
                                                        'siparisurun_ad' => $siparislist[1][$ekk]['EkAdi'],
                                                        'siparisurun_kod' => $siparislist[1][$ekk]['EkKod'],
                                                        'siparisurun_miktar' => 1,
                                                        'siparisurun_tutar' => $siparislist[1][$ekk]['EkFiyat'],
                                                        'siparisurun_tip' => 1,
                                                        'siparisurun_resim' => $siparislist[1][$ekk]['EkResim']
                                                    );
                                                }
                                                $resultEkUrun = $Panel_Model->sipEkUrunInsert($ekurundata);
                                                //siparisin havale ile olduğunu gösterir
                                                Session::set("SipTechOnay", 2);
                                                Session::set("SipTTutar", $urunToplamFiyat);
                                                //mail gönderiliyor
                                                $mailBodyKullanici = 'Merhaba ' . $isim . '!<br/> Siparişiniz tamamlanmıştır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile sitemizdeki siparis arama kısmından '
                                                        . 'takip edebilirsiniz. İyi günler dileriz.<br/><br/>'
                                                        . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                        . '<br/><br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>';
                                                $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyKullanici);
                                                $mailBodyAdmin = 'Yeni Bir siparişiniz vardır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile takip edebilirsiniz. '
                                                        . 'İyi günler dileriz.<br/><br/>'
                                                        . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                        . '<br/><br/><a href="https://www.turkiyefloracicek.com/Admin/Panel">Türkiye Flora Çiçek</a>';
                                                $resultMaill = $form->sSiparisMailGonder("info@turkiyefloracicek.com", "Yeni Sipariş-Gönderen" . $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyAdmin);
                                                $sonuc["result"] = 1;
                                            } else {
                                                //siparisin havale ile olduğunu gösterir
                                                Session::set("SipTechOnay", 2);
                                                Session::set("SipTTutar", $urunToplamFiyat);
                                                //mail gönderiliyor
                                                $mailBodyKullanici = 'Merhaba ' . $isim . '!<br/> Siparişiniz tamamlanmıştır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile sitemizdeki siparis arama kısmından '
                                                        . 'takip edebilirsiniz. İyi günler dileriz.<br/><br/>'
                                                        . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                        . '<br/><br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>';
                                                $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyKullanici);
                                                $mailBodyAdmin = 'Yeni Bir siparişiniz vardır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile takip edebilirsiniz. '
                                                        . 'İyi günler dileriz.<br/><br/>'
                                                        . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                        . '<br/><br/><a href="https://www.turkiyefloracicek.com/Admin/Panel">Türkiye Flora Çiçek</a>';
                                                $resultMaill = $form->sSiparisMailGonder("info@turkiyefloracicek.com", "Yeni Sipariş-Gönderen" . $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyAdmin);
                                                $sonuc["result"] = 1;
                                            }
                                        } else {
                                            //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                            $deletesiparis = $Panel_Model->siparisDelete($result);
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                        $deletesiparis = $Panel_Model->siparisDelete($result);
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Mesafeli Satış Sözleşmesini Okuyup, Onaylayınız.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Banka Seçiniz.";
                    }
                    break;
                case "telefonSiparis":
                    $form->post("tss", true);
                    $tss = $form->values['tss'];
                    if ($tss == "true") {
                        $urunid = Session::get("SipID");
                        //ürünlerin toplam fiyatı için
                        $urunToplamFiyat = 0;
                        //ilçe fiyatını ekliyorum
                        $urunToplamFiyat = $urunToplamFiyat + Session::get("SipIlceFiyat");
                        //Ürün Detayı
                        $urunListe = $Panel_Model->urundetaysiparis($urunid);

                        //kampanyalı ürünlerin listesi
                        foreach ($urunListe as $urunListee) {
                            if ($urunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                $kampanyaId = $urunListee['urun_kmpnyaid'];
                            }
                        }

                        //kampanyalı ürünler için 
                        if (count($kampanyaId) > 0) {
                            $kampanya = $Panel_Model->urunkampanya($kampanyaId, date("Y/m/d"));
                            foreach ($kampanya as $kampanyaa) {
                                $urunkampanya[0]['ID'] = $kampanyaa['kampanya_ID'];
                                $urunkampanya[0]['Yuzde'] = $kampanyaa['kampanya_indirimyuzde'];
                            }
                        }
                        if (count($urunkampanya) > 0) {
                            foreach ($urunListe as $urunListee) {
                                $siparislist[0][0]['KID'] = $urunkampanya[0]['ID'];
                                $siparislist[0][0]['urunID'] = $urunListee['urun_ID'];
                                $siparislist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                                $siparislist[0][0]['urunFiyat'] = round($urunListee['urun_fiyat'] - (($urunListee['urun_fiyat'] * $urunkampanya[0]['Yuzde']) / 100));
                                $urunToplamFiyat = $urunToplamFiyat + $siparislist[0][0]['urunFiyat'];
                                $siparislist[0][0]['urunAd'] = $urunListee['urun_adi'];
                                $siparislist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                            }
                        } else {
                            foreach ($urunListe as $urunListee) {
                                $siparislist[0][0]['urunID'] = $urunListee['urun_ID'];
                                $siparislist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                                $siparislist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                                $urunToplamFiyat = $urunToplamFiyat + $siparislist[0][0]['urunFiyat'];
                                $siparislist[0][0]['urunAd'] = $urunListee['urun_adi'];
                                $siparislist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                            }
                        }

                        //Ek Ürünler varsa Onun Dizisi
                        $ekUrunDizi = Session::get("EkUrunID");
                        if (count($ekUrunDizi) > 0) {
                            //ek ürünleri listeleme
                            $ekurunListe = $Panel_Model->ekurunbazilistele($ekUrunDizi);
                            //kampanyalı ürünlerin listesi
                            foreach ($ekurunListe as $ekurunListee) {
                                if ($ekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    $ekkampanyaId[] = $ekurunListee['urun_kmpnyaid'];
                                }
                            }
                            //kampanyalı ürünler için 
                            if (count($ekkampanyaId) > 0) {
                                $kampanyadizi = implode(',', $ekkampanyaId);
                                $ekkampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
                                $kmpny = 0;
                                foreach ($ekkampanyalar as $ekkampanyalarr) {
                                    $ekurunkampanya[$kmpny]['ID'] = $ekkampanyalarr['kampanya_ID'];
                                    $ekurunkampanya[$kmpny]['Yuzde'] = $ekkampanyalarr['kampanya_indirimyuzde'];
                                    $kmpny++;
                                }
                            }

                            $uek = 0;
                            foreach ($ekurunListe as $ekurunListee) {
                                if ($ekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                                    for ($ku = 0; $ku < count($ekurunkampanya); $ku++) {
                                        if ($ekurunkampanya[$ku]['ID'] == $ekurunListee['urun_kmpnyaid']) {
                                            $siparislist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                            $siparislist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                            $siparislist[1][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                                            $urunToplamFiyat = $urunToplamFiyat + $siparislist[1][$uek]['EkFiyat'];
                                            $siparislist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                            $siparislist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                        }
                                    }
                                } else {
                                    $siparislist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                    $siparislist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                    $siparislist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                                    $urunToplamFiyat = $urunToplamFiyat + $siparislist[1][$uek]['EkFiyat'];
                                    $siparislist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                    $siparislist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                }
                                $uek++;
                            }
                        }
                        $sipID = Session::get("SipGeciciUrunID");
                        $siparisliste = $Panel_Model->geciciSiparis($sipID);
                        if (count($siparisliste) > 0) {
                            $data = array(
                                'siparis_No' => $siparisliste[0]["siparis_No"],
                                'siparis_aliciadsoyad' => $siparisliste[0]["siparis_aliciadsoyad"],
                                'siparis_alicitel' => $siparisliste[0]["siparis_alicitel"],
                                'siparis_aliciadres' => $siparisliste[0]["siparis_aliciadres"],
                                'siparis_aliciadrestarif' => $siparisliste[0]["siparis_aliciadrestarif"],
                                'siparis_gndid' => $siparisliste[0]["siparis_gndid"],
                                'siparis_gndtext' => $siparisliste[0]["siparis_gndtext"],
                                'siparis_yerid' => $siparisliste[0]["siparis_yerid"],
                                'siparis_yertext' => $siparisliste[0]["siparis_yertext"],
                                'siparis_kartisim' => $siparisliste[0]["siparis_kartisim"],
                                'siparis_kartmesaj' => $siparisliste[0]["siparis_kartmesaj"],
                                'siparis_isimgorunme' => $siparisliste[0]["siparis_isimgorunme"],
                                'siparis_gonderenID' => $siparisliste[0]["siparis_gonderenID"],
                                'siparis_gonderenkur' => $siparisliste[0]["siparis_gonderenkur"],
                                'siparis_gonderenAdSoyad' => $siparisliste[0]["siparis_gonderenAdSoyad"],
                                'siparis_gonderenTel' => $siparisliste[0]["siparis_gonderenTel"],
                                'siparis_gondereneposta' => $siparisliste[0]["siparis_gondereneposta"],
                                'siparis_gonderennotu' => $siparisliste[0]["siparis_gonderennotu"],
                                'siparis_gonderensms' => $siparisliste[0]["siparis_gonderensms"],
                                'siparis_gonderenepostaalma' => $siparisliste[0]["siparis_gonderenepostaalma"],
                                'siparis_gonderensmseposta' => $siparisliste[0]["siparis_gonderensmseposta"],
                                'siparis_faturaunvan' => $siparisliste[0]["siparis_faturaunvan"],
                                'siparis_faturatc' => $siparisliste[0]["siparis_faturatc"],
                                'siparis_faturaadres' => $siparisliste[0]["siparis_faturaadres"],
                                'siparis_faturavergidaire' => $siparisliste[0]["siparis_faturavergidaire"],
                                'siparis_vergino' => $siparisliste[0]["siparis_vergino"],
                                'siparis_sehir' => $siparisliste[0]["siparis_sehir"],
                                'siparis_sehirID' => $siparisliste[0]["siparis_sehirID"],
                                'siparis_ilce' => $siparisliste[0]["siparis_ilce"],
                                'siparis_ilceID' => $siparisliste[0]["siparis_ilceID"],
                                'siparis_saat' => $siparisliste[0]["siparis_saat"],
                                'siparis_gun' => $siparisliste[0]["siparis_gun"],
                                'siparis_tarih' => $siparisliste[0]["siparis_tarih"],
                                'siparis_kargofirmaid' => $siparisliste[0]["siparis_kargofirmaid"],
                                'siparis_kargotakipno' => $siparisliste[0]["siparis_kargotakipno"],
                                'siparis_kargotarih' => $siparisliste[0]["siparis_kargotarih"],
                                'siparis_toplamtutar' => $urunToplamFiyat,
                                'siparis_odemetip' => 2, //telefon ile ödeme
                                'siparis_bankaID' => 0, //banka ID
                                'siparis_adminnotu' => $siparisliste[0]["siparis_adminnotu"],
                                'siparis_durum' => $siparisliste[0]["siparis_durum"]
                            );

                            $result = $Panel_Model->sipRealInsert($data);
                            if ($result) {
                                //ana ürünü ekliyorum
                                if (count($siparislist[0]) > 0) {
                                    $dataAnaUrun = array(
                                        'siparisurun_siparisID' => $result,
                                        'siparisurun_urunID' => $siparislist[0][0]['urunID'],
                                        'siparisurun_ad' => $siparislist[0][0]['urunAd'],
                                        'siparisurun_kod' => $siparislist[0][0]['urunKod'],
                                        'siparisurun_miktar' => 1,
                                        'siparisurun_tutar' => $siparislist[0][0]['urunFiyat'],
                                        'siparisurun_tip' => 0,
                                        'siparisurun_resim' => $siparislist[0][0]['urunResim']
                                    );
                                    $resultAnaUrun = $Panel_Model->sipAnaUrunInsert($dataAnaUrun);
                                    if ($resultAnaUrun) {
                                        //ek ürün varsa ekliyorum
                                        $ekurunlerCount = count($siparislist[1]);
                                        if ($ekurunlerCount > 0) {
                                            for ($ekk = 0; $ekk < $ekurunlerCount; $ekk++) {
                                                $ekurundata[$ekk] = array(
                                                    'siparisurun_siparisID' => $result,
                                                    'siparisurun_urunID' => $siparislist[1][$ekk]['EkID'],
                                                    'siparisurun_ad' => $siparislist[1][$ekk]['EkAdi'],
                                                    'siparisurun_kod' => $siparislist[1][$ekk]['EkKod'],
                                                    'siparisurun_miktar' => 1,
                                                    'siparisurun_tutar' => $siparislist[1][$ekk]['EkFiyat'],
                                                    'siparisurun_tip' => 1,
                                                    'siparisurun_resim' => $siparislist[1][$ekk]['EkResim']
                                                );
                                            }
                                            $resultEkUrun = $Panel_Model->sipEkUrunInsert($ekurundata);
                                            //siparisin telefonla olduğunu gösterir
                                            Session::set("SipTechOnay", 3);
                                            Session::set("SipTTutar", $urunToplamFiyat);
                                            //mail gönderiliyor
                                            $mailBodyKullanici = 'Merhaba ' . $isim . '!<br/> Siparişiniz tamamlanmıştır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile sitemizdeki siparis arama kısmından '
                                                    . 'takip edebilirsiniz. İyi günler dileriz.<br/><br/>'
                                                    . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                    . '<br/><br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>';
                                            $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyKullanici);
                                            $mailBodyAdmin = 'Yeni Bir siparişiniz vardır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile takip edebilirsiniz. '
                                                    . 'İyi günler dileriz.<br/><br/>'
                                                    . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                    . '<br/><br/><a href="https://www.turkiyefloracicek.com/Admin/Panel">Türkiye Flora Çiçek</a>';
                                            $resultMaill = $form->sSiparisMailGonder("info@turkiyefloracicek.com", "Yeni Sipariş-Gönderen" . $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyAdmin);
                                            $sonuc["result"] = 1;
                                        } else {
                                            //siparisin telefonla olduğunu gösterir
                                            Session::set("SipTechOnay", 3);
                                            Session::set("SipTTutar", $urunToplamFiyat);
                                            //mail gönderiliyor
                                            $mailBodyKullanici = 'Merhaba ' . $isim . '!<br/> Siparişiniz tamamlanmıştır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile sitemizdeki siparis arama kısmından '
                                                    . 'takip edebilirsiniz. İyi günler dileriz.<br/><br/>'
                                                    . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                    . '<br/><br/><a href="https://www.turkiyefloracicek.com">Türkiye Flora Çiçek</a>';
                                            $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyKullanici);
                                            $mailBodyAdmin = 'Yeni Bir siparişiniz vardır.Siparişiniz ile ilgili durumları aşağıdaki sipariş kodunuz ile takip edebilirsiniz. '
                                                    . 'İyi günler dileriz.<br/><br/>'
                                                    . 'Sipariş Kodunuz=' . $sipKod . ' Geri dönmek için aşağıdaki linke tıklayınız.'
                                                    . '<br/><br/><a href="https://www.turkiyefloracicek.com/Admin/Panel">Türkiye Flora Çiçek</a>';
                                            $resultMaill = $form->sSiparisMailGonder("info@turkiyefloracicek.com", "Yeni Sipariş-Gönderen" . $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"], $mailBodyAdmin);
                                            $sonuc["result"] = 1;
                                        }
                                    } else {
                                        //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                        $deletesiparis = $Panel_Model->siparisDelete($result);
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
                                    //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                    $deletesiparis = $Panel_Model->siparisDelete($result);
                                    $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Mesafeli Satış Sözleşmesini Okuyup, Onaylayınız.";
                    }
                    break;
                case "siparisDuzenlemeDegerler":
                    $form->post("sipKod", true);
                    $form->post("sipMail", true);
                    $sipKod = $form->values['sipKod'];
                    $sipMail = $form->values['sipMail'];
                    if (Session::get("KID") > 0) {
                        $sipMail = Session::get("KEposta");
                        if ($sipKod != "") {
                            $siparis = array();
                            $sip = $Panel_Model->siparisFrontDetaylistele($sipKod, $sipMail);
                            foreach ($sip as $sipp) {
                                $siplist['ID'] = $sipp['siparis_ID'];
                                $siplist['No'] = $sipp['siparis_No'];
                                $explode = explode(" ", $sipp['siparis_girilmetarih']);
                                $explodeTarih = explode("-", $explode[0]);
                                $siplist["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                                $siplist['TTutar'] = $sipp['siparis_toplamtutar'];
                                $siplist['OdeTip'] = $sipp['siparis_odemetip'];
                                //Gönderen İşlemleri
                                $siplist['GAd'] = $sipp['siparis_gonderenAdSoyad'];
                                $siplist['GTel'] = $sipp['siparis_gonderenTel'];
                                $siplist['GMail'] = $sipp['siparis_gondereneposta'];
                                $siplist['GUDurum'] = $sipp['siparis_gonderenkur'];
                                //fatura
                                $siplist['FUnvan'] = $sipp['siparis_faturaunvan'];
                                $siplist['FTcNo'] = $sipp['siparis_faturatc'];
                                $siplist['FVDaire'] = $sipp['siparis_faturavergidaire'];
                                $siplist['FVNo'] = $sipp['siparis_vergino'];
                                $siplist['FAdres'] = $sipp['siparis_faturaadres'];
                                //teslimat
                                $siplist['AAd'] = $sipp['siparis_aliciadsoyad'];
                                $siplist['ATel'] = $sipp['siparis_alicitel'];
                                $siplist['SGonTar'] = $sipp['siparis_tarih'] . ' - ' . $sipp['siparis_gun'];
                                $siplist['SGitYer'] = $sipp['siparis_yertext'];
                                $siplist['SGonSaat'] = $sipp['siparis_saat'];
                                $siplist['SGAdres'] = $sipp['siparis_aliciadres'];
                                $siplist['SGAdresTrf'] = $sipp['siparis_aliciadrestarif'];
                                $siplist['SNot'] = $sipp['siparis_gonderennotu'];
                                $siplist['SKartMsj'] = $sipp['siparis_kartmesaj'];
                                $siplist['SKartIsim'] = $sipp['siparis_kartisim'];
                                $siplist['SIsimGstr'] = $sipp['siparis_isimgorunme'];
                                $siplist['SGndNdn'] = $sipp['siparis_gndtext'];
                                $siplist['SAdminNot'] = $sipp['siparis_adminnotu'];
                                if ($sipp['siparis_durum'] == 0) {
                                    $siplist['SDurum'] = "Siparişiniz Beklemede";
                                } else if ($sipp['siparis_durum'] == 1) {
                                    $siplist['SDurum'] = "Siparişiniz Hazırlanıyor";
                                } else if ($sipp['siparis_durum'] == 2) {
                                    $siplist['SDurum'] = "Siparişiniz Gönderildi";
                                }
                            }

                            $urun = $Panel_Model->siparisUrunDetaylistele($siplist['ID']);
                            $u = 0;
                            $tutar = 0;
                            foreach ($urun as $urunn) {
                                $urunlist[$u]['SID'] = $urunn['siparisurun_ID'];
                                $urunlist[$u]['SSID'] = $urunn['siparisurun_siparisID'];
                                $urunlist[$u]['SUID'] = $urunn['siparisurun_urunID'];
                                $urunlist[$u]['SUAd'] = $urunn['siparisurun_ad'];
                                $urunlist[$u]['SUKod'] = $urunn['siparisurun_kod'];
                                $urunlist[$u]['SUMiktar'] = $urunn['siparisurun_miktar'];
                                $urunlist[$u]['SUTip'] = $urunn['siparisurun_tip'];
                                $urunlist[$u]['SUResim'] = $urunn['siparisurun_resim'];
                                $urunlist[$u]['SUTtar'] = $urunn['siparisurun_tutar'];
                                $urunlist[$u]['SUTplmTutar'] = $urunn['siparisurun_tutar'] * $urunn['siparisurun_miktar'];
                                $tutar = $tutar + $urunlist[$u]['SUTplmTutar'];
                                $urunlist[$u]['Toplam'] = $tutar;
                                $u++;
                            }
                            $siparis[0] = $siplist;
                            $siparis[1] = $urunlist;
                            if (count($siplist) > 0) {
                                $sonuc["result"] = $siparis;
                            } else {
                                $sonuc["hata"] = "Bu Koda Ait Sipariş Bulunamadı.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Kodu Unutmayınız.";
                        }
                    } else {
                        if ($sipMail != "") {
                            if ($sipKod != "") {
                                $siparis = array();
                                $sip = $Panel_Model->siparisFrontDetaylistele($sipKod, $sipMail);
                                foreach ($sip as $sipp) {
                                    $siplist['ID'] = $sipp['siparis_ID'];
                                    $siplist['No'] = $sipp['siparis_No'];
                                    $explode = explode(" ", $sipp['siparis_girilmetarih']);
                                    $explodeTarih = explode("-", $explode[0]);
                                    $siplist["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                                    $siplist['TTutar'] = $sipp['siparis_toplamtutar'];
                                    $siplist['OdeTip'] = $sipp['siparis_odemetip'];
                                    //Gönderen İşlemleri
                                    $siplist['GAd'] = $sipp['siparis_gonderenAdSoyad'];
                                    $siplist['GTel'] = $sipp['siparis_gonderenTel'];
                                    $siplist['GMail'] = $sipp['siparis_gondereneposta'];
                                    $siplist['GUDurum'] = $sipp['siparis_gonderenkur'];
                                    //fatura
                                    $siplist['FUnvan'] = $sipp['siparis_faturaunvan'];
                                    $siplist['FTcNo'] = $sipp['siparis_faturatc'];
                                    $siplist['FVDaire'] = $sipp['siparis_faturavergidaire'];
                                    $siplist['FVNo'] = $sipp['siparis_vergino'];
                                    $siplist['FAdres'] = $sipp['siparis_faturaadres'];
                                    //teslimat
                                    $siplist['AAd'] = $sipp['siparis_aliciadsoyad'];
                                    $siplist['ATel'] = $sipp['siparis_alicitel'];
                                    $siplist['SGonTar'] = $sipp['siparis_tarih'] . ' - ' . $sipp['siparis_gun'];
                                    $siplist['SGitYer'] = $sipp['siparis_yertext'];
                                    $siplist['SGonSaat'] = $sipp['siparis_saat'];
                                    $siplist['SGAdres'] = $sipp['siparis_aliciadres'];
                                    $siplist['SGAdresTrf'] = $sipp['siparis_aliciadrestarif'];
                                    $siplist['SNot'] = $sipp['siparis_gonderennotu'];
                                    $siplist['SKartMsj'] = $sipp['siparis_kartmesaj'];
                                    $siplist['SKartIsim'] = $sipp['siparis_kartisim'];
                                    $siplist['SIsimGstr'] = $sipp['siparis_isimgorunme'];
                                    $siplist['SGndNdn'] = $sipp['siparis_gndtext'];
                                    $siplist['SAdminNot'] = $sipp['siparis_adminnotu'];
                                    if ($sipp['siparis_durum'] == 0) {
                                        $siplist['SDurum'] = "Siparişiniz Beklemede";
                                    } else if ($sipp['siparis_durum'] == 1) {
                                        $siplist['SDurum'] = "Siparişiniz Hazırlanıyor";
                                    } else if ($sipp['siparis_durum'] == 2) {
                                        $siplist['SDurum'] = "Siparişiniz Gönderildi";
                                    }
                                }

                                $urun = $Panel_Model->siparisUrunDetaylistele($siplist['ID']);
                                $u = 0;
                                $tutar = 0;
                                foreach ($urun as $urunn) {
                                    $urunlist[$u]['SID'] = $urunn['siparisurun_ID'];
                                    $urunlist[$u]['SSID'] = $urunn['siparisurun_siparisID'];
                                    $urunlist[$u]['SUID'] = $urunn['siparisurun_urunID'];
                                    $urunlist[$u]['SUAd'] = $urunn['siparisurun_ad'];
                                    $urunlist[$u]['SUKod'] = $urunn['siparisurun_kod'];
                                    $urunlist[$u]['SUMiktar'] = $urunn['siparisurun_miktar'];
                                    $urunlist[$u]['SUTip'] = $urunn['siparisurun_tip'];
                                    $urunlist[$u]['SUResim'] = $urunn['siparisurun_resim'];
                                    $urunlist[$u]['SUTtar'] = $urunn['siparisurun_tutar'];
                                    $urunlist[$u]['SUTplmTutar'] = $urunn['siparisurun_tutar'] * $urunn['siparisurun_miktar'];
                                    $tutar = $tutar + $urunlist[$u]['SUTplmTutar'];
                                    $urunlist[$u]['Toplam'] = $tutar;
                                    $u++;
                                }
                                $siparis[0] = $siplist;
                                $siparis[1] = $urunlist;
                                if (count($siplist) > 0) {
                                    $sonuc["result"] = $siparis;
                                } else {
                                    $sonuc["hata"] = "Bu Koda Ait Sipariş Bulunamadı.";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen Kodu Unutmayınız.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Email Adresini Giriniz.";
                        }
                    }

                    break;
                case "hashkey":
                    $form->post("oid", true);
                    $form->post("amount", true);
                    $oid = $form->values['oid'];
                    $amount = $form->values['amount'];
                    if ($amount != "") {
                        $hash = array();
                        if ($oid == "") {
                            //ürün kodu oluşturulmakta
                            $oid = $form->benzersiz_Sayi(10);
                        }
                        //banka post hesap bilgileri
                        $clientId = "600942236";
                        $okUrl = "https://www.turkiyefloracicek.com/Order/DirectPayment";
                        $failUrl = "https://www.turkiyefloracicek.com/Order/DirectPayment";
                        $rnd = microtime();
                        $taksit = "";
                        $islemtipi = "Auth";
                        $storekey = "478965Flora";
                        $hashstr = $clientId . $oid . $amount . $okUrl . $failUrl . $islemtipi . $taksit . $rnd . $storekey;
                        $hashkey = base64_encode(pack('H*', sha1($hashstr)));
                        $hash[0] = $amount;
                        $hash[1] = $oid;
                        $hash[2] = $rnd;
                        $hash[3] = $hashkey;
                        $sonuc["result"] = $hash;
                    } else {
                        $sonuc["hata"] = "Lütfen Ödeme Tutarınızı Giriniz.";
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

