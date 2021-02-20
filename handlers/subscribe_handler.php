<?php

require_once __DIR__ . '/../models/Subscription.php';

function subscribe($user_from, $user_where)
{
    header('Content-type: application/json');
    if ($user_from == $user_where)
    {
        echo json_encode(array('success' => False));
        exit();
    }

    $subscription = new Subscription(array(
        'user_from' => $user_from,
        'user_where' => $user_where,
    ));
    $subscription->save();
    echo json_encode(array('success' => False));
}