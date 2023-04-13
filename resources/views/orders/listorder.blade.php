@extends('layout.master')
@php
use App\Enums\StatusOrderEnum;
@endphp
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            height: 36px;
            border-radius: 0px;
        }

        .table-detail {
            width: 100%;
        }

        .img {
            width: 100px;
        }

        .modal-dialog {
            max-width: 661px !important;
            margin: 1.75rem auto;
        }

        .error {
            color: red !important;
        }

        .table th,
        .table td {
            padding: 20px 5px !important;
        }

        .pagination {
            display: flex;
            justify-content: center;
        }
    </style>
@endpush
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="font-weight-semi-bold text-uppercase">Hóa Đơn</h1>
        </div>
        <a href="{{ route('orders.export', ['id' => $iduser]) }}" type="submit" class="btn btn-primary mb-3 ml-5">Export</a>
    </div>
    <!-- Page Header End -->

    <table class="table container table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Tên Người Nhận</th>
                <th scope="col" class="text-center">Email</th>
                <th scope="col" class="text-center">Địa Chỉ</th>
                <th scope="col" class="text-center">Ngày Đặt Hàng</th>
                <th scope="col" class="text-center">Số Lượng</th>
                <th scope="col" class="text-center">Đơn Giá</th>
                <th scope="col" class="text-center">Phí Vận Chuyển</th>
                <th scope="col" class="text-center">Tình Trạng</th>
                <th scope="col" class="fix text-center"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @forelse ($orders as $item)
                <tr>
                    <td scope="col" class="align-middle text-center">{{ ++$i }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['name'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['email'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['address'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['created_at'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['quantity'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['price'] }}</td>
                    <td scope="col" class="align-middle text-center">{{ $item['ship'] }}</td>
                    <td scope="col" class="align-middle text-center">
                        <select name="status" class="status"
                            {{ auth()->user()->hasDirectPermission('Admin')? '': 'disabled' }} data-id={{ $item['id'] }}>
                            @foreach (StatusOrderEnum::getValues() as $itemsta)
                                <option {{ $item['status'] == $itemsta ? 'selected' : '' }} value="{{ $itemsta }}">
                                    {{ StatusOrderEnum::getStatus($itemsta) }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td scope="col" class="align-middle">
                        {{-- <button type="button" class="btn btn-warning buttondetail" style="" data-id={{$item['id']}} data-toggle="modal" data-target="#modalbrand">Chi Tiết</button> --}}
                        <a class="btn btn-primary btn-sm shadow-none rounded-0 w-100 mb-1 buttondetail detail primary"
                            style="margin-right:10px" data-id={{ $item['id'] }} data-toggle="modal"
                            data-target="#modalbrand">Xem</a>
                        @if (auth()->check() && $item['status'] == 1)
                            <a class="btn btn-danger btn-sm shadow-none rounded-0 w-100 mb-1 delete"
                                style="margin-right:10px" data-id={{ $item['id'] }}>Xóa</a>
                        @endif
                        <form action="{{ route('orders.updateinfor') }}" method="POST">
                            @csrf
                            @if ($admincheck == 1)
                                <input type="text" name="admincheck" class="d-none" value={{ $admincheck }}>
                            @endif
                            <input type="text" name="id" class="d-none" value={{ $item['id'] }}>
                            <input type="text" name="iduser" class="d-none" value={{ $iduser }}>
                            <button class="btn btn-success btn-sm shadow-none rounded-0 w-100 mb-1 edit">Sửa</button>
                        </form>
                        <a class="btn btn-info btn-sm shadow-none rounded-0 w-100 mb-1"
                            href="{{ route('orders.print', ['id' => $item['id']]) }}" style="margin-right:10px"
                            data-id={{ $item['id'] }}>In</a>
                    </td>

                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    {{ $orders->links() }}

@endsection
@section('modal')
    <div class="modal fade" id="modalbrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Chi tiết hóa đơn</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table-detail text-center table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên Sản Phẩm</th>
                                <th scope="col">Màu</th>
                                <th scope="col">Size</th>
                                <th scope="col">Số Lượng</th>
                                <th scope="col">Đơn Giá</th>
                            </tr>
                        </thead>
                        <tbody id="listspdetail">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $('.buttondetail').click(function() {
                let id = $(this).attr('data-id')
                $.ajax({
                    url: "{{ route('orders.detail') }}",
                    type: 'GET',
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        console.log(response)
                        let inner = ''
                        response.forEach(element => {
                            inner += `<tr class='text-center itemproduct'>
                    <td><img src="{{ asset('storage') }}/${element.path}" class='img' alt=""></td>
                    <td>${element.name}</td>
                    <td>${element.sizename}</td>
                    <td>${element.colorname}</td>
                    <td>${element.quantity}</td>
                    <td>${element.totalPrice}</td>
                    </tr>
                    `
                        });
                        console.log(inner)
                        document.getElementById('listspdetail').innerHTML = inner
                    },
                    error: function(response) {

                    }
                });
            })
            $('.delete').click(function() {
                let id = $(this).attr('data-id')
                let ele = $(this)
                $.ajax({
                    url: "{{ route('orders.delete') }}",
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                    },
                    success: function(response) {
                        ele.parent().parent().remove()
                    },
                    error: function(response) {

                    }
                });
            })
            $('.status').change(function() {
                let status = $(this).val()
                let id = $(this).attr('data-id')
                console.log('data', status, id)
                $.ajax({
                    url: "{{ route('orders.updatestatus') }}",
                    type: 'PUT',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response)
                    },
                    error: function(response) {

                    }
                });
            })
        </script>
    @endpush
