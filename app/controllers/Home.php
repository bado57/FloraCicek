<?php

class Home extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->home();
    }

    //daha önce login oldu ise
    function home() {
        //Tüm Sessionlar iptal edilmekte
        $homedizi = array();
        $form = $this->load->otherClasses('Form');
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        //etiketleri listeleme
        $etiketListe = $Panel_Model->etiketlistele();
        $a = 0;
        foreach ($etiketListe as $etiketListee) {
            $etiketlist[$a]['etiketID'] = $etiketListee['etiket_id'];
            $etiketlist[$a]['etiketAd'] = $etiketListee['etiket_adi'];
            $etiketlist[$a]['etiketUrl'] = $etiketListee['etiket_benzad'];
            $a++;
        }
        $homedizi[0] = $etiketlist; //etiket listesi
        //kategorileri listeleme
        $kategoriListe = $Panel_Model->kategorilistele();
        $b = 0;
        $c = 0;
        foreach ($kategoriListe as $kategoriListee) {
            if ($kategoriListee['kategori_UstID'] == 0) {//Üst Kategori Olanlar
                $kategorilistUst[$b]['ID'] = $kategoriListee['kategori_ID'];
                $kategorilistUst[$b]['Adi'] = $kategoriListee['kategori_Adi'];
                $kategorilistUst[$b]['Sira'] = $kategoriListee['kategori_Sira'];
                $b++;
            } else {
                $kategorilistAlt[$c]['ID'] = $kategoriListee['kategori_ID'];
                $kategorilistAlt[$c]['Adi'] = $kategoriListee['kategori_Adi'];
                $kategorilistAlt[$c]['Sira'] = $kategoriListee['kategori_Sira'];
                $kategorilistAlt[$c]['UstID'] = $kategoriListee['kategori_UstID'];
                $kategorilistAlt[$c]['Url'] = $kategoriListee['kategori_BenzAd'];
                $c++;
            }
        }
        //alt kategorileri üst kategoriye göre gruplama
        for ($x = 0; $x < count($kategorilistUst); $x++) {
            $t = 0;
            for ($y = 0; $y < count($kategorilistAlt); $y++) {
                if ($kategorilistUst[$x]['ID'] == $kategorilistAlt[$y]['UstID']) {
                    $kategoriAltSira[$x][$t]['ID'] = $kategorilistAlt[$y]['ID'];
                    $kategoriAltSira[$x][$t]['UstID'] = $kategorilistAlt[$y]['UstID'];
                    $kategoriAltSira[$x][$t]['Adi'] = $kategorilistAlt[$y]['Adi'];
                    $kategoriAltSira[$x][$t]['Url'] = $kategorilistAlt[$y]['Url'];
                    $kategoriAltSira[$x][$t]['Sira'] = $kategorilistAlt[$y]['Sira'];
                    $t++;
                }
            }
        }
        $homedizi[1] = $kategorilistUst; //Üst Kategori
        $homedizi[2] = $kategoriAltSira; //Alt Kategori

        $kampanyaListe = $Panel_Model->kampanyalistele();
        $k = 0;
        foreach ($kampanyaListe as $kampanyaListee) {
            $kampanyalist[$k]['ID'] = $kampanyaListee['kampanya_ID'];
            $kampanyalist[$k]['Adi'] = $kampanyaListee['kampanya_baslik'];
            $kampanyalist[$k]['Url'] = $kampanyaListee['kampanya_benbaslik'];
            $k++;
        }
        $homedizi[3] = $kampanyalist; //Kampanya Kategori

        $vitrinListe = $Panel_Model->vitrinlistele();
        $vi = 0;
        foreach ($vitrinListe as $vitrinListee) {
            $vitrinlist[$vi]['ID'] = $vitrinListee['vitrin_ID'];
            $vitrinlist[$vi]['Path'] = $vitrinListee['vitrin_resimpath'];
            $vitrinlist[$vi]['Baslik'] = $vitrinListee['vitrin_baslik'];
            $vitrinlist[$vi]['Yazi'] = $vitrinListee['vitrin_yazi'];
            $kes = explode("/", $vitrinListee['vitrin_url']);
            if (count($kes) == 3) {
                $vitrinlist[$vi]['Url'] = $kes[2];
            } else if (count($kes) == 4) {
                $vitrinlist[$vi]['Url'] = $kes[2] . "/" . $kes[3];
            }
            $vitrinlist[$vi]['AltBaslik'] = $vitrinListee['vitrin_altbaslik'];
            $vitrinlist[$vi]['BtnYazi'] = $vitrinListee['vitrin_buttonyazi'];
            $vi++;
        }

        $homedizi[4] = $vitrinlist; //Virin Listesi

        $urunListe = $Panel_Model->urunlistele();
        //kampanyalı ürünlerin listesi
        foreach ($urunListe as $urunListee) {
            if ($urunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                $kampanyaId[] = $urunListee['urun_kmpnyaid'];
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
        $uyeni = 0;
        $uek = 0;
        $ukmpny = 0;
        foreach ($urunListe as $urunListee) {
            if ($urunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                for ($ku = 0; $ku < count($urunkampanya); $ku++) {
                    if ($urunkampanya[$ku]['ID'] == $urunListee['urun_kmpnyaid']) {
                        //kampanyalı ürünler
                        $urunlist[3][$ukmpny]['ID'] = $urunListee['urun_ID'];
                        $urunlist[3][$ukmpny]['Kod'] = $urunListee['urun_kodu'];
                        $urunlist[3][$ukmpny]['Fiyat'] = $urunListee['urun_fiyat'];
                        $urunlist[3][$ukmpny]['Adi'] = $urunListee['urun_adi'];
                        $urunlist[3][$ukmpny]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                        $urunlist[3][$ukmpny]['Path'] = $urunListee['urun_anaresim'];
                        $urunlist[3][$ukmpny]['KYuzde'] = $urunkampanya[$ku]['Yuzde'];
                        $ukmpny++;

                        if ($urunListee['urun_hafta'] != 0) {//haftanın ürünü
                            $urunlist[0][0]['ID'] = $urunListee['urun_ID'];
                            $urunlist[0][0]['Kod'] = $urunListee['urun_kodu'];
                            $urunlist[0][0]['Fiyat'] = $urunListee['urun_fiyat'];
                            $urunlist[0][0]['Adi'] = $urunListee['urun_adi'];
                            $urunlist[0][0]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                            $urunlist[0][0]['Path'] = $urunListee['urun_anaresim'];
                            $urunlist[0][0]['KID'] = $urunkampanya[$ku]['ID'];
                            $urunlist[0][0]['KYuzde'] = $urunkampanya[$ku]['Yuzde'];
                        }
                        if ($urunListee['urun_yeniurun'] != 0) {//yeni ürünü
                            $urunlist[1][$uyeni]['ID'] = $urunListee['urun_ID'];
                            $urunlist[1][$uyeni]['Kod'] = $urunListee['urun_kodu'];
                            $urunlist[1][$uyeni]['Fiyat'] = $urunListee['urun_fiyat'];
                            $urunlist[1][$uyeni]['Adi'] = $urunListee['urun_adi'];
                            $urunlist[1][$uyeni]['Path'] = $urunListee['urun_anaresim'];
                            $urunlist[1][$uyeni]['KID'] = $urunkampanya[$ku]['ID'];
                            $urunlist[1][$uyeni]['KYuzde'] = $urunkampanya[$ku]['Yuzde'];
                            $urunlist[1][$uyeni]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                            $uyeni++;
                        }
                        if ($urunListee['urun_ekurun'] != 0) {//ek ürün
                            $urunlist[2][$uek]['ID'] = $urunListee['urun_ID'];
                            $urunlist[2][$uek]['Kod'] = $urunListee['urun_kodu'];
                            $urunlist[2][$uek]['Fiyat'] = $urunListee['urun_fiyat'];
                            $urunlist[2][$uek]['Adi'] = $urunListee['urun_adi'];
                            $urunlist[2][$uek]['KID'] = $urunkampanya[$ku]['ID'];
                            $urunlist[2][$uek]['KYuzde'] = $urunkampanya[$ku]['Yuzde'];
                            $urunlist[2][$uek]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                            $uek++;
                        }
                    }
                }
            } else {
                if ($urunListee['urun_hafta'] != 0) {//haftanın ürünü
                    $urunlist[0][0]['ID'] = $urunListee['urun_ID'];
                    $urunlist[0][0]['Kod'] = $urunListee['urun_kodu'];
                    $urunlist[0][0]['Fiyat'] = $urunListee['urun_fiyat'];
                    $urunlist[0][0]['Adi'] = $urunListee['urun_adi'];
                    $urunlist[0][0]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                    $urunlist[0][0]['Path'] = $urunListee['urun_anaresim'];
                }
                if ($urunListee['urun_yeniurun'] != 0) {//yeni ürünü
                    $urunlist[1][$uyeni]['ID'] = $urunListee['urun_ID'];
                    $urunlist[1][$uyeni]['Kod'] = $urunListee['urun_kodu'];
                    $urunlist[1][$uyeni]['Fiyat'] = $urunListee['urun_fiyat'];
                    $urunlist[1][$uyeni]['Adi'] = $urunListee['urun_adi'];
                    $urunlist[1][$uyeni]['Path'] = $urunListee['urun_anaresim'];
                    $urunlist[1][$uyeni]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                    $uyeni++;
                }
                if ($urunListee['urun_ekurun'] != 0) {//ek ürün
                    $urunlist[2][$uek]['ID'] = $urunListee['urun_ID'];
                    $urunlist[2][$uek]['Kod'] = $urunListee['urun_kodu'];
                    $urunlist[2][$uek]['Fiyat'] = $urunListee['urun_fiyat'];
                    $urunlist[2][$uek]['Adi'] = $urunListee['urun_adi'];
                    $urunlist[2][$uek]['Url'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
                    $uek++;
                }
            }
        }
        $homedizi[5] = $urunlist; //Ürün Listesi
        //Footer Dinamik Bilgiler
        //kategorileri listeleme
        $fotkategoriListe = $Panel_Model->footerkategorilistele();
        $fb = 0;
        $fc = 0;
        foreach ($fotkategoriListe as $fotkategoriListee) {
            if ($fotkategoriListee['sayfa_UstID'] == 0) {//Footer Üst Kategori Olanlar
                $fotkategorilistUst[$fb]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistUst[$fb]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistUst[$fb]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistUst[$fb]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                $fc++;
            }
        }

        //alt kategorileri üst kategoriye göre gruplama
        for ($x = 0; $x < count($fotkategorilistUst); $x++) {
            $t = 0;
            for ($y = 0; $y < count($fotkategorilistAlt); $y++) {
                if ($fotkategorilistUst[$x]['ID'] == $fotkategorilistAlt[$y]['UstID']) {
                    $fotkategoriAltSira[$x][$t]['ID'] = $fotkategorilistAlt[$y]['ID'];
                    $fotkategoriAltSira[$x][$t]['UstID'] = $fotkategorilistAlt[$y]['UstID'];
                    $fotkategoriAltSira[$x][$t]['Adi'] = $fotkategorilistAlt[$y]['Adi'];
                    $fotkategoriAltSira[$x][$t]['Url'] = $fotkategorilistAlt[$y]['Url'];
                    $fotkategoriAltSira[$x][$t]['Sira'] = $fotkategorilistAlt[$y]['Sira'];
                    $t++;
                }
            }
        }

        $homedizi[6] = $fotkategorilistUst; //Footer Üst Kategori Listesi
        $homedizi[7] = $fotkategoriAltSira; //Footer Alt Kategori Listesi
        //sabit içerikleri listeleme
        $icerikListe = $Panel_Model->sabiticeriklistele();
        foreach ($icerikListe as $icerikListe) {
            $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
            $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
            $iceriklist['face'] = $icerikListe['sbt_face'];
            $iceriklist['twit'] = $icerikListe['sbt_twit'];
            $iceriklist['instag'] = $icerikListe['sbt_instag'];
            $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
        }
        $homedizi[8] = $iceriklist;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/home", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    //daha önce login oldu ise
    function login() {
        if (Session::get("KID") > 0) {
            header("Refresh:0; url=" . SITE_URL);
        } else {
            $Panel_Model = $this->load->model("panel_model");
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
            }
            $homedizi[8] = $iceriklist;

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/login", $languagedeger);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        }
    }

    function bireysel() {
        if (Session::get("KID") > 0) {
            header("Refresh:0; url=" . SITE_URL);
        } else {
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();

            $uyelikListe = $Panel_Model->uyelikSozlistele();
            foreach ($uyelikListe as $uyelikListee) {
                $uyelikSoz[0] = $uyelikListee['sbt_uyeliksoz'];
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
            }
            $homedizi[8] = $iceriklist;

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/bireysel", $languagedeger, $uyelikSoz);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        }
    }

    function kurumsal() {
        if (Session::get("KID") > 0) {
            header("Refresh:0; url=" . SITE_URL);
        } else {
            $form = $this->load->otherClasses('Form');
            //model bağlantısı
            $Panel_Model = $this->load->model("panel_model");
            $formlanguage = $this->load->multilanguage("tr");
            $languagedeger = $formlanguage->multilanguage();

            $uyelikListe = $Panel_Model->uyelikSozlistele();
            foreach ($uyelikListe as $uyelikListee) {
                $uyelikSoz[0] = $uyelikListee['sbt_uyeliksoz'];
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
            }
            $homedizi[8] = $iceriklist; //etiket listesi

            $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
            $this->load->view("Template_FrontEnd/kurumsal", $languagedeger, $uyelikSoz);
            $this->load->view("Template_FrontEnd/footertop", $languagedeger);
            $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
        }
    }

    //daha önce login oldu ise
    function Contact() {
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        //sabit içerikleri listeleme
        $icerikListe = $Panel_Model->sabiticerikcontactlistele();
        foreach ($icerikListe as $icerikListe) {
            $iceriklist['telefon'] = $icerikListe['sbt_telefon'];
            $iceriklist['fax'] = $icerikListe['sbt_fax'];
            $iceriklist['adres'] = $icerikListe['sbt_adres'];
            $iceriklist['iframe'] = $icerikListe['sbt_haritaiframe'];
            $iceriklist['mail'] = $icerikListe['sbt_iletisimmail'];
            $iceriklist['face'] = $icerikListe['sbt_face'];
            $iceriklist['twit'] = $icerikListe['sbt_twit'];
            $iceriklist['instag'] = $icerikListe['sbt_instag'];
            $iceriklist['gplus'] = $icerikListe['sbt_gplus'];
        }
        $homedizi[8] = $iceriklist; //etiket listesi

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/contact", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

}

?>