<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemConfigController extends Controller
{
    public static function getAndCache(): array
    {
        return cache()->remember('configs', 24 * 60 * 60, function () {
            $arr               = [];
            $arr['type'] = Type::with('Img', 'Categories')->withCount('Product')
                ->get()->toArray();
            $arr['ship'] = Ship::get()->toArray();
            return $arr;
        });
    }
    public static function removeCache()
    {
        Cache::forget('configs');
    }
}
