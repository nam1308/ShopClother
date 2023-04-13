@extends('layout.master')
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Bảng điều khiển</span>
            </h5>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>ProductCount</h4>
                        <span>Sản phẩm</span>
                    </div>
                    <i class="fas fa-box"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.product.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>UserCount & Order</h4>
                        <span>Người dùng và Đơn hàng</span>
                    </div>
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.customers.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Order Import</h4>
                        <span>Hóa đơn nhập</span>
                    </div>
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.orderimport.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Brand</h4>
                        <span>Nhãn hàng</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.brand.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Statistical</h4>
                        <span>Thông kê</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.statistical.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Type</h4>
                        <span>Phân loại</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.type.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Discount</h4>
                        <span>Khuyến Mại</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.discount.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        {{-- <div class="col-xxl-3 col-sm-4 col-12">
            <div class="card bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Import</h4>
                        <span>Nhập Hàng</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.orderimport.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div> --}}
        <div class="col-xxl-3 col-sm-4 col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Introduce</h4>
                        <span>Giơi Thiệu</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.introduce.banner') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Shipping Fee</h4>
                        <span>Giá Vận Chuyển</span>
                    </div>
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.ship.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Supplier</h4>
                        <span>Nhà Cung Cấp</span>
                    </div>
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.supplier.index') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-sm-4 col-12">
            <div class="card bg-success text-white">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-body__info">
                        <h4>Send Notifications</h4>
                        <span>Gửi Thông Báo</span>
                    </div>
                    <i class="fas fa-coins"></i>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-center">
                    <a class="text-white" href="{{ route('admin.customers.viewsendnotification') }}">
                        Xem chi tiết
                        <i class="fas fa-arrow-alt-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
