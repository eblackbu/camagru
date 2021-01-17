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

    public static function getLikesCount($id): int
    {
        return count(Like::getMany(array('image' => $id)));
    }

    public static function getComments($id): array
    {
        return Comment::getMany(array('image' => $id));
    }

    protected function _create(): bool
    {
        $this->id = uniqid('i', true);
        while (count(Image::getMany(array('id' => $this->id))) != 0)
            $this->id = uniqid('i', true);

        if (!file_exists(__DIR__ . '/../images/' . $this->created_by)) {
            mkdir(__DIR__ . '/../images/' . $this->created_by, 0777, true);
        }
        return parent::_create();
    }

    public function getPath(): string
    {
        return '/images/' . $this->created_by . '/' . $this->id . '.' . $this->extension;
    }
}