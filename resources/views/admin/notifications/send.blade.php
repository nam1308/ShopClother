@extends('layout.master')
@push('css')
    <style>
        .img {
            width: 172px;
            height: 70px;
        }

        .menu {
            padding: 0px !important;
        }

        .menu ul {
            background-color: #FFD333;
            padding: 0px !important;
            border-radius: 3px;
        }

        .menu ul li a {
            color: white;
        }

        p {
            margin: 0px !important;
        }

        li:hover {
            background-color: #ffc107;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row" id="accordion">
            <form action="{{ route('admin.customers.sendnotification') }}" class="contaier" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-6 form-group mb-4 text-center">
                        <label>Tiêu Đề</label>
                        <input class="form-control shadow-none rounded-0" id="namecategory" type="text" name="name"
                            value={{ isset($brand) ? $brand['name'] : '' }}>
                        @if ($errors->has('name'))
                            <div class="error">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="col-12 row justify-content-center">
                        <div class="col-5 form-group">
                            <div class="col-12 form-group text-center">
                                <label>Ảnh</label>
                                <input class="form-control file-img" name="photo" id="photocategory" type="file">
                                @if ($errors->has('photo'))
                                    <div class="error">{{ $errors->first('photo') }}</div>
                                @endif
                            </div>
                            <div class="col-12">
                                <img style="width:100%; height:13rem;"
                                    src="{{ isset($brand) ? asset('storage/' . (isset($brand['img'][0]) ? $brand['img'][0]['path'] : '')) : '' }}"
                                    class="imgchange" id="imgcategory" />
                            </div>
                        </div>

                    </div>
                    <div class="col-12">
                        <textarea name="message" id="editor" rows="10" cols="100">
                    </textarea>
                    </div>

                </div>
                <input type="submit" class="btn btn-primary mt-3" value="Send">
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor/style.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        CKEDITOR.replace('editor');
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
