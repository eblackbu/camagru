<?php

use models\Image;
use models\Subscription;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

require_once __DIR__ . '/../template_blocks/header.php';
?>

<div class="home main">
    <div class="home__sidebar main__sidebar">
        <?php
            require __DIR__ . '/../template_blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main main__main">
        <?php
        $subscriptions = Subscription::getMany(array('user_from' => $_SESSION['user']['id']));
        $images = $subscriptions ? Image::getMany(array('created_by' => array_map(function ($x) {
            return $x->user_where;
        }, $subscriptions))) : [];
        foreach($images as $image)
        {
            ?><div class="home__main-posts-item"><img src="<?= $image->getPath() ?>" alt=""></div><?php
        }
        ?>
    </div>
</div>

<?php
require_once __DIR__ . '/../template_blocks/footer.php';