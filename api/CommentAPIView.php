<?php


namespace api;

use base\ORMException;
use base\View;
use models\Comment;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class CommentAPIView extends View
{
    public function get($kwargs)
    {
        header('Content-type: application/json');

        try {
            $comments = Comment::getMany($_GET);
        }
        catch (ORMException $e) {
            http_response_code('400');
            echo json_encode(array('success' => False));
            exit();
        }
        http_response_code('200');
        echo json_encode(array_map(function ($comment) {
            return $comment->to_json();
        }, $comments));
    }

    public function post($kwargs)
    {
        $created_by = $_SESSION['user']['id'];
        $text = $_POST['text'];
        $image = $_POST['image'];
        header('Content-type: application/json');

        $comment = new Comment(array(
            'created_by' => $created_by,
            'text' => $text,
            'image' => $image,
        ));
        $comment->save();
        echo json_encode(array('success' => True));
    }

    public function delete($kwargs)
    {
        header('Content-type: application/json');

        try {
            $comment = Comment::getOne(array('id' => $kwargs['id']));
            if ($comment->created_by === $_SESSION['user']['id'])
            {
                $comment->delete();
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