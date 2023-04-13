@extends('layout.master')
@section('content')
    <!-- Breadcrumb Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="{{ route('index') }}">Home</a>
                    <span class="breadcrumb-item active">Shopping Cart</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Color</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @forelse ($cart?$cart->getProductInCart():[] as $item)
                            <tr>
                                <td class="align-middle"><img src={{ asset('storage/' . $item['productInfo']['img']) }}
                                        alt="" style="width: 50px;"> {{ $item['productInfo']['name'] }}</td>
                                <td class="align-middle">{{ $item['productInfo']['namecolor'] }}</td>
                                <td class="align-middle">{{ $item['productInfo']['namesize'] }}</td>
                                <td class="align-middle">{{ $item['productInfo']['price'] }}</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus butchange">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                            class="form-control form-control-sm bg-secondary border-0 text-center dataquantity"
                                            data-max={{ $item['productInfo']['quantity'] }} value={{ $item['quantity'] }}
                                            data-id={{ $item['productInfo']['idProductDetail'] }}
                                            data-size={{ $item['productInfo']['idsize'] }}>
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus butchange"
                                                {{ $item['productInfo']['quantity'] == $item['quantity'] ? 'disabled' : '' }}>
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td
                                    class="align-middle priceitem-{{ $item['productInfo']['idProductDetail'] . '_' . $item['productInfo']['idsize'] }}">
                                    {{ number_format($item['price'], 0, ',', ',') }}</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger remove"
                                        data-id={{ $item['productInfo']['idProductDetail'] }}
                                        data-size={{ $item['productInfo']['idsize'] }}><i class="fa fa-times"></i></button>
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        {{-- <input type="text" class="form-control border-0 p-4 inputdiscont" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary applydiscount" type="button">Apply Coupon</button>
                        </div> --}}
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart
                        Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        {{-- <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6><span id="subtotal">{{ $cart ? $cart->getTotalMoney() : 0 }}</span>Đ</h6>
                        </div> --}}
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Total Quantity</h6>
                            <h6 class="font-weight-medium totalquantity">{{ $cart ? $cart->getTotalQuantity() : 0 }}</h6>
                        </div>

                    </div>
                    <form class="pt-2" action="{{ route('cart.checkout') }}">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5><span
                                    class="total">{{ $cart ? number_format($cart->getTotalMoney(), 0, ',', ',') : 0 }}</span>Đ
                            </h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3 checkout"
                            {{ $cart ? '' : 'disabled' }}>Tạo Hóa
                            Đơn</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@push('js')
    <script>
        function changeQuantityProductCart(idProduct, size, quantity) {
            $.ajax({
                url: "{{ route('cart.changecart') }}",
                type: 'GET',
                data: {
                    idProduct: idProduct,
                    quantity: quantity,
                    size: size,
                },
                success: function(response) {
                    console.log(response)
                    resetdata(response, idProduct, size)

                },
                error: function(response) {

                }
            });
        }

        function resetdata(response, idProduct = null, size = null) {
            if (response.length != 0) {
                $('.total').text(Intl.NumberFormat('en-VN').format(response[0].totalMoney))
                $('.totalquantity').text(response[0].totalQuantity)
                if (idProduct && size) {
                    let id = `${idProduct}_${size}`
                    // console.log('.priceitem-' + id)
                    $('.priceitem-' + id).text(Intl.NumberFormat('en-VN').format(response[0]['products'][id]['price']))
                    enableButton($('.checkout'), false)
                }
            } else {
                $('.total').text(0)
                $('.totalquantity').text(0)
                enableButton($('.checkout'), true)
            }
        }

        function enableButton(e, status) {
            e.attr('disabled', status)
        }
        $('.butchange').on('click', function() {
            var button = $(this);
            let maxdata = button.parent().parent().find('input').attr('data-max')
            var oldValue = button.parent().parent().find('input').val();
            let size = button.parent().parent().find('input').attr('data-size');
            let idProduct = button.parent().parent().find('input').attr('data-id');
            if (button.hasClass('btn-plus')) {
                let buttminus = button.parent().parent().find('.btn-minus');
                console.log(maxdata)
                enableButton(buttminus, false)
                var newVal = parseFloat(oldValue) + 1;
                button.parent().parent().find('input').val(newVal);
                changeQuantityProductCart(idProduct, size, parseFloat(newVal))
                if (parseInt(newVal) + 1 > maxdata) {
                    enableButton($(this), true)
                }
            } else {
                let buttplus = button.parent().parent().find('.btn-plus');
                console.log(maxdata)
                enableButton(buttplus, false)
                var newVal = parseFloat(oldValue) - 1;
                button.parent().parent().find('input').val(newVal);
                if (parseFloat(newVal) - 1 < 0) {
                    newVal = 0;
                    enableButton($(this), true)
                    removeProductInCart(idProduct, size)
                    $(this).parent().parent().parent().parent().remove()
                } else {
                    changeQuantityProductCart(idProduct, size, parseFloat(newVal))
                }

            }

        });
        $('.dataquantity').change(function() {
            let buttplus = $(this).parent().find('.btn-plus');
            let buttminus = $(this).parent().find('.btn-minus');
            let size = $(this).attr('data-size');
            let idProduct = $(this).attr('data-id');
            if (parseInt($(this).val()) > parseInt($(this).attr('data-max'))) {
                $(this).val(parseInt($(this).attr('data-max')))
                enableButton(buttminus, false)
                enableButton(buttplus, true)
                changeQuantityProductCart(idProduct, size, parseInt($(this).attr('data-max')))
            } else if (parseInt($(this).val()) < 0) {
                $(this).val(0)
                enableButton(buttminus, true)
                enableButton(buttplus, false)
                removeProductInCart(idProduct, size)
                $(this).parent().parent().parent().remove()
            } else {
                changeQuantityProductCart(idProduct, size, parseInt($(this).val()))
            }
        })

        function removeProductInCart(idProduct, size) {
            $.ajax({
                url: "{{ route('cart.removeproductincart') }}",
                type: 'GET',
                data: {
                    idProduct: idProduct,
                    size: size,
                },
                success: function(response) {
                    console.log(response)
                    resetdata(response)
                },
                error: function(response) {

                }
            });
        }
        $('.remove').click(function() {
            let size = $(this).attr('data-size');
            let idProduct = $(this).attr('data-id');
            removeProductInCart(idProduct, size)
            $(this).parent().parent().remove()
        })
        //enableButton($('.checkout'),true)
        // function changeTotal(){
        //      let total=0
        //     if(parseFloat($('#subtotal').text())!=0){

        //     total=(parseFloat($('#subtotal').text())*(100-parseFloat($('.discount').text()))/100)-parseFloat($('.ship').text())
        //     enableButton($('.checkout'),false)
        //     }
        //     console.log(total)
        //     $('.total').text(total)
        // }
        ///changeTotal()
        $('.applydiscount').click(function() {
            if ($('.inputdiscont').val()) {
                $.ajax({
                    url: "{{ route('cart.getdiscount') }}",
                    type: 'GET',
                    data: {
                        code: $('.inputdiscont').val(),
                    },
                    success: function(response) {
                        console.log(response)
                        $('.discount').text(response)
                        let total = (parseFloat($('#subtotal').text()) * (100 - response) / 100) -
                            parseFloat($('.ship').text())
                        console.log(total)
                        $('.total').text(total)
                    },
                    error: function(response) {

                    }
                });
            }
        })
    </script>
@endpush
