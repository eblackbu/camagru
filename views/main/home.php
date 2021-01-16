<?php
require_once __DIR__ . '/../blocks/header.php';
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
            <div class="home__main-posts-item"><img src="/views/image/1.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/2.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/3.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/4.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/5.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/1.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/2.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/3.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/4.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/5.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/1.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/2.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/3.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/4.jpg" alt=""></div>
            <div class="home__main-posts-item"><img src="/views/image/5.jpg" alt=""></div>
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