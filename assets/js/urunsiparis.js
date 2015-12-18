$(document).ready(function () {
    $("#formgirisyap").validate({
        rules: {
            girisemail: {
                required: true
            },
            girissifre: {
                required: true
            }
        }
    });
    $("#urunteslimat").validate({
        rules: {
            gndadsoyad: {
                required: true
            },
            gndmail: {
                required: true
            },
            aliciadsoyad: {
                required: true
            },
            alicitel: {
                required: true
            },
            aliciadres: {
                required: true
            },
            faturaunvan: {
                required: true
            },
            vd: {
                required: true
            },
            vn: {
                required: true
            },
            tcno: {
                required: true
            },
            faturaadres: {
                required: true
            }
        }
    });
    $("#urunkartodeme").validate({
        rules: {
            pan: {
                required: true
            },
            Ecom_Payment_Card_ExpDate_Month: {
                selectcheck: true
            },
            Ecom_Payment_Card_ExpDate_Year: {
                selectcheck: true
            },
            cv2: {
                required: true
            },
            cardType: {
                selectcheck: true
            },
            kartSatisSoz: {
                required: true
            }
        },
        messages: {
            pan: {
                required: "Lütfen kart numaranızı giriniz"
            },
            Ecom_Payment_Card_ExpDate_Month: {
                required: "Lütfen kartınızın yıl bilgisini giriniz"
            },
            Ecom_Payment_Card_ExpDate_Year: {
                required: "Lütfen kartınızın ay bilgisini giriniz"
            },
            cv2: {
                required: "Lütfen cvv numaranızı giriniz"
            },
            cardType: {
                required: "Lütfen kart tipini seçiniz"
            },
            kartSatisSoz: {
                required: "Lütfen satış sözleşmesini okuyup, onaylayınız."
            }
        }
    });
    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "Kullanıcı Türü Seçimi gereklidir.");
    $(document).on("click", "button#ekurunIlerle", function (e) {
        var length = $("ul.ekurunler li").length;
        var ekurunID = new Array();
        for (var ek = 0; ek < length; ek++) {
            ekurunID.push($("ul.ekurunler li:eq(" + ek + ")").attr("data-ekid"));
        }
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ekurunID[]": ekurunID, "tip": "orderekurun"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Delivery';
                    } else {
                        window.location.href = SITE_URL + '/Order/Login';
                    }
                }
            }
        });
    });
    $(document).on("click", "button#btnGiris", function (e) {
        var email = $("#girisemail").val();
        var sifre = $("#girissifre").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"email": email, "sifre": sifre, "tip": "girisYap"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.giris) {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Order/Delivery';
                        }
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Order/Delivery';
                        }
                    }
                }
            }
        });
    });
    $(document).on("click", "button#btnGirisYapma", function (e) {
        window.location.href = SITE_URL + '/Order/Delivery';
    });
    $(document).on("click", "button#teslimatIleri", function (e) {
        var gndadsoyad = $("#gndadsoyad").val();
        var gndmail = $("#gndmail").val();
        var gndtel = $("#gndTel").val();
        var gndndnTxt = $("#gonderimNedeni option:selected").text();
        var gndndnID = $("#gonderimNedeni option:selected").val();
        var alcadsoyad = $("#aliciadsoyad").val();
        var alctel = $("#alicitel").val();
        var siparisnotu = $("#siparisnotu").val();
        var alcgityertext = $("#gidecegiYer option:selected").text();
        var alcgityerid = $("#gidecegiYer option:selected").val();
        var alcadres = $("#aliciadres").val();
        var alcadresdetay = $("#aliciadresdetay").val();
        var okfis = $('#fisradio').is(":checked");
        var okfatura = $('#faturaradio').is(":checked");
        var ftrunvan = $("#faturaunvan").val();
        var vd = $("#vd").val();
        var vn = $("#vn").val();
        var tcno = $("#tcno").val();
        var ftradres = $("#faturaadres").val();
        var kartisim = $("#kartisim").val();
        var kartmesaj = $("#kartmesaji").val();
        var onaylama = $('#onayCheck').is(":checked");
        var length = $("ul.ekurunler li").length;
        var ekurunID = new Array();
        for (var ek = 0; ek < length; ek++) {
            ekurunID.push($("ul.ekurunler li:eq(" + ek + ")").attr("data-ekid"));
        }
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"gndadsoyad": gndadsoyad, "gndmail": gndmail, "gndtel": gndtel, "gndndnTxt": gndndnTxt,
                "gndndnID": gndndnID, "alcadsoyad": alcadsoyad, "alctel": alctel, "siparisnotu": siparisnotu, "alcgityertext": alcgityertext,
                "alcgityerid": alcgityerid, "alcadres": alcadres, "alcadresdetay": alcadresdetay, "okfis": okfis,
                "okfatura": okfatura, "ftrunvan": ftrunvan, "vd": vd, "vn": vn,
                "tcno": tcno, "ftradres": ftradres, "kartisim": kartisim, "kartmesaj": kartmesaj,
                "onaylama": onaylama, "ekurunID[]": ekurunID, "tip": "teslimatBilgi"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Card';
                    } else {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    }
                }
            }
        });
    });
    $(document).on("click", "button#spHavaleTamamla", function (e) {
        var hss = $('#havaleSatisSoz').is(":checked");
        var bankaVal = $("#banka option:selected").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"hss": hss, "bankaVal": bankaVal, "tip": "havaleSiparis"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Access';
                    }
                }
            }
        });
    });
    $(document).on("click", "button#spTelefonTamamla", function (e) {
        var tss = $('#telSatisSoz').is(":checked");
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"tss": tss, "tip": "telefonSiparis"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Access';
                    }
                }
            }
        });
    });
    $(document).on("click", "button#gotoHomeCard", function (e) {
        window.location.href = SITE_URL;
    });
    $(document).on("click", "button#gotoHomePhone", function (e) {
        window.location.href = SITE_URL;
    });
    $(document).on("click", "button#gotoHomeHavale", function (e) {
        window.location.href = SITE_URL;
    });

    var bankhatamesaj = $("#bankhatamesaj").val();
    if (bankhatamesaj != undefined) {
        if (bankhatamesaj != "") {
            reset();
            alertify.alert(bankhatamesaj);
            return false;
        }
    }
});