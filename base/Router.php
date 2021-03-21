<?php


namespace base;

use base\Middleware;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});


class Router
{
    private array $_routes;
    private array $_middlewares;
    private string $_bad_template;

    public function __construct() {
        $this->_routes = [];
        $this->_middlewares = [];
        $this->_bad_template = '';
    }

    /**
     * @param string $url -> url string
     * @param callable $view -> view class with implemented "__invoke" method
     */
    public function addRoute(string $url, string $view): void
    {
        $url_regex = preg_replace('/\//', '\/', $url);
        $url_regex = preg_replace('/{/', '(?<', $url_regex);
        $url_regex = preg_replace('/}/', '>\w+)', $url_regex);
        $url_regex = '/^' . $url_regex . '$/';
        $this->_routes[$url_regex] = $view;
    }

    /**
     * @param string $bad_template -> template that called when 4xx error happened
     */
    public function setBadURITemplate(string $bad_template)
    {
        $this->_bad_template = $bad_template;
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
        foreach($this->_routes as $url_regex => $view)
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
                call_user_func(new $view($this->_bad_template), $kwargs);
                foreach($this->_middlewares as $middleware)
                    call_user_func($middleware, 'response');
                exit();
            }
        }
        require_once $this->_bad_template;
    }
}