<?php
session_start();

function show_notification()
{
    # TODO сделать разметку для уведомления
    if (isset($_SESSION['notification']))
    {
        ?>
        <p><?php echo $_SESSION['notification'] ?></p>
        <?php
        $_SESSION['notification'] = null;
    }
}

