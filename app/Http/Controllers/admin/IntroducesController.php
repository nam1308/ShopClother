<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Img;
use App\Models\Introduce;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Throwable;

class IntroducesController extends Controller
{
    public function __construct()
    {
        $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
            ->get()->toArray();
        parent::__construct();
    }
    public function banner(Request $request)
    {
        $main = Introduce::with('Img')->where('type', 2)->get()->toArray();
        $discount = Introduce::with('Img')->where('type', 1)->get()->toArray();
        return view('admin.introduce.banner', ['typenav' => $this->typenav, 'main' => $main, 'discount' => $discount]);
    }
    public function edit(Request $request)
    {
        $discount = Discount::get()->toArray();
        $index = 1;
        // if ($request->input('index'))
        //     $index = $request->input('index');
        // else
        //     $index = intval(Introduce::where('type', $request->input('type'))->get()->count()) + 1;
        return view('admin.introduce.edit', ['typenav' => $this->typenav, 'discount' => $discount, 'type' => $request->input('type'), 'index' => $index]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'index' => 'required',
            'description' => 'required',
            'type' => 'required',
            'photo' => $request->input('id') ? '' : 'required',
        ]);
        Artisan::call('cache:clear');
        // dd($request->all());
        DB::beginTransaction();
        try {
            //dd($request->all());
            $introduce = new Introduce();
            if ($request->input('id')) {
                $introduce = Introduce::where('id', $request->input('id'))->first();
            }
            $introduce->title = $request->input('title');
            $introduce->description = $request->input('description');
            $introduce->index = $request->input('index');
            $introduce->type = $request->input('type');
            if ($request->input('relate_id'))
                $introduce->relate_id = $request->input('relate_id');
            if ($request->input('link'))
                $introduce->link = $request->input('link');
            $introduce->save();
            if ($request->file('photo')) {
                $logo = optional($request->file('photo'))->store('public/introduct_img');
                $logo = str_replace("public/", "", $logo);
                Img::updateOrCreate(
                    [
                        'product_id' => $introduce->id,
                        'type' => 8,
                        'img_index' => 1
                    ],
                    ['path' => $logo]
                );
            }
            DB::commit();
            return Redirect::route('admin.introduce.banner');
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => $e->getMessage()]);
        }
    }
    public function update(Request $request)
    {
        if ($request->input('id')) {
            $discount = Discount::get()->toArray();
            $introduce = Introduce::with('Img')->where('id', $request->input('id'))->get()->toArray()[0];
            //dd($introduce);
            return view('admin.introduce.edit', ['typenav' => $this->typenav, 'discount' => $discount, 'type' => $introduce['type'], 'index' => $introduce['index'], 'olddata' => $introduce, 'isedit' => 1]);
        }
        return Redirect::route('admin.introduce.banner');
    }
    public function updateActive(Request $request)
    {
        Artisan::call('cache:clear');
        try {
            if (!$request->input('id') || !$request->input('status')) {
                throw new Exception("Thay đổi thất bại", 30);
            } else {
                Introduce::where('id', $request->input('id'))->update([
                    'active' => $request->input('status')
                ]);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }
}
