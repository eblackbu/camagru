// отображение модалки по щелчку айтема
$(document).on('click','.home__main-posts-item', function(){
    $('.home__main-posts').css('opacity', '.5');
    $('.modal').css('top', $(window).scrollTop());
    $(`<div class="modal__base-content"></div>`).appendTo(".modal__base");
    // ниже нужна аватарка и имя профиля из бд
    $(`<div class="modal__base-content-title">
        <a href="profile/id">
            <div class="modal__base-content-title-avatar">
                <img src="/views/image/drochila.jpg" alt="">
            </div>
            <h1 class="modal__base-content-title-nickname">adskiy_drochila</h1>
        </a>
        </div>`).appendTo(".modal__base-content");
    // картинка конкретного поста, на который кликнули
    $(`<div class="modal__base-content-image">${$(this).html()}</div>`).appendTo(".modal__base-content");
    // инфа по описанию, количеству лайков и коментам
    // тут еще буду изменения
    $(`<div class="modal__base-content-options">
            <div class="modal__base-content-options-description">
                <div class="modal__base-content-options-description-text">Самая пиздатая фотка в мире, инфа сотка!</div>
                <div class="modal__base-content-options-description-settings">
                    <div class="modal__base-content-options-description-settings-circle1"></div>
                    <div class="modal__base-content-options-description-settings-circle2"></div>
                    <div class="modal__base-content-options-description-settings-circle3"></div>
                </div>
                <div class="modal__menu">
                    <div class="modal__menu-edit">Изменить</div>
                    <div class="modal__menu-delete">Удалить</div>
                </div>
            </div>
            <div class="modal__description-edit">
                <form action="" method="post">
                    <textarea class="modal__textarea description-edit" rows="3"></textarea>
                    <button class="auth__form-btn">сохранить</button>
                </form>
            </div>
            <div class="modal__base-content-options-info">
                <div class="modal__base-content-options-info-statistics">
                    <div class="modal__base-content-options-statistics-likes">
                        <div class="like">
                            <div class="like__left"></div>
                            <div class="like__right"></div>
                            <div class="like__filler"></div>
                        </div>
                        <div class="like-count">
                            666
                        </div>
                    </div>
                    <div class="modal__base-content-options-statistics-comments">
                        <div class="comment"></div>
                        <div class="comment-count"> 
                            1337
                        </div>
                    </div>
                </div>
                <div class="modal__base-content-options-info-date">
                    <span class="modal__base-content-options-statistics-likes">11.09.2001</span>
                </div>
            </div>
            <div class="modal__comments">
                <form action="/comment" method="post"> <!-- TODO П -->
                    <textarea class="modal__textarea" rows="3"></textarea>
                    <button class="auth__form-btn">отправить</button>
                </form>
                <div class="modal__comments-item">
                    <div class="modal__comments-item-title">
                        <div class="modal__comments-item-title-nick"><a href="#">Рузанов Слава</a></div>
                        <div class="modal__comments-item-title-data">14.11.2017</div>
                    </div>
                    <div class="modal__comments-item-text">
                        Верните мой 2007 год и стену вконтакте!!! пидарасы
                    </div>
                </div>
                <div class="modal__comments-item">
                    <div class="modal__comments-item-title">
                        <div class="modal__comments-item-title-nick"><a href="#">Пупа Лупович</a></div>
                        <div class="modal__comments-item-title-data">14.11.2017</div>
                    </div>
                    <div class="modal__comments-item-text">
                        Lorem Ipsum - это текст-"рыба", часто используемый в печати и вэб-дизайне. Lorem Ipsum является стандартной "рыбой" для текстов на латинице с начала XVI века. В то время некий безымянный печатник создал большую коллекцию размеров и форм шрифтов, используя Lorem Ipsum для распечатки образцов.
                    </div>
                </div>
            </div>
    </div>`).appendTo(".modal__base-content");
    $('.modal').show();
});