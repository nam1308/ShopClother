<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'categories';
    public $timestamps = false;
    protected $fillable = ['type', 'name'];
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
}
