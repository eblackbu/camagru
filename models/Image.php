<?php


namespace models;


use base\Model;

spl_autoload_register(function($className) {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $className). '.php';
});

class Image extends Model
{
    public ?string $id = null;
    public ?string $label = null;
    public ?string $filename = null;
    public ?string $extension = null;
    public ?int $created_by = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'label',
        'filename',
        'extension',
        'created_by',
        'created_at'
    ];

    public function __construct($args)
    {
        parent::__construct($args);
        if (!($this->filename))
        {
            $this->filename = uniqid('i', true);
            while (count(Image::getMany(array('filename' => $this->filename))) != 0)
                $this->filename = uniqid('i', true);

            if (!file_exists(__DIR__ . '/../images/' . $this->created_by)) {
                mkdir(__DIR__ . '/../images/' . $this->created_by, 0777, true);
            }
        }
    }

    public function delete(): bool
    {
        if (file_exists($this->getFullPath())) {
            unlink($this->getFullPath());
        }
        return parent::delete();
    }

    public static function getLikesCount($id): int
    {
        return count(Like::getMany(array('image' => $id)));
    }

    public static function getComments($id): array
    {
        return Comment::getMany(array('image' => $id));
    }

    public function getFullPath(): string
    {
        return __DIR__ . '/../images/' . $this->created_by . '/' . $this->filename . '.' . $this->extension;
    }

    public function getPath(): string
    {
        return '/images/' . $this->created_by . '/' . $this->filename . '.' . $this->extension;
    }

    public function getId(): string
    {
        return $this->id;
    }
}