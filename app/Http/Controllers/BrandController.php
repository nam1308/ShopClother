<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Img;
use App\Models\Products;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class BrandController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function index()
    {
        $brands = Brand::with('Img')->withCount('Product')->get()->toArray();
        //dd($brands);
        return view('admin.brand.index', ['brands' => $brands, 'typenav' => $this->typenav]);
    }
    public function create()
    {
        return view('admin.brand.createorupdate', ['typenav' => $this->typenav]);
    }
    public function store(BrandRequest $request)
    {
        DB::beginTransaction();
        try {
            $brand = new Brand();
            if ($request->input('id')) {
                $brand = Brand::where('id', $request->input('id'))->first();
            }
            $brand->name = $request->input('name');
            $brand->country = $request->input('country');
            $brand->description = $request->input('description');
            $brand->website = $request->input('website');
            $brand->save();
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/brand_img');
                $logo = str_replace("public/", "", $logo);
                Img::updateOrCreate(
                    [
                        'product_id' => $brand->id,
                        'type' => 5,
                        'img_index' => 1
                    ],
                    ['path' => $logo]
                );
            }
            DB::commit();
            if ($request->input('api'))
                return response()->json(['success' => 'Thành công'], 200);
            return Redirect::route('admin.brand.index');
        } catch (Throwable $e) {
            DB::rollBack();
            if ($request->input('api')) return response()->json(['error' => 'Thất bại'], 404);
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function update(Request $request)
    {
        if ($request->input('id')) {
            $data = Brand::where('id', $request->input('id'))->with('Img')->withCount('Product')->get()->toArray();
            return view('admin.brand.createorupdate', ['brand' => $data[0], 'typenav' => $this->typenav, 'isedit' => 1]);
        }
    }
    public function getListBrand(Request $request)
    {

        $data = [];
        if ($request->input('q')) {
            $data = Brand::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Brand::get()->toArray();
        }
        return $data;
    }
    public function delete(Request $request)
    {
        if ($request->input('id')) {
            if (Products::where('brand', $request->input('id'))->count()) {
                return response()->json(['error' => 'Hiện còn sản phẩm trong kho thuộc nhã hiệu này không thể xóa'], 400);
            } else {
                Brand::where('id', $request->input('id'))->delete();
                Img::where('type', 5)->where('product_id', $request->input('id'))->delete();
                return response()->json(['success' => 'Xóa thành công'], 200);
            }
        }
    }
}
