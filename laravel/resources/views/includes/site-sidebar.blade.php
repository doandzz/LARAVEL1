<!-- BEGIN Site Sidebar-->
<div class="site-sidebar">
    <!-- BEGIN Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-header-inner h-100 py-2 d-flex align-items-center">
            <!-- BEGIN Sidebar Close -->
            <button class="btn btn-none btn-sidebar-close">
                <i class="icon fa-regular fa-angle-left"></i>
            </button>
            <!-- END Sidebar Close -->
            <!-- BEGIN Site Brand -->
            <div class="site-brand">
                <h2 class="site-title mb-2">
                    <a href="{{ route('management-attendances.list') }}" class="site-link d-flex align-items-center">
                        <img src="{{ asset('assets/img/logo.svg') }}" class="site-logo" alt="ASI Education">
                    </a>
                </h2>
            </div>
            <!-- END Site Brand -->
        </div>
    </div><!-- END Sidebar Header -->
    <!-- BEGIN Sidebar Content -->
    <div class="sidebar-content custom-scroll data-overlayscrollbars-initialize">
        <div class="h-0px">
            <div class="sidebar-content-inner py-3">
                <!-- BEGIN Menu Group -->
                <div class="mb-3">
                    <h6 class="ff-normal small px-2 opacity-50 mb-1">Chức năng</h6>
                    <ul class="nav nav-sidebar-menu flex-column mb-0">
                        <li class="nav-item item-roll-call">
                            <a href="{{ route('management-attendances.list') }}" class="nav-link">
                                <i class="icon fa-regular fa-clipboard-list-check"></i>Điểm danh
                            </a>
                        </li>
                        @can('view-admin-dashboard')
                        <li class="nav-item item-statistic">
                            <a href="{{ route('management-statistics.list') }}" class="nav-link">
                                <i class="icon fa-regular fa-chart-pie-simple"></i>Thống kê
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
                <!-- BEGIN Menu Group -->
                <hr>
                <!-- BEGIN Menu Group -->
                <div class="mb-3">
                    <h6 class="ff-normal small px-2 opacity-50 mb-1">Quản lý</h6>
                    <ul class="nav nav-sidebar-menu flex-column mb-0">
                        <li class="nav-item item-group-student dropdown">
                            <a href="#groupStudent" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="groupStudent">
                                <i class="icon fa-regular fa-children"></i>Quản lý học sinh
                            </a>
                            <div class="collapse" id="groupStudent">
                                <ul class="nav flex-column nav-sidebar-submenu">
                                    <li class="nav-item item-student">
                                        <a href="{{ route('management-students.list') }}" class="nav-link">Danh sách học sinh</a>
                                    </li>
                                    @can('view-admin-dashboard')
                                    <li class="nav-item item-class">
                                        <a href="{{ route('management-classes.list') }}" class="nav-link">Lớp học</a>
                                    </li>
                                    
                                    {{-- <li class="nav-item item-student">
                                        <a href="{{ route('management-students.import') }}" class="nav-link">Nhập danh sách học sinh</a>
                                    </li>
                                    <li class="nav-item item-student">
                                        <a href="{{ route('management-students.export') }}" class="nav-link">Xuất danh sách học sinh</a>
                                    </li> --}}
                                    @endcan
                                </ul>
                            </div>
                        </li>
                        @can('view-admin-dashboard')
                        <li class="nav-item item-teacher">
                            <a href="{{ route('management-teachers.list') }}" class="nav-link">
                                <i class="icon fa-solid fa-person-chalkboard"></i>Quản lý Giáo viên
                            </a>
                        </li>
                        @endcan
                        @can('view-admin-dashboard')
                        <li class="nav-item item-setting">
                            <a href="{{ route('management-settings.list') }}" class="nav-link">
                                <i class="icon fa-regular fa-gear"></i>Cấu hình
                            </a>
                        </li>
                        @endcan
                    </ul>
                </div>
                <!-- BEGIN Menu Group -->
            </div>
        </div>
    </div>
    <!-- END Sidebar Content -->
</div>
<!-- END Site Sidebar-->
