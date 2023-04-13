@extends('layout.master')
@push('css')
    <style>
        .img-fluid {
            height: 260px;

        }

        .priceitem {
            font-size: .9rem
        }

        .paginationjs-page>a,
        .paginationjs-prev>a,
        .paginationjs-next>a {
            position: relative;
            display: block;
            padding: 0.5rem 0.75rem;
            margin-left: -1px;
            line-height: 1.25;
            color: #FFD333 !important;
            background-color: #fff;
            border: 1px solid #dee2e6;

        }

        .active>a {
            background-color: #ffc107;
            color: white !important;
        }

        .paginationjs-page>a:hover,
        .paginationjs-prev>a:hover,
        .paginationjs-next>a:hover {
            z-index: 2;
            color: #FFD333 !important;
            text-decoration: none;
            background-color: #e9ecef;
            border-color: #dee2e6;
        }

        li {
            list-style: none;
        }

        .paginationjs-pages>ul {
            display: flex;
            justify-content: center;
        }

        .autoComplete_list_1 {
            position: relative;
        }

        #autoComplete_list_1 {
            position: absolute;
            /* transform: translate(0, 20px); */
            z-index: 1;
            top: 38px;
            left: 0px;
            background-color: white;
            padding-left: 10px;
            width: 100%;
        }

        #autoComplete_list_1>li {
            margin-top: 8px;
            margin-bottom: 8px;
        }

        #autoComplete_list_1>li:hover {
            background-color: #f8f8f8
        }

        .imgtype {
            width: 100%;
            height: 100%;
        }

        .emptyproduct {
            position: absolute;
            z-index: 1;
            background: #6c6c6c;
            color: #fafafa;
            top: 8px;
            right: 6px;
            padding: 1px 10px;
            font-size: .8rem;
            border-radius: 1px;
        }

        .container-spin {
            position: fixed;
            display: inline-block;
            box-sizing: border-box;
            padding: 30px;
            width: 25%;
            height: 140px;
            z-index: 10;
            top: 50%;
            left: 50%;
            transform: translate(-23%, -28%)
        }


        .circle {
            box-sizing: border-box;
            width: 5rem;
            height: 5rem;
            border-radius: 100%;
            border: 10px solid rgba(133, 130, 128, .3);
            border-top-color: yellow;
            animation: spin 1s infinite linear;
        }

        .circleloader {
            position: absolute;
            box-sizing: border-box;
            top: 50%;
            margin-top: -10px;
            border-radius: 16px;
            width: 80px;
            height: 20px;
            padding: 4px;
            background: rgba(255, 255, 255, 0.4);
        }

        .circleloader:before {
            content: '';
            position: absolute;
            border-radius: 16px;
            width: 20px;
            height: 12px;
            left: 0;
            background: #fff;
            animation: push 1s infinite linear;
        }

        .discount {
            position: absolute;
            z-index: 1;
            background: yellow;
            padding: 1rem 0.3rem;
            left: 2rem;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Carousel Start -->
    <div class="container-spin">
        <div class="circle"></div>
    </div>
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-12">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($introduce as $item)
                            <li data-target="#header-carousel" data-slide-to="{{ $i++ }}"
                                class="{{ $loop->first ? 'active' : '' }}">
                            </li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @forelse ($introduce as $item)
                            <div class="carousel-item position-relative {{ $loop->first ? 'active' : '' }}"
                                style="height: 430px;">
                                <img class="position-absolute w-100 h-100"
                                    src="{{ asset('storage') . '/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '') }}"
                                    style="object-fit: cover;">
                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                    <div class="p-3" style="max-width: 700px;">
                                        <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">
                                            {{ $item['title'] }}
                                        </h1>
                                        <p class="mx-md-5 px-5 animate__animated animate__bounceIn">
                                            {{ $item['description'] }}</p>
                                        <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp"
                                            href="{{ route('product.index') }}">Mua Ngay</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Sản Phẩm Chất Lượng</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Miễn Phí Vận Chuyển</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Đôi Trả Trong 14 Ngày</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Hỗ Trợ 24/7</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Phân
                Loại</span></h2>
        <div class="row px-xl-5 pb-3">
            @forelse ($typenav as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    <a class="text-decoration-none" href="{{ route('product.index', ['maphanloai' => $item['id']]) }}">
                        <div class="cat-item d-flex align-items-center mb-4">
                            <div class="overflow-hidden" style="width: 100px; height: 100px;">
                                <img class="img-fluid imgtype" src='{{ asset('storage/' . $item['img'][0]['path']) }}'
                                    alt="">
                            </div>
                            <div class="flex-fill pl-3">
                                <h6>{{ $item['name'] }}</h6>
                                <small class="text-body">{{ $item['product_count'] }} Sản Phẩm</small>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sẩn Phẩm
                Mới</span></h2>
        <div class="row px-xl-5">
            @forelse ($product as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    @if ($item['isdiscount'])
                        <div class="discount-label red"> <span
                                class="discount">{{ $item['persent'] }}{{ $item['unit'] == 1 ? '%' : 'Đ' }}</span> </div>
                    @else
                    @endif

                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src={{ asset('storage/' . $item['img'][0]['path']) }}
                                alt="">
                            @if ($item['quantity'] <= 0)
                                <div class="emptyproduct">hết hàng</div>
                            @endif

                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square addtocart" data-id={{ $item['id'] }}
                                    href="{{ route('product.productdetail', ['id' => $item['id']]) }}"><i
                                        class="fa fa-shopping-cart"></i></a>
                                @if (auth()->check())
                                    <a class="btn btn-outline-dark btn-square addpavorite" data-id={{ $item['id'] }}><i
                                            class="far fa-heart"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('product.productdetail', ['id' => $item['id']]) }}">{{ $item['name'] }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ number_format($item['priceSell'], 0, ',', ',') }} Đ</h5>
                                <h6 class="text-muted ml-2"></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse


        </div>
    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            @forelse ($discountshow as $item)
                <div class="col-md-6">
                    <div class="product-offer mb-30" style="height: 300px;">
                        <img class="img-fluid"
                            src="{{ asset('storage') . '/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '') }}"
                            alt="">
                        <div class="offer-text">
                            <h6 class="text-white text-uppercase">Tiết Kiệm
                                {{ number_format($item['persent'], 0, ',', ',') }}{{ $item['unit'] == 1 ? '%' : 'Đ' }}
                            </h6>
                            <h3 class="text-white mb-3">{{ $item['title'] }}</h3>
                            <a href="{{ route('product.index') }}" class="btn btn-primary" type="button"
                                data-toggle="modal" data-target="#discount_{{ $item['id'] }}">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Sản Phẩm
                Nổi Bật</span></h2>
        <div class="row px-xl-5">
            @forelse ($productfeatured as $item)
                <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                    @if ($item['isdiscount'])
                        <div class="discount-label red"> <span
                                class="discount">{{ $item['persent'] }}{{ $item['unit'] == 1 ? '%' : 'Đ' }}</span> </div>
                    @else
                    @endif
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src={{ asset('storage/' . $item['img'][0]['path']) }}
                                alt="">
                            @if ($item['quantity'] <= 0)
                                <div class="emptyproduct">hết hàng</div>
                            @endif

                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square addtocart" data-id={{ $item['id'] }}
                                    href="{{ route('product.productdetail', ['id' => $item['id']]) }}"><i
                                        class="fa fa-shopping-cart"></i></a>
                                @if (auth()->check())
                                    <a class="btn btn-outline-dark btn-square addpavorite" data-id={{ $item['id'] }}><i
                                            class="far fa-heart"></i></a>
                                @endif
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate"
                                href="{{ route('product.productdetail', ['id' => $item['id']]) }}">{{ $item['name'] }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ number_format($item['priceSell'], 0, ',', ',') }} Đ</h5>
                                <h6 class="text-muted ml-2"></h6>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                                {{-- <div class="review" data-rating-value="{{ $item['number'] }}"></div> --}}
                                <div id="dataReadonlyReview" data-rating-half="true" data-rating-stars="5"
                                    data-rating-readonly="true" data-rating-value={{ $item['number'] }}
                                    data-rating-input="#dataReadonlyInput">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    @forelse ($brand as $item)
                        <div class="bg-light p-4">
                            <img src={{ asset('storage/' . $item['img'][0]['path']) }} alt="">
                        </div>
                    @empty
                    @endforelse


                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
