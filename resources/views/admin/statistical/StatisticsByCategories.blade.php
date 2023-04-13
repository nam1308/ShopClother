  @extends('layout.master')
  @push('css')
      <style>
          .highcharts-figure,
          .highcharts-data-table table {
              min-width: 320px;
              max-width: 660px;
              margin: 1em auto;
          }

          .highcharts-data-table table {
              font-family: Verdana, sans-serif;
              border-collapse: collapse;
              border: 1px solid #ebebeb;
              margin: 10px auto;
              text-align: center;
              width: 100%;
              max-width: 500px;
          }

          .highcharts-data-table caption {
              padding: 1em 0;
              font-size: 1.2em;
              color: #555;
          }

          .highcharts-data-table th {
              font-weight: 600;
              padding: 0.5em;
          }

          .highcharts-data-table td,
          .highcharts-data-table th,
          .highcharts-data-table caption {
              padding: 0.5em;
          }

          .highcharts-data-table thead tr,
          .highcharts-data-table tr:nth-child(even) {
              background: #f8f8f8;
          }

          .nav-item a {
              color: white;
          }

          .highcharts-data-table tr:hover {
              background: #f1f7ff;
          }

          .list {
              height: 4rem;
          }

          ul .list:hover {
              background-color: #f6db7b;
          }

          p {
              margin-top: 0 !important;
              margin-bottom: 0rem !important;
          }
      </style>
  @endpush
  @section('content')
      <div class="row" id="accordion">
          <div class="col-12 mb-3">

              <div class="dropdown ml-2">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      Chọn Loại Thông Kê
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <a class="btn btn-primary dropdown-item" data-toggle="collapse" href="#categories" role="button"
                          aria-expanded="true" aria-controls="categories">
                          Theo phân loại
                      </a>
                      <a class="btn btn-primary dropdown-item" data-toggle="collapse" href="#product" role="button"
                          aria-expanded="false" aria-controls="product">
                          Theo sản phẩm
                      </a>
                  </div>
              </div>
          </div>

          <div class="col-12">
              <div class="col-12 collapse" id="categories" data-parent="#accordion">
                  <div class="d-flex">
                      <input id="begin_category" class="ml-2" type="date">
                      <input id="endn_category" class="ml-2" type="date">
                      <button id="showchart_category" class="btn btn-info ml-2" type="button">Hiển thị biểu đồ</button>
                  </div>
                  <figure class="highcharts-figure">
                      <div id="chartcategory"></div>
                      <h4 class="highcharts-description text-center">
                          Thông kê số liệu theo loại sản phẩm
                      </h4>
                  </figure>
              </div>
              <div class="col-12 collapse" id="product" data-parent="#accordion">
                  <div class="d-flex">
                      <input id="begin_product" type="date">
                      <input id="end_product" type="date">
                      <button id="showchart_product" class="btn btn-info" type="button">Hiển thị biểu đồ</button>
                  </div>
                  <figure class="highcharts-figure">
                      <div id="chartproduct"></div>
                      <h4 class="highcharts-description text-center">
                          Biểu đồ thống kê theo <span>sản phẩm</span> của cửa hàng
                      </h4>
                  </figure>
              </div>
          </div>
      </div>
  @endsection
  @push('js')
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/modules/data.js"></script>
      <script src="https://code.highcharts.com/modules/drilldown.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/export-data.js"></script>
      <script src="https://code.highcharts.com/modules/accessibility.js"></script>
      <script src={{ asset('js/pagination.js') }}></script>
      <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
      <script>
          $('#showchart_category').click(function() {
              let begin = $('#begin_category').val()
              let end = $('#end_category').val()
              showChartbyCategories(begin, end)
          })
          $('#showchart_product').click(function() {
              let begin = $('#begin_product').val()
              let end = $('#end_product').val()
              showChartbyProduct(begin, end)
          })

          function showChartbyCategories(begin, end) {
              $.ajax({
                  url: "{{ route('admin.statistical.bycategories') }}?" + 'begin=' + begin + '&end=' + end,
                  type: 'GET',
                  success: function(response) {
                      const arrX = Object.values(response[0])
                      console.log(response)
                      const arrDetail = []
                      Object.values(response[1]).forEach(e => {
                          //console.log(e['data'])
                          e['data'] = Object.values(e.data)
                          arrDetail.push(e)
                      });
                      //  console.log(arrX)
                      // Create the chart
                      Highcharts.chart('chartcategory', {
                          chart: {
                              type: 'pie'
                          },
                          title: {
                              text: 'Thông kê số lượng tiêu thị của từng loại sảm phẩm'
                          },
                          subtitle: {
                              text: 'Thông kê theo phân loại'
                          },

                          accessibility: {
                              announceNewData: {
                                  enabled: true
                              },
                              point: {
                                  valueSuffix: '%'
                              }
                          },

                          plotOptions: {
                              series: {
                                  dataLabels: {
                                      enabled: true,
                                      format: '{point.name}: {point.y:.1f}%'
                                  }
                              }
                          },

                          tooltip: {
                              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                          },

                          series: [{
                              name: "Phân Loại Sản Phẩm",
                              colorByPoint: true,
                              data: arrX
                          }],
                          drilldown: {
                              series: arrDetail
                          }
                      });
                  },
                  error: function(response) {}
              });
          }

          //   theo san pham
          function showChartbyProduct(begin, end) {
              $.ajax({
                  url: "{{ route('admin.statistical.byproduct') }}?" + 'begin=' + begin + '&end=' + end +
                      '&data=soluong',
                  type: 'GET',
                  success: function(response) {
                      const arrX = Object.values(response[0])
                      console.log(response)
                      const arrDetail = []
                      Object.values(response[1]).forEach(e => {
                          //console.log(e['data'])
                          e['data'] = Object.values(e.data)
                          arrDetail.push(e)
                      });
                      //  console.log(arrX)
                      Highcharts.chart('chartproduct', {
                          chart: {
                              type: 'column'
                          },
                          title: {
                              align: 'left',
                              text: 'Thông kê theo loại sản phẩm'
                          },
                          subtitle: {
                              align: 'left',
                              text: 'Thông số'
                          },
                          accessibility: {
                              announceNewData: {
                                  enabled: true
                              }
                          },
                          xAxis: {
                              type: 'category'
                          },
                          yAxis: {
                              title: {
                                  text: 'Số lượng sản phẩm'
                              }

                          },
                          legend: {
                              enabled: false
                          },
                          plotOptions: {
                              series: {
                                  borderWidth: 0,
                                  dataLabels: {
                                      enabled: true,
                                      format: '{point.y:.1f} Sản phẩm'
                                  }
                              }
                          },

                          tooltip: {
                              headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                              pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                          },

                          series: [{
                              name: "Phân Loại",
                              colorByPoint: true,
                              data: arrX
                          }],
                          drilldown: {
                              breadcrumbs: {
                                  position: {
                                      align: 'right'
                                  }
                              },
                              series: arrDetail
                          }
                      });
                  },
                  error: function(response) {}
              });
          }
      </script>
  @endpush
