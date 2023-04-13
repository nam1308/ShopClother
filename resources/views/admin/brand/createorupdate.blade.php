@extends('layout.master')
@push('css')
    <style>
        .imgchange {
            width: 100%;
            height: 100%;
        }

        .error {
            color: red;
        }
    </style>
@endpush
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Thông tin nhãn hàng</span>
            </h5>
            @if ($errors->has('msg'))
                <div class="error">{{ $errors->first('msg') }}</div>
            @endif
            <div class="custom-datatable bg-light p-30 table-responsive">
                <form id="formcategory" action="{{ route('admin.brand.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($isedit))
                        <input type="text" name="id" class="d-none" value={{ $brand['id'] }} id="id">
                    @endif
                    <div class="row col-12">
                        <div class="col-md-4 form-group mb-4">
                            <label>Tên</label>
                            <input class="form-control shadow-none rounded-0" id="namecategory" type="text"
                                name="name" value={{ isset($brand) ? $brand['name'] : '' }}>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label>Quốc gia</label>
                            <select class="form-control shadow-none rounded-0" id="country" name="country">
                            </select>
                            @if ($errors->has('country'))
                                <div class="error">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="col-md-4 form-group mb-4">
                            <label>Website</label>
                            <input type="text" class="form-control shadow-none rounded-0" id="website" name="website">
                            @if ($errors->has('website'))
                                <div class="error">{{ $errors->first('website') }}</div>
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
                                    src="{{ isset($brand) ? asset('storage/' . (isset($brand['img'][0]) ? $brand['img'][0]['path'] : '')) : '' }}"
                                    class="imgchange" id="imgcategory" />
                            </div>
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label>Mô tả</label>
                            <textarea class="form-control shadow-none rounded-0" rows="8" id="namecategory" type="text" name="description">
                @if (isset($brand))
{{ $brand['description'] }}
@endif
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
        async function getcountry() {
            const res = await fetch('{{ asset('location/country.json') }}');
            const countries = await res.json();
            console.log(countries)
            let inner = '';
            let data = countries.data
            for (const key in data) {

                inner += `<option value='${data[key]['country']}'>${data[key]['country']}</option>`
            }

            $('#country').append(inner)
        }
        getcountry()
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
