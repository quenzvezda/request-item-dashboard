{{-- resources/views/item_requests.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permintaan Barang</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

{{--Modal Pop up Form--}}
<div class="modal fade" id="addItemRequestModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Permintaan Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addItemRequestForm">
                    <div class="form-group">
                        <label for="nik">NIK Peminta</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK beserta titik (.)">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" disabled>
                    </div>
                    <div class="form-group">
                        <label for="departemen">Departemen</label>
                        <input type="text" class="form-control" id="departemen" name="departemen" disabled>
                    </div>
                    <div class="form-group">
                        <label for="tanggalPermintaan">Tanggal Permintaan</label>
                        <input type="datetime-local" class="form-control" id="tanggalPermintaan" name="tanggalPermintaan">
                    </div>
                    <!-- Tambahkan field lainnya sesuai kebutuhan -->
                    <div class="form-group table-responsive">
                        <div class="row" style="padding: 10px;">
                            <div class="col">
                                <label>Daftar Barang:</label>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-primary" onclick="tambahBaris()">Tambah</button>
                            </div>
                        </div>
                        <table class="table" id="daftarBarang">
                            <thead>
                            <tr>
                                <th>No.</th>
                                <th>Barang</th>
                                <th>Lokasi</th>
                                <th style="width: 80px;">Tersedia</th>
                                <th>Kuantiti</th>
                                <th>Satuan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>*</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Baris akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="submit" form="addItemRequestForm" class="btn btn-primary">Tambah Permintaan</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Daftar Permintaan Barang</h1>
        </div>
        <div class="col-auto">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addItemRequestModal">
                Tambah Permintaan Barang
            </button>
        </div>
    </div>
    <table class="table" style="margin-top: 20px">
        <!-- Tabel head dan body -->
        <thead>
        <tr>
            <th>No.</th>
            <th>Peminta</th>
            <th>Tanggal Permintaan</th>
            <th>Aksi</th>
            <!-- Tambahkan kolom lain sesuai kebutuhan -->
        </tr>
        </thead>
        <tbody>
        @foreach ($itemRequest as $request)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $request->employee->nik }} - {{ $request->employee->nama }}</td>
                <td>{{ \Carbon\Carbon::parse($request->tanggal_permintaan)->format('d F Y H:i') }}</td>
                <td><a href="{{ route('item-requests.show', $request->id) }}" class="btn btn-info btn-sm">Lihat Detail</a></td>
                <!-- Tampilkan data lainnya jika perlu -->
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>

