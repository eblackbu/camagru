<?php
require_once __DIR__ . '/../blocks/header.php';
require_once __DIR__ . '/../../models/Subscription.php';
require_once __DIR__ . '/../../models/Image.php';
?>

<div class="home main">
    <div class="home__sidebar main__sidebar">
        <?php
            require __DIR__ . '/../blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main main__main">
        safsdf<br>
        sdfdsfsdfsdfsd<br>
        sdfdsfsdfsdfsdf<br>
        safsdf<br>
        sdfdsfsdfsdfsd<br>
        sdfdsfsdfsdfsdf<br>
        safsdf<br>
        sdfdsfsdfsdfsd<br>
        sdfdsfsdfsdfsdf<br>
        safsdf<br>
        sdfdsfsdfsdfsd<br>
        sdfdsfsdfsdfsdf<br>
        <?php
        $subscriptions = Subscription::getMany(array('user_from' => $_SESSION['user']['id']));
        $images = $subscriptions ? Image::getMany(array('created_by' => array_map(function ($x) {
            return $x->user_where;
        }, $subscriptions))) : [];
        foreach($images as $image)
        {
            ?><div class="home__main-posts-item"><img src="<?php echo $image->getPath() ?>" alt=""></div><?php
        }
        ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../blocks/footer.php';