<?php

require_once __DIR__ . '/../models/Like.php';

function like($user, $image)
{
    header('Content-type: application/json');
    try {
        $like = Like::getOne(array('created_by' => $user, 'image' => $image));
        $like->delete();
    } catch (ORMException $e) {
        $like = new Like(array(
            'created_by' => $user,
            'image' => $image,
        ));
        $like->save();
    }

    echo json_encode(array('success' => False));
}