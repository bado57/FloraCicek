$(document).ready(function () {
/////////////////////////////Siparis/////////////////////////////
    $(document).on('click', 'a#siparisduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminSiparis/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "siparisDuzenlemeDegerler"},
            success: function (cevap) {
                
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        
                        $("#siparisbilgileri").show();
                        $("#urunbilgileri").show();
                        $("#müsteribilgileri").show();
                        $("#faturabilgileri").show();
                        $("#teslimatbilgileri").show();
                        var durum = $("#" + ID).attr("data-durum");
                        $("#siparisdurum").select2("val", durum);
                        
                        ////// Bilgiler
                        
                        $(".sipno").text(cevap.result[0].No);
                        $(".siptarih").text(cevap.result[0].Tarih);
                        $(".siptutar").text(cevap.result[0].TTutar);
                        if (cevap.result[0].OdeTip == 0) {
                            $(".sipOdeme").text("Kart İle Ödeme");
                        } else if (cevap.result[0].OdeTip == 1) {
                            $(".sipOdeme").text("Banka Havalesi");
                        } else {
                            $(".sipOdeme").text("Telefon İle Ödeme");
                        }

                        if (cevap.result[1]) {
                            var length = cevap.result[1].length;
                            for (var i = 0; i < length; i++) {
                                $("#urunSip").append("<tr>"
                                        + "<td id='urunkod'>" + cevap.result[1][i].SUKod + "/" + cevap.result[1][i].SUAd + "</td>"
                                        + "<td id='urunbirimfiyat'>" + cevap.result[1][i].SUTtar + "</td>"
                                        + "<td id='urunmiktar'>" + cevap.result[1][i].SUMiktar + "</td>"
                                        + "<td id='uruntutar'>" + cevap.result[1][i].SUTplmTutar + " TL</td></tr>");
                                
                                $("#urunSipPrint").append('<div style="margin-left: 0.2cm; position: relative; display: inline-block; width: 47%; height: 3.5cm; margin-bottom: 0.2 cm; margin-top: 0.2cm; border:1px solid #e6e6e6; padding: 0.1cm;">'
                                        +'<img src="https://www.turkiyefloracicek.com/products/'+ cevap.result[1][i].SUResim +'" style="max-width: 40%; max-height: 3.5cm; margin: :0cm; position: relative; display: inline-block; vertical-align: top !important" />'
                                        +'<font style="font-size: 9pt; position: relative; display: inline-block; width: 58%; margin-left: 0.2cm; line-height: 14pt;">'
                                                        +'<b>Ürün Kodu :</b> '+ cevap.result[1][i].SUKod +' <br/>'
                                                        +'<b>Ürün Adı :</b> '+ cevap.result[1][i].SUAd +' <br/>'
                                                        +'<b>Birim Fiyat :</b> '+ cevap.result[1][i].SUTtar +' TL <br/>'
                                                        +'<b>Adet :</b> '+ cevap.result[1][i].SUMiktar +' <br/>'
                                                        +'<b>Toplam Tutar :</b> '+ cevap.result[1][i].SUTplmTutar +' TL <br/>'
                                                        +'</font>'
                                                    +'</div>');
                                
                            }
                            $(".uruntoplamtutar").text(cevap.result[1][i - 1].Toplam);
                        }


                        $(".gndad").text(cevap.result[0].GAd);
                        $(".gndtel").text(cevap.result[0].GTel);
                        $(".gndmail").text(cevap.result[0].GMail);
                        
                        if (cevap.result[0].GUDurum == 0) {
                            $(".gndtip").html('<i class="fa fa-user"></i> Bireysel Üye');
                        } else if (cevap.result[0].GUDurum == 1) {
                            $(".gndtip").html('<i class="fa fa-admin"></i> Admin');
                        } else if (cevap.result[0].GUDurum == 2) {
                            $(".gndtip").html('<i class="fa fa-briefcase"></i>  Kurumsal Üye');
                        } else if (cevap.result[0].GUDurum == 3) {
                            $(".gndtip").html('<i class="fa fa-shopping-cart"></i>  Üye Değil');
                        }

                        $(".ftrunvn").text(cevap.result[0].FUnvan);
                        $(".ftrtc").text(cevap.result[0].FTcNo);
                        $(".ftrvdaire").text(cevap.result[0].FVDaire);
                        $(".ftrvno").text(cevap.result[0].FVNo);
                        $(".ftradres").text(cevap.result[0].FAdres);
                        $(".aliciad").text(cevap.result[0].AAd);
                        $(".alicitel").text(cevap.result[0].ATel);
                        $(".tslmttarih").text(cevap.result[0].SGonTar);
                        $(".tslmsaat").text(cevap.result[0].SGonSaat);
                        $(".tslimtyer").text(cevap.result[0].SGitYer);
                        $(".tslimtadres").text(cevap.result[0].SGAdres);
                        $(".tslmtadrestrf").text(cevap.result[0].SGAdresTrf);
                        $(".tslmtnot").text(cevap.result[0].SNot);
                        $(".tslmtkartmsj").text(cevap.result[0].SKartMsj);
                        $(".tslmtkartisim").text(cevap.result[0].SKartIsim);
                        
                        if (cevap.result[0].SIsimGstr == 1) {
                            $(".tslmtisimgrnme").text("Görünsün");
                        } else {
                            $(".tslmtisimgrnme").text("Görünmesin");
                        }
                        
                        $(".spPrintFooter").text(cevap.result[0].GAd + " " + cevap.result[0].Tarih + " " + cevap.result[0].No + " no'lu sipariş detayları.");
                        $(".spTotalFooter").text("Tpolam Tutar : " + cevap.result[0].TTutar + " TL");
                        ///// ----- Bilgiler
                        $("#tslmtgndndn").text(cevap.result[0].SGndNdn);
                        $("#siparisustbaslik").text(cevap.result[0].No);
                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(ID);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggleSiparis").click();
                        }
                    }
                }
            }
        });
    });
    
    $(document).on('click', 'button#formToggleSiparis', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#siparisbilgileri").hide();
                $("#urunbilgileri").hide();
                $("#müsteribilgileri").hide();
                $("#faturabilgileri").hide();
                $("#teslimatbilgileri").hide();
                $("#siparisaciklama").val("");
                $("#siparisdurum").select2("val", -1);
                $("#siparisustbaslik").text("Yeni");
                $("#urunSip").empty();
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#siparisbilgileri").hide();
            $("#urunbilgileri").hide();
            $("#müsteribilgileri").hide();
            $("#faturabilgileri").hide();
            $("#teslimatbilgileri").hide();
            $("#siparisaciklama").val("");
            $("#siparisdurum").select2("val", -1);
            $("#siparisustbaslik").text("Yeni");
            $("#urunSip").empty();
        }
    });
    $(document).on('click', 'input#sipariskaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            reset();
            alertify.alert("Yeni Sipariş Eklenemez Lütfen Düzenleme Yapın.");
            return false;
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var durum = $("#siparisdurum").val();
            var firma = $("#kargofirma").val();
            var takipno = $("#kargotakipno").val();
            var aciklama = $("#siparisaciklama").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "durum": durum, "firma": firma, "takipno": takipno, "aciklama": aciklama, "tip": "siparisDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Siparis';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Siparis';
                        }
                    }
                }
            });
        }
    });
