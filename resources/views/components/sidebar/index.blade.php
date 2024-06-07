<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <x-sidebar.brand />
        <x-sidebar.profile />
        <div class="navbar-nav w-100">
            <x-sidebar.link href="/dashboard">
                <i class="fa fa-tachometer-alt me-2"></i>
                Dashboard
            </x-sidebar.link>
            <x-sidebar.dropdown>
                <x-sidebar.dropdown.header
                    :routes="['nomor-surat/hari-ini', 'nomor-surat/kastem', 'nomor-surat/kastem-admin']">
                    <i class="fas fa-envelope-open-text me-2"></i>Nomor Surat
                </x-sidebar.dropdown.header>
                <x-sidebar.dropdown.menu>
                    <x-sidebar.dropdown.link href="/nomor-surat/hari-ini">
                        Hari Ini
                    </x-sidebar.dropdown.link>
                    <x-sidebar.dropdown.link href="/nomor-surat/kastem">
                        Kastem
                    </x-sidebar.dropdown.link>
                    @if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2)
                    <x-sidebar.dropdown.link href="/nomor-surat/kastem-admin">
                        Kastem Admin
                    </x-sidebar.dropdown.link>
                    @endif
                </x-sidebar.dropdown.menu>
            </x-sidebar.dropdown>
            <x-sidebar.link href="/surat-jalan">
                <i class="fas fa-truck me-2"></i>
                Surat Jalan
            </x-sidebar.link>
            <x-sidebar.link href="/my-profile">
                <i class="fas fa-user-circle me-2"></i>
                My Profile
            </x-sidebar.link>
            @if (Auth::user()->role_id == 1)
            <x-sidebar.dropdown>
                <x-sidebar.dropdown.header
                    :routes="['data-master/data-role', 'data-master/data-pt', 'data-master/data-users', 'data-master/nomor-surat', 'data-master/surat-jalan']">
                    <i class="far fa-file-alt me-2"></i>
                    Data Master
                </x-sidebar.dropdown.header>
                <x-sidebar.dropdown.menu>
                    <x-sidebar.dropdown.link href="/data-master/data-role">
                        Data Role
                    </x-sidebar.dropdown.link>
                    <x-sidebar.dropdown.link href="/data-master/data-pt">
                        Data PT
                    </x-sidebar.dropdown.link>
                    <x-sidebar.dropdown.link href="/data-master/data-users">
                        Data Users
                    </x-sidebar.dropdown.link>
                    <x-sidebar.dropdown.link href="/data-master/nomor-surat">
                        Data Nomor Surat
                    </x-sidebar.dropdown.link>
                    <x-sidebar.dropdown.link href="/data-master/surat-jalan">
                        Data Surat Jalan
                    </x-sidebar.dropdown.link>
                </x-sidebar.dropdown.menu>
            </x-sidebar.dropdown>

            @endif
        </div>
    </nav>
</div>