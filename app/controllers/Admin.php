<?php

class Admin extends Controller {

    public function __construct() {
        if (Session::get("KRol") == 1) {
            parent::__construct();
        } else {
            header("Refresh:0; url=" . SITE_URL);
        }
    }

    public function index() {
        $this->Panel();
    }

    //daha önce login oldu ise
    function Panel() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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

        $toplamTutar = 0;
        $urunSiparisListe = $Panel_Model->adminPanelUrunSiparis();
        foreach ($urunSiparisListe as $urunSiparisListee) {
            $toplamTutar = $toplamTutar + $urunSiparisListee['siparis_toplamtutar'];
        }
        $panelİslem[3] = $toplamTutar;

        $urunKampyListe = $Panel_Model->adminPanelKampany();
        foreach ($urunKampyListe as $urunKampyListee) {
            $kmpnyCount = $urunKampyListee['total'];
        }
        $panelİslem[6] = $kmpnyCount;

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/home", $languagedeger, $panelİslem);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function UrunKategori() {
        $form = $this->load->otherClasses('Form');
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/urunkategori", $languagedeger, $kategoridizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Urun() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/urun", $languagedeger, $urundizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Etiket() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/etiket", $languagedeger, $etiketlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Vitrin() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/vitrin", $languagedeger, $vitrinlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function SabitIcerik() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $icerikListe = $Panel_Model->panelsabiticerikliste();
        $i = 0;
        foreach ($icerikListe as $icerikListee) {
            $iceriklist[$i]['ID'] = $icerikListee['sbt_id'];
            $iceriklist[$i]['UyeSoz'] = $icerikListee['sbt_uyeliksoz'];
            $iceriklist[$i]['HizmetSoz'] = $icerikListee['sbt_hzmtsoz'];
            $iceriklist[$i]['GizlilikSoz'] = $icerikListee['sbt_gzllksoz'];
            $iceriklist[$i]['MesafeliSoz'] = $icerikListee['sbt_mesafelistssoz'];
            $iceriklist[$i]['TeslimatSart'] = $icerikListee['sbt_tslmatsart'];
            $iceriklist[$i]['OnBilgiFormu'] = $icerikListee['sbt_onbilgilendirmeform'];
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
            $iceriklist[$i]['Logo'] = $icerikListee['sbt_logo'];
            $i++;
        }


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/sabiticerik", $languagedeger, $iceriklist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function BlogYazi() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/blogyazi", $languagedeger, $bloglist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function SabitSayfa() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

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
                $sayfalistAlt[$c]['ID'] = $sayfaListee ['sabitsayfaid'];
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
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/sabitsayfa", $languagedeger, $sayfadizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Kampanya() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $array = array();
        $arrayKategori = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $kampanyaListe = $Panel_Model->adminkampanyalistele();
        $k = 0;
        foreach ($kampanyaListe as $kampanyaListee) {
            error_log("irdi");
            $kampanyalist[$k]['ID'] = $kampanyaListee['kampanya_ID'];
            $kampanyalist[$k]['Baslik'] = $kampanyaListee['kampanya_baslik'];
            $kampanyalist[$k]['Aktif'] = $kampanyaListee['kampanya_aktiflik'];
            $kampanyalist[$k]['Yuzde'] = $kampanyaListee['kampanya_indirimyuzde'];
            if ($kampanyalist[$k]['Aktif'] == 1) {
                $arrayKategori[] = $kampanyaListee['kampanya_kategori'];
            }
            $k++;
        }
        $array[0] = $kampanyalist;
        $kampKatDizi = implode(',', $arrayKategori);
        //ek ürün daha önce kullanılmış mı onu ayırmak için
        if (in_array("-1", $arrayKategori)) {
            $array[2] = "1";
        } else {
            $array[2] = "0";
        }

        $kategoriListe = $Panel_Model->urunKampKategorilistele($kampKatDizi);
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

