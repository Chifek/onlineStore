// highlight current day on opeining hours
$(document).ready(function () {
    $('.opening-hours li').eq(new Date().getDay()).addClass('today');
});

$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $('#toTop').fadeIn();
        } else {
            $('#toTop').fadeOut();
        }
    });
    $('#toTop').click(function () {
        $('body,html').animate({scrollTop: 0}, 800);
    });
});