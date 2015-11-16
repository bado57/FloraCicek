$(document).ready(function () {

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
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Admin/Panel';
                    } else {
                        window.location.href = SITE_URL;
                    }
                }
            }
        });
    });

    $(document).on("click", "button#btnHatirlat", function (e) {
        var email = $("#unutemail").val();
        var randomsayi = $("#randomsayi").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"email": email, "randomsayi": randomsayi, "tip": "sifreHatirlat"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    reset();
                    alertify.alert(cevap.result);
                    return false;
                }
            }
        });
    });

    $(document).on("click", "button#biruyeol", function (e) {
        var adSoyad = $("#birAdSoyad").val();
        var email = $("#birEmail").val();
        var sifre = $("#birSifre").val();
        var sifreTkrar = $("#birSifreTekrar").val();
        var kmpnya = $('#kmp-bireysel').is(":checked");
        var uyesoz = $('#uyesoz-bireysel').is(":checked");
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"adSoyad": adSoyad, "email": email, "sifre": sifre,
                "sifreTkrar": sifreTkrar, "kmpnya": kmpnya, "uyesoz": uyesoz, "tip": "birUye"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL;
                    }
                }
            }
        });
    });

    $(document).on("click", "button#kuruyeol", function (e) {
        var adSoyad = $("#kurAdSoyad").val();
        var email = $("#kurEmail").val();
        var sifre = $("#kurSifre").val();
        var sifreTkrar = $("#kurSifreTekrar").val();
        var kurAdi = $("#kurAdi").val();
        var kurVDaire = $("#kurVDaire").val();
        var kurVNo = $("#kurVNo").val();
        var kurVTel = $("#kurVTel").val();
        var adres = $("#adres").val();
        var kmpnya = $('#kmp-bireysel').is(":checked");
        var uyesoz = $('#uyesoz-bireysel').is(":checked");
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"adSoyad": adSoyad, "email": email, "sifre": sifre,
                "sifreTkrar": sifreTkrar, "kmpnya": kmpnya, "uyesoz": uyesoz,
                "kurAdi": kurAdi, "kurVDaire": kurVDaire, "kurVNo": kurVNo,
                "kurVTel": kurVTel, "adres": adres, "tip": "kurUye"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL;
                    }
                }
            }
        });
    });
});