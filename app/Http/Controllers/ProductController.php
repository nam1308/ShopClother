<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Models\Categories;
use App\Models\Color;
use App\Models\favorite;
use Illuminate\Support\Facades\View;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\ProductSize;
use App\Models\Rate;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function __construct()
    {
        // View::share('numerberOfcart', Session('cart') ? Session('cart')->getTotalQuantity() : 0);
        parent::__construct();
    }
    public function index()
    {
        Artisan::call('cache:clear');
        if (Cache::has('products-index')) {
            return Cache::get('products-index');
        } else {
            $typenav = Type::with('Img', 'Categories')->withCount('Product')->get()->toArray();
            // dd(Type::get()->toArray());
            $product = Products::join('product_detail', 'products.id', '=', 'product_detail.id_product')
                ->select('products.id', 'products.name', 'products.category', 'products.type');
            $type = Type::leftjoinSub($product, 'product', function ($join) {
                $join->on('type.id', '=', 'product.type');
            })
                ->groupBy('type.id', 'type.name')
                ->select('type.id', 'type.name', DB::raw('count(product.id) as soluong'))
                ->get()->toArray();
            $categories = Categories::leftjoinSub($product, 'product', function ($join) {
                $join->on('categories.id', '=', 'product.category');
            })->join('type', 'type.id', '=', 'categories.type')
                ->groupBy('categories.id', 'categories.name', 'type.id', 'type.name')
                ->select('categories.id', 'categories.name', DB::raw('type.id as typeid'), DB::raw('type.name as typename'), DB::raw('count(product.id) as soluong'))
                ->get()->toArray();
            // return view(
            //     'products.index',
            //     [
            //         'list' => Products::with('Img', 'BrandProduct')->get()->toArray(),
            //         'categories' => $categories,
            //         'type' => $type,
            //         'typenav' => $typenav
            //     ]
            // );
            // dd(Products::with('Img', 'BrandProduct')->leftjoin('discount', 'discount.relation_id', 'products.id')->select(
            //     DB::raw(
            //         "if(discount.begin <= '" . Carbon::now()->format('Y-m-d') . "' && discount.end >= '" . Carbon::now()->format('Y-m-d') . "',1,0) as isdiscount"
            //     ),
            //     DB::raw(
            //         'products.*'
            //     )
            // )->get()->toArray());
            $cachedData = view(
                'products.index',
                [
                    'list' => Products::with('Img', 'BrandProduct')->leftjoin('discount', 'discount.relation_id', 'products.id')->select(
                        DB::raw(
                            "if(discount.begin <= '" . Carbon::now()->format('Y-m-d') . "' && discount.end >= '" . Carbon::now()->format('Y-m-d') . "',1,0) as isdiscount"
                        ),
                        DB::raw(
                            'products.*'
                        )
                    )->get()->toArray(),
                    'categories' => $categories,
                    'type' => $type,
                    'typenav' => $typenav
                ]
            )->render();
            Cache::put('products-index', $cachedData);
            return $cachedData;
        }
    }
    public function getProductBy(Request $request)
    {

        $check = 0;
        if (auth()->check()) {
            $check = 1;
        }
        $rate = Rate::groupBy('id_product')->select('id_product', DB::raw('(sum(rate.number_stars)/count(rate.id_product)) as stars'));
        $product = Products::with('Img', 'BrandProduct')
            ->join('categories', 'categories.id', 'products.category')
            ->leftjoin('discount', 'discount.relation_id', 'products.id')
            ->leftjoinSub($rate, 'rate', function ($join) {
                $join->on('products.id', '=', 'rate.id_product');
            });

        if ($request->input('type')) {
            $types = explode('-', $request->input('type'));
            $product->whereIn('categories.type', $types);
        }
        if ($request->input('category')) {
            $categories = explode('-', $request->input('category'));
            $product->whereIn('products.category', $categories);
        }
        if ($request->input('price')) {
            $prices = preg_replace("/[Đ\.><]/", "", $request->input('price'));
            // $prices = str_replace(".", "", $prices);
            // $prices = str_replace(".", "", $prices);
            $prices = explode('_', $prices);
            $product->where(function ($query) use ($prices) {
                foreach ($prices as $item) {
                    $itemprices = explode(' ', trim($item));
                    $from = $itemprices[0];
                    $to = $itemprices[count($itemprices) - 1];
                    $query->orwhereBetween('priceSell', [$from, $to]);
                }
            });
        }
        if ($request->input('search')) {
            $product->where('products.name', 'like', '%' . $request->get('search') . '%');
        }
        $product = $product->select(DB::raw('products.*,IFNULL(rate.stars,0) as star'), DB::raw(
            "if(discount.begin <= '" . Carbon::now()->format('Y-m-d') . "' && discount.end >= '" . Carbon::now()->format('Y-m-d') . "',1,0) as isdiscount"
        ), DB::raw(
            "discount.unit,discount.persent"
        ),);
        if ($request->input('sort')) {
            if ($request->input('sort') == 'rate') {
                $product->orderBy('rate.stars', 'DESC');
            } else if ($request->input('sort') == 'created_at') {
                $product->orderBy('products.created_at', 'DESC');
            }
        }
        //  dd($product->get()->toArray());

        return [$product->get()->toArray(), $check];
    }
    public function getProduct(Request $request)
    {
        $data = $data = Products::with(['TypeProduct', 'BrandProduct', 'CategoryProduct', 'SizeProduct' => function ($q) {
            return $q->join('size', 'size.id', 'product_size.size')->select('size.id', 'size.name');
        }])->where('id', $request->input('id'))->first();
        return $data;
    }
    public function getProductDetail(Request $request)
    {
        $type = Type::with('Img', 'Categories')->withCount('Product')->get()->toArray();
        $data = ProductDetail::with(['colorProduct', 'Img' => fn ($query) => $query->where('type', 2)->where('img_index', 1)])->where('id_product', $request->input('id'))->get()->toArray();
        $product = Products::with('Img')->where('products.id', $request->input('id'))
            ->leftjoin('discount', 'discount.relation_id', 'products.id')
            ->select(DB::raw('products.*'), DB::raw(
                "if(discount.begin <= '" . Carbon::now()->format('Y-m-d') . "' && discount.end >= '" . Carbon::now()->format('Y-m-d') . "',1,0) as isdiscount"
            ), DB::raw(
                "discount.unit,discount.persent"
            ),)
            ->first()->toArray();
        $dataSuggest = Products::with('Img')->where('type', $product['type'])
            // ->where('category', $product['category'])
            ->where('id', '!=', $product['id'])->get()->toArray();
        return view('products.detail', [
            'data' => $data,
            'product' => $product,
            'productSuggest' => $dataSuggest,
            'typenav' => $type
        ]);
    }
    public function listNameProduct(Request $request)
    {
        $data = Products::pluck('name')->toArray();
        return $data;
    }
    public function getSizeAndImg(Request $request)
    {
        if ($request->input('id') && $request->input('color')) {
            $listsize = ProductDetail::where('product_detail.id_product', $request->input('id'))->where('product_detail.id_color', $request->input('color'))
                ->join('product_size', 'product_detail.id', 'product_size.id_productdetail')
                ->join('size', 'size.id', 'product_size.size')->select(DB::raw('product_detail.id as idProduct'), 'size.name', 'size.id', 'product_size.quantity')->get()->toArray();
            //  DB::enableQueryLog();
            $listImg = ProductDetail::join('imgs', 'imgs.product_id', 'product_detail.id')->where('imgs.type', 2)->where('imgs.deleted_at', null)
                ->where('product_detail.id_product', $request->input('id'))->where('product_detail.id_color', $request->input('color'))->get('imgs.path')->toArray();
            //dd($listImg);
            // dd(DB::getQueryLog());
            return [$listsize, $listImg, Session::get('cart') ? Session::get('cart') : []];
        }
    }
    public function addFaverite(Request $request)
    {
        if ($request->input('id') && auth()->check()) {
            $faverite = DB::table('favorite')->where('id_product', $request->input('id'))->where('id_customer', auth()->user()->id)->first();
            if ($faverite) {
                return DB::table('favorite')->where('id_customer', auth()->user()->id)->select(DB::raw('count(id_product) as quantity'))->get()->toArray();
            } else {
                DB::table('favorite')->insert([
                    'id_customer' => auth()->user()->id,
                    'id_product' => $request->input('id')
                ]);
                return DB::table('favorite')->where('id_customer', auth()->user()->id)->select(DB::raw('count(id_product) as quantity'))->get()->toArray();
            }
        }
        return response()->json(['error' => 'Thêm thất bại'], 400);
    }
    public function removeFaverite(Request $request)
    {
        Artisan::call('cache:clear');
        if ($request->input('id') && auth()->check()) {
            DB::table('favorite')->where('id_product', $request->input('id'))->where('id_customer', auth()->user()->id)->delete();
            return response()->json(['success' => 'Thành công'], 200);
        }
        return response()->json(['error' => 'Thêm thất bại'], 400);
    }
    public function rateProduct(RateRequest $request)
    {
        Artisan::call('cache:clear');
        $dataupdate = [
            'number_stars' => $request->input('rate'),
            'review' => $request->input('review'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if ($request->input('review')) {
            $dataupdate = [
                'number_stars' => $request->input('rate'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }
        DB::table('rate')->updateOrInsert(
            [
                'id_product' => $request->input('id'),
                'id_customer' => 1
            ],
            $dataupdate
        );
    }
    public function getListProduct(Request $request)
    {
        $data = Products::query();
        if ($request->input('code')) {
            $data->where('code', $request->input('code'));
        } else {
            if ($request->input('type')) {
                $data->where('type', $request->input('type'));
            }
            if ($request->input('catetory')) {
                $data->where('catetory', $request->input('catetory'));
            }
            if ($request->input('brand')) {
                $data->where('brand', $request->input('brand'));
            }
            if ($request->input('gender')) {
                $data->where('gender', $request->input('gender'));
            }
            if ($request->input('q')) {
                $data = Products::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
            }
        }
        $data = $data->get()->toArray();
        return $data;
    }
    public function getListCode(Request $request)
    {
        $data = [];
        if ($request->input('q')) {
            $data = Products::where('code', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Products::get()->toArray();
        }
        return $data;
    }
    public function quantityProduct(Request $request)
    {
        $quantity = 0;
        if ($request->input('color') && $request->input('size') && $request->input('id')) {
            $quantity = Products::where('products.id', $request->input('id'))
                ->join('product_detail', 'product_detail.id_product', 'products.id')
                ->where('id_color', $request->input('color'))
                ->join('product_size', 'product_size.id_productdetail', 'product_detail.id')
                ->where('product_size.size', $request->input('size'))->first();
            if ($quantity)
                $quantity = $quantity->quantity;
            else $quantity = 0;
        }
        return [$quantity];
    }
    public function viewFavorite(Request $request)
    {
        $data = Products::with('Img', 'BrandProduct')
            ->join('favorite', 'favorite.id_product', 'products.id')
            ->leftjoin('rate', 'rate.id_product', 'products.id')
            ->where('favorite.id_customer', auth()->user()->id)
            ->groupBy('products.id', 'products.name', 'products.priceSell')
            ->select(
                'products.id',
                'products.name',
                'products.priceSell',
                'products.brand',
                DB::raw('ifnull((sum(rate.number_stars)/count(rate.id_product)),0) as number')
            )
            ->get()->toArray();
        //dd($data);
        return view('products.favorite', ['typenav' => $this->typenav, 'data' => $data,]);
    }
}
