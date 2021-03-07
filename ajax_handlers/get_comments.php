<?php

function get_comments($image_id)
{
    header('Content-type: application/json');

    try {
        Image::getComments($image_id);
    }
    catch (ORMException $e) {
        http_response_code('400');
        echo json_encode(array('success' => False));
        exit();
    }
    http_response_code('201');
    echo json_encode(array('success' => True));
}