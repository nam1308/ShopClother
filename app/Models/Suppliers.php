<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Suppliers extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'address',
        'city',
        'district',
        'email',
        'phone',
        'country'
    ];
    protected $table = 'suppliers';
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
}
