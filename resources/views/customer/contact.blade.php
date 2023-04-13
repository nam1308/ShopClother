@extends('layout.master')
@push('css')
    <style>
        .mapouter {
            position: relative;
            text-align: right;
            width: 400px;
            height: 250px;
        }

        .gmap_canvas {
            overflow: hidden;
            background: none !important;
            width: 400px;
            height: 250px;
        }

        .gmap_iframe {
            width: 400px !important;
            height: 250px !important;
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
                    <span class="breadcrumb-item active">Contact</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->


    <!-- Contact Start -->
    <div class="container-fluid">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Kết Nối Với
                Chúng Tôi</span></h2>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form bg-light p-30">
                    <div id="success"></div>
                    <p class="help-block text-danger">
                        @if ($errors->has('msg'))
                            {{ $errors->first('msg') }}
                        @endif
                    </p>
                    <form name="sentMessage" id="contactForm" action="{{ route('user.sendmessage') }}"
                        novalidate="novalidate" method="POST">
                        @csrf
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name"
                                required="required" data-validation-required-message="Please enter your name" />
                            <p class="help-block text-danger">
                                @if ($errors->has('name'))
                                    {{ $errors->first('name') }}
                                @endif
                            </p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Your Email" required="required"
                                data-validation-required-message="Please enter your email" />
                            <p class="help-block text-danger">
                                @if ($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" rows="8" id="message" name="message" placeholder="Message" required="required"
                                data-validation-required-message="Please enter your message"></textarea>
                            <p class="help-block text-danger">
                                @if ($errors->has('message'))
                                    {{ $errors->first('message') }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <div class="bg-light p-30 mb-30">
                    <div class="mapouter" style="width: 100%;overflow:hidden;">
                        <div class="gmap_canvas" style="width: 100%;overflow:hidden;"><iframe class="gmap_iframe"
                                style="width: 100% !important;height: 250px !important;" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=400&amp;height=250&amp;hl=en&amp;q=số 3 Cầu giấy&amp;t=&amp;z=16&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe><a
                                href="https://piratebay-proxys.com/">Piratebay</a></div>

                    </div>
                </div>
                <div class="bg-light p-30 mb-3">
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Số 3, Cầu Giấy, Hà Nội</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>khanhdeptrai@gmail.com</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>012 345 6789</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
