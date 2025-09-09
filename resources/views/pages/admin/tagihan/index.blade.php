@extends('layouts.app')

@section('title', 'Data Tagihan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Tagihan</h3>
            <div class="card-tools">
                <!-- Tombol buka modal -->
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                    data-bs-target="#modalTambahTagihan">
                    <i class="fas fa-plus"></i> Tambah Tagihan
                </button>
            </div>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Jatuh Tempo</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tagihan as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->pelanggan->nama_pelanggan }}</td>
                        <td>{{ $t->periode }}</td>
                        <td>Rp {{ number_format($t->jumlah_tagihan,0,',','.') }}</td>
                        <td>{{ $t->produk }}</td>
                        <td>{{ $t->status }}</td>
                        <td>{{ $t->tanggal_terbit }}</td>
                        <td>{{ $t->tanggal_jatuh_tempo }}</td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#modalEditTagihan{{ $t->id }}">
                                Edit
                            </button>
                            <form action="{{ route('tagihan.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Tagihan -->
<div class="modal fade" id="modalTambahTagihan" tabindex="-1" aria-labelledby="modalTambahTagihanLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tagihan.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahTagihanLabel">Input Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="pelanggan_id" class="form-control" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggan as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan / Periode</label>
                        <input type="text" name="periode" class="form-control"
                            placeholder="Misal: Biaya Instalasi / September 2025" required>
                    </div>

                    <div class="form-group">
                        <label>Produk</label>
                        <input type="text" name="produk" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="jumlah_tagihan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_terbit" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                            <option value="Jatuh Tempo">Jatuh Tempo</option>
                        </select>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach($tagihan as $t)
<div class="modal fade" id="modalEditTagihan{{ $t->id }}" tabindex="-1"
    aria-labelledby="modalEditTagihanLabel{{ $t->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('tagihan.update', $t->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditTagihanLabel{{ $t->id }}">Edit Tagihan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label>Pelanggan</label>
                        <select name="pelanggan_id" class="form-control" required>
                            @foreach($pelanggan as $p)
                            <option value="{{ $p->id }}" {{ $t->pelanggan_id == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_pelanggan }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan / Periode</label>
                        <input type="text" name="periode" class="form-control" value="{{ $t->periode }}" required>
                    </div>

                    <div class="form-group">
                        <label>Produk</label>
                        <input type="text" name="produk" class="form-control" value="{{ $t->produk }}" required>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="jumlah_tagihan" class="form-control" value="{{ $t->jumlah_tagihan }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal_terbit" class="form-control" value="{{ $t->tanggal_terbit }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label>Jatuh Tempo</label>
                        <input type="date" name="tanggal_jatuh_tempo" class="form-control"
                            value="{{ $t->tanggal_jatuh_tempo }}" required>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="Belum Lunas" {{ $t->status == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas
                            </option>
                            <option value="Lunas" {{ $t->status == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Jatuh Tempo" {{ $t->status == 'Jatuh Tempo' ? 'selected' : '' }}>Jatuh Tempo
                            </option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-warning">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach


@endsection
