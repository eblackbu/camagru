<?php

require_once __DIR__ . '/../models/Subscription.php';

/**
 * @param $user_from: кто подписывается
 * @param $user_where: на кого подписываются
 * Если подписка есть, она удаляется. Если подписки нет, то создается.
 */
function subscribe($user_from, $user_where)
{
    header('Content-type: application/json');
    if ($user_from == $user_where)
    {
        echo json_encode(array('success' => False));
        exit();
    }

    try {
        $subscription = Subscription::getOne(array('user_from' => $user_from, 'user_where' => $user_where));
        $subscription->delete();
        echo json_encode(array('success' => True, 'created' => False));
        exit();
    } catch (ORMException $e) {
        $subscription = new Subscription(array(
            'user_from' => $user_from,
            'user_where' => $user_where,
        ));
        $subscription->save();
        echo json_encode(array('success' => True, 'created' => True));
    }
}