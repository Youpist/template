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
                                        <p class="text-sm">Total Pemasukan</p>
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
                            <h3 class="mb-0 ms-3">Rp.{{ number_format($total_pemasukan, 0, ',', '.') }}</h3>
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
                                        <p class="text-sm">Total Perhari</p>
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
                            <h3 class="mb-0 ms-3">Rp.{{ number_format($total_perhari, 0, ',', '.') }}</h3>
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Daftar Produk</h4>
                <div class="data-tables mt-3">
                    <table id="table2" class="table table-bordered table-hover">
                        <thead class="bg-light text-capitalize">
                            <tr>
                                <th>No.</th>
                                <th>Produk</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Kategori</th>
                                <th>Desc</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produks as $i => $produk)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td class="text-center"><img src="{{ asset('./storage/produk/' . $produk->foto) }}"
                                            alt="{{ $produk->nama_produk }}" style="width: 100px;"></td>
                                    <td>{{ $produk->nama_produk }}</td>
                                    <td>Rp.{{ number_format($produk->harga, 0, ',', '.') }},00</td>
                                    <td>{{ $produk->stok }}</td>
                                    <td>{{ $produk->kategori->nama_kategori }}</td>
                                    <td>{{ $produk->desc }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
