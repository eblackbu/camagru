<?php
session_start();

function delete_image($image_id)
{
    header('Content-type: application/json');

    try {
        $image = Image::getOne(array('id' => $image_id));
        if ($_SESSION['user']['id'] != $image->created_by and !$_SESSION['user']['is_admin'])
        {
            http_response_code('403');
            redirect_to('/');
            echo json_encode(array('success' => False));
            exit();
        }
    } catch (ORMException $e) {
        http_response_code('400');
        echo json_encode(array('success' => False));
        exit();
    }
    $image->delete();
    http_response_code('204');
    echo json_encode(array('success' => True));
}