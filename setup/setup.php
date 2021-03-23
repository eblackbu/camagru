<?php

use models\Image;
use models\Subscription;
use models\User;
use setup\DB;

spl_autoload_register(function($className) {
    include_once __DIR__ . '/..' . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

function delTree($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

// создаем бд
$setup_script = file_get_contents(__DIR__ . '/setup.sql');
if (file_exists(__DIR__ . '/../camagru.sqlite3'))
    unlink(__DIR__ . '/../camagru.sqlite3');
DB::getInstance()->exec($setup_script);

// создаем админа
$admin_user = new User(array(
    'login' => 'admin',
    'password' => 'qwerty123',
    'email' => 'admin@admin.ru'
));
$admin_user->save();

//добавляем фотки
$images_dir = __DIR__ . '/base_images';
$admin_user = User::getOne(array('login' => 'admin'));
$images = array_diff(scandir($images_dir), array('..', '.'));

if (file_exists(__DIR__ . '/../images_database'))
    delTree(__DIR__ . '/../images_database');
mkdir(__DIR__ . '/../images_database', 0777, true);

foreach ($images as $file) {
    $obj = new Image(
        array(
            'label' => 'Это подпись',
            'created_by' => $admin_user->id,
            'extension' => pathinfo($images_dir . '/' . $file, PATHINFO_EXTENSION)
        )
    );
    $obj->save();
    file_put_contents($obj->getFullPath(), file_get_contents($images_dir . '/' . $file));
}

$another_user = new User(array(
    'login' => 'eblackbu',
    'password' => 'qwerty123',
    'email' => 'eblackbu@eblackbu.ru'
));
$another_user->save();
$another_user = User::getOne(array('login' => 'eblackbu'));
$subscription = new Subscription(array(
    'user_from' => $another_user->id,
    'user_where' => $admin_user->id
));
$subscription->save();
