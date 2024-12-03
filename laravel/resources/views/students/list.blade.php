@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <div class="d-flex align-items-end mb-2">
                <h3 class="page-title flex-grow-1 d-flex align-items-center mb-0">Quản lý học sinh</h3>
                <div class="flex-shrink-0 ms-auto">
                    <a class="btn btn-sm btn-none btn-filter text-secondary me-1" data-bs-toggle="collapse" href="#searchBox"
                        role="button" aria-expanded="false" aria-controls="searchBox">
                        <i class="fa-solid fa-filter-list"></i>
                    </a>
                    <button class="btn btn-sm btn-warning"
                        onclick="location.href='{{ route('management-students.view_create') }}';"><i
                            class="fa-regular fa-plus"></i><span class="ms-2 d-none d-sm-inline-block">Thêm
                            mới</span></button>
                </div>
            </div>

            <form action="{{ route('management-students.list') }}" method="GET">
                <!-- BEGIN Search Box -->
                <div class="searchbox py-2 px-3 bg-white border rounded shadow-sm collapse" id="searchBox">
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-sm-2">
                            <label class="small opacity-50">Lớp</label>
                            <select id="filter_class" class="form-select form-select-sm" name="class_search">
                                <option value="0" @if ($class_search == 0 || $class_search == null) selected @endif>Chọn lớp học
                                </option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @if ($class_search == $class->id) selected @endif>
                                        {{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="small opacity-50">Tên học sinh</label>
                            <input type="text" name="name_search" class="form-control form-control-sm"
                                value="{{ $name_search ?? '' }}" placeholder="">
                        </div>
                        <div class="col-sm-2 ms-auto">
                            <button type="submit" class="btn btn-sm btn-warning w-100">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
                <!-- END Search Box-->
            </form>
        </div>
    </div><!-- END Page Header-->
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        <div class="h-0px">
            <div class="container-fluid">
                <!-- BEGIN List -->
                <div class="card">
                    <div class="card-header border-bottom-0">
                        <h5 class="card-title mb-0">Danh sách học sinh</h5>
                    </div>
                    @if (isset($students) && $students->total() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table
                                        class="table table-normal table-hover table-borderless table-simple-responsive table-rollcall sticky-first-column sticky-last-column mb-0">
                                        <thead>
                                            <tr>
                                                <th><span class="text-truncate">Mã học sinh</span></th>
                                                <th><span class="text-truncate">Họ và tên</span></th>
                                                <th><span class="text-truncate">Liên lạc</span></th>
                                                <th><span class="text-truncate">Lớp</span></th>
                                                <th class="text-end"><span class="text-truncate">Hành
                                                        động</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr class="align-middle">
                                                    <td data-label="Mã học sinh">
                                                        {{ $student->student_code }}
                                                    </td>
                                                    <td data-label="Họ và tên">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 me-md-2 ms-2 ms-md-0 order-2 order-md-1">
                                                                <img src="{{ $student->student_face_url ? asset('storage/images/' . $student->student_face_url) : asset('assets/img/media/avatar-default.png') }}"
                                                                    class="w-48px h-48px object-fit-cover rounded"
                                                                    alt="">
                                                            </div>
                                                            <div class="flex-grow-1 order-1 order-md-2">
                                                                <div class="lh-sm">{{ $student->full_name }}</div>
                                                                <div class="lh-sm small opacity-50">
                                                                    {{ $student->gender_str }} -
                                                                    {{ $student->birth_date }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td data-label="Liên lạc">
                                                        <div class="lh-sm"><a href="tel:+84"
                                                                class="link">{{ $student->guardian_phone }}</a>
                                                        </div>
                                                        <div class="lh-sm">{{ $student->address }}
                                                        </div>
                                                    </td>
                                                    <td data-label="Lớp học">
                                                        {{ $student->classes->name }} -
                                                        {{ $student->classes->year->name }}
                                                    </td>
                                                    <td class="text-end" data-label="Hành động">
                                                        <button class="btn btn-24px btn-outline-danger rounded-circle me-1"
                                                            data-bs-target="#modalConfirmDelete{{ $student->id }}"
                                                            data-bs-toggle="modal">
                                                            <i class="fa-solid fa-trash" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" data-bs-title="Xoá"></i>
                                                        </button>
                                                        <a href="{{ route('management-students.view_edit', $student) }}"
                                                            role="button"
                                                            class="btn btn-24px btn-outline-success rounded-circle">
                                                            <i class="fa-solid fa-pen" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" data-bs-title="Sửa"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row g-0 d-flex align-items-center border-top pt-2 mt-2">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    {{ $students->links('pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card-body">
                            Không có bản ghi phù hợp
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->

    @foreach ($students as $student)
        <!-- Modal Confirm Delete -->
        <div class="modal" id="modalConfirmDelete{{ $student->id }}" data-bs-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-trash-can-clock"></i></p>
                        <p class="text-center">Bạn muốn xoá thông tin học sinh <strong>{{ $student->full_name }}</strong>
                            không?
                        </p>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                                aria-label="Close">Bỏ qua</button>
                            <button id="btn-delete-user" type="button"
                                onclick="location.href='{{ route('management-students.delete', $student) }}';"
                                class="btn btn-danger text-white mx-1">Xác nhận xoá</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Confirm Delete -->
    @endforeach

@endsection

@section('page-footer')
    <!-- BEGIN Only for this page  -->

    <!-- BEGIN Toast Container -->
    <div class="toast-container position-fixed bottom-0 end-0">
        <!-- BEGIN Toast -->
        <div id="Message" class="toast align-items-center text-bg-info border-2 border-white rounded-3 my-2"
            role="alert" aria-live="assertive" aria-atomic="true">
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
    </div><!-- END Container -->

    <script>
        //Menu Active
        document.querySelector('.item-group-student > .nav-link').setAttribute('aria-expanded', true);
        document.getElementById('groupStudent').classList.add('show');
        document.querySelector('.item-student > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", () => {
            //Nice Select
            NiceSelect.bind(document.getElementById("filter_class"), {
                searchable: true,
                placeholder: 'Chọn lớp học',
                searchtext: 'Tìm kiếm',
                selectedtext: ''
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (request()->has('name_search') || request()->has('class_search'))
                // Open search box after search
                const searchBox = new bootstrap.Collapse(document.getElementById('searchBox'), {
                    toggle: true
                });
            @endif
        });
        document.addEventListener("DOMContentLoaded", function() {

            var session = @json(session('success'));

            if (session) {
                var message = new bootstrap.Toast(document.getElementById('Message'));
                message.show();
            }
        });
    </script>
@endsection
