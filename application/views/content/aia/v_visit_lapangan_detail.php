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
                <button id="add-row" class="btn btn-primary mb-3">Add Row</button>
                <table class="table table-bordered" id="observasi-table">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Hasil Visit Lapangan</th>
                        <th>Klausul</th>
                        <th>File</th>
                        <th>Klasifikasi</th>
                        <th colspan="2">Action</th>
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
                                        <a href="<?= $item['FILE'] ?>" 
                                        target="_blank">Lihat File</a>
                                        <input type="hidden" name="file" value="<?= $item['FILE'] ?>">
                                    <?php endif; ?>
                                    <input type="file" class="form-control-file" name="file">
                                </td>
                                <td>
                                    <select class="form-control" name="klasifikasi">
                                        <option value="MAJOR" <?= $item['klasifikasi'] == 'MAJOR' ? 'selected' : '' ?>>MAJOR</option>
                                        <option value="MINOR" <?= $item['klasifikasi'] == 'MINOR' ? 'selected' : '' ?>>MINOR</option>
                                        <option value="OBSERVASI" <?= $item['klasifikasi'] == 'OBSERVASI' ? 'selected' : '' ?>>OBSERVASI</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-success submit-row" data-id="<?= $item['id'] ?>">
                                        Simpan
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-danger remove-row" data-id="<?= $item['id'] ?>">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td>1</td>
                                <input type="hidden" name="id" value="">
                                <td><textarea class="form-control" name="hasil_observasi" rows="3"><?= htmlspecialchars($item['HASIL_OBSERVASI']) ?></textarea></td>
                                <td>
                                    <select class="form-control" name="id_master_pertanyaan">
                                        <option value="">Pilih Klausul</option>
                                        <?php foreach ($klausul as $klau): ?>
                                            <option value="<?= $klau['ID_MASTER_PERTANYAAN'] ?>"<?= $item['ID_MASTER_PERTANYAAN'] == $klau['ID_MASTER_PERTANYAAN'] ? 'selected' : '' ?>><?= $klau['KLAUSUL'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="file" class="form-control-file" name="file"></td>
                                <td>
                                    <select class="form-control" name="klasifikasi">
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
        let rowCount = <?= $index + 1 ?>;
        
        // console.log('<?= json_encode($detail) ?>');
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
                            <option value="<?= $klau['ID_MASTER_PERTANYAAN'] ?>"<?= $item['ID_MASTER_PERTANYAAN'] == $klau['ID_MASTER_PERTANYAAN'] ? 'selected' : '' ?>><?= $klau['KLAUSUL'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="file" class="form-control-file" name="file"></td>
                    <td>
                        <select class="form-control" name="klasifikasi">
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
        });

        // Handle delete row
        $('#observasi-table').on('click', '.remove-row', function () {
            var row = $(this).closest('tr');
            var idVisit = row.find('input[name="id"]').val(); // Ambil ID_VISIT

            // Tampilkan konfirmasi sebelum hapus
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                // Kirim data ke controller
                $.ajax({
                    url: '<?= base_url("aia/visit_lapangan/delete_visit/") ?>' + idVisit,
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            // Hapus baris dari tampilan
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: "Berhasil Dihapus",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            row.remove();
                            updateRowNumbers(); // Fungsi untuk memperbarui nomor baris
                        } else {
                            alert('Gagal menghapus data!');
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Terjadi kesalahan saat menghapus data!');
                        console.log(error);
                    }
                });
            }
        });


        // Handle save row
        $('#observasi-table').on('click', '.submit-row', function () {
            const row = $(this).closest('tr');
            saveRowData(row);
        });

        function saveRowData(row) {
            const formData = new FormData();
            formData.append('hasil_observasi', row.find('textarea[name="hasil_observasi"]').val());
            formData.append('id', row.find('input[name="id"]').val());
            formData.append('existing_file', row.find('input[name="file"]').val());
            formData.append('id_master_pertanyaan', row.find('select[name="id_master_pertanyaan"]').val());
            formData.append('klasifikasi', row.find('select[name="klasifikasi"]').val());
            
            formData.append('id_response', '<?= $detail['0']['ID_HEADER'] ?>');
            // console.log(formData.get('id_response'));
            // Append file if exists
            const fileInput = row.find('input[name="file"]')[0];
            if (fileInput && fileInput.files && fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);
            }

            $.ajax({
                url: '<?= base_url('aia/Visit_lapangan/save') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    row.find('.submit-row').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Menyimpan...');
                },
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: res.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        row.find('.submit-row').prop('disabled', false).html('Simpan');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message
                        });
                        row.find('.submit-row').prop('disabled', false).html('Simpan');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan saat menyimpan data'
                    });
                    row.find('.submit-row').prop('disabled', false).html('Simpan');
                }
            });
        }

        function updateRowNumbers() {
            $('#observasi-table tbody tr').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });
            rowCount = $('#observasi-table tbody tr').length;
        }
    });
</script>