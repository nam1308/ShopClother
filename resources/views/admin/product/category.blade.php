@extends('layout.master')
@push('css')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous"> --}}
        {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script> --}}
    <style>
        .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    height: 36px;
    border-radius: 0px;
}
    </style>
@endpush
@section('content')
    
<form action="{{route('admin.product.storedetail')}}" id="fromDetail" class = "row px-xl-3" enctype = "multipart/form-data">
    @csrf
    <input type="text" name='idProduct' class="d-none" value="{{$id}}">
<div class="col-12">
        <h5 class="title position-relative text-dark text-uppercase mb-3 mt-3">
            <span class="bg-secondary pe-3">Thông tin phân loại</span>
        </h5>
        <div class="custom-datatable bg-light p-30 table-responsive">
            <div class="row mb-3">
                <div class="col-md-6 form-group row">
                    <div class="col-md-8 form-group">
                    <label>Màu sắc</label>
                    <select name="color" id="color" class = "form-control color"></select>
                    <div class="errorcolor"></div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary rounded-0 shadow-none mb-3" type="button" data-toggle="modal" data-target="#modalcolor">Thêm Màu</button>
                    </div>
                </div>
                {{-- <div class="col-md-6 form-group">
                    <label>Số lượng</label>
                    <input type="text" name="quantity" id="quantity" class = "form-control shadow-none rounded-0" placeholder = "Số lượng">
                   <div class="errorquantity"></div>
                </div> --}}
                <div class="col-md-6 form-group">
                    <label>Ảnh phân loại</label>
                    <input type="file" name="photo[]" multiple id="photo" class = "form-control shadow-none rounded-0">
                   <div class="errorphoto"></div>
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <button class="btn btn-primary rounded-0 shadow-none addDetail mb-3" type="button">Lưu phân loại</button>
                </div>
            </div>
            <table id="category-color-size-table" class="table table-bordered text-center">
                <thead class="align-middle table-dark">
                    <tr>
                        <th>Tên màu</th>
                        <th>Kích cỡ</th>
                        <th>Số lượng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="align-middle" id="body">
                    {{-- @php
                        dd($list);
                    @endphp --}}
                    @forelse ($list as $item)
                        <tr class="id{{$item['id']}} item">
                            <td class="itemcolor">{{$item['color_product']['name']}}</td>
                            <td class="itemsize size{{$item['id']}}">
                                @php
                                    $i=0;
                                @endphp
                                @forelse ($item['size_product'] as $itemsize)
                                       @if ($i==0)
                                            @php
                                                $i=$i+1;
                                            @endphp
                                            {{$itemsize['name']}}
                                       @else
                                           {{','.$itemsize['name']}}
                                       @endif
                                    
                                @empty
                                    {{'Chưa Có Size'}}
                                @endforelse
                            </td>
                            <td class="itemquantity quantity{{$item['id']}}">{{$item['product_size_detail']?$item['product_size_detail'][0]['sum']:0}}</td>
                            <th class="text-center">
                                <div data-toggle="modal" data-target="#modalupdate" data-id={{$item['id']}} class="btn btn-primary btn-xs m-r-5 update" data-toggle="tooltip"
                                    data-original-title="Sửa"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg></div>
                                <div data-id={{$item['id']}} data-toggle="modal" data-target="#deleteModal"
                                    class="btn btn-danger delete-category btn-xs m-r-5 remove"
                                    data-toggle="tooltip" data-original-title="Xóa"><i class="fa fa-trash font-14"></i></div>
                                <div data-id={{$item['id']}} data-toggle="modal" data-target="#modalSize"
                                    class="btn btn-danger delete-category btn-xs m-r-5 addsize"
                                    data-toggle="tooltip" data-original-title="Xóa">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                        </svg>
                                </div>
                            </th>
                        </tr>
                    @empty
                     
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</form>
@endsection
@section('modal')
    {{-- Them Mau --}}
   <div class="modal fade" id="modalcolor" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Thêm Màu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="formcolor" action="{{ route('admin.color.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        
         <div class="col-md-12 form-group mb-4">
            <label>Tên Màu</label>
            <input class = "form-control shadow-none rounded-0" id="namecolor" name="name" type = "text">
            <span class = "text-danger errorname"></span>
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closetype" data-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-primary" id="addcolor">Thêm</button>
      </div>
    </div>
  </div>
</div>
    {{-- Them Mau --}}
 {{-- Update --}}
