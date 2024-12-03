@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header py-3 flex-shrink-0">
        <div class="container-fluid">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <h3 class="mb-0">Quản lý lớp học</h3>
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
                <div class="row gx-3">
                    <div class="col-lg-5">
                        <!-- BEGIN Card -->
                        <div class="card mb-3">
                            <form id ="formClass"
                                action="{{ isset($class) ? route('management-classes.edit', $class) : route('management-classes.create') }}"
                                method="POST">
                                @csrf
                                @if (isset($class))
                                    @method('PUT') <!-- Sử dụng PUT cho chỉnh sửa -->
                                @endif
                                <div class="card-header border-bottom-0">
                                    <h6 class="card-title mb-0">{{ isset($class) ? 'Sửa lớp học' : 'Thêm mới' }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row gx-2">
                                        <div class="col-8">
                                            <div class="mb-2">
                                                <label class="d-block opacity-50 mb-0">Tên lớp học</label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ old('name', $class->name ?? '') }}"
                                                    placeholder="Nhập tên lớp học">
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-2">
                                                <label class="d-block opacity-50 mb-0">Năm học</label>
                                                <select id="filter_khoahoc" class="form-select" name="year_id">
                                                    <option value="0">Chọn năm học</option>
                                                    @foreach ($years as $year)
                                                        <option value="{{ $year->id }}"
                                                            @if (old('year_id', $class->year_id ?? '') == $year->id) selected @endif>
                                                            {{ $year->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('year_id')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="d-block opacity-50 mb-0">Giáo viên chủ nhiệm</label>
                                        <select id="filter_giaovien" class="form-select" name="teacher_id">
                                            <option value="0">Chọn giáo viên</option>
                                            @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}"
                                                    @if (old('teacher_id', $class->teacher_id ?? '') == $teacher->id) selected @endif>
                                                    {{ $teacher->full_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('teacher_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </form>
                            <div class="card-footer border-top-0 bg-transparent d-flex align-items-center">
                                @if (isset($class))
                                    <button type="button" class="btn border-0 bg-transparent text-warning"
                                        data-bs-target="#modalConfirmDelete{{ $class->id }}"
                                        data-bs-toggle="modal">Xoá</button>
                                @endif

                                <button type="button" class="btn btn-warning ms-auto"
                                    data-bs-target="{{ isset($class) ? '#modalConfirmEdit' : '#modalConfirmCreate' }}"
                                    data-bs-toggle="modal">
                                    {{ isset($class) ? 'Sửa' : 'Thêm' }}</button>
                            </div>
                        </div>
                        <!-- END Card -->
                    </div>
                    <div class="col-lg-7">
                        <div class="card mb-3">
                            <div class="card-header border-bottom-0">
                                <h6 class="card-title mb-0">Danh sách Lớp học</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table
                                        class="table table-normal table-hover table-borderless table-simple-responsive table-rollcall sticky-first-column sticky-last-column mb-0">
                                        <thead>
                                            <tr>
                                                <th><span class="text-truncate">Lớp</span></th>
                                                <th class="text-center"><span class="text-truncate">Năm
                                                        học</span>
                                                </th>
                                                <th class="text-end"><span class="text-truncate">Hành
                                                        động</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($classes as $class)
                                                <tr class="align-middle">
                                                    <td data-label="Lớp">
                                                        <div class="lh-sm">{{ $class->name }}</div>
                                                        <div class="lh-sm small opacity-50">GVCN:
                                                            {{ $class->teacher->full_name ?? '' }}
                                                        </div>
                                                    </td>
                                                    <td class="text-center" data-label="Năm học">
                                                        {{ $class->year->name }}
                                                    </td>
                                                    <td class="text-end" data-label="Hành động">
                                                        <a href="{{ route('management-classes.view_create') }}"
                                                            role="button"
                                                            class="btn btn-24px btn-outline-info rounded-circle me-1">
                                                            <i class="fa-solid fa-plus" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" data-bs-title="Thêm học sinh"></i>
                                                        </a>

                                                        <button class="btn btn-24px btn-outline-danger rounded-circle me-1"
                                                            data-bs-target="#modalConfirmDelete{{ $class->id }}"
                                                            data-bs-toggle="modal">
                                                            <i class="fa-solid fa-trash" data-bs-toggle="tooltip"
                                                                data-bs-placement="right" data-bs-title="Xoá"></i>
                                                        </button>
                                                        <a href="{{ route('management-classes.view_edit', $class) }}"
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
                                <div class="row g-0 d-flex align-items-center border-top pt-2 mt-2">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        {{ $classes->links('pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->

    <!-- Modal Confirm Delete -->
    @foreach ($classes as $class)
        <div class="modal" id="modalConfirmDelete{{ $class->id }}" data-bs-backdrop="static" tabindex="-1"
            role="dialog" aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-trash-can-clock"></i></p>
                        <p class="text-center">Bạn muốn xóa lớp <strong>{{ $class->name ?? '' }}</strong>
                            không?
                        </p>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                                aria-label="Close">Bỏ qua</button>
                            <button id="btn-confirm-delete" type="button" class="btn btn-danger text-white mx-1"
                                onclick="location.href='{{ route('management-classes.delete', $class) }}';">Xác
                                nhận
                                xóa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    <!-- Modal Confirm Edit -->
    <div class="modal" id="modalConfirmEdit" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-pen-to-square"></i></p>
                    <p class="text-center">Bạn muốn sửa thông tin lớp <strong>{{ $classname ?? '' }}</strong>
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-confirm-edit" type="button" class="btn btn-warning text-white mx-1">Xác
                            nhận
                            sửa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm Create -->
    <div class="modal" id="modalConfirmCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-plus-circle"></i></p>
                    <p class="text-center">Bạn muốn thêm lớp học này
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-confirm-create" type="button" class="btn btn-warning text-white mx-1">Xác
                            nhận
                            thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        //Menu Active
        document.querySelector('.item-group-student > .nav-link').setAttribute('aria-expanded', true);
        document.getElementById('groupStudent').classList.add('show');
        document.querySelector('.item-class > .nav-link').classList.add("active");


        document.addEventListener("DOMContentLoaded", () => {
            //Nice Select
            NiceSelect.bind(document.getElementById("filter_khoahoc"), {
                searchable: true,
                placeholder: 'Chọn năm học',
                searchtext: 'Tìm kiếm',
                selectedtext: ''
            });

            NiceSelect.bind(document.getElementById("filter_giaovien"), {
                searchable: true,
                placeholder: 'Chọn giáo viên',
                searchtext: 'Tìm kiếm',
                selectedtext: ''
            });
        });
        document.getElementById('btn-confirm-edit').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmEdit'));
            modal.hide();

            // Submit form
            document.getElementById('formClass').submit();
        });
        document.getElementById('btn-confirm-create').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmCreate'));
            modal.hide();

            // Submit form
            document.getElementById('formClass').submit();

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
