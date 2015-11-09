<?php

class Admin extends Controller {

    public function __construct() {
        if (Session::get("KRol") == 1) {
            parent::__construct();
        } else {
            header("Refresh:0; url=localhost/SProject/floracicek");
        }
    }

    public function index() {
        $this->Panel();
    }

    //daha önce login oldu ise
    function Panel() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $uyeliste = $Panel_Model->adminPanelUyeCount();
        $a = 0;
        $b = 0;
        foreach ($uyeliste as $uyelistee) {
            if ($uyelistee['kullanici_rol'] == 0) {//Normal Kullancıı
                $birUyeList[$a]["Rol"] = $uyelistee['kullanici_rol'];
                $a++;
            } else if ($uyelistee['kullanici_rol'] == 2) {//Kurumsal Kullanıcı
                $kurUyeList[$b]["Rol"] = $uyelistee['kullanici_rol'];
                $b++;
            }
        }

        $panelİslem[0] = count($birUyeList);
        $panelİslem[1] = count($kurUyeList);

        $urunliste = $Panel_Model->adminPanelUrunCount();
        foreach ($urunliste as $urunlistee) {
            $urunCount = $urunlistee['total'];
        }
        $panelİslem[2] = $urunCount;

        $uyeSonliste = $Panel_Model->adminPanelUyeSon();
        $c = 0;
        foreach ($uyeSonliste as $uyeSonlistee) {
            $birUyeList[$c]["ID"] = $uyeSonlistee['kullanici_id'];
            $birUyeList[$c]["AdSoyad"] = $uyeSonlistee['kullanici_adSoyad'];
            $birUyeList[$c]["EPosta"] = $uyeSonlistee['kullanici_eposta'];
            $birUyeList[$c]["Rol"] = $uyeSonlistee['kullanici_rol'];
            $c++;
        }

        $panelİslem[4] = $birUyeList;

        $urunSonliste = $Panel_Model->adminPanelUrunSon();
        $d = 0;
        foreach ($urunSonliste as $urunSonlistee) {
            $urunID[] = $urunSonlistee['siparis_ID'];
            $birUrunList[$d]["ID"] = $urunSonlistee['siparis_ID'];
            $birUrunList[$d]["Sehir"] = $urunSonlistee['siparis_sehir'];
            $explodeIlce = explode(" ", $urunSonlistee['siparis_ilce']);
            $birUrunList[$d]["Ilce"] = $explodeIlce[0];
            $explode = explode(" ", $urunSonlistee['siparis_girilmetarih']);
            $explodeTarih = explode("-", $explode[0]);
            $birUrunList[$d]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
            $birUrunList[$d]["TopTutar"] = $urunSonlistee['siparis_toplamtutar'];
            $birUrunList[$d]["Durum"] = $urunSonlistee['siparis_durum'];
            $d++;
        }

        $panelİslem[5] = $birUrunList;

        if (count($urunID)) {
            $uruniddizi = implode(',', $urunID);
        }

        $urunSonliste = $Panel_Model->adminPanelUrunSon($uruniddizi);



        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/home", $languagedeger, $panelİslem);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function UrunKategori() {
        $form = $this->load->otherClasses('Form');
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();


