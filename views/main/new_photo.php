<?php
require_once __DIR__ . '/../blocks/header.php';
?>
    <div class="addPhoto">
        <form class="image-form" id="image-form" name="image_form" action="/?action=add_photo" method="POST" enctype="multipart/form-data">
            <label for="make" class="active">Сделать фото</label>
            <input type="radio" name="choice" id="make" checked value="1">
            <span class="br"></span>
            <label for="upload">Загрузить фото</label>
            <input type="radio" name="choice" id="upload" value="2">
            <div class="makePhoto">
                <div class="preview">
                    <video autoplay></video>
                </div>
                <input type='button' id='snapshot' value="Щелк!" class="auth__form-btn">
                <div class="preview">
                    <canvas id='canvasMake'></canvas> 
                </div>
            </div>
            <div class="uploadPhoto">
                <input type="file" name="file" id="file" accept="image/png,image/jpeg" >
                <div class="preview">
                    <canvas id='canvasUpload'></canvas>
                </div>
            </div>
            <input type="button" value="Загрузить" id="uploadFile" class="auth__form-btn">
        </form>
    </div>
    <div class="ajax-reply"></div>


<?php
require_once __DIR__ . '/../blocks/footer.php';
