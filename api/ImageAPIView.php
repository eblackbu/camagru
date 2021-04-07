<?php


namespace api;

use base\AuthorizedView;
use base\ORMException;
use models\Image;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class ImageAPIView extends AuthorizedView
{
    public function get($kwargs)
    {
        session_start();
        $user = $_GET['user'];
        $page = (int)$_GET['page'];
        $limit = $_GET['limit'] ? (int)$_GET['limit'] : 5;
        if (!$user || $page < 1 || $limit < 1)
        {
            http_response_code('400');
            exit();
        }
        $offset = ($page - 1) * 5;
        try {
            $images = Image::getMany(array('created_by' => $user), '', $limit, $offset);
        } catch (ORMException $e) {
            http_response_code('400');
            exit();
        }
        echo json_encode(array_map(function ($image) {
            return serialize($image);
        }, $images));
    }

    public function post($kwargs)
    {
        session_start();
        $user_id = $_SESSION['user']['id'];
        $file = $_FILES['upload_image'];
        $label = $_POST['label'];

        if ($label === null)
            $label = '';
        if (!($file['size'] && in_array($file['type'], array('image/png', 'image/jpg'))))
        {
            http_response_code('400');
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
    }

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