<?php
require_once __DIR__ . '/../template_blocks/header.php';
?>
    <div class="home addPhoto">
        <div class="home__sidebar">
                <?php
                    require __DIR__ . '/../template_blocks/sidebar.php';
                ?>
        </div>
        <div class="home__main">
            <form class="image-form" id="image-form" name="image_form" action="/?action=add_photo" method="POST" enctype="multipart/form-data">
                <span class="make active tabs">Сделать фото</span>
                <span class="upload tabs">Загрузить фото</span>
                <div class="makePhoto">
                    <div class="preview">
                        <video autoplay></video>
                    </div>
                    <input type='button' value="Щелк!" class="snapshot auth__form-btn">
                </div>
                <div class="uploadPhoto">
                    <div class="input__wrapper">
                        <input name="file" type="file" name="file" id="input__file" class="input input__file" accept="image/png,image/jpeg" multiple >
                        <label for="input__file" class="input__file-button">
                            <span class="input__file-button-text">Выберите файл</span>
                        </label>
                    </div>
                </div>
                <div class="preview" id="previewResult">
                    <canvas id='canvasMake'></canvas>
                    <!-- <img id="shot" src="https://avatars.mds.yandex.net/get-banana/28825/x25DNBUr1VR8xaUkLGhXLsY5X_banana_20161021_logo.png/optimize" alt=""> -->
                </div>
                <div class="preview">
                    <canvas id="canvasTmp"></canvas>
                </div>
                <div class="stickers">
                    <img src="/views/image/1.png" id="sticker1" class="sticker">
                    <img src="/views/image/2.png" id="sticker2" class="sticker">
                    <img src="/views/image/3.png" id="sticker3" class="sticker">
                </div>
                <div class="addPhoto__comment">
                    <textarea name="" id="" rows="3" class="modal__textarea"></textarea>
                </div>
                <input type="button" value="Загрузить" id="uploadFile" class="auth__form-btn">
            </form>
        </div>
        <div class="ajax-reply"></div>
    </div>



<?php
require_once __DIR__ . '/../template_blocks/footer.php';
