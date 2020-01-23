<?php

namespace App\Models;

use Igoframework\Core\Base\Model;

class Comments extends Model
{
    protected $table = 'comments';
    
    public $attributes = [
        'text' => '',
        'date' => '',
        'user_id' => '',
    ];

    public $rules = [
        'required' => [
            ['text']
        ],
        'lengthMax' => [
            ['text', 10000]
        ],
    ];
}