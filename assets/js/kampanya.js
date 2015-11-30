$(document).ready(function () {
    var katkampDegerler = "";
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
                if (katkampDegerler != "") {
                    //daha önceden kalan kategori varsa onları temizliyorum
                    var arr = katkampDegerler.split(',');
                    var length = arr.length;
                    for (var l = 0; l < length; l++) {
                        $("#kategoriler option[value='" + arr[l] + "']").remove();
                    }
                    $("#kategoriler").change();
                }
                $("#kategoriler").change();
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
            if (katkampDegerler != "") {
                //daha önceden kalan kategori varsa onları temizliyorum
                var arr = katkampDegerler.split(',');
                var length = arr.length;
                for (var l = 0; l < length; l++) {
                    $("#kategoriler option[value='" + arr[l] + "']").remove();
                }
                $("#kategoriler").change();
            }
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
    $(document).on('click', '#kampanyakaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var kmpbaslik = $("#kampanyabaslik").val();
            var baslamaTarh = $("#baslamatarihi").val();
            var btsTarih = $("#bitistarihi").val();
            var yuzde = $("#indirimyuzde").val();
            var kmpYazi = CKEDITOR.instances['kampanyayazi'].getData();
            var aktiflik = $("#aktiflik").val();
            var urunKatVal = $("#kategoriler").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminKampanya/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"kmpbaslik": kmpbaslik, "baslamaTarh": baslamaTarh, "btsTarih": btsTarih,
                    "yuzde": yuzde, "kmpYazi": kmpYazi, "aktiflik": aktiflik, "urunKatVal[]": urunKatVal, "tip": "kampanyaEkle"},
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
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var kmpbaslik = $("#kampanyabaslik").val();
            var baslamaTarh = $("#baslamatarihi").val();
            var btsTarih = $("#bitistarihi").val();
            var yuzde = $("#indirimyuzde").val();
            var kmpYazi = CKEDITOR.instances['kampanyayazi'].getData();
            var aktiflik = $("#aktiflik").val();
            var urunKatVal = $("#kategoriler").val();
            var urunEskiKatVal = $("input[name=eskikatval]").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminKampanya/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "kmpbaslik": kmpbaslik, "baslamaTarh": baslamaTarh, "btsTarih": btsTarih,
                    "yuzde": yuzde, "kmpYazi": kmpYazi, "aktiflik": aktiflik, "urunKatVal[]": urunKatVal,
                    "urunEskiKatVal[]": urunEskiKatVal, "tip": "kampanyaDuzenle"},
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
                        if (katkampDegerler != "") {
                            //daha önceden kalan kategori varsa onları temizliyorum
                            var arr = katkampDegerler.split(',');
                            var length = arr.length;
                            for (var l = 0; l < length; l++) {
                                $("#kategoriler option[value='" + arr[l] + "']").remove();
                            }
                            $("#kategoriler").change();
                        }
                        $("#kampanyabaslik").val(cevap.result[0][0].Baslik);
                        $("#baslamatarihi").val(cevap.result[0][0].BsTarih);
                        $("#bitistarihi").val(cevap.result[0][0].BtTarih);
                        $("#indirimyuzde").val(cevap.result[0][0].Yuzde);
                        CKEDITOR.instances['kampanyayazi'].setData(cevap.result[0][0].Yazi);
                        $("#aktiflik").select2("val", cevap.result[0][0].Aktif);
                        $("#kampanyaustbaslik").text(cevap.result[0][0].Baslik);
                        katkampDegerler = cevap.result[0][0].Kategori;
                        //kampanya kategorileri
                        if (cevap.result[1]) {
                            var katkamplength = cevap.result[1].length;
                            for (var kk = 0; kk < katkamplength; kk++) {
                                var select = $('#kategoriler');
                                var option = $('<option></option>').attr('selected', true).text(cevap.result[1][kk].Adi).val(cevap.result[1][kk].ID);
                                option.appendTo(select);
                                select.trigger('change');
                            }
                        }

                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(cevap.result[0][0].ID);
                        $("input[name=eskikatval]").val(cevap.result[0][0].Kategori);
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