@extends('layout.master')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@push('css')
    <style>
        .imgchange {
            width: 100%;
            height: 100%;
        }

        .error {
            color: red;
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 1px solid #aaa;
            height: 36px;
            border-radius: 0px;
        }
    </style>
@endpush
@section('content')
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Thông tin nhà cung cấp</span>
            </h5>
            @if ($errors->has('msg'))
                <div class="error">{{ $errors->first('msg') }}</div>
            @endif
            <div class="custom-datatable bg-light p-30 table-responsive">
                <form id="formcategory" action="{{ route('admin.supplier.store') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @if (isset($isedit))
                        <input type="text" name="id" class="d-none" value={{ $supplier['id'] }}>
                    @endif
                    <div class="row col-12">
                        <div class="col-md-6 form-group">
                            <label>Tên</label>
                            <input class="form-control shadow-none rounded-0" id="namecategory" type="text"
                                name="name"
                                value={{ isset($supplier) ? ($errors->has('name') ? '' : $supplier['name']) : old('name') }}>
                            @if ($errors->has('name'))
                                <div class="error">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Điện thoại</label>
                            <input class="form-control phone" name="phone" type="text"
                                value={{ isset($supplier) ? ($errors->has('phone') ? '' : $supplier['phone']) : old('phone') }}>
                            @if ($errors->has('phone'))
                                <div class="error">{{ $errors->first('phone') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control email" name="email" type="text" placeholder="example@email.com"
                                value="{{ isset($supplier) ? ($errors->has('email') ? '' : $supplier['email']) : old('email') }}">
                            @if ($errors->has('email'))
                                <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group mb-4">
                            <label>Quốc gia</label>
                            <select class="form-control shadow-none rounded-0" id="country" name="country">
                            </select>
                            @if ($errors->has('country'))
                                <div class="error">{{ $errors->first('country') }}</div>
                            @endif
                        </div>
                        <div class="col-md-6 form-group">
                            <label>Địa chỉ</label>
                            <input class="form-control address" name="address" type="text"
                                value="{{ isset($supplier) ? ($errors->has('address') ? '' : $supplier['address']) : old('address') }}">
                            @if ($errors->has('address'))
                                <div class="error">{{ $errors->first('address') }}</div>
                            @endif
                        </div>
                        <div class="col-6 form-group">
                            <label class="">Thành phố</label>
                            <select class="form-control city" name="city"></select>
                            @if ($errors->has('city'))
                                <div class="error">{{ $errors->first('city') }}</div>
                            @endif
                        </div>
                        <div class="col-6 form-group">
                            <label class="">Quận/Huyện</label>
                            <select class="form-control district" name="district"></select>
                            @if ($errors->has('district'))
                                <div class="error">{{ $errors->first('district') }}</div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
        async function getcountry() {
            const res = await fetch('{{ asset('location/country.json') }}');
            const countries = await res.json();
            console.log(countries)
            let inner = '';
            let data = countries.data
            let olddata =
                "{{ !empty(old('country')) ? old('country') : (isset($supplier) ? $supplier['country'] : '') }}";
            for (const key in data) {

                inner +=
                    `<option value='${data[key]['country']}' ${olddata==data[key]['country']?'selected':''}>${data[key]['country']}</option>`
            }

            $('#country').append(inner)
        }
        getcountry()
        async function loadDistrict(path) {
            $(".district").empty()
            const response = await fetch('{{ asset('location/data') }}' + '/' + path);
            const districts = await response.json();
            let string = '';
            // const selectedValue = $(".district").val();
            const selectedValue =
                "{{ !empty(old('district')) ? old('district') : (isset($supplier) ? $supplier['district'] : '') }}";
            console.log(path)
            $.each(districts.district, function(index, each) {
                if (each.pre === 'Quận' || each.pre === 'Huyện') {
                    string +=
                        `<option value='${each.name}' ${each.name==selectedValue?'selected':''}>${each.name}</option>`;
                }
            })
            $(".district").append(string);

            if (!selectedValue) {

                $('.district').val(null).trigger('change');
            }

        }
        async function insertCity() {
            const response = await fetch('{{ asset('location/index.json') }}');
            const cities = await response.json();
            console.log(cities)
            let oldval = "{{ isset($supplier) ? $supplier['city'] : '' }}"
            $.each(cities, function(index, each) {
                $(".city").append(
                    `
                    <option value='${index}' data-path='${each.file_path}' ${index==oldval?'selected':''}>${index}</option>`
                )
            })

            let city = "{{ !empty(old('city')) ? old('city') : '' }}"
            if (city) {
                setValueSelect($('.city'), city)
            } else if ($('.city').val()) {
                let path = $(".city option:selected").data('path')
                let array = path.split("/");
                console.log('gia tri la: ', array[2])
                loadDistrict(array[2])
            } else {
                $('.city').val(null).trigger('change');
            }
        }
        insertCity()

        function setValueSelect(e, data) {
            console.log(e.find("option[value='" + data + "']").length)
            if (e.find("option[value='" + data + "']").length) {
                e.val(data).trigger('change');
            }
        }

        $(".city").select2({
            tags: true
        });
        $(".district").select2({
            tags: true
        });
        $(document).on('change', '.city', function() {
            if ($(this).val()) {
                console.log($('.city').parent().find(".city option:selected").data('path'))
                let path = $('.city').parent().find(".city option:selected").data('path')
                let array = path.split("/");
                loadDistrict(array[2])
            }
        })
    </script>
@endpush
