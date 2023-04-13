<?php

namespace App\Models;

use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProductDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'product_detail';
    protected $fillable = [
        'id_color',
        'quantity',
        'product_id',
        'price_import',
        'price_sell',
    ];
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
    public function sizeProduct()
    {
        return $this->hasManyThrough(Size::class, ProductSize::class, 'id_productdetail', 'id', 'id', 'size');
    }
    public function colorProduct()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id');
    }
    public function ProductSizeDetail()
    {
        return $this->hasMany(ProductSize::class, 'id_productdetail', 'id'); //->select('id_productdetail', 'quantity');
    }
}
