<?php

use router\SimpleRouter;

error_reporting(E_ALL & ~E_NOTICE);
session_start();

//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
//$segments = explode('/', trim($uri, '/'));
//$views_path = '/views/main/';
//$handlers_path = '/handlers/';
//$ajax_handlers_path = '/ajax_handlers/';
//
//require_once __DIR__ . '/helpers/redirect.php';
//
//if (isset($_SESSION['user'])) {
//    // TODO CSRF check
//    switch ($_SERVER['REQUEST_METHOD']) {
//        case 'POST':
//            if (!$segments[0])
//                switch ($_GET['action']) {
//                    case 'add_image':
//                        require_once __DIR__ . $ajax_handlers_path . 'add_image.php';
//                        add_image($_SESSION['user']['id'], $_FILES['upload_image'], $_POST['label']);
//                        break;
//                    case 'change_login':
//                        require_once __DIR__ . $handlers_path . 'change_login.php';
//                        change_login($_POST['new_login']);
//                        break;
//                    case 'change_password':
//                        require_once __DIR__ . $handlers_path . 'change_password.php';
//                        change_password($_POST['old_password'], $_POST['new_password']);
//                        break;
//                    default:
//                        require __DIR__ . $views_path . '404.php';
//                        break;
//                }
//            break;
//        case 'DELETE':
//            if (!isset($segments[3]))
//                switch ($segments[0]) {
//                    case 'comments':
//                        require_once __DIR__ . $ajax_handlers_path . 'delete_comment.php';
//                        delete_comment($segments[2]);
//                        break;
//                    case 'images':
//                        require_once __DIR__ . $ajax_handlers_path . 'delete_image.php';
//                        delete_image($segments[2]);
//                        break;
//                    case 'delete':
//                        require_once __DIR__ . $handlers_path . 'delete_user.php';
//                        delete_user($segments[2]);
//                        break;
//                    default:
//                        require __DIR__ . $views_path . '404.php';
//                        break;
//                }
//            break;
//        case 'GET':
//            if (!isset($segments[1]))
//                switch ($segments[0]) {
//                    case 'logout':
//                        require_once __DIR__ . $handlers_path . 'logout.php';
//                        logout();
//                        break;
//                    case 'new_photo':
//                        require __DIR__ . $views_path . 'new_photo.php';
//                        break;
//                    case 'change_info':
//                        require __DIR__ . $views_path . 'change_info.php';
//                        break;
//                    case 'search':
//                        require __DIR__ . $ajax_handlers_path . 'search_user.php';
//                        search($_GET['search_string']);
//                        break;
//                    case 'comments':
//                        require __DIR__ . $ajax_handlers_path . 'get_comments.php';
//                        get_comments($_GET['image_id']);
//                        break;
//                    case 'likes':
//                        require __DIR__ . $ajax_handlers_path . 'get_likes_count.php';
//                        get_likes_count($_GET['image_id']);
//                        break;
//                    case '':
//                        require __DIR__ . $views_path . 'main.php';
//                        break;
//                    default:
//                        require __DIR__ . $views_path . '404.php';
//                        break;
//                }
//            else if ($segments[0] == 'users' && !isset($segments[2]))
//                require __DIR__ . $views_path . 'user.php';
//            break;
//        default:
//            require __DIR__ . $views_path . '404.php';
//    }
//}
//else {
//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//        switch ($_GET['action']) {
//            case 'login':
//                require_once __DIR__ . $handlers_path . 'login.php';
//                login($_POST['login'], $_POST['password']);
//                break;
//            case 'register':
//                require_once __DIR__ . $handlers_path . 'register.php';
//                register($_POST['login'], $_POST['password'], $_POST['email']);
//                break;
//        }
//    }
//    else if (!isset($segments[1])) {
//        switch ($segments[0]) {
//            case 'register':
//                require __DIR__ . $views_path . 'register.php';
//                break;
//            case 'submit_register':
//                require_once __DIR__ . $handlers_path . 'submit_register.php';
//                submit_register($_GET['login'], $_GET['hash']);
//                break;
//            case 'change_password_request':
//                require_once __DIR__ . $ajax_handlers_path . 'change_password_request.php';
////                change_password_request();
//                break;
//            case '':
//                require __DIR__ . $views_path . 'login.php';
//                break;
//            default:
//                require __DIR__ . $views_path . '404.php';
//                break;
//        }
//    }
//}


require_once 'router/SimpleRouter.php';
require_once 'views/MainView.php';

$router = SimpleRouter::getInstance();

$router->addRoute('/login', 'loginView');
$router->addRoute('/register', 'registerView');

$router->callController($_SERVER['REQUEST_URI']);
