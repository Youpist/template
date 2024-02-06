@extends('layout.main_nomenu')

@section('konten')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title"> Detail Laporan Topup</h4>
                        <div class="data-tables">
                            <table id="table2" class="table table-bordered table-hover text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Rekening</th>
                                        <th>Nama</th>
                                        <th>Nominal</th>
                                        <th>Kode Unik</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topups as $i => $topup)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td class="text-center">{{ $topup->created_at }}</td>
                                            <td class="text-center"> {{ $topup->wallet->rekening }}</td>
                                            <td class="text-center"> {{ $topup->wallet->user->name }}</td>
                                            <td class="text-center">Rp.{{ number_format($topup->nominal, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">{{ $topup->kode_unik }}</td>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.print();

            window.addEventListener('afterprint', function() {

                window.location.href = '{{ url()->previous() }}';
            });

        });
    </script>
@endsection
