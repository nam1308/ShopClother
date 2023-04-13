@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            height: 36px;
            border-radius: 0px;
        }

        .error {
            color: red !important;
        }
    </style>
@endpush
@section('content')
    <form action="{{ route('admin.introduce.store') }}" class="row px-xl-3" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="type" class="d-none" value={{ $type }}>
        <input type="text" name="index" class="d-none" value={{ $index }}>
        @if (isset($isedit))
            <input type="text" name="id" class="d-none" value={{ $olddata['id'] }} />
        @endif
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Thông tin chung</span>
            </h5>
            <div class="bg-light p-30">
                @if ($errors->has('msg'))
                    <div class="error">{{ $errors->first('msg') }}</div>
                @endif
                <div class="row">
                    @if (isset($edit))
                        <input type="text" class="d-none" value={{ $product['id'] }} name="id">
                    @endif
                    @if ($type == 1)
                        <div class="col-md-4 form-group">
                            <label>Khuyến mại</label>
                            <select name="relate_id" id="discount" class="form-control">
                                <option value=0>--Chọn--</option>
                                @forelse ($discount as $item)
                                    <option
                                        {{ isset($olddata) ? ($olddata['relate_id'] == $item['id'] ? 'selected' : '') : (old('relate_id') == $item['id'] ? 'selected' : '') }}
                                        value={{ $item['id'] }}>
                                        {{ $item['name'] }}</option>
                                @empty
                                @endforelse
                            </select>
                            @if ($errors->has('id'))
                                <div class="error">{{ $errors->first('id') }}</div>
                            @endif
                        </div>
                    @endif

                    <div class="col-md-4 form-group">
                        <label>Tiêu Đề</label>
                        <input name="title" id="title" class="form-control"
                            value="{{ isset($olddata) ? $olddata['title'] : old('title') }}" />
                        @if ($errors->has('title'))
                            <div class="error">{{ $errors->first('title') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Mô Tả</label>
                        <textarea name="description" class="form-control" id="description">{{ isset($olddata) ? $olddata['description'] : old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <div class="error">{{ $errors->first('description') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group">
                        <label>Link</label>
                        <input name="link" id="link" class="form-control"
                            value="{{ isset($olddata) ? $olddata['link'] : old('link') }}" />
                        @if ($errors->has('link'))
                            <div class="error">{{ $errors->first('link') }}</div>
                        @endif
                    </div>
                    <div class="col-md-4 form-group row mt-3">
                        <div class="col-md-6 form-group imgInput">
                            <label>Ảnh Thêm</label>
                            <input class="form-control shadow-none rounded-0 file-img" name="photo" id="photo"
                                type="file">
                            @if ($errors->has('photo'))
                                <div class="error">{{ $errors->first('photo') }}</div>
                            @endif
                        </div>
                        <div class="col-md-4 form-group">
                            <img style="width:100px; height:100%;" class="imgchange" id="imgdiscount"
                                src="{{ asset('storage') . '/' . (isset($olddata['img'][0]) ? $olddata['img'][0]['path'] : '') }}" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary rounded-0 shadow-none mt-5">Lưu Thông Tin</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        var upload_img = '';
        $(".file-img").change(function() {
            let img = $(this).val()
            let e = $(this)
            console.log(img)
            const reader = new FileReader();
            reader.addEventListener("load", function() {
                upload_img = reader.result;
                $('.imgchange').attr("src", upload_img)
            })
            reader.readAsDataURL(this.files[0])
            console.log($(this).val())
        })
        $("#discount").select2();
        $('#discount').on('change', function() {
            if ($(this).val()) {
                let id = $(this).val()
                $.ajax({
                    url: "{{ route('api.discountbyid') }}?id=" + id,
                    type: 'GET',
                    success: function(response) {
                        if (response) {
                            console.log(response)
                            $('#title').val(response['name'])
                            $('#description').text(response['discription'])
                            // let img = response['img'].length > 0 ? response['img'][0]['path'] : '';
                            // console.log(img)
                            // $('#imgdiscount').attr('src', "{{ asset('storage') }}/" + img)
                        }
                    },
                    error: function(response) {

                    }
                });
            }
        })
    </script>
@endpush
