<?php

class Order extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->Product();
    }

    //daha önce login oldu ise
    function Product() {
        if (Session::get("SipID") > 0) {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            $id = Session::get("SipID");

            $urunListe = $Panel_Model->urundetaysiparis($id);

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
                    $urunlist[0][0]['KID'] = $urunkampanya[0]['ID'];
                    $urunlist[0][0]['KYuzde'] = $urunkampanya[0]['Yuzde'];
                    $urunlist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $urunlist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $urunlist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $urunlist[0][0]['urunFiyat'] = round($urunListee['urun_fiyat'] - (($urunListee['urun_fiyat'] * $urunkampanya[0]['Yuzde']) / 100));
                    $urunlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $urunlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $urunlist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                }
            } else {
                foreach ($urunListe as $urunListee) {
                    $urunlist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $urunlist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $urunlist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $urunlist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                    $urunlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $urunlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $urunlist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                }
            }

            //ek ürünleri listeleme
            $ekurunListe = $Panel_Model->ekurunlistele();
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
                            $urunlist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                            $urunlist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                            $urunlist[1][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                            $urunlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                            $urunlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                            $urunlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                        }
                    }
                } else {
                    $urunlist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                    $urunlist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                    $urunlist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                    $urunlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                    $urunlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                    $urunlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                }
                $uek++;
            }

            //Ek Ürünler varsa Onun Dizisi Sessiondan gelen
            $pekUrunDizi = Session::get("EkUrunID");
            if (count($pekUrunDizi) > 0) {

                //ek ürünleri listeleme
                $pekurunListe = $Panel_Model->ekurunbazilistele($pekUrunDizi);
                //kampanyalı ürünlerin listesi
                foreach ($pekurunListe as $pekurunListee) {
                    if ($pekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                        $pekkampanyaId[] = $pekurunListee['urun_kmpnyaid'];
                    }
                }
                //kampanyalı ürünler için 
                if (count($pekkampanyaId) > 0) {
                    $pkampanyadizi = implode(',', $pekkampanyaId);
                    $pekkampanyalar = $Panel_Model->urunkampanyalistele($pkampanyadizi, date("Y/m/d"));
                    $kmpny = 0;
                    foreach ($pekkampanyalar as $pekkampanyalarr) {
                        $pekurunkampanya[$kmpny]['ID'] = $pekkampanyalarr['kampanya_ID'];
                        $pekurunkampanya[$kmpny]['Yuzde'] = $pekkampanyalarr['kampanya_indirimyuzde'];
                        $kmpny++;
                    }
                }

                $uek = 0;
                foreach ($pekurunListe as $pekurunListee) {
                    if ($pekurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                        for ($ku = 0; $ku < count($pekurunkampanya); $ku++) {
                            if ($pekurunkampanya[$ku]['ID'] == $pekurunListee['urun_kmpnyaid']) {
                                $urunlist[2][$uek]['EkID'] = $pekurunListee['urun_ID'];
                                $urunlist[2][$uek]['EkKod'] = $pekurunListee['urun_kodu'];
                                $urunlist[2][$uek]['EkFiyat'] = round($pekurunListee['urun_fiyat'] - (($pekurunListee['urun_fiyat'] * $pekurunkampanya[$ku]['Yuzde']) / 100));
                                $urunlist[2][$uek]['EkAdi'] = $pekurunListee['urun_adi'];
                                $urunlist[2][$uek]['EkResim'] = $pekurunListee['urun_anaresim'];
                                $urunlist[2][$uek]['EkUrl'] = $pekurunListee['urun_benzad'] . "-" . $pekurunListee['urun_benzersizkod'];
                            }
                        }
                    } else {
                        $urunlist[2][$uek]['EkID'] = $pekurunListee['urun_ID'];
                        $urunlist[2][$uek]['EkKod'] = $pekurunListee['urun_kodu'];
                        $urunlist[2][$uek]['EkFiyat'] = $pekurunListee['urun_fiyat'];
                        $urunlist[2][$uek]['EkAdi'] = $pekurunListee['urun_adi'];
                        $urunlist[2][$uek]['EkResim'] = $pekurunListee['urun_anaresim'];
                        $urunlist[2][$uek]['EkUrl'] = $pekurunListee['urun_benzad'] . "-" . $pekurunListee['urun_benzersizkod'];
                    }
                    $uek++;
                }

                //ek ürünlerdeki on off durumunu ayarlama için yapıyorum
                $urunlist[3][0]['EkSwitch'] = explode(",", $pekUrunDizi);
            }

            //sabit içerikleri listeleme
            $icerikListe = $Panel_Model->sabiticeriklistele();
            foreach ($icerikListe as $icerikListe) {
                $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
                $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
                $iceriklist['face'] = $icerikListe['sbt_face'];
                $iceriklist['twit'] = $icerikListe['sbt_twit'];
                $iceriklist['instag'] = $icerikListe['sbt_instag'];
                $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
                $iceriklist['logo'] = $icerikListe['sbt_logo'];
            }
            $homedizi[8] = $iceriklist;
            $urunlist[4][0]['Logo'] = $iceriklist['logo'];

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/ekurun", $languagedeger, $urunlist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function Login() {
        if (Session::get("KID") > 0) {
            header("Refresh:0; url=" . SITE_URL . "/Order/Delivery");
        } else {
            if (Session::get("SipID") > 0) {
                $form = $this->load->otherClasses('Form');
                //model bağlantısı
                $Panel_Model = $this->load->model("Panel_Model");
                $formlanguage = $this->load->multilanguage("tr");
                $languagedeger = $formlanguage->multilanguage();

                //sabit içerikleri listeleme
                $icerikListe = $Panel_Model->sabiticeriklistele();
                foreach ($icerikListe as $icerikListe) {
                    $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
                    $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
                    $iceriklist['face'] = $icerikListe['sbt_face'];
                    $iceriklist['twit'] = $icerikListe['sbt_twit'];
                    $iceriklist['instag'] = $icerikListe['sbt_instag'];
                    $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
                    $iceriklist['logo'] = $icerikListe['sbt_logo'];
                }
                $homedizi[8] = $iceriklist;
                $siparis[0][0]['Logo'] = $iceriklist['logo'];

                $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
                $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
                $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
                $this->load->view("Template_FrontEnd/siparisuye", $languagedeger, $siparis);
                $this->load->view("Template_FrontEnd/footertop", $languagedeger);
                $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
            } else {
                header("Location:" . SITE_URL);
            }
        }
    }

    function Delivery() {
        if (Session::get("SipID") > 0) {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            $urunid = Session::get("SipID");
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
                    $deliverylist[0][0]['KID'] = $urunkampanya[0]['ID'];
                    $deliverylist[0][0]['KYuzde'] = $urunkampanya[0]['Yuzde'];
                    $deliverylist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $deliverylist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $deliverylist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $deliverylist[0][0]['urunFiyat'] = round($urunListee['urun_fiyat'] - (($urunListee['urun_fiyat'] * $urunkampanya[0]['Yuzde']) / 100));
                    $deliverylist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $deliverylist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $deliverylist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                }
            } else {
                foreach ($urunListe as $urunListee) {
                    $deliverylist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $deliverylist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $deliverylist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $deliverylist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                    $deliverylist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $deliverylist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $deliverylist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
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
                                $deliverylist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                $deliverylist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                $deliverylist[1][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                                $deliverylist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                $deliverylist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                $deliverylist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                            }
                        }
                    } else {
                        $deliverylist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                        $deliverylist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                        $deliverylist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                        $deliverylist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                        $deliverylist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                        $deliverylist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                    }
                    $uek++;
                }
            }

            $gonYer = $Panel_Model->gonderimYeri();
            $g = 0;
            foreach ($gonYer as $gonYerr) {
                $deliverylist[2][$g]['ID'] = $gonYerr['gonderimyeri_ID'];
                $deliverylist[2][$g]['AD'] = $gonYerr['gonderimyeri_adi'];
                $g++;
            }

            $gonNeden = $Panel_Model->gonderimNeden();
            $n = 0;
            foreach ($gonNeden as $gonNedenn) {
                $deliverylist[3][$n]['ID'] = $gonNedenn['gonderimnedeni_ID'];
                $deliverylist[3][$n]['AD'] = $gonNedenn['gonderimnedeni_adi'];
                $n++;
            }


            //sabit içerikleri listeleme
            $icerikListe = $Panel_Model->sabiticeriklistele();
            foreach ($icerikListe as $icerikListe) {
                $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
                $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
                $iceriklist['face'] = $icerikListe['sbt_face'];
                $iceriklist['twit'] = $icerikListe['sbt_twit'];
                $iceriklist['instag'] = $icerikListe['sbt_instag'];
                $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
                $iceriklist['logo'] = $icerikListe['sbt_logo'];
            }
            $homedizi[8] = $iceriklist;
            $deliverylist[4][0]['Logo'] = $iceriklist['logo'];

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/urunteslimat", $languagedeger, $deliverylist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function Card() {
        if (Session::get("SipID") > 0) {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            $urunid = Session::get("SipID");
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
                    $cardlist[0][0]['KID'] = $urunkampanya[0]['ID'];
                    $cardlist[0][0]['KYuzde'] = $urunkampanya[0]['Yuzde'];
                    $cardlist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $cardlist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $cardlist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $cardlist[0][0]['urunFiyat'] = round($urunListee['urun_fiyat'] - (($urunListee['urun_fiyat'] * $urunkampanya[0]['Yuzde']) / 100));
                    $cardlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $cardlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $cardlist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                }
            } else {
                foreach ($urunListe as $urunListee) {
                    $cardlist[0][0]['urunID'] = $urunListee['urun_ID'];
                    $cardlist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                    $cardlist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                    $cardlist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                    $cardlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                    $cardlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                    $cardlist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
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
                                $cardlist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                                $cardlist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                                $cardlist[1][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                                $cardlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                $cardlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                $cardlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                            }
                        }
                    } else {
                        $cardlist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                        $cardlist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                        $cardlist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                        $cardlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                        $cardlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                        $cardlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                    }
                    $uek++;
                }
            }

            $mesafeListe = $Panel_Model->mesafeliSozlistele();
            foreach ($mesafeListe as $mesafeListee) {
                $cardlist[2][0]["Mesafe"] = $mesafeListee['sbt_mesafelistssoz'];
            }

            //sabit içerikleri listeleme
            $icerikListe = $Panel_Model->sabiticeriklistele();
            foreach ($icerikListe as $icerikListe) {
                $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
                $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
                $iceriklist['face'] = $icerikListe['sbt_face'];
                $iceriklist['twit'] = $icerikListe['sbt_twit'];
                $iceriklist['instag'] = $icerikListe['sbt_instag'];
                $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
                $iceriklist['logo'] = $icerikListe['sbt_logo'];
            }
            $homedizi[8] = $iceriklist;
            $cardlist[3][0]["Logo"] = $iceriklist['logo'];
            $cardlist[3][1]["Tel"] = $iceriklist['telefon'];

            //kart bilgileri
            $bankaListe = $Panel_Model->bankaFrontListele();
            $b = 0;
            foreach ($bankaListe as $bankaListee) {
                $cardlist[4][$b]['ID'] = $bankaListee['banka_ID'];
                $cardlist[4][$b]['Adi'] = $bankaListee['banka_adi'];
                $cardlist[4][$b]['Sube'] = $bankaListee['banka_sube'];
                $cardlist[4][$b]['HesapNo'] = $bankaListee['banka_hesapno'];
                $cardlist[4][$b]['IbanNo'] = $bankaListee['banka_ibanno'];
                $cardlist[4][$b]['Alici'] = $bankaListee['banka_alici'];
                $b++;
            }

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/urunodeme", $languagedeger, $cardlist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function Access() {
        if (Session::get("SipID") > 0) {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            //daha önceki siparişle ilgili bilgileri temizliyorum
            unset($_SESSION['SipID']);
            unset($_SESSION['SipAdres']);
            unset($_SESSION['SipIlceFiyat']);
            unset($_SESSION['SipTarih']);
            unset($_SESSION['SipSaat']);
            unset($_SESSION['SipGun']);
            unset($_SESSION['EkUrunID']);
            unset($_SESSION['SipGeciciUrunID']);

            // Banka hesap bilgileri
            $bankaListe = $Panel_Model->bankaFrontListele();
            $b = 0;
            foreach ($bankaListe as $bankaListee) {
                $onaylist[0][$b]['ID'] = $bankaListee['banka_ID'];
                $onaylist[0][$b]['Adi'] = $bankaListee['banka_adi'];
                $onaylist[0][$b]['Sube'] = $bankaListee['banka_sube'];
                $onaylist[0][$b]['HesapNo'] = $bankaListee['banka_hesapno'];
                $onaylist[0][$b]['IbanNo'] = $bankaListee['banka_ibanno'];
                $onaylist[0][$b]['Alici'] = $bankaListee['banka_alici'];
                $b++;
            }

            //sabit içerikleri listeleme
            $icerikListe = $Panel_Model->sabiticeriklistele();
            foreach ($icerikListe as $icerikListe) {
                $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
                $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
                $iceriklist['face'] = $icerikListe['sbt_face'];
                $iceriklist['twit'] = $icerikListe['sbt_twit'];
                $iceriklist['instag'] = $icerikListe['sbt_instag'];
                $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
                $iceriklist['logo'] = $icerikListe['sbt_logo'];
            }
            $homedizi[8] = $iceriklist;
            $onaylist[1][0]['Logo'] = $iceriklist['logo'];
            $onaylist[1][0]['Tel'] = $iceriklist['telefon'];

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/siparisonay", $languagedeger, $onaylist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}

?>
