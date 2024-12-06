@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Quản lý giáo viên - Sửa') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <!-- BEGIN Breadcrumb -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="{{ route('management-teachers.list') }}">Quản lý giáo viên</a>
                    </li>
                    <li class="breadcrumb-item small active" aria-current="page">Sửa</li>
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
                <div class="row">
                    <div class="col-lg-8 col-md-10">
                        <!-- BEGIN Card -->
                        <div class="card mb-3">
                            <div class="card-header border-bottom-0">
                                <h6 class="card-title mb-0">Sửa giáo viên</h5>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{ route('management-teachers.edit', $teacher) }}"
                                    method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-8  order-2 order-md-1">
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin hệ thống</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Mã định danh GV</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('identification_code', $teacher->identification_code) }}"
                                                        name="identification_code"
                                                        placeholder="Nhập mã định danh giáo viên">
                                                    @error('identification_code')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                @if (isset($teacher->user))
                                                    <div class="mb-2">
                                                        <label class="d-block opacity-50 mb-0">Vai trò</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" name="roleAdmin" type="checkbox"
                                                                value="1" id="flexCheckDefault"
                                                                {{ old('roleAdmin',$teacher->user->role) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Quản trị trường
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin cá nhân</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Họ và tên</label>
                                                    <input type="text" name="full_name" class="form-control"
                                                        value="{{ old('full_name', $teacher->full_name) }}"
                                                        placeholder="Nguyễn..">
                                                    @error('full_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Ngày sinh</label>
                                                    <div class="input-group custom-input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-regular fa-calendar opacity-50"></i></span>
                                                        <input type="text" name="birth_date" class="form-control ps-0"
                                                            id="birthday"
                                                            value="{{ old('birth_date', $teacher->birth_date) }}">
                                                    </div>
                                                    @error('birth_date')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Giới tính</label>
                                                    <div class="mt-1">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                id="male" value="1"
                                                                {{ old('gender', $teacher->gender) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="male">Nam</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                id="female" value="0"
                                                                {{ old('gender', $teacher->gender) == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="female">Nữ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin liên hệ</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Email</label>
                                                    <div class="input-group custom-input-group">
                                                        <input name="email" type="text"
                                                            class="form-control flex-grow-1"
                                                            value="{{ old('email', $teacher->email) }}"
                                                            placeholder="@gmail.com">
                                                        <span class="input-group-text flex-shrink-0"><i
                                                                class="icon fa-regular fa-envelope opacity-50"></i></span>
                                                    </div>
                                                    @error('email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Số điện thoại</label>
                                                    <div class="input-group custom-input-group">
                                                        <input name="phone" type="text"
                                                            class="form-control flex-grow-1"
                                                            value="{{ old('phone', $teacher->phone) }}"
                                                            placeholder="+84">
                                                        <span class="input-group-text flex-shrink-0"><i
                                                                class="icon fa-regular fa-phone opacity-50"></i></span>
                                                    </div>
                                                    @error('phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Địa chỉ</label>
                                                    <div class="input-group custom-input-group">
                                                        <input type="text" name="address"
                                                            class="form-control flex-grow-1"
                                                            value="{{ old('address', $teacher->address) }}"
                                                            placeholder="Hà Nội phố">
                                                        <span class="input-group-text flex-shrink-0"><i
                                                                class="icon fa-regular fa-location-pin opacity-50"></i></span>
                                                    </div>
                                                    @error('address')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pt-3 mx-auto order-1 order-md-2">
                                            <p class="text-center">
                                                <img src="{{ $teacher->face_url ? asset('images/' . $teacher->face_url) : asset('assets/img/media/avatar-default.png') }}"
                                                    class="rounded mw-128px mx-auto" alt="" id="imagePreview">
                                            </p>
                                            <p class="text-center"><a href="#" class="small link"
                                                    id="uploadLink"><i class="fa-regular fa-upload me-2"></i> Tải ảnh
                                                    lên</a></p>
                                        </div>
                                        <!-- hidden input file -->
                                        <input type="file" name="face_url" id="fileInput"
                                            value="{{ old('face_url') }}" style="display:none;" accept="image/*" />

                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent d-flex align-items-center">
                                        <button type="button" class="btn border-0 bg-transparent text-warning px-0"
                                            data-bs-target="#modalConfirmDelete" data-bs-toggle="modal">Xoá</button>
                                        <button type="button" class="btn btn-warning px-4 ms-auto"
                                            data-bs-target="#modalConfirmEdit" data-bs-toggle="modal">Cập
                                            nhật</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- END Card -->
                    </div>
                </div>
            </div>
        </div><!-- END Page Content -->

    </div>
    <!-- END Page Content-->

    <!-- Modal Confirm Delete -->
    <div class="modal" id="modalConfirmDelete" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-trash-can-clock"></i></p>
                    <p class="text-center">Bạn có chắc về việc xoá giáo viên <strong>{{ $teacher->full_name }}</strong>
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-delete-user" type="button" class="btn btn-danger text-white mx-1"
                            onclick="location.href='{{ route('management-teachers.delete', $teacher) }}';">Xác nhận
                            xoá</button>
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
                    <p class="text-center">Bạn muốn sửa thông tin giáo viên <strong>{{ $teacher->full_name }}</strong>
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
@endsection

@section('page-footer')
    <!-- BEGIN Only for this page  -->
    <script>
        document.querySelector('.item-teacher > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", () => {
            flatpickr("#birthday", {
                //enableTime: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y/m/d",
                locale: "vn"
            });
        });

        document.getElementById('uploadLink').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('fileInput').click();
        });
        document.getElementById('fileInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Update src for <img> 
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file); // read file URL
            }
        });
    </script>
    {{-- Submit form edit --}}
    <script>
        document.getElementById('btn-confirm-edit').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmEdit'));
            modal.hide();

            // Submit form
            document.getElementById('edit-form').submit();
        });
    </script>
@endsection
