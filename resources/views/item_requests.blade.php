{{-- resources/views/item_requests.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Permintaan Barang</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    {{--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>--}}
    <!-- Gunakan jQuery versi penuh -->
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>

    <!-- Kemudian, muat jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .ui-autocomplete {
            z-index: 2000; /* Pastikan lebih tinggi dari z-index elemen lain */
            max-height: 200px; /* Atur tinggi maksimal jika diperlukan */
            overflow-y: auto; /* Tambahkan scrollbar jika terlalu panjang */
            border: 1px solid #ddd; /* Sesuaikan gaya border */
            /* Tambahkan gaya lain sesuai kebutuhan */
        }

        .status-label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 100%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
        }

        .status-diproses { background-color: #ffc107; } /* Warna kuning */
        .status-terpenuhi { background-color: #28a745; } /* Warna hijau */
        .status-ditolak { background-color: #dc3545; } /* Warna merah */
    </style>
</head>
<body>
<!-- Toast Notification -->
<div class="position-fixed top-0 end-0 p-3 center" style="z-index: 1500">
    <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            <strong class="me-auto">Pemberitahuan</strong>
            <small>Baru saja</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Data Berhasil Disimpan.
        </div>
    </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>
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
    @include('item_requests_form')

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

<script>
    $(document).on('addItemRequestSuccess', function() {
        var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    });
</script>

<!-- Bootstrap JS, Popper.js, and jQuery -->


<!-- Bootstrap JS dan Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

