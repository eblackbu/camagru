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
        <a href="profile/id">
            <div class="home__main-posts-modal-base-content-title-avatar">
                <img src="/views/image/drochila.jpg" alt="">
            </div>
            <h1 class="home__main-posts-modal-base-content-title-nickname">adskiy_drochila</h1>
        </a>
        </div>`).appendTo(".home__main-posts-modal-base-content");
    // картинка конкретного поста, на который кликнули
    $(`<div class="home__main-posts-modal-base-content-image">${$(this).html()}</div>`).appendTo(".home__main-posts-modal-base-content");
    // инфа по описанию, количеству лайков и коментам
    // тут еще буду изменения
    $(`<div class="home__main-posts-modal-base-content-options">
            <div class="home__main-posts-modal-base-content-options-description">
                <div class="home__main-posts-modal-base-content-options-description-text">Самая пиздатая фотка в мире, инфа сотка!</div>
                <div class="home__main-posts-modal-base-content-options-description-settings">
                    <div class="home__main-posts-modal-base-content-options-description-settings-circle1"></div>
                    <div class="home__main-posts-modal-base-content-options-description-settings-circle2"></div>
                    <div class="home__main-posts-modal-base-content-options-description-settings-circle3"></div>
                </div>
                <div class="home__main-posts-menu">
                    <div class="home__main-posts-menu-edit">Изменить</div>
                    <div class="home__main-posts-menu-delete">Удалить</div>
                </div>
            </div>
            <div class="home__main-posts-description-edit">
                <form action="" method="post">
                    <textarea class="modal-textarea description-edit" rows="3"></textarea>
                    <button class="auth__form-btn">сохранить</button>
                </form>
            </div>
            <div class="home__main-posts-modal-base-content-options-info">
                <div class="home__main-posts-modal-base-content-options-info-statistics">
                    <div class="home__main-posts-modal-base-content-options-statistics-likes">
                        <div class="like">
                            <div class="like__left"></div>
                            <div class="like__right"></div>
                            <div class="like__filler"></div>
                        </div>
                        <div class="like-count">
                            666
                        </div>
                    </div>
                    <div class="home__main-posts-modal-base-content-options-statistics-comments">
                        <div class="comment"></div>
                        <div class="comment-count"> 
                            1337
                        </div>
                    </div>
                </div>
                <div class="home__main-posts-modal-base-content-options-info-date">
                    <span class="home__main-posts-modal-base-content-options-statistics-likes">11.09.2001</span>
                </div>
            </div>
            <div class="home__main-posts-comments">
                <form action="/comment" method="post"> <!-- TODO П -->
                    <textarea class="modal-textarea" rows="3"></textarea>
                    <button class="auth__form-btn">отправить</button>
                </form>
                <div class="home__main-posts-comments-item">
                    <div class="home__main-posts-comments-item-title">
                        <div class="home__main-posts-comments-item-title-nick"><a href="#">Рузанов Слава</a></div>
                        <div class="home__main-posts-comments-item-title-data">14.11.2017</div>
                    </div>
                    <div class="home__main-posts-comments-item-text">
                        Верните мой 2007 год и стену вконтакте!!! пидарасы
                    </div>
                </div>
                <div class="home__main-posts-comments-item">
                    <div class="home__main-posts-comments-item-title">
                        <div class="home__main-posts-comments-item-title-nick"><a href="#">Пупа Лупович</a></div>
                        <div class="home__main-posts-comments-item-title-data">14.11.2017</div>
                    </div>
                    <div class="home__main-posts-comments-item-text">
                        Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.
                    </div>
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

$(document).on('click','.home__main-posts-modal-base-content-options-description-settings', function(){
    $('.home__main-posts-menu').toggle();
});

$(document).on('click','.home__main-posts-menu-edit', function(){
    $('.home__main-posts-description-edit').toggle();
    $('.description-edit').text($('.home__main-posts-modal-base-content-options-description-text').text());
    $('.home__main-posts-menu').toggle();
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


$(document).on('click','.home__main-posts-modal-base-content-options-statistics-comments', function(){
    $('.home__main-posts-comments').toggle();
});