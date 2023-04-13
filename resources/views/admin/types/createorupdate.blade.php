@extends('layout.master')
@push('css')
    <style>
        .imgchange {
            width: 100%;
            height: 100%;
        }

        .errorname {
            color: red;

        }
    </style>
@endpush
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Thông tin phân loại</span>
            </h5>
            <span class="text-danger errorname">
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif
            </span>
            <div class="custom-datatable bg-light p-30 table-responsive">
                <form id="formcategory" class="" action="{{ route('admin.type.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($isedit))
                        <input type="text" name="id" class="d-none" value={{ $idtype }} id="id">
                    @endif
                    <div class="col-md-6 form-group mb-4">
                        <label>Tên Loại</label>
                        <input class="form-control shadow-none rounded-0" id="namecategory" type="text" name="name"
                            value={{ isset($type) ? $type['name'] : '' }}>
                        <span class="text-danger errorname">
                            @if ($errors->has('name'))
                                {{ $errors->first('name') }}
                            @endif
                        </span>
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Ảnh</label>
                        <input class="form-control shadow-none rounded-0  file-img" name="photo" id="photocategory"
                            type="file">
                        <span class="text-danger errorphoto">
                            @if ($errors->has('photo'))
                                {{ $errors->first('photo') }}
                            @endif
                        </span>
                    </div>
                    <div class="col-md-6 form-group">
                        <img style="width:200px; height:100%;"
                            src="{{ isset($type) ? asset('storage/' . $type['img'][0]['path']) : '' }}" class="imgchange"
                            id="imgcategory" />
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
    </script>
@endpush
