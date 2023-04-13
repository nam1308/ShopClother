@extends('layout.master')
@section('content')
    <form action="{{ route('orders.index') }}" id="myForm" method="post" class="d-none">
        @csrf
        <input type="text" name="id" value={{ $id }}>
        <input type="submit" style="background: none;border: none;" class="nav-link" value="Hóa Đơn">
    </form>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        document.forms["myForm"].submit();
    </script>
@endpush
