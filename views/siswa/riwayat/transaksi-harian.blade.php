@extends('layout.main')

@section('content')
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="sales-report-area sales-style-two">
            <div class="row">
                <!-- laporan -->
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Riwayat Transaksi</h4>
                            <div class="list-group list-group-flush">
                                @foreach ($transaksis as $transaksi)
                                    <h6 class="bg-body-tertiary p-2 border-top border-bottom">{{ $transaksi->tanggal }}
                                    </h6>
                                    @php
                                        $transaksiList = App\Models\Transaksi::select('invoice', 'tgl_transaksi')
                                            ->where(DB::raw('DATE(tgl_transaksi)'), $transaksi->tanggal)
                                            ->where('id_user', auth()->id())
                                            ->groupBy('invoice', 'tgl_transaksi')
                                            ->get();
                                    @endphp

                                    <ul class="list-group list-group-light mb-4">
                                        @foreach ($transaksiList as $list)
                                            @php
                                                $totalHarga = App\Models\Transaksi::where('invoice', $list->invoice)->sum('total_harga');
                                            @endphp
                                            <a href="{{ route('riwayat.detail', $list->invoice) }}">
                                                <li
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center col-12">
                                                        <div class="ms-3 col-12 ">
                                                            <p class="fw-bold mb-1 me-3">{{ $list->invoice }} <span
                                                                    class="float-end">{{ $list->tgl_transaksi }}</span>
                                                            </p>
                                                            <p class="text-muted mb-0">Rp.
                                                                {{ number_format($totalHarga, 2, ',', '.') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                            </a>
                                        @endforeach
                                    </ul>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
                <!-- laporan -->
            @endsection
