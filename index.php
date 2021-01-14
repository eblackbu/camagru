<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$views_path = 'views/main/';
$handlers_path = 'handlers/';

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    switch ($_GET['action'])
    {
        case 'login':
            require_once($handlers_path . 'login_handler.php');
            login($_POST['login'], $_POST['password']);
            break;
        case 'register':
            require_once($handlers_path . 'register_handler.php');
            register($_POST['login'], $_POST['password'], $_POST['email']);
            break;
        default:
            require($views_path . '404.php');
            break;
    }
}
else if (isset($_SESSION['user']))
{
    switch ($segments[0])
    {
        case 'home':
            require($views_path . 'home.php');
            break;
        case 'new_photo':
            require($views_path . 'new_photo.php');
            break;
        case 'change_password':
            require($views_path . 'change_password.php');
            break;
        case 'logout':
            require_once($handlers_path . 'logout_handler.php');
            logout();
            break;
        case '':
            require($views_path . 'main.php');
            break;
        default:
            require($views_path . '404.php');
            break;
    }
}
else if (!$segments[1])
{
    switch ($segments[0])
    {
        case 'register':
            require($views_path . 'register.php');
            break;
        case 'submit_register':
            require_once($handlers_path . 'submit_register.php');
            submit_register($_GET['login'], $_GET['hash']);
            break;
        case 'change_password': // change_password_request ???
            require($views_path . 'change_password.php');
            break;
        case 'new_password':
            require($views_path . 'new_password.php');
            break;
        case '':
            require($views_path . 'login.php');
            break;
        default:
            require($views_path . '404.php');
            break;
    }
}
else
    require($views_path . '404.php');