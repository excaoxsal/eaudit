<style>
  /* Warna untuk klasifikasi */
  .klasifikasi-major {
    background-color: #dc3545 !important;
    color: white !important;
    border-color: #bd2130 !important;
  }
  
  .klasifikasi-minor {
    background-color: #ffc107 !important;
    color: #212529 !important;
    border-color: #d39e00 !important;
  }
  
  .klasifikasi-observasi {
    background-color: #17a2b8 !important;
    color: white !important;
    border-color: #117a8b !important;
  }
  
  /* Efek transisi untuk perubahan warna */
  .klasifikasi-select {
    transition: all 0.3s ease;
    padding: 8px 12px;
    border-radius: 4px;
    width: 100%;
    border: 1px solid #ddd;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 1em;
  }
  
  /* Style untuk tabel */
  #observasi-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  #observasi-table th, 
  #observasi-table td {
    padding: 12px;
    border: 1px solid #ddd;
    vertical-align: top;
  }
  
  #observasi-table th {
    background-color: #f8f9fa;
    font-weight: bold;
    text-align: left;
  }
  
  /* Style untuk textarea */
  .form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
  }
  
  /* Style untuk tombol */
  .btn {
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    border: none;
    font-weight: 500;
  }
  
  .btn-success {
    background-color: #28a745;
    color: white;
  }
  
  .btn-danger {
    background-color: #dc3545;
    color: white;
  }
  
  .btn-primary {
    background-color: #007bff;
    color: white;
  }
  
  /* Style untuk file input */
  .form-control-file {
    width: 100%;
  }
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-klau-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-klau-center flex-wrap mr-2">
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4">Detail Observasi Lapangan</span>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4"><?=$detail['0']['NOMOR_ISO']?></span>
            <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
            <span class="text-muted font-weight-bold mr-4"><?=$detail['0']['KODE']?></span>
        </div>
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <div class="container">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">List Visit Lapangan
            </div>
            </div>
            <div class="card-body">
            <?php if ($this->session->flashdata('error')) { ?>
                <div class="alert alert-danger alert-dismissible text-left">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban text-white"></i> Error!</h4>
                    <?= $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success')) { ?>
            <div class="input-group mb-3">
                <div class="alert alert-success alert-dismissible" style="width: 100%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h6><i class="icon fa fa-check text-white"></i> Success!</h6>
                    <?= $this->session->flashdata('success'); ?>
                </div>
            </div>
            <?php } ?>
            
            <div class="container">
                <button id="add-row" class="btn btn-primary mb-3">Tambah Baru</button>
                <table class="table table-bordered" id="observasi-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Hasil Visit Lapangan</th>
                            <th>Klausul</th>
                            <th>File</th>
                            <th>Klasifikasi</th>
                            <th colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($observasi)): ?>
                            <?php foreach ($observasi as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <input type="hidden" name="id" value="<?= $item['ID_VISIT'] ?>">
                                <td>
                                    <textarea class="form-control" name="hasil_observasi" rows="3"><?= htmlspecialchars($item['HASIL_OBSERVASI']) ?></textarea>
                                </td>
                                <td>
                                    <select class="form-control" name="id_master_pertanyaan">
                                        <option value="">Pilih Klausul</option>
                                        <?php foreach ($klausul as $klau): ?>
                                            <option value="<?= $klau['ID_MASTER_PERTANYAAN'] ?>"<?= $item['ID_MASTER_PERTANYAAN'] == $klau['ID_MASTER_PERTANYAAN'] ? 'selected' : '' ?>><?= $klau['KLAUSUL'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <?php if (!empty($item['FILE'])): ?>
                                        <a href="<?= $item['FILE'] ?>" target="_blank" class="file-link">Lihat File</a>
                                        <input type="hidden" name="existing_file" value="<?= $item['FILE'] ?>">
                                    <?php endif; ?>
                                    <input type="file" class="form-control-file" name="file">
                                </td>
                                <td>
                                    <select class="form-control klasifikasi-select" name="klasifikasi">
                                        <option value="MAJOR" <?= $item['KLASIFIKASI'] == 'MAJOR' ? 'selected' : '' ?>>MAJOR</option>
                                        <option value="MINOR" <?= $item['KLASIFIKASI'] == 'MINOR' ? 'selected' : '' ?>>MINOR</option>
                                        <option value="OBSERVASI" <?= $item['KLASIFIKASI'] == 'OBSERVASI' ? 'selected' : '' ?>>OBSERVASI</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-success submit-row" data-id="<?= $item['ID_VISIT'] ?>">
                                        Simpan
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger remove-row" data-id="<?= $item['ID_VISIT'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>1</td>
                                <input type="hidden" name="id" value="">
                                <td><textarea class="form-control" name="hasil_observasi" rows="3"></textarea></td>
                                <td>
                                    <select class="form-control" name="id_master_pertanyaan">
                                        <option value="">Pilih Klausul</option>
                                        <?php foreach ($klausul as $klau): ?>
                                            <option value="<?= $klau['ID_MASTER_PERTANYAAN'] ?>"><?= $klau['KLAUSUL'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="file" class="form-control-file" name="file"></td>
                                <td>
                                    <select class="form-control klasifikasi-select" name="klasifikasi">
                                        <option value="MAJOR">MAJOR</option>
                                        <option value="MINOR">MINOR</option>
                                        <option value="OBSERVASI">OBSERVASI</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-success submit-row">Simpan</button></td>
                                <td><button class="btn btn-danger remove-row">Hapus</button></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<script>
$(document).ready(function () {
    // Fungsi untuk update warna klasifikasi
    function updateKlasifikasiColor(selectElement) {
        const selectedValue = selectElement.val();
        selectElement.removeClass('klasifikasi-major klasifikasi-minor klasifikasi-observasi');
        
        if (selectedValue === "MAJOR") {
            selectElement.addClass('klasifikasi-major');
        } else if (selectedValue === "MINOR") {
            selectElement.addClass('klasifikasi-minor');
        } else if (selectedValue === "OBSERVASI") {
            selectElement.addClass('klasifikasi-observasi');
        }
    }

    // Inisialisasi warna saat pertama kali load
    $('.klasifikasi-select').each(function() {
        updateKlasifikasiColor($(this));
    });
    
    // Event handler untuk perubahan klasifikasi
    $(document).on('change', '.klasifikasi-select', function() {
        updateKlasifikasiColor($(this));
    });

    let rowCount = <?= !empty($observasi) ? count($observasi) : 1 ?>;
    
    // Tambah baris baru
    $('#add-row').click(function () {
        rowCount++;
        let newRow = `
            <tr>
                <td>${rowCount}</td>
                <input type="hidden" name="id" value="">
                <td><textarea class="form-control" name="hasil_observasi" rows="3"></textarea></td>
                <td>
                    <select class="form-control" name="id_master_pertanyaan">
                        <option value="">Pilih Klausul</option>
                        <?php foreach ($klausul as $klau): ?>
                        <option value="<?= $klau['ID_MASTER_PERTANYAAN'] ?>"><?= $klau['KLAUSUL'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input type="file" class="form-control-file" name="file"></td>
                <td>
                    <select class="form-control klasifikasi-select" name="klasifikasi">
                        <option value="MAJOR">MAJOR</option>
                        <option value="MINOR">MINOR</option>
                        <option value="OBSERVASI">OBSERVASI</option>
                    </select>
                </td>
                <td><button class="btn btn-success submit-row">Simpan</button></td>
                <td><button class="btn btn-danger remove-row">Hapus</button></td>
            </tr>
        `;
        $('#observasi-table tbody').append(newRow);
        
        // Inisialisasi warna untuk select baru
        setTimeout(function() {
            $('select.klasifikasi-select').last().change();
        }, 100);
    });

    // Hapus baris
    $(document).on('click', '.remove-row', function () {
        const row = $(this).closest('tr');
        const idVisit = row.find('input[name="id"]').val();
        const button = $(this);

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menghapus...');
                
                $.ajax({
                    url: '<?= base_url("aia/visit_lapangan/delete_visit/") ?>' + idVisit,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: "Data berhasil dihapus",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            row.remove();
                            updateRowNumbers();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message || 'Gagal menghapus data'
                            });
                            button.prop('disabled', false).html('Hapus');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menghapus data'
                        });
                        button.prop('disabled', false).html('Hapus');
                    }
                });
            }
        });
    });

    // Simpan baris
    $(document).on('click', '.submit-row', function () {
        const row = $(this).closest('tr');
        saveRowData(row);
    });

    function saveRowData(row) {
        const formData = new FormData();
        formData.append('hasil_observasi', row.find('textarea[name="hasil_observasi"]').val());
        formData.append('id', row.find('input[name="id"]').val());
        formData.append('id_master_pertanyaan', row.find('select[name="id_master_pertanyaan"]').val());
        formData.append('klasifikasi', row.find('select[name="klasifikasi"]').val());
        formData.append('id_response', '<?= $detail['0']['ID_HEADER'] ?>');
        
        // Handle existing file
        const existingFile = row.find('input[name="existing_file"]').val();
        if (existingFile) {
            formData.append('existing_file', existingFile);
        }
        
        // Handle file upload
        const fileInput = row.find('input[name="file"]')[0];
        if (fileInput && fileInput.files && fileInput.files.length > 0) {
            formData.append('file', fileInput.files[0]);
        }

        const button = row.find('.submit-row');
        button.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');

        $.ajax({
            url: '<?= base_url('aia/Visit_lapangan/save') ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                try {
                    const res = typeof response === 'string' ? JSON.parse(response) : response;
                    
                    if (res.status === 'success') {
                        // Update semua data di row
                        if (res.data) {
                            row.find('input[name="id"]').val(res.data.ID_VISIT || '');
                            
                            // Update klasifikasi dan warnanya
                            const klasifikasiSelect = row.find('select[name="klasifikasi"]');
                            klasifikasiSelect.val(res.data.KLASIFIKASI);
                            updateKlasifikasiColor(klasifikasiSelect);
                            
                            // Update file link
                            const fileCell = row.find('td:eq(3)');
                            
                            // Hapus elemen file yang ada jika ada
                            fileCell.find('a.file-link').remove();
                            fileCell.find('input[name="existing_file"]').remove();
                            
                            if (res.data.FILE) {
                                // Tambahkan elemen baru dengan prepend
                                fileCell.prepend(`
                                    <a href="${res.data.FILE}" target="_blank" class="file-link">Lihat File</a><br>
                                    <input type="hidden" name="existing_file" value="${res.data.FILE}">
                                `);
                            }
                            
                            // Reset file input
                            fileCell.find('input[name="file"]').val('');
                        }
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message || 'Gagal menyimpan data'
                        });
                    }
                } catch (e) {
                    console.error('Error parsing response:', e, response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat memproses respons'
                    });
                }
                button.prop('disabled', false).html('Simpan');
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat menyimpan data: ' + error
                });
                button.prop('disabled', false).html('Simpan');
            }
        });
    }

    // Update nomor baris
    function updateRowNumbers() {
        $('#observasi-table tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
        rowCount = $('#observasi-table tbody tr').length;
    }
});
</script>