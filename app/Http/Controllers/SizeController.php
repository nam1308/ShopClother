<?php

namespace App\Http\Controllers;

use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function getListSize(Request $request)
    {

        $data = [];
        if ($request->input('q')) {
            $data = Size::where('name', 'like', '%' . $request->get('q') . '%')->where('type', $request->input('type'))->get()->toArray();
        } else {
            $data = Size::where('type', $request->input('type'))->get()->toArray();
        }
        return $data;
    }
    public function getSizeOfProductDetail(Request $request)
    {
        $data = [];
        if ($request->input('color') && $request->input('id')) {
            $data = Products::where('products.id', $request->input('id'))
                ->join('product_detail', 'product_detail.id_product', 'products.id')
                ->join('product_size', 'product_size.id_productdetail', 'product_detail.id')
                ->join('size', 'size.id', 'product_size.size')->where('product_detail.id_color', $request->input('color'))
                ->whereNull('product_size.deleted_at')->whereNull('product_detail.deleted_at');
            if ($request->input('q')) {
                $data->where('size.name', 'like', '%' . $request->input('q') . '%');
            }
            $data = $data->select('size.id', 'size.name')->get()->toArray();
        }
        return $data;
    }
}
