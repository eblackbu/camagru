<?php

namespace router;

class SimpleRouter
{
    private static ?SimpleRouter $_instance = null;
    private array $_routes = [];
    private array $_middlewares = [];

    private function __construct() {
    }

    private static function __replace_url_param($url_param): string
    {
        $url_param = preg_replace('{', '(?<', $url_param);
        $url_param = preg_replace('}', '>\w+)', $url_param);
        return $url_param;
    }

    /**
     * @param string $url -> url string
     * @param callable $view -> view class with implemented "__call" method
     */
    public function addRoute(string $url, callable $view): void
    {
        $url_regex = '^' . preg_replace_callback('{{[a-zA-Z]+}]}', 'self::__replace_url_param', $url) . '$';
        $this->_routes[$url_regex] = $view;
    }

    /**
     * @param callable $middleware -> middleware class with implemented "__call" method
     */
    public function setMiddleware(callable $middleware): void
    {
        self::$_instance->_middlewares[] += $middleware;
    }

    /**
     * this method should be in index.php
     * @param string $url -> url from request
     */
    public function callController(string $url): void
    {
        foreach($this->_routes as $url_regex => $view)
        {
            if (preg_match($url_regex, $url))
            {
                foreach($this->_middlewares as $middleware)
                    call_user_func($middleware);
                call_user_func($view);
                exit();
            }
        }
    }

    /**
     * use this method to create Router
     */
    public static function getInstance(): SimpleRouter
    {
        if (self::$_instance === null) {
            return new SimpleRouter();
        }
        return self::$_instance;
    }

    private function __clone() {
    }

    private function __wakeup() {
    }
}