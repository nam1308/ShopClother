@extends('layout.master')
@section('content')
    <div class="modal fade" id="admin-MaDonHang" tabindex="-1" aria-labelledby="modalOrderAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-user">Chi tiết đơn hàng</h5>
                <button type="button" class="btn rounded-0 shadow-none" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Mã sản phẩm</th>
                            <th>Tên màu</th>
                            <th>Kích cỡ</th>
                            <th>Số lượng mua</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (var item in Model)
                        {
                            <tr>
                                <td>
                                    <a href="/Product/Detail?masanpham=MaSanPham">TenSanPham</a>
                                </td>
                                <td>TenMau</td>
                                <td>KichCo</td>
                                <td>SoLuongMua</td>
                            </tr>
                        }
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary rounded-0 shadow-none" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
@endsection