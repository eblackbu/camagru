<?php
error_reporting(E_ALL & ~E_NOTICE);

session_start();
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$views_path = 'views/main/';

// print_r($uri);
// print_r($segments);

if (isset($_SESSION['user']))
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
        case '':
            require($views_path . 'main.php');
            break;
        default:
            require($views_path . '404.php');
            break;
    }
}
elseif (!$segments[1])
{
    switch ($segments[0])
    {
        case 'register':
            require($views_path . 'register.php');
            break;
        case 'change_password':
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