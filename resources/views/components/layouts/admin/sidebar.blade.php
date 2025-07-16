<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                <!-- ========   Change your logo from here   ============ -->
                <div class="d-flex align-items-center gap-3">
                    <h3 class="text-primary "><i class="ti ti-book me-2"></i>BOOK SHOP</h3>
                </div>
            </a>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}" class="pc-link">
                        <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Data Master</label>
                    <i class="ti ti-dashboard"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('pengguna.index') }}"
                        class="pc-link {{ request()->routeIs('pengguna.*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-users"></i></span>
                        <span class="pc-mtext">Data Pengguna</span>
                    </a>
                </li>
                <li
                    class="pc-item pc-hasmenu {{ request()->routeIs('kategori-buku.*') || request()->routeIs('buku.*') ? 'pc-trigger active' : '' }}">
                    <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-notebook"></i></span><span
                            class="pc-mtext">
                            Produk Buku
                        </span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
                    <ul class="pc-submenu"
                        style="{{ request()->routeIs('kategori-buku.*') || request()->routeIs('buku.*') ? 'display: block;' : '' }} box-sizing: border-box;">
                        <li class="pc-item {{ request()->routeIs('kategori-buku.index') ? 'active' : '' }}"><a
                                class="pc-link" href="{{ route('kategori-buku.index') }}">Kategori Buku</a></li>
                        <li class="pc-item {{ request()->routeIs('buku.*') ? 'active' : '' }}"><a class="pc-link"
                                href="{{ route('buku.index') }}">List Buku</a></li>
                    </ul>
                </li>
                <li class="pc-item">
                    <a href="{{ route('rekening.index') }}"
                        class="pc-link {{ request()->routeIs('rekening.*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-cash-banknote"></i></span>
                        <span class="pc-mtext">Data Rekening Toko</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Inventory</label>
                    <i class="ti ti-shopping-cart"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="pc-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-box"></i></span>
                        <span class="pc-mtext">Barang Masuk</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Transaksi</label>
                    <i class="ti ti-shopping-cart"></i>
                </li>
                <li class="pc-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="pc-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-clipboard-list"></i></span>
                        <span class="pc-mtext">Manajemen Pesanan</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="{{ route('admin.refunds.index') }}"
                        class="pc-link {{ request()->routeIs('admin.refunds.*') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-cash-banknote-off"></i></span>
                        <span class="pc-mtext">Manajemen Refund</span>
                    </a>
                </li>
                <li class="pc-item">
                    <a href="#" class="pc-link {{ request()->routeIs('') ? 'active' : '' }}">
                        <span class="pc-micon"><i class="ti ti-file"></i></span>
                        <span class="pc-mtext">Mutasi Barang</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
