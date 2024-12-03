@extends('layouts.app') <!-- Inherit from the main layout -->

@section('title', 'ASI Education - Dashboard') <!-- Set a custom title for this page -->
@section('page-header')
    <!-- BEGIN Page Header -->
    <div class="page-header flex-shrink-0">
        <div class="container-fluid pt-3 pb-2">
            <h3 class="page-title d-flex align-items-center mb-0"><i class="fa-regular fa-gear fs-5 opacity-50 me-1"></i>Cài
                đặt hệ thống</h3>
        </div>
    </div><!-- END Page Header-->
@endsection

@section('page-content')
    <!-- BEGIN Page Content -->
    <div class="page-conent flex-grow-1 custom-scroll" data-overlayscrollbars-initialize>
        <div class="h-0px">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- BEGIN -->
                        <div class="card">
                            <div class="card-header border-bottom-0">
                                <h5 class="card-title mb-0">Giờ điểm danh</h5>
                            </div>
                            <form id="form-setting-time" action="{{ route('management-settings.update') }}" method="POST">
                                @csrf

                                <div class="card-body">
                                    <!-- BEGIN Row title -->
                                    <div class="row align-items-center">
                                        <div class="col-sm-5">
                                            &nbsp;
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row gx-2">
                                                <div class="col-4">
                                                    <label class="d-block opacity-50 mb-0">Giờ bắt đầu</label>
                                                </div>
                                                <div class="col-4">
                                                    <label class="d-block opacity-50 mb-0">Giờ kết thúc</label>
                                                </div>
                                                <div class="col-4">
                                                    <label class="d-block opacity-50 mb-0">Giờ vào học</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div><!-- END Row title -->
                                    <hr class="my-2">
                                    @foreach ($settings as $setting)
                                        <!-- BEGIN Row Item -->
                                        <div class="row align-items-center mb-2">
                                            <div class="col-sm-5">
                                                <h6 class="mb-2 mb-md-0">{{ $setting->day }}</h6>
                                            </div>
                                            <div class="col-sm-7">
                                                <div class="row gx-2">
                                                    <div class="col-4">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center time-picker"
                                                            name="settings[{{ $setting->id }}][start_time]"
                                                            value="{{ $setting->start_time }}" placeholder="">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center time-picker"
                                                            name="settings[{{ $setting->id }}][end_time]"
                                                            value="{{ $setting->end_time }}" placeholder="">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text"
                                                            class="form-control form-control-sm text-center time-picker"
                                                            name="settings[{{ $setting->id }}][end_try_time]"
                                                            value="{{ $setting->end_try_time }}" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- END Row Item -->
                                    @endforeach
                                    <!-- BEGIN Row Item -->
                                    <div class="row align-items-center mb-2">
                                        <div class="col-sm-5">
                                            <h6 class="mb-2 mb-md-0">Chủ nhật</h6>
                                        </div>
                                        <div class="col-sm-7">
                                            <div class="row gx-2">
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        value="N/A" disabled placeholder="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        value="N/A" disabled placeholder="">
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control form-control-sm text-center"
                                                        value="N/A" disabled placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- END Row Item -->
                                </div>
                                <div class="card-footer bg-transparent border-top-0 text-end">
                                    <button type="button" class="btn btn-sm px-4 btn-warning" id="btn-update" data-bs-target="#modalConfirmEdit" data-bs-toggle="modal">Lưu</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- END Page Content -->
    <!-- Modal Confirm Edit -->
    <div class="modal" id="modalConfirmEdit" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p class="text-center text-warning fs-1 mb-2"><i class="fa-duotone fa-pen-to-square"></i></p>
                    <p class="text-center">Bạn muốn sửa thông tin giờ điểm danh
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
        document.querySelector('.item-setting > .nav-link').classList.add("active");

        document.addEventListener("DOMContentLoaded", () => {
            flatpickr(".time-picker", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i"
            });
        });

        document.addEventListener("DOMContentLoaded", function() {

            var session = @json(session('success'));

            if (session) {
                var message = new bootstrap.Toast(document.getElementById('Message'));
                message.show();
            }
        });
        document.getElementById('btn-confirm-edit').addEventListener('click', function() {
            // Close modal
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalConfirmEdit'));
            modal.hide();

            // Submit form
            document.getElementById('form-setting-time').submit();
        });
    </script>
@endsection