/////////////////////////////Kargo Firmaları/////////////////////////////
//kargo toggle buton
    $(document).on('click', 'button#formToggleKargo', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#kargofirmaadi").val("");
                $("#aktiflik").select2("val", 0);
                $("#aciklama").val("");
                $("#kargoustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#kargofirmaadi").val("");
            $("#aktiflik").select2("val", 0);
            $("#aciklama").val("");
            $("#kargoustbaslik").text("Yeni");
        }
    });
//silme butonu
    $(document).on('click', 'a#kargosil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminSiparis/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "kargoSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Kargo';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Kargo';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
//buton kaydet
    $(document).on('click', 'input#kargokaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var ad = $("#kargofirmaadi").val();
            var aciklama = $("#aciklama").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ad": ad, "aciklama": aciklama, "aktiflik": aktiflik, "tip": "kargoEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Kargo';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Kargo';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var ad = $("#kargofirmaadi").val();
            var aciklama = $("#aciklama").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "ad": ad, "aciklama": aciklama, "aktiflik": aktiflik, "tip": "kargoDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Kargo';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Kargo';
                        }
                    }
                }
            });
        }
    });
//table düzenle butonları
    $(document).on('click', 'a#kargoduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        var kargoAdi = $("#kargoad" + ID).text();
        var kargoDurum = $("#kargoaktif" + ID).attr('data-aktif');
        var aciklama = $("#kargoaciklama" + ID).text();
        $("#kargofirmaadi").val(kargoAdi);
        $("#aciklama").val(aciklama);
        $("#aktiflik").select2("val", kargoDurum);
        $("#kargoustbaslik").text(kargoAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleKargo").click();
        }
    });
