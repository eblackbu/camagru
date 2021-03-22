<?php


namespace views;


use models\Image;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class ImageView
{
    public function get(array $kwargs)
    {
        require_once 'templates/new_image.php';
    }

    public function post(array $kwargs)
    {
        session_start();
        $user_id = $_SESSION['user']['id'];
        $file = $_FILES['upload_image'];
        $label = $_POST['label'];

        if ($label === null)
            $label = '';
        if (!($file['size'] && in_array($file['type'], array('image/png', 'image/jpg')))) {
            http_response_code('400');
            $_SESSION['notification'] = 'Что то пошло не так при загрузке фото';
            redirect_to('/new_image');
        }
        $img = new Image(array(
            'label' => $label,
            'created_by' => $user_id,
            'extension' => substr($file['type'], -3)
        ));
    }
}