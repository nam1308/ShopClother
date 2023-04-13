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
    </style>
@endpush
@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid bg-secondary">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 100px">
            <h1 class="font-weight-semi-bold text-uppercase">Hóa Đơn Nhập</h1>
        </div>
    </div>
    <div class="container-fluid bg-secondary">
        <a href="{{ route('admin.orderimport.create') }}" type="submit" class="btn btn-primary mb-3 ml-5">Thêm</a>
    </div>
    <!-- Page Header End -->
    <table class="table container">
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
                <th scope="col" class="fix text-center"></th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 0;
            @endphp
            @forelse ($orders as $item)
                <tr class="text-center">
                    <td scope="col">{{ ++$i }}</td>
                    <td scope="col">{{ $item['name'] }}</td>
                    <td scope="col">{{ $item['email'] }}</td>
                    <td scope="col">{{ $item['address'] }}</td>
                    <td scope="col">{{ $item['created_at'] }}</td>
                    <td scope="col">{{ $item['quantity'] }}</td>
                    <td scope="col">{{ $item['price'] }}</td>
                    <td scope="col">{{ $item['ship'] }}</td>
                    <td class=" d-flex justify-content-center">
                        {{-- <button type="button" class="btn btn-warning buttondetail" style="" data-id={{$item['id']}} data-toggle="modal" data-target="#modalbrand">Chi Tiết</button> --}}
                        <a class="buttondetail detail" style="margin-right:10px" data-id={{ $item['id'] }}
                            data-toggle="modal" data-target="#modalbrand"><svg xmlns="http://www.w3.org/2000/svg"
                                width="16" height="16" fill="currentColor" class="bi bi-eye-fill"
                                viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                            </svg></a>
                        <a class="delete" style="margin-right:10px" data-id={{ $item['id'] }}><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path
                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg></a>

                        {{-- <a href="{{ route('orders.updateinfor', ['id' => $item['id']]) }}" class="edit"
                            data-id={{ $item['id'] }}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path
                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                            </svg></a> --}}
                    </td>

                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
@endsection
@section('modal')
    <div class="modal fade" id="modalbrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm Nhãn Hiệu</h5>
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
                    url: "{{ route('admin.orderimport.orderdetail') }}",
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
        </script>
    @endpush
