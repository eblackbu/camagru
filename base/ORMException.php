<?php


namespace base;


use Exception;

class ORMException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return static::class . ": [{$this->code}]: {$this->message}\n";
    }
}