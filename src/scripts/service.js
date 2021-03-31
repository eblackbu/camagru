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
            data.forEach((el) => {
                $(`<div class="search__result-item">
                    <div class="search__result-item-nickname"><a href="/${el['login']}">${el['login']}</a></div>
                </div>`).appendTo(".search__result");
            })
        }
    });
});

// загрузка фото на сервер
$(document).on('click', "#uploadFile", () => {
    if (window.FormData === undefined) {
        alert('В вашем браузере FormData не поддерживается')
    } else {
        console.log(canvas);
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