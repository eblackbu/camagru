<?php


namespace base;

use base\Middleware;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});


class Router
{
    public static ?Router $_instance = null;
    private array $_routes;
    private array $_auth_routes;
    private array $_middlewares;
    private string $_403_template;
    private string $_404_template;

    private function __construct() {
        $this->_routes = [];
        $this->_auth_routes = [];
        $this->_middlewares = [];
        $this->_403_template = '';
        $this->_404_template = '';
    }

    public static function getInstance(): Router
    {
        if (!self::$_instance)
            return new Router();
        return self::$_instance;
    }

    public function getRoutes(): array
    {
        return $this->_routes;
    }

    /**
     * @param string $url -> url string
     * @param string $view -> view class name with implemented "__invoke" method
     */
    public function addRoute(string $url, string $view, bool $auth=false): void
    {
        $url_regex = preg_replace('/\//', '\/', $url);
        $url_regex = preg_replace('/{/', '(?<', $url_regex);
        $url_regex = preg_replace('/}/', '>\w+)', $url_regex);
        $url_regex = '/^' . $url_regex . '$/';
        if ($auth)
            $this->_auth_routes[$url_regex] = $view;
        else
            $this->_routes[$url_regex] = $view;
    }

    /**
     * @param string $_403_template -> template that called when requested resource is forbidden
     */
    public function setNotAuthorizedTemplate(string $_403_template)
    {
        $this->_403_template = $_403_template;
    }

    /**
     * @param string $_404_template -> template that called when resource not found
     */
    public function setNotFoundTemplate(string $_404_template)
    {
        $this->_404_template = $_404_template;
    }

    /**
     * @param Middleware $middleware -> middleware object with implemented "process_request" and "process_response" methods
     */
    public function setMiddleware(Middleware $middleware): void
    {
        $this->_middlewares[] = $middleware;
    }

    /**
     * this method should be in index.php
     * @param string $url -> url from request
     */
    public function callView(string $url): void
    {
        session_start();
        $tmp_routes = $_SESSION['user'] ? $this->_auth_routes : $this->_routes;
        foreach($tmp_routes as $url_regex => $view)
        {
            $url_info = parse_url($url);
            if (preg_match_all($url_regex, $url_info["path"], $matches))
            {
                foreach($this->_middlewares as $middleware)
                    call_user_func($middleware, 'request');
                $kwargs = [];
                foreach($matches as $key => $value)
                    if (!is_int($key))
                        $kwargs[$key] = $value[0];
                $_view_to_call = new $view();
                if ($_view_to_call->check_rights())
                    call_user_func(new $view(), $kwargs);
                else
                    require_once $this->_403_template;
                foreach($this->_middlewares as $middleware)
                    call_user_func($middleware, 'response');
                exit();
            }
        }
        require_once $this->_404_template;
    }
}