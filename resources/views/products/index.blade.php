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

          .discount {
              position: absolute;
              z-index: 1;
              background: yellow;
              padding: 1rem 0.3rem;
              left: 2rem;
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
                      <span class="breadcrumb-item active">Shop List</span>
                  </nav>
              </div>
          </div>
      </div>
      <!-- Breadcrumb End -->


      <!-- Shop Start -->
      <div class="container-fluid">
          <div class="row px-xl-5">
              <!-- Shop Sidebar Start -->
              <div class="col-lg-3 col-md-4">
                  <!-- Price Start -->
                  <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                          giá</span></h5>
                  <div class="bg-light p-4 mb-30">
                      <form>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice" checked id="price-all">
                              <label class="custom-control-label priceall" for="price-all">Tất cả các giá</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price="< 100.000Đ" id="price-1">
                              <label class="custom-control-label lbprice priceitem" for="price-1">
                                  < 100.000Đ</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price="100.000Đ - 200.000Đ" id="price-2">
                              <label class="custom-control-label lbprice priceitem" for="price-2">100.000Đ -
                                  200.000Đ</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price='200000Đ - 400000Đ' id="price-3">
                              <label class="custom-control-label lbprice priceitem" for="price-3">200.000 -
                                  400.000Đ</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price="400.000Đ - 600.000Đ" id="price-4">
                              <label class="custom-control-label lbprice priceitem" for="price-4">400.000Đ -
                                  600.000Đ</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3 price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price="600.000Đ - 1000.000Đ" id="price-5">
                              <label class="custom-control-label lbprice priceitem" for="price-5">600.000Đ -
                                  1000.000Đ</label>
                          </div>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between price">
                              <input type="checkbox" class="custom-control-input inputPrice inputPriceitem"
                                  data-price="> 1000.000Đ" id="price-6">
                              <label class="custom-control-label lbprice priceitem" for="price-6">> 1000.000Đ</label>

                          </div>
                      </form>
                  </div>
                  <!-- Price End -->

                  <!-- Color Start -->
                  <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                          loại</span></h5>
                  <div class="bg-light p-4 mb-30">
                      <form>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                              <input type="checkbox" class="custom-control-input typeall" value=0 checked id="type-all">
                              <label class="custom-control-label" for="type-all">Tất cả</label>
                              <span class="badge border font-weight-normal">1000</span>
                          </div>
                          @forelse ($type as $item)
                              <div
                                  class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                  <input type="checkbox" class="custom-control-input type" value={{ $item['id'] }}
                                      id="type-{{ $item['id'] }}">
                                  <label class="custom-control-label"
                                      for="type-{{ $item['id'] }}">{{ $item['name'] }}</label>
                                  <span class="badge border font-weight-normal">150</span>
                              </div>
                          @empty
                          @endforelse
                      </form>

                  </div>
                  <!-- Color End -->

                  <!-- Size Start -->
                  <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Lọc theo
                          phân loại</span></h5>
                  <div class="bg-light p-4 mb-30">
                      <form>
                          <div
                              class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                              <input type="checkbox" class="custom-control-input categoryall" checked id="category-all">
                              <label class="custom-control-label" for="category-all">Tất cả</label>
                              <span class="badge border font-weight-normal">1000</span>
                          </div>
                          @forelse ($categories as $item)
                              <div
                                  class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                  <input type="checkbox" class="custom-control-input category" value={{ $item['id'] }}
                                      id="category-{{ $item['id'] }}">
                                  <label class="custom-control-label" for="category-{{ $item['id'] }}">{{ $item['name'] }}
                                      ({{ $item['typename'] }})
                                  </label>
                                  <span class="badge border font-weight-normal">1000</span>
                              </div>
                          @empty
                          @endforelse
                      </form>
                  </div>
                  <!-- Size End -->
              </div>
              <!-- Shop Sidebar End -->


              <!-- Shop Product Start -->
              <div class="col-lg-9 col-md-8">
                  <div class="row pb-3">
                      <div class="col-12 pb-1">
                          <div class="d-flex align-items-center justify-content-between mb-4">
                              <div class="d-flex">
                                  <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                  <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                                  <div>
                                      <form action="" class="ml-2">
                                          <div class="input-group">
                                              <input type="search" class="form-control" id="autoComplete"
                                                  placeholder="Search for products">
                                              <div class="input-group-append">
                                                  <span class="input-group-text bg-transparent text-primary">
                                                      <i class="fa fa-search"></i>
                                                  </span>
                                              </div>
                                          </div>
                                      </form>
                                      {{-- <input id="autoComplete" type="search" dir="ltr" spellcheck=false autocorrect="off" autocomplete="off" autocapitalize="off"> --}}
                                  </div>
                              </div>

                              <div class="ml-2">
                                  <div class="btn-group">
                                      <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                          data-toggle="dropdown">Sorting</button>
                                      <div class="dropdown-menu dropdown-menu-right">
                                          <div class="dropdown-item sort" data-sort='created_at'>Mới nhất</div>
                                          <div class="dropdown-item sort" data-sort='rate'>Đánh giá cao nhất</div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="col-12 pb-1 row" id="list-products">


                      </div>
                      <div class="col-12 pb-1" id="pagination">

                      </div>
                  </div>
                  <!-- Shop Product End -->
              </div>
          </div>
      @endsection
      @push('js')
          <script src={{ asset('js/pagination.js') }}></script>
          <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
          <script>
              $.ajax({
                  url: "{{ route('api.listnameproduct') }}",
                  method: 'GET',
                  success: function(response) {
                      console.log(response)
                      const autoCompleteJS = new autoComplete({
                          placeHolder: "Search for Food...",
                          data: {
                              src: response,
                              cache: true,
                          },
                          resultItem: {
                              highlight: true
                          },
                          events: {
                              input: {
                                  selection: (event) => {
                                      const selection = event.detail.selection.value;
                                      autoCompleteJS.input.value = selection;
                                  }
                              }
                          }
                      });
                  }
              })


              var rangePrice = ''
              var Maphanloai = ''
              var categories = ''
              var search = ''
              var sort = ''
              $('.sort').click(function() {
                  sort = $(this).attr('data-sort')
                  getProduct()
              })
              //  getProduct()
              $("#price-all").change(function() {
                  console.log('cha nha')
                  rangePrice = ""
                  if ($('#price-all').is(':checked')) {
                      $(".inputPriceitem").prop("checked", false);
                  }
                  getProduct()
              })
              $('.inputPriceitem').change(function() {
                  console.log($(".inputPriceitem:checked"))
                  if ($(".inputPriceitem:checked").length > 0) {
                      document.getElementById("price-all").checked = false;
                  } else {
                      document.getElementById("price-all").checked = true;
                  }
                  let i = 0
                  rangePrice = ''
                  $(".inputPriceitem:checked").each(function() {
                      if (i == 0)
                          rangePrice += $(this).attr('data-price')
                      else
                          rangePrice += "_" + $(this).attr('data-price')
                      i++;
                  })
                  //   console.log(rangePrice)
                  getProduct()
              })



              function showproduct(response) {
                  $('#pagination').pagination({
                      dataSource: response[0],
                      pageSize: 6,
                      formatResult: function(data) {

                      },
                      callback: function(list, pagination) {
                          console.log("respon", response)
                          let inner = ''
                          list.forEach(element => {
                              let price = Intl.NumberFormat('en-VN').format(element['priceSell'])
                              let pricediscount = Intl.NumberFormat('en-VN').format(element['price_discount'])
                              //   console.log(element)
                              let labeldiscount = element['isdiscount'] == 1 ?
                                  `<div class="discount-label red"> <span class="discount">${element['persent']}${ element['unit']==1?'%':'Đ'}</span> </div>` :
                                  ''
                              inner += `  <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                ${labeldiscount}
                    <div class="product-item bg-light mb-4">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100 imgProduct" src="{{ asset('storage/') }}/${element['img'][0]['path']}" alt="">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square addtocart" data-id={{ $item['id'] }}
                                    href="{{ route('product.productdetail') }}?id=${element['id']}"><i
                                        class="fa fa-shopping-cart"></i></a>
                                    ${ response[1] ==1?`<a class="btn btn-outline-dark btn-square addpavorite" data-id=${element['id']}><i class="far fa-heart"></i></a>`:''}
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="{{ route('product.productdetail') }}?id=${element['id']}">${element['name']}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h6>`
                              inner += element['isdiscount'] == 1 ?
                                  `<del style="color:#808080cc;">${price} Đ</del> ${pricediscount} Đ` :
                                  price
                              inner += `</h6>
                            </div>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>Nhãn hàng: ${element['brand_product']['name']}</h5>
                            </div>
                            <div class="d-flex align-items-center justify-content-center mb-1">
                               
                            </div>
                        </div>
                    </div>
                </div>`
                          });
                          document.getElementById('list-products').innerHTML = inner;
                          $('.addpavorite').unbind('click')
                          $('.addpavorite').click(function() {
                              let id = $(this).attr('data-id')
                              $.ajax({
                                  url: "{{ route('product.addfaverite') }}",
                                  type: 'GET',
                                  data: {
                                      id: id,
                                  },
                                  success: function(response) {
                                      $('.faverite').text(response[0]['quantity'])
                                      console.log(response)
                                  },
                                  error: function(response) {

                                  }
                              });
                          })
                      }
                  })

              }

              function checkUrl() {
                  const params = new Proxy(new URLSearchParams(window.location.search), {
                      get: (searchParams, prop) => searchParams.get(prop),
                  });
                  Maphanloai = params.maphanloai ? params.maphanloai : '';
                  getProduct()
                  console.log(Maphanloai)
                  if (params.maphanloai) {
                      $('.type[value="' + params.maphanloai + '"]').attr('checked', true)
                      document.getElementById("type-all").checked = false;
                      console.log($('.type[value="' + params.maphanloai + '"]'))
                  }
              }
              checkUrl()

              function getProduct() {
                  $(".container-spin").fadeIn("fast");
                  //   console.log("{{ route('product.listproduct') }}" + '?type=' + Maphanloai + '&category=' + categories +
                  //       '&price=' + rangePrice + '&search=' + search + '&sort=' + sort)
                  $.ajax({
                      url: "{{ route('product.listproduct') }}" + '?type=' + Maphanloai + '&category=' + categories +
                          '&price=' + rangePrice + '&search=' + search + '&sort=' + sort,
                      method: 'GET',
                      success: function(response) {
                          console.log(response);
                          showproduct(response)
                          $(".container-spin").fadeOut("fast");
                      }
                  })
              }
              $('#autoComplete').change(function() {
                  search = $(this).val()
                  getProduct()
              })
              $('.type').change(function() {
                  if ($(".type:checked").length > 0) {
                      document.getElementById("type-all").checked = false;
                  } else {
                      document.getElementById("type-all").checked = true;
                  }
                  let i = 0
                  Maphanloai = ''
                  $(".type:checked").each(function() {
                      if (i == 0)
                          Maphanloai += $(this).val()
                      else
                          Maphanloai += "-" + $(this).val()
                      i++;
                  });
                  getProduct()
                  console.log(Maphanloai)
              })
              $('.category').change(function() {
                  if ($(".category:checked").length > 0) {
                      document.getElementById("category-all").checked = false;
                  } else {
                      document.getElementById("category-all").checked = true;
                  }
                  let i = 0
                  categories = ''
                  $(".category:checked").each(function() {
                      if (i == 0)
                          categories += $(this).val()
                      else
                          categories += "-" + $(this).val()
                      i++;
                  });
                  getProduct()
                  console.log(categories)
              })
              $(".categoryall").change(function() {
                  categories = ""
                  if ($('.categoryall').is(':checked')) {
                      $(".category").prop("checked", false);
                  }
                  getProduct()
              })
              $(".typeall").change(function() {
                  Maphanloai = ""
                  if ($('.typeall').is(':checked')) {
                      $(".type").prop("checked", false);
                  }
                  getProduct()
              })
          </script>
      @endpush
