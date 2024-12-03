@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Rollcall Detail') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <!-- BEGIN Breadcrumb -->
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);"
                aria-label="breadcrumb">
            </nav>
            <!-- END Breadcrumb -->
        </div>
        <form action="{{ route('test-image') }}" method="GET">
            <!-- BEGIN Search Box -->
                <div class="row g-2 align-items-end mb-2 ms-2">
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
                        <label class="small opacity-50">Tên học sinh/Mã định danh</label>
                        <input type="text" name="name_search" class="form-control form-control-sm"
                            value="{{ $name_search ?? '' }}" placeholder="">
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group input-group-sm custom-input-group ms-2 ">
                            <span class="input-group-text"><i class="fa-regular fa-calendar opacity-50"></i></span>
                            <input type="text" name="date" class="form-control ps-0" value="{{ $currentDate }}"
                                id="date">
                        </div>
                    </div>
                    
                    <div class="col-sm-2 ms-auto">
                        <button type="submit" class="btn btn-sm btn-warning w-100">Tìm kiếm</button>
                    </div>
                </div>
            <!-- END Search Box-->
        </form>
    </div><!-- END Page Header-->
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        <div class="h-0px">
            <div class="container-fluid">
                <!-- BEGIN -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-normal table-hover table-borderless table-simple-responsive table-rollcall sticky-first-column sticky-last-column mb-0"
                                cellspacing="0" cellpading="0">
                                <thead>
                                    <tr>
                                        <th><span class="text-truncate">Học sinh</span></th>
                                        <th><span class="text-truncate">Lớp khoá</span></th>
                                        <th><span class="text-truncate">Thời gian</span></th>
                                        <th><span class="text-truncate">Điểm danh</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($face_historys as $s)
                                        <tr class="align-middle">
                                            <td data-label="Học sinh">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-md-2 ms-2 ms-md-0 order-2 order-md-1">
                                                        <img src="{{ $s->student->student_face_url ? asset('images/' . $s->student->student_face_url) : asset('assets/img/media/avatar-default.png') }}"
                                                            class="w-48px h-48px rounded object-fit-cover" alt=""
                                                            data-bs-target="#modalAnh1{{ $s->student->id }}"
                                                            data-bs-toggle="modal">
                                                    </div>
                                                    <div class="flex-grow-1 order-1 order-md-2">
                                                        <div class="lh-sm"><strong>Bé {{ $s->student->full_name }}</strong>
                                                        </div>
                                                        <div class="lh-sm small">{{ $s->student_identification_code }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-label="Lớp / Khoá">{{ $s->student->classes->name }}</td>
                                            <td>{{ $s->datetime }}</td>
                                            <td data-label="Điểm danh">
                                                <img src="{{ asset($s->tracking_image_url) }}"
                                                    class="w-48px h-48px rounded object-fit-cover" alt=""
                                                    data-bs-target="#modalAnh2{{ $s->id }}" data-bs-toggle="modal">
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="row g-0 d-flex align-items-center border-top pt-2 mt-2">
                                <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    {{ $face_historys->links('pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END -->
            </div>
        </div>
    </div><!-- END Page Content -->

    @foreach ($face_historys as $s)
        <!-- Modal Confirm Delete -->
        <div class="modal" id="modalAnh1{{ $s->student->id }}" tabindex="-1" role="dialog"
            aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-center align-items-center row">
                            <img src="{{ asset('images/' . $s->student->student_face_url) }}" class="col-lg-6" >
                            <img src="{{ $s->tracking_image_url }}" class="col-lg-6">
                            
                        </div>

                        <div class="text-center mt-3">
                            <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                                aria-label="Close">Bỏ qua</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Confirm Delete -->
    @endforeach

    @foreach ($face_historys as $s)
        <!-- Modal Confirm Delete -->
        <div class="modal" id="modalAnh2{{ $s->id }}" tabindex="-1" role="dialog"
            aria-labelledby="" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-center align-items-center row">
                            <img src="{{ asset('images/' . $s->student->student_face_url) }}" class="col-lg-6">
                            <img src="{{ $s->tracking_image_url }}" class="col-lg-6">
                            
                        </div>
                        <div class="text-center">
                            <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                                aria-label="Close">Bỏ qua</button>
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
    <style>
        .table-rollcall tbody tr td:nth-child(4),
        .table-rollcall thead tr th:nth-child(4) {
            border-left: 2px solid #F7931E;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            flatpickr("#date", {
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
    </script>

@endsection
