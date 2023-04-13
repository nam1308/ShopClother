@extends('layout.master')
@push('css')
    <style>
        .img {
            width: 172px;
            height: 100px;
        }

        .itemimg {
            width: 20%;
            height: 50%;
        }

        .itemcount {
            width: 11%;
        }

        .custom {
            width: 20%;
        }

        .buttonchange {
            width: 100%;
        }

        .buttoncate {
            width: 30%;
        }
    </style>
@endpush
@section('content')
    @php
        use App\Enums\TypeShipEnum;
    @endphp
    <div class="row px-xl-3">
        <div class="col-12">
            <h5 class="title position-relative text-dark text-uppercase mb-3">
                <span class="bg-secondary pe-3">Phí Vận Chuyển</span>
            </h5>
            <div class="custom-datatable bg-light p-30 table-responsive d-flex justify-content-center">
                <div class="col-5">
                    <label for="shiptitle">Vùng vận chuyển</label>
                    <select name="shiptitle" class="form-control" id="shiptitle">
                        @forelse ($list as $item)
                            <option data-price={{ $item['price'] }} value={{ $item['id'] }}>
                                {{ TypeShipEnum::getType($item['location']) }}</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="col-4 ml-2">
                    <label for="price">Giá</label>
                    <input type="text" id="price" class="form-control" value={{ $list[0]['price'] }}>
                </div>
                <button type="button" class="btn btn-primary mt-4 ml-2 col-1 update">Cập nhật</button>
            </div>
        </div>
    @endsection

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
        <script>
            $('#shiptitle').change(function() {
                let price = $(this).find(":selected").attr('data-price');
                $('#price').val(price)
            })
            $('.update').click(function() {
                $.ajax({
                    url: "{{ route('admin.ship.update') }}",
                    type: 'PUT',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: $('#shiptitle').val(),
                        price: $('#price').val(),
                    },
                    success: function(response) {
                        console.log(response)
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        $('#shiptitle').find(":selected").attr('data-price', $('#price').val());
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cập nhật thất bại',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                });
            })
        </script>
    @endpush
