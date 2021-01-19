<?php
session_start();

require_once __DIR__ . '/../helpers/redirect.php';

function logout()
{
    $_SESSION['user'] = null;
    redirect_to('/');
}
