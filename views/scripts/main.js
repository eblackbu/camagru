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

// отображение модалки по щелчку айтема
$(document).on('click','.home__main-posts-item', function(){
    $('.home__main-posts').css('opacity', '.5');
    $('.home__main-posts-modal').css('top', $(window).scrollTop());
    $(`<div class="home__main-posts-modal-base-content"></div>`).appendTo(".home__main-posts-modal-base");
    // ниже нужна аватарка и имя профиля из бд
    $(`<div class="home__main-posts-modal-base-content-title">
            <div class="home__main-posts-modal-base-content-title-avatar">
                <img src="/views/image/drochila.jpg" alt="">
            </div>
            <h1 class="home__main-posts-modal-base-content-title-nickname">adskiy_drochila</h1>
        </div>`).appendTo(".home__main-posts-modal-base-content");
    // картинка конкретного поста, на который кликнули
    $(`<div class="home__main-posts-modal-base-content-image">${$(this).html()}</div>`).appendTo(".home__main-posts-modal-base-content");
    // инфа по описанию, количеству лайков и коментам
    // тут еще буду изменения
    $(`<div class="home__main-posts-modal-base-content-options">
            <div class="home__main-posts-modal-base-content-options-description">
                Самая пиздатая фотка в мире, инфа сотка!
            </div>
            <div class="home__main-posts-modal-base-content-options-info">
                <div class="home__main-posts-modal-base-content-options-info-statistics">
                    <span class="home__main-posts-modal-base-content-options-statistics-likes">Сердечки: 666</span>
                    <span class="home__main-posts-modal-base-content-options-statistics-comments">Коменты: 42</span>
                </div>
                <div class="home__main-posts-modal-base-content-options-info-date">
                    <span class="home__main-posts-modal-base-content-options-statistics-likes">11.09.2001</span>
                </div>
            </div>
    </div>`).appendTo(".home__main-posts-modal-base-content");
    $('.home__main-posts-modal').show();
});

// скрытие модалки по щелчку закрытия
$(document).on('click','.home__main-posts-modal-base-close', function(){
    $('.home__main-posts').css('opacity', '1');
    $('.home__main-posts-modal').hide();
    $(".home__main-posts-modal-base-content").remove();
});

