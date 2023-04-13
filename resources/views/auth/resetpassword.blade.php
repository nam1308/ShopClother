@extends('layout.master')
@section('content')
    @php
        use App\Enums\RoleEnum;
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="text-center my-4">Tạo Lại Mật Khẩu</h2>
                <form action="{{ route('auth.updatebyemail') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    <input class="form-control rounded-0 shadow-none text-box single-line mb-3 d-none" id="token_email"
                        name="token_email" type="text" value="{{ $token }}" readonly />
                    <input class="form-control rounded-0 shadow-none text-box single-line mb-3" id="email"
                        name="email" placeholder="Email" type="text" value="{{ $email }}" readonly />
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="newpassword"
                        name="newpassword" type="password" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('newpassword'))
                            {{ $errors->first('newpassword') }}
                        @endif
                    </span>
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="newpassword_confirmation"
                        name="newpassword_confirmation" type="password" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('newpassword_confirmation'))
                            {{ $errors->first('newpassword_confirmation') }}
                        @endif
                    </span>
                    <button class="btn btn-primary rounded-0 shadow-none mb-3">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
