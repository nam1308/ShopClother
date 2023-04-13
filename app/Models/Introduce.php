<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Introduce extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title', 'description', 'index', 'relate_id', 'type', 'link'
    ];
    protected $table = 'introduces';
    public function Img()
    {
        return $this->morphMany(Img::class, 'product', 'type');
    }
    public function Discount()
    {
        return $this->belongsTo(Discount::class, 'relate_id', 'id');
    }
}
