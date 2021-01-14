<?php

require_once('models/Like.php');

function like($user, $image): bool
{
    $like = new Like(array(
        'created_by' => $user,
        'image' => $image,
    ));
    $like->save();
    return True;
}