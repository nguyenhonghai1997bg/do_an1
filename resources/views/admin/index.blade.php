@extends('admin.layouts.master')
@section('title', __('app.home'))
@section('content')
    <h5 class="mb-2 mt-4"></h5>
      <div class="row container">
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $countOrderWaiting }}</h3>

              <p>{{ __('app.orderWaiting') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{ route('admin.orders.waiting') }}" class="small-box-footer">
            {{ __('app.moreInfor') }} <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>{{ number_format($amoutCurrentMonth->money) }} <span style="font-size: 13px;">VND</span></h3>

              <p>{{ __('orders.amoutCurrentMonth') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-sort-amount-desc"></i>
            </div>
            <a href="#" class="small-box-footer">
              {{ __('app.moreInfor') }} <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-secondary">
            <div class="inner">
              <h3>{{ $countNewUsers }}</h3>

              <p>{{ __('users.newUsers') }}</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-plus"></i>
            </div>
            <a href="{{ route('users.listNewUsers') }}" class="small-box-footer">
              {{ __('app.moreInfor') }} <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>{{ $countOrderDeleted }}</h3>

              <p>{{ __('orders.deleted') }} đơn hàng</p>
            </div>
            <div class="icon">
              <i class="fa fa-trash"></i>
            </div>
            <a href="{{ route('admin.orders.deleted') }}" class="small-box-footer">
              {{ __('app.moreInfor') }} <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
      </div>
    <div class="container mt-3 mb-4">
      <div class="form-group">
        <div class="row">
          <div class="col-md-1 ml-3 mt-1">
            <label>{{ __('orders.year') }}</label>
          </div>
          <div class="col-md-4">
            <select class="form-control" name="year" id="year">
              @if($years)
                @foreach($years as $year)
                  <option value="{{ $year->year }}">{{ $year->year }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6">
            <!-- AREA CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">{{ __('orders.doing') }}</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="countOrder" style="height:250px"></canvas>
                </div>
              </div>
              <div class="d-flex flex-row justify-content-center">
                  <span class="mr-2">
                    {{ __('orders.doing') }}
                  </span>

                </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-success">
              <div class="card-header no-border">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">{{ __('orders.chartOrders') }}</h3>
                  <a href="javascript:void(0);"></a>
                </div>
              </div>
              <div class="card-body">
                <div class="position-relative mb-4">
                  <canvas id="lineChart" style="height:250px"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fa fa-square text-primary"></i> {{ __('orders.done') }}
                  </span>

                </div>
              </div>
            </div>
          </div>
          <!-- /.col (RIGHT) -->
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Order ID</th>
                      <th>Item</th>
                      <th>Status</th>
                      <th>Popularity</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-info">Processing</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR1848</a></td>
                      <td>Samsung Smart TV</td>
                      <td><span class="badge badge-warning">Pending</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR7429</a></td>
                      <td>iPhone 6 Plus</td>
                      <td><span class="badge badge-danger">Delivered</span></td>
                      <td>
                        <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                      </td>
                    </tr>
                    <tr>
                      <td><a href="pages/examples/invoice.html">OR9842</a></td>
                      <td>Call of Duty IV</td>
                      <td><span class="badge badge-success">Shipped</span></td>
                      <td>
                        <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
              </div>
              <!-- /.card-footer -->
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
<script src="{{ asset('plugins/chartjs-old/Chart.min.js') }}"></script>
{{-- <script type="text/javascript"  src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script> --}}
<script type="text/javascript">
  function chartjs (year) {
    $.ajax({
      url: window.location.origin + '/admin/manager/all-orders-done',
      method: 'GET',
      data: {
        year: year
      },
      success: function(data) {
        var areaChartCanvas = $('#lineChart').get(0).getContext('2d')
          // This will get the first returned node in the jQuery collection.
        var areaChart       = new Chart(areaChartCanvas)

        var areaChartData = {
          labels  : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug' ,'Sep', 'Oct', 'Nov', 'Dec'],
          datasets: [
            {
              label               : 'Orders done',
              fillColor           : 'rgba(60,141,188,0.9)',
              strokeColor         : 'rgba(60,141,188,0.8)',
              pointColor          : '#3b8bba',
              pointStrokeColor    : 'rgba(60,141,188,1)',
              pointHighlightFill  : '#fff',
              pointHighlightStroke: 'rgba(60,141,188,1)',
              data                : [data.orderDone[1], data.orderDone[2], data.orderDone[3], data.orderDone[4], data.orderDone[5], data.orderDone[6], data.orderDone[7], data.orderDone[8], data.orderDone[9], data.orderDone[10], data.orderDone[11], data.orderDone[12]]
            },
          ]
        }

        var areaChartOptions = {
          //Boolean - If we should show the scale at all
          showScale               : true,
          //Boolean - Whether grid lines are shown across the chart
          scaleShowGridLines      : true,
          //String - Colour of the grid lines
          scaleGridLineColor      : 'rgba(0,0,0,.05)',
          //Number - Width of the grid lines
          scaleGridLineWidth      : 1,
          //Boolean - Whether to show horizontal lines (except X axis)
          scaleShowHorizontalLines: true,
          //Boolean - Whether to show vertical lines (except Y axis)
          scaleShowVerticalLines  : true,
          //Boolean - Whether the line is curved between points
          bezierCurve             : true,
          //Number - Tension of the bezier curve between points
          bezierCurveTension      : 0.3,
          //Boolean - Whether to show a dot for each point
          pointDot                : true,
          //Number - Radius of each point dot in pixels
          pointDotRadius          : 4,
          //Number - Pixel width of point dot stroke
          pointDotStrokeWidth     : 1,
          //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
          pointHitDetectionRadius : 20,
          //Boolean - Whether to show a stroke for datasets
          datasetStroke           : true,
          //Number - Pixel width of dataset stroke
          datasetStrokeWidth      : 2,
          //Boolean - Whether to fill the dataset with a color
          datasetFill             : true,
          //String - A legend template
          legendTemplate          : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
          //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio     : true,
          //Boolean - whether to make the chart responsive to window resizing
          responsive              : true,
        }

        //Create the line chart
        areaChart.Line(areaChartData, areaChartOptions)

        //-------------
        //- LINE CHART -
        //--------------
        var lineChartCanvas          = $('#lineChart').get(0).getContext('2d')
        var lineChart                = new Chart(lineChartCanvas)
        var lineChartOptions         = areaChartOptions
        lineChartOptions.datasetFill = false
        lineChart.Line(areaChartData, lineChartOptions)
      },
      error: function (error) {
        console.log(error)
      }
    })
  }

  function countOrder(year) {
     $.ajax({
      url: window.location.origin + '/admin/manager/count-order',
      method: 'GET',
      data: {
        year: year
      },
      success: function(data) {
        console.log(data)
        var pieChartCanvas = $('#countOrder').get(0).getContext('2d')
        var pieChart       = new Chart(pieChartCanvas)
        var PieData        = [
          {
            value    : data.done,
            color    : '#00a65a',
            highlight: '#00a65a',
            label    : 'Đã giao hàng'
          },
          {
            value    : data.waiting,
            color    : '#f39c12',
            highlight: '#f39c12',
            label    : 'Đơn hàng đang chờ'
          },
          {
            value    : data.process,
            color    : '#00c0ef',
            highlight: '#00c0ef',
            label    : 'Đơn hàng đang xử lý'
          },
          {
            value    : data.cancel,
            color    : '#f56954',
            highlight: '#f56954',
            label    : 'Đơn hàng đã xóa'
          }
        ]
        var pieOptions     = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke    : true,
          //String - The colour of each segment stroke
          segmentStrokeColor   : '#fff',
          //Number - The width of each segment stroke
          segmentStrokeWidth   : 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps       : 100,
          //String - Animation easing effect
          animationEasing      : 'easeOutBounce',
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate        : true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale         : false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive           : true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio  : true,
          //String - A legend template
          legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
        }
        //Create pie or douhnut chart
        // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions)
      },
      error: function(error) {

      },
    })
  }

  var year = $('#year').val();
  $('#year').change(function() {
    var year = $('#year').val();
    chartjs(year);
    countOrder(year);
  })

  chartjs(year);
  countOrder(year)
</script>
<!-- /.content-wrapper -->
@endsection
