<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'products';
    protected $fillable = [
        'name',
        'description',
        'quantity',
        'category',
        'priceImport',
        'priceSell',
        'type',
        'supplier',
        'brand',
        'code',
        'status',
        'featured',
        'price_discount'
    ];
    protected $cast = [
        'created_at' => 'date:Y-m-d',
        'updated-at' => 'date:Y-m-d',
    ];
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
    public function BrandProduct()
    {
        return $this->belongsTo(Brand::class, 'brand', 'id');
    }
    public function TypeProduct()
    {
        return $this->belongsTo(Type::class, 'type', 'id');
    }
    public function CategoryProduct()
    {
        return $this->belongsTo(Categories::class, 'category', 'id');
    }
    public function ColorProduct()
    {
        return $this->belongsTo(Color::class, 'category', 'id');
    }
    public function SizeProduct()
    {
        return $this->hasManyThrough(ProductSize::class, ProductDetail::class, 'id_product', 'id_productdetail', 'id', 'id');
    }
    public function ProductDetail()
    {
        return $this->hasMany(ProductDetail::class, 'id_product', 'id');
    }
}
