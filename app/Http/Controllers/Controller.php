<?php

namespace App\Http\Controllers;

use App\Models\favorite;
use App\Models\Type;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
   use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
   protected $typenav;
   protected $configs;
   protected $cartall;
   public function __construct()
   {
      //  DB::enableQueryLog();
      $cart = 0;
      $this->middleware(function ($request, $next) {
         View::share('numerberOfcart', Session('cart') ? Session('cart')->getTotalQuantity() : 0);
         View::share('Favorite', auth()->check() ? favorite::where('id_customer', auth()->user()->id)->get()->count() : 0);
         return $next($request);
      });
      $this->configs = SystemConfigController::getAndCache();
      $this->typenav = $this->configs['type']; //Type::with('Img', 'Categories')->withCount('Product')->get()->toArray();
      //dd('ngoai', $cart);

   }
}
