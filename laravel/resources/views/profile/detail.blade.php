@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Rollcall Detail') <!-- Set a custom title for this page -->
@section('page-header')
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        @php
            $class_name = '';
            $email = '';
            if (isset($teacher)) {
                $email = $teacher->email;

                $names = [];
                foreach ($teacher->classes as $class) {
                    $names[] = $class->name;
                }
                $class_name = implode(', ', $names);
            }
        @endphp

        <div class="h-0px">
            <div class="container-fluid pt-3 pb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- BEGIN Card -->
                        <div class="card mb-3">
                            <div class="card-header border-bottom-0">
                                <h6 class="card-title mb-0">Hồ sơ</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <span class="opacity-50">Tên tài khoản</span>
                                    </div>
                                    <div class="col-sm-8"><strong>{{ $user->full_name }}</strong></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <span class="opacity-50">Loại tài khoản</span>
                                    </div>
                                    <div class="col-sm-8">{{ $user->role === 1 ? 'Quản trị trường' : 'Giáo viên' }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <span class="opacity-50">Quản lý điểm danh</span>
                                    </div>
                                    <div class="col-sm-8"> {{ $user->role === 1 ? 'Tất cả' : 'Lớp'.$class_name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <span class="opacity-50">Email</span>
                                    </div>
                                    <div class="col-sm-8">{{ $email }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        <span class="opacity-50">Mật khẩu</span>
                                    </div>
                                    <div class="col-sm-8"><a href="{{ route('password-update.list') }}" class="link">Đổi
                                            mật khẩu</a></div>
                                </div>
                            </div>
                        </div>
                        <!-- END Card -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->
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
        document.addEventListener("DOMContentLoaded", function() {

            var session = @json(session('success'));

            if (session) {
                var message = new bootstrap.Toast(document.getElementById('Message'));
                message.show();
            }
        });
    </script>

@endsection
