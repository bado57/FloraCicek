$(document).ready(function () {
    $.ajax({
        type: "post",
        url: SITE_URL + "/Genel/ajaxCall",
        cache: false,
        dataType: "json",
        data: {"tip": "urunIl"},
        success: function (cevap) {
            if (cevap.hata) {
                reset();
                alertify.alert(cevap.hata);
                return false;
            } else {
                var length = cevap.result.length;
                for (var il = 0; il < length; il++) {
                    $("#sehirSec").append("<option value='" + cevap.result[il].ID + "'>" + cevap.result[il].Ad + "</option>");
                }
            }
        }
    });
    $(document).on("click", "button#urunSipVer", function (e) {
        var urunID = $("#urunID").val();
        var ilText = $("#sehirSec option:selected").text();
        var ilceText = $("#ilceSec option:selected").text();
        var tarih = $("#tarihSec").val();
        var pKodu = $("#postaKoduSec").val();
        var saat = $("#saatSec option:selected").text();
        var ilID = $("#sehirSec option:selected").val();
        var ilceID = $("#ilceSec option:selected").val();
        var saatID = $("#saatSec option:selected").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"urunID": urunID, "ilText": ilText, "ilceText": ilceText, "tarih": tarih, "pKodu": pKodu, "saat": saat,
                "ilID": ilID, "ilceID": ilceID, "saatID": saatID, "tip": "urunDetay"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result == 1) {
                        window.location.href = SITE_URL + '/Order/Product';
                    }
                }
            }
        });
    });
    $("#sehirSec").on('change', function () {
        $("#ilceSec option:not(:first)").remove();
        var ilid = $(this).val();
        if (ilid != 0) {
            $.ajax({
                type: "post",
                url: SITE_URL + "/Genel/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ilid": ilid, "tip": "urunIlce"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        var length = cevap.result.length;
                        for (var ilce = 0; ilce < length; ilce++) {
                            if (cevap.result[ilce].EkUcret != 0) {
                                $("#ilceSec").append("<option value='" + cevap.result[ilce].ID + "'>" + cevap.result[ilce].Ad + " " + "(+" + cevap.result[ilce].EkUcret + " TL)" + "</option>");
                            } else {
                                $("#ilceSec").append("<option value='" + cevap.result[ilce].ID + "'>" + cevap.result[ilce].Ad + " " + "</option>");
                            }
                        }
                    }
                }
            });
        } else {
            alert("Lütfen bir il seçiniz..");
        }
    });
    $("#furunsiparis").validate({
        rules: {
            sehirSec: {
                selectcheck: true
            },
            ilceSec: {
                selectcheck: true
            },
            semtSec: {
                selectcheck: true
            },
            mahalleSec: {
                selectcheck: true
            },
            tarihSec: {
                required: true
            },
            saatSec: {
                selectcheck: true
            }
        }
    });
    jQuery.validator.addMethod('selectcheck', function (value) {
        return (value != '0');
    }, "Bu Alan Gereklidir.");
});
$(function () {
    $(".select2").select2();
});