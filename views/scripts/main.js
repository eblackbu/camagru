$(document).ready(function(){
    if($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }
});

function hide_notifications() {
    $('.header__notifications').hide();
    $('.header__notifications').removeClass('active');
}

$(document).on('click','.header__notifications', function(){
    $('.header__notifications').addClass('active');
    setTimeout(hide_notifications, 900);   
});