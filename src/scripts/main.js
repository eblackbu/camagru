let canvas;
let ctx;
let z = 0;
let stickers = [];
let dragok = false;
let startX;
let startY;

$(document).ready(() => {
    // скрытие сообщения в самом начале и фото режима
    if ($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }
    if (window.location.pathname === '/new_image') {
        canvas = document.getElementById('canvasMake');
        ctx = canvas.getContext('2d');
        canvas.onmousedown = myDown;
        canvas.onmouseup = myUp;
        canvas.onmousemove = myMove;
    }
    

    // скрытые канвасов
    $('#canvasMake').hide();
    // $('#canvasUpload').hide();
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
    // let canvas = document.getElementById('canvasUpload');
    let img = new Image;
    img.src = URL.createObjectURL(event.target.files[0]);
    img.onload = function () {
        canvas.width = this.width;
        canvas.height = this.height;
        stickers = [];
        z = 0;
        myPush(stickers, img, 0, 0, canvas.width, canvas.height, z++, false, true);
        draw();
    }
    $('#previewResult').addClass('active');
    $('.stickers').show();
    $('#canvasMake').show();
    $('#uploadFile').show();
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
        let canvasTmp = document.getElementById('canvasTmp');
        let ctxTmp = canvasTmp.getContext('2d');
        canvas.width = video.clientWidth;
        canvas.height = video.clientHeight;
        canvasTmp.width = video.clientWidth;
        canvasTmp.height = video.clientHeight;
        ctxTmp.drawImage(video, 0, 0, canvas.width, canvas.height);
        stickers = [];
        z = 0;
        myPush(stickers, canvasTmp, 0, 0, canvas.width, canvas.height, z++, false, true);
        draw();
        $('#previewResult').addClass('active');
        $('.stickers').show();
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

$(document).on('click', '.stickers', (event) => {
    let size = stickers[0].width * 0.30;
    let id = event.target.id;
    switch (id) {
        case 'sticker1':
            myPush(stickers, document.querySelector(`#${id}`), 0, 0, size, size, z++, false, false);
            draw();
            break;
        case 'sticker2':
            myPush(stickers, document.querySelector(`#${id}`), 0, 0, size, size, z++, false, false);
            draw();
            break;
        case 'sticker3':
            myPush(stickers, document.querySelector(`#${id}`), 0, 0, size, size, z++, false, false);
            draw();
            break;
    }
});

function myPush(array, selector, x, y, width, height, z, isDragging, noMove) {
    array.push({
        selector,
        x,
        y,
        width,
        height,
        z,
        isDragging,
        noMove
    })
}

function myMove(e) {
    if (dragok) {
        let mx = parseInt(e.offsetX);
        let my = parseInt(e.offsetY);

        let dx = mx - startX;
        let dy = my - startY;
        let coef = getSizeCoefficient();

        for (let el of stickers) {
            if (el.isDragging) {
                el.x += coef*dx;
                el.y += coef*dy;
            }
        }
        draw();
        startX = mx;
        startY = my;
    }
}

function myUp(e) {
    // draw();
    dragok = false;
    for (let el of stickers) {
        el.isDragging = false;
    }
}

function myDown(e) {
    let mx = parseInt(e.offsetX);
    let my = parseInt(e.offsetY);
    dragok = true;
    let group = [];
    let coef = getSizeCoefficient();
    for (let el of stickers) {
        if (!el.noMove) {
            if (mx > el.x/coef && mx < el.x/coef + el.width && my > el.y/coef && my < el.y/coef + el.height) {
                group.push(el);
            }
        }
    }
    
    if (group.length === 1)
    {
        group[0].isDragging = true;
    }
    else if (group.length >= 2)
    {
        let maxZ = group[0].z;
        let b = group[0];
        for (var i = 1; i < group.length; i++)
        {
            if (maxZ < group[i].z)
            {
                maxZ = group[i].z;
                b = group[i];
            }
        }
        b.isDragging = true;
    }

    startX = mx;
    startY = my;
}

// отрисовка фигуры
function rect(r) {
    if (!r.noMove) {
        ctx.drawImage(r.selector, r.x, r.y, r.width, r.height);
    } else {
        ctx.drawImage(r.selector, r.x, r.y);
    }
}

// отрисовка массива фигур
function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (let el of stickers) {
        rect(el);
    }
} 

function getSizeCoefficient() {
    let displayWidth = window.innerWidth;
    let resCanvas = $('#canvasMake')[0];
    let div = $('#previewResult')[0];
    let widthCoef = resCanvas.width/div.clientWidth;
    if (displayWidth > 870) {
        return +(widthCoef / 0.6).toFixed(2);
    }
    return +widthCoef.toFixed(2);
} 