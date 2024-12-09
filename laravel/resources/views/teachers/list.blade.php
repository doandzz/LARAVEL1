@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <div class="d-flex align-items-end mb-2">
                <h3 class="page-title flex-grow-1 d-flex align-items-center mb-0">Quản lý giáo viên</h3>
                <div class="flex-shrink-0 ms-auto">
                    <a class="btn btn-sm btn-none btn-filter text-secondary me-1" data-bs-toggle="collapse" href="#searchBox"
                        role="button" aria-expanded="false" aria-controls="searchBox">
                        <i class="fa-solid fa-filter-list"></i>
                    </a>
                    <button class="btn btn-sm btn-warning"
                        onclick="location.href='{{ route('management-teachers.view_create') }}';"><i
                            class="fa-regular fa-plus"></i><span class="ms-2 d-none d-sm-inline-block">Thêm
                            mới</span></button>
                </div>

            </div>
            <!-- BEGIN Search Box -->
            <div class="searchbox py-2 px-3 bg-white border rounded shadow-sm collapse" id="searchBox">
                <form action="{{ route('management-teachers.list') }}" method="get">
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-sm-2">
                            <label class="small opacity-50">Mã định danh giáo viên</label>
                            <input type="text" name="teacher_code_search" class="form-control form-control-sm"
                                value="{{ $teacher_code_search ?? '' }}" placeholder="">
                        </div>
                        <div class="col-sm-4">
                            <label class="small opacity-50">Họ và tên</label>
                            <input type="text" name="name_search" class="form-control form-control-sm"
                                value="{{ $name_search ?? '' }}" placeholder="">
                        </div>
                        <div class="col-sm-2">
                            <label class="small opacity-50">Chức danh</label>
                            <select class="form-select form-select-sm" name="role_search">
                                <option value="0" @if ($role_search == 0) selected @endif>Tất cả</option>
                                <option value="1" @if ($role_search == 1) selected @endif>Quản trị trường
                                </option>
                                <option value="2" @if ($role_search == 2) selected @endif>Giáo viên</option>
                            </select>
                        </div>
                        <div class="col-sm-2 ms-auto d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-warning w-100"
                                onclick="location.href='{{ route('management-teachers.clear_fillter') }}';">Làm
                                mới</button>
                            <button type="submit" class="btn btn-sm btn-warning w-100">Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Search Box-->
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
                        <h5 class="card-title mb-0">Danh sách giáo viên</h5>
                    </div>
                    @if (isset($teachers) && $teachers->total() > 0)
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="table-responsive">
                                    <table
                                        class="table table-normal table-hover table-borderless table-simple-responsive table-rollcall sticky-first-column sticky-last-column mb-0">
                                        <thead>
                                            <tr>
                                                <th><span class="text-truncate">Mã định danh GV</span></th>
                                                <th><span class="text-truncate">Họ và tên</span></th>
                                                <th><span class="text-truncate">Liên hệ</span></th>
                                                <th><span class="text-truncate">Chức danh</span></th>
                                                <th class="text-end"><span class="text-truncate">Hành
                                                        động</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($teachers as $teacher)
                                                @php
                                                    $names = [];
                                                    foreach ($teacher->classes as $class) {
                                                        $names[] = $class->name;
                                                    }
                                                    $classes_names = implode(', ', $names);
                                                @endphp
                                                <tr class="align-middle">
                                                    <td data-label="Mã định danh GV">
                                                        {{ $teacher->identification_code }}
                                                    </td>
                                                    <td data-label="Họ và tên">
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                class="flex-shrink-0 me-md-2 ms-2 ms-md-0 order-2 order-md-1">
                                                                <img src="{{ $teacher->face_url ? asset('images/' . $teacher->face_url) : asset('assets/img/media/avatar-default.png') }}"
                                                                    class="w-48px h-48px object-fit-cover rounded">
                                                            </div>
                                                            <div class="flex-grow-1 order-1 order-md-2">
                                                                <div class="lh-sm">{{ $teacher->full_name }}</div>
                                                                <div class="lh-sm small opacity-50">
                                                                    {{ $teacher->gender_str }} - {{ $teacher->birth_date }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td data-label="Liên hệ">
                                                        <div class="lh-sm"><a href="tel:+84"
                                                                class="link">{{ $teacher->phone }}</a>
                                                        </div>
                                                        <div class="lh-sm">{{ $teacher->address }}
                                                        </div>
                                                    </td>
                                                    <td data-label="Liên hệ">
                                                        @if ($classes_names != '')
                                                            <div class="lh-sm">
                                                                Giáo viên chủ nhiệm
                                                            </div>
                                                            <div class="lh-sm">Lớp: <strong>{{ $classes_names }}</strong>
                                                            </div>
                                                        @else
                                                            @if ($teacher->user && $teacher->user->role == 1)
                                                                <div class="lh-sm">
                                                                    Quản trị trường
                                                                </div>
                                                            @else
                                                                <div class="lh-sm">
                                                                    Giáo viên
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td class="text-end" data-label="Hành động">
                                                        <button class="btn btn-24px btn-outline-danger rounded-circle me-1"
                                                            data-bs-target="#modalConfirmDelete{{ $teacher->id }}"
                                                            data-bs-toggle="modal">
                                                            <i class="fa-solid fa-trash" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" data-bs-title="Xoá"></i>
                                                        </button>
                                                        <a href="{{ route('management-teachers.view_edit', $teacher) }}"
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
                                    {{ $teachers->links('pagination.custom') }}
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

    @foreach ($teachers as $teacher)
        <!-- Modal Confirm Delete -->
        <div class="modal" id="modalConfirmDelete{{ $teacher->id }}" data-bs-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-trash-can-clock"></i></p>
                        <p class="text-center">Bạn muốn xoá thông tin giáo viên <strong>{{ $teacher->full_name }}</strong>
                            không?
                        </p>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                                aria-label="Close">Bỏ qua</button>
                            <button id="btn-delete-user" type="button"
                                onclick="location.href='{{ route('management-teachers.delete', $teacher) }}';"
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
    <!-- BEGIN Only for this page  -->
    <style>
        .btn-filter[aria-expanded=true] {
            color: var(--bs-warning) !important;
        }
    </style>
    <script>
        //Menu Active
        document.querySelector('.item-teacher > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", function() {

            var session = @json(session('success'));

            if (session) {
                var message = new bootstrap.Toast(document.getElementById('Message'));
                message.show();
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            @if (request()->has('name_search') || request()->has('teacher_code_search') || request()->has('role_search'))
                // Open search box after search
                const searchBox = new bootstrap.Collapse(document.getElementById('searchBox'), {
                    toggle: true
                });
            @endif
            @if (isset($showFilter) && $showFilter)
                const searchBox = new bootstrap.Collapse(document.getElementById('searchBox'), {
                    toggle: true
                });
            @endif
        });
    </script>
@endsection
