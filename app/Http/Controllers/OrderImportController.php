<?php

namespace App\Http\Controllers;

use App\Enums\OrderTypeEnum;
use App\Enums\StatusOrderEnum;
use App\Http\Requests\OrderImportRequest;
use App\Models\Cart;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\ProductSize;
use App\Models\Suppliers;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Throwable;

class OrderImportController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function index(Request $request)
    {
        $orders = Orders::where('id_customer', $request->input('id'))->where('type', OrderTypeEnum::OrderImport)->get()->toArray();
        return view('admin.orderimport.index', ['orders' => $orders, 'typenav' => $this->typenav]);
    }
    public function create(Request $request)
    {
        return view('admin.orderimport.order', ['typenav' => $this->typenav, 'cart' => $request->session()->get('cartimport')]);
    }
    public function AddToCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'color' => 'required',
            'quantity' => 'required| numeric|min:0',
            'size' => 'required',
        ]);
        if ($request->input('id') && $request->input('color') && $request->input('size')) {
            if ($request->input('quantity') >= 0) {
                $product = Products::join('product_detail', 'products.id', 'product_detail.id_product')
                    ->join('product_size', 'product_detail.id', 'product_size.id_productdetail')
                    ->join('color', 'color.id', 'product_detail.id_color')
                    ->where('products.id', $request->input('id'))
                    ->join('size', 'size.id', 'product_size.size')
                    ->join('imgs', 'imgs.product_id', 'products.id')->where('imgs.type', 1)
                    ->where('product_detail.id_color', $request->input('color'))->where('product_size.size', $request->input('size'))
                    ->select(
                        'products.name',
                        'products.id',

                        DB::raw(
                            'products.priceSell as price'
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
                    $oldcart = Session('cartimport') ? Session('cartimport') : null;
                    $newcart = new Cart($oldcart);
                    $quantityInStock = $newcart->AddCart($product, $product['idProductDetail'], $request->input('quantity'), 1);
                    $request->session()->put('cartimport', $newcart);
                }
            }
            return [$request->session()->get('cartimport')->getTotalQuantity(), $quantityInStock, $product];
        }
    }
    public function removeProductInCart(Request $request)
    {
        $request->validate([
            'idProduct' => 'required',
            'size' => 'required',
        ]);
        $oldcart = Session('cartimport') ? Session('cartimport') : null;
        $newcart = new Cart($oldcart);
        $newcart->removeProductInCart($request->input('idProduct'), $request->input('size'));
        if ($newcart->getTotalQuantity() <= 0) {
            $request->session()->forget('cartimport');
            return [];
        } else
            $request->session()->put('cartimport', $newcart);
        return [$request->session()->get('cartimport')];
    }
    public function changeCart(Request $request)
    {
        $request->validate([
            'idProduct' => 'required',
            'quantity' => 'required| numeric',
            'size' => 'required',
        ]);
        $product = ProductDetail::where('id', $request->input('idProduct'))->first();
        if ($product != null) {
            $oldcart = Session('cartimport') ? Session('cartimport') : null;
            if ($oldcart != null) {
                $newcart = new Cart($oldcart);
                $newcart->changeQuantityProduct($request->input('idProduct'), $request->input('quantity'), $request->input('size'), 1);
                $request->session()->put('cartimport', $newcart);
            }
            return [$request->session()->get('cartimport')];
        }
    }
    public function removeCart(Request $request)
    {
        $request->session()->forget('cartimport');
    }
    public function checkCart(Request $request)
    {
        $quantity = 0;
        if ($request->session()->has('cartimport')) {
            $quantity = $request->session()->get('cartimport')->getTotalQuantity();
        }
        return $quantity;
    }
    public function checkOut(Request $request)
    {
        $cart = Session('cartimport') ? Session('cartimport') : null;
        $suppliers = Suppliers::get()->toArray();
        return view('admin.orderimport.checkout', ['typenav' => $this->typenav, 'cart' => $cart, 'suppliers' => $suppliers]);
    }
    public function CreateOrder(OrderImportRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try {
            $cart = Session::get('cartimport') ? Session::get('cartimport') : null;
            if ($cart != null) {
                if (!$request->input('idsupplier')) {
                    $supplier = Suppliers::create([
                        'name' => $request->input('name'),
                        'address' => $request->input('address'),
                        'city' => $request->input('city'),
                        'district' => $request->input('district'),
                        'email' => $request->input('email'),
                        'phone' => $request->input('phone'),
                        'country' => $request->input('country')
                    ]);
                    $order = Orders::create([
                        'id_user' => 1,
                        'id_customer' => $supplier->id,
                        'price' => $cart->getTotalMoney(),
                        'quantity' => $cart->getTotalQuantity(),
                        'type' => OrderTypeEnum::OrderImport,
                        'payment_method' => 1,
                        'note' => $request->input('note') ? $request->input('note') : '',
                        'address' => $request->input('address'),
                        'discount' => 0,
                        'name' => $request->input('name'),
                        'phone' => $request->input('phone'),
                        'email' => $request->input('email'),
                        'country' => $request->input('country'),
                        'city' => $request->input('city'),
                        'district' => $request->input('district'),
                        'zip_code' => $request->input('zip_code') ? $request->input('zip_code') : '',
                        'status' => StatusOrderEnum::Delivered,
                        'ship' => $request->input('ship')
                    ]);
                } else {
                    $supplier = Suppliers::where('id', $request->input('idsupplier'))->first();
                    $order = Orders::create([
                        'id_user' => 1,
                        'id_customer' => $request->input('idsupplier'),
                        'price' => $cart->getTotalMoney(),
                        'quantity' => $cart->getTotalQuantity(),
                        'type' => OrderTypeEnum::OrderImport,
                        'payment_method' => 1,
                        'note' => $request->input('note') ? $request->input('note') : '',
                        'address' => $supplier->address,
                        'discount' => 0,
                        'name' => $supplier->name,
                        'phone' => $supplier->phone,
                        'email' => $supplier->email,
                        'country' => $supplier->country,
                        'city' => $supplier->city,
                        'district' => $supplier->district,
                        'zip_code' => $request->input('zip_code') ? $request->input('zip_code') : '',
                        'status' => StatusOrderEnum::Delivered,
                        'ship' => $request->input('ship')
                    ]);
                }

                foreach ($cart->getProductInCart() as $item) {
                    $productsize = ProductSize::where('size', $item['productInfo']['idsize'])->where('id_productdetail', $item['productInfo']['idProductDetail'])->first();

                    ProductSize::where('size', $item['productInfo']['idsize'])->where('id_productdetail', $item['productInfo']['idProductDetail'])->update([
                        'quantity' => $productsize->quantity + $item['quantity']
                    ]);
                    OrderDetails::create([
                        'id_order' => $order->id,
                        'id_product' => $item['productInfo']['idProductDetail'],
                        'quantity' => $item['quantity'],
                        'price' => $item['productInfo']['price'],
                        'size' => $item['productInfo']['idsize'],
                        'totalPrice' => $item['price']
                    ]);
                }
                DB::commit();
                $request->session()->forget('cartimport');
                return Redirect::route('product.index');
            } else {
                return Redirect::route('product.index');
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function orderDetail(Request $request)
    {
        if ($request->input('id')) {
            $data = OrderDetails::where('id_order', $request->input('id'))
                ->join('product_detail', 'product_detail.id', 'order_details.id_product')
                ->join('product_size', function ($join) {
                    $join->on('product_size.id_productdetail', '=', 'product_detail.id');
                    $join->on('order_details.size', '=', 'product_size.size');
                })
                ->join('products', 'products.id', 'product_detail.id_product')
                ->join('color', 'color.id', 'product_detail.id_color')
                ->join('size', 'size.id', 'product_size.size')
                ->join('imgs', 'imgs.product_id', 'product_detail.id')->where('img_index', 1)
                ->select('order_details.quantity', 'order_details.totalPrice', 'order_details.size', 'products.name', 'imgs.path', DB::raw('color.name as colorname'), DB::raw('size.name as sizename'))->get()->toArray();
            return $data;
        }
        return [];
    }
    public function delete(Request $request)
    {
        if ($request->input('id')) {
            try {
                DB::beginTransaction();
                //$data = OrderDetails::where('id_order', $request->input('id'))->get()->toArray();
                // foreach ($data as $item) {
                //     $productsize = ProductSize::where('size', $item['size'])->where('id_productdetail', $item['id_product'])->first();

                //     ProductSize::where('size', $item['size'])->where('id_productdetail', $item['id_product'])->update([
                //         'quantity' => $productsize->quantity + $item['quantity']
                //     ]);
                // }
                OrderDetails::where('id_order', $request->input('id'))->delete();
                Orders::where('id', $request->input('id'))->delete();
                DB::commit();
                return response()->json(['error' => 'Xóa thành công'], 200);
            } catch (Throwable $e) {
                DB::rollBack();
                return response()->json(['error' => 'Xóa thất bại'], 404);
            }
        }
    }
}
