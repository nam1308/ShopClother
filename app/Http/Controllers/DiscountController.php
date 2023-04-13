<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\DiscountUser;
use App\Models\Img;
use App\Models\Products;
use App\Models\Type;
use App\Models\User;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Client\Response as ClientResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;
use Symfony\Contracts\Service\Attribute\Required;
use Throwable;

class DiscountController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function index(Request $request)
    {
        $discount = Discount::with('Img')->get()->toArray();
        return view('admin.discount.index', ['discount' => $discount, 'typenav' => $this->typenav]);
    }
    public function edit(Request $request)
    {
        $listproduct = Products::with('Img')->get()->toArray();
        return view('admin.discount.CreateOrUpdate', ['typenav' => $this->typenav, 'discount' => Discount::with('Img')->where('id', $request->input('id'))->first()->toArray(), 'isedit' => $request->input('id'), 'listproduct' => $listproduct]);
    }
    public function delete(Request $request)
    {
        DB::beginTransaction();
        try {
            $discount = Discount::where('id', $request->input('id'));
            if ($discount->first()->type == 1) {
                Products::where('id', $discount->first()->relation_id)->update(['price_discount' => 0]);
            }
            $discount->delete();
            DB::commit();
            return response()->json(['success' => 'Thành công'], 200);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function create(Request $request)
    {
        $listproduct = Products::with('Img')->get()->toArray();
        return view('admin.discount.CreateOrUpdate', ['typenav' => $this->typenav, 'listproduct' => $listproduct]);
    }
    public function update(Request $request)
    {
        $discount = [];
        if ($request->input('id')) {
            $discount = Discount::where('id', $request->input('id'));
        }
        return view('admin.discount.CreateOrUpdate', ['isedit' => 1, 'id' => $request->input('id'), 'discount' => $discount, 'typenav' => $this->typenav]);
    }
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $discount = new Discount();
            if ($request->input('id')) {
                $discount = Discount::where('id', $request->input('id'))->first();
            }
            $discount->persent = $request->input('persent');
            $discount->type = $request->input('type');
            $discount->begin = $request->input('begin');
            $discount->end = $request->input('end');
            $discount->name = $request->input('name');
            $discount->code = $request->input('code');
            $discount->discription = $request->input('description');
            $discount->unit = $request->input('unit');
            if ($request->input('type') == 1) {
                $discount->relation_id = $request->input('product');
                $price = Products::where('id', $request->input('product'))->first()->priceSell;
                $pricediscount = 0;
                if ($request->input('unit') == 1) {
                    $pricediscount = (1 - (floatval($request->input('persent')) / 100)) * $price;
                } else {
                    $pricediscount = $price - floatval($request->input('persent'));
                }

                Products::where('id', $request->input('product'))->update(['price_discount' => $pricediscount]);
            }
            $discount->save();
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/discount_img');
                $logo = str_replace("public/", "", $logo);
                Img::updateOrCreate(
                    [
                        'product_id' => $discount->id,
                        'type' => 7,
                        'img_index' => 1
                    ],
                    ['path' => $logo]
                );
            }
            DB::commit();
            return Redirect::route('admin.discount.index');
        } catch (Throwable $e) {
            DB::rollBack();
            // dd($e);
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function getList(Request $request)
    {
        $data = [];
        if ($request->input('q')) {
            $data = Discount::where('name', 'like', '%' . $request->get('q') . '%')->get()->toArray();
        } else {
            $data = Discount::get()->toArray();
        }
        return $data;
    }
    public function getDiscountById(Request $request)
    {
        $data = [];
        if ($request->input('id')) {
            $data = Discount::with('Img')->where('id', $request->input('id'))->first()->toArray();
            return $data;
        }
        return $data;
    }
    public function addToAccount(Request $request)
    {
        $request->validate([
            'iduser' => 'required',
            'iddiscount' => 'required',
        ]);
        $count = DiscountUser::where('id_customer', $request->input('iduser'))->where('id_discount', $request->input('iddiscount'))->count();
        if (!$count) {
            DiscountUser::create([
                'id_customer' => $request->input('iduser'),
                'id_discount' => $request->input('iddiscount')
            ]);
            return 1;
        }
        return response()->json([
            'message'   =>  "Tài khoản đã nhận hoặc lỗi, bạn có thể thử lại"
        ], 401);
    }
}
