<!-- BEGIN Site Header -->
<div class="site-header">
    <div class="header-inner h-100 px-3 d-flex align-items-center">
        <!-- BEGIN Sidebar Close -->
        <button class="btn btn-none btn-sidebar-open ms-n3">
            <i class="icon fa-regular fa-bars"></i>
        </button>
        <!-- END Sidebar Close -->

        <!-- BEGIN Nav Header End -->
        <ul class="nav nav-header-end ms-auto">
            <li class="nav-item item-user dropdown">
                <a href="#" class="nav-link d-flex align-items-center p-0 dropdown-toggle" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-info me-2 d-none d-lg-block lh-sm">
                        <div class="user-title text-end fw-bold">@if (Auth::check()) {{Auth::user()->full_name}} @endif</div>
                        <div class="small opacity-50 text-end"> {{ Auth::user()->role == 0 ? 'Giáo viên chủ nhiệm' : 'Quản trị trường' }}</div>
                    </div>
                    <div class="user-avatar">
                        <img src="{{ (isset(Auth::user()->teacher) && Auth::user()->teacher->face_url) ? asset('images/' . Auth::user()->teacher->face_url) : asset('assets/img/media/avatar-default.png') }}"
                            class="w-36px h-36px rounded-circle object-fit-cover" alt="Ảnh giáo viên">
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item item-profile" href="{{ route('profile.detail') }}" >Trang hồ sơ</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a class="dropdown-item item-sign-out" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();">Đăng
                                xuất</a>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
        <!-- END Nav Header End -->
    </div>
</div>
<!-- END Site Header-->
