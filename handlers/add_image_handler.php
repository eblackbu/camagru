<?php

session_start();

require_once __DIR__ . '/../models/Image.php';

function add_image($user, $image, $label)
{
    header('Content-type: application/json');

//    if (strpos($image, 'data:image/png;base64') === 0) {
//
//        $image = str_replace('data:image/png;base64,', '', $image);
//        $image = str_replace(' ', '+', $image);
//        $data = base64_decode($image);
//        $file = 'uploads/img' . date("YmdHis") . '.png';
//
//        if (file_put_contents($file, $data)) {
//            echo "The canvas was saved as $file.";
//        } else {
//            echo 'The canvas could not be saved.';
//        }
//    }
//    $obj = new Image(array(
//        'label' => $label,
//        'created_by' => $user,
//        'extension' => pathinfo($image->tmppath, PATHINFO_EXTENSION))
//    );
//    $obj->save();
//    file_put_contents($obj->getPath(), file_get_contents($image->tmp_path));
    // TODO $_FILES

    echo json_encode(array('success' => True));
}