<div class="modal fade" id="modalupdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh Sửa Chi Tiết</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="formupdate" action="{{ route('admin.product.storedetail') }}" method="post" enctype="multipart/form-data">
        @csrf
             <input type="number" name='idProduct' class="d-none" id="idProductUpdate" value="{{$id}}">
            <input type="number" id="idUpdate" name='id' class="d-none">
           <div class="container-fluid row mb-3">
                <div class="col-md-12 form-group row colorupdate">
                    <div class="col-md-8 form-group">
                    <label>Màu sắc</label>
                    <select name="color" id="colorUpdate" style="width: 100%" class = "form-control color"></select>
                    <div class="errorcolor"></div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary rounded-0 shadow-none mb-3" type="button" data-toggle="modal" data-target="#modalcolor">Thêm Màu</button>
                    </div>
                </div>
                <div class="col-md-12 form-group row">
                    <div class="col-md-6 form-group imgInput">
                    <label>Ảnh Thêm</label>
                    <input class = "form-control shadow-none rounded-0 file-img" name="photo[]" multiple id="photo" type = "file">
                        <div class="errorphoto"></div>
                    </div>
                    <div class="col-md-4 form-group">
                        <img style="width:100px; height:100%;" class="imgchange" id="imgtype"/>
                    </div>
                </div>
                <input type="number" id="numberImg" name='numberimg' class="d-none">
               
            </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closetype" data-dismiss="modal">Đóng</button>
        <button class="btn btn-primary rounded-0 shadow-none updateDetail" type="button">Lưu phân loại</button>
      </div>
    </div>
  </div>
</div>
    {{-- Update --}}
     {{-- Add size --}}
<div class="modal fade" id="modalSize" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh Sửa Kích Cỡ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="modal-body" id="formsize" action="{{ route('admin.product.storeSize') }}" method="post" enctype="multipart/form-data">
        @csrf
            <input type="number" id="idProductDetail" name='id' class="d-none">
           <div class="container-fluid row mb-3">
                 <div class="col-md-3 form-group">
                    <label>Cỡ Bằng</label>
                      <select name="typesize" id="typeSize" class = "form-control">
                        <option value=1>Chữ</option>
                        <option value=2>Số</option>
                      </select>
                       <div class="error errortypesize"></div>
                </div>
                <div class="col-md-4 form-group">
                    <label>Kích cỡ</label>
                    <select class="form-control size" name="size" style="width: 100%" id="size"></select>
                     <div class="error errorsize"></div>
                </div>
                <div class="col-md-5 form-group" id="sl">
                    <label>Số lượng</label>
                    <input type="text" name="quantity" id="quantityUpdate" class = "form-control shadow-none rounded-0" placeholder = "Số lượng">
                     <div class="error errorquantity"></div>
                </div>
            </div>
      </form>
      <table class="table table-bordered text-center">
        <thead class="align-middle table-dark">
            <th>Size</th>
            <th>Quantity</th>
            <th></th>
        </thead>
        <tbody class="bodylistsize align-middle">
        </tbody>
      </table>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary closetype" data-dismiss="modal">Đóng</button>
        <button class="btn btn-primary rounded-0 shadow-none addSize" type="button">Lưu Kích Cỡ</button>
      </div>
    </div>
  </div>
