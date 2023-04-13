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

        .img {
            width: 100px;
        }

        /* .table{
                            padding-left: 3rem !important;
                            padding-right: 3rem !important;
                        } */
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
        <form action="{{ route('orders.updateorder') }}" method="POST" class="row px-xl-5">
            <input type="text" class="d-none" value={{ $id }} name="id" id="">
            <input type="text" class="d-none" value={{ $iduser }} name="iduser" id="">
            @if ($errors->has('msg'))
                <div class="error">{{ $errors->first('msg') }}</div>
            @endif
            @csrf
            @if ($admincheck == 1)
                <input type="text" name="admincheck" class="d-none" value={{ $admincheck }}>
            @endif
            <div class="col-lg-8">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing
                        Address</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input class="form-control name" name="name" type="text" placeholder="John"
                                value="{{ $order->name }}">
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Phone</label>
                            <input class="form-control phone" name="phone" type="text" placeholder="Doe"
                                value="{{ $order->phone }}">
                            @if ($errors->has('phone'))
                                <div class="error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control email" name="email" type="text" placeholder="example@email.com"
                                value="{{ $order->email }}">
                            @if ($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Address</label>
                            <input class="form-control address" name="address" type="text" placeholder="+123 456 789"
                                value="{{ $order->address }}">
                            @if ($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Note</label>
                            <textarea class="form-control note" name="note" type="text" placeholder="123 Street">{{ $order->note }}</textarea>
                            @if ($errors->has('note'))
                                <div class="error">{{ $errors->first('note') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Country</label>
                            <input class="form-control country" name="country" type="text" placeholder=""
                                value="Việt Nam">
                            @if ($errors->has('country'))
                                <div class="error">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>City</label>
                            <select class="form-control city" name="city">
                                {{-- <option>{{$order->city}}</option> --}}
                            </select>
                            @if ($errors->has('city'))
                                <div class="error">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>District</label>
                            <select class="form-control district" name="district">
                                {{-- <option>{{$order->district}}</option> --}}
                            </select>
                            @if ($errors->has('district'))
                                <div class="error">{{ $errors->first('district') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>ZIP Code</label>
                            <input class="form-control code" name="zip_code" type="text" placeholder="123"
                                value="{{ $order->zip_code }}">
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order
                        Total</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pt-3 pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6><span id="subtotal">{{ $order['price'] }}</span>Đ</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <input type="text" class="d-none" name="ship" value=10000>
                            <h6 class="font-weight-medium "><span class="ship">{{ $order['ship'] }}</span>Đ</h6>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <h6 class="font-weight-medium">Discount</h6>
                            <input id="discount" class="d-none" name="discount" value=0>
                            <h6 class="font-weight-medium "><span class="discount">{{ $order['discount'] }}</span>%</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><span
                                    class="total">{{ $order['price'] * (1 - $order['discount'] / 100) - $order['ship'] }}</span>Đ
                            </h5>
                        </div>
                    </div>
                </div>
                <button class="btn btn-block btn-primary font-weight-bold py-3" type="submit">Cập Nhật</button>
                <a href="{{ route('orders.reject', ['id' => $iduser, 'admincheck' => $admincheck]) }}"
                    class="btn btn-block btn-primary font-weight-bold py-3" type="button">Hủy</a>
            </div>

        </form>
    </div>
    <table class="table container">
        <thead class="thead-dark text-center">
            <tr>
                <th scope="col">Ảnh</th>
                <th scope="col">Tên Sản Phẩm</th>
                <th scope="col">Màu</th>
                <th scope="col">Size</th>
                <th scope="col">Số Lượng</th>
                <th scope="col">Đơn Giá</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orderdetail as $item)
                <tr class='text-center itemproduct'>
                    <td><img src="{{ asset('storage') }}/{{ $item['path'] }}" class='img' alt=""></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['sizename'] }}</td>
                    <td>{{ $item['colorname'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ $item['totalPrice'] }}</td>
                    <td> <a class="delete" style="margin-right:10px" data-id={{ $item['id_order'] }}
                            data-idPro={{ $item['id_product'] }} data-size={{ $item['size'] }}><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path
                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg></a></td>
                </tr>
            @empty
            @endforelse
        </tbody>
    </table>


    <!-- Checkout End -->
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        //    async function insertselect(){
        //          const response = await fetch('{{ asset('location/index.json') }}');
        //             const cities = await response.json();
        //             console.log(cities["{{ $order->city }}"])
        //             inner=`<option data-path='${cities["{{ $order->city }}"]['file_path']}'>"{{ $order->city }}"</option>`
        //             $('.city').append()
        //     }
        //  insertselect()
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
        var check = true;
        async function loadDistrict(path) {
            $(".district").empty()
            const response = await fetch('{{ asset('location/data') }}' + '/' + path);

            const districts = await response.json();
            let string = '';
            const selectedValue = "{{ $order->district }}";

            $.each(districts.district, function(index, each) {
                if (each.pre === 'Quận' || each.pre === 'Huyện') {
                    console.log(selectedValue === each.name)
                    //string += ;
                    // if (selectedValue == each.name) {
                    //     string += ` selected `;
                    // }
                    string += `<option ${each.name==selectedValue?'selected':''}>${each.name}</option>`;
                }
            })
            $(".district").append(string);
            if (!check) {
                $('.district').val(null).trigger('change');
            } else check = false
        }

        async function insertCity() {
            const response = await fetch('{{ asset('location/index.json') }}');
            const cities = await response.json();
            console.log(cities)
            $.each(cities, function(index, each) {
                $(".city").append(`
                    <option data-path='${each.file_path}' ${index=="{{ $order->city }}"?'selected':''}>
                        ${index}
                    </option>`)
            })
            if ($('.city').val) {
                let path = $(".city option:selected").data('path')
                let array = path.split("/");
                loadDistrict(array[2])
            }
        }
        insertCity()
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

        function changeTotal() {
            let total = 0
            if (parseFloat($('#subtotal').text()) != 0) {
                console.log(parseFloat($('#subtotal').text()) * (100 - parseFloat($('.discount').text())) / 100) -
                    parseFloat($('.ship').text())
                total = (parseFloat($('#subtotal').text()) * (100 - parseFloat($('.discount').text())) / 100) - parseFloat(
                    $('.ship').text())
                //enableButton($('.checkout'),false)
            }
            console.log(total)
            $('.total').text(total)
        }
        $('.delete').click(function() {
            let idorder = $(this).attr('data-id')
            let idpro = $(this).attr('data-idPro')
            let size = $(this).attr('data-size')
            let ele = $(this)
            $.ajax({
                url: "{{ route('orders.deletedetail') }}",
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}",
                    order: idorder,
                    product: idpro,
                    size: size
                },
                success: function(response) {
                    ele.parent().parent().remove()
                    $('#subtotal').text(response[0])
                    changeTotal()
                },
                error: function(response) {

                }
            });
        })
    </script>
@endpush
