$(document).ready(function () {
///////////////////////Kurumsal Üye İşlemleri///////////////////////////////////////
    //kurumsal üye düzenleme
    $(document).on('click', 'a#kuyeDetay', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminUyeMail/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "kUyeDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#uyelikBilgiSiparis").hide();
                        $("#uyeBilgiler").show();
                        $("#kurSipTable").empty();
                        //üyelik bilgi
                        if (cevap.result[0]) {
                            $("#uyelikBilgiSiparis").show();
                            var siplength = cevap.result[0].length;
                            $("#headtoplamTutar").text(cevap.result[2].TTutar);
                            $("#headtoplamSip").text(cevap.result[2].SipCount);
                            for (var i = 0; i < siplength; i++) {
                                $("#kurSipTable").append("<tr>"
                                        + "<td>" + cevap.result[0][i].No + "</td>"
                                        + "<td>" + cevap.result[0][i].Tarih + "</td>"
                                        + "<td>" + cevap.result[0][i].TTutar + "</td>"
                                        + "<td class='text-right'><a id='spDetay-" + i + "' href='" + SITE_URL + "/Admin/Siparis' class='btn btn-primary btn-sm' title='Detaylar'>"
                                        + "<i class='fa fa-eye'></i></a></td></tr>");
                            }
                        }
                        $("#kuyeustbaslik").text(cevap.result[1].AdSoyad + " Üye");
                        $("#kuyeadSoyad").text(cevap.result[1].AdSoyad);
                        $("#kuyetarih").text(cevap.result[1].Tarih);
                        $("#kuyekurumad").text(cevap.result[1].KurumAd);
                        $("#kuyekurumtel").text(cevap.result[1].KurumTel);
                        $("#kuyeemail").text(cevap.result[1].EPosta);
                        $("#kuyetel").text(cevap.result[1].Telefon);
                        $("#kuyeadres").text(cevap.result[1].Adres);
                        $("#kuyevd").text(cevap.result[1].VergiD);
                        $("#kuyevno").text(cevap.result[1].VergiNo);
                    }
                }
            }
        });
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleKurumsalUye").click();
        }

    });
    //buton toggle
    $(document).on('click', 'button#formToggleKurumsalUye', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("#kuyeadSoyad").text("");
                $("#kuyetarih").text("");
                $("#kuyekurumad").text("");
                $("#kuyekurumtel").text("");
                $("#kuyeemail").text("");
                $("#kuyetel").text("");
                $("#kuyeadres").text("");
                $("#kuyevd").text("");
                $("#kuyevno").text("");
                $("#uyeBilgiler").hide();
                $("#uyelikBilgiSiparis").hide();
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("input[name=duzenlemeUstID]").val(-1);
                $("#kuyeustbaslik").text("Üye");
            }
        } else {
            $("#kuyeadSoyad").text("");
            $("#kuyetarih").text("");
            $("#kuyekurumad").text("");
            $("#kuyekurumtel").text("");
            $("#kuyeemail").text("");
            $("#kuyetel").text("");
            $("#kuyeadres").text("");
            $("#kuyevd").text("");
            $("#kuyevno").text("");
            $("#uyeBilgiler").hide();
            $("#uyelikBilgiSiparis").hide();
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("input[name=duzenlemeUstID]").val(-1);
            $("#kuyeustbaslik").text("Üye");
        }
    });
    ///////////////////////Bireysel Üye İşlemleri///////////////////////////////////////
    //bireysel üye düzenleme
    $(document).on('click', 'a#buyeDetay', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminUyeMail/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "bUyeDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#uyelikBilgiSiparis").hide();
                        $("#uyeBilgiler").show();
                        $("#birSipTable").empty();
                        //üyelik bilgi
                        if (cevap.result[0]) {
                            $("#uyelikBilgiSiparis").show();
                            var siplength = cevap.result[0].length;
                            $("#headtoplamTutar").text(cevap.result[2].TTutar);
                            $("#headtoplamSip").text(cevap.result[2].SipCount);
                            for (var i = 0; i < siplength; i++) {
                                $("#birSipTable").append("<tr>"
                                        + "<td>" + cevap.result[0][i].No + "</td>"
                                        + "<td>" + cevap.result[0][i].Tarih + "</td>"
                                        + "<td>" + cevap.result[0][i].TTutar + "</td>"
                                        + "<td class='text-right'><a id='spDetay-" + i + "' href='" + SITE_URL + "/Admin/Siparis' class='btn btn-primary btn-sm' title='Detaylar'>"
                                        + "<i class='fa fa-eye'></i></a></td></tr>");
                            }
                        }
                        $("#buyeustbaslik").text(cevap.result[1].AdSoyad + " Üye");
                        $("#buyeadSoyad").text(cevap.result[1].AdSoyad);
                        $("#buyetarih").text(cevap.result[1].Tarih);
                        $("#buyeemail").text(cevap.result[1].EPosta);
                        $("#buyetel").text(cevap.result[1].Telefon);
                        $("#buyeadres").text(cevap.result[1].Adres);
                    }
                }
            }
        });
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleBireyselUye").click();
        }

    });
    //buton toggle
    $(document).on('click', 'button#formToggleBireyselUye', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("#uyeBilgiler").hide();
                $("#uyelikBilgiSiparis").hide();
                $("#buyeadSoyad").text("");
                $("#buyetarih").text("");
                $("#buyeemail").text("");
                $("#buyetel").text("");
                $("#buyeadres").text("");
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("input[name=duzenlemeUstID]").val(-1);
                $("#buyeustbaslik").text("Üye");
            }
        } else {
            $("#uyeBilgiler").hide();
            $("#uyelikBilgiSiparis").hide();
            $("#buyeadSoyad").text("");
            $("#buyetarih").text("");
            $("#buyeemail").text("");
            $("#buyetel").text("");
            $("#buyeadres").text("");
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("input[name=duzenlemeUstID]").val(-1);
            $("#buyeustbaslik").text("Üye");
        }
    });
});
$(function () {
    $("#kuyeTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false
    });
    $("#buyeTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false
    });
    $("#uyeDetayKapat").on("click", function () {
        $("#formToggleKurumsalUye").click();
    });
    $("#biruyeDetayKapat").on("click", function () {
        $("#formToggleBireyselUye").click();
    });
});
