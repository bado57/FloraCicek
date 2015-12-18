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
    $(document).on("click", "#sipTakibi", function (e) {
        $("#siparisTakipNo").val("");
        $("#spSorguMail").val("");
        $("#sipSorgulama").show();
        $("#sipaccordion").hide();
    });
    $(document).on("click", "#siparisArama", function (e) {
        var sipKod = $("#siparisTakipNo").val();
        var sipMail = $("#spSorguMail").val();
        $.ajax({
            type: "post",
            url: SITE_URL + "/Genel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"sipMail": sipMail, "sipKod": sipKod, "tip": "siparisDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#sipSorgulama").hide();
                        $("#sipaccordion").show();
                        $("#urunSip").empty();
                        $("#siparisbilgileri").show();
                        $("#urunbilgileri").show();
                        $("#müsteribilgileri").show();
                        $("#faturabilgileri").show();
                        $("#teslimatbilgileri").show();

                        ////// Bilgiler
                        $("#sipDurum").text(cevap.result[0].SDurum);
                        $("#sipAdminNot").text(cevap.result[0].SAdminNot);
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
                                var urunresulttip = "";
                                if (cevap.result[1][i].SUTip != 0) {
                                    urunresulttip = "Ek Ürün";
                                } else {
                                    urunresulttip = "Ana Ürün";
                                }
                                $("#urunSip").append("<tr>"
                                        + "<td id='urunkod'>" + cevap.result[1][i].SUKod + "/" + cevap.result[1][i].SUAd + "</td>"
                                        + "<td id='urunbirimfiyat'>" + cevap.result[1][i].SUTtar + "</td>"
                                        + "<td id='urunmiktar'>" + cevap.result[1][i].SUMiktar + "</td>"
                                        + "<td id='uruntutar'>" + cevap.result[1][i].SUTplmTutar + " TL</td></tr>");

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
                        ///// ----- Bilgiler
                        $("#tslmtgndndn").text(cevap.result[0].SGndNdn);
                    }
                }
            }
        });
    });
});