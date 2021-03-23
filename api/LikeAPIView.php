<?php


namespace api;

use base\AuthorizedView;
use base\ORMException;
use models\Like;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class LikeAPIView extends AuthorizedView
{
    public function get($kwargs)
    {
        header('Content-type: application/json');

        try {
            $likes = Like::getMany($_GET);
        }
        catch (ORMException $e) {
            http_response_code('400');
            echo json_encode(array('success' => False));
            exit();
        }
        echo json_encode(array_map(function ($like) {
            return serialize($like);
        }, $likes));
    }

    public function post($kwargs)
    {
        $created_by = $_SESSION['user']['id'];
        $image = $_POST['image'];
        header('Content-type: application/json');

        try {
            $like = Like::getOne(array('created_by' => $created_by, 'image' => $image));
            http_response_code('400');
            echo json_encode(array('success' => False));
            exit();
        } catch (ORMException $e) {
            $like = new Like(array(
                'created_by' => $created_by,
                'image' => $image,
            ));
            $like->save();
            echo json_encode(array('success' => True));
        }
    }

    public function delete($kwargs)
    {
        header('Content-type: application/json');

        try {
            $like = Like::getOne(array('id' => $kwargs['id']));
            if ($like->created_by === $_SESSION['user']['id'])
            {
                $like->delete();
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
        }
    }
}