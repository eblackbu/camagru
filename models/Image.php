<?php

require_once __DIR__ . '/../orm/Model.php';

class Image extends Model
{
    public ?string $id = null;
    public ?string $label = null;
    public ?string $extension = null;
    public ?int $created_by = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'label',
        'extension',
        'created_by',
        'created_at'
    ];

    public function __construct($args)
    {
        if (!($this->id))
        {
            $this->id = uniqid('i', true);
            while (count(Image::getMany(array('id' => $this->id))) != 0)
                $this->id = uniqid('i', true);

            if (!file_exists(__DIR__ . '/../images/' . $this->created_by)) {
                mkdir(__DIR__ . '/../images/' . $this->created_by, 0777, true);
            }
        }
        parent::__construct($args);
    }

    public static function getLikesCount($id): int
    {
        return count(Like::getMany(array('image' => $id)));
    }

    public static function getComments($id): array
    {
        return Comment::getMany(array('image' => $id));
    }

    public function getPath(): string
    {
        return __DIR__ . '/../images/' . $this->created_by . '/' . $this->id . '.' . $this->extension;
    }
}