<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Products;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'namecolor' => 'required|string'
        ]);
        $color = Color::create([
            'name' => $request->get('namecolor')
        ]);
        return $color;
    }
    public function getListColor(Request $request)
    {
        $data = [];
        if ($request->input('q')) {
            $data = Color::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Color::get()->toArray();
        }
        return $data;
    }
    public function getColorOfProduct(Request $request)
    {
        $data = [];
        if ($request->input('id')) {
            $data = Products::where('products.id', $request->input('id'))
                ->join('product_detail', 'product_detail.id_product', 'products.id')
                ->join('color', 'color.id', 'product_detail.id_color')->whereNull('color.deleted_at');
            if ($request->input('q')) {
                $data->where('color.name', 'like', '%' . $request->get('q') . '%');
            }
            $data = $data->select('color.id', 'color.name')->get()->toArray();
        }
        return $data;
    }
}
