<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Discount;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use PDO;

class CartController extends Controller
{
    public function __construct()
    {
        // View::share('numerberOfcart', Session('cart') ? Session('cart')->getTotalQuantity() : 0);
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function index(Request $request)
    {
        $cart = Session('cart') ? Session('cart') : null;
        return view('orders.cart', ['typenav' => $this->typenav, 'cart' => $cart]);
    }
    public function AddToCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'color' => 'required',
            'quantity' => 'required| numeric|min:0',
            'size' => 'required',
        ]);
        Artisan::call('cache:clear');
        if ($request->input('id') && $request->input('color') && $request->input('size')) {
            if ($request->input('quantity') >= 0) {
                $product = Products::join('product_detail', 'products.id', 'product_detail.id_product')
                    ->join('product_size', 'product_detail.id', 'product_size.id_productdetail')
                    ->join('color', 'color.id', 'product_detail.id_color')
                    ->where('products.id', $request->input('id'))
                    ->join('size', 'size.id', 'product_size.size')
                    ->leftjoin('discount', 'discount.relation_id', 'products.id')
                    ->join('imgs', 'imgs.product_id', 'products.id')->where('imgs.type', 1)
                    ->where('product_detail.id_color', $request->input('color'))->where('product_size.size', $request->input('size'))
                    ->select(
                        'products.name',
                        'products.id',
                        DB::raw(
                            "if(discount.begin <= '" . Carbon::now()->format('Y-m-d') . "' && discount.end >= '" . Carbon::now()->format('Y-m-d') . "',products.price_discount,products.priceSell) as price"
                        ),
                        DB::raw(
                            'imgs.path as img'
                        ),
                        DB::raw('products.code'),
                        DB::raw('product_detail.id_color'),
                        DB::raw('color.name as namecolor'),
                        DB::raw('product_size.quantity'),
                        DB::raw('product_size.size as idsize'),
                        DB::raw('product_detail.id as idProductDetail'),
                        DB::raw('size.name as namesize'),
                    )->first()->toArray();
                if ($product != null) {
                    $oldcart = Session('cart') ? Session('cart') : null;
                    $newcart = new Cart($oldcart);
                    $quantityInStock = $newcart->AddCart($product, $product['idProductDetail'], $request->input('quantity'),);
                    $request->session()->put('cart', $newcart);
                }
            }
            return [$request->session()->get('cart')->getTotalQuantity(), $quantityInStock];
        }
    }
    public function removeProductInCart(Request $request)
    {
        $request->validate([
            'idProduct' => 'required',
            'size' => 'required',
        ]);
        Artisan::call('cache:clear');
        $oldcart = Session('cart') ? Session('cart') : null;
        $newcart = new Cart($oldcart);
        $newcart->removeProductInCart($request->input('idProduct'), $request->input('size'));
        if ($newcart->getTotalQuantity() <= 0) {
            $request->session()->forget('cart');
            return [];
        } else
            $request->session()->put('cart', $newcart);
        return [$request->session()->get('cart')];
    }
    public function changeCart(Request $request)
    {
        $request->validate([
            'idProduct' => 'required',
            'quantity' => 'required| numeric',
            'size' => 'required',
        ]);
        Artisan::call('cache:clear');
        $product = ProductDetail::where('id', $request->input('idProduct'))->first();
        if ($product != null) {
            $oldcart = Session('cart') ? Session('cart') : null;
            if ($oldcart != null) {
                $newcart = new Cart($oldcart);
                $newcart->changeQuantityProduct($request->input('idProduct'), $request->input('quantity'), $request->input('size'));
                $request->session()->put('cart', $newcart);
            }
            return [$request->session()->get('cart')];
        }
    }
    public function removeCart(Request $request)
    {
        // $oldcart = Session('cart') ? Session('cart') : null;
        // if ($oldcart != null) {
        //     $newcart = new Cart($oldcart);
        //     $newcart->removeCart();
        // }
        Artisan::call('cache:clear');
        $request->session()->forget('cart');
    }
    public function getDiscount(Request $request)
    {
        if ($request->input('code')) {
            $data = Discount::where('code', $request->input('code'))->first();
            $count = DB::table('discount_user')->where('id_customer', auth()->user()->id)->where('id_discount', $data->id)->where('use', 0)->count();
            //  dd($data);
            return $data && $count ? [$data->persent, $data->unit, $data->id] : 0;
        }
    }
    public function checkout(Request $request)
    {
        $cart = Session('cart') ? Session('cart') : null;
        $listdiscount = DB::table('discount_user')->join('discount', 'discount.id', 'discount_user.id_discount')
            ->whereDate('begin', '<=', date('Y-m-d'))->whereDate('end', '>=', date('Y-m-d'))
            ->where('use', 0)
            ->where('id_customer', auth()->user()->id)
            ->select('discount_user.id_customer', 'discount.id', 'discount.code', 'discount.name')->get()->toArray();
        //dd($listdiscount);
        return view('orders.checkout', ['typenav' => $this->typenav, 'cart' => $cart, 'listdiscount' => $listdiscount]);
    }
}
