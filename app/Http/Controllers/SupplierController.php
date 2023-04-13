<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use Illuminate\Http\Request;
use App\Models\Img;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Suppliers;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class SupplierController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $supplier = Suppliers::get()->toArray();
        return view('admin.supplier.index', ['suppliers' => $supplier, 'typenav' => $this->typenav]);
    }
    public function create()
    {
        return view('admin.supplier.updateorcreate', ['typenav' => $this->typenav]);
    }
    public function store(SupplierRequest $request)
    {
        DB::beginTransaction();
        try {
            $supplier = new Suppliers();
            if ($request->input('id')) {
                $supplier = Suppliers::where('id', $request->input('id'))->first();
            }
            $supplier->name = $request->input('name');
            $supplier->country = $request->input('country');
            $supplier->district = $request->input('district');
            $supplier->email = $request->input('email');
            $supplier->phone = $request->input('phone');
            $supplier->address = $request->input('address');
            $supplier->city = $request->input('city');
            $supplier->save();
            DB::commit();
            return Redirect::route('admin.supplier.index');
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function update(Request $request)
    {
        if ($request->input('id')) {
            $data = Suppliers::where('id', $request->input('id'))->get()->toArray();
            return view('admin.supplier.updateorcreate', ['supplier' => $data[0], 'typenav' => $this->typenav, 'isedit' => 1]);
        }
    }
    public function getSupplier(Request $request)
    {

        $data = [];
        if ($request->input('q')) {
            $data = Suppliers::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Suppliers::get()->toArray();
        }
        return $data;
    }
    public function delete(Request $request)
    {
        if ($request->input('id')) {
            if (Orders::where('id_customer', $request->input('id'))->where('type', 2)->count()) {
                return response()->json(['error' => 'Hiện không thể xóa vì còn hóa đơn liên quan đến nhà sản xuất này'], 400);
            } else {
                Suppliers::where('id', $request->input('id'))->delete();
                return response()->json(['success' => 'Xóa thành công'], 200);
            }
        }
    }
}
