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

    // загрузка фото на сервер
    $("#uploadFile").click(() => {
        if (window.FormData === undefined) {
            alert('В вашем браузере FormData не поддерживается')
        } else {
            let canvas = prepToServer();
            canvas.toBlob(function(blob) {
                let formData = new FormData();
                formData.append('upload_image', blob);
                $.ajax({
                    type: "POST",
                    url: '/?action=add_image',
                    contentType: false,
                    processData: false,
                    data: formData,
                    dataType : 'json'
                });
            });
        }
    });
});

function hide_notifications() {
    $('.header__notifications').hide();
    $('.header__notifications').removeClass('active');
}

// скрытие сообщения по щелчку
$(document).on('click', '.header__notifications', () => {
    $('.header__notifications').addClass('active');
    setTimeout(hide_notifications, 900);
});

// скрытие и показ меню шапки
$(document).on('click', '.header__content-menu', () => {
    $('.header__content-sidebar').toggle();
    if ($('.header__content-menu').hasClass('active')) {
        $('.header__content-menu').removeClass('active');
        $('.main__main').css('opacity', '1');
        $('.home__main').css('opacity', '1');
        $('.search').hide();

    } else {
        $('.header__content-menu').addClass('active');
    }
});

// скрытие модалки по щелчку закрытия
$(document).on('click', '.modal__base-close', () => {
    $('.home__main-posts').css('opacity', '1');
    $('.home__main-profile').css('opacity', '1');
    $('.home__main-new').css('opacity', '1');
    $('.modal').hide();
    $(".modal__base-content").remove();
});

// скрытие и показ настроек модалки по кнопке
$(document).on('click', '.modal__base-content-options-description-settings', () => {
    $('.modal__menu').toggle();
});

// скрытие и показ панели редактирования
$(document).on('click', '.modal__menu-edit', () => {
    $('.modal__description-edit').toggle();
    $('.description-edit').text($('.modal__base-content-options-description-text').text());
    $('.modal__menu').toggle();
});

// отображение лайка
$(document).on('click', '.like', () => {
    const like = $('.like');
    if (like.hasClass('active')) {
        like.removeClass('active');
    } else {
        like.addClass('active');
    }

    // let id = $('.modal__base-content-image').children()[0].id;
    // id = id.substr(5);
    // $.ajax({
    //     url: `/images/${id}`,
    //     type: 'DELETE',
    //     success: () => alert('set!'),
    //     error: () => alert('error!'),
    // });
});

// скрытие и показ коментариев
$(document).on('click', '.modal__base-content-options-statistics-comments', () => {
    $('.modal__comments').toggle();
});

// логика подключения вебки
let url = window.location.pathname;
if (url == "/new_photo") {
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

// запись скрина в канвас
$(document).on('click', '#snapshot', () => {
    let video = document.querySelector('video');
    let canvas = document.getElementById('canvasMake');
    canvas.width = video.clientWidth;
    canvas.height = video.clientHeight;
    let ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    $('#canvasMake').show();
    $('#uploadFile').show();
});

// переключение режима добавления фото
$(document).on('click', '.make', () => {
    if (!$('.make').hasClass('active')) {
        $('.make').addClass('active');
        $('.upload').removeClass('active');
        $('.uploadPhoto').hide();
        $('.makePhoto').show();
    }
});

$(document).on('click', '.upload', () => {
    if (!$('.upload').hasClass('active')) {
        $('.upload').addClass('active');
        $('.make').removeClass('active');
        $('.makePhoto').hide();
        $('.uploadPhoto').show();
    }
});

// показ поиска
$(document).on('click', '#search', () => {
    $('.search').show();
    $('.main__main').css('opacity', '.5');
    $('.home__main').css('opacity', '.5');
});

// скрытие поиска
$(document).on('click', '.search__close', () => {
    $('.search').hide();
    $('.main__main').css('opacity', '1');
    $('.home__main').css('opacity', '1');
});

// функция, выбирающая значение для поиска (костыль)
function chooseInput() {
    let result = '';
    $(".search_input").map((indx, element) => {
        if (!!$(element).val()) {
            result = $(element).val();
        }
    });
    return result;
}

// функция для предпросмотра загруженного файла
function handleFiles(e) {
    let canvas = document.getElementById('canvasUpload');
    let img = new Image;
    img.src = URL.createObjectURL(e.target.files[0]);
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

// ====================AJAXES=========================
// отправка аякса по нажатию клавиши "найти"
$(document).on('click', '.search_get', () => {
    $.ajax({
        url: "/search",
        type: 'GET',
        data: {
            search_string: chooseInput(),
        },
        success: (data) => {
            $(".search__result").remove();
            $(`<div class="search__result"></div>`).appendTo(".search");
            for (let i = 0; i < data.length; i++) {
                $(`<div class="search__result-item">
                    <div class="search__result-item-nickname"><a href="/users/${data[i]['id']}">${data[i]['login']}</a></div>
                </div>`).appendTo(".search__result");
            }
        }
    });
});


// удаление фото
$(document).on('click', '.modal__menu-delete', () => {
    let id = $('.modal__base-content-image').children()[0].id;
    id = id.substr(5);
    $.ajax({
        url: `/images/${id}`,
        type: 'DELETE',
        success: () => alert('удалено!'),
        error: () => alert('bad!'),
    });
});

// получение количества лайков




// function ajax(url, type, success, data, contentType = false, processData = false, dataType = null) {
//     $.ajax({
//         url,
//         type,
//         contentType,
//         processData,
//         data,
//         dataType,
//         success,
//     });       
// }