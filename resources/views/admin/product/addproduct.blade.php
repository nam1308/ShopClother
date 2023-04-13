@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            height: 36px;
            border-radius: 0px;
        }

        .error {
            color: red !important;
        }
    </style>
@endpush
@section('content')
    <form action="{{ route('admin.product.store') }}" class="row px-xl-3" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Thông tin chung</span>
            </h5>
            <div class="bg-light p-30">
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif
                <div class="row">
                    {{-- @php
                  dd(old('type'))
                @endphp --}}
                    @if (isset($edit))
                        <input type="text" class="d-none" value={{ $product['id'] }} name="id">
                    @endif
                    <div class="col-md-4 form-group">
                        <label>Phân loại chính</label>
                        <select name="type" id="type" class="form-control"
                            data-old='{{ isset($edit) ? $product['type'] : old('type') }}'>
                            @if (old('type') != null || isset($edit))
                                <option value="{{ isset($edit) ? $product['type'] : old('type') }}">
                                    {{ $type->where('id', isset($edit) ? $product['type'] : intval(old('type')))->first()->name }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('type'))
                            <div class="error">{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary rounded-0 shadow-none mb-3" type="button" data-toggle="modal"
                            data-target="#modaltype">Thêm Loại</button>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Phân loại phụ</label>
                        <select name="category" class="form-control" id="category"
                            data-old="{{ isset($edit) ? $product['category'] : old('category') }}">
                            @if (old('category') != null || isset($edit))
                                <option value="{{ isset($edit) ? $product['category'] : old('category') }}">
                                    {{ $type->with([
                                            'Categories' => fn($query) => $query->where(
                                                'id',
                                                isset($edit) ? $product['category'] : intval(old('category')),
                                            ),
                                        ])->where('id', isset($edit) ? $product['type'] : intval(old('type')))->get()->first()->toArray()['categories'][0]['name'] }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('category'))
                            <div class="error">{{ $errors->first('category') }}</div>
                        @endif
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary rounded-0 shadow-none mb-3" type="button" data-toggle="modal"
                            data-target="#modalcategory">Thêm Phân Loại</button>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mã sản phẩm</label>
                        <input class="form-control shadow-none rounded-0" name="code"
                            value="{{ isset($edit) ? $product['code'] : old('code') }}" placeholder="AOKHOAC001">
                        @if ($errors->has('code'))
                            <div class="error">{{ $errors->first('code') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tên sản phẩm</label>
                        <input name="name" id="tensp" class="form-control shadow-none rounded-0"
                            value="{{ isset($edit) ? $product['name'] : old('name') }}"
                            placeholder="Áo sơ mi dài tay khử mùi">
                        @if ($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giá nhập</label>
                        <input name="priceImport" id="" class="form-control shadow-none rounded-0"
                            value="{{ isset($edit) ? $product['priceImport'] : old('priceImport') }}" placeholder="100000">
                        @if ($errors->has('priceImport'))
                            <div class="error">{{ $errors->first('priceImport') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giá bán</label>
                        <input name="priceSell" id="" class="form-control shadow-none rounded-0"
                            value="{{ isset($edit) ? $product['priceSell'] : old('priceSell') }}" placeholder="300000">
                        @if ($errors->has('priceSell'))
                            <div class="error">{{ $errors->first('priceSell') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giới Tính</label>
                        <select name="gender" id="" class="form-control shadow-none rounded-0">
                            <option>--Chọn--</option>
                            <option {{ (isset($edit) ? $product['gender'] : old('gender')) == 1 ? 'selected' : '' }}
                                value=1>Nam
                            </option>
                            <option {{ (isset($edit) ? $product['gender'] : old('gender')) == 2 ? 'selected' : '' }}
                                value=2>Nữ
                            </option>
                            <option {{ (isset($edit) ? $product['gender'] : old('gender')) == 3 ? 'selected' : '' }}
                                value=3>Không
                                phân biệt giới tính</option>
                        </select>
                        @if ($errors->has('gender'))
                            <div class="error">{{ $errors->first('gender') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mô tả ngắn</label>
                        <input name="description" id="" class="form-control shadow-none rounded-0"
                            value="{{ isset($edit) ? $product['description'] : old('description') }}"
                            placeholder="Áo sơ mi dài tay với chất liệu khử mùi, co giãn tự nhiên">
                        @if ($errors->has('description'))
                            <div class="error">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6 form-group row">
                        <div class="col-md-8 form-group">
                            <label>Ảnh đại diện</label>
                            <input class="form-control shadow-none rounded-0 file-img" name="photo" type="file">
                            @if ($errors->has('photo'))
                                <div class="error">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="col-md-4 form-group">
                            {{-- @php
                            dd($product['img'][0]['path']);
                        @endphp --}}
                            <img style="width:100px; height:100%;" class="imgchange"
                                src="{{ isset($edit) ? asset('storage/' . $product['img'][0]['path']) : '' }}"
                                id="imgtype" />
                        </div>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nhãn Hiệu</label>
                        <select name="brand" class="form-control" id="brand"
                            data-old="{{ isset($edit) ? $product['brand'] : old('brand') }}">
                            @if (old('brand') != null || isset($edit))
                                <option value="{{ isset($edit) ? $product['brand'] : old('brand') }}">
                                    {{ $brand->where('id', isset($edit) ? $product['brand'] : intval(old('brand')))->first()->name }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('brand'))
                            <div class="error">{{ $errors->first('brand') }}</div>
                        @endif
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary rounded-0 shadow-none mb-3" type="button" data-toggle="modal"
                            data-target="#modalbrand">Thêm Nhãn Hiệu</button>
                    </div>
                    <div class="col-md-3">
                        <label>Trạng thái</label>
                        <select class="form-control" name="status" id="TrangThai">
                            <option value=1
                                {{ (isset($edit) ? $product['status'] : old('status')) == 0 ? 'selected' : '' }}>Hiển thị
                            </option>
                            <option value=0
                                {{ (isset($edit) ? $product['status'] : old('status')) == 1 ? 'selected' : '' }}>Ẩn
                            </option>
                        </select>
                        @if ($errors->has('status'))
                            <div class="error">{{ $errors->first('status') }}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <label>Sản phẩm nổi bật</label>
                        <select class="form-control" name="featured" id="NoiBat">
                            <option value=0
                                {{ (isset($edit) ? $product['featured'] : old('featured')) == 0 ? 'selected' : '' }}>Có
                            </option>
                            <option value=1
                                {{ (isset($edit) ? $product['featured'] : old('featured')) == 1 ? 'selected' : '' }}>
                                Không</option>
                        </select>
                        @if ($errors->has('featured'))
                            <div class="error">{{ $errors->first('featured') }}</div>
                        @endif

                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary rounded-0 shadow-none mt-3">Lưu sản phẩm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('modal')
    {{-- Them Loai --}}
    <div class="modal fade" id="modaltype" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Thêm Loại</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="modal-body" id="formtype" action="{{ route('admin.type.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="1" name="api">
                    <div class="col-md-12 form-group mb-4">
                        <label>Tên Loại</label>
                        <input class="form-control shadow-none rounded-0 data" id="nametype" name="name"
                            type="text">
                        <span class="text-danger errorname"></span>
                    </div>
                    <div class="col-md-12 row form-group">
                        <div class="col-md-8 form-group">
                            <label>Ảnh</label>
                            <input class="form-control shadow-none rounded-0 data file-img" name="photo" id="phototype"
                                type="file">
                            <span class="text-danger errorphoto"></span>
                        </div>
                        <div class="col-md-4 form-group">
                            <img style="width:100px; height:100%;" class="imgchange" src="" id="imgtype" />
                        </div>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closetype" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="addtype">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Them Loai --}}
    {{-- Them phan loai --}}
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
                <form class="modal-body" id="formcategory" action="{{ route('admin.category.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="1" name="api">
                    <div class="col-md-12 form-group">
                        <label>Phân loại chính</label>
                        <select name="type" id="type_cate" style="width: 100%"
                            class="form-control shadow-none rounded-0">
                            <option value="0">--Chọn--</option>
                            @foreach ($type as $item)
                                <option value={{ $item['id'] }}>{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger errortype"></span>
                    </div>
                    <div class="col-md-12 form-group mb-4">
                        <label>Tên Loại</label>
                        <input class="form-control shadow-none rounded-0 data" id="namecategory" name="name"
                            type="text" disabled>
                        <span class="text-danger errorname"></span>
                    </div>
                    <div class="col-md-12 row form-group">
                        <div class="col-md-8 form-group">
                            <label>Ảnh</label>
                            <input class="form-control shadow-none rounded-0 data file-img" name="photo"
                                id="photocategory" type="file" disabled>
                            <span class="text-danger errorphoto"></span>
                        </div>
                        <div class="col-md-4 form-group">
                            <img style="width:100px; height:100%;" src="" class="imgchange" id="imgcategory" />
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closecategory" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary addcategory" disabled>Thêm</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Them phan loai --}}
    {{-- Them Nhan Hieu --}}
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
                <form class="modal-body" id="formbrand" action="{{ route('admin.brand.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="1" name="api">
                    <div class="col-md-12 form-group mb-4">
                        <label>Tên Loại</label>
                        <input class="form-control shadow-none rounded-0 data" id="namebrand" name="name"
                            type="text">
                        <span class="text-danger errorname"></span>
                    </div>
                    <div class="col-md-12 form-group mb-4">
                        <label>Quốc gia</label>
                        <select class="form-control shadow-none rounded-0" id="country" name="country" type="text">

                        </select>
                        <span class="text-danger errorcountry"></span>
                    </div>
                    <div class="col-md-12 form-group mb-4">
                        <label>Mô Tả</label>
                        <textarea class="form-control shadow-none rounded-0 data" id="mota" name="description" type="text"></textarea>
                        <span class="text-danger errordescription"></span>
                    </div>
                    <div class="col-md-12 row form-group">
                        <div class="col-md-8 form-group">
                            <label>Ảnh</label>
                            <input class="form-control shadow-none rounded-0 data file-img" name="photo"
                                id="photobrand" type="file">
                            <span class="text-danger errorphoto"></span>
                        </div>
                        <div class="col-md-4 form-group">
                            <img style="width:100px; height:100%;" src="" class="imgchange" id="imgtype" />
                        </div>
                    </div>

                </form>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closebrand" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary addbrand">Thêm</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Them Nhan Hieu --}}
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        async function getcountry() {
            const res = await fetch('{{ asset('location/country.json') }}');
            const countries = await res.json();
            console.log(countries)
            let inner = '';
            let data = countries.data
            for (const key in data) {

                inner += `<option value='${data[key]['country']}'>${data[key]['country']}</option>`
            }

            $('#country').append(inner)
        }
        getcountry()
        var upload_img = '';
        $(".file-img").change(function() {
            let img = $(this).val()
            let e = $(this)
            let eleimg = $(this).parent().parent().find('img')

            console.log(eleimg)
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                upload_img = reader.result;
                console.log(upload_img)
                eleimg.attr("src", upload_img)
            })
            reader.readAsDataURL(this.files[0])
            console.log($(this).val())
        })

        function sumitform(formData, obj) {
            console.log(obj.attr('action'), 'dd')
            $.ajax({
                url: obj.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                enctype: 'multipart/form-data',
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thêm thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    resetModal(obj)
                },
                error: function(response) {
                    console.log(response)
                    object = response.responseJSON ? response.responseJSON.errors : {}
                    for (const property in object) {
                        obj.find('.error' + property).text(object[property][0])
                        console.log(`${property}: ${object[property][0]}`);
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Thêm thất bại',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    console.log(obj, obj.find('.errorname'))
                }
            });
        }

        function resetModal(obj) {
            obj.find('.data').val(null)
            obj.find('.text-danger').text('')
            obj.find('img').attr('src', '')
            obj.find('textarea').val('')
            obj.find('select').prop('selectedIndex', 0);
        }
        $('.closetype').click(function() {
            const obj = $('#formtype');
            resetModal(obj)
        })
        $('.closebrand').click(function() {
            const obj = $('#formbrand');
            resetModal(obj)
        })
        $('.closecategory').click(function() {
            const obj = $('#formcategory');
            resetModal(obj)
        })
        $('#addtype').click(function() {
            console.log('chay')
            const obj = $('#formtype');
            const formData = new FormData(obj[0]);
            sumitform(formData, obj)
        })
        $('.addbrand').click(function() {
            console.log('chay')
            const obj = $('#formbrand');
            const formData = new FormData(obj[0]);
            sumitform(formData, obj)
        })
        $('.addcategory').click(function() {
            const obj = $('#formcategory');
            const formData = new FormData(obj[0]);
            sumitform(formData, obj)
        })
        $(document).on('change', '#type', function() {
            $('#category').val(null).trigger('change');
        })
        $(document).on('change', '#type_cate', function() {
            if ($('#type_cate').val()) {
                $('#namecategory').attr('disabled', false)
                $('#photocategory').attr('disabled', false)
                $('.addcategory').attr('disabled', false)
            } else {
                $('#namecategory').attr('disabled', true)
                $('#namecategory').val('')
                $('#photocategory').attr('disabled', true)
                $('#imgcategory').attr('src', '')
                $('.addcategory').attr('disabled', true)
            }
        })
        $("#type_cate").select2({
            ajax: {
                url: '{{ route('api.type') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $('#brand').select2({
            ajax: {
                url: '{{ route('api.brand') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("#type").select2({
            ajax: {
                url: '{{ route('api.type') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        $("#category").select2({
            ajax: {
                url: '{{ route('api.categories') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term,
                        type: $('#type').val()
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });

        function setvauleSelect2(e, data) {
            console.log('gia tri cu', $('#type').find("option[value=2]"))
            if (e.find("option[value=" + data + "]").length) {
                e.val(data).trigger('change');
            }
            // else { 
            //     // Create a DOM Option and pre-select by default
            //     var newOption = new Option(text, data, true, true);
            //     // Append it to the select
            //     e.append(newOption).trigger('change');
            // } 
        }

        function setValueOld() {
            let valuetype = $('$type').attr('data-old')
            let category = $('$category').attr('data-old')
            let brand = $('$brand').attr('data-old')
            console.log('gia tri cu', type)
            if (valuetype)
                setvauleSelect2($('#type'), parseInt(valuetype))
            if (category)
                setvauleSelect2($('#category'), parseInt(category))
            if (brand)
                setvauleSelect2($('#brand'), parseInt(brand))
        }
        // setValueOld($('type'),'type')
    </script>
@endpush
