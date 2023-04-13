<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ResponseTrait;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Img;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\ProductSize;
use App\Models\Size;
use App\Models\Type;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Illuminate\Validation\Rule;
use Symfony\Component\Console\Input\Input;
use Throwable;

class ProductController extends Controller
{
    use ResponseTrait;
    public function __construct()
    {
        $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
            ->get()->toArray();
        parent::__construct();
    }
    public function index()
    {
        $data = Products::with('Img', 'TypeProduct')->get()->toArray();
        //dd($data);
        return view('admin.product.product', ['typenav' => $this->typenav, 'products' => $data]);
    }
    public function create()
    {

        $typenav = Type::with('Img', 'Categories')->withCount('Product')->get()->toArray();
        // DB::enableQueryLog();
        // dd(Type::with(['Categories' => fn ($query) => $query->where('id', 1)])->where('id', 1)->get()->first()->toArray()['categories'][0]['name']);
        // dd(DB::getQueryLog());
        return view('admin.product.addproduct', ['typenav' => $this->typenav, 'type' => Type::query(), 'brand' => Brand::query(), 'typenav' => $typenav]);
    }
    public function update(Request $request)
    {
        //Artisan::call('cache:clear');
        //dd(Products::with('Img', 'BrandProduct', 'TypeProduct')->where('id', $request->get('id'))->first()->toArray());
        return view('admin.product.addproduct', [
            'typenav' => $this->typenav,
            'type' => Type::query(), 'brand' => Brand::query(),
            'edit' => 1, 'product' => Products::with('Img')->where('id', $request->get('id'))->first()->toArray(),
        ]);
    }
    public function store(ProductRequest $request)
    {
        Artisan::call('cache:clear');
        // dd($request->file('photo'));
        DB::beginTransaction();
        try {

            $product = new Products();
            if ($request->get('id')) {
                $product = Products::where('id', $request->get('id'))->first();
            }
            $product->name = $request->get('name');
            $product->code = $request->get('code');
            $product->category = $request->get('category');
            $product->priceImport = $request->get('priceImport');
            $product->priceSell = $request->get('priceSell');
            $product->type = $request->get('type');
            $product->brand = $request->get('brand');
            $product->status = $request->get('status');
            $product->featured = $request->get('featured');
            $product->description = $request->get('description');
            $product->gender = $request->get('gender');
            $product->quantity = $request->get('quantity') ? $request->get('quantity') : 0;
            $product->save();
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/product_img');
                $logo = str_replace("public/", "", $logo);
                if ($request->get('id')) {
                    DB::table('imgs')->where("product_id", $request->get('id'))->where('type', 1)->update(['path' => $logo]);
                    DB::commit();
                    return redirect()->route('admin.product.index');
                } else {
                    Img::create([
                        'product_id' => $product->id,
                        'path' => $logo,
                        'type' => 1,
                        'img_index' => 1
                    ]);
                    DB::commit();
                    return redirect()->route('admin.product.createdetail', ['id' => $product->id]);
                }
            }
            DB::commit();
            return redirect()->route('admin.product.index');
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function createDetail(Request $request)
    {

        //dd(ProductDetail::with('sizeProduct', 'colorProduct')->where('id_product', $request->get('id'))->get()->toArray());
        return view('admin.product.category', [
            'typenav' => $this->typenav,
            'id' => $request->get('id'),
            'list' => ProductDetail::with(['sizeProduct', 'colorProduct', 'ProductSizeDetail' => function ($query) {
                $query->select('id_productdetail', DB::raw('sum(quantity) as sum'))->groupBy('id_productdetail');
            }])->where('id_product', $request->get('id'))->get()->toArray(),

        ]);
    }
    public function storeDetail(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'idProduct' => 'required',
            'color' => [
                'required', Rule::in(Color::pluck('id')->toArray()),
                Rule::unique('product_detail', 'id_color')->where(fn ($query) => $query->where('id_product', $request->input('idProduct')))
                    ->ignore(request('id'), 'id'),
            ],
            // 'size' => ['required', Rule::in(Size::pluck('id')->toArray()),],
            // 'quantity' => 'required| numeric',
            'photo' => $request->input('id') ? '' : 'required',
            'photo.*' => $request->input('id') ? '' : 'image',
            'numberimg' => $request->input('id') ? 'numeric' : ''
        ]);
        $productDetail = new ProductDetail();
        if ($request->input('id')) {
            $productDetail = ProductDetail::where('id', $request->input('id'))->first();
        }
        $productDetail->id_color = $request->input('color');
        $productDetail->quantity = 0;
        $productDetail->id_product = $request->input('idProduct');
        $productDetail->save();

