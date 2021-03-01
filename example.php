<?php

$input_name = 'my-file';

$path = __DIR__ . '/uploads/';
$file = $_FILES[$input_name];
$name = $file['name'];
$name = date("YmdHis") . $name;
move_uploaded_file($file['tmp_name'], $path . $name);
