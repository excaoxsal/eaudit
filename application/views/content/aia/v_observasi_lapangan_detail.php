<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
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
                        <th>Hasil Observasi</th>
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
                                <td>
                                    <input type="text" class="form-control" name="hasil_observasi" 
                                        value="<?= htmlspecialchars($item['HASIL_OBSERVASI']) ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="klausul" 
                                        value="<?= htmlspecialchars($item['KLAUSUL']) ?>">
                                </td>
                                <td>
                                    <?php if (!empty($item['FILE'])): ?>
                                        <a href="<?= base_url('uploads/observasi/'.$item['FILE']) ?>" 
                                        target="_blank">Lihat File</a>
                                        <input type="hidden" name="existing_file" value="<?= $item['FILE'] ?>">
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
                                <td><input type="text" class="form-control" name="hasil_observasi"></td>
                                <td>
                                    <select class="form-control" name="klausul">
                                        <option value="">Pilih Klausul</option>
                                        <?php foreach ($klausul as $item): ?>
                                            <option value="<?= $item['KLAUSUL'] ?>"><?= $item['KLAUSUL'] ?></option>
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
        let rowCount = 1;
        console.log('<?= json_encode($detail) ?>');
        $('#add-row').click(function () {
            rowCount++;
            let newRow = `
                <tr>
                    <td>${rowCount}</td>
                    <td><input type="text" class="form-control" name="hasil_observasi"></td>
                    <td>
                        <select class="form-control" name="klausul">
                            <option value="">Pilih Klausul</option>
                            <?php foreach ($klausul as $item): ?>
                                <option value="<?= $item['KLAUSUL'] ?>"><?= $item['KLAUSUL'] ?></option>
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
            $(this).closest('tr').remove();
            updateRowNumbers();
        });

        // Handle save row
        $('#observasi-table').on('click', '.submit-row', function () {
            const row = $(this).closest('tr');
            saveRowData(row);
        });

        function saveRowData(row) {
            const formData = new FormData();
            formData.append('hasil_observasi', row.find('input[name="hasil_observasi"]').val());
            formData.append('klausul', row.find('input[name="klausul"]').val());
            formData.append('klasifikasi', row.find('select[name="klasifikasi"]').val());
            formData.append('count', rowCount);
            formData.append('id_response', '<?= $detail['0']['ID_HEADER'] ?>');
            // console.log(formData.get('id_response'));
            // Append file if exists
            const fileInput = row.find('input[name="file"]')[0];
            if (fileInput.files.length > 0) {
                formData.append('file', fileInput.files[0]);
            }

            $.ajax({
                url: '<?= base_url('aia/Observasi_lapangan/save') ?>',
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