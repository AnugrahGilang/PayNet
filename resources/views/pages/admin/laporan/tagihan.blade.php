@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">Laporan Tagihan</h3>

    {{-- Filter Form --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="GET" class="d-flex flex-wrap">
                <select name="bulan" class="form-control mr-2 mb-2" style="max-width: 180px;">
                    <option value="">-- Pilih Bulan --</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                            {{ date("F", mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>

                <select name="tahun" class="form-control mr-2 mb-2" style="max-width: 150px;">
                    <option value="">-- Pilih Tahun --</option>
                    @for ($t = date('Y'); $t >= 2020; $t--)
                        <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>
                            {{ $t }}
                        </option>
                    @endfor
                </select>

                <select name="status" class="form-control mr-2 mb-2" style="max-width: 180px;">
                    <option value="">-- Semua Status --</option>
                    <option value="lunas" {{ request('status')=='lunas'?'selected':'' }}>Lunas</option>
                    <option value="belum lunas" {{ request('status')=='belum lunas'?'selected':'' }}>Belum Lunas</option>
                </select>

                <button type="submit" class="btn btn-primary mb-2">Filter</button>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Tanggal Terbit</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tagihan as $t)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $t->pelanggan->nama_pelanggan ?? '-' }}</td>
                            <td>{{ $t->periode ?? '-' }}</td>
                            <td>Rp {{ number_format($t->jumlah_tagihan, 0, ',', '.') }}</td>
                            <td>{{ $t->tanggal_terbit }}</td>
                            <td>{{ $t->tanggal_jatuh_tempo }}</td>
                            <td>{{ ucfirst($t->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
