@extends('layout.master')
@section('content')
    @php
        use App\Enums\RoleEnum;
    @endphp
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-4">
                <h2 class="text-center my-4">Tạo Lại Mật Khẩu</h2>
                <form action="{{ route('auth.sendconfirm') }}" method="POST" class="d-flex flex-column">
                    @csrf
                    <input class="form-control rounded-0 shadow-none text-box single-line" id="email" name="email"
                        placeholder="Email" type="text" value="" />
                    <span class="field-validation-valid text-danger mb-3">
                        @if ($errors->has('email'))
                            {{ $errors->first('email') }}
                        @endif
                    </span>
                    </span>
                    <button class="btn btn-primary rounded-0 shadow-none mb-3">Gửi</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
