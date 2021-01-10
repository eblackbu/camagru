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

$(document).on('click','.header__content-menu', function(){
    $('.header__content-sidebar').toggle();
    if($('.header__content-menu').hasClass('active')) {
        $('.header__content-menu').removeClass('active');
    } else {
        $('.header__content-menu').addClass('active');
    }
});

$(document).on('click','.home__main-posts-item', function(){
    // alert($(this).attr('swo'));
    $(`<div class="home__main-posts-modal-base-content"></div>`).appendTo(".home__main-posts-modal-base");
    $(`<div class="home__main-posts-modal-base-content-title">Title</div>`).appendTo(".home__main-posts-modal-base-content");
    $(`<div class="home__main-posts-modal-base-content-image">${$(this).html()}</div>`).appendTo(".home__main-posts-modal-base-content");
    $(`<div class="home__main-posts-modal-base-content-options">Options</div>`).appendTo(".home__main-posts-modal-base-content");
    $('.home__main-posts-modal').show();
});

$(document).on('click','.home__main-posts-modal-base-close', function(){
    $('.home__main-posts-modal').hide();
    $(".home__main-posts-modal-base-content").remove();
});