        $array[1] = $kategorilistUst;

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/kampanya", $languagedeger, $array);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Siparis() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparis = array();
        $siparisCount = array();
        $siparisListe = $Panel_Model->siparisListele();
        $s = 0;
        $bekleyensiparis = 0;
        foreach ($siparisListe as $siparisListee) {
            $siparislist[$s]['ID'] = $siparisListee ['siparis_ID'];
            $siparislist[$s]['Ad'] = $siparisListee['siparis_gonderenAdSoyad'];
            $siparislist[$s]['No'] = $siparisListee ['siparis_No'];
            $siparislist[$s]['Tip'] = $siparisListee['siparis_gonderenkur'];
            $explode = explode(" ", $siparisListee['siparis_girilmetarih']);
            $explodeTarih = explode("-", $explode[0]);
            $siparislist[$s]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
            if ($siparisListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
            $siparislist[$s]["Durum"] = $siparisListee['siparis_durum'];
            $s++;
        }
        $siparis[0] = $siparislist;

        $kargoListe = $Panel_Model->sipariskargoListele();
        $k = 0;
        foreach ($kargoListe as $kargoListee) {
            $kargolist[$k]['ID'] = $kargoListee['kargofirma_id'];
            $kargolist[$k]['Adi'] = $kargoListee['kargofirma_adi'];
            $k++;
        } $siparis[1] = $kargolist;

        $siparis[2] = $bekleyensiparis;
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparislist);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/siparis", $languagedeger, $siparis);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function BekleyenSiparis() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparis = array();
        $siparisCount = array();
        $siparisListe = $Panel_Model->siparisBekleyenListele();
        $s = 0;
        $bekleyensiparis = 0;
        foreach ($siparisListe as $siparisListee) {
            $siparislist[$s]['ID'] = $siparisListee ['siparis_ID'];
            $siparislist[$s]['Ad'] = $siparisListee['siparis_gonderenAdSoyad'];
            $siparislist[$s]['No'] = $siparisListee ['siparis_No'];
            $siparislist[$s]['Tip'] = $siparisListee['siparis_gonderenkur'];
            $explode = explode(" ", $siparisListee['siparis_girilmetarih']);
            $explodeTarih = explode("-", $explode[0]);
            $siparislist[$s]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
            $bekleyensiparis = $bekleyensiparis + 1;
            $siparislist[$s]["Durum"] = $siparisListee['siparis_durum'];
            $s++;
        }
        $siparis[0] = $siparislist;

        $kargoListe = $Panel_Model->sipariskargoListele();
        $k = 0;
        foreach ($kargoListe as $kargoListee) {
            $kargolist[$k]['ID'] = $kargoListee['kargofirma_id'];
            $kargolist[$k]['Adi'] = $kargoListee['kargofirma_adi'];
            $k++;
        } $siparis[1] = $kargolist;

