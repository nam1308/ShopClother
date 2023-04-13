@extends('layout.master')
@section('content')
    @php
        use App\Enums\RoleEnum;
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="text-center my-4">Đăng ký</h2>
                <form action="{{ route('auth.registering') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="username" name="username"
                        placeholder="Tên đăng nhập" type="text" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('username'))
                            {{ $errors->first('username') }}
                        @endif
                    </span>
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="name" name="name"
                        placeholder="Tên người dùng" type="text" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('name'))
                            {{ $errors->first('name') }}
                        @endif
                    </span>
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="email" name="email"
                        placeholder="Email" type="text" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('email'))
                            {{ $errors->first('email') }}
                        @endif
                    </span>
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="phone" name="phone"
                        placeholder="Số điện thoại" type="text" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('phone'))
                            {{ $errors->first('phone') }}
                        @endif
                    </span>
                    <input class="form-control rounded-0 shadow-none" id="password" name="password" placeholder="Mật khẩu"
                        type="password" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </span>
                    <select
                        class="form-control rounded-0 shadow-none {{ auth()->check()? (auth()->user()->hasDirectPermission('Admin')? '': 'd-none'): 'd-none' }}"
                        id="role" name="role" placeholder="Vai Trò" type="text">
                        @foreach ($listroles as $key => $item)
                            <option value={{ $key }} {{ $key == 2 ? 'selected="selected"' : '' }}>{{ $item }}
                            </option>
                        @endforeach
                    </select>
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('permiss'))
                            {{ $errors->first('permiss') }}
                        @endif
                    </span>
                    <button class="btn btn-primary rounded-0 shadow-none mb-3">Đăng ký</button>
                </form>
                <p class="text-center">Bạn đã có tài khoản? <a href="{{ route('auth.login') }}" class="text-primary">Đăng
                        nhập</a></p>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
