<?php

require_once(__DIR__ . '/../orm/DB.php');

$setup_script = file_get_contents(__DIR__ . '/setup.sql');
DB::getInstance()->exec($setup_script);
