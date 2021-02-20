// скрытие сообщения в самом начале и фото режима
$(document).ready(function(){
    if($('.header__notifications').children().length == 0) {
        $('.header__notifications').hide();
    }

    if ($('input[name="choice"]:checked').val() == '1') {
        $('.uploadPhoto').hide();
    } else if ($('input[name="choice"]:checked').val() == '2') {
        $('.makePhoto').hide();
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
        $('.main__main').css('opacity', '1');
        $('.home__main').css('opacity', '1');
        $('.search').hide();
        
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

// скрытие и показ настроек модалки по кнопке
$(document).on('click','.modal__base-content-options-description-settings', function(){
    $('.modal__menu').toggle();
});

// скрытие и показ панели редактирования
$(document).on('click','.modal__menu-edit', function(){
    $('.modal__description-edit').toggle();
    $('.description-edit').text($('.modal__base-content-options-description-text').text());
    $('.modal__menu').toggle();
});

// отображение лайка
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

// скрытие и показ коментариев
$(document).on('click','.modal__base-content-options-statistics-comments', function(){
    $('.modal__comments').toggle();
});

// логика подключения вебки
// let constraints = { audio: false, video: { width: 300, height: 200 } };
//
// navigator.mediaDevices.getUserMedia(constraints)
// .then(function(mediaStream) {
// let video = document.querySelector('video');
// video.srcObject = mediaStream;
// video.onloadedmetadata = function(e) {
//     video.play();
// };
// })
// .catch(function(err) { console.log(err.name + ": " + err.message); });
//
// // запись скрина в канвас
// $(document).on('click','#snapshot', function() {
//     let video = document.querySelector('video');
//     let canvas = document.getElementById('canvasMake');
//     let ctx = canvas.getContext('2d');
//     ctx.drawImage(video, 0, 0);
// });

// переключение режима добавления фото
let stateFirstRadio = false;
$(document).on('click', 'input[name="choice"]', function() { 
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
$(document).on('click', '#search', function() { 
    $('.search').show();
    $('.main__main').css('opacity', '.5');
    $('.home__main').css('opacity', '.5');
});

// скрытие поиска
$(document).on('click', '.search__close', function() { 
    $('.search').hide();
    $('.main__main').css('opacity', '1');
    $('.home__main').css('opacity', '1');
});    

// отправка аякса по нажатию клавиши "найти"
$(document).on('click', '#search_get', function() { 
    $.get(
        "/search",
        {
            search_string: $("#search_input").val(),
        },
        onAjaxSuccess
    );
});   

// функция, отрабатвающая в случае успешной отправки
function onAjaxSuccess(data)
{
    alert(data.join(', '));
}









// test bottom
$(document).on('click', '#lol', function() { 
    let file = $('input[type="file"]').prop('files');
    console.log(file[0]['name']);
    console.log(file);
}); 

// $(document).on('change', '#file', function(){
//     let photo = $('input[type="file"]').prop('files')[0]['name']; 
//     let canvas = document.getElementById('canvasUpload'); 
//     let ctx = canvas.getContext('2d'); 
//     ctx.drawImage(photo, 0, 0); 
// });

$(document).on('change', '#file', function(){
    let photo = $('input[type="file"]').prop('files');

    // FileReader support
    if (FileReader && photo && photo.length) {
        var fr = new FileReader(photo);
        console.log(fr.result);
        // fr.onload = function () {
        //     let canvas = document.getElementById('canvasUpload'); 
        //     let ctx = canvas.getContext('2d'); 
        //     ctx.drawImage(fr.result, 0, 0);
        // }
        // fr.readAsDataURL(files[0]);
    } else {
    }
});
