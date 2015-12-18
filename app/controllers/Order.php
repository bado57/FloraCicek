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
        if ($_POST["HASHPARAMS"] != "") {
            $hashparams = $_POST["HASHPARAMS"];
            $hashparamsval = $_POST["HASHPARAMSVAL"];
            $hashparam = $_POST["HASH"];
            $storekey = "123456";
            $paramsval = "";
            $index1 = 0;
            $index2 = 0;

            while ($index1 < strlen($hashparams)) {
                $index2 = strpos($hashparams, ":", $index1);
                $vl = $_POST[substr($hashparams, $index1, $index2 - $index1)];
                if ($vl == null)
                    $vl = "";
                $paramsval = $paramsval . $vl;
                $index1 = $index2 + 1;
            }
            $storekey = "123456";
            $hashval = $paramsval . $storekey;
            $hash = base64_encode(pack('H*', sha1($hashval)));

            if ($paramsval != $hashparamsval || $hashparam != $hash) {
                unset($_SESSION["BankErrMsg"]);
                Session:set("BankErrMsg", "3D Islemi basarisiz");
                header("Location:" . SITE_URL . "/Order/Card");
            }
            if ($_POST["mdStatus"] != "") {
                $mdStatus = $_POST["mdStatus"];
                if ($mdStatus == 1 || $mdStatus == 2 || $mdStatus == 3 || $mdStatus == 4) {
                    //3D Islemi basarili
                    if ($_POST["Response"]) {
                        $mdStatus = $_POST["mdStatus"];
                        $ErrMsg = $_POST["ErrMsg"];
                        $response = $_POST["Response"];
                        $form = $this->load->otherClasses('Form');
                        //model bağlantısı
                        $Panel_Model = $this->load->model("Panel_Model");
                        if ($response == "Approved") {
                            $urunid = Session::get("SipID");
                            //ürünlerin toplam fiyatı için
                            $urunToplamFiyat = 0;
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
                                    'siparis_odemetip' => 0, //kart ile ödeme
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
                                                //siparisin kart ile olduğunu gösterir
                                                Session::set("SipTechOnay", 1);
                                                Session::set("SipTTutar", $urunToplamFiyat);
                                                //mail gönderiliyor
                                                $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"]);
                                                if ($resultMail) {
                                                    header("Location:" . SITE_URL . "/Order/Access");
                                                } else {
                                                    header("Location:" . SITE_URL . "/Order/Access");
                                                }
                                            } else {
                                                //siparisin kart ile olduğunu gösterir
                                                Session::set("SipTechOnay", 1);
                                                Session::set("SipTTutar", $urunToplamFiyat);
                                                //mail gönderiliyor
                                                $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"]);
                                                if ($resultMail) {
                                                    header("Location:" . SITE_URL . "/Order/Access");
                                                } else {
                                                    header("Location:" . SITE_URL . "/Order/Access");
                                                }
                                            }
                                        } else {
                                            //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                            //$deletesiparis = $Panel_Model->siparisDelete($result);
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                        //$deletesiparis = $Panel_Model->siparisDelete($result);
                                        $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                    }
                                } else {
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
                                        'siparis_odemetip' => 0, //kart ile ödeme
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
                                                    //siparisin kart ile olduğunu gösterir
                                                    Session::set("SipTechOnay", 1);
                                                    Session::set("SipTTutar", $urunToplamFiyat);
                                                    //mail gönderiliyor
                                                    $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"]);
                                                    if ($resultMail) {
                                                        header("Location:" . SITE_URL . "/Order/Access");
                                                    } else {
                                                        header("Location:" . SITE_URL . "/Order/Access");
                                                    }
                                                } else {
                                                    //siparisin kart ile olduğunu gösterir
                                                    Session::set("SipTechOnay", 1);
                                                    Session::set("SipTTutar", $urunToplamFiyat);
                                                    //mail gönderiliyor
                                                    $resultMail = $form->sSiparisMailGonder($siparisliste[0]["siparis_gondereneposta"], $siparisliste[0]["siparis_gonderenAdSoyad"], $siparisliste[0]["siparis_No"]);
                                                    if ($resultMail) {
                                                        header("Location:" . SITE_URL . "/Order/Access");
                                                    } else {
                                                        header("Location:" . SITE_URL . "/Order/Access");
                                                    }
                                                }
                                            } else {
                                                //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                            }
                                        } else {
                                            //eklenilen son siparişi siliyorum çünkü ürün durumunda bi hata meydana geldi
                                            $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                                        }
                                    }
                                }
                            } else {
                                $sonuc["hata"] = "Bir Hata Oluştu Lütfen Tekrar Deneyiniz.";
                            }
                        } else {
                            //Başarısız
                            //echo "Ödeme Islemi Basarisiz. Hata = " . $ErrMsg;
                            unset($_SESSION["BankErrMsg"]);
                            $_SESSION["BankErrMsg"] = " Ödeme Islemi Basarisiz. Hata =" . $ErrMsg;
                            header("Location:" . SITE_URL . "/Order/Card");
                        }
                    }
                } else {
                    unset($_SESSION["BankErrMsg"]);
                    $_SESSION["BankErrMsg"] = "3D Islemi basarisiz";
                    header("Location:" . SITE_URL . "/Order/Card");
                }
            } else {
                unset($_SESSION["BankErrMsg"]);
                $_SESSION["BankErrMsg"] = "Kart Bilgileri Hatalıdır.";
                header("Location:" . SITE_URL . "/Order/Card");
            }
        } else {
            if (Session::get("Odeme") > 0) {
                $form = $this->load->otherClasses('Form');
                //model bağlantısı
                $Panel_Model = $this->load->model("Panel_Model");
                $formlanguage = $this->load->multilanguage("tr");
                $languagedeger = $formlanguage->multilanguage();
                $urunid = Session::get("SipID");
                $urunToplamFiyat = 0;
                $urunAdet = 0;
                $urunHtml = "";
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
                        $urunToplamFiyat = $urunToplamFiyat + $cardlist[0][0]['urunFiyat'];
                        $urunAdet++;
                        $cardlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                        $cardlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                        $urunHtml = $urunHtml . "<b>Ürün Adı: </b>" . $urunListee['urun_adi'] . "</br>";
                        $cardlist[0][0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                    }
                } else {
                    foreach ($urunListe as $urunListee) {
                        $cardlist[0][0]['urunID'] = $urunListee['urun_ID'];
                        $cardlist[0][0]['urunKod'] = $urunListee['urun_kodu'];
                        $cardlist[0][0]['urunAciklama'] = $urunListee['urun_aciklama'];
                        $cardlist[0][0]['urunFiyat'] = $urunListee['urun_fiyat'];
                        $urunToplamFiyat = $urunToplamFiyat + $cardlist[0][0]['urunFiyat'];
                        $urunAdet++;
                        $cardlist[0][0]['urunResim'] = $urunListee['urun_anaresim'];
                        $cardlist[0][0]['urunAd'] = $urunListee['urun_adi'];
                        $urunHtml = $urunHtml . "<b>Ürün Adı: </b>" . $urunListee['urun_adi'] . "</br>";
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
                                    $urunToplamFiyat = $urunToplamFiyat + $cardlist[1][$uek]['EkFiyat'];
                                    $cardlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                                    $urunAdet++;
                                    $urunHtml = $urunHtml . "<b>Ürün Adı: </b>" . $ekurunListee['urun_adi'] . " (Ek Ürün)</br>";
                                    $cardlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                                    $cardlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                                }
                            }
                        } else {
                            $cardlist[1][$uek]['EkID'] = $ekurunListee['urun_ID'];
                            $cardlist[1][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                            $cardlist[1][$uek]['EkFiyat'] = $ekurunListee['urun_fiyat'];
                            $urunToplamFiyat = $urunToplamFiyat + $cardlist[1][$uek]['EkFiyat'];
                            $cardlist[1][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                            $urunAdet++;
                            $urunHtml = $urunHtml . "<b>Ürün Adı: </b>" . $ekurunListee['urun_adi'] . " (Ek Ürün)</br>";
                            $cardlist[1][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                            $cardlist[1][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                        }
                        $uek++;
                    }
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
                    $cardlist[2][0]["Mesafe"] = $icerikListe['sbt_mesafelistssoz'];
                    $cardlist[2][1]["OnBilgi"] = $icerikListe['sbt_onbilgilendirmeform'];
                }
                //mesafeli sözleşmede değişmesi gereken alanlar
                date_default_timezone_set('Europe/Istanbul');
                //mesafeli satış sözleşmesi bilgiler değişimi
                $cardlist[2][0]["Mesafe"] = str_replace("[username]", Session::get("AliciAdSoyad"), $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[userphone]", Session::get("AliciPhone"), $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[usermail]", Session::get("AliciMail"), $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[orderarrivedate]", Session::get("SipTarih"), $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[orderextraprice]", $urunToplamFiyat . ' TL', $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[now]", date('d.m.Y H:i:s'), $cardlist[2][0]["Mesafe"]);
                $cardlist[2][0]["Mesafe"] = str_replace("[orderproductlist]", $urunHtml, $cardlist[2][0]["Mesafe"]);
                //Ön bilgilendirme formu bilgiler değişimi
                $cardlist[2][1]["OnBilgi"] = str_replace("[orderno]", Session::get("SipKodu"), $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[orderquantity]", $urunAdet . " Adet", $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[ordertotal]", $urunToplamFiyat, $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[orderproductlist]", $urunHtml, $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[orderpaymenttype]", "Tanımsız", $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[orderextraprice]", $urunToplamFiyat, $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[username]", Session::get("AliciAdSoyad"), $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[userphone]", Session::get("AliciPhone"), $cardlist[2][1]["OnBilgi"]);
                $cardlist[2][1]["OnBilgi"] = str_replace("[usermail]", Session::get("AliciMail"), $cardlist[2][1]["OnBilgi"]);

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

                //banka post hesap bilgileri
                $cardlist[5][0]['ClientID'] = "600200000";
                $cardlist[5][0]['TTutar'] = $urunToplamFiyat;
                $cardlist[5][0]['SipNumber'] = Session::get("SipKodu");
                $cardlist[5][0]['okUrl'] = "https://www.turkiyefloracicek.com/Order/Card";
                $cardlist[5][0]['failUrl'] = "https://www.turkiyefloracicek.com/Order/Card";
                $cardlist[5][0]['Rnd'] = microtime();
                $cardlist[5][0]['Taksit'] = "";
                $cardlist[5][0]['IslemTip'] = "Auth";
                $cardlist[5][0]['IsyeriAnahtar'] = "123456";
                $hashstr = $cardlist[5][0]['ClientID'] . $cardlist[5][0]['SipNumber'] . $cardlist[5][0]['TTutar'] . $cardlist[5][0]['okUrl']
                        . $cardlist[5][0]['failUrl'] . $cardlist[5][0]['IslemTip'] . $cardlist[5][0]['Taksit'] . $cardlist[5][0]['Rnd']
                        . $cardlist[5][0]['IsyeriAnahtar'];
                $cardlist[5][0]['Hash'] = base64_encode(pack('H*', sha1($hashstr)));
                //banka dönen error değeri varmı
                if (Session::get("BankErrMsg") != "") {
                    $cardlist[5][0]['BankErrMsj'] = Session::get("BankErrMsg");
                    unset($_SESSION["BankErrMsg"]);
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
    }

    function Access() {
        if (Session::get("SipTechOnay") > 0) {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            //daha önceki siparişle ilgili bilgileri temizliyorum
            unset($_SESSION['SipID']);
            unset($_SESSION['SipIl']);
            unset($_SESSION['SipIlID']);
            unset($_SESSION['SipIlce']);
            unset($_SESSION['SipIlceID']);
            unset($_SESSION['SipAdres']);
            unset($_SESSION['SipIlceFiyat']);
            unset($_SESSION['SipTarih']);
            unset($_SESSION['SipSaat']);
            unset($_SESSION['SipGun']);
            unset($_SESSION['EkUrunID']);
            unset($_SESSION['SipGeciciUrunID']);
            unset($_SESSION['Odeme']);
            unset($_SESSION['AliciAdSoyad']);
            unset($_SESSION['AliciPhone']);
            unset($_SESSION['AliciMail']);
            unset($_SESSION["BankErrMsg"]);
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
            //son olan sessionlarıda kaldırıyorum
            unset($_SESSION['SipTechOnay']);
            unset($_SESSION['SipKodu']);
            unset($_SESSION['SipTTutar']);
        } else {
            header("Location:" . SITE_URL);
        }
    }

    function DirectPayment() {
        if ($_POST["HASHPARAMS"] != "") {
            $hashparams = $_POST["HASHPARAMS"];
            $hashparamsval = $_POST["HASHPARAMSVAL"];
            $hashparam = $_POST["HASH"];
            $storekey = "123456";
            $paramsval = "";
            $index1 = 0;
            $index2 = 0;

            while ($index1 < strlen($hashparams)) {
                $index2 = strpos($hashparams, ":", $index1);
                $vl = $_POST[substr($hashparams, $index1, $index2 - $index1)];
                if ($vl == null)
                    $vl = "";
                $paramsval = $paramsval . $vl;
                $index1 = $index2 + 1;
            }
            $storekey = "123456";
            $hashval = $paramsval . $storekey;
            $hash = base64_encode(pack('H*', sha1($hashval)));

            if ($paramsval != $hashparamsval || $hashparam != $hash) {
                unset($_SESSION["BankErrMsg"]);
                Session:set("BankErrMsg", "3D Islemi basarisiz");
                header("Location:" . SITE_URL . "/Order/DirectPayment");
            }
            if ($_POST["mdStatus"] != "") {
                $mdStatus = $_POST["mdStatus"];
                if ($mdStatus == 1 || $mdStatus == 2 || $mdStatus == 3 || $mdStatus == 4) {
                    //3D Islemi basarili
                    if ($_POST["Response"]) {
                        $mdStatus = $_POST["mdStatus"];
                        $ErrMsg = $_POST["ErrMsg"];
                        $response = $_POST["Response"];
                        $form = $this->load->otherClasses('Form');
                        //model bağlantısı
                        $Panel_Model = $this->load->model("Panel_Model");
                        if ($response == "Approved") {
                            Session::set("OzelOdeme", 1);
                            header("Location:" . SITE_URL . "/Order/DirectAccess");
                        } else {
                            //Başarısız
                            //echo "Ödeme Islemi Basarisiz. Hata = " . $ErrMsg;
                            unset($_SESSION["BankErrMsg"]);
                            $_SESSION["BankErrMsg"] = " Ödeme Islemi Basarisiz. Hata =" . $ErrMsg;
                            header("Location:" . SITE_URL . "/Order/DirectPayment");
                        }
                    }
                } else {
                    unset($_SESSION["BankErrMsg"]);
                    $_SESSION["BankErrMsg"] = "3D Islemi basarisiz";
                    header("Location:" . SITE_URL . "/Order/DirectPayment");
                }
            } else {
                unset($_SESSION["BankErrMsg"]);
                $_SESSION["BankErrMsg"] = "Kart Bilgileri Hatalıdır.";
                header("Location:" . SITE_URL . "/Order/DirectPayment");
            }
        } else {
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
            $paymentlist[3][0]["Logo"] = $iceriklist['logo'];
            $paymentlist[3][1]["Tel"] = $iceriklist['telefon'];

            //banka post hesap bilgileri
            $paymentlist[5][0]['ClientID'] = "600200000";
            $paymentlist[5][0]['TTutar'] = "";
            $paymentlist[5][0]['SipNumber'] = "";
            $paymentlist[5][0]['okUrl'] = "https://www.turkiyefloracicek.com/Order/DirectPayment";
            $paymentlist[5][0]['failUrl'] = "https://www.turkiyefloracicek.com/Order/DirectPayment";
            $paymentlist[5][0]['Rnd'] = microtime();
            $paymentlist[5][0]['Taksit'] = "";
            $paymentlist[5][0]['IslemTip'] = "Auth";
            $paymentlist[5][0]['IsyeriAnahtar'] = "123456";
            $hashstr = $paymentlist[5][0]['ClientID'] . $paymentlist[5][0]['SipNumber'] . $paymentlist[5][0]['TTutar'] . $paymentlist[5][0]['okUrl']
                    . $paymentlist[5][0]['failUrl'] . $paymentlist[5][0]['IslemTip'] . $paymentlist[5][0]['Taksit'] . $paymentlist[5][0]['Rnd']
                    . $paymentlist[5][0]['IsyeriAnahtar'];
            $paymentlist[5][0]['Hash'] = base64_encode(pack('H*', sha1($hashstr)));
            //banka dönen error değeri varmı
            if (Session::get("BankErrMsg") != "") {
                $paymentlist[5][0]['BankErrMsj'] = Session::get("BankErrMsg");
                unset($_SESSION["BankErrMsg"]);
            }
            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/ozelodeme", $languagedeger, $paymentlist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        }
    }

    function DirectAccess() {
        if (Session::get("OzelOdeme") > 0) {
            //model bağlantısı
            $Panel_Model = $this->load->model("Panel_Model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();
            //daha önceki siparişle ilgili bilgileri temizliyorum

            unset($_SESSION["BankErrMsg"]);

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
            $this->load->view("Template_FrontEnd/ozelodemeonay", $languagedeger, $onaylist);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
            //son olan sessionlarıda kaldırıyorum
            unset($_SESSION['OzelOdeme']);
        } else {
            header("Location:" . SITE_URL);
        }
    }

}

?>
