<?php


class Image extends Model
{
    public ?int $id = null;
    public ?string $filepath = null;
    public ?int $created_by = null;
    public ?string $created_at = null;

    public array $_fields = [
        'id',
        'filepath',
        'created_by',
        'created_at'
    ];
}