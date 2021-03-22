<?php


namespace base;


class View
{
    const _methods = array(
        'GET' => 'get',
        'POST' => 'post',
        'PUT' => 'put',
        'DELETE' => 'delete',
    );
    protected string $_bad_template;

    public function __construct(string $_bad_template)
    {
        $this->_bad_template = $_bad_template;
    }

    public function __invoke(array $kwargs)
    {
        session_start();
        if (array_key_exists($_SERVER['REQUEST_METHOD'], self::_methods))
            call_user_func(array($this, self::_methods[$_SERVER['REQUEST_METHOD']]), $kwargs);
        else
            require_once $this->_bad_template;
    }

    public function get(array $kwargs)
    {
        require_once $this->_bad_template;
    }

    public function post(array $kwargs)
    {
        require_once $this->_bad_template;
    }

    public function put(array $kwargs)
    {
        require_once $this->_bad_template;
    }

    public function delete(array $kwargs)
    {
        require_once $this->_bad_template;
    }
}