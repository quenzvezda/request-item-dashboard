{{-- resources/views/item_request_form.blade.php --}}

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

<script>
    document.getElementById('nik').addEventListener('input', function() {
        var nik = this.value;
        // Melakukan AJAX request ke server
        fetch('/api/get-employee-data/' + nik)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                document.getElementById('nama').value = data.nama;
                document.getElementById('departemen').value = data.departemen;
            })
            .catch(error => console.error('Error:', error));
    });

    window.onload = function() {
        var now = new Date();
        document.getElementById('tanggalPermintaan').value = now.toISOString().substring(0, 16);
    };

    function hapusBaris(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function tambahBaris() {
        var tabel = document.getElementById('daftarBarang').getElementsByTagName('tbody')[0];
        var nomorBaru = tabel.rows.length + 1;
        var barisBaru = tabel.insertRow();

        barisBaru.innerHTML = `
        <td>${nomorBaru}</td>
        <td><input type="text" class="form-control namaBarang" placeholder="Ketik nama atau kode barang">
            <input type="hidden" name="item_id[]" class="itemId">
        </td>
        <td><input type="text" class="form-control" name="lokasi[]" style="width: 100px" disabled></td>
        <td><input type="number" class="form-control" name="tersedia[]" style="width: 90px" disabled></td>
        <td><input type="number" class="form-control" name="kuantiti[]" style="width: 90px" value=1></td>
        <td><input type="text" class="form-control" name="satuan[]" style="width: 90px" disabled></td>
        <td><input type="text" class="form-control" name="keterangan[]" style="width: 90px" value="-"></td>
        <td><span class="status-label" data-status=""></span></td>
        <td><button class="btn btn-danger btn-sm" type="button" onclick="hapusBaris(this)"><i class="fas fa-times"></i></button></td>
    `;

        // Menambahkan autocomplete ke input nama barang
        $(barisBaru).find('.namaBarang').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "/api/get-item",
                    dataType: "json",
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response($.map(data, function(item) {
                            return {
                                label: item.nama_barang + " (" + item.kode_barang + ")",
                                value: item.nama_barang + " (" + item.kode_barang + ")",
                                lokasi: item.lokasi,
                                stok: item.stok,
                                satuan: item.satuan,
                                status: item.status,
                                id: item.id,
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                // Asumsi bahwa ui.item memiliki properti yang Anda butuhkan
                var row = $(this).closest('tr'); // Dapatkan baris dimana input autocomplete berada

                row.find('[name="lokasi[]"]').val(ui.item.lokasi);
                row.find('[name="tersedia[]"]').val(ui.item.stok);
                row.find('[name="satuan[]"]').val(ui.item.satuan);
                row.find('[name="status[]"]').val(ui.item.status);

                row.find('.itemId').val(ui.item.id);

                // Set min dan max untuk kuantiti
                var kuantitiInput = row.find('[name="kuantiti[]"]');
                kuantitiInput.attr('min', 1);
                kuantitiInput.attr('max', ui.item.stok);

                var statusLabel = row.find('.status-label');
                statusLabel.text(ui.item.status); // Mengatur teks status
                statusLabel.attr('data-status', ui.item.status); // Mengatur data-status
                statusLabel.removeClass('status-diproses status-terpenuhi status-ditolak'); // Hapus kelas sebelumnya
                statusLabel.addClass('status-' + ui.item.status.toLowerCase()); // Tambahkan kelas baru berdasarkan status
            }

        });
    }

    $(document).ready(function() {
        $('#addItemRequestForm').on('submit', function(e) {
            e.preventDefault();

            // Membuat objek FormData dari form
            var formData = new FormData(this);

            // Menyiapkan data untuk dikirim dalam format yang sesuai
            var payload = {};
            formData.forEach((value, key) => {
                // Menangani input array
                if (key.endsWith('[]')) {
                    key = key.slice(0, -2);
                    if (!Array.isArray(payload[key])) {
                        payload[key] = [];
                    }
                    payload[key].push(value);
                } else {
                    payload[key] = value;
                }
            });

            // Mengirim data ke API
            $.ajax({
                url: '/api/add-item-request', // Sesuaikan dengan URL endpoint API Anda
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(payload),
                success: function(response) {
                    $(document).trigger('addItemRequestSuccess');
                    // Reset formulir setelah berhasil
                    document.getElementById('addItemRequestForm').reset();

                    // Tampilkan toast notification
                    var toastEl = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastEl);
                    toast.show();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    // Tampilkan error atau lakukan tindakan lain jika terjadi kesalahan
                }
            });
        });

        // Inisialisasi toast
        var toastEl = document.getElementById('liveToast');
        var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 10000 });
    });


    // $(document).ready(function() {
    //     // Set CSRF token untuk setiap request AJAX
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //
    //     $('#addItemRequestForm').on('submit', function(e) {
    //         e.preventDefault(); // Mencegah form dari submit secara default
    //
    //         var formData = new FormData(this);
    //
    //         // Menangkap semua data dari form dan menyiapkannya untuk dikirim
    //         var payload = {};
    //         formData.forEach((value, key) => {
    //             // Menangani input array
    //             if (key.endsWith('[]')) {
    //                 key = key.slice(0, -2);
    //                 if (!Array.isArray(payload[key])) {
    //                     payload[key] = [];
    //                 }
    //                 payload[key].push(value);
    //             } else {
    //                 payload[key] = value;
    //             }
    //         });
    //
    //         // Mengirim data ke API
    //         $.ajax({
    //             url: '/api/add-item-request', // URL endpoint API
    //             type: 'POST',
    //             contentType: 'application/json',
    //             data: JSON.stringify(payload),
    //             success: function(response) {
    //                 console.log(response); // Tampilkan respons di konsol
    //                 // Tindakan jika berhasil, misalnya tampilkan pesan sukses atau refresh halaman
    //             },
    //             error: function(xhr, status, error) {
    //                 console.error(error); // Tampilkan error di konsol
    //                 // Tindakan jika terjadi error
    //             }
    //         });
    //     });
    // });



    // $(document).ready(function() {
    //     $('#addItemRequestForm').on('submit', function(e) {
    //         e.preventDefault(); // Mencegah form dari submit secara default
    //
    //         // Menangkap semua data dari form
    //         var formData = $(this).serializeArray();
    //         console.log(formData);
    //
    //         // Tempat untuk kode AJAX Anda
    //         // ...
    //     });
    // });

</script>


