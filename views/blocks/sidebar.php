<?php

require_once ('handlers/logout_handler.php');
require_once ('models/User.php');

?>

<div class="sidebar">
    <div class="sidebar__profile group">
        <div class="sidebar__profile-avatar">
            <img src="/views/image/drochila.jpg" alt="">
        </div>
        <div class="sidebar__profile-nickname">
            <?php echo $_SESSION['user']['login']; ?>
        </div>
    </div>
    <div class="sidebar__statistics group">
        <div class="sidebar__statistics-subscriptions"><a href="">Подписки: <?php echo User::getSubscriptionsCount($_SESSION['user']['id']); ?></a></div>
        <div class="sidebar__statistics-subscribers"><a href="">Подписчики: <?php echo User::getSubscribersCount($_SESSION['user']['id']); ?></a></div>
    </div>
    <div class="sidebar__options group">
        <div class="sidebar__options-search"><span id="search">Поиск</span></div>
        <div class="sidebar__options-settings"><a href="/change_password">Настройки</a></div>
        <div class="sidebar__options-logout"><a href="/logout">Выйти</a></div>
    </div>
</div>

<div class="search">
    <div class="search__close">x</div>
    <div class="search__form">
        <form>
            <input type="text" id="search_input" value="найти">
            <input type="button" value="найти" id="search_get">
        </form>
    </div>
    <div class="search__result"></div>
</div>