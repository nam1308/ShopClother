<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'orders';
    protected $fillable = [
        'id_customer',
        'id_user',
        'price',
        'quantity',
        'type',
        'payment_method',
        'note',
        'address',
        'discount',
        'name',
        'phone',
        'email',
        'country',
        'city',
        'district',
        'zip_code',
        'status',
        'ship'
    ];
    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
    ];
    public function DiscountProduct()
    {
        return $this->belongsTo(Discount::class, 'discount', 'id');
    }
    public function OrderDetail()
    {
        return $this->hasMany(OrderDetails::class, 'id_order', 'id');
    }
    public function Customers()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id');
    }
}
