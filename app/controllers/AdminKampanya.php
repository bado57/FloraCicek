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
                    $arrayKategori = array();

                    $kmpnyaListe = $Panel_Model->panelKampanyaListe($ID);
                    foreach ($kmpnyaListe as $kmpnyaListee) {
                        $kampanyaList[0][0]['ID'] = $kmpnyaListee['kampanya_ID'];
                        $kampanyaList[0][0]['Baslik'] = $kmpnyaListee['kampanya_baslik'];
                        $kampanyaList[0][0]['Yazi'] = $kmpnyaListee['kampanya_yazi'];
                        $explodeBaslama = explode(" ", $kmpnyaListee['kampanya_baslamatarih']);
                        $explodeBasTarih = explode("-", $explodeBaslama[0]);
                        $kampanyaList[0][0]["BsTarih"] = $explodeBasTarih[2] . '/' . $explodeBasTarih[1] . '/' . $explodeBasTarih[0];
                        $explodeBitis = explode(" ", $kmpnyaListee['kampanya_bitistarihi']);
                        $explodeBitisTarih = explode("-", $explodeBitis[0]);
                        $kampanyaList[0][0]["BtTarih"] = $explodeBitisTarih[2] . '/' . $explodeBitisTarih[1] . '/' . $explodeBitisTarih[0];
                        $kampanyaList[0][0]['Aktif'] = $kmpnyaListee['kampanya_aktiflik'];
                        $kampanyaList[0][0]['Yuzde'] = $kmpnyaListee['kampanya_indirimyuzde'];
                        $kampanyaList[0][0]['Kategori'] = $kmpnyaListee['kampanya_kategori'];
                        $arrayKategori[] = $kmpnyaListee['kampanya_kategori'];
                    }

                    $kampKatDizi = implode(',', $arrayKategori);
                    $kk = 0;
                    //ek ürün daha önce kullanılmış mı onu ayırmak için
                    if (in_array("-1", $arrayKategori)) {
                        $kampanyaList[1][$kk]['ID'] = "-1";
                        $kampanyaList[1][$kk]['Adi'] = "Ek Ürün";
                        $kk++;
                    }
                    $kategoriListe = $Panel_Model->kampKategori($kampKatDizi);

                    foreach ($kategoriListe as $kategoriListee) {
                        $kampanyaList[1][$kk]['ID'] = $kategoriListee['kategori_ID'];
                        $kampanyaList[1][$kk]['Adi'] = $kategoriListee['kategori_Adi'];
                        $kk++;
                    }

                    $sonuc["result"] = $kampanyaList;
                    break;
                case "kampanyaEkle":
                    $form->post("baslamaTarh", true);
                    $form->post("btsTarih", true);
                    $form->post("yuzde", true);
                    $form->post("aktiflik", true);
                    $kmpbaslik = $_POST['kmpbaslik'];
                    $kmpYazi = $_POST['kmpYazi'];
                    $aciklama = $_POST['aciklama'];
                    $baslamaTarh = $form->values['baslamaTarh'];
                    $btsTarih = $form->values['btsTarih'];
                    $yuzde = $form->values['yuzde'];
                    $aktiflik = $form->values['aktiflik'];
                    $kmpArray = $_REQUEST['urunKatVal'];
                    $kampanyadizi = implode(',', $kmpArray);

                    if ($kmpbaslik != "") {
                        if ($baslamaTarh != "") {
                            if ($btsTarih != "") {
                                if ($yuzde != "") {
                                    if ($kmpYazi != "") {
                                        $yenikmpbaslik = $form->turkce_kucult_tr($kmpbaslik);
                                        $explodeBsTarih = explode("/", $baslamaTarh);
                                        $newbstarih = $explodeBsTarih[2] . '/' . $explodeBsTarih[1] . '/' . $explodeBsTarih[0];
                                        $explodeBtTarih = explode("/", $btsTarih);
                                        $newbttarih = $explodeBtTarih[2] . '/' . $explodeBtTarih[1] . '/' . $explodeBtTarih[0];
                                        if ($form->submit()) {
                                            $data = array(
                                                'kampanya_baslik' => $kmpbaslik,
                                                'kampanya_benbaslik' => $yenikmpbaslik,
                                                'kampanya_yazi' => $kmpYazi,
                                                'kampanya_baslamatarih' => $newbstarih,
                                                'kampanya_bitistarihi' => $newbttarih,
                                                'kampanya_aktiflik' => $aktiflik,
                                                'kampanya_indirimyuzde' => $yuzde,
                                                'kampanya_kategori' => $kampanyadizi
                                            );
                                        }
                                        $result = $Panel_Model->kampanyaEkle($data);
                                        if ($result) {
                                            if (count($kmpArray) > 0) {
                                                if ($form->submit()) {
                                                    $dataK = array(
                                                        'urun_kmpnyaid' => $result
                                                    );
                                                }
                                                $resultUpdate = $Panel_Model->kampanyUrunUpdate($dataK, $kampanyadizi);
                                                if ($resultUpdate) {
                                                    $sonuc["result"] = "1";
                                                }
                                            } else {
                                                $sonuc["result"] = "1";
                                            }
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Kampanya Yazısını Giriniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Lütfen İndirim Tutarını Giriniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen Kampanya Bitiş Tarihini Giriniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Kampanya Başlama Tarihini Giriniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Kampanya Başlığını Giriniz.";
                    }

                    break;
                case "kampanyaDuzenle":
                    $form->post("ID", true);
                    $form->post("baslamaTarh", true);
                    $form->post("btsTarih", true);
                    $form->post("yuzde", true);
                    $form->post("aktiflik", true);
                    $kmpbaslik = $_POST['kmpbaslik'];
                    $kmpYazi = $_POST['kmpYazi'];
                    $aciklama = $_POST['aciklama'];
                    $ID = $form->values['ID'];
                    $baslamaTarh = $form->values['baslamaTarh'];
                    $btsTarih = $form->values['btsTarih'];
                    $yuzde = $form->values['yuzde'];
                    $aktiflik = $form->values['aktiflik'];
                    $kmpArray = $_REQUEST['urunKatVal'];
                    $kmpEskiArray = $_REQUEST['urunEskiKatVal'];
                    $kampanyadizi = implode(',', $kmpArray);
                    $kampanyaeskidizi = implode(',', $kmpEskiArray);

                    if ($kmpbaslik != "") {
                        if ($baslamaTarh != "") {
                            if ($btsTarih != "") {
                                if ($yuzde != "") {
                                    if ($kmpYazi != "") {
                                        $yenikmpbaslik = $form->turkce_kucult_tr($kmpbaslik);
                                        $explodeBsTarih = explode("/", $baslamaTarh);
                                        $newbstarih = $explodeBsTarih[2] . '/' . $explodeBsTarih[1] . '/' . $explodeBsTarih[0];
                                        $explodeBtTarih = explode("/", $btsTarih);
                                        $newbttarih = $explodeBtTarih[2] . '/' . $explodeBtTarih[1] . '/' . $explodeBtTarih[0];
                                        if ($form->submit()) {
                                            $data = array(
                                                'kampanya_baslik' => $kmpbaslik,
                                                'kampanya_benbaslik' => $yenikmpbaslik,
                                                'kampanya_yazi' => $kmpYazi,
                                                'kampanya_baslamatarih' => $newbstarih,
                                                'kampanya_bitistarihi' => $newbttarih,
                                                'kampanya_aktiflik' => $aktiflik,
                                                'kampanya_indirimyuzde' => $yuzde,
                                                'kampanya_kategori' => $kampanyadizi
                                            );
                                        }
                                        $result = $Panel_Model->kampanyaUpdate($data, $ID);
                                        if ($result) {
                                            if (count($kmpEskiArray) > 0) {
                                                if ($form->submit()) {
                                                    $dataEK = array(
                                                        'urun_kmpnyaid' => 0
                                                    );
                                                }
                                                $resultEskiUpdate = $Panel_Model->kampanyUrunUpdate($dataEK, $kampanyaeskidizi);
                                                if ($resultEskiUpdate) {
                                                    if (count($kmpArray) > 0) {
                                                        if ($form->submit()) {
                                                            $dataK = array(
                                                                'urun_kmpnyaid' => $ID
                                                            );
                                                        }
                                                        $resultUpdate = $Panel_Model->kampanyUrunUpdate($dataK, $kampanyadizi);
                                                        if ($resultUpdate) {
                                                            $sonuc["result"] = "1";
                                                        }
                                                    } else {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                                                }
                                            } else {
                                                if (count($kmpArray) > 0) {
                                                    if ($form->submit()) {
                                                        $dataK = array(
                                                            'urun_kmpnyaid' => $ID
                                                        );
                                                    }
                                                    $resultUpdate = $Panel_Model->kampanyUrunUpdate($dataK, $kampanyadizi);
                                                    if ($resultUpdate) {
                                                        $sonuc["result"] = "1";
                                                    }
                                                } else {
                                                    $sonuc["result"] = "1";
                                                }
                                            }
                                        } else {
                                            $sonuc["hata"] = "Bir Hata Oluştu Tekrar Deneyiniz.";
                                        }
                                    } else {
                                        $sonuc["hata"] = "Lütfen Kampanya Yazısını Giriniz.";
                                    }
                                } else {
                                    $sonuc["hata"] = "Lütfen İndirim Tutarını Giriniz.";
                                }
                            } else {
                                $sonuc["hata"] = "Lütfen Kampanya Bitiş Tarihini Giriniz.";
                            }
                        } else {
                            $sonuc["hata"] = "Lütfen Kampanya Başlama Tarihini Giriniz.";
                        }
                    } else {
                        $sonuc["hata"] = "Lütfen Kampanya Başlığını Giriniz.";
                    }

                    break;
                case "iletisim":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $iletisimListe = $Panel_Model->iletisimDetay($ID);
                    foreach ($iletisimListe as $iletisimListee) {
                        $iletList[0]['ID'] = $iletisimListee['iletisim_ID'];
                        $iletList[0]['AdSoyad'] = $iletisimListee['iletisim_AdSoyad'];
                        $iletList[0]['Email'] = $iletisimListee['iletisim_email'];
                        $explodeBaslama = explode(" ", $iletisimListee['iletisim_tarih']);
                        $explodeBasTarih = explode("-", $explodeBaslama[0]);
                        $iletList[0]["BsTarih"] = $explodeBasTarih[2] . '/' . $explodeBasTarih[1] . '/' . $explodeBasTarih[0] . "--" . $explodeBaslama[1];
                        $iletList[0]['Konu'] = $iletisimListee['iletisim_konu'];
                        $iletList[0]['Mesaj'] = $iletisimListee['iletisim_mesaj'];
                        $iletList[0]['Uye'] = $iletisimListee['iletisim_Uye'];
                    }

                    $sonuc["result"] = $iletList;
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

