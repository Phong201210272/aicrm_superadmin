<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand"
                    height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item active">
                    <a href="">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Thành phần quản lý</h4>
                </li>


                <li class="nav-item">
                    <a href="{{ route('super.user.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Khách hàng</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super.zalo.index') }}">
                        <i class="fa-solid fa-z"></i>
                        <p>Zalo</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#sidebargiaodich">
                        <i class="fas fa-dollar"></i>
                        <p>Giao dịch</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="sidebargiaodich">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href = "{{ route('super.transaction.index') }}">
                                    <span class="sub-item">Nạp tiền</span>
                                </a>
                            </li>
                            <li>
                                <a href = "{{ route('super.transfer.index') }}">
                                    <span class="sub-item">Chuyển tiền</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('super.campaign.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Chiến dịch</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('super.transaction.index') }}">
                        <i class="fas fa-user"></i>
                        <p>Giao dịch</p>
                    </a>
                </li> --}}
            </ul>
        </div>
    </div>
</div>