@endsection
@section('modal')
    @forelse ($discountshow as $item)
        <div class="modal fade" id="discount_{{ $item['id'] }}" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="border-radius: 1rem;padding: 0.5rem;">
                    <div class="modal-header">
                        <h5 class="modal-title text-center" id="exampleModalLabel"> Khuyến Mại</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-offer mb-30" style="height: 200px;border-radius: 0.5rem;">
                                    <img class="img-fluid"
                                        src="{{ asset('storage') . '/' . (isset($item['img'][0]) ? $item['img'][0]['path'] : '') }}"
                                        alt="">
                                    <div class="offer-text text-center">
                                        <h3 class="text-white mb-3">{{ $item['title'] }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center"> {{ $item['description'] }}</div>
                            @if ($item['discount'])
                                <div class="col-12 text-center"> {{ $item['discount']['begin'] }} -
                                    {{ $item['discount']['end'] }}</div>
                            @else
                                <div class="col-12 text-center">Đã hết hạn</div>
                            @endif

                        </div>
                    </div>
                    {{-- @php
                        dd($item['discount']['discount_user'] ? '' : 'disabled');
                    @endphp --}}
                    <div class="modal-footer justify-content-center">
                        @if ($item['discount'])
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            @if (auth()->check())
                                <button type="button" class="btn btn-primary adddiscount"
                                    data-id="{{ $item['relate_id'] }}" data-user={{ auth()->user()->id }}
                                    {{ $item['discount']['discount_user'] ? 'disabled' : '' }}>
                                    {{ $item['discount']['discount_user'] ? 'Đã Nhận' : 'Nhận' }}
                                </button>
                            @else
                                <a class="btn btn-primary" href="{{ route('auth.login') }}">Nhận</a>
                            @endif
                        @else
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
@endsection
@push('js')
    <script src="{{ asset('js/rating-star-icons/dist/rating.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        $('.addpavorite').click(function() {
            let id = $(this).attr('data-id')
            $.ajax({
                url: "{{ route('product.addfaverite') }}",
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(response) {
                    $('.faverite').text(response[0]['quantity'])
                    console.log(response)
                },
                error: function(response) {

                }
            });
        })
        $('.adddiscount').click(function() {
            let iduser = $(this).attr('data-user')
            let iddiscount = $(this).attr('data-id')
            let ele = $(this)
            $.ajax({
                url: "{{ route('discount.addtoaccount') }}",
                type: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    iduser: iduser,
                    iddiscount: iddiscount
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Nhận thành công',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    ele.attr('disabled'.true);
                    ele.text('Đã Nhận')
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Đã nhận',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
        $(window).on("load", function() {
            $(".container-spin").fadeOut("fast");
        });
    </script>
@endpush
