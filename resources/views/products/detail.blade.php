@extends('layout.master')
@push('css')
    <style>
        img.h-100 {
            height: 500px !important;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-12">
                <nav class="breadcrumb bg-light mb-30">
                    <a class="breadcrumb-item text-dark" href="#">Home</a>
                    <a class="breadcrumb-item text-dark" href="#">Shop</a>
                    <span class="breadcrumb-item active">Shop Detail</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <input type="text" value={{ $product['id'] }} class="d-none" id="idProduct">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light" id="listImg">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" style="height: 100%;"
                                src={{ asset('storage/' . $product['img'][0]['path']) }} alt="Image">
                        </div>
                        @forelse ($data as $item)
                            <div class="carousel-item">
                                <img class="w-100 h-100" src={{ asset('storage/' . $item['img'][0]['path']) }}
                                    alt="Image">
                            </div>
                        @empty
                        @endforelse


                        {{-- <div class="carousel-item">
                            <img class="w-100 h-100" src={{ asset("img/product-3.jpg")}} alt="Image">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 h-100" src={{ asset("img/product-4.jpg")}} alt="Image">
                        </div> --}}
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $product['name'] }}</h3>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            {{-- <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small> --}}
                        </div>
                        {{-- <small class="pt-1">(99 Reviews)</small> --}}
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">
                        @if ($product['isdiscount'] == 1)
                            <del style="color:#808080cc;">{{ number_format($product['priceSell'], 0, ',', ',') }} Đ</del>
                            {{ $product['price_discount'] }} Đ
                        @else
                            {{ number_format($product['priceSell'], 0, ',', ',') }} Đ
                        @endif

                    </h3>
                    {{-- <p class="mb-4">{{ $product['description'] }}</p> --}}
                    <div class="d-flex mb-4">
                        <strong class="text-dark mr-3">Màu sắc:</strong>
                        <form>
                            @forelse ($data as $item)
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input color"
                                        value={{ $item['color_product']['id'] }} id="color-{{ $item['id'] }}"
                                        name="color">
                                    <label class="custom-control-label"
                                        for="color-{{ $item['id'] }}">{{ $item['color_product']['name'] }}</label>
                                </div>
                            @empty
                            @endforelse
                        </form>
                    </div>
                    <div class="d-flex mb-3">
                        <strong class="text-dark mr-3">Kích cỡ:</strong>
                        <form id="listSize">
                            <div class="btn-primary" style="padding: 5px"> Vui lòng chọn màu trước</div>

                        </form>
                    </div>

                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus subtrac butchange">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center inputquantity"
                                value="0">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus add butchange">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button class="btn btn-primary px-3 addtocart"><i class="fa fa-shopping-cart mr-1"></i> Thêm vào
                            giỏ hàng</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Mô Tả</a>
                        {{-- <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a> --}}
                        <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Đánh Giá</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <h4 class="mb-3">Mô tả sản phẩm</h4>
                            <p>{{ $product['description'] }}</p>

                        </div>

                        <div class="tab-pane fade" id="tab-pane-3">
                            <div class="row">

                                <form action="{{ route('product.rateproduct') }}" id="formreview" class="col-md-12">
                                    @csrf
                                    <input type="text" class="d-none" name="id" value={{ $product['id'] }}>
                                    <h4 class="mb-4">Để lại một đanh giá</h4>
                                    <div class="d-flex my-3">
                                        <p class="mb-0 mr-2">Đánh giá của bạn * :</p>
                                        <div id="starrate"></div>
                                        <input type="number" class="d-none" id="rate" name="rate">
                                    </div>
                                    <div>
                                        <div class="form-group row">
                                            <div class='col-6'>
                                                <label for="message">Bình luận của bạn *</label>
                                                <textarea id="message" name="review" cols="30" rows="5" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class='col-6' style="margin-top: 32px">
                                                <input type="button" value="Submit" class="btn btn-primary px-3 rating">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->


    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Bạn có
                thể cũng thích</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @forelse ($productSuggest as $item)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src={{ asset('storage/' . $item['img'][0]['path']) }}
                                    alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="far fa-heart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $item['name'] }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $item['priceSell'] }}</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        @empty
                    @endforelse

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('js')
    {{-- <script src="https://code.jquery.com/jquery-3.6.1.slim.js" integrity="sha256-tXm+sa1uzsbFnbXt8GJqsgi2Tw+m4BLGDof6eUPjbtk=" crossorigin="anonymous"></script> --}}
    <script src="{{ asset('js/rating-star-icons/dist/rating.js') }}"></script>
    <script>
        $('.rating').click(function() {
            var form = $('#formreview');
            var actionUrl = form.attr('action');
            console.log('dd')
            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {}
            });
        })
        $(function() {
            $("#starrate").rating({
                "half": true,
                "click": function(e) {
                    $('#rate').val(e.stars)
                }
            });
        });
        $("#message").click(function() {
            console.log($('#starrate').val())
        })
        $('.addtocart').click(function() {
            let id = $('#idProduct').val()
            let color = $("input[type='radio'].color:checked").val()
            let size = $("input[type='radio'].size:checked").val()
            let quantity = $('.inputquantity').val()
            $.ajax({
                url: "{{ route('cart.addtocart') }}",
                type: 'GET',
                data: {
                    id: id,
                    color: color,
                    size: size,
                    quantity: quantity
                },
                success: function(response) {
                    console.log(response)
                    $('.inputquantity').val(0)
                    $("input[type='radio'].size:checked").attr('data-quantity', response[1])
                    enableButton($('.btn-minus'), true)
                    enableButton($('.addtocart'), true)
                },
                error: function(response) {

                }
            });
        })

        function changeRadio() {
            let data = $("input[type='radio'].color:checked").val()
            let id = $("#idProduct").val()
            console.log('data', data)
            $.ajax({
                url: "{{ route('product.getsizeandimg') }}",
                type: 'GET',
                data: {
                    id: id,
                    color: data
                },
                success: function(response) {
                    let textSize = ''
                    let textImg = ''
                    let check = false;
                    console.log(response)
                    response[1].forEach((element, index) => {
                        textImg += `<div class="carousel-item ${index==0?'active':''}">
                            <img class="w-100 h-100" src=http://localhost/Shop_clothes/public/storage/${element.path} alt="Image">
                        </div>`
                    });
                    // // console.log('length',Object.keys(response[2]).length);
                    // if(response[2].length>0){
                    //     check=true
                    // }
                    response[0].forEach((element, index) => {
                        let count = 0
                        if (Object.keys(response[2]).length) {
                            count = response[2].products.hasOwnProperty(element.idProduct + '_' +
                                element.id) ? response[2].products[element.idProduct + '_' + element
                                .id].quantity : 0
                        }
                        console.log(count)
                        textSize += `<div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input size"
                                 data-quantity=${element.quantity-count}
                                  value=${element.id} id="size-${element.id}" name="size">
                                <label class="custom-control-label" for="size-${element.id}">${element.name}</label>
                            </div>`
                    });
                    enableButton($('.butchange'), true)
                    document.getElementById('listImg').innerHTML = textImg;
                    document.getElementById('listSize').innerHTML = textSize;
                    $('.size').change(function() {
                        if ($("input[type='radio'].size:checked").length > 0) {
                            if ($("input[type='radio'].size:checked").attr('data-quantity') != 0) {
                                $(".inputquantity").val(1)
                                enableButton($('.btn-plus'), false)
                                enableButton($('.btn-minus'), false)
                                enableButton($('.addtocart'), false)
                            } else {
                                $("input[type='radio'].size:checked").val(0)
                                enableButton($('.btn-plus'), true)
                                enableButton($('.btn-minus'), true)
                                enableButton($('.addtocart'), true)
                            }

                        }
                    })
                },
                error: function(response) {

                }
            });
        }

        function activeAddtoCart() {

        }

        $('.addtocart').attr('disabled', true)
        //changeRadio()
        $('.color').change(function() {
            changeRadio()
        })

        function enableButton(e, status) {
            e.attr('disabled', status)
        }
        //  $('.inputquantity').change(function(){
        //     let maxdata=parseInt($("input[type='radio'].size:checked").val())
        //     let data=parseInt($(this).val())
        //     console.log(maxdata,data)
        //     if(data>maxdata){
        //         enableButton($('.add'),true)
        //     }else if(data<=0){
        //         enableButton($('.subtrac'),true)
        //     }else{
        //         enableButton($('.butchange',false))
        //     }
        //  })
        enableButton($('.butchange'), true)
        $('.butchange').on('click', function() {
            var button = $(this);
            let maxdata = parseInt($("input[type='radio'].size:checked").attr('data-quantity'))
            console.log(maxdata)
            var oldValue = button.parent().parent().find('input').val();
            if (button.hasClass('btn-plus')) {
                if (parseFloat(oldValue) + 1 > maxdata) {
                    enableButton($(this), true)
                    enableButton($('.addtocart'), true)
                } else {
                    enableButton($('.btn-minus'), false)
                    enableButton($('.addtocart'), false)
                    var newVal = parseFloat(oldValue) + 1;
                    button.parent().parent().find('input').val(newVal);
                }
            } else {
                if (oldValue > 0) {
                    var newVal = parseFloat(oldValue) - 1;
                    enableButton($('.btn-plus'), false)
                    enableButton($('.addtocart'), false)
                } else {
                    newVal = 0;
                    enableButton($(this), true)
                    enableButton($('.addtocart'), true)
                }
                button.parent().parent().find('input').val(newVal);
            }

        });
    </script>
@endpush
