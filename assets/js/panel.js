$(document).ready(function () {
    $(document).on("click", "a#panelCikisYap", function (e) {
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
    /*
    UyeSonTable = $('#sonuyeler').dataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });
    SonSiparisler = $("#sonsiparisler").DataTable({
        "paging": true,
        "ordering": true,
        "info": true
    });*/
});