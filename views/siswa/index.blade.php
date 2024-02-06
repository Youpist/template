@extends('layout.main')

@section('content')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-primary">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fs-2 fw-semibold">
                                    <div>
                                        <p class="text">Saldo Anda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">Rp.{{ number_format($wallets->saldo, 0, ',', '.') }}</h3>
                            <p></p>
                        </div>
                        <div class="text-end me-2">
                            <button type="button" class="btn btn-light my-3 mr-3" data-coreui-toggle="modal"
                                data-coreui-target="#topupModal">Top Up</button>
                            <button type="button" class="btn btn-light my-3 mr-3" data-coreui-toggle="modal"
                                data-coreui-target="#tariktunaiModal">Tarik Tunai</button>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-6">
                    <div class="card mb-4 text-white bg-warning">
                        <div class="card-body pb-0 d-flex justify-content-between align-items-start">
                            <div class="fs-2 fw-semibold">
                                <div>
                                    <div class="fs-2 fw-semibold">
                                        <div>
                                            <p class="text">Rekening Anda</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-start mt-3">
                            <h3 class="mb-0 ms-3">{{ implode(' ', str_split(str_replace(',', '', $wallets->rekening), 3)) }}
                            </h3>
                            <p></p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Tabel Produk Kantin</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
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
                                            <td class="text-center"><img
                                                    src="{{ asset('./storage/produk/' . $produk->foto) }}"
                                                    alt="{{ $produk->nama_produk }} " width="100px"></td>
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

            <div class="modal fade" id="topupModal" tabindex="-1" role="dialog" aria-labelledby="topupModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="topupModalLabel">Top Up</h4>
                            <button type="button" class="close" data-coreui-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('topup') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rekening">Rekening</label>
                                    <input id="rekening" name="rekening" type="text" placeholder="" class="form-control"
                                        required value="{{ $wallets->rekening }}">
                                </div>

                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input type="text" id="nominal" class="form-control" placeholder="" name="nominal"
                                        required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-coreui-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Top Up</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tariktunaiModal" tabindex="-1" role="dialog"
                aria-labelledby="tariktunaiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="tariktunaiModalLabel">Tarik Tunai</h4>
                            <button type="button" class="close" data-coreui-dismiss="modal" aria-label="Close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('withdrawal') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="rekening">Rekening</label>
                                    <input id="rekening" name="rekening" type="text" placeholder=""
                                        class="form-control" required value="{{ $wallets->rekening }}">
                                </div>

                                <div class="form-group">
                                    <label for="nominal">Nominal</label>
                                    <input type="text" id="nominal" class="form-control" placeholder=""
                                        name="nominal" required>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-coreui-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Batal</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Tarik Tunai</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
