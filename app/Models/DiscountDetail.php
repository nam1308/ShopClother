<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'id_discount',
        'condition',
    ];
    protected $table = 'discount_detail';
}
