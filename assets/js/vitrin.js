$(document).ready(function () {
    //vitrinler
    $(document).on('click', 'button#formToggleVitrin', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#vitrinbaslik").val("");
                $("#vitrinaltbaslik").val("");
                $("#vitrinbuttonyazi").val("");
                $("#vitrinadres").val("");
                CKEDITOR.instances['vitrinyazi'].setData("");
                $("#aktiflik").select2("val", 0);
                $("#sira").val("");
                $("#etiketustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#vitrinbaslik").val("");
            $("#vitrinaltbaslik").val("");
            $("#vitrinbuttonyazi").val("");
            $("#vitrinadres").val("");
            CKEDITOR.instances['vitrinyazi'].setData("");
            $("#aktiflik").select2("val", 0);
            $("#sira").val("");
            $("#etiketustbaslik").text("Yeni");
        }
    });
    //silme butonu
    $(document).on('click', 'a#vitrinSil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminVitrin/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "vitrinSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/Vitrin';
                            } else {
                                window.location.href = SITE_URL + '/Admin/Vitrin';
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
    $(document).on('click', 'input#vitrinkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        var formData = new FormData();
        if (duzenleme == 0) {//ekleme
            var baslik = $("#vitrinbaslik").val();
            var altbaslik = $("#vitrinaltbaslik").val();
            var buttonyazi = $("#vitrinbuttonyazi").val();
            var adres = $("#vitrinadres").val();
            var yazi = CKEDITOR.instances['vitrinyazi'].getData();
            var aktiflik = $("#aktiflik").val();
            var sira = $("#sira").val();
            formData.append('file', $("#vitrinresim")[0].files[0]);
            var trlength = $("#vitrintbody tr").length;
            var maksSira = 0;
            var degisecekID = 0;
            for (var a = 0; a < trlength; a++) {
                var trID = $("#vitrintbody tr:eq(" + a + ")").attr("id");
                var sirasi = $("#vitrinsira" + trID).text();
                if (maksSira < sirasi) {
                    maksSira = sirasi;
                }
                if (sirasi == sira) {
                    degisecekID = trID;
                }
            }


            formData.append('baslik', baslik);
            formData.append('yazi', yazi);
            formData.append('degisecekID', degisecekID);
            formData.append('maxSira', maksSira);
            formData.append('altbaslik', altbaslik);
            formData.append('buttonyazi', buttonyazi);
            formData.append('aktiflik', aktiflik);
            formData.append('sira', sira);
            formData.append('adres', adres);
            formData.append('tip', "vitrinEkle");

            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/Vitrin';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Vitrin';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var baslik = $("#vitrinbaslik").val();
            var altbaslik = $("#vitrinaltbaslik").val();
            var buttonyazi = $("#vitrinbuttonyazi").val();
            var adres = $("#vitrinadres").val();
            var yazi = CKEDITOR.instances['vitrinyazi'].getData();
            var aktiflik = $("#aktiflik").val();
            var sira = $("#sira").val();
            var normalSira = $("input[name=normalSira]").val();
            var imageKontrol = $("#image-holder img").length;
            var newimage = 0;
            if ($("#vitrinresim")[0].files[0] == undefined) {
                newimage = 0;
            } else {
                newimage = 1;
            }
            formData.append('file', $("#vitrinresim")[0].files[0]);
            formData.append('resimKontrol', imageKontrol);
            formData.append('newImage', newimage);
            formData.append('normalSira', normalSira);
            var trlength = $("#vitrintbody tr").length;
            var maksSira = 0;
            var degisecekID = 0;
            if (normalSira != sira) {
                for (var a = 0; a < trlength; a++) {
                    var trID = $("#vitrintbody tr:eq(" + a + ")").attr("id");
                    var sirasi = $("#vitrinsira" + trID).text();
                    if (maksSira < sirasi) {
                        maksSira = sirasi;
                    }
                    if (sirasi == sira) {
                        degisecekID = trID;
                    }
                }
            }

            formData.append('ID', ID);
            formData.append('baslik', baslik);
            formData.append('yazi', yazi);
            formData.append('degisecekID', degisecekID);
            formData.append('maxSira', maksSira);
            formData.append('altbaslik', altbaslik);
            formData.append('buttonyazi', buttonyazi);
            formData.append('aktiflik', aktiflik);
            formData.append('sira', sira);
            formData.append('adres', adres);
            formData.append('tip', "vitrinDuzenle");
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/Vitrin';
                        } else {
                            window.location.href = SITE_URL + '/Admin/Vitrin';
                        }
                    }
                }
            });
        }
    });
    //table düzenle butonları
    $(document).on('click', 'a#vitrinduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminVitrin/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "vitrinDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#vitrinbaslik").val(cevap.result.Baslik);
                        $("#vitrinaltbaslik").val(cevap.result.AltBaslik);
                        $("#vitrinbuttonyazi").val(cevap.result.Button);
                        $("#vitrinadres").val(cevap.result.Url);
                        CKEDITOR.instances['vitrinyazi'].setData(cevap.result.Yazi);
                        $("#aktiflik").select2("val", cevap.result.Aktif);
                        $("#sira").val(cevap.result.Sira);
                        $("#vitrinustbaslik").text(cevap.result.Baslik);
                        if (cevap.result.Resim) {
                            $("#image-holder").empty();
                            $("#image-holder").prepend('<img id="theImg" src="' + SITE_URL + '/vitrin/' + cevap.result.Resim + '" class="thumb-image img-responsive urunresim" style="width:auto; max - width:100 % ; heaight:auto; max - height:100 % ; "/>');
                        }
                        $("input[name=normalSira]").val($("#sira").val());
                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(cevap.result.ID);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggleVitrin").click();
                        }
                    }
                }
            }
        });
    });
    ///////////////////////Sabit İçerikler//////////////////////////////
    //buton kaydet
    $(document).on('click', 'input#sabiticerikkaydet', function (e) {
        var formData = new FormData();
        var telefon = $("input[name=telefon]").val();
        var fax = $("input[name=fax]").val();
        var iletisimmail = $("input[name=iletisimmail]").val();
        var harita = $("input[name=harita]").val();
        var facebook = $("input[name=facebook]").val();
        var twitter = $("input[name=twitter]").val();
        var instagram = $("input[name=instagram]").val();
        var googleplus = $("input[name=googleplus]").val();
        var adres = $("#adres").val();
        var yoneticimail = $("input[name=yoneticimail]").val();
        var yoneticimailek = $("input[name=yoneticimailek]").val();
        var imageKontrol = $("#image-holder img").length;
        var newimage = 0;
        if ($("#logoresim")[0].files[0] == undefined) {
            newimage = 0;
        } else {
            newimage = 1;
        }
        var uyelikSoz = CKEDITOR.instances['uyelikSoz'].getData();
        var onBilgi = CKEDITOR.instances['onBilgi'].getData();
        var mesafeliSatis = CKEDITOR.instances['mesafeliSatis'].getData();
        var gizlilikSoz = CKEDITOR.instances['gizlilikSoz'].getData();
        var hizmetSoz = CKEDITOR.instances['hizmetSoz'].getData();
        var teslimatSart = CKEDITOR.instances['teslimatSart'].getData();
        formData.append('file', $("#logoresim")[0].files[0]);
        formData.append('newImage', newimage);
        formData.append('telefon', telefon);
        formData.append('fax', fax);
        formData.append('iletisimmail', iletisimmail);
        formData.append('harita', harita);
        formData.append('facebook', facebook);
        formData.append('twitter', twitter);
        formData.append('instagram', instagram);
        formData.append('googleplus', googleplus);
        formData.append('adres', adres);
        formData.append('yoneticimail', yoneticimail);
        formData.append('yoneticimailek', yoneticimailek);
        formData.append('uyelikSoz', uyelikSoz);
        formData.append('onBilgi', onBilgi);
        formData.append('mesafeliSatis', mesafeliSatis);
        formData.append('gizlilikSoz', gizlilikSoz);
        formData.append('hizmetSoz', hizmetSoz);
        formData.append('teslimatSart', teslimatSart);
        formData.append('tip', "sabitIcerikEkle");
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                        window.location.href = SITE_URL + '/Admin/SabitIcerik';
                    } else {
                        window.location.href = SITE_URL + '/Admin/SabitIcerik';
                    }
                }
            }
        });
    });
    //buton vazgeç
    $(document).on('click', 'input#sabiticerikvazgec', function (e) {
        var telefon = $("input[name=telefon]").val($("input[name=hidtelefon]").val());
        var fax = $("input[name=fax]").val($("input[name=hidfax]").val());
        var iletisimmail = $("input[name=iletisimmail]").val($("input[name=hidemail]").val());
        var harita = $("input[name=harita]").val($("input[name=hidharita]").val());
        var facebook = $("input[name=facebook]").val($("input[name=hidfacebook]").val());
        var twitter = $("input[name=twitter]").val($("input[name=hidtwitter]").val());
        var instagram = $("input[name=instagram]").val($("input[name=hidinstagram]").val());
        var googleplus = $("input[name=googleplus]").val($("input[name=hidgoogleplus]").val());
        var adres = $("#adres").val($("input[name=hidadres]").val());
        var yoneticimail = $("input[name=yoneticimail]").val($("input[name=hidyoneticimail]").val());
        var yoneticimailek = $("input[name=yoneticimailek]").val($("input[name=hidyoneticimailek]").val());
    });
    ///////////////////////Blog İçerikler///////////////////////////////////////
    $(document).on('click', 'button#formToggleBlog', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("#blogbaslik").val("");
                CKEDITOR.instances['blogyazisi'].setData("");
                $("#aktiflik").select2("val", 0);
                $("#blogustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("#blogbaslik").val("");
            CKEDITOR.instances['blogyazisi'].setData("");
            $("#aktiflik").select2("val", 0);
            $("#blogustbaslik").text("Yeni");
        }
    });
    //silme butonu
    $(document).on('click', 'a#blogsil', function (e) {
        var ID = $(this).parent().parent().attr('id');
        reset();
        alertify.confirm("Silmek İstiyormusunuz", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: SITE_URL + "/AdminVitrin/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ID": ID, "tip": "blogSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/BlogYazi';
                            } else {
                                window.location.href = SITE_URL + '/Admin/BlogYazi';
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
    $(document).on('click', 'input#blogkaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        var formData = new FormData();
        if (duzenleme == 0) {//ekleme
            var baslik = $("#blogbaslik").val();
            var cke = CKEDITOR.instances['blogyazisi'].getData();
            var aktiflik = $("#aktiflik").val();

            formData.append('baslik', baslik);
            formData.append('file', $("#blogresim")[0].files[0]);
            formData.append('yazi', cke);
            formData.append('aktiflik', aktiflik);
            formData.append('tip', "blogEkle");

            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/BlogYazi';
                        } else {
                            window.location.href = SITE_URL + '/Admin/BlogYazi';
                        }
                    }
                }
            });
        } else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var baslik = $("#blogbaslik").val();
            var normalbaslik = $("#blogustbaslik").text();
            var cke = CKEDITOR.instances['blogyazisi'].getData();
            var aktiflik = $("#aktiflik").val();

            var imageKontrol = $("#image-holder img").length;
            var newimage = 0;
            if ($("#blogresim")[0].files[0] == undefined) {
                newimage = 0;
            } else {
                newimage = 1;
            }
            formData.append('resimKontrol', imageKontrol);
            formData.append('newImage', newimage);
            formData.append('ID', ID);
            formData.append('baslik', baslik);
            formData.append('normalbaslik', normalbaslik);
            formData.append('file', $("#blogresim")[0].files[0]);
            formData.append('yazi', cke);
            formData.append('aktiflik', aktiflik);
            formData.append('tip', "blogDuzenle");
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/BlogYazi';
                        } else {
                            window.location.href = SITE_URL + '/Admin/BlogYazi';
                        }
                    }
                }
            });
        }
    });
    //table düzenle butonları
    $(document).on('click', 'a#blogduzenle', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminVitrin/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "blogDuzenlemeDegerler"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#blogbaslik").val(cevap.result.Baslik);
                        $("#aktiflik").select2("val", cevap.result.Aktif);
                        CKEDITOR.instances['blogyazisi'].setData(cevap.result.Yazi);
                        if (cevap.result.Resim) {
                            $("#image-holder").empty();
                            $("#image-holder").prepend('<img id="theImg" src="' + SITE_URL + '/blogum/' + cevap.result.Resim + '" class="thumb-image img-responsive urunresim" style="width:auto; max - width:100 % ; heaight:auto; max - height:100 % ; "/>');
                        }
                        $("#blogustbaslik").text(cevap.result.Baslik);
                        $("input[name=duzenleme]").val(1);
                        $("input[name=duzenlemeID]").val(cevap.result.ID);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggleBlog").click();
                        }
                    }
                }
            }
        });
    });
    ///////////////////////Sabit Sayfa İçerikler///////////////////////////////////////
    //table düzenle butonları
    $(document).on('click', 'a#SayfaDuzenle', function (e) {
        var ustID = $(this).parent().parent().attr('data-ust');
        var ID = $(this).parent().parent().attr('id');
        var sayfaAdi = $("#sayfaad" + ID).attr('data-sayfaad');
        var sayfaDurum = $("#sayfadurum" + ID).attr('data-aktif');
        var sayfaSira = $("#sayfasira" + ID).text();
        if (ustID == 0) {
            $(".visible-all").fadeIn();
            $(".visible-sayfa").fadeOut();
            $('#sayfaturu').select2('enable', true);
            $("#sayfaturu").select2("val", "kategori");
            $('#sayfaturu').prop('disabled', !$('#sayfkategori').prop('disabled'));
            $('select').select2();
            $("#sayfaadi").val(sayfaAdi);
            $("#aktiflik").select2("val", sayfaDurum);
            $("#sira").val(sayfaSira);
        } else {
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
                cache: false,
                dataType: "json",
                data: {"ID": ID, "tip": "sayfaDuzenlemeDegerler"},
                success: function (cevap) {
                    if (cevap.hata) {
                        reset();
                        alertify.alert(cevap.hata);
                        return false;
                    } else {
                        if (cevap.result) {
                            $('#sayfaturu').select2('enable', true);
                            $("#sayfaturu").select2("val", "sayfa");
                            $('#sayfaturu').prop('disabled', !$('#altsayfakat').prop('disabled'));
                            $('select').select2();
                            $("#sayfaadi").val(sayfaAdi);
                            $("#aktiflik").select2("val", sayfaDurum);
                            $("#sira").val(sayfaSira);
                            $("#ustSayfa").select2("val", ustID);
                            $("#aktiflik").select2("val", sayfaDurum);
                            CKEDITOR.instances['sayfayazisi'].setData(cevap.result.Yazi);
                            if (cevap.result.Resim) {
                                $("#image-holder").empty();
                                $("#image-holder").prepend('<img id="theImg" src="' + SITE_URL + '/sayfa/' + cevap.result.Resim + '" class="thumb-image img-responsive urunresim" style="width:auto; max - width:100 % ; heaight:auto; max - height:100 % ; "/>');
                            }
                            $(".visible-all").fadeIn();
                            $(".visible-sayfa").fadeIn();
                        }
                    }
                }
            });
        }

        $("#sayfaustbaslik").text(sayfaAdi);
        $("input[name=duzenleme]").val(1);
        $("input[name=duzenlemeID]").val(ID);
        $("input[name=duzenlemeUstID]").val(ustID);
        $("input[name=normalSira]").val(sayfaSira);
        $("input[name=normalUstKategori]").val(ustID);
        var kapaliacik = $("input[name=kapaliacik]").val();
        if (kapaliacik == 0) {
            $("#formToggleSayfa").click();
        }

    });
    //silme butonu
    $(document).on('click', 'a#SayfaSilme', function (e) {
        var ustID = $(this).parent().parent().attr('data-ust');
        var ID = $(this).parent().parent().attr('id');
        var altkatvar = 0;
        if (ustID == 0) {//üst kategoridir
            var trlength = $("#sayfatbody tr").length;
            for (var a = 0; a < trlength; a++) {
                var ust = $("#sayfatbody tr:eq(" + a + ")").attr("data-ust");
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
                    url: SITE_URL + "/AdminVitrin/ajaxCall",
                    cache: false,
                    dataType: "json",
                    data: {"ustID": ustID, "ID": ID, "altkatvar": altkatvar, "tip": "sayfaSil"},
                    success: function (cevap) {
                        if (cevap.hata) {
                            reset();
                            alertify.alert(cevap.hata);
                            return false;
                        } else {
                            if (cevap.result == 1) {
                                window.location.href = SITE_URL + '/Admin/SabitSayfa';
                            } else {
                                window.location.href = SITE_URL + '/Admin/SabitSayfa';
                            }
                        }
                    }
                });
            } else {
                alertify.error("Silme İşlemi iptal edildi");
            }
        });
    });
    //buton toggle
    $(document).on('click', 'button#formToggleSayfa', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("input[name=duzenlemeID]").val(-1);
                $("input[name=duzenlemeUstID]").val(-1);
                $('#sayfaturu').select2('enable', true);
                $("#sayfaadi").val("");
                $("#sira").val("");
                $("#kategoriyazisi").val("");
                $("#aktiflik").select2("val", 0);
                $("#ustSayfa").select2("val", 0);
                CKEDITOR.instances['sayfayazisi'].setData("");
                $("#sayfaustbaslik").text("Yeni");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("input[name=duzenlemeID]").val(-1);
            $("input[name=duzenlemeUstID]").val(-1);
            $("#sayfaadi").val("");
            $("#sira").val("");
            $("#kategoriyazisi").val("");
            $("#aktiflik").select2("val", 0);
            $("#ustSayfa").select2("val", 0);
            CKEDITOR.instances['sayfayazisi'].setData("");
            $("#sayfaustbaslik").text("Yeni");
        }
    });
    //buton kaydet
    $(document).on('click', 'input#sayfakaydet', function (e) {
        var duzenleme = $("input[name=duzenleme]").val();
        var formData = new FormData();
        if (duzenleme == 0) {//ekleme
            var sayfaTuru = $("#sayfaturu").val();
            var sayfaAdi = $("#sayfaadi").val();
            var sira = $("#sira").val();
            var durum = $("#aktiflik").val();
            var ustSayfa = $("#ustSayfa").val();
            var cke = CKEDITOR.instances['sayfayazisi'].getData();
            var maksSira = 0
            if (sayfaTuru == "sayfa") {//alt kategori
                var trlength = $("#sayfatbody tr").length;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#sayfatbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == ustSayfa) {
                        var trID = $("#sayfatbody tr:eq(" + a + ")").attr("id");
                        var altKatSira = $("#sayfasira" + trID).text();
                        if (maksSira < altKatSira) {
                            maksSira = altKatSira;
                        }
                        if (altKatSira == sira) {
                            var degisecekID = trID;
                        }
                    }
                }
            } else if (sayfaTuru == "kategori") {//üst kategori
                var trlength = $("#sayfatbody tr").length;
                var kategoriSayi = 1;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#sayfatbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == 0) {
                        var trID = $("#sayfatbody tr:eq(" + a + ")").attr("id");
                        var sirasi = $("#sayfasira" + trID).text();
                        if (maksSira < sirasi) {
                            maksSira = sirasi;
                        }
                        if (sirasi == sira) {
                            var degisecekID = trID;
                        }
                        kategoriSayi++;
                    }
                }
            }
            formData.append('sayfaTuru', sayfaTuru);
            formData.append('sayfaAdi', sayfaAdi);
            formData.append('kategoriSayi', kategoriSayi);
            formData.append('sira', sira);
            formData.append('durum', durum);
            formData.append('file', $("#sayfaresim")[0].files[0]);
            formData.append('ustSayfa', ustSayfa);
            formData.append('cke', cke);
            formData.append('sonUstSira', maksSira);
            formData.append('degisecekID', degisecekID);
            formData.append('tip', "sayfaEkle");
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/SabitSayfa';
                        } else {
                            window.location.href = SITE_URL + '/Admin/SabitSayfa';
                        }
                    }
                }
            });
        }
        else {//düzenleme
            var ID = $("input[name=duzenlemeID]").val();
            var sayfaTuru = $("#sayfaturu").val();
            var sayfaAdi = $("#sayfaadi").val();
            var normalSayfaAdi = $("#sayfaustbaslik").text();
            var sira = $("#sira").val();
            var normalSira = $("input[name=normalSira]").val();
            var durum = $("#aktiflik").val();
            var ustSayfa = $("#ustSayfa").val();
            var normalUstID = $("input[name=normalUstKategori]").val();
            var cke = CKEDITOR.instances['sayfayazisi'].getData();
            var maksSira = 0
            if (sayfaTuru == "sayfa") {//alt kategori
                var trlength = $("#sayfatbody tr").length;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#sayfatbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == ustSayfa) {
                        var trID = $("#sayfatbody tr:eq(" + a + ")").attr("id");
                        var altKatSira = $("#sayfasira" + trID).text();
                        if (maksSira < altKatSira) {
                            maksSira = altKatSira;
                        }
                        if (altKatSira == sira) {
                            var degisecekID = trID;
                        }
                    }
                }
            } else if (sayfaTuru == "kategori") {//üst kategori
                var trlength = $("#sayfatbody tr").length;
                for (var a = 0; a < trlength; a++) {
                    var ust = $("#sayfatbody tr:eq(" + a + ")").attr("data-ust");
                    if (ust == 0) {
                        var trID = $("#sayfatbody tr:eq(" + a + ")").attr("id");
                        var sirasi = $("#sayfasira" + trID).text();
                        if (maksSira < sirasi) {
                            maksSira = sirasi;
                        }
                        if (sirasi == sira) {
                            var degisecekID = trID;
                        }
                    }
                }
            }

            var imageKontrol = $("#image-holder img").length;
            var newimage = 0;
            if ($("#sayfaresim")[0].files[0] == undefined) {
                newimage = 0;
            } else {
                newimage = 1;
            }
            formData.append('resimKontrol', imageKontrol);
            formData.append('newImage', newimage);
            formData.append('sayfaTuru', sayfaTuru);
            formData.append('sayfaAdi', sayfaAdi);
            formData.append('normalSayfaAdi', normalSayfaAdi);
            formData.append('sira', sira);
            formData.append('normalSira', normalSira);
            formData.append('durum', durum);
            formData.append('file', $("#sayfaresim")[0].files[0]);
            formData.append('ustSayfa', ustSayfa);
            formData.append('normalUstID', normalUstID);
            formData.append('cke', cke);
            formData.append('sonUstSira', maksSira);
            formData.append('degisecekID', degisecekID);
            formData.append('ID', ID);
            formData.append('tip', "sayfaDuzenle");
            $.ajax({
                type: "post",
                url: SITE_URL + "/AdminVitrin/ajaxCall",
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
                            window.location.href = SITE_URL + '/Admin/SabitSayfa';
                        } else {
                            window.location.href = SITE_URL + '/Admin/SabitSayfa';
                        }
                    }
                }
            });
        }
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

    $("#vitrinTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});

    $("#blogTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false
    });

    $("#sayfaTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": false
    });



    var image_holder = $("#image-holder");
    $("#vitrinresim").on("change", function () {
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
    var image_holder = $("#image-holder");
    $("#blogresim").on("change", function () {
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
    var image_holder = $("#image-holder");
    $("#sayfaresim").on("change", function () {
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
    var image_holder = $("#image-holder");
    $("#logoresim").on("change", function () {
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

    $("#sayfaturu").on("change", function () {
        var val = $(this).val();
        if (val == "kategori") {
            $(".visible-all").fadeIn();
            $(".visible-sayfa").fadeOut();
        } else if (val == "sayfa") {
            $(".visible-all").fadeIn();
            $(".visible-sayfa").fadeIn();
        } else {
            $(".visible-all").fadeOut();
            $(".visible-sayfa").fadeOut();
        }
    });

    $("#vitrinvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleVitrin").click();
    });
    $("#blogvazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleBlog").click();
    });
    $("#sayfavazgec").on("click", function () {
        image_holder.empty();
        $("#formToggleSayfa").click();
        $(".hidden-first").fadeOut();
    });
});
