$(document).ready(function () {
    $(document).on('click', 'button#formToggleKampanya', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#kampanyabaslik").val("");
                $("#baslamatarihi").val("");
                $("#bitistarihi").val("");
                $("#indirimyuzde").val("");
                $("#kategoriler").select2("val", 0);
                $("#aktiflik").select2("val", 0);
                CKEDITOR.instances['kampanyayazi'].setData("");
                $("#kampanyaustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#kampanyabaslik").val("");
            $("#baslamatarihi").val("");
            $("#bitistarihi").val("");
            $("#indirimyuzde").val("");
            $("#kategoriler").select2("val", 0);
            $("#aktiflik").select2("val", 0);
            CKEDITOR.instances['kampanyayazi'].setData("");
            $("#kampanyaustbaslik").text("Yeni");
        }
    });
    $(document).on('click', 'a#kampanyaSil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminKampanya/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "kampanyaSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Kampanya';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Kampanya';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
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
    $(document).on('click', 'a#kampanyaDuzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminKampanya/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "kampanyaDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        console.log(cevap.result);
                        $("#kampanyabaslik").val(cevap.result.Baslik);
                        $("#baslamatarihi").val(cevap.result.BsTarih);
                        $("#bitistarihi").val(cevap.result.BtTarih);
                        $("#indirimyuzde").val(cevap.result.Yuzde);
                        CKEDITOR.instances['kampanyayazi'].setData(cevap.result.Yazi);
                        $("#kategoriler").select2("val", 0);
                        $("#aktiflik").select2("val", cevap.result.Aktif);
                        $("#kampanyaustbaslik").text(cevap.result.Baslik);
                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(cevap.result.ID);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggleKampanya").click();
                        }
                    }
                }
            }
        });
    });
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
    $("#baslamatarihi").datepicker({
        dateFormat: 'dd/mm/yy',
        onClose: function (selectedDate) {
            $("#bitistarihi").datepicker("option", "minDate", selectedDate);
        }
    });
    $("#bitistarihi").datepicker({
        dateFormat: 'dd/mm/yy',
        onClose: function (selectedDate) {
            $("#baslamatarihi").datepicker("option", "maxDate", selectedDate);
        }
    });

    $(document).on("click", "#baslamatarihBtn", function () {
        $("#baslamatarihi").focus();
    });

    $(document).on("click", "#bitistarihBtn", function () {
        $("#bitistarihi").focus();
    });

    $("#indirimyuzde").on("keyup", function () {
        var val = $(this).val();
        if (val != "") {
            $("#ind").html("% " + val);
            $(".has-warning").fadeIn();
        } else {
            $("#ind").html("");
            $(".has-warning").fadeOut();
        }

    });
    $("#kampanyaTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
    $("#kampanyavazgec").on("click", function () {
        $("#formToggleKampanya").click();
    });
});