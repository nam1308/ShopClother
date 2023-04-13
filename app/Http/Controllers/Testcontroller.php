<?php

namespace App\Http\Controllers;

use App\Exports\TestEport;
use App\Imports\TestImport;
use App\Models\Customers;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class Testcontroller extends Controller
{
    public function __construct()
    {
        //dd('chay nha');
    }
    public function index(Request $request)
    {
        $data = User::get();
        return Excel::download(new TestEport(
            $data
        ), 'danhsachkhachhang' . date('Y-m-d-His') . '.xlsx');
    }
    public function put(Request $request)
    {
        //dd('chay');
    }
    public function export1(Request $request)
    {
        $data = Products::get();
        return Excel::download(new TestEport(
            $data
        ), 'danhsachkhachhang' . date('Y-m-d-His') . '.xlsx');
    }
    public function export(Request $request)
    {
        $data = User::get();
        return Excel::download(new TestEport(
            $data
        ), 'danhsachkhachhang' . date('Y-m-d-His') . '.xlsx');
    }
    public function import(Request $request)
    {
        $collection = Excel::toCollection(new TestImport, $request->file('file'), null);
        $sheetData = $collection[0];
        dd($sheetData);
    }
}
