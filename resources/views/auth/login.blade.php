@extends('layout.master')
@push('css')
    <style>
        .error {
            color: red;
        }

        #customBtn {
            display: inline-block;
            background: white;
            color: #444;
            width: 190px;
            border-radius: 5px;
            border: thin solid #888;
            box-shadow: 1px 1px 1px grey;
            white-space: nowrap;
        }

        #customBtn:hover {
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }

        .icon {
            display: inline-block;
            vertical-align: middle;
            width: 1.5rem;
            height: 1.5rem;
            margin: .5rem 0;
            margin-left: .5rem;
        }

        span.buttonText {
            display: inline-block;
            vertical-align: middle;
            padding-left: 1rem;
            padding-right: 42px;
            font-size: 14px;
            font-weight: bold;
            /* Use the Roboto font that is loaded in the <head> */
            font-family: 'Roboto', sans-serif;
        }
    </style>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="text-center my-4">Đăng nhập</h2>
                <form action="{{ route('auth.signin') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    <input type="text" name="email" class="form-control rounded-0 shadow-none mb-3">
                    @if ($errors->has('email'))
                        <div class="error">{{ $errors->first('email') }}</div>
                    @endif
                    <input type="password" name="password" class="form-control rounded-0 shadow-none mb-3">
                    @if ($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif
                    <div class="d-flex align-items-center mb-3">
                        <input type="checkbox" class="mr-1" name="remember" id="remember">
                        <p class="text_remember" style="margin-bottom: 0;">Remmember</p>
                    </div>

                    <button type="submit" class="btn btn-primary rounded-0 shadow-none mb-3">Đăng nhập</button>
                </form>
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif

                <p class="text-center"><a href="{{ route('auth.fogotpassword') }}" class="text-primary">Quên
                        mật khẩu, </a>Bạn chưa có tài khoản? <a href="{{ route('auth.register') }}"
                        class="text-primary">Đăng ký</a></p>
                <a id="customBtn" class="customGPlusSignIn" href="{{ route('social', ['social' => 'github']) }}">
                    <img class="icon" src="{{ asset('/img/25231.png') }}">
                    <span class="buttonText">Login with Github</span>
                </a>
                <a id="customBtn" class="customGPlusSignIn" href="{{ route('social', ['social' => 'google']) }}">
                    <img class="icon" src="{{ asset('/img/google.png') }}">
                    <span class="buttonText">Login with Google</span>
                </a>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
