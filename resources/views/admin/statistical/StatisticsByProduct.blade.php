  @extends('layout.master')
  @push('css')
      <style>
          .highcharts-figure,
          .highcharts-data-table table {
              min-width: 310px;
              max-width: 800px;
              margin: 1em auto;
          }

          #container {
              height: 400px;
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

          .highcharts-data-table tr:hover {
              background: #f1f7ff;
          }
      </style>
  @endpush
  @section('content')
      <script src="https://code.highcharts.com/highcharts.js"></script>
      <script src="https://code.highcharts.com/modules/data.js"></script>
      <script src="https://code.highcharts.com/modules/drilldown.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/export-data.js"></script>
      <script src="https://code.highcharts.com/modules/accessibility.js"></script>
      <div class="d-flex">
          <input id="begin" type="date">
          <input id="end" type="date">
          <button id="showchart" class="btn btn-info" type="button">Show Chart</button>
      </div>
      <figure class="highcharts-figure">
          <div id="product"></div>
          <p class="highcharts-description">
              Biểu đồ thống kê theo <span>sản phẩm</span> của cửa hàng
          </p>
      </figure>
  @endsection
  @push('js')
      <script src={{ asset('js/pagination.js') }}></script>
      <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
      <script>
          $('#showchart').click(function() {
              let begin = $('#begin').val()
              let end = $('#end').val()
              showCart(begin, end)
          })

          function showCart(begin, end) {
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
                      Highcharts.chart('product', {
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
