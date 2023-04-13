<?php

namespace App\Http\Controllers;

use App\Http\Requests\TypeRequest;
use App\Models\Categories;
use App\Models\Img;
use App\Models\Products;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Throwable;

class TypeController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function getListType(Request $request)
    {
        $data = [];
        if ($request->input('q')) {
            $data = Type::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Type::get()->toArray();
        }
        return $data;
    }
    public function getTypeById(Request $request)
    {
        $data = [];
        if ($request->input('id')) {
            $data = Type::where('id', $request->input('id'))->first()->toArray();
            return $data;
        }
        return $data;
    }
    public function create(Request $request)
    {
        // $typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        return view('admin.types.createorupdate', ['typenav' => $this->typenav]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'name' => $request->input('id') ? ['required', Rule::unique('type', 'name')->whereNull('deleted_at')->ignore($request->input('id'))] : ['required', Rule::unique('type', 'name')->whereNull('deleted_at')],
            'photo.*' => $request->input('id') ? '' : ['required', 'image'],
        ]);

        DB::beginTransaction();
        try {
            $type = new Type();
            $logo = null;
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/type_img');
                $logo = str_replace("public/", "", $logo);
            }
            if ($request->input('id')) {
                $type = Type::where('id', $request->input('id'))->first();
                if ($logo) {
                    Img::where('product_id', $request->input('id'))->where('type', 3)->where('img_index', 1)->update([
                        'path' => $logo,
                    ]);
                }
                $type->name = $request->input('name');
                $type->save();
            } else {
                $type->name = $request->input('name');
                $type->save();
                Img::create([
                    'product_id' => $type->id,
                    'path' => $logo,
                    'type' => 3,
                    'img_index' => 1
                ]);
            }
            DB::commit();
            SystemConfigController::removeCache();
            if ($request->input('api'))
                return response()->json(['success' => 'Thành công'], 200);
            return redirect()->route('admin.type.index');
        } catch (Throwable $e) {
            DB::rollBack();
            if ($request->input('api'))
                return response()->json(['error' => 'Thất bại'], 400);
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => 'Thêm không thành công']);
        }
    }

    public function index(Request $request)
    {
        // $typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        //  dd(Products::join('categories', 'categories.id', 'products.category')->where('categories.type', 2)->count());
        return view('admin.types.index', ['typenav' => $this->typenav]);
    }
    public function update(Request $request)
    {
        // $typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        $type  = $this->typenav[array_search($request->input('id'), array_column($this->typenav, 'id'))];
        SystemConfigController::removeCache();
        return view('admin.types.createorupdate', ['idtype' => $request->input('id'), 'typenav' => $this->typenav, 'type' => $type, 'isedit' => 1]);
    }
    public function delete(Request $request)
    {
        if ($request->input('id')) {
            if (Products::join('categories', 'categories.id', 'products.category')->where('categories.type', $request->input('id'))->count()) {
                return response()->json(['error' => 'Hiện còn sản phẩm trong kho thuộc loại này không thể xóa'], 400);
            } else {
                Type::where('id', $request->input('id'))->delete();
                Categories::where('type', $request->input('id'))->delete();
                Img::whereIn('type', [3, 4])->where('product_id', $request->input('id'))->delete();
                return response()->json(['success' => 'Xóa thành công'], 200);
            }
        }
        SystemConfigController::removeCache();
    }
}
