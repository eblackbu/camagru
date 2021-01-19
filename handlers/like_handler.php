<?php

require_once __DIR__ . '/../models/Like.php';

function like($user, $image): bool
{
    $like = new Like(array(
        'created_by' => $user,
        'image' => $image,
    ));
    $like->save();
    return True;
}