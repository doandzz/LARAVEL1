@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Change Password') <!-- Set a custom title for this page -->
@section('page-header')
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>

        <div class="h-0px">
            <div class="container-fluid pt-3 pb-2">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- BEGIN Card -->
                        <div class="card mb-3">
                            <form id="form-update-password" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                                @csrf
                                @method('put')
                                <div class="card-header border-bottom-0">
                                    <h6 class="card-title mb-0">Đổi mật khẩu</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <span class="opacity-50">Mật khẩu hiện tại</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="current_password" type="password" class="form-control"
                                                value="{{ old('current_password') }}" placeholder="Nhập mật khẩu hiện tại">
                                            @error('current_password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <span class="opacity-50">Mật khẩu mới</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="password" type="password" class="form-control"
                                                value="{{ old('password') }}" placeholder="Nhập mật khẩu mới">
                                            @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            <span class="opacity-50">Xác nhận mật khẩu</span>
                                        </div>
                                        <div class="col-sm-8">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                value="{{ old('password_confirmation') }}"
                                                placeholder="Xác nhận mật khẩu mới">
                                            @error('password_confirmation')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer border-top-0 bg-transparent d-flex align-items-center">
                                    <!-- <button class="btn border-0 bg-transparent text-warning">Xoá</button> -->
                                    <button class="btn btn-warning px-4 ms-auto"
                                        type="button" data-bs-target="#modalConfirmPasswordUpdate" data-bs-toggle="modal" >Đổi mật khẩu</button>
                                </div>
                            </form>
                        </div>
                        <!-- END Card -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END Page Content -->
    <!-- Modal Confirm Edit -->
    <div class="modal" id="modalConfirmPasswordUpdate" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-pen-to-square"></i></p>
                    <p class="text-center">Bạn muốn đổi mật khẩu
                        không?
                    </p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal"
                            aria-label="Close">Bỏ qua</button>
                        <button id="btn-confirm" type="button" class="btn btn-warning text-white mx-1">Xác nhận
                            đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm Edit -->
@endsection

@section('page-footer')
    {{-- Submit form edit --}}
    <script>
        document.getElementById('btn-confirm').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmPasswordUpdate'));
            modal.hide();

            // Submit form
            document.getElementById('form-update-password').submit();
        });
    </script>
@endsection
