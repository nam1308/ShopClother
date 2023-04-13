<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetails extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'order_details';
    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'price',
        'color',
        'size',
        'totalPrice'
    ];
    protected $cast = [
        'created_at' => 'date:Y-m-d',
        'updated-at' => 'date:Y-m-d',
    ];
}
