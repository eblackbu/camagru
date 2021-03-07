<?php

require_once __DIR__ . '/../models/Comment.php';

function add_comment($user_id, $text, $image_id)
{
    header('Content-type: application/json');

    if (!($text && $user_id && $image_id))
    {
        http_response_code('400');
        echo json_encode(array('success' => False));
        exit();
    }
    $comment = new Comment(array(
        'text' => $text,
        'image' => $image_id,
        'created_by' => $user_id
    ));
    $comment->save();
    # TODO send_mail
    http_response_code('201');
    echo json_encode(array('success' => True));
}