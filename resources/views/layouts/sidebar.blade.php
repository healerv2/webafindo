<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>
                <li class="{{ Request::route()->getName() == 'dashboard' ? ' active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="waves-effect">
                        <i class="mdi mdi-speedometer"></i> <span>Dashboard</span>
                    </a>
                </li>
                @can('view role')
                    <li class="{{ request()->is('dashboard/roles*') ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}" class="waves-effect">
                            <i class="mdi mdi-format-list-bulleted"></i> <span>Role</span>
                        </a>
                    </li>
                @endcan
                @can('view permission')
                    <li class="{{ request()->is('dashboard/permissions*') ? 'active' : '' }}">
                        <a href="{{ route('permissions.index') }}" class="waves-effect">
                            <i class="mdi mdi-format-list-bulleted"></i> <span>Permissions</span>
                        </a>
                    </li>
                @endcan
                @can('view user')
                    <li class="{{ request()->is('dashboard/users*') ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}" class="waves-effect">
                            <i class="mdi mdi-account-box-multiple-outline"></i> <span>User</span>
                        </a>
                    </li>
                @endcan
                @can('view manage pelanggan')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-box-multiple-outline"></i>
                            <span>Manage Pelanggan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view customer')
                                <li><a href="{{ route('customer.index') }}">Pelanggan</a></li>
                            @endcan
                            @can('view mikrotik')
                                <li><a href="{{ route('mikrotik.index') }}">My Mikrotik</a></li>
                            @endcan
                            <li><a href="#">Cek Mikrotik</a></li>
                            <li><a href="#">Cek PPOE</a></li>
                            <li><a href="#">Ekport</a></li>
                        </ul>
                    </li>
                @endcan
                @can('view user')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-box-multiple-outline"></i>
                            <span>Manage Karyawan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="#">Tugas Teknisi</a></li>
                            <li><a href="#">Absensi</a></li>
                            <li><a href="#">Admin</a></li>
                            <li><a href="#">Karyawan</a></li>
                        </ul>
                    </li>
                @endcan
                @can('view menu lain lain')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-box-multiple-outline"></i>
                            <span>Menu Lain - Lain</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('view data paket')
                                <li><a href="{{ route('data-paket.index') }}">Data Paket</a></li>
                            @endcan
                            @can('view data area')
                                <li><a href="#">Data Area</a></li>
                            @endcan
                        </ul>
                    </li>
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
