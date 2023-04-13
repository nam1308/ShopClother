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
    <form action="" class="row px-xl-3" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Nhập</span>
            </h5>
            <div class="bg-light p-30">
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif
                <div class="row">
                    @if (isset($edit))
                        <input type="text" class="d-none" value={{ $product['id'] }} name="id">
                    @endif
                    <div class="col-md-4 form-group">
                        <label>Phân loại chính</label>
                        <select name="type" id="type" class="form-control" data-old='{{ old('type') }}'>
                            @if (old('type') != null)
                                <option value="{{ old('type') }}">
                                    {{ $type->where('id', intval(old('type')))->first()->name }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('type'))
                            <div class="error">{{ $errors->first('type') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Phân loại phụ</label>
                        <select name="category" class="form-control" id="category" data-old="{{ old('category') }}">
                            @if (old('category') != null)
                                <option value="{{ old('category') }}">
                                    {{ $type->with([
                                            'Categories' => fn($query) => $query->where('id', intval(old('category'))),
                                        ])->where('id', intval(old('type')))->get()->first()->toArray()['categories'][0]['name'] }}
                                </option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Nhãn Hiệu</label>
                        <select name="brand" class="form-control" id="brand" data-old="{{ old('brand') }}">
                            @if (old('brand') != null || isset($edit))
                                <option value="{{ old('brand') }}">
                                    {{ old('brand') }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('brand'))
                            <div class="error">{{ $errors->first('brand') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giới Tính</label>
                        <select name="gender" id="gender" class="form-control shadow-none rounded-0">
                            <option value=0>--Chọn--</option>
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
                    <div class="col-md-4 form-group">
                        <label>Mã sản phẩm</label>
                        <select class="form-control shadow-none rounded-0" name="code" id="code">
                            @if (old('code') != null)
                                <option value="{{ isset($edit) ? $product['code'] : old('code') }}">
                                    {{ intval(old('code')) }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('code'))
                            <div class="error">{{ $errors->first('code') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Sản phẩm</label>
                        <select name="name" id="tensp" class="form-control shadow-none rounded-0">
                            @if (old('name') != null)
                                <option value="{{ old('name') }}">
                                    {{ old('name') }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giá nhập</label>
                        <input name="importprice" id="importprice" class="form-control shadow-none rounded-0"
                            value="{{ old('importprice') }}" placeholder="Số lượng nhập">
                        @if ($errors->has('importprice'))
                            <div class="error">{{ $errors->first('importprice') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Giá bán</label>
                        <input name="salesprice" id="salesprice" class="form-control shadow-none rounded-0"
                            value="{{ old('salesprice') }}" placeholder="Số lượng nhập">
                        @if ($errors->has('salesprice'))
                            <div class="error">{{ $errors->first('salesprice') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Màu sắc</label>
                        <select name="color" id="color" class="form-control shadow-none rounded-0"
                            value="{{ old('color') }}">
                            @if (old('color') != null)
                                <option value="{{ old('color') }}">
                                    {{ old('color') }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('color'))
                            <div class="error">{{ $errors->first('color') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Kích cỡ</label>
                        <select name="size" id="size" class="form-control shadow-none rounded-0"
                            value="{{ old('size') }}">
                            @if (old('size') != null)
                                <option value="{{ old('size') }}">
                                    {{ old('size') }}
                                </option>
                            @endif
                        </select>
                        @if ($errors->has('size'))
                            <div class="error">{{ $errors->first('size') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Số lượng trong kho</label>
                        <input name="quantity" id="quantity" class="form-control shadow-none rounded-0" disabled
                            value="{{ old('quantity') }}" placeholder="Số lượng còn trong kho">
                        @if ($errors->has('quantity'))
                            <div class="error">{{ $errors->first('quantity') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Số lượng nhập</label>
                        <input name="quantityimport" id="quantityimport" class="form-control shadow-none rounded-0"
                            value="{{ old('quantityimport') }}" placeholder="Số lượng nhập">
                        @if ($errors->has('quantityimport'))
                            <div class="error">{{ $errors->first('quantityimport') }}</div>
                        @endif
                    </div>
                    <div class="col-md-6 mt-3">
                        <button type="button" class="btn btn-primary rounded-0 shadow-none mt-3 reset">Làm mới</button>
                        <button type="button" class="btn btn-primary rounded-0 shadow-none mt-3 addtocart"
                            disabled>Thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @php
        // dd($cart);
    @endphp
    <table class="table mt-1" style="width:97.5% !important; margin:0 auto;">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Tên sản phẩm</th>
                <th scope="col">Màu</th>
                <th scope="col">Kích cỡ</th>
                <th scope="col">Số lượng</th>
                <th scope="col">Thao tác</th>
            </tr>
        </thead>
        <tbody class="bodytable">
            @forelse ($cart?$cart->getProductInCart():[] as $item)
                <tr id='sp_{{ $item['productInfo']['idProductDetail'] . '-' . $item['productInfo']['idsize'] }}'>
                    <th scope="col">-</th>
                    <th scope="col">{{ $item['productInfo']['name'] }}</th>
                    <th scope="col">{{ $item['productInfo']['namecolor'] }}</th>
                    <th scope="col">{{ $item['productInfo']['namesize'] }}</th>
                    <th scope="col"><input type="number" class="countimport" value={{ $item['quantity'] }} /></th>
                    <th scope="col"><button type="button" data-id={{ $item['productInfo']['idProductDetail'] }}
                            data-size={{ $item['productInfo']['idsize'] }}
                            class="btn btn-danger btn-sm mb-2 d-block buttonchange remove">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                            </svg> Xóa
                        </button> </th>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>
    <div class="row mt-5 border-top">
        <button type="button" class="btn btn-primary rounded-0 shadow-none mt-3 ml-5 checkout">Tạo hóa
            đơn</button>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
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
                    console.log(obj, obj.find('.errorname'))
                }
            });
        }

        function resetModal(obj) {
            obj.find('input').val(null)
            obj.find('.text-danger').text('')
            obj.find('img').attr('src', '')
            obj.find('textarea').val('')
            obj.find('select').prop('selectedIndex', 0);
        }
        $("#code").select2({
            ajax: {
                url: '{{ route('api.getlistcode') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map([{
                            begin: 0,
                            code: "--Chọn--",
                        }, ...data], function(item) {
                            return {
                                text: item.code,
                                id: item.begin != null ? item.begin : item.code
                            }
                        })
                    };
                }
            }
        });
        $('#tensp').select2({
            ajax: {
                url: '{{ route('api.getlistproduct') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term,
                        type: $('#type').val(),
                        category: $('#category').val(),
                        brand: $('#brand').val(),
                        gender: $('#gender').val(),
                        code: $('#code').val(),
                    };

                    return queryParameters;
                },
                processResults: function(data) {
                    return {
                        results: $.map([{
                            id: 0,
                            name: "--Tất Cả--"
                        }, ...data], function(item) {
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
                        results: $.map([{
                            id: 0,
                            name: "--Tất Cả--"
                        }, ...data], function(item) {
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
                        results: $.map([{
                            id: 0,
                            name: "--Tất Cả--"
                        }, ...data], function(item) {
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
                        results: $.map([{
                            id: 0,
                            name: "--Tất Cả--"
                        }, ...data], function(item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
        $("#color").select2({
            ajax: {
                url: '{{ route('api.getcolorofproduct') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term,
                        id: $('#tensp').val()
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
        $("#size").select2({
            ajax: {
                url: '{{ route('api.getsizeofproduct') }}',
                data: function(params) {
                    const queryParameters = {
                        q: params.term,
                        id: $('#tensp').val(),
                        color: $('#color').val()
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
        $('#tensp').on('change', function() {
            console.log('chayng')
            if ($(this).val()) {
                let id = $(this).val()
                $.ajax({
                    url: "{{ route('api.getproduct') }}",
                    type: 'GET',
                    data: {
                        id: id
                    },
                    success: function(response) {
                        setValueInput(response)
                    },
                    error: function(response) {

                    }
                });
            }
        })

        function insetOption(data, name, obj) {
            let inner = `<option value="${data}">${name}</option>`
            obj.append(inner)
        }

        function setValueInput(data = null) {
            if (data) {
                insetOption(data['type_product']['id'], data['type_product']['name'], $('#type'))
                setvauleSelect2($('#type'), data['type'])
                insetOption(data['category'], data['category_product']['name'], $('#category'))
                setvauleSelect2($('#category'), data['category'])
                insetOption(data['brand_product']['id'], data['brand_product']['name'], $('#brand'))
                setvauleSelect2($('#brand'), data['brand'])
                insetOption(data['code'], data['code'], $('#code'))
                setvauleSelect2($('#code'), data['code'])
                $('#importprice').val(data['priceImport'])
                $('#salesprice').val(data['priceSell'])
                $('#gender').find(":selected").attr('selected', false)
                $('#gender').find("option[value=" + data['gender'] + "]").attr('selected', true)
            } else {
                $('#color').val(null).trigger('change');
                $('#type').val(null).trigger('change');
                $('#brand').val(null).trigger('change');
                $('#category').val(null).trigger('change');
                $('#code').val(null).trigger('change');
                $('#tensp').val(null).trigger('change');
                $('#size').val(null).trigger('change');
                $('#importprice').val(null);
                $('#salesprice').val(null);
                $('#quantityimport').val(null);
                $('#quantity').val(null);
                $('#gender').find("option[value=" + 0 + "]").attr('selected', true)
            }
        }

        function setvauleSelect2(e, data) {
            console.log('gia tri cu', data)
            if (e.find("option[value=" + data + "]").length) {
                e.val(data).trigger('change');
            }
        }
        $('.remove').click(function() {
            let dataidProduct = $(this).attr('data-id')
            let datasize = $(this).attr('data-size')
            let e = $(this)
            console.log(dataidProduct, datasize)
            $.ajax({
                url: "{{ route('admin.orderimport.removeproductincart') }}",
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    'idProduct': dataidProduct,
                    'size': datasize
                },
                success: function(response) {
                    e.parent().parent().remove()
                },
                error: function(response) {

                }
            });
        })
        $('#color').on('change', function() {
            $('#size').val(null).trigger('change');
        })
        $('#size').on('change', function() {
            if ($(this).val()) {
                $.ajax({
                    url: "{{ route('api.quantityproduct') }}",
                    type: 'GET',
                    data: {
                        id: $('#tensp').val(),
                        color: $('#color').val(),
                        size: $('#size').val()
                    },
                    success: function(response) {
                        $('#quantity').val(response[0])
                    },
                    error: function(response) {

                    }
                });
            }
        })
        $('.reset').click(function() {
            setValueInput()
        })
        $('#quantityimport').change(function() {
            if ($(this).val() && parseInt($(this).val()) != 0 && $('#size').val()) {
                $('.addtocart').attr('disabled', false)
            } else {
                $('.addtocart').attr('disabled', true)
            }
        })
        $('.addtocart').click(function() {
            let id = $('#tensp').val()
            let product_detail = $('#color').val()
            let size = $('#size').val()
            $.ajax({
                url: "{{ route('admin.orderimport.addtocart') }}",
                type: 'GET',
                data: {
                    id: id,
                    color: $('#color').val(),
                    size: size,
                    quantity: $('#quantityimport').val()
                },
                success: function(response) {
                    console.log(response)
                    if (!$(`#sp_${response[2]['idProductDetail']+'-'+response[2]['idsize']}`).length) {
                        let ten = $('#tensp').text()
                        let color = $('#color').text()
                        let size = $('#size').text()
                        let quantity = $('#quantityimport').val()
                        let item = `<tr id='sp_${response[2]['idProductDetail']+'-'+response[2]['idsize']}'> 
                        <th scope = "col"></th> 
                        <th scope = "col">${ten}</th> 
                        <th scope = "col">${color} </th> 
                        <th scope = "col"> ${size} </th> 
                        <th scope = "col"><input type="number" class="countimport" value=${quantity} /> </th> 
                        <th scope = "col"> <button type="button" class="btn btn-danger btn-sm mb-2 d-block buttonchange remove"  
                            data-id=${ response[2]['idProductDetail'] }
                            data-size=${  response[2]['idsize']  }>
                                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg> Xóa
                                </button> 
                        </th> 
                        </tr>`
                        $('.bodytable').append(item);
                        $('.countimport').unbind('change')
                        $('.countimport').change(function() {
                            let idProduct = $(this).parent().next().find('.remove').attr(
                                'data-id')
                            let size = $(this).parent().next().find('.remove').attr('data-size')
                            let quantity = $(this).val()
                            $.ajax({
                                url: "{{ route('admin.orderimport.changequantity') }}",
                                type: 'GET',
                                data: {
                                    idProduct: idProduct,
                                    size: size,
                                    quantity: quantity
                                },
                                success: function(response) {

                                },
                                error: function(response) {

                                }
                            });
                        })
                    } else {
                        let oldquantity = $(
                            `#sp_${response[2]['idProductDetail']+'-'+response[2]['idsize']}`).find(
                            '.countimport').val()
                        $(`#sp_${response[2]['idProductDetail']+'-'+response[2]['idsize']}`).find(
                            '.countimport').val(parseInt(oldquantity) + parseInt($(
                            '#quantityimport').val()))
                    }
                },
                error: function(response) {

                }
            });
        })
        $('.countimport').change(function() {
            let idProduct = $(this).parent().next().find('.remove').attr('data-id')
            let size = $(this).parent().next().find('.remove').attr('data-size')
            let quantity = $(this).val()
            $.ajax({
                url: "{{ route('admin.orderimport.changequantity') }}",
                type: 'GET',
                data: {
                    idProduct: idProduct,
                    size: size,
                    quantity: quantity
                },
                success: function(response) {

                },
                error: function(response) {

                }
            });
        })
        $('.checkout').click(function() {
            $.ajax({
                url: "{{ route('admin.orderimport.checkcart') }}",
                type: 'GET',
                success: function(response) {
                    console.log('kkk: ', response)
                    if (parseInt(response) != 0) {
                        window.location.replace("{{ route('admin.orderimport.checkout') }}");
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Vui lòng thêm sản phẩm',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                },
                error: function(response) {

                }
            });
        })

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
