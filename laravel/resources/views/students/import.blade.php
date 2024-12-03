@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Import Students') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <div class="d-flex align-items-end mb-2">
                <h3 class="page-title flex-grow-1 d-flex align-items-center mb-0">Nhập danh sách học sinh</h3>
                <div class="flex-shrink-0 ms-auto">
                    <a class="btn btn-sm btn-none btn-filter text-secondary me-1" data-bs-toggle="collapse" href="#searchBox"
                        role="button" aria-expanded="false" aria-controls="searchBox">
                        <i class="fa-solid fa-filter-list"></i>
                    </a>
                    
                </div>
            </div>

            <form action="{{ route('') }}" method="GET">
                <!-- BEGIN Search Box -->
                <div class="searchbox py-2 px-3 bg-white border rounded shadow-sm collapse" id="searchBox">
                    <div class="row g-2 align-items-end mb-2">
                        <div class="col-sm-2">
                            <label class="small opacity-50">Lớp</label>
                            <select id="select_class" class="form-select form-select-sm" name="select_class">
                                {{-- <option value="0" @if ($class_search == 0 || $class_search == null) selected @endif>Chọn lớp học</option> --}}
                                <option value="0">Chọn lớp học</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}" @if ($class_search == $class->id) selected @endif>
                                        {{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="small opacity-50">Chọn tập tin nhập dánh sách học sinh</label>
                            <input type="file" name="import_file" class="form-control form-control-sm"
                                 placeholder="">
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

@endsection