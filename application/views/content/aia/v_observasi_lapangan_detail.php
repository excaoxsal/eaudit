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
            <h3 class="card-label">List Observasi Lapangan
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
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td><input type="text" class="form-control" name="hasil_observasi"></td>
                    <td><input type="text" class="form-control" name="klausul"></td>
                    <td><input type="file" class="form-control-file" name="file"></td>
                    <td>
                        <select class="form-control" name="klasifikasi">
                            <option value="MAJOR">MAJOR</option>
                            <option value="MINOR">MINOR</option>
                            <option value="OBSERVASI">OBSERVASI</option>
                        </select>
                    </td>
                    <td><button class="btn btn-danger remove-row">Remove</button></td>
                </tr>
                </tbody>
            </table>
          </div>
<script>
    $(document).ready(function () {
        let rowCount = 1;

        $('#add-row').click(function () {
            let newRow = `
                <tr>
                    <td>${rowCount}</td>
                    <td><input type="text" class="form-control" name="hasil_observasi"></td>
                    <td><input type="text" class="form-control" name="klausul"></td>
                    <td><input type="file" class="form-control-file" name="file"></td>
                    <td>
                        <select class="form-control" name="klasifikasi">
                            <option value="MAJOR">MAJOR</option>
                            <option value="MINOR">MINOR</option>
                            <option value="OBSERVASI">OBSERVASI</option>
                        </select>
                    </td>
                    <td><button class="btn btn-danger remove-row">Remove</button></td>
                </tr>
            `;
            $('#observasi-table tbody').append(newRow);
            updateRowNumbers();
        });

        // Delegate event to handle dynamically added rows
        $('#observasi-table').on('click', '.remove-row', function () {
            $(this).closest('tr').remove();
            updateRowNumbers();
        });

        function updateRowNumbers() {
            $('#observasi-table tbody tr').each(function (index) {
                $(this).find('td:first').text(index + 1);
            });
            rowCount = $('#observasi-table tbody tr').length + 1;
        }

        $('input, select').change(function () {
            let formData = new FormData();
            formData.append('no', 1);
            formData.append('hasil_observasi', $('input[name="hasil_observasi"]').val());
            formData.append('klausul', $('input[name="klausul"]').val());
            formData.append('klasifikasi', $('select[name="klasifikasi"]').val());

            if ($('input[name="file"]')[0].files[0]) {
                formData.append('file', $('input[name="file"]')[0].files[0]);
            }

            $.ajax({
                url: '<?= base_url('observasi/save') ?>',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });
</script>