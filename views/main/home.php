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
        <a href="#"><div class="home__main-new">
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
        <div class="home__main-posts-modal">
            <div class="home__main-posts-modal-base">
                <div class="home__main-posts-modal-base-close">
                    X
                </div>
            </div>
            <div class="home__main-posts-modal-filler"></div>
        </div>
        
    </div>
</div>

<?php
require_once __DIR__ . '/../blocks/footer.php';