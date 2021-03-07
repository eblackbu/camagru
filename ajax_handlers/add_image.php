<?php

require_once __DIR__ . '/../models/Image.php';

function add_image($user_id, $file, $label)
{
    header('Content-type: application/json');

    if ($label === null)
        $label = '';
    if (!($file['size'] && in_array($file['type'], array('image/png', 'image/jpg')))) {
        http_response_code('400');
        echo json_encode(array('success' => False));
        exit();
    }
    $img = new Image(array(
        'label' => $label,
        'created_by' => $user_id,
        'extension' => substr($file['type'], -3)
    ));
    move_uploaded_file($file['tmp_name'], $img->getFullPath());
    $img->save();
    http_response_code('201');
    echo json_encode(array('success' => True));
}