/////////////////////////////Banka İşlemleri/////////////////////////////
//banka toggle buton
    $(document).on('click', 'button#formToggleBanka', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#bankaadi").val("");
                $("#hesapno").val("");
                $("#alici").val("");
                $("#subeadi").val("");
                $("#ibanno").val("");
                $("#aktiflik").select2("val", 0);
                $("#bankaustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#bankaadi").val("");
            $("#hesapno").val("");
            $("#alici").val("");
            $("#subeadi").val("");
            $("#ibanno").val("");
            $("#aktiflik").select2("val", 0);
            $("#bankaustbaslik").text("Yeni");
        }
    });
//silme butonu
    $(document).on('click', 'a#bankasil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminSiparis/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "bankaSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Banka';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Banka';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
//buton kaydet
    $(document).on('click', 'input#bankakaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var bankAdi = $("#bankaadi").val();
            var bankHesap = $("#hesapno").val();
            var bankAlici = $("#alici").val();
            var bankSube = $("#subeadi").val();
            var bankIban = $("#ibanno").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"bankAdi": bankAdi, "bankHesap": bankHesap, "bankAlici": bankAlici,
                    "bankSube": bankSube, "bankIban": bankIban, "aktiflik": aktiflik, "tip": "bankaEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Banka';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Banka';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var bankAdi = $("#bankaadi").val();
            var bankHesap = $("#hesapno").val();
            var bankAlici = $("#alici").val();
            var bankSube = $("#subeadi").val();
            var bankIban = $("#ibanno").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "bankAdi": bankAdi, "bankHesap": bankHesap, "bankAlici": bankAlici,
                    "bankSube": bankSube, "bankIban": bankIban, "aktiflik": aktiflik, "tip": "bankaDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Banka';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Banka';
                        }
                    }
                }
            });
        }
    });
//table düzenle butonları
    $(document).on('click', 'a#bankaduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        var bankAdi = $("#bankaad" + ID).text();
        var bankSube = $("#bankasube" + ID).text();
        var bankHesap = $("#bankahesap" + ID).text();
        var bankIban = $("#bankaiban" + ID).text();
        var bankAlici = $("#bankaalici" + ID).text();
        var bankDurum = $("#bankaaktif" + ID).attr('data-aktif');
        $("#bankaadi").val(bankAdi);
        $("#hesapno").val(bankHesap);
        $("#alici").val(bankAlici);
        $("#subeadi").val(bankSube);
        $("#ibanno").val(bankIban);
        $("#aktiflik").select2("val", bankDurum);
        $("#bankaustbaslik").text(bankAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleBanka").click();
        }
    });
