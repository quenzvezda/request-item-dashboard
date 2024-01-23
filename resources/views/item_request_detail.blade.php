{{-- resources/views/item_request_detail.blade.php --}}
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Permintaan Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Style yang sama dari halaman item_requests -->
    <style>
        /* (Style yang sama dari halaman item_requests) */
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <h1 class="mb-4">Detail Permintaan Barang (ID: {{ $itemRequest->id }})</h1>
        </div>
        <div class="col-auto">
            <a href="{{ url('/item-requests') }}" class="btn btn-secondary mb-4">Kembali ke Daftar Permintaan</a>
        </div>
    </div>

    <!-- Informasi Umum tentang Permintaan -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Informasi Permintaan</h5>
            <p class="card-text">Peminta: {{ $itemRequest->employee->nik }} - {{ $itemRequest->employee->nama }}</p>
            <p class="card-text">Tanggal Permintaan: {{ \Carbon\Carbon::parse($itemRequest->tanggal_permintaan)->format('d F Y H:i') }}</p>
            <!-- Tambahkan informasi lain yang relevan -->
        </div>
    </div>

    <!-- Tabel Detail Permintaan -->
    <table class="table">
        <thead>
        <tr>
            <th>No.</th>
            <th>Nama Barang</th>
            <th>Kuantitas</th>
            <th>Keterangan</th>
            <!-- Tambahkan kolom lain sesuai kebutuhan -->
        </tr>
        </thead>
        <tbody>
        @foreach ($itemRequest->itemRequestDetails as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->item->nama_barang }}</td>
                <td>{{ $detail->kuantitas }}</td>
                <td>{{ $detail->keterangan }}</td>
                <!-- Tampilkan data lainnya jika perlu -->
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Bootstrap JS, Popper.js, and jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
