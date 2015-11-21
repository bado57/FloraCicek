$(document).ready(function () {
    $(document).on("click", "a#urunTab", function (e) {
        $("a#urunTab").each(function () {
            $(this).removeClass('active');
        });
        var tab = $(this).attr("data-tab");
        var index = tab - 1;
        $("#tabClick div div:eq(" + index + ") a").addClass('active');
        var katID = $("div#katID").attr("data-value");
        var katTip = $("div#katTip").attr("data-value");
        $("#tabs-container").addClass('loading');
        $("#tabs-container").fadeOut('fast');
        $("#features_items").empty();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"katID": katID, "katTip": katTip, "tab": tab, "tip": "urunTab"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    var length = cevap.result.length;
                    for (var ur = 0; ur < length; ur++) {
                        if (cevap.result[ur].KID == undefined) {
                            $("#features_items").append("<div class='col-sm-3 col-xs-6'><div class='product-image-wrapper'>"
                                    + "<div class='single-products'><div class='productinfo text-center'>"
                                    + "<div class='imgThumb'>"
                                    + "<img class='urunlerTab' src='" + SITE_URL + "/products/" + cevap.result[ur].urunResim + "' alt='' />"
                                    + "</div>"
                                    + "<p>" + cevap.result[ur].urunAd + "<br /> <small>Ürün Kodu : " + cevap.result[ur].urunKod + "</small></p>"
                                    + "<h2>" + cevap.result[ur].urunFiyat + " TL</h2>"
                                    + "<a href='" + cevap.result[ur].urunUrl + "' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Sipariş Ver</a>"
                                    + "</div></div></div></div>");
                        } else {
                            var indfiyat = cevap.result[ur].urunFiyat - Math.round((cevap.result[ur].urunFiyat * cevap.result[ur].KYuzde) / 100);
                            $("#features_items").append("<div class='col-sm-3 col-xs-6'><div class='product-image-wrapper'>"
                                    + "<div class='single-products'><div class='productinfo text-center'>"
                                    + "<div class='imgThumb'>"
                                    + "<img class='urunlerTab' src='" + SITE_URL + "/products/" + cevap.result[ur].urunResim + "' alt='' />"
                                    + "</div>"
                                    + "<p>" + cevap.result[ur].urunAd + "<br /> <small>Ürün Kodu : " + cevap.result[ur].urunKod + "</small></p>"
                                    + "<h2><span>" + cevap.result[ur].urunFiyat + " TL </span>" + indfiyat + " TL</h2>"
                                    + "<a href='" + cevap.result[ur].urunUrl + "' class='btn btn-default add-to-cart'><i class='fa fa-shopping-cart'></i>Sipariş Ver</a>"
                                    + "</div></div></div></div>");
                        }
                    }
                    $("#tabs-container").removeClass('loading');
                    $("#tabs-container").fadeIn('fast');
                }
            }
        });
    });

    $(document).on("click", "a#cikisYap", function (e) {
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"tip": "cikisYap"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    window.location.href = SITE_URL;
                }
            }
        });
    });

    $(document).on("click", "#btnebulten", function (e) {
        var email = $("#inputebulten").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"email": email, "tip": "ebulten"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    $("#h2ebulten").hide();
                    $("#divebulten").hide();
                    reset();
                    alertify.alert(cevap.result);
                    return false;
                }
            }
        });
    });
});
