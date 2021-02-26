<?php
require_once __DIR__ . '/../blocks/header.php';
require_once __DIR__ . '/../../models/Image.php';
require_once __DIR__ . '/../../models/User.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));

if (!isset($segments[1]))
{
    require_once __DIR__ . '/404.php';
    exit();
}


try {
    $user = User::getOne(array('login' => $segments[1]));
} catch (ORMException $e) {
    require_once __DIR__ . '/404.php';
    exit();
}

$avatar = $user->avatar_path ?? null;

?>

<div class="home">
    <div class="home__sidebar">
        <?php
            require __DIR__ . '/../blocks/sidebar.php';
        ?>
    </div>
    <div class="home__main">
            <div class="home__main-profile">
                <div class="profile__main">
                    <div class="profile__main-info">
                        <div class="modal__base-content-title-avatar profile__main-info-avatar">
                            <a href="/users/<?=$user->login?>"><img src="<?php echo $avatar ?? '/views/image/none.png'?>" alt=""></a>
                        </div>
                        <div class="profile__main-info-nickname">
                            <a href="/users/<?=$user->login?>"><h1 class="modal__base-content-title-nickname"><?php echo $user->login ?></h1></a>
                        </div>
                    </div>
                    <?php if ($user->id != $_SESSION['user']['id']): ?>
                    <div class="profile__main-subscribebutton">
                        <input type="button" value="подписаться" class="auth__form-btn">
                    </div>
                    <?php endif; ?>
                </div>

                <div class="profile__minor">
                    <div class="profile__minor-subscriptions"><span>Подписки</span> <?php echo User::getSubscriptionsCount($user->id); ?></div>
                    <div class="profile__minor-subscribers"><span>Подписчики</span> <?php echo User::getSubscribersCount($user->id); ?></div>
                </div>
            </div>
            <?php if ($user->id == $_SESSION['user']['id']): ?>
            <a href="/new_photo"><div class="home__main-new">
                <img src="/views/image/photo2.svg" alt="">
            </div></a>
            <?php endif; ?>
            <div class="home__main-posts">
                <?php
                $images = Image::getMany(array('created_by' => $user->id));
                foreach($images as $image)
                {
                    ?><div class="home__main-posts-item"><img src="<?php echo $image->getPath() ?>" alt=""></div><?php
                }
                ?>
            </div>
        
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