<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="/views/style/css/main.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;700&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="/views/scripts/main.js"></script>
</head>

<body>
    <header class="header">
        <div class="header__content container">
            <h1 class="header__content-logo"><a href="">Camagru</a></h1>
            <div class="header__notifications">
                <?php require_once('helpers/notification.php'); show_notification(); ?>
            </div>
        </div>
    </header>
    <div class="content container">