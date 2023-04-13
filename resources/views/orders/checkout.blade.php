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
        <form action="{{ route('cart.checkout') }}" method="POST" class="row px-xl-5">
            @if ($errors->has('msg'))
                <div class="error">{{ $errors->first('msg') }}</div>
            @endif
            @csrf
            <div class="col-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Địa chỉ
                        đơn hàng</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
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
                            <input class="form-control email" name="email" type="text" placeholder="example@email.com"
                                value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ</label>
                            <input class="form-control address" name="address" type="text" placeholder="+123 456 789"
                                value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Ghi chú</label>
                            <textarea class="form-control note" name="note" type="text" placeholder="123 Street">{{ old('note') }}</textarea>
                            @if ($errors->has('note'))
                                <div class="error">{{ $errors->first('note') }}</div>
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
                        <div class="col-md-6 form-group">
                            <label>Thành phố</label>
                            <select class="form-control city" name="city"></select>
                            @if ($errors->has('city'))
                                <div class="error">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Quận/Huyện</label>
                            <select class="form-control district" name="district"></select>
                            @if ($errors->has('district'))
                                <div class="error">{{ $errors->first('district') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control code" name="zip_code" type="text" placeholder="123"
                                value="{{ old('zip_code') }}">
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm pt-2 pb-2 info-account" type="button">Lấy thông tin của
                                tài khoản</button>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order
                        Total</span></h5>
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
                    <div class="mb-30 mt-3 pb-1 border-bottom" action="">
                        <div class="input-group">
                            <div class="input-group-append">
                                <button class="btn btn-primary applydiscount" type="button">Apply Coupon</button>
                            </div>
                            <select class="form-control inputdiscont rounded ml-1">
                                <option value="">--Không sử dụng--</option>
                                @forelse ($listdiscount as $itemdiscount)
                                    <option value="{{ $itemdiscount->code }}">{{ $itemdiscount->name }}</option>
                                @empty
                                @endforelse
                            </select>

                        </div>
                    </div>
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>
                                <input id="subtotal" class="d-none" name="subtotal" value={{ $cart->getTotalMoney() }}>
                                <span
                                    class="subtotal">{{ $cart ? number_format($cart->getTotalMoney(), 0, ',', ',') : 0 }}</span>Đ
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <input type="text" class="d-none ship" name="ship" id="ship" value=10000>
                            <h6 class="font-weight-medium textship"><span
                                    class="ship">{{ number_format(10000, 0, ',', ',') }}</span>Đ</h6>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h6 class="font-weight-medium">Discount</h6>
                            <input id="discount" class="d-none" name="discount" value=0>
                            <input id="iddiscount" class="d-none" name="iddiscount" value=0>
                            <h6 class="font-weight-medium "><span class="discount">0</span>Đ</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><span class="total">{{ $cart ? $cart->getTotalMoney() : 0 }}</span>Đ</h5>
                        </div>
                    </div>
                </div>
                <div class="mb-5">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span
                            class="bg-secondary pr-3">Payment</span></h5>
                    <div class="bg-light p-30">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" value=1
                                    id="paypal">
                                <label class="custom-control-label" for="paypal">Paypal</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" value=2
                                    id="directcheck">
                                <label class="custom-control-label" for="directcheck">Direct Check</label>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" name="payment" value=3
                                    id="banktransfer">
                                <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                            </div>
                        </div>
                        @if ($errors->has('payment'))
                            <div class="error">{{ $errors->first('payment') }}</div>
                        @endif
                        <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit">Place
                            Order</button>
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
        var district = null
        $('.applydiscount').click(function() {
            console.log('cccc')
            if ($('.inputdiscont').val()) {
                $.ajax({
                    url: "{{ route('cart.getdiscount') }}",
                    type: 'GET',
                    data: {
                        code: $('.inputdiscont').val(),
                    },
                    success: function(response) {
                        let total
                        console.log(response)
                        if (response[2]) {
                            if (response[1] == 1) {
                                $('.discount').text(Intl.NumberFormat('en-VN').format(parseFloat($(
                                    '#subtotal').val()) * (response[0]) / 100))
                                $('#discount').val(parseFloat($('#subtotal').val()) * (response[0]) /
                                    100)
                                total = (parseFloat($('#subtotal').val()) * (100 - response[0]) / 100) -
                                    parseFloat($('#ship').val())

                            } else {
                                $('.discount').text(response[0])
                                $('#discount').val(response[0])
                                total = parseFloat($('#subtotal').val()) - parseFloat(response[0]) -
                                    parseFloat($('#ship').val())

                            }
                            $('#iddiscount').val(response[2])
                            console.log('vao day ma sai rooif')
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Mã không tồn tại hoặc đã được dùng',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                        console.log(total)
                        $('.total').text(Intl.NumberFormat('en-VN').format(total))

                    },
                    error: function(response) {

                    }
                });
            } else {
                $('.discount').text(0)
                $('#discount').val(0)
                $('#iddiscount').val(0)
                total = parseFloat($('#subtotal').val()) - parseFloat($('#ship').val())
                $('.total').text(Intl.NumberFormat('en-VN').format(total))
            }

        })

        function changeTotal() {
            let total = 0
            if (parseFloat($('#subtotal').val()) != 0) {
                console.log('tong: ', parseFloat($('#subtotal').val()) - parseFloat($('#discount').val()) -
                    parseFloat($('#ship').val()))
                total = parseFloat($('#subtotal').val()) - parseFloat($('#discount').val()) -
                    parseFloat($('#ship').val())
                //enableButton($('.checkout'),false)
            }
            console.log(total)
            $('.total').text(Intl.NumberFormat('en-VN').format(total))
        }
        changeTotal()
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
            } else if (district) {
                setValueSelect($('.district'), district);
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
        insertCity();
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
                let location = 1;
                if ($(this).val() != 'Hà Nội') {
                    location = 2;
                }
                $.ajax({
                    url: "{{ route('api.ship') }}",
                    type: 'GET',
                    data: {
                        location: location,
                    },
                    success: function(response) {
                        $('.ship').val(response[0])
                        $('.textship').text(Intl.NumberFormat('en-VN').format(response[0]))
                        changeTotal()
                        console.log('ship la:', $('.ship').val())
                    },
                    error: function(response) {

                    }
                });
            } else {
                $('.ship').val(10000)
                $('.textship').text(Intl.NumberFormat('en-VN').format(10000))
                changeTotal()
                console.log('ship la:', $('.ship').val())
            }
        })

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
            // } 
        }
        $('.info-account').click(function() {
            let name = "{{ auth()->user()->name }}"
            $('.name').val(name);
            let email = "{{ auth()->user()->email }}"
            $('.email').val(email);
            let phone = "{{ auth()->user()->phone }}"
            $('.phone').val(phone);
            let address = "{{ auth()->user()->address }}"
            $('.address').val(address);
            let note = "{{ auth()->user()->note }}"
            $('.note').val(note);
            let city = "{{ auth()->user()->city }}"
            district = "{{ auth()->user()->district }}"
            setValueSelect($('.city'), city)
        })
    </script>
@endpush
