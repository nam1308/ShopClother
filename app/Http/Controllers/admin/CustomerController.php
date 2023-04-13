<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotification;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CustomerController extends Controller
{
    protected $page;
    public function __construct()
    {
        $this->page = 3;
        $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
            ->get()->toArray();
        parent::__construct();
    }
    public function index(Request $request)
    {
        $customers = User::with('Img')->paginate($this->page);
        return view('admin.customers.index', ['typenav' => $this->typenav, 'customers' => $customers]);
    }
    public function deletecustomer(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $order = Orders::where('id_customer', $request->input('id'));
            OrderDetails::whereIn('id_order', $order->select('id')->get()->toArray())->delete();
            $order->delete();
            User::where('id', $request->input('id'))->delete();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['eror' => "Xóa thất bại"], 400);
        }
    }
    public function sendNotification(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'photo' => 'required',
            'message' => 'required',
        ]);
        $message = $request->input('message');
        $logo = optional($request->file('photo'))->store('public/introduce_img');
        $logo = str_replace("public/", "", $logo);
        $header = $request->input('name');
        // dd([$header, $logo, $message]);
        SendNotification::dispatch(array($header, $logo, $message), User::whereNull('provider_id')->get())->delay(now()->addSeconds(1));
        return redirect()->route('admin.customers.viewsendnotification');
    }
    public function viewSendNotification(Request $request)
    {
        return view('admin.notifications.send', ['typenav' => $this->typenav]);
    }
}
