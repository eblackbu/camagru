<?php

require_once __DIR__ . '../models/Comment.php';

function delete_comment($comment_id)
{
    header('Content-type: application/json');

    try {
        $comment = Comment::getOne(array('id' => $comment_id));
        if ($_SESSION['user']['id'] != $comment->created_by and !$_SESSION['user']['is_admin'])
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
    $comment->delete();
    http_response_code('204');
    echo json_encode(array('success' => True));
}