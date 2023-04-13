@extends('layout.master')
@push('css')
    <style>
        .img {
            width: 172px;
            height: 70px;
        }

        .menu {
            padding: 0px !important;
        }

        .menu ul {
            background-color: #FFD333;
            padding: 0px !important;
            border-radius: 3px;
        }

        .menu ul li a {
            color: white;
        }

        p {
            margin: 0px !important;
        }

        li:hover {
            background-color: #ffc107;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row" id="accordion">
            <div class="col-2 menu">
                <ul class="nav d-flex flex-column">
                    <li class="nav-item" id="quanly">
                        <a class="nav-link text-center d-flex align-items-center justify-content-center mt-3"
                            data-toggle="collapse" href="#main" role="button" aria-expanded="true" aria-controls="main">
                            <p>Quảng cáo chính</p>
                        </a>
                    </li>
                    <li class="nav-item " id="hoadon">
                        <a class="nav-link text-center d-flex align-items-center justify-content-center mt-3"
                            data-toggle="collapse" href="#discont" role="button" aria-expanded="false"
                            aria-controls="discont">
                            <p>Quảng cáo khuyến mại</p>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-10">
                <div class="col-12 collapse" id="main" data-parent="#accordion">
                    <div class="col-12">
                        <h4>Quảng cáo chính</h4>
                        <a href="{{ route('admin.introduce.edit', ['type' => 2]) }}" type="submit"
                            class="btn btn-primary mb-3">Thêm</a>
                    </div>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Đường link</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($main as $item)
                                <tr class="text-center">
                                    <td><img class="img"
                                            src="{{ asset('storage') . '/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '') }}"
                                            alt="">
                                    </td>
                                    <td>{{ $item['title'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['link'] }}</td>
                                    <td> <a href="{{ route('admin.introduce.update', ['id' => $item['id']]) }}"
                                            class="btn btn-primary btn-sm mb-2 d-block buttonchange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                <path
                                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                            </svg> Chỉnh sửa
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove"
                                            data-id={{ $item['id'] }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                            </svg> Xóa
                                        </a>
                                        <select name="" id="" class="change-active custom-select"
                                            data-id={{ $item['id'] }}>
                                            <option {{ $item['active'] == 1 ? 'selected' : '' }} value=1>Ẩn</option>
                                            <option {{ $item['active'] == 2 ? 'selected' : '' }} value=2>Hiện</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="col-12 collapse" id="discont" data-parent="#accordion">
                    <div class="col-12">
                        <h4>Quảng cáo khuyến mại</h4>
                        <a href="{{ route('admin.introduce.edit', ['type' => 1]) }}" type="submit"
                            class="btn btn-primary mb-3">Thêm</a>
                    </div>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Mô tả</th>
                                <th scope="col">Đường link</th>
                                <th scope="col">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($discount as $item)
                                <tr class="text-center">
                                    <td><img class="img"
                                            src="{{ asset('storage') . '/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '') }}"
                                            alt="">
                                    </td>
                                    <td>{{ $item['title'] }}</td>
                                    <td>{{ $item['description'] }}</td>
                                    <td>{{ $item['link'] }}</td>
                                    <td> <a href="{{ route('admin.introduce.update', ['id' => $item['id']]) }}"
                                            class="btn btn-primary btn-sm mb-2 d-block buttonchange">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                <path
                                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                            </svg> Chỉnh sửa
                                        </a>
                                        <a type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove"
                                            data-id={{ $item['id'] }}>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                            </svg> Xóa
                                        </a>
                                        <select name="" id="" class="change-active custom-select"
                                            data-id={{ $item['id'] }}>
                                            <option {{ $item['active'] == 1 ? 'selected' : '' }} value=1>Ẩn</option>
                                            <option {{ $item['active'] == 2 ? 'selected' : '' }} value=2>Hiện</option>
                                        </select>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.change-active').change(function() {
            let id = $(this).attr('data-id')
            let status = $(this).val()
            $.ajax({
                url: "{{ route('admin.introduce.updateactive') }}",
                type: 'PUT',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id,
                    status: status
                },
                success: function(response) {

                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Đã xảy ra lỗi',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
    </script>
@endpush
