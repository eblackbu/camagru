<?php


namespace base;


use Exception;

class View
{
    const _methods = array(
        'GET' => 'get',
        'POST' => 'post',
        'PUT' => 'put',
        'DELETE' => 'delete',
    );

    /**
     * Function that checks if user has rights for this view (and method, maybe!)
     * @return bool
     */
    public function check_rights(): bool
    {
        return True;
    }

    public function __invoke(array $kwargs)
    {
        session_start();
        if (array_key_exists($_SERVER['REQUEST_METHOD'], self::_methods))
            call_user_func(array($this, self::_methods[$_SERVER['REQUEST_METHOD']]), $kwargs);
        else
            http_response_code(405);
        exit();
    }

    public function get(array $kwargs)
    {
        http_response_code(405);
        exit();
    }

    public function post(array $kwargs)
    {
        http_response_code(405);
        exit();
    }

    public function put(array $kwargs)
    {
        http_response_code(405);
        exit();
    }

    public function delete(array $kwargs)
    {
        http_response_code(405);
        exit();
    }
}