@extends('layout.main_nomenu')

@section('konten')
    <!-- page title area end -->
    <div class="main-content-inner">
        <div class="sales-report-area sales-style-two">
            <div class="row">
                <!-- laporan -->
                <div class="col-md-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Laporan Withdrawal</h4>
                            <div class="list-group list-group-flush">
                                @foreach ($withdrawals as $withdrawal)
                                    <h6 class="bg-body-tertiary p-2 border-top border-bottom">{{ $withdrawal->tanggal }}
                                        <span
                                            class="float-end">Rp.{{ number_format($withdrawal->nominal, 0, ',', '.') }}</span>
                                    </h6>
                                    @php
                                        $withdrawalList = App\Models\Withdrawal::where(DB::raw('DATE(created_at)'), $withdrawal->tanggal)
                                            // ->where('rekening', $wallet->rekening)
                                            ->orderBy('created_at', 'desc')
                                            ->get();
                                    @endphp

                                    <ul class="list-group list-group-light mb-4">
                                        @foreach ($withdrawalList as $list)
                                            <a href="{{ route('withdrawal.detail', $withdrawal->tanggal) }}">
                                                <li
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <div class="d-flex align-items-center col-12">
                                                        <div class="ms-3 col-12">
                                                            <p class="fw-bold mb-1 me-3">{{ $list->kode_unik }} <span
                                                                    class="float-end">{{ $list->created_at }}</span>
                                                            </p>
                                                            <p class="text-muted mb-0">Rp.
                                                                {{ number_format($list->nominal, 2, ',', '.') }}
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
        </div>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print();

            window.addEventListener('afterprint', function() {

                window.location.href = '{{ url()->previous() }}';
            });

        });
    </script>
@endsection
