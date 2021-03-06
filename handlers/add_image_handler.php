<?php

session_start();

require_once __DIR__ . '/../models/Image.php';

function add_image($user, $file, $label)
{
    header('Content-type: application/json');

    if ($label === null)
        $label = '';
    if (!($file['size'] && in_array($file['type'], array('image/png', 'image/jpg')))) {
        echo json_encode(array('success' => False));
        exit();
    }
    $img = new Image(array(
        'label' => $label,
        'created_by' => $user,
        'extension' => substr($file['type'], -3)
    ));
    move_uploaded_file($file['tmp_name'], $img->getPath());
    $img->save();
    echo json_encode(array('success' => True));
}