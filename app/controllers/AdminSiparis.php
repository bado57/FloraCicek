<?php

class AdminSiparis extends Controller {

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

                case "kargoSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deletekargo = $Panel_Model->kargoDelete($ID);
                    if ($deletekargo) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
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
                        $result = $Panel_Model->kargoUpdate($dataK, $ID);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "bankaSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deletebanka = $Panel_Model->bankaDelete($ID);
                    if ($deletebanka) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;

                case "bankaEkle":
                    $form->post("bankAdi", true);
                    $form->post("bankHesap", true);
                    $form->post("bankAlici", true);
                    $form->post("bankSube", true);
                    $form->post("bankIban", true);
                    $form->post("aktiflik", true);
                    $bankAdi = $form->values['bankAdi'];
                    $bankHesap = $form->values['bankHesap'];
                    $bankAlici = $form->values['bankAlici'];
                    $bankSube = $form->values['bankSube'];
                    $bankIban = $form->values['bankIban'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($bankAdi == "") {
                        $sonuc["hata"] = "Lütfen Banka Adı Giriniz.";
                    } else {
                        if ($bankHesap == "") {
                            $sonuc["hata"] = "Lütfen Hesap Numarası Giriniz.";
                        } else {
                            if ($bankAlici == "") {
                                $sonuc["hata"] = "Lütfen Alıcı İsmi Giriniz.";
                            } else {
                                if ($bankSube == "") {
                                    $sonuc["hata"] = "Lütfen Şube Adı ve Kodu Giriniz.";
                                } else {
                                    if ($bankIban == "") {
                                        $sonuc["hata"] = "Lütfen Iban Numarası Giriniz.";
                                    } else {
                                        if ($form->submit()) {
                                            $dataB = array(
                                                'banka_adi' => $bankAdi,
                                                'banka_aktif' => $aktiflik,
                                                'banka_sube' => $bankSube,
                                                'banka_hesapno' => $bankHesap,
                                                'banka_ibanno' => $bankIban,
                                                'banka_alici' => $bankAlici
                                            );
                                        }
                                        $result = $Panel_Model->bankaekle($dataB);
                                        if ($result) {
                                            $sonuc["result"] = "1";
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "bankaDuzenle":
                    $form->post("ID", true);
                    $form->post("bankAdi", true);
                    $form->post("bankHesap", true);
                    $form->post("bankAlici", true);
                    $form->post("bankSube", true);
                    $form->post("bankIban", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $bankAdi = $form->values['bankAdi'];
                    $bankHesap = $form->values['bankHesap'];
                    $bankAlici = $form->values['bankAlici'];
                    $bankSube = $form->values['bankSube'];
                    $bankIban = $form->values['bankIban'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($bankAdi == "") {
                        $sonuc["hata"] = "Lütfen Banka Adı Giriniz.";
                    } else {
                        if ($bankHesap == "") {
                            $sonuc["hata"] = "Lütfen Hesap Numarası Giriniz.";
                        } else {
                            if ($bankAlici == "") {
                                $sonuc["hata"] = "Lütfen Alıcı İsmi Giriniz.";
                            } else {
                                if ($bankSube == "") {
                                    $sonuc["hata"] = "Lütfen Şube Adı ve Kodu Giriniz.";
                                } else {
                                    if ($bankIban == "") {
                                        $sonuc["hata"] = "Lütfen Iban Numarası Giriniz.";
                                    } else {
                                        if ($form->submit()) {
                                            $dataB = array(
                                                'banka_adi' => $bankAdi,
                                                'banka_aktif' => $aktiflik,
                                                'banka_sube' => $bankSube,
                                                'banka_hesapno' => $bankHesap,
                                                'banka_ibanno' => $bankIban,
                                                'banka_alici' => $bankAlici
                                            );
                                        }
                                        $result = $Panel_Model->bankaUpdate($dataB, $ID);
                                        if ($result) {
                                            $sonuc["result"] = "1";
                                        } else {
                                            $sonuc["hata"] = "Tekrar Deneyiniz";
                                        }
                                    }
                                }
                            }
                        }
                    }

                    break;

                case "yerSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deleteyer = $Panel_Model->yerDelete($ID);
                    if ($deleteyer) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;

                case "yerEkle":
                    $form->post("ad", true);
                    $form->post("aktiflik", true);
                    $yerAdi = $form->values['ad'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($yerAdi == "") {
                        $sonuc["hata"] = "Lütfen Gönderim Yeri Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataY = array(
                                'gonderimyeri_adi' => $yerAdi,
                                'gonderimyeri_aktif' => $aktiflik
                            );
                        }
                        $result = $Panel_Model->yerekle($dataY);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "yerDuzenle":
                    $form->post("ID", true);
                    $form->post("ad", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $yerAdi = $form->values['ad'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($yerAdi == "") {
                        $sonuc["hata"] = "Lütfen Gönderim Yeri Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataY = array(
                                'gonderimyeri_adi' => $yerAdi,
                                'gonderimyeri_aktif' => $aktiflik
                            );
                        }
                        $result = $Panel_Model->yerUpdate($dataY, $ID);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "nedenSil":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];

                    $deleteneden = $Panel_Model->nedenDelete($ID);
                    if ($deleteneden) {
                        $sonuc["cevap"] = "Başarıyla silinmiştir.";
                    }
                    break;

                case "nedenEkle":
                    $form->post("ad", true);
                    $form->post("aktiflik", true);
                    $nedenAdi = $form->values['ad'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($nedenAdi == "") {
                        $sonuc["hata"] = "Lütfen Gönderim Nedeni Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataN = array(
                                'gonderimnedeni_adi' => $nedenAdi,
                                'gonderimnedeni_aktif' => $aktiflik
                            );
                        }
                        $result = $Panel_Model->nedenekle($dataN);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "nedenDuzenle":
                    $form->post("ID", true);
                    $form->post("ad", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $nedenAdi = $form->values['ad'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($nedenAdi == "") {
                        $sonuc["hata"] = "Lütfen Gönderim Nedeni Giriniz.";
                    } else {
                        if ($form->submit()) {
                            $dataN = array(
                                'gonderimnedeni_adi' => $nedenAdi,
                                'gonderimnedeni_aktif' => $aktiflik
                            );
                        }
                        $result = $Panel_Model->nedenUpdate($dataN, $ID);
                        if ($result) {
                            $sonuc["result"] = "1";
                        } else {
                            $sonuc["hata"] = "Tekrar Deneyiniz";
                        }
                    }

                    break;

                case "ilDuzenle":
                    $form->post("ID", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($form->submit()) {
                        $dataIl = array(
                            'sehir_aktiflik' => $aktiflik
                        );
                    }
                    $result = $Panel_Model->ilUpdate($dataIl, $ID);
                    if ($result) {
                        $sonuc["result"] = "1";
                    } else {
                        $sonuc["hata"] = "Tekrar Deneyiniz";
                    }

                    break;

                case "ilceDuzenle":
                    $form->post("ID", true);
                    $form->post("ekucrett", true);
                    $form->post("aktiflik", true);
                    $ID = $form->values['ID'];
                    $ekucret = $form->values['ekucrett'];
                    $aktiflik = $form->values['aktiflik'];

                    if ($form->submit()) {
                        $dataIlce = array(
                            'ilce_aktiflik' => $aktiflik,
                            'ilce_ekucret' => $ekucret
                        );
                    }
                    $result = $Panel_Model->ilceUpdate($dataIlce, $ID);
                    if ($result) {
                        $sonuc["result"] = "1";
                    } else {
                        $sonuc["hata"] = "Tekrar Deneyiniz";
                    }

                    break;

                case "siparisDuzenlemeDegerler":
                    $form->post("ID", true);
                    $ID = $form->values['ID'];
                    $siparis = array();

                    $sip = $Panel_Model->siparisDetaylistele($ID);
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
                        $siplist['SGonTar'] = $sipp['siparis_tarih'] . ' (' . $sipp['siparis_saat'] . '-' . $sipp['siparis_gun'] . ')';
                        $siplist['SGitYer'] = $sipp['siparis_yertext'];
                        $siplist['SGAdres'] = $sipp['siparis_aliciadres'];
                        $siplist['SGAdresTrf'] = $sipp['siparis_aliciadrestarif'];
                        $siplist['SNot'] = $sipp['siparis_gonderennotu'];
                        $siplist['SKartMsj'] = $sipp['siparis_kartmesaj'];
                        $siplist['SKartIsim'] = $sipp['siparis_kartisim'];
                        $siplist['SIsimGstr'] = $sipp['siparis_isimgorunme'];
                        $siplist['SGndNdn'] = $sipp['siparis_gndtext'];
                    }
                    $urun = $Panel_Model->siparisUrunDetaylistele($ID);
                    $u = 0;
                    $tutar = 0;
                    foreach ($urun as $urunn) {
                        $urunlist[$u]['SID'] = $urunn['siparisurun_ID'];
                        $urunlist[$u]['SSID'] = $urunn['siparisurun_siparisID'];
                        $urunlist[$u]['SUID'] = $urunn['siparisurun_urunID'];
                        $urunlist[$u]['SUAd'] = $urunn['siparisurun_ad'];
                        $urunlist[$u]['SUKod'] = $urunn['siparisurun_kod'];
                        $urunlist[$u]['SUMiktar'] = $urunn['siparisurun_miktar'];
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
                        $sonuc["hata"] = "Tekrar Deneyiniz";
                    }

                    break;

                case "siparisDuzenle":
                    $form->post("ID", true);
                    $form->post("durum", true);
                    $form->post("aciklama", true);
                    $form->post("firma", true);
                    $form->post("takipno", true);
                    $ID = $form->values['ID'];
                    $durum = $form->values['durum'];
                    $aciklama = $form->values['aciklama'];
                    $firma = $form->values['firma'];
                    $takipno = $form->values['takipno'];

                    if ($durum == -1) {
                        $sonuc["hata"] = "Lütfen Sipariş Durumunu Giriniz.";
                    } else {
                        if ($durum == 3) {
                            if ($firma == -1) {
                                $sonuc["hata"] = "Lütfen Kargo Firması Seçiniz.";
                            } else {
                                if ($form->submit()) {
                                    $dataS = array(
                                        'siparis_adminnotu' => $aciklama,
                                        'siparis_durum' => $durum,
                                        'siparis_kargofirmaid' => $firma,
                                        'siparis_kargotakipno' => $takipno
                                    );
                                }
                                $result = $Panel_Model->siparisUpdate($dataS, $ID);
                                if ($result) {
                                    $sonuc["result"] = "1";
                                } else {
                                    $sonuc["hata"] = "Tekrar Deneyiniz";
                                }
                            }
                        } else {
                            if ($form->submit()) {
                                $dataS = array(
                                    'siparis_adminnotu' => $aciklama,
                                    'siparis_durum' => $durum
                                );
                            }
                            $result = $Panel_Model->siparisUpdate($dataS, $ID);
                            if ($result) {
                                $sonuc["result"] = "1";
                            } else {
                                $sonuc["hata"] = "Tekrar Deneyiniz";
                            }
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

