@extends('layout.main')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">
                                    <div>
                                        <p class="text-sm">Transaksi Top Up</p>
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-right') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">{{ count($topups) }}</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-success">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">
                                    <div>
                                        <p class="text-sm">Total TopUp</p>
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-right') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">Rp.{{ $total_topup, 0, ',', '.' }}</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">
                                    <div>
                                        <p class="text-sm">Transaksi Withdrawal</p>
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-right') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">{{ count($withdrawals) }}</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6   ">
                    <div class="card mb-4 text-white bg-success">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-4 fw-semibold">
                                    <div>
                                        <p class="text-sm">Total Withdrawal</p>
                                        <svg class="icon">
                                            <use
                                                xlink:href="{{ asset('assets/vendors/@coreui/icons/svg/free.svg#cil-arrow-right') }}">
                                            </use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">Rp.{{ $total_wd, 0, ',', '.' }}</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Permintaan Topup</h4>
                            <div class="data-tables">
                                <table id="table2" class="table table-bordered table-hover text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer</th>
                                            <th>Rekening</th>
                                            <th>Nominal</th>
                                            <th>Kode Unik</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($requestTopups as $i => $topup)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $topup->wallet->user->name }}</td>
                                                <td>{{ $topup->rekening }}</td>
                                                <td>Rp. {{ number_format($topup->nominal, 0, ',', '.') }}</td>
                                                <td>{{ $topup->kode_unik }}</td>
                                                <td>{{ $topup->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Permintaan Tarik Tunai</h4>
                            <div class="data-tables">
                                <table id="table2" class="table table-bordered table-hover text-center">
                                    <thead class="bg-light text-capitalize">
                                        <tr>
                                            <th>No.</th>
                                            <th>Customer</th>
                                            <th>Rekening</th>
                                            <th>Nominal</th>
                                            <th>Kode Unik</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawals as $i => $withdrawal)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $withdrawal->wallet->user->name }}</td>
                                                <td>{{ $withdrawal->rekening }}</td>
                                                <td>{{ $withdrawal->nominal }}</td>
                                                <td>{{ $withdrawal->kode_unik }}</td>
                                                <td>{{ $withdrawal->status }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
