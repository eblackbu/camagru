<?php

session_start();

require_once __DIR__ . '/../models/Image.php';

function add_image($user, $image, $label)
{
    if (!substr($image, 0, 6 ) === "image/")
    {
        $_SESSION['notification'] = 'Ошибка при загрузке файла - он не является картинкой';
        redirect_to('/');
    }
    $obj = new Image(array(
        'label' => $label,
        'created_by' => $user,
        'extension' => pathinfo($image->tmppath, PATHINFO_EXTENSION))
    );
    $obj->save();
    file_put_contents($obj->getPath(), file_get_contents($image->tmp_path));
    $_SESSION['notification'] = 'Фото успешно загружено!';
    redirect_to('/');
}