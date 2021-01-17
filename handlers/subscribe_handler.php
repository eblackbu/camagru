<?php

require_once __DIR__ . '/../models/Subscription.php';

function subscribe($user_from, $user_where): bool
{
    $subscription = new Subscription(array(
        'user_from' => $user_from,
        'user_where' => $user_where,
    ));
    $subscription->save();
    return True;
}