<?php

namespace App\Http\Controllers;

use App\Models\Img;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Throwable;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function index(Request $request)
    {
        if ($request->input('id')) {
            $user = User::with('Img')->where('id', $request->input('id'))->get()->toArray();
            return view('customer.userinfo', ['typenav' => $this->typenav, 'user' => $user[0]]);
        }
    }
    public function updateInfo(Request $request)
    {
        DB::beginTransaction();
        try {

            User::where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'district' => $request->input('district'),
                'age' => $request->input('age'),
                'gender' => $request->input('gender'),
                'phone' => $request->input('phone')
            ]);
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/user_img');
                $logo = str_replace("public/", "", $logo);
                Img::updateOrCreate(
                    [
                        'product_id' => $request->input('id'),
                        'type' => 6,
                        'img_index' => 1
                    ],
                    ['path' => $logo]
                );
            }
            DB::commit();
            return 0;
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
    public function conTact(Request $request)
    {
        return view('customer.contact', ['typenav' => $this->typenav]);
    }
    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'message' => 'required|string'
        ]);
        try {
            DB::table('user_message')->insert([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'message' => $request->input('message'),
                'id_user' => auth()->user()->id
            ]);
            return Redirect::route('index');
        } catch (Throwable $e) {
            return Redirect::back()->withErrors(['msg' => 'Gửi thất bại']);
        }
    }
}