        if ($request->input('id')) {
            for ($i = 1; $i <= $request->input('numberimg'); $i++) {
                //dd('chay');
                if ($request->hasFile('photo' . $i)) {
                    $logo = optional($request->file('photo' . $i))->store('public/product_img');
                    $logo = str_replace("public/", "", $logo);
                    DB::table('imgs')->where("product_id", $request->get('id'))->where('type', 2)->where('img_index', $i)->update(['path' => $logo]);
                }
            }
            if ($request->hasFile('photo')) {

                $files = $request->file('photo');
                $i = $request->input('numberimg');
                foreach ($files as $file) {
                    $i++;
                    $logo = optional($file)->store('public/product-detail_img');
                    $logo = str_replace("public/", "", $logo);
                    Img::create([
                        'product_id' => $productDetail->id,
                        'path' => $logo,
                        'type' => 2,
                        'img_index' => $i
                    ]);
                }
            }
        }
        // dd('khong cos');
        else if ($request->hasFile('photo')) {
            $files = $request->file('photo');
            $i = 0;
            foreach ($files as $file) {
                $i++;
                $logo = optional($file)->store('public/product-detail_img');
                $logo = str_replace("public/", "", $logo);
                Img::create([
                    'product_id' => $productDetail->id,
                    'path' => $logo,
                    'type' => 2,
                    'img_index' => $i
                ]);
            }
        } //Size::where('id', $request->input('size'))->first()->name
        return [
            $productDetail,
            Color::where('id', $request->input('color'))->first()->name,
            ProductDetail::with('sizeProduct')->where('id', $productDetail->id)->get()->toArray()
        ];
    }
    public function getProduct(Request $request)
    {
        $data = Products::with('TypeProduct', 'BrandProduct', 'CategoryProduct')->where('id', $request->input('id'))->first();
        return $data;
    }
    public function getDetailProduct(Request $request)
    {
        $data = ProductDetail::with(['Img' => fn ($query) => $query->where('type', 2), 'colorProduct'])->where('id', $request->input('id'))->first();
        return $data ? $data->toArray() : [];
    }
    public function updateProductDetail(Request $request)
    {
    }
    public function removeImg(Request $request)
    {
        if ($request->input('id')) {
            Img::where('id', $request->input('id'))->delete();
            return 1;
        }
        return 0;
    }
    public function removeDetail(Request $request)
    {
        Artisan::call('cache:clear');
        if ($request->input('id')) {
            ProductDetail::where('id', $request->input('id'))->delete();
            Img::where('product_id', $request->input('id'))->where('type', 2)->delete();
        }
    }
    public function storeSize(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'id' => 'required',
            'size' => ['required', Rule::in(Size::pluck('id')->toArray()), Rule::unique('product_size', 'size')
                ->where(fn ($query) => $query->where('id_productdetail', $request->input('id'))->where('deleted_at', null))],
            'quantity' => 'required| numeric',
            'typesize' => 'required',
        ]);
        $productsize = ProductSize::create([
            'size' => $request->input('size'),
            'id_productdetail' => $request->input('id'),
            'quantity' => $request->input('quantity')
        ]);
        return [
            ProductSize::with('infoSize')->where('size', $request->input('size'))->where('id_productdetail', $request->input('id'))->get()->toArray(),
            ProductSize::where('id_productdetail', $request->input('id'))->select(DB::raw('sum(quantity) as sum'))->get(),
            ProductSize::with('infoSize')->where('id_productdetail', $request->input('id'))->get()->toArray()
        ];
    }
    public function updateSize(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'idProductDetail' => 'required',
            'size' => ['required', Rule::in(Size::pluck('id')->toArray()), Rule::unique('product_size', 'size')
                ->where(fn ($query) => $query->where('id_productdetail', $request->input('id'))->where('size', '!=', $request->input('size')))],
            'quantity' => 'required| numeric',
            'typesize' => 'required',
        ]);
        $productsize = ProductSize::where('id_productdetail', $request->input('id'))->where('size', $request->input('size'))->update([
            'size' => $request->input('size'),
            'quantity' => $request->input('quantity')
        ]);
        return [$productsize, Size::where('id', $request->input('size')->first()->toArray())];
    }
    public function getSize(Request $request)
    {
        $data = ProductSize::with('infoSize')->where('id_productdetail', $request->input('id'))->get()->toArray();
        return $data;
    }
    public function removeSize(Request $request)
    {
        Artisan::call('cache:clear');
        try {
            if (!$request->input('idproduct') || !$request->input('idsize')) {
                throw new Exception("Remove failled", 30);
            } else {
                ProductSize::where('id_productdetail', $request->input('idproduct'))->where('size', $request->input('idsize'))->delete();
                return [
                    ProductSize::where('id_productdetail', $request->input('idproduct'))->select(DB::raw('sum(quantity) as sum'))->get(),
                    ProductSize::with('infoSize')->where('id_productdetail', $request->input('idproduct'))->get()->toArray()
                ];
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
    public function changeSize(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'idProductDetail' => 'required',
            'size' => 'required',
            'quantity' => 'required| numeric',
        ]);
        $productsize = ProductSize::where('id_productdetail', $request->input('idProductDetail'))->where('size', $request->input('size'))->update([
            'quantity' => $request->input('quantity')
        ]);
        return [$productsize, ProductSize::where('id_productdetail', $request->input('idProductDetail'))->select(DB::raw('sum(quantity) as sum'))->get()];
    }
    public function changStatus(Request $request)
    {
        Artisan::call('cache:clear');
        if ($request->input('id') && ($request->input('status') || $request->input('status') == 0)) {
            Products::where('id', $request->input('id'))->update([
                'status' => $request->input('status')
            ]);
            return [$request->input('status')];
        }
        return response()->json(['error' => "Thất bại"], 200);
    }
    public function delete(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            if ($request->input('id')) {
                Products::where('id', $request->input('id'))->delete();
                $iddetail = ProductDetail::where('id_product', $request->input('id'))->get()->toArray();
                ProductDetail::where('id_product', $request->input('id'))->delete();
                ProductSize::whereIn('id_productdetail', $iddetail)->delete();
                DB::commit();
                return response()->json(['success' => "Xóa thành công"], 200);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['eror' => "Xóa thất bại"], 400);
        }
    }
}
