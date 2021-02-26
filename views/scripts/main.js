// скрытие сообщения в самом начале и фото режима
$(document).ready(function () {
    if ($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }

    if ($('input[name="choice"]:checked').val() == '1') {
        $('.uploadPhoto').hide();
    } else if ($('input[name="choice"]:checked').val() == '2') {
        $('.makePhoto').hide();
    }

    // отображения загруженного файла
    $("#file").on('change', handleFiles);

    // загрузка фото на сервер
    $("#uploadFile").click(function () {
        console.log(prepToServer());
        $.ajax({
            type: "POST",
            url: "example.php",
            data: { img: prepToServer() }
        }).done(function (msg) {
            alert('done!');
        });
    });
});

function hide_notifications() {
    $('.header__notifications').hide();
    $('.header__notifications').removeClass('active');
}

// скрытие сообщения по щелчку
$(document).on('click', '.header__notifications', function () {
    $('.header__notifications').addClass('active');
    setTimeout(hide_notifications, 900);
});

// скрытие и показ меню шапки
$(document).on('click', '.header__content-menu', function () {
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
$(document).on('click', '.modal__base-close', function () {
    $('.home__main-posts').css('opacity', '1');
    $('.modal').hide();
    $(".modal__base-content").remove();
});

// скрытие и показ настроек модалки по кнопке
$(document).on('click', '.modal__base-content-options-description-settings', function () {
    $('.modal__menu').toggle();
});

// скрытие и показ панели редактирования
$(document).on('click', '.modal__menu-edit', function () {
    $('.modal__description-edit').toggle();
    $('.description-edit').text($('.modal__base-content-options-description-text').text());
    $('.modal__menu').toggle();
});

// отображение лайка
$(document).on('click', '.like', function () {
    if ($('.like__left').css('background-color') == 'rgb(255, 255, 255)') {
        $('.like__left').css({ 'background-color': 'rgb(255, 0, 0)', 'border': 'none' });
        $('.like__right').css({ 'background-color': 'rgb(255, 0, 0)', 'border': 'none' });
        $('.like__filler').hide();
    } else {
        $('.like__left').css({ 'background-color': 'rgb(255, 255, 255)', 'border': '0.5px solid black' });
        $('.like__right').css({ 'background-color': 'rgb(255, 255, 255)', 'border': '0.5px solid black' });
        $('.like__filler').show();
    }
});

// скрытие и показ коментариев
$(document).on('click', '.modal__base-content-options-statistics-comments', function () {
    $('.modal__comments').toggle();
});

// логика подключения вебки
let constraints = { audio: false, video: { width: 300, height: 200 } };
let url = window.location.pathname;
if (url == "/new_photo") {
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
$(document).on('click', '#snapshot', function () {
    let video = document.querySelector('video');
    let canvas = document.getElementById('canvasMake');
    let ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0);
});

// переключение режима добавления фото
let stateFirstRadio = false;
$(document).on('click', 'input[name="choice"]', function () {
    if ($('input[name="choice"][value="1"]').prop("checked") && stateFirstRadio) {
        $('.uploadPhoto').toggle();
        $('.makePhoto').toggle();
        stateFirstRadio = false;
    } else if ($('input[name="choice"][value="2"]').prop("checked") && !stateFirstRadio) {
        $('.uploadPhoto').toggle();
        $('.makePhoto').toggle();
        stateFirstRadio = true;
    }
});

// показ поиска
$(document).on('click', '#search', function () {
    $('.search').show();
    $('.main__main').css('opacity', '.5');
    $('.home__main').css('opacity', '.5');
});

// скрытие поиска
$(document).on('click', '.search__close', function () {
    $('.search').hide();
    $('.main__main').css('opacity', '1');
    $('.home__main').css('opacity', '1');
});

// отправка аякса по нажатию клавиши "найти"
$(document).on('click', '.search_get', function () {
    $.get(
        "/search",
        {
            search_string: chooseInput(),
        },
        onAjaxSuccess
    );
});

// функция, отрабатвающая в случае успешной отправки
function onAjaxSuccess(data) {
    $(".search__result").remove();
    $(`<div class="search__result"></div>`).appendTo(".search");
    for (let i = 0; i < data.length; i++) {
        $(`<div class="search__result-item">
            <div class="search__result-item-nickname"><a href="/users/${data[i]['login']}">${data[i]['login']}</a></div>
        </div>`).appendTo(".search__result");
    }
}

// функция, выбирающая значение для поиска (костыль)
function chooseInput() {
    let result = '';
    $(".search_input").map(function (indx, element) {
        if (!!$(element).val()) {
            result = $(element).val();
        }
    });
    return result;
}

// функция для предпросмотра загруженного файла
function handleFiles(e) {
    var ctx = document.getElementById('canvasUpload').getContext('2d');
    var img = new Image;
    img.src = URL.createObjectURL(e.target.files[0]);
    img.onload = function () {
        ctx.drawImage(img, 0, 0, 300, 200);
    }
}

// выбор нужного канваса
function prepToServer() {
    let canvas;
    if ($('input[name="choice"][value="1"]').prop("checked")) {
        canvas = document.getElementById('canvasMake');
    } else {
        canvas = document.getElementById('canvasUpload');
    }
    return canvas.toDataURL();
}



















///
function addImage() {
    // создать объект для формы
    var formData = new FormData(document.forms.image_form);
    // отослать
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "example.php", false);
    xhr.send(formData);
}