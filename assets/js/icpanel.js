$(document).ready(function () {
    yardir();
    //table düzenle butonları
    $(document).on('click', 'a#KatDuzenle', function (e) {
        var ustID = $(this).parent().parent().attr('data-ust');
        var ID = $(this).parent().parent().attr('id');
        var katAdi = $("#katad" + ID).attr('data-katad');
        var katDurum = $("#katdurum" + ID).attr('data-aktif');
        var katSira = $("#katsira" + ID).text();
        var yazi = $("input[name=" + ID + "]").val();
        $("#kategoriadi").val(katAdi);
        $("#sira").val(katSira);
        $("#kategoriyazisi").val(yazi);
        $("#aktiflik").select2("val", katDurum);
        if (ustID > 0) {
            $('#ustkategori').select2('enable', true);
            $("#ustkategori").select2("val", ustID);
            if (!$('#0select2').prop('disabled') == true) {
                $('#0select2').prop('disabled', !$('#0select2').prop('disabled'));
                $('select').select2();
            }
        } else {
            $("#ustkategori").select2("val", 0);
            $('#ustkategori').select2('enable', false);
        }
        $("#katustbaslik").text(katAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        $("input[name=duzenlemeUstID]").val(ustID);
        $("input[name=normalSira]").val(katSira);
        $("input[name=normalUstKategori]").val(ustID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#btnkayanekleme").click();
        }

    });
    //silme butonu
    $(document).on('click', 'a#KatSilme', function (e) {
        var ustID = $(this).parent().parent().attr('data-ust');
        var ID = $(this).parent().parent().attr('id');
        var altkatvar = 0;
        if (ustID == 0) {//üst kategoridir
            var trlength = $("#tabletbody tr").length;
            for (var a = 0; a < trlength; a++) {
                var ust = $("#tabletbody tr:eq(" + a + ")").attr("data-ust");
                if (ust == ID) {
                    altkatvar = 1;
                }
            }
        }
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminGenel/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ustID": ustID, "ID": ID, "altkatvar": altkatvar, "tip": "kategoriSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/UrunKategori';
                            } else {
                                window.location.href = SITE_URL + '/Admin/UrunKategori';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
    //vazgeç butonu clickleri
    $(document).on('click', 'input#vazgec', function (e) {
        $("#btnkayanekleme").click();
        $("#kategoriadi").val("");
        $("#sira").val("");
        $("#kategoriyazisi").val("");
        $("#aktiflik").select2("val", 0);
        $("#ustkategori").select2("val", 0);
        $("#katustbaslik").text("Yeni");
        $("input[name=kapaliacik]").val(0);
        $("input[name=duzenleme]").val(0);
        $("input[name=duzenlemeID]").val(-1);
        $("input[name=duzenlemeUstID]").val(-1);
    });
    //buton kaydet
    $(document).on('click', 'input#kaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var katAdi = $("#kategoriadi").val();
            var data = $('#ustkategori').select2('data')[0];
            var ustKatText = data.text;
            var ustKatVal = $("#ustkategori").val();
            var sira = $("#sira").val();
            var maksSira = 0;
            if (ustKatVal != 0) {
                var trlength = $("#tabletbody tr").length;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#tabletbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == ustKatVal) {
                        var trID = $("#tabletbody tr:eq(" + a + ")").attr("id");
                        var altKatSira = $("#katsira" + trID).text();
                        if (maksSira < altKatSira) {
                            maksSira = altKatSira;
                        }
                    }
                }
            } else {
                var trlength = $("#tabletbody tr").length;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#tabletbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == 0) {
                        var trID = $("#tabletbody tr:eq(" + a + ")").attr("id");
                        var sirasi = $("#katsira" + trID).text();
                        if (maksSira < sirasi) {
                            maksSira = sirasi;
                        }
                        if (sirasi == sira) {
                            var degisecekID = trID;
                        }
                    }
                }
            }
            var durum = $("#aktiflik").val();
            var katYazi = $("#kategoriyazisi").val();
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"katAdi": katAdi, "ustKatText": ustKatText, "ustKatVal": ustKatVal, "altKatSira": altKatSira,
                    "durum": durum, "sira": sira, "katYazi": katYazi, "sonUstSira": maksSira, "degisecekID": degisecekID,
                    "trID": trID, "tip": "kategoriEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/UrunKategori';
                        } else {
                            window.location.href = SITE_URL + '/Admin/UrunKategori';
                        }
                    }
                }
            });
        } else {//düzenleme
            var katAdi = $("#kategoriadi").val();
            var normalkatAdi = $("#katustbaslik").text();
            var ustKatVal = $("#ustkategori").val();
            var sira = $("#sira").val();
            var durum = $("#aktiflik").val();
            var katYazi = $("#kategoriyazisi").val();
            var duzenlenenID = $("input[name=duzenlemeID]").val();
            var normalSira = $("input[name=normalSira]").val();
            var normalUstKatID = $("input[name=normalUstKategori]").val();
            var degisecekID = 0;
            var maksSira = 0;
            if (ustKatVal != 0) {//alt ketgori
                if (normalSira != sira) {
                    var trlength = $("#tabletbody tr").length;
                    for (var a = 0; a < trlength; a++) {
                        var ust = $("#tabletbody tr:eq(" + a + ")").attr("data-ust");
                        if (ust == ustKatVal) {
                            var trID = $("#tabletbody tr:eq(" + a + ")").attr("id");
                            var altKatSira = $("#katsira" + trID).text();
                            var aynıustfarklialtSira = altKatSira;
                            if (maksSira < altKatSira) {
                                maksSira = altKatSira;
                            }
                            if (altKatSira == sira) {
                                degisecekID = trID;
                            }
                        }
                    }
                }
            } else {//üst kategori
                if (normalSira != sira) {
                    var trlength = $("#tabletbody tr").length;
                    for (var a = 0; a < trlength; a++) {
                        var ust = $("#tabletbody tr:eq(" + a + ")").attr("data-ust");
                        if (ust == 0) {
                            var trID = $("#tabletbody tr:eq(" + a + ")").attr("id");
                            var sirasi = $("#katsira" + trID).text();
                            if (maksSira < sirasi) {
                                maksSira = sirasi;
                            }
                            if (sirasi == sira) {
                                degisecekID = trID;
                            }
                        }
                    }
                }
            }
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"katAdi": katAdi, "normalkatAdi": normalkatAdi, "ustKatVal": ustKatVal, "altKatSira": altKatSira,
                    "durum": durum, "sira": sira, "katYazi": katYazi, "sonUstSira": maksSira, "degisecekID": degisecekID,
                    "trID": trID, "duzenlenenID": duzenlenenID, "normalSira": normalSira, "normalUstKatID": normalUstKatID,
                    "aynıustfarklialtSira": aynıustfarklialtSira, "tip": "kategoriDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/UrunKategori';
                        } else {
                            window.location.href = SITE_URL + '/Admin/UrunKategori';
                        }
                    }
                }
            });
        }
    });
    //buton kayan
    $(document).on('click', 'button#btnkayanekleme', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("input[name=duzenlemeUstID]").val(-1);
                $('#ustkategori').select2('enable', true);
                $("#kategoriadi").val("");
                $("#sira").val("");
                $("#kategoriyazisi").val("");
                $("#aktiflik").select2("val", 0);
                $("#ustkategori").select2("val", 0);
                $("#katustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("input[name=duzenlemeUstID]").val(-1);
            $("#kategoriadi").val("");
            $("#sira").val("");
            $("#kategoriyazisi").val("");
            $("#aktiflik").select2("val", 0);
            $("#ustkategori").select2("val", 0);
            $("#katustbaslik").text("Yeni");
        }
    });
    //////////////////////////////////////////////////////////////////
    //ürünler
    $(document).on('click', 'button#formToggle', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                var urunetiketlabel = $("#etiketozellik>label").length;
                for (var e = 0; e < urunetiketlabel; e++) {
                    $("#etiketozellik>label:eq(" + e + ")>div").addClass("checked");
                    $("#etiketozellik>label:eq(" + e + ")>div>input").prop("checked", true);
                }
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#urunadi").val("");
                $("#urunkodu").val("");
                $("#urunfiyat").val("");
                $("#aktiflik").select2("val", 0);
                $("#urunkategori").select2("val", 0);
                $("#sira").val("");
                $("#urunyazisi").val("");
                $("#urunustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#urunadi").val("");
            $("#urunkodu").val("");
            $("#urunfiyat").val("");
            $("#aktiflik").select2("val", 0);
            $("#urunkategori").select2("val", 0);
            $("#sira").val("");
            $("#urunyazisi").val("");
            $("#urunustbaslik").text("Yeni");
        }
    });
    //buton ürün kaydet
    $(document).on('click', 'input#urunkaydet', function (e) {
        var formData = new FormData();
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var urunAdi = $("#urunadi").val();
            var urunKod = $("#urunkodu").val();
            var data = $('#urunkategori').select2('data')[0];
            var urunKatText = data.text;
            var urunKatVal = $("#urunkategori").val();
            var urunFiyat = $("#urunfiyat").val();
            var durum = $("#aktiflik").val();
            var sira = $("#sira").val();
            formData.append('file', $("#urunresim")[0].files[0]);
            var urunYazi = CKEDITOR.instances['urunyazisi'].getData();
            if (urunKatVal != 0) {//burada o kategori ile ilgili son ürünün sırasına bakılacak
                var trlength = $("#urunTbodyTable tr").length;
                var maxSira = 0;
                var siraolanurun = 0;
                var degisecekurunid = 0;
                for (var a = 0; a < trlength; a++) {
                    var katid = $("#urunTbodyTable tr:eq(" + a + ")").attr("data-katid");
                    if (katid == urunKatVal) {
                        var katID = $("#urunTbodyTable tr:eq(" + a + ")").attr("id");
                        var katSira = $("#urunsira" + katID).text();
                        if (katSira > 0) {
                            if (sira == katSira) {
                                degisecekurunid = $("#urunsira" + katID).parent().attr("id");
                                siraolanurun = 1;
                            }
                            if (maxSira < katSira) {
                                maxSira = katSira;
                            }
                        } else {
                            siraolanurun = 0;
                        }
                    }
                }
            }
            //ürün  özellikleri haftanın ürünü...
            var urunozelliklabel = $("#urunOzellik>label").length;
            var urunOzellikArray = new Array();
            for (var f = 0; f < urunozelliklabel; f++) {
                var boolean = $("#urunOzellik>label:eq(" + f + ")>div>input").prop("checked");
                if (boolean == true) {
                    urunOzellikArray.push(1);
                } else {
                    urunOzellikArray.push(0);
                }
            }
            //ürün etiketileri
            var urunetiketlabel = $("#etiketozellik>label").length;
            var urunEtiketArray = new Array();
            for (var e = 0; e < urunetiketlabel; e++) {
                var boolean = $("#etiketozellik>label:eq(" + e + ")>div>input").prop("checked");
                if (boolean == true) {//idlerini alıyoruz
                    urunEtiketArray.push($("#etiketozellik>label:eq(" + e + ")>div>input").attr("id"));
                }
            }
            formData.append('urunAdi', urunAdi);
            formData.append('urunKod', urunKod);
            formData.append('urunKatText', urunKatText);
            formData.append('siraolanurun', siraolanurun);
            formData.append('degisecekurunid', degisecekurunid);
            formData.append('maxSira', maxSira);
            formData.append('urunKatVal', urunKatVal);
            formData.append('urunFiyat', urunFiyat);
            formData.append('durum', durum);
            formData.append('sira', sira);
            formData.append('urunYazi', urunYazi);
            formData.append('urunOzellikArray[]', urunOzellikArray);
            formData.append('urunEtiketArray[]', urunEtiketArray);
            formData.append('tip', "urunEkle");

            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: formData,
                async: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Urun';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Urun';
                        }
                    }
                }
            });
        } else {//düzenleme
            var urunID = $("input[name=duzenlemeID]").val();
            var urunAdi = $("#urunadi").val();
            var urunKod = $("#urunkodu").val();
            var data = $('#urunkategori').select2('data')[0];
            var urunKatText = data.text;
            var urunKatVal = $("#urunkategori").val();
            var urunFiyat = $("#urunfiyat").val();
            var durum = $("#aktiflik").val();
            var sira = $("#sira").val();
            var normalSira = $("input[name=normalSira]").val();
            var imageKontrol = $("#image-holder img").length;
            var newimage = 0;
            if ($("#urunresim")[0].files[0] == undefined) {
                newimage = 0;
            } else {
                newimage = 1;
            }
            formData.append('file', $("#urunresim")[0].files[0]);
            formData.append('resimKontrol', imageKontrol);
            formData.append('newImage', newimage);
            formData.append('normalSira', normalSira);
            var urunYazi = CKEDITOR.instances['urunyazisi'].getData();
            if (normalSira != sira) {
                if (urunKatVal != 0) {//burada o kategori ile ilgili son ürünün sırasına bakılacak
                    var trlength = $("#urunTbodyTable tr").length;
                    var siraolanurun = 0;
                    var degisecekurunid = 0;
                    for (var a = 0; a < trlength; a++) {
                        var katid = $("#urunTbodyTable tr:eq(" + a + ")").attr("data-katid");
                        if (katid == urunKatVal) {
                            var katID = $("#urunTbodyTable tr:eq(" + a + ")").attr("id");
                            var katSira = $("#urunsira" + katID).text();
                            if (katSira > 0) {
                                if (sira == katSira) {
                                    degisecekurunid = $("#urunsira" + katID).parent().attr("id");
                                    siraolanurun = 1;
                                }
                            } else {
                                siraolanurun = 0;
                            }
                        }
                    }
                }
            }
            //ürün  özellikleri haftanın ürünü...
            var urunozelliklabel = $("#urunOzellik>label").length;
            var urunOzellikArray = new Array();
            for (var f = 0; f < urunozelliklabel; f++) {
                var boolean = $("#urunOzellik>label:eq(" + f + ")>div>input").prop("checked");
                if (boolean == true) {
                    urunOzellikArray.push(1);
                } else {
                    urunOzellikArray.push(0);
                }
            }
            //ürün etiketileri
            var urunetiketlabel = $("#etiketozellik>label").length;
            var urunEtiketArray = new Array();
            for (var e = 0; e < urunetiketlabel; e++) {
                var boolean = $("#etiketozellik>label:eq(" + e + ")>div>input").prop("checked");
                if (boolean == true) {//idlerini alıyoruz
                    urunEtiketArray.push($("#etiketozellik>label:eq(" + e + ")>div>input").attr("id"));
                }
            }
            formData.append('urunID', urunID);
            formData.append('urunAdi', urunAdi);
            formData.append('urunKod', urunKod);
            formData.append('urunKatText', urunKatText);
            formData.append('siraolanurun', siraolanurun);
            formData.append('degisecekurunid', degisecekurunid);
            formData.append('urunKatVal', urunKatVal);
            formData.append('urunFiyat', urunFiyat);
            formData.append('durum', durum);
            formData.append('sira', sira);
            formData.append('urunYazi', urunYazi);
            formData.append('urunOzellikArray[]', urunOzellikArray);
            formData.append('urunEtiketArray[]', urunEtiketArray);
            formData.append('tip', "urunDuzenle");

            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: formData,
                async: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Urun';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Urun';
                        }
                    }
                }
            });
        }
    });
    //silme butonu
    $(document).on('click', 'a#urunSil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminGenel/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "urunSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Urun';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Urun';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
    //table düzenle butonları
    $(document).on('click', 'a#urunDuzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminGenel/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "urunDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#urunadi").val(cevap.result[1].Adi);
                        $("#urunkodu").val(cevap.result[1].Kod);
                        $("#urunkategori").select2("val", cevap.result[1].KatID);
                        $("#urunfiyat").val(cevap.result[1].Fiyat);
                        $("#aktiflik").select2("val", cevap.result[1].Aktif);
                        $("#sira").val(cevap.result[1].Sira);
                        CKEDITOR.instances['urunyazisi'].setData(cevap.result[1].Aciklama);
                        if (cevap.result[1].HaftaUrun == 1) {
                            $("#haftaninurunu").prop('checked', true);
                            $("#haftaninurunu").parent().addClass("checked");
                        } else {
                            $("#haftaninurunu").prop('checked', false);
                            $("#haftaninurunu").parent().removeClass("checked");
                        }
                        if (cevap.result[1].CokSatan == 1) {
                            $("#coksatan").prop('checked', true);
                            $("#coksatan").parent().addClass("checked");
                        } else {
                            $("#coksatan").prop('checked', false);
                            $("#coksatan").parent().removeClass("checked");
                        }
                        if (cevap.result[1].Yeni == 1) {
                            $("#yeniurun").prop('checked', true);
                            $("#yeniurun").parent().addClass("checked");
                        } else {
                            $("#yeniurun").prop('checked', false);
                            $("#yeniurun").parent().removeClass("checked");
                        }
                        if (cevap.result[1].Resim) {
                            $("#image-holder").empty();
                            $("#image-holder").prepend('<img id="theImg" src="' + SITE_URL + '/products/' + cevap.result[1].Resim + '" class="thumb-image img-responsive urunresim" style="width:auto; max - width:100 % ; heaight:auto; max - height:100 % ; "/>');
                        }
                        var urunetiketlabel = $("#etiketozellik>label").length;
                        for (var e = 0; e < urunetiketlabel; e++) {
                            $("#etiketozellik>label:eq(" + e + ")>div").removeClass("checked");
                        }
                        if (cevap.result[0]) {
                            var urunetiketlabel = $("#etiketozellik>label").length;
                            var urunetiketid = cevap.result[0].length;
                            for (var e = 0; e < urunetiketlabel; e++) {
                                var id = $("#etiketozellik>label:eq(" + e + ")>div>input").attr("id")
                                for (var d = 0; d < urunetiketid; d++) {
                                    if (id == cevap.result[0][d].EtiketID) {
                                        $("#etiketozellik>label:eq(" + e + ")>div").addClass("checked");
                                        $("#etiketozellik>label:eq(" + e + ")>div>input").prop("checked", true);
                                    }
                                }
                            }
                        }
                        $("#urunustbaslik").text(cevap.result[1].Adi);
                        $("input[name=normalSira]").val($("#sira").val());
                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(ID);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggle").click();
                        }
                    }
                }
            }
        });
    });
    //////////////////////////////////////////////////////////////////
    //etiketler
    $(document).on('click', 'button#formToggleEtiket', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#etiketadi").val("");
                $("#aktiflik").select2("val", 0);
                $("#sira").val("");
                $("#etiketustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#etiketadi").val("");
            $("#aktiflik").select2("val", 0);
            $("#sira").val("");
            $("#etiketustbaslik").text("Yeni");
        }
    });
    //silme butonu
    $(document).on('click', 'a#etiketsil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminGenel/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "etiketSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Etiket';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Etiket';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
    //buton kaydet
    $(document).on('click', 'input#etiketkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        if (duzenleme == 0) {//ekleme
            var etiketAdi = $("#etiketadi").val();
            var sira = $("#sira").val();
            var durum = $("#aktiflik").val();
            var trlength = $("#etikettbody tr").length;
            var maksSira = 0;
            for (var a = 0; a < trlength; a++) {
                var trID = $("#etikettbody tr:eq(" + a + ")").attr("id");
                var sirasi = $("#etiketsira" + trID).text();
                if (maksSira < sirasi) {
                    maksSira = sirasi;
                }
                if (sirasi == sira) {
                    var degisecekID = trID;
                }
            }
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"etiketAdi": etiketAdi, "durum": durum, "sira": sira,
                    "maksSira": maksSira, "degisecekID": degisecekID, "tip": "etiketEkle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Etiket';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Etiket';
                        }
                    }
                }
            });
        } else {//düzenleme
            var etiketAdi = $("#etiketadi").val();
            var etiketNormalAdi = $("#etiketustbaslik").text();
            var sira = $("#sira").val();
            var durum = $("#aktiflik").val();
            var normalSira = $("input[name=normalSira]").val();
            var duzenlenenID = $("input[name=duzenleme]").val();
            var trlength = $("#etikettbody tr").length;
            var maksSira = 0;
            for (var a = 0; a < trlength; a++) {
                var trID = $("#etikettbody tr:eq(" + a + ")").attr("id");
                var sirasi = $("#etiketsira" + trID).text();
                if (maksSira < sirasi) {
                    maksSira = sirasi;
                }
                if (sirasi == sira) {
                    var degisecekID = trID;
                }
            }
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminGenel/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"etiketAdi": etiketAdi, "etiketNormalAdi": etiketNormalAdi, "durum": durum, "sira": sira, "normalSira": normalSira,
                    "maksSira": maksSira, "duzenlenenID": duzenlenenID, "degisecekID": degisecekID, "tip": "etiketDuzenle"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result == 1) {
                            window.location.href = SITE_URL + '/Admin/Etiket';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Etiket';
                        }
                    }
                }
            });
        }
    });
    //table düzenle butonları
    $(document).on('click', 'a#etiketduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        var etiketAdi = $("#etiketad" + ID).text();
        var etiketDurum = $("#etiketdurum" + ID).attr('data-aktif');
        var etiketSira = $("#etiketsira" + ID).text();
        $("#etiketadi").val(etiketAdi);
        $("#sira").val(etiketSira);
        $("#aktiflik").select2("val", etiketDurum);
        $("#etiketustbaslik").text(etiketAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        $("input[name=normalSira]").val(etiketSira);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleEtiket").click();
        }

    });
});
function yardir() {
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
    $("#urunTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true
    });

    var image_holder = $("#image-holder");
    $("#urunresim").on("change", function () {

        if (typeof (FileReader) != "undefined") {
            image_holder.empty();

            var reader = new FileReader();
            reader.onload = function (e) {
                $("<img />", {
                    "src": e.target.result,
                    "class": "thumb-image img-responsive",
                    "style": "width:auto;max-width:100%;heaight:auto;max-height:100%;"
                }).appendTo(image_holder);

            }
            image_holder.show();
            reader.readAsDataURL($(this)[0].files[0]);
        } else {
            //alert("This browser does not support FileReader.");
        }

    });

    $("#urunvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggle").click();
    });
    $("#etiketvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleEtiket").click();
    });
}