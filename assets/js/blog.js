$(document).ready(function () {
    var toplamurun = $("ul#fullblog>li ").size();
    var sayfalimit = 5;
    $("ul#fullblog>li:gt(" + (sayfalimit - 1) + ")").hide();
    var sayfasayisi = Math.ceil(toplamurun / sayfalimit);
    for (var i = 1; i <= sayfasayisi; i++) {
        $("#ulsayfalar").append("<li><a href='javascript:void(0)'>" + i + "</a></li>");
    }
    $("#ulsayfalar a:first").addClass("active");
    $("#ulsayfalar a").click(function () {
        var index = $(this).text();
        var goster = (index * sayfalimit);
        $("ul#fullblog>li").fadeOut(200);

        $("#ulsayfalar a").removeClass("active");
        $(this).addClass("active");

        for (i = (goster - sayfalimit); i <= goster - 1; i++) {
            $("ul#fullblog>li:eq(" + i + ")").fadeIn(300);
        }
    });
});