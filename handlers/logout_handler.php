<?php
session_start();

require_once 'helpers/redirect.php';

function logout()
{
    $_SESSION['user'] = null;
    redirect_to('/');
}
