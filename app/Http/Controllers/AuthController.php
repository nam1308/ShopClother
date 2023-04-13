<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassAccountRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Jobs\SendEmail;
use App\Models\Type;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    private $redirectTo;
    public function __construct()
    {
        // $this->typenav = Type::with('Img', 'Categories')->withCount('Product')
        //     ->get()->toArray();
        parent::__construct();
    }
    public function login(Request $request)
    {
        $loginPath  = url('auth/register');
        $previous   = url()->previous();
        $myPath = url('/');
        if ($previous == $loginPath || $previous == url('auth/') || $previous == url('auth/update-account') || $previous == url('auth/reset-password') || $previous == url('auth/update-by-email')) {
            session(['link' => $myPath]);
        } else {
            session(['link' => $previous]);
        }
        //dd(session('link'));
        return view('auth.login', ['typenav' => $this->typenav]);
    }
    public function register(Request $request)
    {

        $listroles = DB::table('permissions')->pluck('name', 'id');
        return view('auth.register', ['typenav' => $this->typenav, 'listroles' => $listroles]);
    }
    public function registering(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            Artisan::call('cache:clear');
            $password = Hash::make($request->password);
            $roles     = $request->input('role');
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $password,
                'phone' => $request->input('phone'),
                'username' => $request->input('username') ? $request->input('username') : $request->email
            ]);
            $user->syncRoles($roles);
            $rolePermissions = DB::table('role_has_permissions')->whereIn('role_id', [$roles])->get()->pluck('permission_id')->unique()->toArray();
            $user->permissions()->sync($rolePermissions);
            // RegisterEvent::dispatch($user);
            SendEmail::dispatch('Chúc mừng bạn đã đăng kí tài khoản thành công', $user);
            // Auth::login($user);
            DB::commit();
            return redirect()->route('auth.login');
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => 'Đăng kí thất bại']);
        }
    }
    public function logout(Request $request)
    {
        User::where('id', auth()->user()->id)->update([
            'remember_token' => null
        ]);
        Auth::logout();
        Artisan::call('cache:clear');
        $request->session()->invalidate();

        return redirect()->route('index');
    }
    public function username()
    {
        return 'username';
    }
    public function signin(LoginRequest $request)
    {
        Artisan::call('cache:clear');
        $remember = $request->input('remember') ? true : false;
        if (Auth::attempt(['username' => $request->input('email'), 'password' => $request->input('password')], $remember)) {
            return redirect(session('link'));
        } else
            return Redirect::back()->withErrors(['msg' => 'Đăng nhập thất bại, có thể bạn đã nhập sai tài khoản hoặc mật khẩu vui lòng thử lại']);
        // $user = User::where('username', $request->input('email'))->first();
        // dd(Hash::check($request->input('password'), $user->password));
        //Auth::login();
    }
    public function updateAccont(Request $request)
    {
        return view('auth.changepassword', ['typenav' => $this->typenav]);
    }
    public function update(ChangePassAccountRequest $request)
    {
        Artisan::call('cache:clear');
        $user = auth()->user();
        if (Hash::check($request->input('password'), $user->password)) {
            $password = Hash::make($request->input('newpassword'));
            User::where('id', $user->id)->update([
                'password' => $password
            ]);
            return redirect()->route('auth.login');
        } else {
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => 'Thất bại, có thể sai mật khẩu hoặc tài khoản hãy thử lại']);
        }
    }
    public function updateByEmail(Request $request)
    {
        Artisan::call('cache:clear');
        $request->validate([
            'email' => 'required',
            'newpassword' => 'required',
            'newpassword_confirmation' => 'required',
            'token_email' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $exit = 0;
            $exit = DB::table('password_resets')->where('token', $request->input('token_email'))->where('email', $request->input('email'))->count();
            if ($exit) {
                $password = Hash::make($request->input('newpassword'));
                User::where('email', $request->input('email'))->whereNull('deleted_at')->whereNull('provider_id')->update([
                    'password' => $password
                ]);
                DB::table('password_resets')->where('token', $request->input('token_email'))->where('email', $request->input('email'))->delete();
                DB::commit();
                // dd($password);
                return redirect()->route('auth.login');
            } else {
                throw new Exception("Thay đổi thất bại", 30);
            }
        } catch (Throwable $e) {
            DB::rollBack();
            return Redirect::back()->withInput($request->input())->withErrors(['msg' => 'Thay đổi thất bại']);
        }
    }
    public function forgotPassword(Request $request)
    {
        //   dd(md5('kkk' . now()));
        return view('auth.sendmailtoconfirm', ['typenav' => $this->typenav]);
    }
    public function sendConfirm(Request $request)
    {
        if ($request->input('email')) {
            $count = User::where('email', $request->input('email'))->whereNull('provider_id')->get()->count();
            if ($count) {
                $token = md5($request->input('email') . now());
                DB::table('password_resets')->insert([
                    'email' => $request->input('email'),
                    'token' => $token
                ]);
                SendEmail::dispatch('Vui lòng nhấn vào đây để lấy lại mật khẩu', null, 2, $request->input('email'), $token);
                return Redirect::route('index');
            }
        }
        return Redirect::back()->withInput($request->input())->withErrors(['email' => 'Email không hợp lệ vui lòng nhập lại email bạn đã đăng kí trong tài khoản của bạn!']);
    }
    public function resetPassword(Request $request)
    {
        // dd($request->input('token'));
        return view('auth.resetpassword', ['email' => $request->input('email'), 'typenav' => $this->typenav, 'token' => $request->input('token')]);
    }
    public function redirectToProvider($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (Throwable $e) {
            return redirect()->route('auth.login');
        }
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $data = self::handleSocialLogin($provider, $user);
        if ($data == 0) {
            return Redirect::back()->withErrors(['msg' => 'Đăng nhập thất bại']);
        } else {
            return Redirect::route('index');
        }
    }

    public function handleSocialLogin($provider, $userProvider)
    {
        try {
            $providerId = $userProvider->id;
            $user = User::where('provider_id', $providerId)->where('provider', $provider)->first();
            if (!$user) {
                $user = new User();
                $user->name = $userProvider->name ? $userProvider->name : $userProvider->email;
                $user->email = $userProvider->email;
                $user->provider_id = $userProvider->id;
                $user->provider = $provider;
                $user->password = Hash::make(rand());
                $user->phone = isset($userProvider->phone) ? $userProvider->phone : 0;
                $user->save();
                $role = DB::table('roles')->where('name', 'like', '%' . 'customer' . '%')->first();
                $user->syncRoles($role->id);
                $rolePermissions = DB::table('role_has_permissions')->whereIn('role_id', [$role->id])->get()->pluck('permission_id')->unique()->toArray();
                $user->permissions()->sync($rolePermissions);
            }
            $userId = $user->id;
            Artisan::call('cache:clear');
            Auth::loginUsingId($userId, true);
            return 1;
        } catch (Throwable $e) {
            return 0;
        }
    }
    public function redirectRoute()
    {
        return redirect()->route('index');
    }
}
