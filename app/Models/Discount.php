<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'type',
        'persent',
        'begin',
        'end',
        'code',
    ];
    protected $table = 'discount';
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
    public function DiscountDetail()
    {
        return $this->hasOne(DiscountDetail::class, 'id_discount', 'id');
    }
    public function DiscountUser()
    {
        return $this->hasMany(DiscountUser::class, 'id_discount', 'id');
    }
}
