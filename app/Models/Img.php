<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Img extends Model
{
    use HasFactory, SoftDeletes;
    public $timestamps = false;
    protected $fillable = [
        'product_id', 'path', 'type', 'img_index'
    ];
    protected $table = 'imgs';
    public function ImgProduct()
    {
        return $this->morphTo();
    }
}
