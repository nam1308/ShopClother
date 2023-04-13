<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'rate';
    public $incrementing = false;
    protected $fillable = [
        'id_product',
        'id_customer',
        'number_stars',
        'review',
        'email',
    ];
    protected $primaryKey = ['id_product', 'id_customer'];
}
