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
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Checkout</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Checkout Start -->
    <div class="container-fluid">
        <form action="{{ route('admin.orderimport.createorder') }}" method="POST" class="row px-xl-5">

            @csrf
            <div class="col-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ
                        đơn hàng</span></h5>
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif
                <div class="bg-light p-30 mb-5">
                    <div class="row" id="accordion">
                        <div class="col-md-6 form-group">
                            <label>Nhà Cung Cấp</label>
                            <select class="form-control supplier" name="idsupplier"
                                @if ($errors->has('name') ||
                                    $errors->has('phone') ||
                                    $errors->has('email') ||
                                    $errors->has('address') ||
                                    $errors->has('note') ||
                                    $errors->has('country') ||
                                    $errors->has('city') ||
                                    $errors->has('district')) disabled @endif>
                                <option>--Chọn--</option>
                                @forelse ($suppliers as $item)
                                    <option value={{ $item['id'] }}>{{ $item['name'] . ' - ' . $item['address'] }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('idsupplier'))
                                <div class="error">{{ $errors->first('idsupplier') }}</div>
                            @endif
                        </div>
                        <input type="text" class="d-none" name="exists" value="1" id="exists"
                            @if ($errors->has('name') ||
                                $errors->has('phone') ||
                                $errors->has('email') ||
                                $errors->has('address') ||
                                $errors->has('note') ||
                                $errors->has('country') ||
                                $errors->has('city') ||
                                $errors->has('district')) disabled @endif>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control code" name="zip_code" type="text" placeholder="123"
                                value="{{ old('zip_code') }}">
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control note" name="note" type="text" placeholder="123 Street">{{ old('note') }}</textarea>
                            @if ($errors->has('note'))
                                <div class="error">{{ $errors->first('note') }}</div>
                            @endif
                        </div>
                        <button type="button" class="btn btn-primary h-50 newinfo" style="margin-top: 2rem !important;"
                            data-toggle="collapse" href="#infor" type="button" role="button"
                            aria-expanded="@if ($errors->has('name') ||
                                $errors->has('phone') ||
                                $errors->has('email') ||
                                $errors->has('address') ||
                                $errors->has('note') ||
                                $errors->has('country') ||
                                $errors->has('city') ||
                                $errors->has('district')) true @endif" aria-controls="product">
                            Nhập Thông Tin
                            Mới</button>
                        {{-- <button class="btn btn-primary dropdown-item col-6 mb-2" data-toggle="collapse" href="#infor"
                            type="button" role="button" aria-expanded="false" aria-controls="product">
                            Nhập Thông Tin Mới
                        </button> --}}
                        <div class="col-12 collapse row @if ($errors->has('name') ||
                            $errors->has('phone') ||
                            $errors->has('email') ||
                            $errors->has('address') ||
                            $errors->has('city') ||
                            $errors->has('district')) show @endif" id="infor"
                            data-parent="#accordion">
                            <div class="col-md-6 form-group">
                                <label>Tên</label>
                                <input class="form-control name" name="name" type="text" placeholder="John"
                                    value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="error">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Điện thoại</label>
                                <input class="form-control phone" name="phone" type="text" placeholder="Doe"
                                    value="{{ old('phone') }}">
                                @if ($errors->has('phone'))
                                    <div class="error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control email" name="email" type="text"
                                    placeholder="example@email.com" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Địa chỉ</label>
                                <input class="form-control address" name="address" type="text"
                                    value="{{ old('address') }}">
                                @if ($errors->has('address'))
                                    <div class="error">{{ $errors->first('address') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Quốc gia</label>
                                <input class="form-control country" name="country" type="text" placeholder=""
                                    value="Việt Nam" value="{{ old('country') }}">
                                @if ($errors->has('country'))
                                    <div class="error">{{ $errors->first('country') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group d-flex flex-column">
                                <label class="">Thành phố</label>
                                <select class="form-control col-12 city" name="city"></select>
                                @if ($errors->has('city'))
                                    <div class="error">{{ $errors->first('city') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6 form-group d-flex flex-column">
                                <label class="">Quận/Huyện</label>
                                <select class="form-control col-12 district" name="district"></select>
                                @if ($errors->has('district'))
                                    <div class="error">{{ $errors->first('district') }}</div>
                                @endif
                            </div>

                        </div>



                    </div>
                </div>
            </div>
            <div class="col-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Tổng
                        hóa
                        đơn</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom">
                        <h6 class="mb-3">Sản phẩm</h6>
                        @forelse ($cart?$cart->getProductInCart():[] as $item)
                            <div class="d-flex justify-content-between">
                                <p>{{ $item['productInfo']['name'] . '-' . $item['productInfo']['namecolor'] . '-' . $item['productInfo']['namesize'] }}
                                </p>
                                <p>{{ $item['price'] }}Đ</p>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Giá hóa đơn</h6>
                            <h6><span id="subtotal">{{ $cart ? $cart->getTotalMoney() : 0 }}</span>Đ</h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="font-weight-medium mt-2">Vận chuyển</h6>
                            <input type="text" class="form-control border-0 p-4 tranforPrice"
                                value="{{ old('ship') }}" name="ship" placeholder="Giá vận chuyển ...">
                            @if ($errors->has('ship'))
                                <div class="error">{{ $errors->first('ship') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <button class="btn btn-block btn-primary font-weight-bold py-3 create">Tạo hóa
                                đơn</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- Checkout End -->
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.newinfo').click(function() {
            if (!$('.supplier').prop('disabled')) {
                $('#exists').attr('disabled', true)
                $('.supplier').attr('disabled', true)
            } else {
                $('#exists').attr('disabled', false)
                $('.supplier').attr('disabled', false)
            }
        })
        async function loadDistrict(path) {
            $(".district").empty()
            const response = await fetch('{{ asset('location/data') }}' + '/' + path);
            const districts = await response.json();
            let string = '';
            // const selectedValue = $(".district").val();
            const selectedValue = "{{ !empty(old('district')) ? old('district') : '' }}";
            console.log(path)
            $.each(districts.district, function(index, each) {
                if (each.pre === 'Quận' || each.pre === 'Huyện') {
                    string +=
                        `<option value='${each.name}' ${each.name==selectedValue?'selected':''}>${each.name}</option>`;
                }
            })
            $(".district").append(string);
            $('.district').val(null).trigger('change');
            let olddistric = "{{ !empty(old('district')) ? old('district') : '' }}"

            if (olddistric) {
                setValueSelect($('.district'), olddistric);
            } else if (districts) {
                setValueSelect($('.district'), districts);
            }

        }
        async function insertCity() {
            const response = await fetch('{{ asset('location/index.json') }}');
            const cities = await response.json();
            console.log(cities)
            $.each(cities, function(index, each) {
                $(".city").append(`
                    <option value='${index}' data-path='${each.file_path}'>${index}</option>`)
            })
            $('.city').val(null).trigger('change');
            let city = "{{ !empty(old('city')) ? old('city') : '' }}"
            if (city) {
                console.log(city, '  co nha')
                setValueSelect($('.city'), city)
            }
        }
        insertCity()


        function setOldSupplier() {
            let supplier = "{{ !empty(old('idsupplier')) ? old('idsupplier') : '' }}"
            if (supplier) {
                setValueSelect($('.idsupplier'), supplier);
            }
        }
        setOldSupplier()

        function setValueSelect(e, data) {
            console.log(e.find("option[value='" + data + "']").length)
            if (e.find("option[value='" + data + "']").length) {
                e.val(data).trigger('change');
            }
            // else { 
            //     // Create a DOM Option and pre-select by default
            //     var newOption = new Option(data.text, data.id, true, true);
            //     // Append it to the select
            //     e.append(newOption).trigger('change');
        }
        $(".supplier").select2({
            tags: true
        });
        $(".city").select2({
            tags: true
        });
        $(".district").select2({
            tags: true
        });
        $(document).on('change', '.city', function() {
            if ($(this).val()) {
                console.log($('.city').parent().find(".city option:selected").data('path'))
                let path = $('.city').parent().find(".city option:selected").data('path')
                let array = path.split("/");
                loadDistrict(array[2])
            }
        })
    </script>
@endpush
