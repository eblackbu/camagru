<?php


namespace base;


abstract class Middleware
{
    /**
     * method that called before calling the View
     */
    abstract public function processRequest(): void;

    /**
     * method that called after calling the View
     */
    abstract public function processResponse(): void;
}