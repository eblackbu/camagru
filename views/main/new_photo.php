<?php
require_once __DIR__ . '/../blocks/header.php';
?>
    <div class="addPhoto">
        <form action="">
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
                <input type="file" name="file" accept="image/png,image/jpeg" >
                <canvas id='canvasUpload' width='300' height='200'></canvas> 
            </div>
            <button type="submit">Добавить фото</button>
            <input id="lol">files</input>
        </form>
    </div>


<?php
require_once __DIR__ . '/../blocks/footer.php';
