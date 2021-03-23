<?php

use models\User;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

?>

<div class="sidebar">
    <div class="sidebar__profile group">
        <a href="/<?= $_SESSION['user']['login']?>">
            <div class="sidebar__profile-avatar">
                <img src="/views/image/none.png" alt="">
            </div>
            <div class="sidebar__profile-nickname">
                <?= $_SESSION['user']['login']; ?>
            </div>
        </a>
    </div>
    <div class="sidebar__statistics group">
        <div class="sidebar__statistics-subscriptions"><a href="">Подписки: <?= User::getSubscriptionsCount($_SESSION['user']['id']); ?></a></div>
        <div class="sidebar__statistics-subscribers"><a href="">Подписчики: <?= User::getSubscribersCount($_SESSION['user']['id']); ?></a></div>
    </div>
    <div class="sidebar__options group">
        <div class="sidebar__options-search"><span class="search-open">Поиск</span></div>
        <div class="sidebar__options-repassword"><a href="/settings">Настройки</a></div>
        <div class="sidebar__options-logout"><a href="/logout">Выйти</a></div>
    </div>
</div>

<div class="search">
    <div class="search__close">x</div>
    <div class="search__form">
        <form>
            <input type="text" class="search_input">
            <input type="button" class="search_get" value="найти">
        </form>
    </div>
</div>