        $kategoriListe = $Panel_Model->adminKategorilistele();
        $b = 0;
        $c = 0;
        foreach ($kategoriListe as $kategoriListee) {
            if ($kategoriListee['kategori_UstID'] == 0) {//Üst Kategori Olanlar
                $kategorilistUst[$b]['ID'] = $kategoriListee['kategori_ID'];
                $kategorilistUst[$b]['Adi'] = $kategoriListee['kategori_Adi'];
                $kategorilistUst[$b]['Aktif'] = $kategoriListee['kategori_Aktiflik'];
                $kategorilistUst[$b]['Sira'] = $kategoriListee['kategori_Sira'];
                $kategorilistUst[$b]['Yazi'] = $kategoriListee['kategori_Yazi'];
                $b++;
            } else {
                $kategorilistAlt[$c]['ID'] = $kategoriListee['kategori_ID'];
                $kategorilistAlt[$c]['Adi'] = $kategoriListee['kategori_Adi'];
                $kategorilistAlt[$c]['Aktif'] = $kategoriListee['kategori_Aktiflik'];
                $kategorilistAlt[$c]['Sira'] = $kategoriListee['kategori_Sira'];
                $kategorilistAlt[$c]['UstID'] = $kategoriListee['kategori_UstID'];
                $kategorilistAlt[$c]['Yazi'] = $kategoriListee['kategori_Yazi'];
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
                    $kategoriAltSira[$x][$t]['Url'] = $form->turkce_kucult_tr($kategorilistAlt[$y]['Adi']);
                    $kategoriAltSira[$x][$t]['Aktif'] = $kategorilistAlt[$y]['Aktif'];
                    $kategoriAltSira[$x][$t]['Sira'] = $kategorilistAlt[$y]['Sira'];
                    $kategoriAltSira[$x][$t]['Yazi'] = $kategorilistAlt[$y]['Yazi'];
                    $t++;
                }
            }
        }
        $kategoridizi[1] = $kategorilistUst; //Üst Kategori
        $kategoridizi[2] = $kategoriAltSira; //Alt Kategori

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/urunkategori", $languagedeger, $kategoridizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Urun() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $kategoriListe = $Panel_Model->urunKategorilistele();
        $b = 0;
        foreach ($kategoriListe as $kategoriListee) {
            $kategorilistUst[$b]['ID'] = $kategoriListee['kategori_ID'];
            $kategorilistUst[$b]['Adi'] = $kategoriListee['kategori_Adi'];
            $kategorilistUst[$b]['Aktif'] = $kategoriListee['kategori_Aktiflik'];
            $kategorilistUst[$b]['Sira'] = $kategoriListee['kategori_Sira'];
            $kategorilistUst[$b]['Yazi'] = $kategoriListee['kategori_Yazi'];
            $kategorilistUst[$b]['UstID'] = $kategoriListee['kategori_UstID'];
            $b++;
        }


        $etiketListe = $Panel_Model->adminEtiketlistele();
        $a = 0;
        foreach ($etiketListe as $etiketListee) {
            $etiketlist[$a]['ID'] = $etiketListee['etiket_id'];
            $etiketlist[$a]['Adi'] = $etiketListee['etiket_adi'];
            $a++;
        }


        $urunListe = $Panel_Model->panelurunlistele();
        $c = 0;
        foreach ($urunListe as $urunListee) {
            $urunlist[$c]['ID'] = $urunListee['urun_ID'];
            $urunlist[$c]['KatID'] = $urunListee['urun_kategoriID'];
            $urunlist[$c]['KatAd'] = $urunListee['urun_kategoriAd'];
            $urunlist[$c]['Adi'] = $urunListee['urun_adi'];
            $urunlist[$c]['Aktif'] = $urunListee['urun_aktiflik'];
            $urunlist[$c]['Sira'] = $urunListee['urun_sira'];
            $urunlist[$c]['Kod'] = $urunListee['urun_kodu'];
            $urunlist[$c]['Kampanya'] = $urunListee['urun_kmpnyaid'];
            $urunlist[$c]['Yeni'] = $urunListee['urun_yeniurun'];
            $urunlist[$c]['Ek'] = $urunListee['urun_ekurun'];
            $urunlist[$c]['CokSatan'] = $urunListee['urun_coksatan'];
            $urunlist[$c]['HaftaUrun'] = $urunListee['urun_hafta'];
            $c++;
        }

        $urundizi[0] = $kategorilistUst;
        $urundizi[1] = $etiketlist;
        $urundizi[2] = $urunlist;


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/urun", $languagedeger, $urundizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Etiket() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $etiketListe = $Panel_Model->paneletiketlistele();
        $b = 0;
        foreach ($etiketListe as $etiketListee) {
            $etiketlist[$b]['ID'] = $etiketListee['etiket_id'];
            $etiketlist[$b]['Adi'] = $etiketListee['etiket_adi'];
            $etiketlist[$b]['Sira'] = $etiketListee['etiket_sira'];
            $etiketlist[$b]['Aktif'] = $etiketListee['etiket_aktiflik'];
            $b++;
        }


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/etiket", $languagedeger, $etiketlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Vitrin() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $vitrinListe = $Panel_Model->panelvitrinlistele();
        $v = 0;
        foreach ($vitrinListe as $vitrinListee) {
            $vitrinlist[$v]['ID'] = $vitrinListee['vitrin_ID'];
            $vitrinlist[$v]['Baslik'] = $vitrinListee['vitrin_baslik'];
            $vitrinlist[$v]['Aktif'] = $vitrinListee['vitrin_aktiflik'];
            $vitrinlist[$v]['Sira'] = $vitrinListee['vitrin_sira'];
            $v++;
        }


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/vitrin", $languagedeger, $vitrinlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function SabitIcerik() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $icerikListe = $Panel_Model->panelsabiticerikliste();
        $i = 0;
        foreach ($icerikListe as $icerikListee) {
            $iceriklist[$i]['ID'] = $icerikListee['sbt_id'];
            $iceriklist[$i]['Tel'] = $icerikListee['sbt_telefon'];
            $iceriklist[$i]['Fax'] = $icerikListee['sbt_fax'];
            $iceriklist[$i]['Adres'] = $icerikListee['sbt_adres'];
            $iceriklist[$i]['IFrame'] = $icerikListee['sbt_haritaiframe'];
            $iceriklist[$i]['IletMail'] = $icerikListee['sbt_iletisimmail'];
            $iceriklist[$i]['YMail2'] = $icerikListee['sbt_yonetmail2'];
            $iceriklist[$i]['YMail1'] = $icerikListee['sbt_yonetmail1'];
            $iceriklist[$i]['Face'] = $icerikListee['sbt_face'];
            $iceriklist[$i]['Twit'] = $icerikListee['sbt_twit'];
            $iceriklist[$i]['Instagram'] = $icerikListee['sbt_instag'];
            $iceriklist[$i]['GPlus'] = $icerikListee['sbt_gplus'];
            $i++;
        }


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/sabiticerik", $languagedeger, $iceriklist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function BlogYazi() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $blogListe = $Panel_Model->panelblogliste();
        $b = 0;
        foreach ($blogListe as $blogListee) {
            $bloglist[$b]['ID'] = $blogListee['blog_ID'];
            $bloglist[$b]['Baslik'] = $blogListee['blog_baslik'];
            $explode = explode(" ", $blogListee['blog_tarih']);
            $explodeTarih = explode("-", $explode[0]);
            $bloglist[$b]['Tarih'] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
            $bloglist[$b]['Aktif'] = $blogListee['blog_aktiflik'];
            $b++;
        }


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/blogyazi", $languagedeger, $bloglist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function SabitSayfa() {
        //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $sayfaListe = $Panel_Model->adminSayfalistele();
        $b = 0;
        $c = 0;
        foreach ($sayfaListe as $sayfaListee) {
            if ($sayfaListee['sayfa_UstID'] == 0) {//Üst Kategori Olanlar
                $sayfalistUst[$b]['ID'] = $sayfaListee['sabitsayfaid'];
                $sayfalistUst[$b]['Adi'] = $sayfaListee['sbtsayfa_Adi'];
                $sayfalistUst[$b]['Aktif'] = $sayfaListee['sbtsayfa_Aktiflik'];
                $sayfalistUst[$b]['Sira'] = $sayfaListee['sbtsayfa_Sira'];
                $b++;
            } else {
                $sayfalistAlt[$c]['ID'] = $sayfaListee['sabitsayfaid'];
                $sayfalistAlt[$c]['Adi'] = $sayfaListee['sbtsayfa_Adi'];
                $sayfalistAlt[$c]['Aktif'] = $sayfaListee['sbtsayfa_Aktiflik'];
                $sayfalistAlt[$c]['Sira'] = $sayfaListee['sbtsayfa_Sira'];
                $sayfalistAlt[$c]['UstID'] = $sayfaListee['sayfa_UstID'];
                $c++;
            }
        }
        //alt sayfaya göre üst sayfayı gruplama
        for ($x = 0; $x < count($sayfalistUst); $x++) {
            $t = 0;
            for ($y = 0; $y < count($sayfalistAlt); $y++) {
                if ($sayfalistUst[$x]['ID'] == $sayfalistAlt[$y]['UstID']) {
                    $sayfaAltSira[$x][$t]['ID'] = $sayfalistAlt[$y]['ID'];
                    $sayfaAltSira[$x][$t]['UstID'] = $sayfalistAlt[$y]['UstID'];
                    $sayfaAltSira[$x][$t]['Adi'] = $sayfalistAlt[$y]['Adi'];
                    $sayfaAltSira[$x][$t]['Aktif'] = $sayfalistAlt[$y]['Aktif'];
                    $sayfaAltSira[$x][$t]['Sira'] = $sayfalistAlt[$y]['Sira'];
                    $t++;
                }
            }
        }
        $sayfadizi[1] = $sayfalistUst; //Üst Syfa
        $sayfadizi[2] = $sayfaAltSira; //Alt Sayfa


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/sabitsayfa", $languagedeger, $sayfadizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Kampanya(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/kampanya", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Siparis(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/siparis", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Banka(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/banka", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Kargo(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/kargo", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Gonderimyeri(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/gonderimyer", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Gonderimnedeni(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/gonderimneden", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
    
    function Ililce(){
      //model bağlantısı
        $Panel_Model = $this->load->model("panel_model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();  
        
        
        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/ililce", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }
}

?>