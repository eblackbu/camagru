<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$segments = explode('/', trim($uri, '/'));
$views_path = '/views/main/';
$handlers_path = '/handlers/';

require_once __DIR__ . '/helpers/redirect.php';

if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_GET['action']) {
            case 'add_image':
                require_once __DIR__ . $handlers_path . 'add_image_handler.php';
                add_image($_SESSION['user']['id'], $_FILES['loaded_image'], $_POST['label']);
                break;
            case 'change_login':
                require_once __DIR__ . $handlers_path . 'change_login_handler.php';
                change_login($_POST['new_login']);
                break;
            case 'change_password':
                require_once __DIR__ . $handlers_path . 'change_password_handler.php';
                change_password($_POST['old_password'], $_POST['new_password']);
                break;
            default:
                require __DIR__ . $views_path . '404.php';
                break;
        }
    }
    else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        switch ($segments[0]) {
            case 'logout':
                require_once __DIR__ . $handlers_path . 'logout_handler.php';
                logout();
                break;
            case 'delete':
                require_once __DIR__ . $handlers_path . 'delete_user_handler.php';
                delete_user($_SESSION['user']['id']);
                break;
            case 'new_photo':
                require __DIR__ . $views_path . 'new_photo.php';
                break;
            case 'change_info':
                require __DIR__ . $views_path . 'change_info.php';
                break;
            case 'users':
                require __DIR__ . $views_path . 'user.php';
                break;
            case 'search':
                require __DIR__ . $handlers_path . 'search_handler.php';
                search($_GET['search_string']);
                break;
            case '':
                require __DIR__ . $views_path . 'main.php';
                break;
            default:
                require __DIR__ . $views_path . '404.php';
                break;
        }
    }
    else
        require __DIR__ . $views_path . '404.php';
}
else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        switch ($_GET['action']) {
            case 'login':
                require_once __DIR__ . $handlers_path . 'login_handler.php';
                login($_POST['login'], $_POST['password']);
                break;
            case 'register':
                require_once __DIR__ . $handlers_path . 'register_handler.php';
                register($_POST['login'], $_POST['password'], $_POST['email']);
                break;
        }
    }
    else if (!isset($segments[1])) {
        switch ($segments[0]) {
            case 'register':
                require __DIR__ . $views_path . 'register.php';
                break;
            case 'submit_register':
                require_once __DIR__ . $handlers_path . 'submit_register.php';
                submit_register($_GET['login'], $_GET['hash']);
                break;
            case 'change_password': // change_password_request ???
                require __DIR__ . $views_path . 'change_info.php';
                break;
            case 'new_password':
                require __DIR__ . $views_path . 'new_password.php';
                break;
            case '':
                require __DIR__ . $views_path . 'login.php';
                break;
            default:
                require __DIR__ . $views_path . '404.php';
                break;
        }
    }
}