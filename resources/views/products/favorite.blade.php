  @extends('layout.master')
  @push('css')
      <style>
          .img-fluid {
              height: 260px;

          }

          .priceitem {
              font-size: .9rem
          }

          .paginationjs-page>a,
          .paginationjs-prev>a,
          .paginationjs-next>a {
              position: relative;
              display: block;
              padding: 0.5rem 0.75rem;
              margin-left: -1px;
              line-height: 1.25;
              color: #FFD333 !important;
              background-color: #fff;
              border: 1px solid #dee2e6;

          }

          .active>a {
              background-color: #ffc107;
              color: white !important;
          }

          .paginationjs-page>a:hover,
          .paginationjs-prev>a:hover,
          .paginationjs-next>a:hover {
              z-index: 2;
              color: #FFD333 !important;
              text-decoration: none;
              background-color: #e9ecef;
              border-color: #dee2e6;
          }

          li {
              list-style: none;
          }

          .paginationjs-pages>ul {
              display: flex;
              justify-content: center;
          }

          .autoComplete_list_1 {
              position: relative;
          }

          #autoComplete_list_1 {
              position: absolute;
              /* transform: translate(0, 20px); */
              z-index: 1;
              top: 38px;
              left: 0px;
              background-color: white;
              padding-left: 10px;
              width: 100%;
          }

          #autoComplete_list_1>li {
              margin-top: 8px;
              margin-bottom: 8px;
          }

          #autoComplete_list_1>li:hover {
              background-color: #f8f8f8
          }
      </style>
      {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.min.css"> --}}
  @endpush
  @section('content')
      <!-- Breadcrumb Start -->
      <div class="container-fluid">
          <div class="row px-xl-5">
              <div class="col-12">
                  <nav class="breadcrumb bg-light mb-30">
                      <a class="breadcrumb-item text-dark" href="{{ route('index') }}">Home</a>
                      <span class="breadcrumb-item active">Shop Favorite</span>
                  </nav>
              </div>
          </div>
      </div>
      <div class="container-fluid">
          <div class="row px-xl-5">
              <div class="col-lg-12 col-md-12">
                  <div class="row pb-3">
                      <h4 class="col-12 mb-5 border-bottom">Sản Phầm Yêu Thích</h4>
                      <div class="col-12 pb-1 row" id="list-products">
                          @forelse ($data as $item)
                              <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                  <div class="product-item bg-light mb-4">
                                      <div class="product-img position-relative overflow-hidden">
                                          <img class="img-fluid w-100 imgProduct"
                                              src="{{ asset('storage/') . '/' . $item['img'][0]['path'] }}" alt="">
                                          <div class="product-action">
                                              <a class="btn btn-outline-dark btn-square"
                                                  href="{{ route('product.productdetail') . '?id=' . $item['id'] }}"><i
                                                      class="fa fa-shopping-cart"></i></a>
                                              <a class="btn btn-outline-dark btn-square remove"
                                                  data-id={{ $item['id'] }}><i class="fa-solid fa-trash"></i></a>
                                          </div>
                                      </div>
                                      <div class="text-center py-4">
                                          <a class="h6 text-decoration-none text-truncate"
                                              href="{{ route('product.productdetail') . '?id=' . $item['id'] }}">{{ $item['name'] }}</a>
                                          <div class="d-flex align-items-center justify-content-center mt-2">
                                              <h5>{{ number_format($item['priceSell'], 0, ',', ',') }} Đ</h5>
                                          </div>
                                          <div class="d-flex align-items-center justify-content-center mt-2">
                                              <h5>{{ $item['brand_product']['name'] }}</h5>
                                          </div>
                                          <div class="d-flex align-items-center justify-content-center mb-1">
                                              <div id="dataReadonlyReview" data-rating-half="true" data-rating-stars="5"
                                                  data-rating-readonly="true" data-rating-value={{ $item['number'] }}
                                                  data-rating-input="#dataReadonlyInput">
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          @empty
                              <h4 class="col-12 text-center">Hiện chưa có sản phẩm yêu thích nào</h4>
                          @endforelse
                      </div>
                      <div class="col-12 pb-1" id="pagination">
                      </div>
                  </div>
              </div>
          </div>
      @endsection
      @push('js')
          <script src={{ asset('js/pagination.js') }}></script>
          <script src="{{ asset('js/rating-star-icons/dist/rating.js') }}"></script>
          <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.28/dist/sweetalert2.all.min.js"></script>
          <script>
              $('.remove').click(function() {
                  let id = $(this).attr('data-id')
                  let ele = $(this)
                  $.ajax({
                      url: "{{ route('product.removefaverite') }}",
                      type: 'GET',
                      data: {
                          id: id,
                      },
                      success: function(response) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Nhận thành công',
                              showConfirmButton: false,
                              timer: 1500
                          })
                          ele.parent().parent().parent().parent().remove()
                          console.log(response)
                      },
                      error: function(response) {

                      }
                  });
              })
          </script>
      @endpush
