// Submit AJAX
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

                // Refresh halaman setelah 1 detik
                setTimeout(function() {
                    location.reload();
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Tampilkan error atau lakukan tindakan lain jika terjadi kesalahan
            }
        });
    });
});

// NIK Auto Complete
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

// Datetime Now
window.onload = function() {
    var now = new Date();
    document.getElementById('tanggalPermintaan').value = now.toISOString().substring(0, 16);
};

// Button HapusBaris
function hapusBaris(button) {
    var row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// Button Tambah Baris
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
