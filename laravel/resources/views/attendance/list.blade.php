@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header py-3 flex-shrink-0">
        <div class="container-fluid">
            <div class="row align-items-end">
                <div class="col-lg-6">
                    <h3 class="mb-0">Bảng điểm danh {{ $currentDate->locale('vi')->dayName }}, {{ $currentDate->day }}
                        tháng {{ $currentDate->month }}/{{ $currentDate->year }}</h3>
                </div>
                <div class="col-lg-6">
                    <form action="{{ route('management-attendances.list') }}" method="get">
                        @csrf
                        <div class="d-flex align-items-center ms-auto">
                            <select class="form-select form-select-sm" style="width: 70%;" name="">
                                <option value="0" >Tất cả
                                </option>
                                <option value="1">Điểm danh đủ
                                </option>
                                <option value="2">Điểm danh thiếu
                                </option>
                            </select>
                            <select class="form-select form-select-sm ms-2" style="width: 70%;" name="status_attendance">
                                <option value="0" @if ($statusAttendance == 0) selected @endif>Chọn trạng thái
                                </option>
                                <option value="1" @if ($statusAttendance == 1) selected @endif>Đã xác nhận
                                </option>
                                <option value="2" @if ($statusAttendance == 2) selected @endif>Chưa xác nhận
                                </option>
                            </select>
                            <div class="input-group input-group-sm custom-input-group ms-2 ">
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
                @if ($is_teacher)
                    <h6 class="fw-normal opacity-50 text-uppercase">Lớp phụ trách
                    </h6>
                    <div class="mb-2">
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($classes as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">
                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif

                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- BEGIN Block 5 -->
                    <div class="mb-2">
                        @if ($grade_5->isNotEmpty())
                            <h6 class="fw-normal opacity-50 text-uppercase">Khối lớp 5</h6>
                        @endif
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($grade_5 as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">
                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif

                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach

                        </div>
                    </div><!-- END Block 5 -->
                    <!-- BEGIN Block 4 -->
                    <div class="mb-2">
                        @if ($grade_4->isNotEmpty())
                            <h6 class="fw-normal opacity-50 text-uppercase">Khối lớp 4</h6>
                        @endif
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($grade_4 as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">

                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach
                        </div>
                    </div><!-- END Block 4 -->
                    <!-- BEGIN Block 3 -->
                    <div class="mb-2">
                        @if ($grade_3->isNotEmpty())
                            <h6 class="fw-normal opacity-50 text-uppercase">Khối lớp 3</h6>
                        @endif
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($grade_3 as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">
                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach
                        </div>
                    </div><!-- END Block 3 -->
                    <!-- BEGIN Block 2 -->
                    <div class="mb-2">
                        @if ($grade_2->isNotEmpty())
                            <h6 class="fw-normal opacity-50 text-uppercase">Khối lớp 2</h6>
                        @endif
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($grade_2 as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">
                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach
                        </div>
                    </div><!-- END Block 2 -->
                    <!-- BEGIN Block 2 -->
                    <div class="mb-2">
                        @if ($grade_1->isNotEmpty())
                            <h6 class="fw-normal opacity-50 text-uppercase">Khối lớp 1</h6>
                        @endif
                        <div class="row gx-2 align-items-stretch">
                            @foreach ($grade_1 as $class)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                                    <!-- BEGIN Roll Call Item -->
                                    <div
                                        class="{{ $class->confirmed_attendance_count > 0 ? 'rollcall-stats-item h-100 confirmed full' : 'rollcall-stats-item h-100 confirmed absent' }} ">
                                        <div class="item-content">
                                            <h4 class="item-title mb-2">Lớp {{ $class->name }}</h4>
                                            <div class="item-meta small d-flex align-items-center">
                                                <div class="flex-grow-1"><i class="fa-regular fa-children opacity-50"></i>
                                                    <span>Sĩ
                                                        số</span>
                                                </div>
                                                <div class="flex-shrink-0 ms-auto"><span
                                                        class="text-warning">{{ $class->students_attended_count }}</span>/{{ $class->students_count }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-footer">
                                            @if ($class->confirmed_attendance_count > 0)
                                                <div class="item-meta small"><span class="text-success"><i
                                                            class="fa-regular fa-check-circle me-1"></i>Đã xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @else
                                                <div class="item-meta small"><span class="opacity-50">Chưa xác nhận</span>
                                                </div>
                                                <div class="item-action ms-auto"><button class="btn btn-more"
                                                        onclick="location.href='{{ route('management-attendances.view_detail', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';"><i
                                                            class="fa-regular fa-chevron-right"></i></button></div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- END Roll Call Item -->
                                </div>
                            @endforeach
                        </div>
                    </div><!-- END Block 2 -->

                @endif

            </div>
        </div>
    </div><!-- END Page Content -->
@endsection

@section('page-footer')
    <!-- BEGIN Only for this page  -->
    <script>
        //Menu Active
        document.querySelector('.item-roll-call > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", () => {
            flatpickr("#date", {
                //enableTime: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y/m/d",
                locale: "vn"
            });
        });
    </script>
@endsection
