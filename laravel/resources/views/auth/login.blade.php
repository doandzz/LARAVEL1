<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="site">
        <div class="page-banner d-flex flex-column">
            <div class="page-banner-top mb-auto">
                <div class="inner py-4 py-lg-5 px-3">
                    <p class="text-center"><img src="{{ asset('assets/img/suoihoa-logo.png') }}"
                            class="w-96px w-auto mw-100" alt="">
                    </p>
                    <h3 class="text-center text-uppercase lh-sm mb-1">UBND TP Bắc Ninh</h3>
                    <h1 class="text-center text-danger text-uppercase lh-sm mb-1">Trường Tiểu Học Suối Hoa</h1>
                </div>
            </div>
            <div class="page-banner-bottom mt-auto">
                <div class="inner py-2 px-3 d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('assets/img/asi-logo.svg') }}" class="bw h-36px w-auto me-3 mb-1"
                            alt="">
                    </div>
                    <div class="flex-grow-1">
                        <div class="small opacity-50 lh-sm">Hệ thống điểm danh bằng AI Camera<br />
                            Một sản phẩm của ASI Group</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-8 col-lg-6">
                        <div class="form form-sign-in my-4">
                            <p class="text-center mb-4"><img src="{{ asset('assets/img/logo.svg') }}" class="mw-100"
                                    alt=""></p>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="input-group custom-input-group">
                                        <label class="label small mb-n2">Tên đăng nhập</label>
                                        <div class="input-group-inner w-100 d-flex align-items-center">
                                            <input type="text" class="form-control flex-grow-1" name="user_name"
                                                placeholder="Nhập tên đăng nhập của bạn" value="{{ old('user_name') }}"
                                                autofocus autocomplete="username">
                                            <span class="input-group-text flex-shrink-0"><i
                                                    class="icon fa-regular fa-envelope"></i></span>
                                        </div>
                                    </div>
                                    @error('user_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group custom-input-group">
                                        <label class="label small mb-n2">Mật khẩu</label>
                                        <div class="input-group-inner w-100 d-flex align-items-center">
                                            <input type="password" id="password" class="form-control flex-grow-1"
                                                value="" placeholder="Nhập mật khẩu của bạn" name="password"
                                                autocomplete="current-password">
                                            <button id="togglePassword"
                                                class="btn btn-pw-view flex-shrink-0 opacity-50 d-inline-flex justify-content-center align-items-center"><i
                                                    class="icon fa-regular fa-eye"></i></button>
                                        </div>
                                    </div>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-warning py-2 w-100 btn-login"><strong>Đăng
                                            nhập</strong></button>
                                    <div class="mt-3 text-center">
                                        Quên mật khẩu? <a href="#">Cấp lại</a> mật khẩu
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END Site -->
    <!-- BEGIN Inlucde JS -->
    <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/overlayscrollbars/browser/overlayscrollbars.browser.es6.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- END Inlucde JS -->

    <!-- BEGIN Only for this page  -->
    <style>
        .btn-pw-view.pw-showed .icon:before {
            content: '\f070';
        }

        .page.login .site {
            display: flex;
            align-items: stretch;
        }

        .page.login .site .page-banner,
        .page.login .site .page-content {
            width: 50%;
            flex-basis: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .page.login .site .page-banner {
            background: #FFFDF9 url(assets/img/bg-suoihoa.png) 50% 100% no-repeat;
            background-size: 100% auto;
        }

        .page.login .site .page-banner .page-banner-top,
        .page.login .site .page-banner .page-banner-bottom {
            position: relative;
        }

        .page.login .site .page-banner .page-banner-top .inner,
        .page.login .site .page-banner .page-banner-bottom .inner {
            position: relative;
            z-index: 20;
        }



        .page.login .site .page-banner .page-banner-top::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 200%;
            background: linear-gradient(to top, rgba(235, 225, 204, 0) 0%, rgba(235, 225, 204, 1) 100%);

        }

        .page.login .site .page-banner .page-banner-bottom::before {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 400%;
            background: linear-gradient(to bottom, rgba(235, 225, 204, 0) 0%, rgba(235, 225, 204, 1) 100%);

        }


        @media screen and (max-width:992px) {

            .page.login .site .page-banner {
                display: none !important;
            }

            .page.login .site .page-content {
                width: 100%;
                flex-basis: 1000%;
            }
        }
    </style>
    <script>
        // Show/Hide Password
        document.querySelector('#togglePassword').addEventListener('click', function(e) {
            // toggle the type attribute
            const type = document.querySelector('#password').getAttribute('type') === 'password' ? 'text' :
                'password';
            document.querySelector('#password').setAttribute('type', type);
            // toggle the eye / eye slash icon
            this.classList.toggle('pw-showed');
        });
    </script>
</x-guest-layout>