        $siparis[2] = $bekleyensiparis;
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparislist);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/bekleyensiparis", $languagedeger, $siparis);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Banka() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);


        $bankaListe = $Panel_Model->bankaListele();
        $b = 0;
        foreach ($bankaListe as $bankaListee) {
            $bankalist[$b]['ID'] = $bankaListee['banka_ID'];
            $bankalist[$b]['Adi'] = $bankaListee['banka_adi'];
            $bankalist[$b]['Sube'] = $bankaListee['banka_sube'];
            $bankalist[$b]['HesapNo'] = $bankaListee['banka_hesapno'];
            $bankalist[$b]['IbanNo'] = $bankaListee['banka_ibanno'];
            $bankalist[$b]['Alici'] = $bankaListee['banka_alici'];
            $bankalist[$b]['Aktif'] = $bankaListee['banka_aktif'];
            $b++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/banka", $languagedeger, $bankalist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Kargo() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $kargoListe = $Panel_Model->kargoListele();
        $k = 0;
        foreach ($kargoListe as $kargoListee) {
            $kargolist[$k]['ID'] = $kargoListee['kargofirma_id'];
            $kargolist[$k]['Adi'] = $kargoListee['kargofirma_adi'];
            $kargolist[$k] ['Aktif'] = $kargoListee[
                    'kargofirma_aktiflik'];
            $kargolist[$k]['Aciklama'] = $kargoListee['kargofirma_aciklama'];
            $k++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/kargo", $languagedeger, $kargolist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Gonderimyeri() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);


        $yerListe = $Panel_Model->yerListele();
        $y = 0;
        foreach ($yerListe as $yerListee) {
            $yerlist[$y]['ID'] = $yerListee['gonderimyeri_ID'];
            $yerlist[$y]['Adi'] = $yerListee['gonderimyeri_adi'];
            $yerlist[$y]['Aktif'] = $yerListee['gonderimyeri_aktif'];
            $y++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/gonderimyer", $languagedeger, $yerlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Gonderimnedeni() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $nedenListe = $Panel_Model->nedenListele();
        $n = 0;
        foreach ($nedenListe as $nedenListee) {
            $nedenlist[$n]['ID'] = $nedenListee['gonderimnedeni_ID'];
            $nedenlist[$n]['Adi'] = $nedenListee[
                    'gonderimnedeni_adi'];
            $nedenlist[$n]['Aktif'] = $nedenListee['gonderimnedeni_aktif'];
            $n++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/gonderimneden", $languagedeger, $nedenlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Ililce() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        //il listele
        $ilListe = $Panel_Model->adminIllistele();
        $a = 0;
        foreach ($ilListe as $ilListee) {
            $illist[$a]['ID'] = $ilListee['sehir_id'];
            $illist[$a]['Adi'] = $ilListee['sehir_adi'];
            $illist[$a]['Aktif'] = $ilListee['sehir_aktiflik'];
            $a++;
        }
        //ilçe listele
        $ilceListe = $Panel_Model->adminIlcelistele();
        $b = 0;
        foreach ($ilceListe as $ilceListee) {
            $ilcelist[$b]['ID'] = $ilceListee['ilce_id'];

            $ilcelist[$b]['UstID'] = $ilceListee['ilce_sehirid'];
            $ilcelist[$b]['Adi'] = $ilceListee['ilce_adi'];
            $ilcelist[$b]['Aktif'] = $ilceListee['ilce_aktiflik'];
            $ilcelist[$b]['EkUcret'] = $ilceListee['ilce_ekucret'];
            $b++;
        }

        //alt kategorileri üst kategoriye göre gruplama
        for ($x = 0; $x < count($illist); $x++) {
            $t = 0;
            for ($y = 0; $y < count($ilcelist); $y++) {
                if ($illist[$x]['ID'] == $ilcelist[$y]['UstID']) {
                    $ilceAltSira[$x][$t]['ID'] = $ilcelist[$y]['ID'];
                    $ilceAltSira[$x][$t]['UstID'] = $ilcelist[$y]['UstID'];
                    $ilceAltSira[$x][$t]['Adi'] = $ilcelist[$y]['Adi'];
                    $ilceAltSira[$x][$t]['Aktif'] = $ilcelist[$y]['Aktif'];
                    $ilceAltSira[$x][$t]['EkUcret'] = $ilcelist[$y]['EkUcret'];
                    $t++;
                }
            }
        }
        $ililcedizi[1] = $illist; //Üst Kategori
        $ililcedizi[2] = $ilceAltSira; //Alt Kategori

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/ililce", $languagedeger, $ililcedizi);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Kurumsaluye() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $kuyeListe = $Panel_Model->kurumsalUyeListele();
        $ku = 0;
        foreach ($kuyeListe as $kuyeListee) {
            $kuyelist[$ku]['ID'] = $kuyeListee['kullanici_id'];
            $kuyelist[$ku]['Adi'] = $kuyeListee['kullanici_adSoyad'];
            $kuyelist[$ku]['EPosta'] = $kuyeListee['kullanici_eposta'];
            $kuyelist[$ku]['Tel'] = $kuyeListee['kullanici_kurumtel'];
            $ku++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/kurumsaluye", $languagedeger, $kuyelist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Bireyseluye() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);

        $buyeListe = $Panel_Model->bireyselUyeListele();
        $bu = 0;
        foreach ($buyeListe as $buyeListee) {
            $buyelist[$bu]['ID'] = $buyeListee['kullanici_id'];
            $buyelist[$bu]['Adi'] = $buyeListee['kullanici_adSoyad'];
            $buyelist[$bu]['EPosta'] = $buyeListee['kullanici_eposta'];
            $buyelist[$bu]['Tel'] = $buyeListee['kullanici_kurumtel'];
            $bu++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/bireyseluye", $languagedeger, $buyelist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Siparismail() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);


        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger);
        $this->load->view("Template_BackEnd/siparismailsablon", $languagedeger);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

    function Iletisim() {
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();
        $siparisCount = array();
        $siparisCountListe = $Panel_Model->siparisCountListele();
        $bekleyensiparis = 0;
        foreach ($siparisCountListe as $siparisCountListee) {
            if ($siparisCountListee['siparis_durum'] == 0) {
                $bekleyensiparis = $bekleyensiparis + 1;
            }
        }
        $siparisCount[0] = $bekleyensiparis;
        $siparisCount[1] = count($siparisCountListe);

        $kampanyaCountListe = $Panel_Model->kampanyaCountListele();
        $siparisCount[2] = count($kampanyaCountListe);


        $iletisimListe = $Panel_Model->iletisimListele();
        $i = 0;
        foreach ($iletisimListe as $iletisimListee) {
            $iletisimlist[$i]['ID'] = $iletisimListee['iletisim_ID'];
            $iletisimlist[$i]['Ad'] = $iletisimListee['iletisim_AdSoyad'];
            $iletisimlist[$i]['Konu'] = $iletisimListee['iletisim_konu'];
            $explodeBaslama = explode(" ", $iletisimListee['iletisim_tarih']);
            $explodeBasTarih = explode("-", $explodeBaslama[0]);
            $iletisimlist[$i]['Tarih'] = $explodeBasTarih[2] . '/' . $explodeBasTarih[1] . '/' . $explodeBasTarih[0];
            $i++;
        }

        $this->load->view("Template_BackEnd/header", $languagedeger);
        $this->load->view("Template_BackEnd/left", $languagedeger, $siparisCount);
        $this->load->view("Template_BackEnd/contact", $languagedeger, $iletisimlist);
        $this->load->view("Template_BackEnd/footer", $languagedeger);
    }

}

?>
