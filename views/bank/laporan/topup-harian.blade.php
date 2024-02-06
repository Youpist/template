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
                            <h4 class="header-title">Laporan Topup</h4>
                            <div class="list-group list-group-flush">
                                @foreach ($topups as $topup)
                                    <h6 class="bg-body-tertiary p-2 border-top border-bottom">{{ $topup->tanggal }}
                                        <span class="float-end">Rp.{{ number_format($topup->nominal, 0, ',', '.') }}</span>
                                    </h6>
                                    @php
                                        $topupList = App\Models\TopUp::where(DB::raw('DATE(created_at)'), $topup->tanggal)
                                            // ->where('rekening', $wallet->rekening)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                                    @endphp

                                    <ul class="list-group list-group-light mb-4">
                                        @foreach ($topupList as $list)
                                            <a href="{{ route('topup.detail', $topup->tanggal) }}">
                                                <li
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center col-12">
                                                        <div class="ms-3 col-12">
                                                            <p class="fw-bold mb-1 me-3">{{ $list->kode_unik }} <span
                                                                    class="float-end">{{ $list->created_at }}</span>
                                                            </p>
                                                            <p class="text-success mb-0 me-3">+ Rp.
                                                                {{ number_format($list->nominal, 2, ',', '.') }}
                                                                <span
                                                                    class="float-end">Rek:{{ implode(' ', str_split(str_replace(',', '', $list->wallet->rekening), 4)) }}</span>
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
            </div>
            <!-- laporan -->
        @endsection
    </div>
</div>
</div>
