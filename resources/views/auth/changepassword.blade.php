@extends('layout.master')
@section('content')
    @php
        use App\Enums\RoleEnum;
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="text-center my-4">Cập nhật tài khoản</h2>
                <form action="{{ route('auth.update') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    <label for="">Tên tài khoản</label>
                    <input class="form-control rounded-0 shadow-none text-box single-line"
                        value="{{ auth()->user()->username }}" id="username" name="username" readonly="readonly"
                        placeholder="Tên đăng nhập" type="text" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('username'))
                            {{ $errors->first('username') }}
                        @endif
                    </span>
                    <label for="">Mật khẩu cũ</label>
                    <input class="form-control rounded-0 shadow-none" id="password" name="password" placeholder="Mật khẩu"
                        type="password" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('password'))
                            {{ $errors->first('password') }}
                        @endif
                    </span>
                    <label for="">Mật khẩu mới</label>
                    <input class="form-control rounded-0 shadow-none" id="newpassword" name="newpassword"
                        placeholder="Mật khẩu" type="password" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('newpassword'))
                            {{ $errors->first('newpassword') }}
                        @endif
                    </span>
                    <label for="">Xác nhận mật khẩu mới</label>
                    <input class="form-control rounded-0 shadow-none" id="newpassword_confirmation"
                        name="newpassword_confirmation" placeholder="Mật khẩu" type="password" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('newpassword_confirmation'))
                            {{ $errors->first('newpassword_confirmation') }}
                        @endif
                    </span>
                    <button class="btn btn-primary rounded-0 shadow-none mb-3">Câp nhật</button>
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('msg'))
                            {{ $errors->first('msg') }}
                        @endif
                    </span>
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
