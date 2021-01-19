// скрытие сообщения в самом начале
$(document).ready(function(){
    if($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }
});

function hide_notifications() {
    $('.header__notifications').hide();
    $('.header__notifications').removeClass('active');
}

// скрытие сообщения по щелчку
$(document).on('click','.header__notifications', function(){
    $('.header__notifications').addClass('active');
    setTimeout(hide_notifications, 900);   
});

// скрытие и показ меню шапки
$(document).on('click','.header__content-menu', function(){
    $('.header__content-sidebar').toggle();
    if($('.header__content-menu').hasClass('active')) {
        $('.header__content-menu').removeClass('active');
    } else {
        $('.header__content-menu').addClass('active');
    }
});

// скрытие модалки по щелчку закрытия
$(document).on('click','.modal__base-close', function(){
    $('.home__main-posts').css('opacity', '1');
    $('.modal').hide();
    $(".modal__base-content").remove();
});

$(document).on('click','.modal__base-content-options-description-settings', function(){
    $('.modal__menu').toggle();
});

$(document).on('click','.modal__menu-edit', function(){
    $('.modal__description-edit').toggle();
    $('.description-edit').text($('.modal__base-content-options-description-text').text());
    $('.modal__menu').toggle();
});

$(document).on('click','.like', function(){
    if ($('.like__left').css('background-color') == 'rgb(255, 255, 255)') {
        $('.like__left').css({'background-color': 'rgb(255, 0, 0)', 'border': 'none'});
        $('.like__right').css({'background-color': 'rgb(255, 0, 0)', 'border': 'none'});
        $('.like__filler').hide();
    } else {
        $('.like__left').css({'background-color': 'rgb(255, 255, 255)', 'border': '0.5px solid black'});
        $('.like__right').css({'background-color': 'rgb(255, 255, 255)', 'border': '0.5px solid black'});
        $('.like__filler').show();
    }
}); 


$(document).on('click','.modal__base-content-options-statistics-comments', function(){
    $('.modal__comments').toggle();
});