@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .img {
            width: 100px;
            height: 100px;
        }

        .name {
            text-align: left;
        }
    </style>
@endpush
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Danh sách sản phẩm</span>
            </h5>
            <div class="custom-datatable bg-light p-30 table-responsive">
                <form action="{{ route('admin.product.create') }}" class="mb-3"> <button type="submit"
                        class="btn btn-primary rounded-0 shadow-none">Thêm sản phẩm</button></form>

                <table id="product-table" class="table table-bordered text-center">
                    <thead class="align-middle table-dark">
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá nhập</th>
                            <th>Giá bán</th>
                            <th>Phân loại</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($products as $item)
                            <tr>
                                <td>{{ $item['code'] }}</td>
                                <td class="name">
                                    <img src="{{ asset('storage') }}/{{ $item['img'][0]['path'] }}"
                                        class="product-info-img img">
                                    {{ $item['name'] }}
                                </td>
                                <td>{{ number_format($item['priceImport'], 0, ',', ',') }} Đ</td>
                                <td>{{ number_format($item['priceSell'], 0, ',', ',') }} Đ</td>
                                <td> {{ $item['type_product']['name'] }}</td>
                                <td class="align-middle d-flex flex-column">
                                    <a href="{{ route('admin.product.createdetail', ['id' => $item['id']]) }}"
                                        type="button" class="btn btn-primary btn-sm shadow-none rounded-0 mb-2">
                                        <i class="fas fa-plus me-2"></i>Thêm phân loại
                                    </a>
                                    <div>
                                        <button type="button"
                                            class="btn btn-danger btn-sm shadow-none rounded-0 mb-2 w-100 remove"
                                            data-id={{ $item['id'] }}>
                                            <i class="fas fa-trash me-2"></i>Xoá
                                        </button>
                                    </div>
                                    @if ($item['status'] == 1)
                                        <div>
                                            <button type="button"
                                                class="btn btn-danger tn-sm shadow-none rounded-0 w-100 mb-2 changestatus"
                                                data-id={{ $item['id'] }} data-status=0>
                                                <i class="fas fa-check me-2"></i>Ẩn
                                            </button>
                                        </div>
                                    @else
                                        <div>
                                            <button type="button"
                                                class="btn btn-success btn-sm shadow-none rounded-0 w-100 mb-2 changestatus"
                                                data-id={{ $item['id'] }} data-status=1>
                                                <i class="fas fa-check me-2"></i>Hiển thị
                                            </button>
                                        </div>
                                    @endif



                                </td>
                            </tr>
                        @empty
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.changestatus').click(function() {
            let status = $(this).attr('data-status')
            let id = $(this).attr('data-id')
            let element = $(this)
            $.ajax({
                url: "{{ route('admin.product.changstatus') }}",
                type: 'GET',
                data: {
                    id: id,
                    status: status
                },
                success: function(response) {
                    element.addClass("d-none")
                    if (parseInt(status) == 1) {
                        element.attr('class',
                            'btn btn-danger btn-sm shadow-none rounded-0 w-100 mb-2 changestatus')
                        element.attr('data-status', 0)
                        element.html(' <i class="fas fa-check me-2"></i>Ẩn')
                    } else {
                        element.attr('class',
                            'btn btn-success btn-sm shadow-none rounded-0 w-100 mb-2 changestatus')
                        element.attr('data-status', 1)
                        element.html('<i class="fas fa-check me-2"></i>Hiển thị')
                    }
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
        $('.remove').click(function() {
            let id = $(this).attr('data-id')
            let ele = $(this)
            $.ajax({
                url: "{{ route('admin.product.delete') }}",
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    ele.parent().parent().parent().remove()
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
    </script>
@endpush
