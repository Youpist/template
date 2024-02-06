<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
      <h3 class="text-lg-bold">KANTINEIJR</h3>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('kantin.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-grid') }}"></use>
                </svg> Dashboard</a></li>
        <li class="nav-title">Theme</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('produk.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-dinner') }}"></use>
                </svg> Data Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('kategori.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-3d') }}"></use>
                </svg> Data Kategori</a></li>
        <li class="nav-title">Components</li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Laporan</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('kantin.transaksi') }}"><span
                            class="nav-icon"></span> Transaksi</a></li>
            </ul>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
