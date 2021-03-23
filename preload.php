<?php

//TODO использовать в дальнейшем чтобы роутер создавался один раз

//use base\Router;
//
//spl_autoload_register(function($className) {
//    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
//});
//
//$router = Router::getInstance();
//
//if (!$router->getRoutes())
//{
//    $router->addRoute('/logout', 'views\LogoutView', true);
//    $router->addRoute('/new_image', 'views\ImageView', true);
//    $router->addRoute('/settings', 'views\SettingsView', true);
//    $router->addRoute('/search', 'api\SearchUserAPIView', true);
//    $router->addRoute('/comments', 'api\CommentAPIView', true);
//    $router->addRoute('/likes', 'api\LikeAPIView', true);
//    $router->addRoute('/images_database', 'api\ImageAPIView', true);
//    $router->addRoute('/users', 'api\UserAPIView', true);
//    $router->addRoute('/comments/{id}', 'api\CommentAPIView', true);
//    $router->addRoute('/likes/{id}', 'api\LikeAPIView', true);
//    $router->addRoute('/images_database/{id}', 'api\ImageAPIView', true);
//    $router->addRoute('/users/{id}', 'api\UserAPIView', true);
//    $router->addRoute('/{login}', 'views\UserView', true);
//    $router->addRoute('/', 'views\MainView', true);
//
//    $router->addRoute('/register', 'views\RegisterView');
//    $router->addRoute('/submit_register', 'views\SubmitRegisterView');
//    $router->addRoute('/change_password_request', 'views\ChangePasswordRequest');
//    $router->addRoute('/', 'views\LoginView');
//
//    $router->setNotAuthorizedTemplate('views/templates/403.php');
//    $router->setNotFoundTemplate('views/templates/404.php');
//}