<?php


namespace base;


class AuthorizedView extends View
{
    public function check_rights(): bool
    {
        session_start();
        return isset($_SESSION['user']);
    }
}