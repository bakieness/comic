$(document).ready(function () {

    var a;
    var b = 83;
    $('.mobileTitle').css('height', 0);
    setMargin();

    function setMargin() {
        setTimeout(setMargin, 10);
        if ($(window).width() > 980) {
            $('.l-main').css('margin-top', 0)
        } else if($(window).width() > 500){
            a = 8;
        } else {
            a = 33;
        }
    }

    $('.menu').on('click', function () {
        var navHeight = $('.mobileTitle').height();
        var newNavHeight = $('header').height();
        
        if (navHeight == 0) {
            $('.mobileTitle').animate({ 'height': newNavHeight + a + 'px' }, 400)
            $('.l-main').animate({ 'margin-top': b + 'px' }, 400)
        } else {
            $('.mobileTitle').animate({ 'height': '0' }, 400)
            $('.l-main').animate({ 'margin-top': 0 }, 400)
        }
    });

    $('.primaryMob').on('click', function () {
        var navHeight = $('.mobileTitle').height();
        var newNavHeight = $('header').height();

        if (navHeight == 0) {
            $('.mobileTitle').animate({ 'height': newNavHeight + a + 'px' }, 400)
            $('.l-main').animate({ 'margin-top': b + 'px' }, 400)
        } else {
            $('.mobileTitle').animate({ 'height': '0' }, 400)
            $('.l-main').animate({ 'margin-top': 0 }, 400)
        }
    });
});