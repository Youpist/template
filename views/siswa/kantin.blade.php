@extends('layout.main')

@section('content')
    <div class="row">
        <div class="col-12 mt-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-bold">Produk</h4>
                    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center mt-5">
                        @foreach ($produks as $produk)
                            <div class="col-3 mb-5">
                                <div class="card h-100"
                                    style="box-shadow: rgba(9, 30, 66, 0.25) 0px 4px 8px -2px, rgba(9, 30, 66, 0.08) 0px 0px 0px 1px;">
                                    <!-- Product itmage-->
                                    <img class="card-img-top" src="{{ asset('storage/produk/' . $produk->foto) }}"
                                        alt="{{ $produk->nama_produk }}" style="max-height: 15em; object-fit: cover;" />
                                    <!-- Product details-->
                                    <div class="card-body p-4">
                                        <div class="text-center">
                                            <h5 class="fw-bolder mb-3">{{ $produk->nama_produk }}</h5>
                                            <p class="mb-3">{{ $produk->kategori->nama_kategori }}</p>
                                            <p class="mb-3">Tersedia :{{ $produk->stok }}</p>
                                            <h5>Rp. {{ number_format($produk->harga, 0, ',', '.') }},00</h5>
                                        </div>
                                    </div>
                                    <!-- Product actions-->
                                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center"><button class="btn btn-outline-dark mt-auto"
                                                data-coreui-toggle="modal"
                                                data-coreui-target="#addToCart{{ $produk->id }}"><i
                                                    class="ti-shopping-cart"></i> Tambah ke Keranjang</button></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    @foreach ($produks as $produk)
        <div class="modal fade" id="addToCart{{ $produk->id }}" tabindex="-1" role="dialog"
            aria-labelledby="addToCart{{ $produk->id }}Label" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="addToCart{{ $produk->id }}Label">Tambah ke Keranjang</h4>
                        <button type="button" class="close" data-coreui-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('addToCart', $produk->id) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="id_user" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="id_produk" value="{{ $produk->id }}">
                            <input type="hidden" name="harga" value="{{ $produk->harga }}">
                            <div class="form-group">
                                <label for="jumlah_produk">Qty</label>
                                <input id="jumlah_produk" name="jumlah_produk" type="number" placeholder=""
                                    class="form-control" required min="1" max="{{ $produk->stok }}" value="1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-coreui-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
