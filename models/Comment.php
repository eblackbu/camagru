<?php

require_once __DIR__ . '/../orm/Model.php';

class Comment extends Model
{
    public ?int $id = null;
    public ?string $text = null;
    public ?int $created_by = null;
    public ?int $image = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'text',
        'created_by',
        'image',
        'created_at'
    ];
}