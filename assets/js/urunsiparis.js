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
        alert("deneme");
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
                        alert(cevap.giris);
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
                "gndndnID": gndndnID, "alcadsoyad": alcadsoyad, "alctel": alctel, "alcgityertext": alcgityertext,
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
                    } else if (cevap.result == 0) {
                        window.location.href = SITE_URL + '/Order/Card';
                    }
                }
            }
        });
    });
    $(document).on("click", "button#odemeIleri", function (e) {
        var kartNo = $("#kartno").val();
        var kartSonAyText = $("#kartAy option:selected").text();
        var kartSonAyID = $("#kartAy option:selected").val();
        var kartSonYilText = $("#kartYil option:selected").text();
        var kartSonYilID = $("#kartYil option:selected").val();
        var cvv = $("#cvv").val();
        var ucd = $('#3dsecure').is(":checked");
        var kartsatisSoz = $('#kartSatisSoz').is(":checked");
        var bankaText = $("#banka option:selected").text();
        var bankaID = $("#banka option:selected").val();
        var havaleSatisSoz = $("#havaleSatisSoz option:selected").val();
        var telSatisSoz = $("#telSatisSoz option:selected").val();
    });
});