$(document).ready(function () {
    $("#hamburger").click(function () {
        $("#drop_down_nav_mobile").toggleClass("hidden");
    });

    $("#acc_setting").click(function () {
        $("#drop_down_desktop_account").toggleClass("hidden");
    });

    $(".category_dropdown").click(function () {
        $(this).children("ul").toggleClass("hidden");
    });
});
