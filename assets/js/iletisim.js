$(document).ready(function () {
    $(document).on('click', 'button#formToggleIletisim', function (e) {
        var kapaliacik = $("input[name=kapaliacik]").val();
        var duzenleme = $("input[name=duzenleme]").val();
        if (kapaliacik == 0) {
            $("input[name=kapaliacik]").val(1);
            if (duzenleme == 0) {
                $("input[name=duzenleme]").val(0);
                $("#iletadsoyad").val("");
                $("#iletemail").val("");
                $("#iletkonu").val("");
                $("#ilettarih").val("");
                CKEDITOR.instances['mesajyazi'].setData("");
                $("#iletudurum").val("");
            }
        } else {
            $("input[name=duzenleme]").val(0);
            $("input[name=kapaliacik]").val(0);
            $("#iletadsoyad").val("");
            $("#iletemail").val("");
            $("#iletkonu").val("");
            $("#ilettarih").val("");
            CKEDITOR.instances['mesajyazi'].setData("");
            $("#iletudurum").val("");
        }
    });
    $(document).on('click', 'a#mesajGoruntule', function (e) {
        var ID = $(this).parent().parent().attr('id');
        $.ajax({
            type: "post",
            url: SITE_URL + "/AdminKampanya/ajaxCall",
            cache: false,
            dataType: "json",
            data: {"ID": ID, "tip": "iletisim"},
            success: function (cevap) {
                if (cevap.hata) {
                    reset();
                    alertify.alert(cevap.hata);
                    return false;
                } else {
                    if (cevap.result) {
                        $("#iletadsoyad").val(cevap.result[0].AdSoyad);
                        $("#iletemail").val(cevap.result[0].Email);
                        $("#iletkonu").val(cevap.result[0].Konu);
                        $("#ilettarih").val(cevap.result[0].BsTarih);
                        CKEDITOR.instances['mesajyazi'].setData(cevap.result[0].Mesaj);
                        if (cevap.result[0].Uye != 0) {
                            $("#iletudurum").val("Kişi üye durumundadır.");
                        } else {
                            $("#iletudurum").val("Kişi üye değildir.");
                        }
                        $("input[name=duzenleme]").val(1);
                        var kapaliacik = $("input[name=kapaliacik]").val();
                        if (kapaliacik == 0) {
                            $("#formToggleIletisim").click();
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
    $("#mesajTable").DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": false,
        "info": true});
});