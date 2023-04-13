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
                <span class="bg-secondary pe-3">Danh sách phân loại</span>
            </h5>
            <a href="{{ route('admin.type.create') }}" type="submit" class="btn btn-primary mb-3">Thêm</a>
            <div class="custom-datatable bg-light p-30 table-responsive">
                <table id="classify-table" class="table table-bordered text-center align-items-center">
                    <thead class="align-middle table-dark">
                        <tr>
                            <th>#</th>
                            <th>Ảnh</th>
                            <th>Tên Loại</th>
                            <th>Số sản phẩm thuộc loại</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @php
                            $i = 0;
                        @endphp
                        @forelse ($typenav as $item)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td class="itemimg"><img class="img-fluid img"
                                        src='{{ asset('storage/' . $item['img'][0]['path']) }}' alt=""></td>
                                <td>{{ $item['name'] }}</td>
                                <td class="itemcount">{{ $item['product_count'] }}</td>
                                <td class="custom">
                                    <a href="{{ route('admin.type.update', ['id' => $item['id']]) }}"
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
                                    <button data-toggle="modal" data-target="#modalcategory" data-id={{ $item['id'] }}
                                        type="button"
                                        class="btn btn-info btn-sm shadow-none rounded-0 mb-2 d-block buttonchange detail"
                                        data-status=0>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                                            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                            <path
                                                d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                        </svg> Chi tiết phân loại
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
@section('modal')
    <div class="modal fade" id="modalcategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm Phân Loại</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formcategory" action="{{ route('admin.category.store') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="text" class="d-none" name="type" id="idtype">
                        <input type="text" class="d-none" name="id" id="idupdate">
                        <div class="col-md-6 form-group mb-4">
                            <label>Tên Loại</label>
                            <input class="form-control shadow-none rounded-0" id="namecategory" type="text"
                                name="name">
                            <span class="text-danger errorname"></span>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-8">
                                <label>Ảnh</label>
                                <input type="file" class="form-control shadow-none rounded-0 file-img" name="photo"
                                    id="photocategory">
                                <span class="text-danger errorphoto"></span>
                            </div>
                            <div class="col-md-4 form-group">
                                <img style="width:100px; height:100%;" src="" class="imgchange" id="imgcategory" />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary closecategory" data-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary addcategory">Thêm</button>
                        <button type="button" class="btn btn-primary updatecategory d-none">Cập nhật</button>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody class="bodycate">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- category update --}}
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        var count = 0
        var upload_img = '';
        $(".file-img").change(function() {
            let img = $(this).val()
            let e = $(this)
            console.log(img)
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                upload_img = reader.result;
                console.log(upload_img)
                $('.imgchange').attr("src", upload_img)
            })
            reader.readAsDataURL(this.files[0])
            console.log($(this).val())
        })
        $('.closecategory').click(function() {
            resetform()
        })

        function resetform() {
            $('#photocategory').val(null)
            $('.imgchange').attr('src', '')
            $('#namecategory').val(null)
            $('#idupdate').val(null)
        }
        $('.addcategory').click(function() {
            const obj = $("#formcategory");
            const formData = new FormData(obj[0]);
            var actionUrl = obj.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                enctype: 'multipart/form-data',
                success: function(data) {
                    console.log(data)
                    count = count + 1
                    let inner = ` <tr class="table-bordered item-${data['id']}">
                                <th>${count}</th>
                                 <td class="itemimg"><img class="img-fluid img" src='{{ asset('storage/') }}/${data['img'][0]?data['img'][0]['path']:''}' alt=""></td>
                                <th class="nameitem">${data.name}</th>
                                <th class="buttoncate">
                                <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange update" data-id=${data['id']}>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg> Cập nhật
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove" data-id=${data['id']}>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg> Xóa
                                </button>
                                </th>
                            </tr>`
                    console.log(inner)
                    $('.bodycate').append(inner)
                    $('.update').unbind('click')
                    $('.update').click(function() {
                        let id = $(this).attr('data-id')
                        let name = $(this).parent().prev().text()
                        let img = $(this).parent().prev().prev().find('img').attr('src')
                        console.log(id, name, img)
                        $('.imgchange').attr('src', img)
                        $('#namecategory').val(name)
                        $('#idupdate').val(id)
                        $('.addcategory').addClass('d-none')
                        $('.updatecategory').removeClass('d-none')
                    })
                    $('.remove').unbind('click')
                    // $('.update').click(function() {
                    //     let id = $(this).attr('data-id')
                    //     let name = $(this).parent().prev().text()
                    //     let img = $(this).parent().prev().prev().attr('src')
                    //     $('.addcategory').addClass('d-none')
                    //     $('.updatecategory').removeClass('d-none')
                    //     $('#idupdate').val(id)
                    //     console.log(id, name, img)
                    // })
                    $('.remove').click(function() {
                        let id = $(this).attr('data-id')
                        let e = $(this)
                        $.ajax({
                            url: "{{ route('admin.type.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id
                            },
                            type: 'DELETE',
                            success: function(response) {
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
                    resetform()
                }
            });
        })
        $('.updatecategory').click(function() {
            let id = $(this).attr('data-id')
            const obj = $("#formcategory");
            const formData = new FormData(obj[0]);
            var actionUrl = obj.attr('action');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.category.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                enctype: 'multipart/form-data',
                success: function(data) {
                    console.log(data)
                    $('.item-' + data['id']).find('.itemimg img').attr('src',
                        "{{ asset('storage') }}" + '/' + data['img'][0]['path'])
                    $('.item-' + data['id']).find('.nameitem').text(data['name'])
                    $('.addcategory').removeClass('d-none')
                    $('.updatecategory').addClass('d-none')
                    resetform()
                }
            });
        })
        $('.remove').click(function() {
            let id = $(this).attr('data-id')
            let e = $(this)
            $.ajax({
                url: "{{ route('admin.type.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: id
                },
                type: 'DELETE',
                success: function(response) {
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
        $('.detail').click(function() {
            let id = $(this).attr('data-id');
            $('#idtype').val(id);
            $.ajax({
                url: "{{ route('admin.category.listbyid') }}",
                data: {
                    id: id
                },
                type: 'GET',
                success: function(response) {
                    console.log(response)
                    inner = ''
                    response.forEach((element, index) => {
                        count = index
                        inner += ` <tr class="table-bordered item-${element['id']}">
                                <th>${++index}</th>
                                <td class="itemimg"><img class="img-fluid img" src='{{ asset('storage/') }}/${element['img'][0]?element['img'][0]['path']:''}' alt=""></td>
                                <th class="nameitem">${element.name}</th>
                                <th class="buttoncate">
                                <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange update" data-id=${element['id']}>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                                </svg> Cập nhật
                                </button>
                                <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove" data-id=${element['id']}>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg> Xóa
                                </button>
                                </th>
                            </tr>`
                    });
                    $('.bodycate').empty()
                    $('.bodycate').append(inner)
                    $('.update').unbind('click')
                    $('.update').click(function() {
                        let id = $(this).attr('data-id')
                        let name = $(this).parent().prev().text()
                        let img = $(this).parent().prev().prev().find('img').attr('src')
                        console.log(id, name, img)
                        $('.imgchange').attr('src', img)
                        $('#namecategory').val(name)
                        $('#idupdate').val(id)
                        $('.addcategory').addClass('d-none')
                        $('.updatecategory').removeClass('d-none')
                    })
                    $('.remove').unbind('click')
                    $('.remove').click(function() {
                        let e = $(this)
                        let id = $(this).attr('data-id')
                        $.ajax({
                            url: "{{ route('admin.category.delete') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                id: id
                            },
                            type: 'DELETE',
                            success: function(response) {
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

                },
                error: function(response) {}
            });
        })
    </script>
@endpush
