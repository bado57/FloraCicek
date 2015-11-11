<?php

class AdminKampanya extends Controller {

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

                case "kampanyaSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deletekampanya = $Panel_Model->kampanyaDelete($ID);
                    if ($deletekampanya) {
                        if ($form->submit()) {
                            $dataK = array(
                                'urun_kmpnyaid' => 0
                            );
                        }
                        $result = $Panel_Model->kampanyaUrunUpdate($dataK, $ID);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }
                    break;

                case "kampanyaDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $kampanyaList = array();

                    $kmpnyaListe = $Panel_Model->panelKampanyaListe($ID);
                    foreach ($kmpnyaListe as $kmpnyaListee) {
                        $kampanyaList['ID'] = $kmpnyaListee['kampanya_ID'];
                        $kampanyaList['Baslik'] = $kmpnyaListee['kampanya_baslik'];
                        $kampanyaList['Yazi'] = $kmpnyaListee['kampanya_yazi'];
                        $explodeBaslama = explode(" ", $kmpnyaListee['kampanya_baslamatarih']);
                        $explodeBasTarih = explode("-", $explodeBaslama[0]);
                        $kampanyaList["BsTarih"] = $explodeBasTarih[2] . '/' . $explodeBasTarih[1] . '/' . $explodeBasTarih[0];
                        $explodeBitis = explode(" ", $kmpnyaListee['kampanya_bitistarihi']);
                        $explodeBitisTarih = explode("-", $explodeBitis[0]);
                        $kampanyaList["BtTarih"] = $explodeBitisTarih[2] . '/' . $explodeBitisTarih[1] . '/' . $explodeBitisTarih[0];
                        $kampanyaList['Aktif'] = $kmpnyaListee['kampanya_aktiflik'];
                        $kampanyaList['Yuzde'] = $kmpnyaListee['kampanya_indirimyuzde'];
                    }

                    $sonuc["result"] = $kampanyaList;
                    break;

                case "kargoEkle":
                    $form->post("ad", true);
                    $form->post("aciklama", true);
                    $form->post("aktiflik", true);
                    $ad = $form->values['ad'];
                    $aciklama = $form->values['aciklama'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($ad == "") {
                        $sonuc["hata"] = "Lütfen Kargo Adını Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataK = array(
                                'kargofirma_adi' => $ad,
                                'kargofirma_aktiflik' => $aktiflik,
                                'kargofirma_aciklama' => $aciklama
                            );
                        }
                        $result = $Panel_Model->kargoekle($dataK);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "kargoDuzenle":
                    $form->post("ID", true);
                    $form->post("ad", true);
                    $form->post("aciklama", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $ad = $form->values['ad'];
                    $aciklama = $form->values['aciklama'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($ad == "") {
                        $sonuc["hata"] = "Lütfen Kargo Adını Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataK = array(
                                'kargofirma_adi' => $ad,
                                'kargofirma_aktiflik' => $aktiflik,
                                'kargofirma_aciklama' => $aciklama
                            );
                        }
                        $result = $Panel_Model->kampanyaUrunUpdate($dataK, $ID);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
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

