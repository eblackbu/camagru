<?php


namespace api;

use base\ORMException;
use base\View;
use models\Image;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class ImageAPIView extends View
{
    public function delete($kwargs)
    {
        header('Content-type: application/json');

        try {
            $image = Image::getOne(array('id' => $kwargs['id']));
            if ($_SESSION['user']['id'] === $image->created_by or $_SESSION['user']['is_admin'])
            {
                $image->delete();
                http_response_code('204');
                echo json_encode(array('success' => True));
            }
            else
            {
                http_response_code('403');
                echo json_encode(array('success' => False));
            }
            exit();
        } catch (ORMException $e) {
            http_response_code('404');
            echo json_encode(array('success' => False));
            exit();
        }
    }
}