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
                    }
                }
            }
        });
    });
    $(document).on("click", "button#spKartTamamla", function (e) {
        var kartNo = $("#kartno").val();
        var kartSonAyText = $("#kartAy option:selected").text();
        var kartSonYilText = $("#kartYil option:selected").text();
        var cvv = $("#cvv").val();
        var mss = $('#kartSatisSoz').is(":checked");
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"mss": mss, "kartNo": kartNo, "kartSonAyText": kartSonAyText, "kartSonYilText": kartSonYilText,
                "cvv": cvv, "tip": "kartSiparis"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Onay';
                    }
                }
            }
        });
    });
    $(document).on("click", "button#spHavaleTamamla", function (e) {
        var hss = $('#havaleSatisSoz').is(":checked");
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"hss": hss, "tip": "havaleSiparis"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Onay';
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
                        window.location.href = SITE_URL + '/Order/Onay';
                    }
                }
            }
        });
    });
});