</div>
    {{-- Add size --}}
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
    <script>
       $('.remove').click(function(){
        id=$(this).attr('data-id')
         $.ajax({
            url: "{{route('admin.product.removedetail')}}",
            type: 'DELETE',
            data:{
                    "_token": "{{ csrf_token() }}",
                id:id
            },
            success: function(response) {
                Swal.fire({
                icon: 'success',
                title: 'Thêm thành công',
                showConfirmButton: false,
                timer: 1500
                })
                obj.closest('.img').remove()
            },
            error: function(response) {
            
            }
        });
        $(this).closest('.item').remove()
       })
        console.log('hien la: ', $(".file-imgdd"))
         
         function setvauleSelect2(e,data){
            if (e.find("option[value=" + data + "]").length) {
                e.val(data).trigger('change');
            }  
        }
        function insetOption(data,obj){
            let inner=`<option value="${data.id}">${data.name}</option>`
            obj.append(inner)
        }
        function changeImg(element){
             var upload_img='';
                $(".file-img").change(function(){
                    let img=$(this).val()
                    console.log('img la: ',img)
                    let e=$(this)
                    console.log(img)
                    const reader=new FileReader();
                    reader.addEventListener("load",function(){
                        upload_img= reader.result;
                        console.log(upload_img)
                        e.closest('.'+element).next().children().attr("src",upload_img)
                    })
                reader.readAsDataURL(this.files[0])
                console.log($(this).val())
        })
        }
         changeImg('imgInput')
        function setValueUpdate(id){
             $.ajax({
                url: '{{route("api.productdetail")}}',
                type: 'get',
                data:{
                    id:id
                },
                success: function(response) {
                    $('#quantityUpdate').val(response.quantity)
                    insetOption(response.color_product,$('#colorUpdate'))
                    setvauleSelect2($('#colorUpdate'),parseInt(response.id_color))
                    // if(!isNaN(response.id_size))
                    // $("#typeSizeUpdate option[value='1']").attr("selected", "selected");
                    // else
                    // $("#typeSizeUpdate option[value='2']").attr("selected", "selected");
                    // insetOption(response.size_product,$('#sizeUpdate'))
                    // setvauleSelect2($('#sizeUpdate'),parseInt(response.id_size))
                    inner='';
                    console.log('d',response)
                    $('.img').remove();
                    let i=0
                    response.img.forEach(function(item,index){
                        console.log(item)
                        i++;
                        inner+=`<div class="col-md-12 form-group row img">
                            <div class="col-md-6 form-group imgupdate">
                            <label>Ảnh đại diện</label>
                            <input class = "form-control shadow-none rounded-0 file-img" name="photo${i}" type = "file">
                            @if($errors->has('photo'))
                                <div class="error">{{ $errors->first('photo') }}</div>
                            @endif
                            </div>
                            <div class="col-md-4 form-group">
                                <img style="width:100px; height:100%;" class="imgchange" src="{{asset('storage/${item.path}')}}" id="imgtype"/>
                            </div>
                            <div data-id=${item.id} class="col-md-2 d-flex align-items-center removeimg"
                                    class="btn btn-danger delete-category btn-xs m-r-5 remove"
                                    data-toggle="tooltip" data-original-title="Xóa"><i class="fa fa-trash font-14"></i>
                            </div>
                        </div>`
                    });
                    $('.removeimg').unbind('click');
                    $('#numberImg').val(i)
                    $('#idUpdate').val(response.id)
                    $('.colorupdate').after(inner)
                    $('.removeimg').click(function(e){
                    let obj=$(this)
                    let id=$(this).attr('data-id')
                    console.log(id)
                      $.ajax({
                            url: "{{route('admin.product.removeimg')}}",
                            type: 'DELETE',
                            data:{
                                 "_token": "{{ csrf_token() }}",
                                id:id
                            },
                            success: function(response) {
                                Swal.fire({
                                icon: 'success',
                                title: 'Thêm thành công',
                                showConfirmButton: false,
                                timer: 1500
                                })
                                obj.closest('.img').remove()
                            },
                            error: function(response) {
                            
                            }
                        });
                    })
                        changeImg('imgupdate')
                       
               
                    },
                error: function(response) {
                }
            });
        }
        $('.remove').click(function(){
             setValueUpdate($(this).attr('data-id'))
        })
        $('.update').click(function(){
            console.log($(this).attr('data-id'))
            setValueUpdate($(this).attr('data-id'))
        })
         $(".color").select2({
                    ajax: {
                        url: '{{ route('api.color') }}',
                        data: function(params) {
                            const queryParameters = {
                                q: params.term,
                            };

                            return queryParameters;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        }
                    }
                });
                
                 $("#size").select2({
                    ajax: {
                        url: '{{ route('api.size') }}',
                        data: function(params) {
                            const queryParameters = {
                                q: params.term,
                                type:$('#typeSize').val()
                            };

                            return queryParameters;
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        }
                    }
                });
     function sumitform(formData,obj,hander){
        console.log(obj.attr('action'),'dd')
         $.ajax({
                url: obj.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                enctype: 'multipart/form-data',
                success: hander,
                error: function(response) {
                    object=response.responseJSON?response.responseJSON.errors:{}
                     for (const property in object) {
                        obj.find('.error'+property).text(object[property][0])
                    }
                }
            });
    }     
    function successColor(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Thêm thành công',
                    showConfirmButton: false,
                    timer: 1500
                    })
                //  obj.find('input').val(null)
                 obj.find('.text-danger').text('')
               
                }      
        $('#addcolor').click(function(){
        console.log('chay')
            const obj = $('#formcolor');
            const formData = new FormData(obj[0]);
           sumitform(formData,obj,successColor)
    })
    $('.addDetail').click(function(){
            const obj = $('#fromDetail');
            const formData = new FormData(obj[0]);
            $.ajax({
                url: obj.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                async: false,
                cache: false,
                enctype: 'multipart/form-data',
                success: function(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Thêm thành công',
                    showConfirmButton: false,
                    timer: 1500
                    })
                  $('#quantity').val(null)
                  $('#photo').val(null)
                 obj.find('.text-danger').text('')
                //  $('#size').val(null).trigger('change');
                 $('#color').val(null).trigger('change');
                   console.log('detal',response)
                   inner=` <tr class="id${response[0].id} item">
                        <td class="itemcolor">${response[1]}</td>
                        <td class="itemsize size${response[0].id}">Hiện Chưa Có</td>
                        <td class="itemquantity quantity${response[0].id}">${response[0].quantity}</td>
                        <th class="text-center">
                                <div data-toggle="modal" data-target="#modalupdate" data-id=${response[0].id} class="btn btn-primary btn-xs m-r-5 update" data-toggle="tooltip"
                                    data-original-title="Sửa"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg></div>
                                <div data-id=${response[0].id} data-toggle="modal" data-target="#deleteModal"
                                    class="btn btn-danger delete-category btn-xs m-r-5 remove"
                                    data-toggle="tooltip" data-original-title="Xóa">
                                        <i class="fa fa-trash font-14"></i>
                                    </div>
                                <div data-id=${response[0].id} data-toggle="modal" data-target="#modalSize"
                                    class="btn btn-danger delete-category btn-xs m-r-5 addsize"
                                    data-toggle="tooltip" data-original-title="Thêm Size">
                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                    </svg>
                                </div>
                                   
                            </th>
                    </tr>`

                    $('#body').append(inner);
                    $('.update').unbind('click')
                     $('.update').click(function(){
                        console.log($(this).attr('data-id'))
                        setValueUpdate($(this).attr('data-id'))
                    })
                    $('.remove').unbind('click')
                     $('.remove').click(function(){
                        setValueUpdate($(this).attr('data-id'))
                    })
                    $('.addsize').unbind('click')
                       $('.addsize').click(function(){
                            let id=$(this).attr('data-id')
                            $.ajax({
                                url: "{{route('admin.product.getsize')}}",
                                type: 'GET',
                                data:{
                                    id:id
                                },
                                success: function(response) {
                                    
                                    console.log(response)
                                    $('#idProductDetail').val(id)
                                    $('.listsize').remove()
                                    inner=''
                                    response.forEach(element => {
                                        inner+=`<tr class="listsize">
                                        <td>${element.info_size.name}<td>
                                        <td><input value=${element.quantity} data-id=${element.id_productdetail} data-size=${element.size}/></td>
                                        <td>  <div data-id=${element.id_productdetail} data-size=${element.size} data-toggle="modal" data-target="#deleteModal"
                                                class="btn btn-danger delete-category btn-xs m-r-5 removesize"
                                                data-toggle="tooltip" data-original-title="Xóa">
                                                    <i class="fa fa-trash font-14"></i>
                                                </div>
                                            </td>
                                        </tr>
                                        `
                                    });
                                $('.bodylistsize').append(inner)
                                $('.removesize').unbind('click')
                                
                                $('.removesize').click(function(){
                                    let idproduct=$(this).attr('data-id')
                                    let idsize=$(this).attr('data-size')
                                        remove($(this),"{{route('admin.product.removesize')}}",idproduct,idsize)
                                })
            },
            error: function(response) {
            
            }
        });
   })
                },
                error: function(response) {
                    console.log(response)
                    object=response.responseJSON?response.responseJSON.errors:{}
                     for (const property in object) {
                        obj.find('.error'+property).text(object[property][0])
                    }
                }
            });
    })
     function successUpdatedetail(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Thêm thành công',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    console.log(response)
                //  obj.find('input').val(null)
                //  obj.find('.text-danger').text('')
                console.log('.id'+$('#idProductUpdate').val()+' .itemcolor')
                $('.id'+$('#idUpdate').val()+' .itemcolor').text(response[1])
                ///$('.id'+$('#idUpdate').val()+' .itemsize').text(response[1])
                $('.id'+$('#idUpdate').val()+' .itemquantity').text(response[0].quantity)
                }      
     
    $('.updateDetail').click(function(){
        const obj = $('#formupdate');
        const formData = new FormData(obj[0]);
       sumitform(formData,obj,successUpdatedetail)
    })
    function remove(e,url,id1,id2){
        $.ajax({
                url: url,
                data:{ "_token": "{{ csrf_token() }}",
                    idproduct:id1,
                    idsize:id2
                },
                type: 'DELETE',
                success:  function(response) {
                    Swal.fire({
                    icon: 'success',
                    title: 'Xóa thành công',
                    showConfirmButton: false,
                    timer: 1500
                    })
                e.closest('.listsize').remove()
                console.log(response)
                resetValueColor(id1,response[0][0].sum,response[1])
                },
                error: function(response) {
                    alert(response.responseJSON.error)
                }
            });
    }
   $('.addsize').click(function(){
        let id=$(this).attr('data-id')
          $.ajax({
            url: "{{route('admin.product.getsize')}}",
            type: 'GET',
            data:{
                id:id
            },
            success: function(response) {
                
                
                $('#idProductDetail').val(id)
                $('.listsize').remove()
                inner=''
                response.forEach(element => {
                    inner+=`<tr class="listsize">
                    <td>${element.info_size.name}</td>
                    <td><input type="number" class="sizeinput" value=${element.quantity} data-id=${element.id_productdetail} data-size=${element.size}></td>
                    <td>  <div data-id=${element.id_productdetail} data-size=${element.size} data-toggle="modal" data-target="#deleteModal"
                            class="btn btn-danger delete-category btn-xs m-r-5 removesize"
                            data-toggle="tooltip" data-original-title="Xóa">
                                <i class="fa fa-trash font-14"></i>
                            </div>
                        </td>
                    </tr>
                    `
                });
                console.log(inner)
               $('.bodylistsize').append(inner)
               $('.removesize').unbind('click')
               
               $('.removesize').click(function(){
                let idproduct=$(this).attr('data-id')
                let idsize=$(this).attr('data-size')
                    remove($(this),"{{route('admin.product.removesize')}}",idproduct,idsize)
               })
               $('.sizeinput').unbind('change')
                 $('.sizeinput').change(function(){
                    console.log($(this))
                    let idproduct=$(this).attr('data-id')
                let idsize=$(this).attr('data-size')
                let quantity=$(this).val()
                $.ajax({
                    url: "{{route('admin.product.changesize')}}",
                    type: 'POST',
                    data:{"_token": "{{ csrf_token() }}",
                        idProductDetail:idproduct,
                        size:idsize,
                        quantity:quantity,
                        
                    },
                    success: function(response) {

                        $('.quantity'+idproduct).text(response[1][0].sum)
                    },
                    error: function(response) {
                    
                    }
                });
                })
            },
            error: function(response) {
            
            }
        });
   })
   function resetValueColor(id,quantity,sizes){
    //console.log(response[1][0].sum)
                $('.quantity'+id).text(quantity?quantity:0)
                let listsize=''
                let i=true;
                sizes.forEach(element => {
                    if(i){
                        listsize+=element.info_size.name
                        i=false
                    }else{
                        listsize+=','+element.info_size.name
                    }
                    
                });
                $('.size'+id).text(listsize?listsize:'Chưa Có Size')
   }
      
   function successAddSize(response){
    console.log(response)
                 inner=''
                    inner+=`<tr class="listsize">
                    <td>${response[0][0].info_size.name}</td>
                    <td><input type="number" class="sizeinput" value=${response[0][0].quantity} data-id=${response[0][0].id_productdetail} data-size=${response[0][0].size}></td>
                    <td>  <div data-id=${response[0][0].id_productdetail} data-size=${response[0][0].size} data-toggle="modal" data-target="#deleteModal"
                            class="btn btn-danger delete-category btn-xs m-r-5 removesize"
                            data-toggle="tooltip" data-original-title="Xóa">
                                <i class="fa fa-trash font-14"></i>
                            </div>
                        </td>
                    </tr>`
                    console.log(inner)
               $('.bodylistsize').append(inner)
               $('#formsize error').text('')
               $('#formsize #quantityUpdate').val(null)
               $('#formsize .size').val(null).trigger('change');
               $('.removesize').unbind('click')
               $('.removesize').click(function(){
                let idproduct=$(this).attr('data-id')
                let idsize=$(this).attr('data-size')
                remove($(this),"{{route('admin.product.removesize')}}",idproduct,idsize)
                
               })
                let id=$('#idProductDetail').val()
                resetValueColor(id,response[1][0].sum,response[2])
                $('.sizeinput').unbind('change')
                $('.sizeinput').change(function(){
                    console.log($(this))
                    let idproduct=$(this).attr('data-id')
                let idsize=$(this).attr('data-size')
                let quantity=$(this).val()
                $.ajax({
                    url: "{{route('admin.product.changesize')}}",
                    type: 'POST',
                    data:{"_token": "{{ csrf_token() }}",
                        idProductDetail:idproduct,
                        size:idsize,
                        quantity:quantity,
                        
                    },
                    success: function(response) {
                        $('.quantity'+idproduct).text(response[1][0].sum)
                    },
                    error: function(response) {
                    
                    }
                });
                })
   }
   
   $('.addSize').click(function(){
     const obj = $('#formsize');
        const formData = new FormData(obj[0]);
       sumitform(formData,obj,successAddSize)
   })
    </script>
@endpush