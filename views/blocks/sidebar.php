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
            adskiy_drochila
        </div>
    </div>
    <div class="sidebar__statistics group">
        <div class="sidebar__statistics-subscriptions"><a href="">Подписки: <?php User::getSubscriptionsCount($_SESSION['user']['id']) ?></a></div>
        <div class="sidebar__statistics-subscribers"><a href="">Подписчики: <?php User::getSubscribersCount($_SESSION['user']['id']) ?></a></div>
    </div>
    <div class="sidebar__options group">
        <div class="sidebar__options-rename"><a href="">Смена ника</a></div>
        <div class="sidebar__options-repassword"><a href="/change_password">Смена пароля</a></div>
        <div class="sidebar__options-logout"><a href="/logout">Выйти</a></div>
    </div>
</div>