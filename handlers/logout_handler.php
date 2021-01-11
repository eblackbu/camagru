<?php
session_start();

function logout()
{
    $_SESSION['user'] = null;
    redirect_to('/');
}
