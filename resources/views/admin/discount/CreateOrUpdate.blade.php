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
                <form id="formcategory" class="" action="{{ route('admin.discount.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($isedit))
                        <input type="text" class="d-none" name="id" value={{ $isedit }}>
                    @endif
                    <div class="row col-12">
                        <div class="col-md-6 form-group mb-4">
                            <label>Loại</label>
                            <select class="form-control shadow-none rounded-0" id="type" name="type">
                                @forelse (DiscountTypeEnum::getValues() as $item)
                                    <option {{ isset($discount) ? ($discount['type'] == $item ? 'selected' : '') : '' }}
                                        value={{ $item }}>
                                        {{ DiscountTypeEnum::getTypesOfDiscount($item) }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('type'))
                                <div class="error">{{ $errors->first('type') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label>Mã</label>
                            <input class="form-control shadow-none rounded-0" id="code" type="text" name="code"
                                value={{ isset($discount) ? $discount['code'] : '' }}>
                            @if ($errors->has('code'))
                                <div class="error">{{ $errors->first('code') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="row col-12">
                        <div class="col-md-12 form-group mb-4">
                            <label>Sản Phẩm</label>
                            <select class="form-control shadow-none rounded-0" id="product" name="product"
                                {{ isset($discount) ? ($discount['type'] != 1 ? 'disabled' : '') : '' }}>
                                @forelse ($listproduct as $item)
                                    <option
                                        {{ isset($discount) ? ($discount['type'] == 1 && $discount['relation_id'] == $item['id'] ? 'selected' : '') : '' }}
                                        value={{ $item['id'] }}>
                                        {{ $item['name'] }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('product'))
                                <div class="error">{{ $errors->first('product') }}</div>
                            @endif
                        </div>

                    </div>
                    <div class="row col-12">
                        <div class="col-md-6 form-group mb-4">
                            <label>Thời điểm bắt đầu</label>
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
                    <div class="row col-12">
                        <div class="col-md-6 form-group mb-4">
                            <label>Tên</label>
                            <input class="form-control shadow-none rounded-0" id="name" type="text" name="name"
                                value={{ isset($discount) ? $discount['name'] : '' }}>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-3 form-group mb-4">
                            <label>Số tiền khuyến mãi</label>
                            <input class="form-control shadow-none rounded-0" type="number" id="persent" name="persent"
                                value={{ isset($discount) ? $discount['persent'] : '' }}>
                            @if ($errors->has('persent'))
                                <div class="error">{{ $errors->first('persent') }}</div>
                            @endif
                        </div>
                        <div class="col-md-3 form-group mb-4">
                            <label>Đơn vị</label>
                            <select class="form-control shadow-none rounded-0" type="number" id="unit" name="unit">
                                <option {{ isset($discount) ? ($discount['unit'] == 1 ? 'selected' : '') : '' }} value=1>%
                                </option>
                                <option {{ isset($discount) ? ($discount['unit'] == 2 ? 'selected' : '') : '' }} value=2>Đ
                                </option>
                            </select>
                            @if ($errors->has('unit'))
                                <div class="error">{{ $errors->first('unit') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="row col-12">
                        <div class="col-md-6 form-group">
                            <div class="col-md-6 form-group">
                                <label>Ảnh</label>
                                <input class="form-control file-img" name="photo" id="photocategory" type="file">
                                @if ($errors->has('photo'))
                                    <div class="error">{{ $errors->first('photo') }}</div>
                                @endif
                            </div>
                            <div class="col-md-6">

                                <img style="width:200px; height:100%;"
                                    src="{{ isset($discount) ? asset('storage/' . (isset($discount['img'][0]) ? $discount['img'][0]['path'] : '')) : '' }}"
                                    class="imgchange" id="imgcategory" />
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label>Mô tả</label>
                            <textarea class="form-control shadow-none rounded-0" rows="8" id="namecategory" type="text" name="description">{{ isset($discount['discription']) ? $discount['discription'] : '' }}
                            </textarea>
                            @if ($errors->has('description'))
                                <div class="error">{{ $errors->first('description') }}</div>
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
    <script>
        var upload_img = '';
        $(".file-img").change(function() {
            let img = $(this).val()
            let e = $(this)
            console.log(img)
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                upload_img = reader.result;
                console.log(upload_img)
                $('.imgchange').attr("src", upload_img)
            })
            reader.readAsDataURL(this.files[0])
            console.log($(this).val())
        })
        $('#type').change(function() {
            let value = $(this).val()
            if (value == 1) {
                $('#product').attr('disabled', false)
            } else $('#product').attr('disabled', true)
        })
    </script>
@endpush
