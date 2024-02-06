@extends('layout.main_nomenu')

@section('konten')
    <div class="main-content-inner">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <div class="invoice-area">
                            <div class="invoice-head">
                                <div class="row">
                                    <div class="iv-left col-6">
                                        <span>CHECKOUT</span>
                                    </div>
                                    <div class="iv-right col-6 text-md-right">
                                        <span>{{ $invoice }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <div class="invoice-address">
                                        <h3>Checkout</h3>
                                        <h5>{{ auth()->user()->name }}</h5>
                                        <p>{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6 text-md-right">
                                    <ul class="invoice-date">
                                        <li>Tanggal : {{ now()->format('d F Y') }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="invoice-table table-responsive mt-5">
                                <table class="table table-bordered table-hover text-right">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th scope="col">Produk</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($selectedProduks as $selectedProduk)
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    {{ $selectedProduk['produk']->nama_produk }}</td>
                                                <td style="vertical-align: middle;">
                                                    Rp.{{ number_format($selectedProduk['produk']->harga, 0, ',', '.') }},00
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    {{ $selectedProduk['kuantitas'] }}
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    Rp.{{ number_format($selectedProduk['total_harga'], 0, ',', '.') }},00
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3">Total Seluruh Harga :</td>
                                            <td>Rp.{{ number_format($totalharga, 0, ',', '.') }},00</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