/////////////////////////////Gönderim Yerleri/////////////////////////////
//yer toggle buton
    $(document).on('click', 'button#formToggleYer', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#gonderimyeradi").val("");
                $("#aktiflik").select2("val", 0);
                $("#yerustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#gonderimyeradi").val("");
            $("#aktiflik").select2("val", 0);
            $("#yerustbaslik").text("Yeni");
        }
    });
//silme butonu
    $(document).on('click', 'a#yersil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminSiparis/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "yerSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
//buton kaydet
    $(document).on('click', 'input#yerkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var ad = $("#gonderimyeradi").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ad": ad, "aktiflik": aktiflik, "tip": "yerEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var ad = $("#gonderimyeradi").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "ad": ad, "aktiflik": aktiflik, "tip": "yerDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Gonderimyeri';
                        }
                    }
                }
            });
        }
    });
//table düzenle butonları
    $(document).on('click', 'a#yerduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        var yerAdi = $("#yerad" + ID).text();
        var yerDurum = $("#yeraktif" + ID).attr('data-aktif');
        $("#gonderimyeradi").val(yerAdi);
        $("#aktiflik").select2("val", yerDurum);
        $("#yerustbaslik").text(yerAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleYer").click();
        }
    });
/////////////////////////////Gönderim Nedenleri/////////////////////////////
//yer toggle buton
    $(document).on('click', 'button#formToggleNeden', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#gonderimnedenadi").val("");
                $("#aktiflik").select2("val", 0);
                $("#nedenustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#gonderimnedenadi").val("");
            $("#aktiflik").select2("val", 0);
            $("#nedenustbaslik").text("Yeni");
        }
    });
//silme butonu
    $(document).on('click', 'a#nedensil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminSiparis/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "nedenSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
//buton kaydet
    $(document).on('click', 'input#nedenkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var ad = $("#gonderimnedenadi").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ad": ad, "aktiflik": aktiflik, "tip": "nedenEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var ad = $("#gonderimnedenadi").val();
            var aktiflik = $("#aktiflik").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "ad": ad, "aktiflik": aktiflik, "tip": "nedenDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Gonderimnedeni';
                        }
                    }
                }
            });
        }
    });
//table düzenle butonları
    $(document).on('click', 'a#nedenduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        var nedenAdi = $("#nedenad" + ID).text();
        var nedenDurum = $("#nedenaktif" + ID).attr('data-aktif');
        $("#gonderimnedenadi").val(nedenAdi);
        $("#aktiflik").select2("val", nedenDurum);
        $("#nedenustbaslik").text(nedenAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleNeden").click();
        }
    });
/////////////////////////////İl İlçe/////////////////////////////
//table düzenle butonları
    $(document).on('click', 'a#IlIlceDuzenle', function (e) {
        var ustID = $(this).parent().parent().attr('data-ust');
        var ID = $(this).parent().parent().attr('id');
        if (ustID > 0) {//ilce
//il temizle
            $("input[name=iladi]").val("");
            $("#ilaktiflik").select2("val", 0);
            var ilAdi = $("#ilad" + ustID).text();
            var ilceAdi = $("#ilcead" + ID).text();
            var ilceDurum = $("#ilcedurum" + ID).attr('data-aktif');
            var ilceUcret = $("#ilceekucret" + ID).text();
            $("input[name=ilceiladi]").val(ilAdi);
            $("input[name=ilceadi]").val(ilceAdi);
            var ilceYeniUcret = ilceUcret.split(" ");
            $("input[name=ekucret]").val(ilceYeniUcret[0]);
            $("#ilceaktiflik").select2("val", ilceDurum);
            $("#ililceustbaslik").text(ilceAdi);
        } else {//il
//ilce temizle
            $("input[name=ilceiladi]").val("");
            $("input[name=ilceadi]").val("");
            $("input[name=ekucret]").val("");
            $("#ilceaktiflik").select2("val", 0);
            var ilAdi = $("#ilad" + ID).text();
            var ilDurum = $("#ildurum" + ID).attr('data-aktif');
            $("input[name=iladi]").val(ilAdi);
            $("#ilaktiflik").select2("val", ilDurum);
            $("#ililceustbaslik").text(ilAdi);
        }

        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        $("input[name=duzenlemeUstID]").val(ustID);
        $("input[name=normalUstKategori]").val(ustID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleIlIlce").click();
        }

    });
