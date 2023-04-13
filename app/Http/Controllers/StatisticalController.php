<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\ProductDetail;
use App\Models\Products;
use App\Models\Type;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticalController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function productCategories(Request $request)
    {
        return view('admin.statistical.StatisticsByCategories', ['typenav' => $this->typenav]);
    }
    public function index(Request $request)
    {
        return view('admin.statistical.index', ['typenav' => $this->typenav]);
    }
    public function byProduct(Request $request)
    {
        $begin = $request->input('begin') . ' 0:0:0';
        $end = $request->input('end') . ' 23:59:59';
        $hoadon = Orders::join('order_details', 'order_details.id_order', 'orders.id')
            ->where('orders.created_at', '>=', $begin)
            ->where('orders.created_at', '<=', $end)
            ->whereNull('order_details.deleted_at')
            ->select('orders.created_at', 'order_details.id_product', 'order_details.totalPrice', 'order_details.quantity');
        //dd($hoadon->get()->toArray());
        $data = ProductDetail::joinSub($hoadon, 'hoadon', function ($join) {
            $join->on('product_detail.id', '=', 'hoadon.id_product');
        })->rightJoin('products', 'products.id', 'product_detail.id_product')
            ->groupBy('products.id', 'products.name', 'hoadon.created_at')
            ->select(
                'products.id',
                'products.name',
                DB::raw("IFNULL(DATE_FORMAT(hoadon.created_at, '%Y-%m-%d'),0) as NgayDatHang"),
                DB::raw('IFNULL(sum(hoadon.quantity),0) as soluong'),
                DB::raw('IFNULL(sum(hoadon.totalPrice-products.priceImport),0) as doanhthu')
            )
            ->get()->toArray();
        // dd($data);
        $dataget = 'doanhthu';
        $dataget = $request->input('data') ? $request->input('data') : 'soluong';
        $itemsp = [];
        foreach ($data as $item) {
            if (empty($itemsp[$item['name']])) {
                $itemsp[$item['name']] = [
                    'name' => $item['name'],
                    'y' => intval($item[$dataget]),
                    'drilldown' => $item['name']
                ];
            } else {
                $itemsp[$item['name']]['y'] += $item[$dataget];
            }
        }
        $arr = [];
        $period = new DatePeriod(
            new DateTime($begin),
            new DateInterval('P1D'),
            new DateTime($end)
        );
        foreach ($data as $item) {
            $arr[$item['name']] = [
                'name' => $item['name'],
                'id' => $item['name'],
                'data' => []
            ];
            foreach ($period as $key => $value) {

                $arr[$item['name']]['data'][$value->format('Y-m-d')] = [
                    $value->format('Y-m-d'),
                    0
                ];
            }
            foreach ($data as $item) {
                $arr[$item['name']]['data'][$item['NgayDatHang']] = [
                    $item['NgayDatHang'],
                    floatval($item[$dataget])
                ];
            }
        }
        return [$itemsp, $arr];
    }
    public function byCategories(Request $request)
    {
        $begin = $request->input('begin') . ' 0:0:0';
        $end = $request->input('end') . ' 23:59:59';
        $hoadon = Orders::join('order_details', 'order_details.id_order', 'orders.id')
            ->where('orders.created_at', '>=', $begin)
            ->where('orders.created_at', '<=', $end)
            ->whereNull('order_details.deleted_at')
            ->select('orders.created_at', 'order_details.id_product', 'order_details.totalPrice', 'order_details.quantity');
        $typeCategories = Type::join('categories', 'categories.type', 'type.id')
            ->select(DB::raw('categories.name as namecategory'), DB::raw('type.name as nametype'), DB::raw('categories.id idcategory'), DB::raw('type.id as idtype'));
        //dd($hoadon->get()->toArray());
        $data = ProductDetail::joinSub($hoadon, 'hoadon', function ($join) {
            $join->on('product_detail.id', '=', 'hoadon.id_product');
        })
            ->join('products', 'products.id', 'product_detail.id_product')
            ->rightJoinSub($typeCategories, 'typecate',  function ($join) {
                $join->on('products.type', '=', 'typecate.idtype');
                $join->on('products.category', '=', 'typecate.idcategory');
            })
            ->groupBy('typecate.idtype', 'typecate.idcategory', 'typecate.nametype', 'typecate.namecategory')
            ->select(
                'typecate.idtype',
                'typecate.idcategory',
                'typecate.nametype',
                'typecate.namecategory',
                DB::raw('IFNULL(sum(hoadon.quantity),0) as soluong'),
                DB::raw('IFNULL(sum(hoadon.totalPrice-products.priceImport),0) as doanhthu')
            )
            ->get();

        $dataget = 'doanhthu';
        $dataget = $request->input('data') ? $request->input('data') : 'doanhthu';
        $type = 1;
        $type = $request->input('type') ? $request->input('type') : 1;
        $sum = $data->sum($dataget);
        $data = $data->toArray();
        // dd($sum);
        $itemsp = [];
        foreach ($data as $item) {
            if (empty($itemsp[$item['nametype']])) {
                $itemsp[$item['nametype']] = [
                    'name' => $item['nametype'],
                    'data' => intval($item[$dataget]),
                    'drilldown' => $item['nametype'],
                    'y' => $type == 1 ? ($sum != 0 ? (intval($item[$dataget]) / floatval($sum)) * 100 : 0) : intval($item[$dataget])
                ];
            } else {
                $itemsp[$item['nametype']]['data'] += $item[$dataget];
                $itemsp[$item['nametype']]['y'] = ($type == 1 ? ($sum != 0 ? (intval($itemsp[$item['nametype']]['data']) / floatval($sum)) * 100 : 0) : $itemsp[$item['nametype']]['data']);
            }
        }
        $arr = [];
        $categoryoftype = Type::with('Categories')->get()->toArray();
        foreach ($categoryoftype as $item) {
            $arr[$item['name']] = [
                'name' => $item['name'],
                'id' => $item['name'],
                'data' => []
            ];
            foreach ($item['categories'] as $value) {

                $arr[$item['name']]['data'][$value['name']] = [
                    $value['name'],
                    0
                ];
            }
        }
        foreach ($data as $item) {
            $arr[$item['nametype']]['data'][$item['namecategory']] = [
                $item['namecategory'],
                $type == 1 ?  (floatval($itemsp[$item['nametype']]['data']) != 0 ? (floatval($item[$dataget]) / floatval($itemsp[$item['nametype']]['data'])) * 100 : 0) : floatval($item[$dataget]),
            ];
        }
        return [$itemsp, $arr];
    }
}
