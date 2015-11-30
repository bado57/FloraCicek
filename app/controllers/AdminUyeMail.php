<?php

class AdminUyeMail extends Controller {

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

                case "kUyeDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $kUyeList = array();
                    $toplamTutar = 0;
                    $kUyeSip = $Panel_Model->kurumsalUyeSiparis($ID);
                    $k = 0;
                    foreach ($kUyeSip as $kUyeSipp) {
                        $kUyeList[0][$k]['No'] = $kUyeSipp['siparis_No'];
                        $kUyeList[0][$k]['TTutar'] = $kUyeSipp['siparis_toplamtutar'];
                        $toplamTutar = $toplamTutar + $kUyeSipp['siparis_toplamtutar'];
                        $explode = explode(" ", $kUyeSipp['siparis_girilmetarih']);
                        $explodeTarih = explode("-", $explode[0]);
                        $kUyeList[0][$k]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                        $k++;
                    }
                    $kUyeList[2]['TTutar'] = $toplamTutar;
                    $kUyeList[2]['SipCount'] = count($kUyeSip);

                    $uyeListe = $Panel_Model->kurumsalUyeDetayListe($ID);
                    foreach ($uyeListe as $uyeListee) {
                        $kUyeList[1]['ID'] = $uyeListee['kullanici_id'];
                        $kUyeList[1]['AdSoyad'] = $uyeListee['kullanici_adSoyad'];
                        $kUyeList[1]['EPosta'] = $uyeListee['kullanici_eposta'];
                        $kUyeList[1]['KurumAd'] = $uyeListee['kullanici_kurumadi'];
                        $kUyeList[1]['VergiD'] = $uyeListee['kullanici_vergid'];
                        $kUyeList[1]['VergiNo'] = $uyeListee['kullanici_vergino'];
                        $kUyeList[1]['KurumTel'] = $uyeListee['kullanici_kurumtel'];
                        $kUyeList[1]['Telefon'] = $uyeListee['kullanici_tel'];
                        $kUyeList[1]['Adres'] = $uyeListee['kullanici_adres'];
                        $explode = explode(" ", $uyeListee['kullanici_tarih']);
                        $explodeTarih = explode("-", $explode[0]);
                        $kUyeList[1]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                    }

                    $sonuc["result"] = $kUyeList;
                    break;

                case "bUyeDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $bUyeList = array();
                    $toplamTutar = 0;
                    $bUyeSip = $Panel_Model->bireyselUyeSiparis($ID);
                    $b = 0;
                    foreach ($bUyeSip as $bUyeSipp) {
                        $bUyeList[0][$b]['No'] = $bUyeSipp['siparis_No'];
                        $bUyeList[0][$b]['TTutar'] = $bUyeSipp['siparis_toplamtutar'];
                        $toplamTutar = $toplamTutar + $bUyeSipp['siparis_toplamtutar'];
                        $explode = explode(" ", $bUyeSipp['siparis_girilmetarih']);
                        $explodeTarih = explode("-", $explode[0]);
                        $bUyeList[0][$b]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                        $b++;
                    }
                    $bUyeList[2]['TTutar'] = $toplamTutar;
                    $bUyeList[2]['SipCount'] = count($bUyeSip);

                    $uyeListe = $Panel_Model->bireyselUyeDetayListe($ID);
                    foreach ($uyeListe as $uyeListee) {
                        $bUyeList[1]['ID'] = $uyeListee['kullanici_id'];
                        $bUyeList[1]['AdSoyad'] = $uyeListee['kullanici_adSoyad'];
                        $bUyeList[1]['EPosta'] = $uyeListee['kullanici_eposta'];
                        $bUyeList[1]['KurumAd'] = $uyeListee['kullanici_kurumadi'];
                        $bUyeList[1]['VergiD'] = $uyeListee['kullanici_vergid'];
                        $bUyeList[1]['VergiNo'] = $uyeListee['kullanici_vergino'];
                        $bUyeList[1]['KurumTel'] = $uyeListee['kullanici_kurumtel'];
                        $bUyeList[1]['Telefon'] = $uyeListee['kullanici_tel'];
                        $bUyeList[1]['Adres'] = $uyeListee['kullanici_adres'];
                        $explode = explode(" ", $uyeListee['kullanici_tarih']);
                        $explodeTarih = explode("-", $explode[0]);
                        $bUyeList[1]["Tarih"] = $explodeTarih[2] . '/' . $explodeTarih[1] . '/' . $explodeTarih[0];
                    }

                    $sonuc["result"] = $bUyeList;
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

