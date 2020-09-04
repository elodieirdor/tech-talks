<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Talk extends Model
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_DRAFT = 'draft';
    const STATUS = [self::STATUS_PUBLISHED, self::STATUS_DRAFT];

    protected $fillable = [
        'topic', 'description', 'date', 'status',
    ];

    protected $visible = [
        'id', 'topic', 'description', 'date', 'status',
    ];
}
