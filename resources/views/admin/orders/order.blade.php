@extends('layout.master')
@section('content')
    

<div class="row px-xl-3">
    <div class="col-12">
        <h5 class="title position-relative text-dark text-uppercase mb-3">
            <span class="bg-secondary pe-3">Danh sách đơn hàng</span>
        </h5>
        <div class="custom-datatable bg-light p-30 table-responsive">
            <table id="order-table" class="table table-bordered text-center">
                <thead class="align-middle table-dark">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Thông tin chung</th>
                        <th>Phương thức thanh toán</th>
                        <th>Tình trạng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach (var orderItem in Model)
                    {
                        <tr>
                            <td>MaDonHang</td>
                            <td>
                                - Tên khách hàng: TenKhachHang <br>
                                - Số điện thoại: SoDienThoaiNhanHang <br>
                                - Địa chỉ giao hàng:DiaChiGiaoHang <br>
                                - Ngày đặt hàng: NgayDatHang.ToString("dd/MM/yyyy") <br>
                                - Ghi chú: Trước khi giao hàng gọi trước 30 phút <br>
                            </td>
                            <td>PTThanhToan</td>
                            <td>TinhTrang</td>
                            <td class="align-middle">
                                <button class="btn btn-primary btn-sm shadow-none rounded-0 mb-2" data-bs-toggle="modal" data-bs-target="#admin-@orderItem.MaDonHang">
                                    <i class="fas fa-eye me-2"></i>Xem
                                </button>
                                <form action="" class = "d-inline" method="POST">
                                     <button class="btn btn-danger btn-sm shadow-none rounded-0 mb-2">
                                        <i class="fas fa-times me-2"></i>Huỷ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    }
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection