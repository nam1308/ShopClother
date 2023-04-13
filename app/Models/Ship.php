<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ship extends Model
{
    use HasFactory;
    protected $table = 'ship';
    public $timestamps = false;
    protected $fillable = [
        'location',
        'price',
    ];
}
