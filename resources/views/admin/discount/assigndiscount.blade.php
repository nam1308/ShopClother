@extends('layout.master')
@push('css')
    <style>
        .imgchange {
            width: 100%;
            height: 100%;
        }
    </style>
@endpush
@section('content')
    @php
        use App\Enums\DiscountTypeEnum;
    @endphp
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Tạo phiếu giảm giá</span>
            </h5>
            <div class="custom-datatable bg-light p-30 table-responsive">
                <form id="formcategory" class="" action="{{ route('admin.discount.assignuser') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($isedit))
                        <input type="text" class="d-none" name="id" value={{ $isedit }}>
                    @endif
                    <div class="row col-12">
                        <div class="col-md-6 form-group mb-4">
                            <label>Danh sách khuyến mại</label>
                            <input class="form-control shadow-none rounded-0" type="date" id="begin" type="text"
                                name="begin" value={{ isset($discount) ? $discount['begin'] : '' }}>
                            @if ($errors->has('begin'))
                                <div class="error">{{ $errors->first('begin') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label>Thời điểm kết thúc</label>
                            <input class="form-control shadow-none rounded-0" type="date" id="end" name="end"
                                value={{ isset($discount) ? $discount['end'] : '' }}>
                            @if ($errors->has('end'))
                                <div class="error">{{ $errors->first('end') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary closecategory" data-dismiss="modal">Đóng</button>
                        @if (isset($isedit))
                            <button type="submit" class="btn btn-primary save">Cập nhật</button>
                        @else
                            <button type="submit" class="btn btn-primary save">Thêm</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script></script>
@endpush
