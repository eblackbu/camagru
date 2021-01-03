<?php


class Like extends Model
{
    public ?int $id = null;
    public ?int $created_by = null;
    public ?int $image = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'created_by',
        'image',
        'created_at',
    ];
}