//buton kaydet
    $(document).on('click', 'input#ilkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            reset();
            alertify.alert("Lütfen Yeni İl Eklemeyiniz.");
            return false;
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var aktiflik = $("#ildurum").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "aktiflik": aktiflik, "tip": "ilDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Ililce';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Ililce';
                        }
                    }
                }
            });
        }
    });
    $(document).on('click', 'input#ilcekaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            reset();
            alertify.alert("Lütfen Yeni İlçe Eklemeyiniz.");
            return false;
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var aktiflik = $("#ilceaktiflik").val();
            var ekucret = $("input[name=ekucret]").val();
            var ilceyeniucret = ekucret.split(" ");
            var ekucrett = ilceyeniucret[0];
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminSiparis/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "aktiflik": aktiflik, "ekucrett": ekucrett, "tip": "ilceDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Ililce';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Ililce';
                        }
                    }
                }
            });
        }
    });
//buton kayan
    $(document).on('click', 'button#formToggleIlIlce', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("input[name=duzenlemeUstID]").val(-1);
                $("input[name=ilceiladi]").val("");
                $("input[name=ilceadi]").val("");
                $("input[name=ekucret]").val("");
                $("#ilceaktiflik").select2("val", "");
                $("input[name=iladi]").val("");
                $("#ilceaktiflik").select2("val", 0);
                $("#ililceustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("input[name=duzenlemeUstID]").val(-1);
            $("input[name=ilceiladi]").val("");
            $("input[name=ilceadi]").val("");
            $("input[name=ekucret]").val("");
            $("#ilceaktiflik").select2("val", "");
            $("input[name=iladi]").val("");
            $("#ilceaktiflik").select2("val", 0);
            $("#ililceustbaslik").text("Yeni");
        }
    }
    );
});
$(function () {
    $(".select2").select2();
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    //Tree Grid
    $('.TreeGrid').treegrid({
        expanderExpandedClass: 'glyphicon glyphicon-minus',
        expanderCollapsedClass: 'glyphicon glyphicon-plus',
        initialState: 'collapsed'
    });
    $("#kargoTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    $("#bankaTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    $("#yerTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    $("#nedenTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    $("#siparisTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    var image_holder = $("#image-holder");
    $("#blogresim").on("change", function () {
        if (typeof (FileReader) != "undefined") {
            image_holder.empty();
            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image img-responsive",
                    "style": "width:auto;max-width:100%;heaight:auto;max-height:100%;"
                }).appendTo(image_holder);
            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            //alert("This browser does not support FileReader.");
        }

    });
    $("#kargovazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleKargo").click();
    });
    $("#bankavazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleBanka").click();
    });
    $("#yervazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleYer").click();
        $(".hidden-first").fadeOut();
    });
    $("#nedenvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleNeden").click();
        $(".hidden-first").fadeOut();
    });
    $("#ilcevazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleIlIlce").click();
        $(".hidden-first").fadeOut();
    });
    $("#ilvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleIlIlce").click();
        $(".hidden-first").fadeOut();
    });
    $("#siparisvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleSiparis").click();
        $(".hidden-first").fadeOut();
    });
    $("#siparisdurum").on("change", function () {
        var val = $(this).val();
        if (val == "3") {
            $(".kargoForm").fadeIn();
        } else {
            $(".kargoForm").fadeOut();
        }
    });
});