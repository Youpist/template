<div class="sidebar sidebar-dark sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <h3 class="text-lg-bold">KANTINEIJR</h3>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link" href="{{ route('bank.index') }}">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-grid') }}"></use>
                </svg>Dashboard</a></li>
        <li class="nav-title">Akses</li>
        <li class="nav-item"><a class="nav-link" href="{{ route('bank.topup') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-thick-from-left') }}">
                    </use>
                </svg> Top Up</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('bank.withdrawal') }}">
                <svg class="nav-icon">
                    <use
                        xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-thick-from-right') }}">
                    </use>
                </svg> Withdrawal</a></li>
        <li class="nav-group"><a class="nav-link nav-group-toggle" href="#">
                <svg class="nav-icon">
                    <use xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-notes') }}"></use>
                </svg> Laporan</a>
            <ul class="nav-group-items">
                <li class="nav-item"><a class="nav-link" href="{{ route('bank.laporan.topup') }}"><span
                            class="nav-icon"></span> Top Up</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('bank.laporan.withdrawal') }}"><span
                            class="nav-icon"></span> Withdrawal</a></li>
            </ul>
        </li>
    </ul>
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
