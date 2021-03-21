<?php

use base\Router;

error_reporting(E_ALL & ~E_NOTICE);
session_start();

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

$router = new Router();

if (isset($_SESSION['user']))
{
    $router->addRoute('/logout', 'views\LogoutView');
    $router->addRoute('/new_image', 'views\ImageView');
    $router->addRoute('/settings', 'views\SettingsView');

    $router->addRoute('/search', 'api\SearchUserAPIView');
    $router->addRoute('/comments', 'api\CommentAPIView');
    $router->addRoute('/likes', 'api\LikeAPIView');
    $router->addRoute('/images', 'api\ImageAPIView');
    $router->addRoute('/users', 'api\UserAPIView');
    $router->addRoute('/comments/{id}', 'api\CommentAPIView');
    $router->addRoute('/likes/{id}', 'api\LikeAPIView');
    $router->addRoute('/images/{id}', 'api\ImageAPIView');
    $router->addRoute('/users/{id}', 'api\UserAPIView');

    $router->addRoute('/{login}', 'views\UserView');
    $router->addRoute('/', 'views\MainView');
}
else
{
    $router->addRoute('/register', 'views\RegisterView');
    $router->addRoute('/submit_register', 'views\SubmitRegisterView');
    $router->addRoute('/change_password_request', 'views\ChangePasswordRequest');
    $router->addRoute('/', 'views\LoginView');
}

$router->setBadURITemplate('views/templates/404.php');

$router->callView($_SERVER['REQUEST_URI']);
