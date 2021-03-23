$(document).ready(() => {
    // скрытие сообщения в самом начале и фото режима
    if ($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }

    // скрытые канвасов
    $('#canvasMake').hide();
    $('#canvasUpload').hide();
    $('#uploadFile').hide();

    // отображения загруженного файла
    $("#input__file").on('change', handleFiles);

    // подключение вебки
    let url = window.location.pathname;
    if (url == "/new_image") {
        let constraints = { audio: false, video: {} };
        navigator.mediaDevices.getUserMedia(constraints)
            .then(function (mediaStream) {
                let video = document.querySelector('video');
                video.srcObject = mediaStream;
                video.onloadedmetadata = function (e) {
                    video.play();
                };
            })
            .catch(function (err) { console.log(err.name + ": " + err.message); });
    }
});

// скрытие уведомлений
function hide_notifications() {
    $('.header__notifications').hide();
    $('.header__notifications').removeClass('active');
}

// запись скрина в канвас
// $(document).on('click', '.snapshot', () => {
//     let video = document.querySelector('video');
//     let canvas = document.getElementById('canvasMake');
//     canvas.width = video.clientWidth;
//     canvas.height = video.clientHeight;
//     let ctx = canvas.getContext('2d');
//     ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
//     $('#canvasMake').show();
//     $('#uploadFile').show();
// });

// переключение режима добавления фото
// $(document).on('click', '.make', () => {
//     if (!$('.make').hasClass('active')) {
//         $('.make').addClass('active');
//         $('.upload').removeClass('active');
//         $('.uploadPhoto').hide();
//         $('.makePhoto').show();
//     }
// });

// $(document).on('click', '.upload', () => {
//     if (!$('.upload').hasClass('active')) {
//         $('.upload').addClass('active');
//         $('.make').removeClass('active');
//         $('.makePhoto').hide();
//         $('.uploadPhoto').show();
//     }
// });

// показ поиска
// $(document).on('click', '#search', () => {
//     $('.search').show();
//     $('.main__main').css('opacity', '.5');
//     $('.home__main').css('opacity', '.5');
// });

// // скрытие поиска
// $(document).on('click', '.search__close', () => {
//     $('.search').hide();
//     $('.main__main').css('opacity', '1');
//     $('.home__main').css('opacity', '1');
// });

// выбор необходимой поисковой строки
function chooseInput() {
    let result = '';
    $(".search_input").map((indx, element) => {
        if (!!$(element).val()) {
            result = $(element).val();
        }
    });
    return result;
}

// предпросмотр загруженного файла в канвасе
function handleFiles(event) {
    let canvas = document.getElementById('canvasUpload');
    let img = new Image;
    img.src = URL.createObjectURL(event.target.files[0]);
    img.onload = function () {
        canvas.width = this.width;
        canvas.height = this.height;
        let ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
    }
    $('#canvasUpload').show();
    $('#uploadFile').show();
}

// выбор нужного канваса
function prepToServer() {
    let canvas;
    if ($('.make').hasClass('active')) {
        canvas = document.getElementById('canvasMake');
    } else {
        canvas = document.getElementById('canvasUpload');
    }
    return canvas;
}


$(document).on('click', (event) => {
    let classList = event.target.classList;
    classList = Object.keys(classList).map(key => classList[key]);
    let parentClassList = event.target.parentElement.classList;
    parentClassList = Object.keys(parentClassList).map(key => parentClassList[key]);
    if (classList.includes('header__content-menu')) {
        // скрытие и показ меню из шапки
        $('.header__content-sidebar').toggle();
            if ($('.header__content-menu').hasClass('active')) {
                $('.header__content-menu').removeClass('active');
                $('.main__main').css('opacity', '1');
                $('.home__main').css('opacity', '1');
                $('.search').hide();

            } else {
                $('.header__content-menu').addClass('active');
            }
    } else if (classList.includes('search__close')) {
        // скрытие поиска
        $('.search').hide();
        $('.main__main').css('opacity', '1');
        $('.home__main').css('opacity', '1');
    } else if (classList.includes('search-open')) {
        // показ поиска
        $('.search').show();
        $('.main__main').css('opacity', '.5');
        $('.home__main').css('opacity', '.5');
    } else if (classList.includes('make')) {
        // табы
        if (!$('.make').hasClass('active')) {
            $('.make').addClass('active');
            $('.upload').removeClass('active');
            $('.uploadPhoto').hide();
            $('.makePhoto').show();
        }
    } else if (classList.includes('upload')) {
        // табы
        if (!$('.upload').hasClass('active')) {
            $('.upload').addClass('active');
            $('.make').removeClass('active');
            $('.makePhoto').hide();
            $('.uploadPhoto').show();
        }
    } else if (classList.includes('snapshot')) {
        // запись фото в канвас
        let video = document.querySelector('video');
        let canvas = document.getElementById('canvasMake');
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        let ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        $('#canvasMake').show();
        $('#uploadFile').show();
    } else if (classList.includes('modal__base-content-options-statistics-comments')
            || parentClassList.includes('modal__base-content-options-statistics-comments')) {
        // скрытие и показ коментариев
        $('.modal__comments').toggle();
    } else if (classList.includes('header__notifications')) {
        // скрытие сообщения по щелчку
        $('.header__notifications').addClass('active');
        setTimeout(hide_notifications, 900);
    } else if (classList.includes('modal__base-close')) {
        // скрытие модалки по щелчку закрытия
        $('.home__main-posts').css('opacity', '1');
        $('.home__main-profile').css('opacity', '1');
        $('.home__main-new').css('opacity', '1');
        $('.modal').hide();
        $(".modal__base-content").remove();
    } else if (classList.includes('modal__base-content-options-description-settings' || parentClassList.includes('modal__base-content-options-description-settings'))) {
        // скрытие и показ настроек модалки по кнопке
        $('.modal__menu').toggle();
    } else if (classList.includes('modal__menu-edit')) {
        // скрытие и показ панели редактирования
        $('.modal__description-edit').toggle();
        $('.description-edit').text($('.modal__base-content-options-description-text').text());
        $('.modal__menu').toggle();
    } else if (classList.includes('like') || parentClassList.includes('like')) {
        // отображение лайка
        const like = $('.like');
        if (like.hasClass('active')) {
            like.removeClass('active');
        } else {
            like.addClass('active');
        }
    }
});
