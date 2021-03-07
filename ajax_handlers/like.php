<?php

require_once __DIR__ . '/../models/Like.php';

/**
 * @param $user: id юзера, ставящего лайк
 * @param $image: id фото, на которое ставят лайк
 * Если лайк есть, он удаляется. Если лайка нет, то создается.
 */
function like($user, $image)
{
    header('Content-type: application/json');
    try {
        $like = Like::getOne(array('created_by' => $user, 'image' => $image));
        $like->delete();
        echo json_encode(array('created' => False));
        exit();
    } catch (ORMException $e) {
        $like = new Like(array(
            'created_by' => $user,
            'image' => $image,
        ));
        $like->save();
        echo json_encode(array('created' => True));
    }
}