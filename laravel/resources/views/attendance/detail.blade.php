@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Rollcall Detail') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <!-- BEGIN Breadcrumb -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="{{ route('management-attendances.list') }}">Điểm danh</a></li>
                    <li class="breadcrumb-item small active" aria-current="page">
                        {{ $class->name }}{{ $currentDate->day }}{{ $currentDate->month }}{{ $currentDate->year }}</li>
                </ol>
            </nav>
            <!-- END Breadcrumb -->
        </div>
    </div><!-- END Page Header-->
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        <div class="h-0px">
            <div class="container-fluid">
                <form id="edit-status"
                    action="{{ route('management-attendances.edit_status', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}"
                    method="post">
                    @csrf
                    <!-- BEGIN -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-end mb-2">
                                <div class="col-lg-8">
                                    <h3 class="mb-0">Bảng điểm danh Lớp {{ $class->name }}</h3>
                                    <div class="small opacity-50"><i class="fa-regular fa-calendar"></i>
                                        {{ $currentDate->locale('vi')->dayName }}, {{ $currentDate->day }}
                                        tháng {{ $currentDate->month }},{{ $currentDate->year }}</div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="text-lg-end lh-sm">
                                        Sĩ số: <strong>{{ $class->students->count() }}</strong><br />
                                        Vắng: <strong>{{ $studentsWithoutFaceHistory }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table
                                    class="table table-normal table-hover table-borderless table-simple-responsive table-rollcall sticky-first-column sticky-last-column mb-0"
                                    cellspacing="0" cellpading="0">
                                    <thead>
                                        <tr>
                                            <th width="20" class="th-check">
                                                <div
                                                    class="form-check d-flex align-items-center justify-content-center mb-0">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        onclick="toggleCheckboxs('pupil')" id="pupil-all">
                                                    <label class="form-check-label" for="pupil-all">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th><span class="text-truncate">Học sinh</span></th>
                                            <th><span class="text-truncate">Lớp khoá</span></th>
                                            <th><span class="text-truncate">Điểm danh</span></th>
                                            <th><span class="text-truncate">Thời gian</span></th>
                                            <th class="text-end"><span class="text-truncate">Trạng thái</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $endTryTime = \Carbon\Carbon::parse(
                                                $setting_time->end_try_time,
                                            )->toTimeString();
                                        @endphp
                                        @foreach ($class->students as $student)
                                            @php
                                                $attendance = $student->attendances->first();
                                            @endphp
                                            <tr class="align-middle">
                                                <td class="td-check" data-label="Lựa chọn">
                                                    <div
                                                        class="form-check d-flex align-items-center justify-content-center mb-1">
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            name="pupil" id="pupil-1">
                                                        <label class="form-check-label" for="pupil-1">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td data-label="Học sinh">
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-md-2 ms-2 ms-md-0 order-2 order-md-1">
                                                            <img src="{{ $student->student_face_url ? asset('storage/images/' . $student->student_face_url) : asset('assets/img/media/avatar-default.png') }}"
                                                                class="w-48px h-48px rounded object-fit-cover"
                                                                alt="">
                                                        </div>
                                                        <div class="flex-grow-1 order-1 order-md-2">
                                                            <div class="lh-sm"><strong>Bé
                                                                    {{ $student->full_name }}</strong>
                                                            </div>
                                                            <div class="lh-sm small">
                                                                {{ $student->gender == 1 ? 'Nam' : 'Nữ' }}
                                                                - {{ $student->birth_date }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td data-label="Lớp / Khoá">{{ $class->name }} / {{ $class->year->name }}
                                                </td>
                                                <td data-label="Điểm danh">
                                                    <img src="{{ $attendance->tracking_image_url ?? asset('assets/img/media/avatar-default.png') }}"
                                                        class="w-48px h-48px rounded object-fit-cover" alt="">
                                                </td>
                                                <td data-label="Thời gian">
                                                    <input type="text"
                                                        class="form-control form-control-sm text-center time-picker w-auto"
                                                        value="{{ $attendance ? \Carbon\Carbon::parse($attendance->time_in)->format('H:i') : '' }}"
                                                        name="time_in[{{ $attendance ? $attendance->id : 'new-' . $student->id }}]"
                                                        data-student-id="{{ $student->id }}">
                                                </td>
                                                <td data-label="Trạng thái" class="text-end">
                                                    @php
                                                        $punctualityStatus = null;

                                                        if ($attendance) {
                                                            if ($attendance->status == 0) {
                                                                $punctualityStatus = 0;
                                                            } elseif ($attendance->status == 1) {
                                                                $punctualityStatus = 1;
                                                            } elseif ($attendance->status == 2) {
                                                                $punctualityStatus = null;
                                                            } else {
                                                                $attendanceTime = \Carbon\Carbon::parse(
                                                                    $attendance->time_in,
                                                                )->toTimeString();
                                                                $punctualityStatus =
                                                                    $attendanceTime <= $endTryTime ? 0 : 1;
                                                            }
                                                        }
                                                    @endphp
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="status[{{ $attendance ? $attendance->id : 'new-' . $student->id }}]"
                                                            id="status_on_time_{{ $student->id }}" value="0"
                                                            @if ($punctualityStatus === 0) checked @endif
                                                            data-student-id="{{ $student->id }}">
                                                        <label class="form-check-label"
                                                            for="status_on_time_{{ $student->id }}">Đúng giờ</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="status[{{ $attendance ? $attendance->id : 'new-' . $student->id }}]"
                                                            id="status_late_{{ $student->id }}" value="1"
                                                            @if ($punctualityStatus === 1) checked @endif
                                                            data-student-id="{{ $student->id }}">
                                                        <label class="form-check-label"
                                                            for="status_late_{{ $student->id }}">Đi trễ</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="status[{{ $attendance ? $attendance->id : 'new-' . $student->id }}]"
                                                            id="status_absent_{{ $student->id }}" value="2"
                                                            @if (is_null($punctualityStatus)) checked @endif
                                                            data-student-id="{{ $student->id }}">
                                                        <label class="form-check-label"
                                                            for="status_absent_{{ $student->id }}">Nghỉ học</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="row g-0 d-flex align-items-center border-top pt-3 mt-3">
                                <div class="col-lg-8">
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end ms-lg-auto mt-2 mt-lg-0">Giáo viên chủ nhiệm:
                                        <strong>{{ $class->teacher->full_name ?? '' }}</strong>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="card-footer border-top-0">
                            <div class="row align-items-center">
                                <div class="col-lg-6">
                                    @if ($confirmed_attendance > 0)
                                        <div class="opacity-75 text-center text-lg-start text-lock-countdown-end">
                                            Điểm danh đã bị <i class="fa-solid fa-lock"></i> khoá
                                        </div>
                                    @else
                                        <div class="opacity-75 text-center text-lg-start text-lock-countdown">
                                            @php
                                                $timezone = 'Asia/Bangkok'; // UTC+7
                                                $format = 'Y/m/d H:i';

                                                $now = \Carbon\Carbon::now()->timezone($timezone)->format($format);
                                                $end_time = \Carbon\Carbon::parse(
                                                    "$currentDate->year/$currentDate->month/$currentDate->day $setting_time->end_time",
                                                )->format($format);

                                                // $lockConfirm = \Carbon\Carbon::parse($end_time)->lte(
                                                //     \Carbon\Carbon::parse($now),
                                                // );
                                                $lockConfirm = false;

                                                $lockTime = \Carbon\Carbon::parse($end_time)->format('H:i d/m/Y');
                                            @endphp
                                            Hệ thống điểm danh ngừng ghi nhận sau {{ $lockTime }}
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-6 text-center text-lg-end pt-2 pt-lg-0" id="attendance-message">
                                    @if ($confirmed_attendance > 0)
                                        Đã xác nhận điểm danh
                                    @else
                                        <button type="button" class="btn btn-warning" id="btn-confirm"
                                            data-bs-target="#modalConfirm" data-bs-toggle="modal"
                                            @if ($lockConfirm) disabled @endif>Xác nhận</button>
                                        <button type="button" class="btn btn-outline-warning" id="btn-update"
                                            @if ($lockConfirm) disabled @endif
                                            data-bs-target="#modalConfirmEdit" data-bs-toggle="modal">Cập nhật</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END -->
                </form>

            </div>
        </div>
    </div><!-- END Page Content -->

    <!-- Modal Confirm -->
    <div class="modal" id="modalConfirm" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-labelledby=""
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-clipboard-check"></i></p>
                    <p class="text-center">Bạn có chắc về việc điểm danh này là chính xác. Sau khi xác nhận hoặc hết
                        giờ
                        điểm danh trạng thái điểm danh sẽ bị khoá.</p>

                    <div class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button> <button id="btn-confirm-x" type="button"
                            class="btn btn-sm btn-warning" data-bs-dismiss="modal" aria-label="Close">Xác
                            nhận</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm Delete -->

    <!-- Modal Confirm Edit -->
    <div class="modal" id="modalConfirmEdit" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-pen-to-square"></i></p>
                    <p class="text-center">Bạn muốn sửa thông tin điểm danh lớp <strong>{{ $class->name }}</strong>
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-confirm-edit" type="button" class="btn btn-warning text-white mx-1">Xác nhận
                            sửa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm Edit -->

    <div class="toast-container position-fixed bottom-0 end-0">
        <!-- BEGIN Toast Confim -->
        <div id="Message"
            class="toast align-items-center text-bg-success border-2 border-white rounded-3 shadow-xl my-2" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body text-white">
                    @if (session('success'))
                        {{ session('success') }}
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        <!-- END Toast Confirm -->
        <!-- BEGIN Toast error -->
        <div id="errorMessage" class="toast align-items-center text-bg-danger border-2 border-white rounded-3 my-2"
            role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body text-white">
                    Vui lòng nhập thời gian điểm danh!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div><!-- END Toast Container -->



@endsection

@section('page-footer')
    <!-- BEGIN Only for this page  -->
    <style>
        .table-rollcall tbody tr td:nth-child(4),
        .table-rollcall thead tr th:nth-child(4) {
            border-left: 2px solid #F7931E;
        }
    </style>
    <script>
        //Menu Active
        document.querySelector('.item-roll-call > .nav-link').classList.add("active");
        document.addEventListener("DOMContentLoaded", () => {
            flatpickr(".time-picker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i"
            });
        });

        document.getElementById('btn-confirm-edit').addEventListener('click', function(e) {
            let isValid = true;
            document.querySelectorAll('.form-check-input[type="radio"]').forEach(function(radio) {
                const studentId = radio.getAttribute('data-student-id');

                if (radio.checked) {
                    const status = radio.value;
                    const timeInput = document.querySelector(
                        `[data-student-id="${studentId}"][type="text"]`);

                    if (status != 2 && timeInput.value.trim() === '') {
                        isValid = false;
                        const modal = bootstrap.Modal.getInstance(document.getElementById(
                            'modalConfirmEdit'));
                        modal.hide();

                        const errorMessage = new bootstrap.Toast(document.getElementById('errorMessage'));
                        errorMessage.show();

                        timeInput.focus();

                        return;
                    }
                }
            });

            if (!isValid) {
                e.preventDefault();
            } else {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmEdit'));
                modal.hide();
                document.getElementById('edit-status').submit();
            }
        });

        document.addEventListener("DOMContentLoaded", function() {

            var session = @json(session('success'));

            if (session) {
                var Message = new bootstrap.Toast(document.getElementById('Message'));
                Message.show();
            }
        });
    </script>

    <script>
        document.getElementById('btn-confirm-x').addEventListener('click', function(event) {
            let isValid = true;
            document.querySelectorAll('.form-check-input[type="radio"]').forEach(function(radio) {
                const studentId = radio.getAttribute('data-student-id');

                if (radio.checked) {
                    const status = radio.value;
                    const timeInput = document.querySelector(
                        `[data-student-id="${studentId}"][type="text"]`);

                    if (status != 2 && timeInput.value.trim() === '') {
                        isValid = false;

                        const errorMessage = new bootstrap.Toast(document.getElementById('errorMessage'));
                        errorMessage.show();

                        timeInput.focus();

                        return;
                    }
                }
            });

            if (!isValid) {
                event.preventDefault();
            } else {
                const url =
                    '{{ route('management-attendances.confirmed_attendance', ['class' => $class, 'currentDate' => $currentDate->format('Y-m-d')]) }}';
                const form = document.getElementById('edit-status');
                form.action = url;
                form.submit();
            }

        });
    </script>

@endsection
