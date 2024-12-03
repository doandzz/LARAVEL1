@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Quản lý học sinh - Thêm mới') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <!-- BEGIN Breadcrumb -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item small"><a href="{{ route('management-students.list') }}">Quản lý học sinh</a>
                    </li>
                    <li class="breadcrumb-item small active" aria-current="page">Thêm mới</li>
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
                        <form id="create-form" action="{{route('management-students.create')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card mb-3">
                                <div class="card-header border-bottom-0">
                                    <h6 class="card-title mb-0">Thêm học sinh</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8 order-2 order-md-1">
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin hệ thống</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Mã định danh học sinh</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('student_identification_code') }}"
                                                        name="student_identification_code" placeholder="Mã định danh học sinh">
                                                    @error('student_identification_code')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="row gx-2">
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label class="d-block opacity-50 mb-0">Mã học sinh</label>
                                                            <input type="text" class="form-control"
                                                                value="{{ old('student_code') }}"
                                                                name="student_code" placeholder="Mã học sinh">
                                                            @error('student_code')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label class="d-block opacity-50 mb-0">Lớp</label>
                                                            <select id="filter_class" class="form-select" name="class_id">
                                                                <option value="0">Chọn lớp học</option>
                                                                @foreach ($classes as $class)
                                                                    <option value="{{ $class->id }}"
                                                                        @if (old('class_id') == $class->id) selected @endif>
                                                                        {{ $class->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('class_id')
                                                                <div class="text-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin học sinh</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Họ và tên</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('full_name') }}" name="full_name"
                                                        placeholder="Họ và tên">
                                                    @error('full_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Ngày sinh</label>
                                                    <div class="input-group custom-input-group">
                                                        <span class="input-group-text"><i
                                                                class="fa-regular fa-calendar opacity-50"></i></span>
                                                        <input type="text" class="form-control ps-0" id="birthday"
                                                            value="{{ old('birth_date','Thứ 4, 16 tháng 10/2024') }}"
                                                            name="birth_date">
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
                                                                {{ old('gender', 0) == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="male">Nam</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="gender"
                                                                id="female" value="0"
                                                                {{ old('gender', 0) == 0 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="female">Nữ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <h6 class="text-uppercase text-primary">Thông tin liên lạc</h6>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Địa chỉ</label>
                                                    <div class="input-group custom-input-group">
                                                        <input type="text" class="form-control flex-grow-1"
                                                            value="{{ old('address') }}" name="address"
                                                            placeholder="Hà Nội phố">
                                                        <span class="input-group-text flex-shrink-0"><i
                                                                class="icon fa-regular fa-location-pin opacity-50"></i></span>
                                                    </div>
                                                    @error('address')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Số điện thoại</label>
                                                    <div class="input-group custom-input-group">
                                                        <input type="text" class="form-control flex-grow-1"
                                                            value="{{ old('guardian_phone') }}" name="guardian_phone"
                                                            placeholder="+84">
                                                        <span class="input-group-text flex-shrink-0"><i
                                                                class="icon fa-regular fa-phone opacity-50"></i></span>
                                                    </div>
                                                    @error('guardian_phone')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-2">
                                                    <label class="d-block opacity-50 mb-0">Họ tên phụ huynh</label>
                                                    <input type="text" class="form-control"
                                                        value="{{ old('guardian_full_name') }}"
                                                        name="guardian_full_name" placeholder="Họ và tên">
                                                    @error('guardian_full_name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 pt-3 mx-auto order-1 order-md-2">
                                            <p class="text-center">
                                                <img src="{{asset('assets/img/media/avatar-default.png')}}"
                                                    class="rounded mw-128px mx-auto" alt="" id="imagePreview">
                                            </p>
                                            <p class="text-center"><a href="#" class="small link" id="uploadLink"><i
                                                        class="fa-regular fa-upload me-2"></i> Tải ảnh lên</a></p>
                                            <hr>
                                            <p class="text-center small lh-sm opacity-50">Lựa chọn hình ảnh trực
                                                diện đúng
                                                khung hình.<br /><a href="#" class="link">Xem ví dụ</a></p>
                                        </div>
                                        <!-- hidden input file image -->
                                        <input type="file" name="student_face_url" id="fileInput" value="{{ old('student_face_url') }}"
                                            style="display:none;" accept="image/*" />
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 bg-transparent d-flex align-items-center">
                                    <!-- <button class="btn border-0 bg-transparent text-warning">Xoá</button> -->
                                    <button class="btn btn-warning px-4 ms-auto"
                                        type="button" data-bs-target="#modalConfirmCreate" data-bs-toggle="modal">Thêm</button>
                                </div>
                            </div>
                        </form>

                        <!-- END Card -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->

    <!-- Modal Confirm Create -->
    <div class="modal" id="modalConfirmCreate" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-plus-circle"></i></p>
                    <p class="text-center">Bạn muốn thêm học sinh này
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-confirm-create" type="button" class="btn btn-warning text-white mx-1">Xác nhận
                            thêm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm Create -->

@endsection

@section('page-footer')
    <!-- BEGIN Only for this page  -->
    <script>
        //Menu Active
        document.querySelector('.item-group-student > .nav-link').setAttribute('aria-expanded', true);
        document.getElementById('groupStudent').classList.add('show');
        document.querySelector('.item-student > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", () => {
            flatpickr("#birthday", {
                //enableTime: true,
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y/m/d",
                locale: "vn"
            });

            //Nice Select
            NiceSelect.bind(document.getElementById("filter_class"), {
                searchable: true,
                placeholder: 'Chọn lớp học',
                searchtext: 'Tìm kiếm',
                selectedtext: ''
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
        document.getElementById('btn-confirm-create').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmCreate'));
            modal.hide();

            // Submit form
            document.getElementById('create-form').submit();
        });
    </script>
@endsection
