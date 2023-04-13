<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'type';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    public function Categories()
    {
        return $this->hasMany(Categories::class, 'type', 'id');
    }
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
    public function Product()
    {
        return $this->hasMany(Products::class, 'type', 'id');
    }
}
