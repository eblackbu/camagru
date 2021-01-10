<?php

require_once 'orm/Model.php';

class Subscription extends Model
{
    public ?int $id = null;
    public ?int $user_where = null;
    public ?int $user_from = null;

    public array $_fields = [
        'id',
        'user_where',
        'user_from'
    ];
}