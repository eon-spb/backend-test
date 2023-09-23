<?php

namespace EON\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartments extends Model
{
    use HasFactory;

    protected $table = 'apartments';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'uaid',
        's_total',
        's_living',
        's_kitchen',
        'height',
        'price',
        'floor',
    ];
}
