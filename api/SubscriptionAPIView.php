<?php


namespace api;

use base\AuthorizedView;
use base\ORMException;
use models\Subscription;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class SubscriptionAPIView extends AuthorizedView
{
    public function get($kwargs)
    {
        header('Content-type: application/json');

        try {
            $subscriptions = Subscription::getMany($_GET);
        } catch (ORMException $e) {
            http_response_code('404');
            echo json_encode(array('success' => False));
            exit();
        }
        echo json_encode(array_map(function ($subscription) {
            return serialize($subscription);
        }, $subscriptions));
    }

    public function post($kwargs)
    {
        $user_from = $_SESSION['user']['id'];
        $user_where = $_POST['user_where'];
        header('Content-type: application/json');

        if ($user_from == $user_where)
        {
            echo json_encode(array('success' => False));
            exit();
        }

        try {
            $subscription = Subscription::getOne(array('user_from' => $user_from, 'user_where' => $user_where));
            http_response_code('400');
            echo json_encode(array('success' => False));
            exit();
        } catch (ORMException $e) {
            $subscription = new Subscription(array(
                'user_from' => $user_from,
                'user_where' => $user_where,
            ));
            $subscription->save();
            echo json_encode(array('success' => True));
        }
    }

    public function delete($kwargs)
    {
        header('Content-type: application/json');

        try {
            $subscription = Subscription::getOne(array('id' => $kwargs['id']));
            if ($subscription->user_from === $_SESSION['user']['id'])
            {
                http_response_code('204');
                $subscription->delete();
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
            echo json_encode(array('success' => False,));
        }
    }
}