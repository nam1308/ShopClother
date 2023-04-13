<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class ShipController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getShip(Request $request)
    {
        if ($request->input('location')) {
            return Ship::where('location', $request->input('location'))->pluck('price');
        }
    }
    public function index(Request $request)
    {
        $ship = $this->configs['ship'];
        // dd($ship);
        return view('admin.ship.index', ['typenav' => $this->typenav, 'list' => $ship]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'price' => 'required',
        ]);
        DB::beginTransaction();
        try {
            Ship::where('id', $request->input('id'))->update([
                'price' => $request->input('price')
            ]);
            Cache::forget('configs');
            DB::commit();
            return response()->json(['message' => 'Cập nhật thành công'], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message'   =>  "Cập nhật thất bại"
            ], 401);
        }
    }
}
