@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <h3 class="page-title mb-0">Thống kê</h3>
                </div>
                <div class="col-lg-4">
                    <form action="{{ route('management-statistics.list') }}" method="get">
                        @csrf
                        <div class="d-flex align-items-center ms-auto">
                            <div class="input-group input-group-sm custom-input-group ms-2">
                                <span class="input-group-text"><i class="fa-regular fa-calendar opacity-50"></i></span>
                                <input type="text" name="date" class="form-control ps-0" value="{{ $currentDate }}"
                                    id="date">
                            </div>
                            <button type="submit" class="btn btn-sm btn-warning ms-2">Chọn</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- END Page Header-->
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        <div class="h-0px">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <h5 class="flex-grow-1 text-primary text-uppercase mb-0">Điểm danh
                            </h5>
                            {{-- <div class="input-group input-group-sm custom-input-group mw-180px ms-auto">
                                <span class="input-group-text"><i class="fa-regular fa-calendar opacity-50"></i></span>
                                <input type="text" class="form-control ps-0" id="date"
                                    value="Thứ 4, 16 tháng 10/2024">
                            </div> --}}
                        </div>
                        <div class="row align-items-md-stretch">
                            <div class="col-lg-9 col-md-8 order-2 order-md-1">
                                <div id="rollCallChartDetail"></div>
                            </div>
                            <div class="col-lg-3 col-md-8 order-1 order-md-2">
                                <div class="border rounded p-2 h-100 d-flex flex-column">
                                    <div id="rollCallChartTotal" class="my-auto"></div>
                                    <div class="border-top pt-3 mt-auto">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="text-center lh-1 fs-1">{{ $totalStudents }}</div>
                                                <div class="small lh-sm text-center opacity-50">Số lượng học
                                                    sinh
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center lh-1 fs-1">{{ $totalClasses }}</div>
                                                <div class="small lh-sm text-center opacity-50">Lớp học</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-center lh-1 fs-1">{{ $totalTeachers }}</div>
                                                <div class="small lh-sm text-center opacity-50">Giáo viên</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->
@endsection

@section('page-footer')
    <script src="{{ asset('node_modules/highcharts/highcharts.js') }}"></script>
    <script>
        //Menu Active
        document.querySelector('.item-statistic > .nav-link').classList.add("active");

        //Date
        document.addEventListener("DOMContentLoaded", () => {
            flatpickr("#date", {
                //enableTime: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y/m/d",
                locale: "vn"
            });
        });
        //rollCallChartDetail
        Highcharts.chart('rollCallChartDetail', {
            chart: {
                type: 'column',
                height: '360px',
            },
            title: {
                text: '',
            },
            xAxis: {
                categories: @json($classes->pluck('name')->toArray()),
                labels: {
                    rotation: 90
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true
                }
            },
            tooltip: {
                headerFormat: '<b>{category}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Tổng: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Vắng',
                color: '#EA8E6D',
                data: @json($classes->pluck('student_absent')->toArray())
            }, {
                name: 'Muộn',
                color: '#FABA6B',
                data: @json($classes->pluck('student_late_time')->toArray())
            }, {
                name: 'Đúng giờ',
                color: '#4DC659',
                data: @json($classes->pluck('student_on_time')->toArray())
            }],
            credits: {
                enabled: false
            }
        });

        //Chart rollCallChartTotal
        Highcharts.chart('rollCallChartTotal', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie',
                height: '180px',
                backgroundColor: 'rgba(255,255,255,0)',
                spacing: [0, 0, 0, 0]
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: false,
                    slicedOffset: 0,
                    borderWidth: '2px',
                    borderColor: '#fff',
                    borderRadius: 0,
                    innerSize: 60,
                    states: {
                        hover: {
                            enabled: false
                        }
                    }

                }
            },
            series: [{
                name: 'Loại vi phạm',
                colorByPoint: true,
                data: [{
                    name: 'Vắng',
                    y: @json(array_sum($classes->pluck('student_absent')->toArray())),
                    sliced: true,
                    selected: true,
                    color: "#EA8E6D"
                }, {
                    name: 'Muộn',
                    y: @json(array_sum($classes->pluck('student_late_time')->toArray())),
                    color: "#FABA6B"
                }, {
                    name: 'Đúng giờ',
                    y: @json(array_sum($classes->pluck('student_on_time')->toArray())),
                    color: "#4DC659"
                }]
            }],
            credits: {
                enabled: false
            }
        });
    </script>
    <style>
        #rollCallChartDetail {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            /* Cho phép cuộn ngang */
        }
    </style>
@endsection
