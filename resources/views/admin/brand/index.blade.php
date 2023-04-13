@extends('layout.master')
@push('css')
    <style>
        .img {
            width: 172px;
            height: 100px;
        }

        .itemimg {
            width: 20%;
            height: 50%;
        }

        .itemcount {
            width: 11%;
        }

        .custom {
            width: 20%;
        }

        .buttonchange {
            width: 100%;
        }

        .buttoncate {
            width: 30%;
        }
    </style>
@endpush
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Danh sách nhãn hàng</span>
            </h5>
            <div class="custom-datatable bg-light p-30 table-responsive">
                <a href="{{ route('admin.brand.create') }}" type="submit" class="btn btn-primary mb-3">Thêm</a>
                <table id="classify-table" class="table table-bordered text-center align-items-center">
                    <thead class="align-middle table-dark">
                        <tr>
                            <th>#</th>
                            <th>Ảnh</th>
                            <th>Tên phân loại</th>
                            <th>Quốc gia</th>
                            <th>Số lượng sản phẩm</th>
                            <th>Mô tả</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $i = 0;
                        @endphp
                        @forelse ($brands as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="itemimg">
                                    <img class="img-fluid img"
                                        src='{{ asset('storage/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '')) }}'
                                        alt="">
                                </td>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['country'] }}</td>
                                <td class="itemcount">{{ $item['product_count'] }}</td>
                                <td>{{ $item['description'] }}</td>
                                <td class="custom">
                                    <a href="{{ route('admin.brand.update', ['id' => $item['id']]) }}"
                                        class="btn btn-primary btn-sm mb-2 d-block buttonchange">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg> Chỉnh sửa phân loại
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove"
                                        data-id={{ $item['id'] }}>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                        </svg> Xóa phân loại
                                    </button>

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.remove').click(function() {
            let id = $(this).attr('data-id')
            let e = $(this)
            $.ajax({
                type: "DELETE",
                url: "{{ route('admin.brand.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Xóa thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    e.parent().parent().remove()
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.error,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
    </script>
@endpush
