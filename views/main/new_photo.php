<?php
require_once __DIR__ . '/../blocks/header.php';
?>
    <div class="addPhoto">
        <form class="image-form" id="image-form" name="image_form" action="" method="POST" enctype="multipart/form-data">
            <label for="make">Сделать фото</label>
            <input type="radio" name="choice" id="make" checked value="1">
            <label for="upload">Загрузить фото</label>
            <input type="radio" name="choice" id="upload" value="2">
            <div class="makePhoto">
                <video autoplay></video>
                <input type='button' id='snapshot' value="snapshot">
                <canvas id='canvasMake' width='300' height='200'></canvas> 
            </div>
            <div class="uploadPhoto">
                <input type="file" name="file" id="file" accept="image/png,image/jpeg" >
                <canvas id='canvasUpload' width='300' height='200'></canvas> 
            </div>
            <input type="button" value="Загрузить" id="uploadFile">
        </form>
    </div>
    <div class="ajax-reply"></div>


<?php
require_once __DIR__ . '/../blocks/footer.php';
