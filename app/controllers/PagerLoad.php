<?php

class PagerLoad extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $gelenurl = isset($_GET["url"]) ? $_GET["url"] : null;
        if ($gelenurl != null) {
            $url = rtrim($gelenurl, "/");
            $url = explode("-", $url);
            $count = count($url);
        } else {
            unset($url);
        }
        //gelen url /kategori şeklinde olmaktadır.Yani Count sıfır ise
        if ($gelenurl == "ek-urunler") {
            $this->ekurun();
        } else if ($url[0] == "sayfa") {
            $newurl = substr($gelenurl, 6);
            $this->pager($newurl);
        } else if ($url[0] == "blog") {
            if (isset($url[1])) {
                $newurl = substr($gelenurl, 5);
                $this->blogPage($newurl);
            } else {
                $this->blog();
            }
        } else if ($gelenurl == "kampanyali-urunler") {
            $this->kampanyaliurun();
        } else if ($gelenurl == "coksatan-urunler") {
            $this->coksatan();
        } else {
            if (ereg("[0-9]", $url[$count - 1])) {//sayı varsa son halinde üründür, ürün kodundan
                $kod = $url[$count - 1];
                $this->urun($kod);
            } else {
                $this->kategori($gelenurl);
            }
        }
    }

    function kategori($gelenurl) {
        $form = $this->load->otherClasses('Form');
        //model bağlantısı
        $Panel_Model = $this->load->model("Panel_Model");
        $formlanguage = $this->load->multilanguage("tr");
        $languagedeger = $formlanguage->multilanguage();

        $secimListe = $Panel_Model->secimlistele($gelenurl);
        foreach ($secimListe as $secimListee) {
            $secimlist['Ad'] = $secimListee['kategoriAd'];
            $secimlist['ID'] = $secimListee['kategoriID'];
            $secimlist['Tip'] = $secimListee['kategoriTip'];
        }
        if ($secimlist['Tip'] == 0) {//Etiket Kategorileri
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
                    $kategorilistAlt[$c]['Url'] = $kategoriListee['kategori_BenzAd'];
                    $kategorilistAlt[$c]['UstID'] = $kategoriListee['kategori_UstID'];
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
            //normal kategori listeleme
            $kategoriListe = $Panel_Model->kategorietiketdetaylistele($secimlist['ID']);
            foreach ($kategoriListe as $kategoriListee) {
                $kategorilist[0][0]['katID'] = $kategoriListee['etiket_id'];
                $kategorilist[0][0]['katTip'] = 0;
                $kategorilist[0][0]['katAd'] = $kategoriListee['etiket_adi'];
                $kategorilist[0][0]['katYazi'] = $kategoriListee['etiket_yazi'];
            }

            //etiket-ürün id listeleme
            $etiketurunid = $Panel_Model->kategorietiketurunid($secimlist['ID']);
            foreach ($etiketurunid as $etiketurunidd) {
                $urunId[] = $etiketurunidd['urunetiket_UrunID'];
            }
            if (count($urunId) > 0) {
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
                                $kategorilist[1][$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                                $kategorilist[1][$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                            }
                            $kategorilist[1][$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                            $kategorilist[1][$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                            $kategorilist[1][$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                            $kategorilist[1][$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                            $kategorilist[1][$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                            $kategorilist[1][$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                        }
                        $ku++;
                    }
                } else {
                    foreach ($kategoriurunListe as $kategoriurunListee) {
                        $kategorilist[1][$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                        $kategorilist[1][$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                        $kategorilist[1][$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                        $kategorilist[1][$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                        $kategorilist[1][$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                        $kategorilist[1][$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                        $ku++;
                    }
                }
            }
        } else if ($secimlist['Tip'] == 1) {//normal kategoriler
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
            //normal kategori listeleme
            $kategoriListe = $Panel_Model->kategoridetaylistele($secimlist['ID']);
            foreach ($kategoriListe as $kategoriListee) {
                $kategorilist[0][0]['katID'] = $kategoriListee['kategori_ID'];
                $kategorilist[0][0]['katTip'] = 1;
                $kategorilist[0][0]['katAd'] = $kategoriListee['kategori_Adi'];
                $kategorilist[0][0]['katYazi'] = $kategoriListee['kategori_Yazi'];
                $kategorilist[0][0]['katResim'] = $kategoriListee['kategori_Resim'];
                $kategorilist[0][0]['katKmpnya'] = $kategoriListee['urun_kmpnyaid'];
            }

            //kategoriye ait ürünleri listeleme
            $kategoriurunListe = $Panel_Model->kategoriurunlistele($secimlist['ID']);

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
                            $kategorilist[1][$ku]['KID'] = $urunkampanya[$kmp]['ID'];
                            $kategorilist[1][$ku]['KYuzde'] = $urunkampanya[$kmp]['Yuzde'];
                        }
                        $kategorilist[1][$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                        $kategorilist[1][$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                        $kategorilist[1][$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                        $kategorilist[1][$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                        $kategorilist[1][$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                        $kategorilist[1][$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                    }
                    $ku++;
                }
            } else {
                foreach ($kategoriurunListe as $kategoriurunListee) {
                    $kategorilist[1][$ku]['urunID'] = $kategoriurunListee['urun_ID'];
                    $kategorilist[1][$ku]['urunKod'] = $kategoriurunListee['urun_kodu'];
                    $kategorilist[1][$ku]['urunFiyat'] = $kategoriurunListee['urun_fiyat'];
                    $kategorilist[1][$ku]['urunResim'] = $kategoriurunListee['urun_anaresim'];
                    $kategorilist[1][$ku]['urunAd'] = $kategoriurunListee['urun_adi'];
                    $kategorilist[1][$ku]['urunUrl'] = $kategoriurunListee['urun_benzad'] . "-" . $kategoriurunListee['urun_benzersizkod'];
                    $ku++;
                }
            }
        } else {//kampanya
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
            //kampanyalı kategori listeleme
            $katkampanyaListe = $Panel_Model->katkampanyadetaylistele($gelenurl, date("Y/m/d"));
            foreach ($katkampanyaListe as $katkampanyaListee) {
                $kategorilist[0][0]['katID'] = $katkampanyaListee['kampanya_ID'];
                $kategorilist[0][0]['katTip'] = 2;
                $kategorilist[0][0]['katAd'] = $katkampanyaListee['kampanya_baslik'];
                $kategorilist[0][0]['katYazi'] = $katkampanyaListee['kampanya_yazi'];
                $kategorilist[0][0]['katResim'] = $katkampanyaListee['kampanya_resim'];
                $kategorilist[0][0]['katYuzde'] = $katkampanyaListee['kampanya_indirimyuzde'];
            }
            if (count($kategorilist[0][0]['katID']) > 0) {
                $kmpurunListe = $Panel_Model->katkampanyaurunlistele($kategorilist[0][0]['katID']);
                $ku = 0;
                foreach ($kmpurunListe as $kmpurunListee) {
                    $kategorilist[1][$ku]['KID'] = $secimlist['ID'];
                    $kategorilist[1][$ku]['KYuzde'] = $kategorilist[0][0]['katYuzde'];
                    $kategorilist[1][$ku]['urunID'] = $kmpurunListee['urun_ID'];
                    $kategorilist[1][$ku]['urunKod'] = $kmpurunListee['urun_kodu'];
                    $kategorilist[1][$ku]['urunFiyat'] = $kmpurunListee['urun_fiyat'];
                    $kategorilist[1][$ku]['urunResim'] = $kmpurunListee['urun_anaresim'];
                    $kategorilist[1][$ku]['urunAd'] = $kmpurunListee['urun_adi'];
                    $kategorilist[1][$ku]['urunUrl'] = $kmpurunListee['urun_benzad'] . "-" . $kmpurunListee['urun_benzersizkod'];
                    $ku++;
                }
            }
        }



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
                $fotkategorilistUst[$fb]['Url'] = $fotkategoriListee['sbtsayfa_bnzrszAd'];
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/urunler", $languagedeger, $kategorilist);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function urun($kod) {
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
        //kategoriye ait ürünleri listeleme
        $urunListe = $Panel_Model->urundetaylistele($kod);

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
                $urunlist[0]['KID'] = $urunkampanya[0]['ID'];
                $urunlist[0]['KYuzde'] = $urunkampanya[0]['Yuzde'];
                $urunlist[0]['urunID'] = $urunListee['urun_ID'];
                $urunlist[0]['urunKod'] = $urunListee['urun_kodu'];
                $urunlist[0]['urunAciklama'] = $urunListee['urun_aciklama'];
                $urunlist[0]['urunFiyat'] = $urunListee['urun_fiyat'];
                $urunlist[0]['urunResim'] = $urunListee['urun_anaresim'];
                $urunlist[0]['urunAd'] = $urunListee['urun_adi'];
                $urunlist[0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
            }
        } else {
            foreach ($urunListe as $urunListee) {
                $urunlist[0]['urunID'] = $urunListee['urun_ID'];
                $urunlist[0]['urunKod'] = $urunListee['urun_kodu'];
                $urunlist[0]['urunAciklama'] = $urunListee['urun_aciklama'];
                $urunlist[0]['urunFiyat'] = $urunListee['urun_fiyat'];
                $urunlist[0]['urunResim'] = $urunListee['urun_anaresim'];
                $urunlist[0]['urunAd'] = $urunListee['urun_adi'];
                $urunlist[0]['urunUrl'] = $urunListee['urun_benzad'] . "-" . $urunListee['urun_benzersizkod'];
            }
        }


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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/urundetay", $languagedeger, $urunlist);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function ekurun() {
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
            $vitrinlist[$vi]['Url'] = $vitrinListee['vitrin_url'];
            $vitrinlist[$vi]['AltBaslik'] = $vitrinListee['vitrin_altbaslik'];
            $vitrinlist[$vi]['BtnYazi'] = $vitrinListee['vitrin_buttonyazi'];
            $vi++;
        }

        $homedizi[4] = $vitrinlist; //Virin Listesi
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
                        $ekurunlist[0][$uek]['EkID'] = $ekurunListee['urun_ID'];
                        $ekurunlist[0][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                        $ekurunlist[0][$uek]['NormalEkFiyat'] = $ekurunListee['urun_fiyat'];
                        $ekurunlist[0][$uek]['EkFiyat'] = round($ekurunListee['urun_fiyat'] - (($ekurunListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                        $ekurunlist[0][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                        $ekurunlist[0][$uek]['EkKmpID'] = $ekurunkampanya[$ku]['ID'];
                        $ekurunlist[0][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                        $ekurunlist[0][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
                    }
                }
            } else {
                $ekurunlist[0][$uek]['EkID'] = $ekurunListee['urun_ID'];
                $ekurunlist[0][$uek]['EkKod'] = $ekurunListee['urun_kodu'];
                $ekurunlist[0][$uek]['NormalEkFiyat'] = $ekurunListee['urun_fiyat'];
                $ekurunlist[0][$uek]['EkAdi'] = $ekurunListee['urun_adi'];
                $ekurunlist[0][$uek]['EkResim'] = $ekurunListee['urun_anaresim'];
                $ekurunlist[0][$uek]['EkUrl'] = $ekurunListee['urun_benzad'] . "-" . $ekurunListee['urun_benzersizkod'];
            }
            $uek++;
        }

        $homedizi[5] = $ekurunlist; //Virin Listesi
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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist; //etiket listesi

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/ekurunhome", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function kampanyaliurun() {
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
            $vitrinlist[$vi]['Url'] = $vitrinListee['vitrin_url'];
            $vitrinlist[$vi]['AltBaslik'] = $vitrinListee['vitrin_altbaslik'];
            $vitrinlist[$vi]['BtnYazi'] = $vitrinListee['vitrin_buttonyazi'];
            $vi++;
        }

        $homedizi[4] = $vitrinlist; //Virin Listesi
        //kampanyalı ürünleri listeleme
        $kampanyaliurunListe = $Panel_Model->kampanyaliurunlistele();
        //kampanyalı ürünlerin listesi
        foreach ($kampanyaliurunListe as $kampanyaliurunListee) {
            if ($kampanyaliurunListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                $ekkampanyaId[] = $kampanyaliurunListee['urun_kmpnyaid'];
            }
        }
        //kampanyalı ürünler için 
        if (count($ekkampanyaId) > 0) {
            $kampanyadizi = implode(',', $ekkampanyaId);
            $ekkampanyalar = $Panel_Model->urunkampanyalistele($kampanyadizi, date("Y/m/d"));
            $kmpny = 0;
            foreach ($ekkampanyalar as $ekkampanyalarr) {
                $urunkampanya[$kmpny]['ID'] = $ekkampanyalarr['kampanya_ID'];
                $urunkampanya[$kmpny]['Yuzde'] = $ekkampanyalarr['kampanya_indirimyuzde'];
                $kmpny++;
            }
        }

        $uk = 0;
        foreach ($kampanyaliurunListe as $kampanyaliurunListee) {
            for ($ku = 0; $ku < count($urunkampanya); $ku++) {
                if ($urunkampanya[$ku]['ID'] == $kampanyaliurunListee['urun_kmpnyaid']) {
                    $kampanyaurunlist[0][$uk]['KmpnyaID'] = $kampanyaliurunListee['urun_ID'];
                    $kampanyaurunlist[0][$uk]['KmpnyaKod'] = $kampanyaliurunListee['urun_kodu'];
                    $kampanyaurunlist[0][$uk]['NormalEkFiyat'] = $kampanyaliurunListee['urun_fiyat'];
                    $kampanyaurunlist[0][$uk]['KmpnyaFiyat'] = round($kampanyaliurunListee['urun_fiyat'] - (($kampanyaliurunListee['urun_fiyat'] * $urunkampanya[$ku]['Yuzde']) / 100));
                    $kampanyaurunlist[0][$uk]['KmpnyaAdi'] = $kampanyaliurunListee['urun_adi'];
                    $kampanyaurunlist[0][$uk]['KmpnyaKmpID'] = $urunkampanya[$ku]['ID'];
                    $kampanyaurunlist[0][$uk]['KmpnyaResim'] = $kampanyaliurunListee['urun_anaresim'];
                    $kampanyaurunlist[0][$uk]['KmpnyaUrl'] = $kampanyaliurunListee['urun_benzad'] . "-" . $kampanyaliurunListee['urun_benzersizkod'];
                }
            }
            $uk++;
        }

        $homedizi[5] = $kampanyaurunlist; //ürün Listesi
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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist; //etiket listesi

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/kampanyaliurun", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function coksatan() {
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
            $vitrinlist[$vi]['Url'] = $vitrinListee['vitrin_url'];
            $vitrinlist[$vi]['AltBaslik'] = $vitrinListee['vitrin_altbaslik'];
            $vitrinlist[$vi]['BtnYazi'] = $vitrinListee['vitrin_buttonyazi'];
            $vi++;
        }

        $homedizi[4] = $vitrinlist; //Virin Listesi
        //çok satan ürünleri listeleme
        $coksatanListe = $Panel_Model->coksatanurunlistele();
        //kampanyalı ürünlerin listesi
        foreach ($coksatanListe as $coksatanListee) {
            if ($coksatanListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                $ekkampanyaId[] = $coksatanListee['urun_kmpnyaid'];
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

        $uc = 0;
        foreach ($coksatanListe as $coksatanListee) {
            if ($coksatanListee['urun_kmpnyaid'] != 0) {//kampanyalı ürünler
                for ($ku = 0; $ku < count($ekurunkampanya); $ku++) {
                    if ($ekurunkampanya[$ku]['ID'] == $coksatanListee['urun_kmpnyaid']) {
                        $coksatanlist[0][$uc]['EkID'] = $coksatanListee['urun_ID'];
                        $coksatanlist[0][$uc]['EkKod'] = $coksatanListee['urun_kodu'];
                        $coksatanlist[0][$uc]['NormalEkFiyat'] = $coksatanListee['urun_fiyat'];
                        $coksatanlist[0][$uc]['EkFiyat'] = round($coksatanListee['urun_fiyat'] - (($coksatanListee['urun_fiyat'] * $ekurunkampanya[$ku]['Yuzde']) / 100));
                        $coksatanlist[0][$uc]['EkAdi'] = $coksatanListee['urun_adi'];
                        $coksatanlist[0][$uc]['EkKmpID'] = $ekurunkampanya[$ku]['ID'];
                        $coksatanlist[0][$uc]['EkResim'] = $coksatanListee['urun_anaresim'];
                        $coksatanlist[0][$uc]['EkUrl'] = $coksatanListee['urun_benzad'] . "-" . $coksatanListee['urun_benzersizkod'];
                    }
                }
            } else {
                $coksatanlist[0][$uc]['EkID'] = $coksatanListee['urun_ID'];
                $coksatanlist[0][$uc]['EkKod'] = $coksatanListee['urun_kodu'];
                $coksatanlist[0][$uc]['NormalEkFiyat'] = $coksatanListee['urun_fiyat'];
                $coksatanlist[0][$uc]['EkAdi'] = $coksatanListee['urun_adi'];
                $coksatanlist[0][$uc]['EkResim'] = $coksatanListee['urun_anaresim'];
                $coksatanlist[0][$uc]['EkUrl'] = $coksatanListee['urun_benzad'] . "-" . $coksatanListee['urun_benzersizkod'];
            }
            $uc++;
        }

        $homedizi[5] = $coksatanlist; //Virin Listesi
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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist; //etiket listesi

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/coksatanurun", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function pager($newurl) {
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
        //ürün içerik listeleme
        $sayfaicerikListe = $Panel_Model->sabitsayfaicerik($newurl);
        foreach ($sayfaicerikListe as $sayfaicerikListee) {
            $syfaIcerik[0]['ID'] = $sayfaicerikListee['sabitsayfaid'];
            $syfaIcerik[0]['Adi'] = $sayfaicerikListee['sbtsayfa_Adi'];
            $syfaIcerik[0]['Resim'] = $sayfaicerikListee['sayfa_Resim'];
            $syfaIcerik[0]['Yazi'] = $sayfaicerikListee['sayfa_Yazi'];
        }

        $homedizi[9] = $syfaIcerik;

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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/staticpage", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function blogPage($newurl) {
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
        //Footer Dinamik Bilgiler
        //kategorileri listeleme
        $fotkategoriListe = $Panel_Model->footerkategorilistele();
        $fb = 0;
        $fc = 0;
        foreach ($fotkategoriListe as $fotkategoriListee) {
            if ($fotkategoriListee['sayfa_UstID'] == 0) {//Footer Üst Kategori Olanlar
                $fotkategorilistUst[$fb]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistUst[$fb]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fotkategorilistUst[$fb]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
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
        ////sabit içerikleri listeleme
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
        //blogları listeleme
        $blogYilListe = $Panel_Model->blogicerikYil();
        $blogYil = 0;
        foreach ($blogYilListe as $blogYilListee) {
            $bloggerYil[$blogYil]['ID'] = $blogYilListee['blog_ID'];
            $bloggerYil[$blogYil]['Yil'] = $blogYilListee['blog_yil'];
            $blogYil++;
        }

        //blogları listeleme
        $blogAyListe = $Panel_Model->blogicerikAy();
        $blogAy = 0;
        for ($v = 0; $v < count($bloggerYil); $v++) {
            foreach ($blogAyListe as $blogAyListee) {
                if ($blogAyListee['blog_yil'] == $bloggerYil[$v]['Yil']) {
                    $bloggerYilAy[$blogAy]['Ay'] = $blogAyListee['blog_ay'];
                    $bloggerYilAy[$blogAy]['Yil'] = $blogAyListee['blog_yil'];
                    $blogAy++;
                }
            }
        }

        $blogListe = $Panel_Model->blogicerik();
        $y = 0;
        foreach ($blogListe as $blogListee) {
            $blogIcerik[$y]['ID'] = $blogListee['blog_ID'];
            $blogIcerik[$y]['Baslik'] = $blogListee['blog_baslik'];
            $blogIcerik[$y]['Url'] = "blog-" . $blogListee['blog_benzersizbaslik'];
            $blogIcerik[$y]['Yazi'] = $blogListee['blog_yazi'];
            $bolunmus = explode(" ", $blogListee['blog_tarih']);
            $newtarihex = explode("-", $bolunmus[0]);
            $blogIcerik[$y]['Tarih'] = $newtarihex[2] . '/' . $newtarihex[1] . '/' . $newtarihex[0];
            $blogIcerik[$y]['Saat'] = $bolunmus[1];
            $blogIcerik[$y]['Resim'] = $blogListee['blog_resim'];
            $y++;
        }

        //gruplama
        for ($a = 0; $a < count($bloggerYilAy); $a++) {
            $b = 0;
            foreach ($blogListe as $blogListee) {
                if ($bloggerYilAy[$a]['Ay'] == $blogListee['blog_ay']) {
                    $bloggerGrup[$a][$b]['ID'] = $blogListee['blog_ID'];
                    $bloggerGrup[$a][$b]['Baslik'] = $blogListee['blog_baslik'];
                    $bloggerGrup[$a][$b]['Url'] = "blog-" . $blogListee['blog_benzersizbaslik'];
                    $bloggerGrup[$a][$b]['Ay'] = $form->ayogrenme($blogListee['blog_ay']);
                    $bloggerGrup[$a][$b]['Yil'] = $blogListee['blog_yil'];
                    $b++;
                }
            }
        }


        $blogtekilListe = $Panel_Model->blogtekilicerik($newurl);
        foreach ($blogtekilListe as $blogtekilListee) {
            $blogTekIcerik[0]['ID'] = $blogtekilListee['blog_ID'];
            $blogTekIcerik[0]['Baslik'] = $blogtekilListee['blog_baslik'];
            $blogTekIcerik[0]['Url'] = "blog-" . $blogListee['blog_benzersizbaslik'];
            $blogTekIcerik[0]['Yazi'] = $blogtekilListee['blog_yazi'];
            $bolunmus = explode(" ", $blogtekilListee['blog_tarih']);
            $newtarihex = explode("-", $bolunmus[0]);
            $blogTekIcerik[0]['Tarih'] = $newtarihex[2] . '/' . $newtarihex[1] . '/' . $newtarihex[0];
            $blogTekIcerik[0]['Saat'] = $bolunmus[1];
            $blogTekIcerik[0]['Resim'] = $blogtekilListee['blog_resim'];
        }

        $blogger[0] = $blogTekIcerik;
        $blogger[1] = $bloggerGrup;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/blogpost", $languagedeger, $blogger);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

    function blog() {
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
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
                $fb++;
            } else {
                $fotkategorilistAlt[$fc]['ID'] = $fotkategoriListee['sabitsayfaid'];
                $fotkategorilistAlt[$fc]['Adi'] = $fotkategoriListee['sbtsayfa_Adi'];
                $fotkategorilistAlt[$fc]['Sira'] = $fotkategoriListee['sbtsayfa_Sira'];
                $fotkategorilistAlt[$fc]['UstID'] = $fotkategoriListee['sayfa_UstID'];
                if ($fotkategoriListee['sbtsayfa_bnzrszAd'] != "ozel-odeme") {
                    $fotkategorilistAlt[$fc]['Url'] = "sayfa-" . $fotkategoriListee['sbtsayfa_bnzrszAd'];
                } else {
                    $fotkategorilistAlt[$fc]['Url'] = "Order/DirectPayment";
                }
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
            $iceriklist['logo'] = $icerikListe['sbt_logo'];
        }
        $homedizi[8] = $iceriklist; //etiket listesi
        //blogları listeleme
        $blogYilListe = $Panel_Model->blogicerikYil();
        $blogYil = 0;
        foreach ($blogYilListe as $blogYilListee) {
            $bloggerYil[$blogYil]['ID'] = $blogYilListee['blog_ID'];
            $bloggerYil[$blogYil]['Yil'] = $blogYilListee['blog_yil'];
            $blogYil++;
        }

        //blogları listeleme
        $blogAyListe = $Panel_Model->blogicerikAy();
        $blogAy = 0;
        for ($v = 0; $v < count($bloggerYil); $v++) {
            foreach ($blogAyListe as $blogAyListee) {
                if ($blogAyListee['blog_yil'] == $bloggerYil[$v]['Yil']) {
                    $bloggerYilAy[$blogAy]['Ay'] = $blogAyListee['blog_ay'];
                    $bloggerYilAy[$blogAy]['Yil'] = $blogAyListee['blog_yil'];
                    $blogAy++;
                }
            }
        }

        $blogListe = $Panel_Model->blogicerik();
        $y = 0;
        foreach ($blogListe as $blogListee) {
            $blogIcerik[$y]['ID'] = $blogListee['blog_ID'];
            $blogIcerik[$y]['Baslik'] = $blogListee['blog_baslik'];
            $blogIcerik[$y]['Url'] = "blog-" . $blogListee['blog_benzersizbaslik'];
            $blogIcerik[$y]['Yazi'] = $blogListee['blog_yazi'];
            $bolunmus = explode(" ", $blogListee['blog_tarih']);
            $newtarihex = explode("-", $bolunmus[0]);
            $blogIcerik[$y]['Tarih'] = $newtarihex[2] . '/' . $newtarihex[1] . '/' . $newtarihex[0];
            $blogIcerik[$y]['Saat'] = $bolunmus[1];
            $blogIcerik[$y]['Resim'] = $blogListee['blog_resim'];
            $y++;
        }

        //gruplama
        for ($a = 0; $a < count($bloggerYilAy); $a++) {
            $b = 0;
            foreach ($blogListe as $blogListee) {
                if ($bloggerYilAy[$a]['Ay'] == $blogListee['blog_ay']) {
                    $bloggerGrup[$a][$b]['ID'] = $blogListee['blog_ID'];
                    $bloggerGrup[$a][$b]['Baslik'] = $blogListee['blog_baslik'];
                    $bloggerGrup[$a][$b]['Url'] = "blog-" . $blogListee['blog_benzersizbaslik'];
                    $bloggerGrup[$a][$b]['Ay'] = $form->ayogrenme($blogListee['blog_ay']);
                    $bloggerGrup[$a][$b]['Yil'] = $blogListee['blog_yil'];
                    $b++;
                }
            }
        }

        $blogger[0] = $blogIcerik;
        $blogger[1] = $bloggerGrup;

        $this->load->view("Template_FrontEnd/headertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headermiddle", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/headerbottom", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/blog", $languagedeger, $blogger);
        $this->load->view("Template_FrontEnd/footertop", $languagedeger, $homedizi);
        $this->load->view("Template_FrontEnd/footerbottom", $languagedeger);
    }

}

?>