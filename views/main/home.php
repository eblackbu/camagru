<?php
require_once __DIR__ . '/../blocks/header.php';
require_once __DIR__ . '/../../models/Image.php';
?>

<div class="home">
    <div class="home__sidebar">
        <?php
            require __DIR__ . '/../blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main">

        <?php if(isset($_GET["profile_id"])) {?>
            <div class="home__main-profile">
                <div class="profile__main">
                    <div class="profile__main-info">
                        <div class="modal__base-content-title-avatar profile__main-info-avatar">
                            <a href="#"><img src="/views/image/none.png" alt=""></a>
                        </div>
                        <div class="profile__main-info-nickname">
                            <a href="#"><h1 class="modal__base-content-title-nickname">profile_test</h1></a>
                        </div>
                    </div>
                    <div class="profile__main-subscribebutton">
                        <input type="button" value="подписаться" class="auth__form-btn">
                    </div>
                </div>

                <div class="profile__minor">
                    <div class="profile__minor-subscriptions"><span>Подписки</span> 100</div>
                    <div class="profile__minor-subscribers"><span>Подписчики</span> 20</div>
                </div>
            </div>
            <div class="home__main-posts">
                <?php
                $images = Image::getMany(array('created_by' => $_SESSION['user']['id']));
                foreach($images as $image)
                {
                    ?><div class="home__main-posts-item"><img src="<?php echo $image->getPath() ?>" alt=""></div><?php
                }
                ?>
            </div>
        <?php } else { ?>
            <a href="/new_photo"><div class="home__main-new">
                <img src="/views/image/photo2.svg" alt="">
            </div></a>
            <div class="home__main-posts">
                <?php
                $images = Image::getMany(array('created_by' => $_SESSION['user']['id']));
                foreach($images as $image)
                {
                    ?><div class="home__main-posts-item"><img src="<?php echo $image->getPath() ?>" alt=""></div><?php
                }
                ?>
            </div>
        <?php } ?>
        
        <div class="modal">
            <div class="modal__base">
                <div class="modal__base-close">
                    X
                </div>
            </div>
            <div class="modal__filler"></div>
        </div>
        
    </div>
</div>

<?php
require_once __DIR__ . '/../blocks/footer.php';