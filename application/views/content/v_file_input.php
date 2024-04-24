<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Laporan Hasil Audit</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Entry</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <form class="form" id="form_lha" method="post">
        <div class="card card-custom">
          <div class="card-header">
          <div class="card-title">
            <h3 class="card-label"><?= $title ?></h3>
          </div>

          </div>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Divisi</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control selectpicker" id="nomor_spa" name="NOMOR_SPA" readonly>
                    <option value="<?= $divisi->ID_DIVISI ?>"><?= $divisi->NAMA_DIVISI ?></option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Matrix File</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control selectpicker" id="ID_JENIS_AUDIT" name="ID_JENIS_AUDIT" readonly>
                    <option value="<?= $mx_file->ID ?>"><?= $mx_file->NAMA ?> (<?= $mx_file->KD_MATRIX ?>)</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Lampiran</label>
              <div class="col-8">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" multiple="" name="lampiran[]" />
                  <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
              </div>
              <div class="col-1 d-none">
                <span style="cursor: pointer;" name="add_lampiran" id="add_lampiran" class="label font-weight-bold label-lg label-success label-inline mb-2 mt-2">+</span><br>
              </div>
            </div>
            <div class="separator separator-dashed mb-5"></div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right"></label>
              <div class="col-8">
                <!-- <a onclick="tindak_lanjut()" type="submit" class="btn btn-primary font-weight-bold">Simpan</a> -->
                <button type="submit" id="save" class="btn btn-light-primary font-weight-bold">Simpan File</button>
                <a href="<?= base_url('monitoring/entry') ?>" class="btn btn-light-danger font-weight-bold">Kembali</a>
              </div>
            </div>
          </div>
      </form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    $("#form_lha").validate({
      errorClass: 'text-danger is-invalid',
      submitHandler: function () {
        Swal.fire({
      text: 'Simpan data?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya',
      cancelButtonText: 'Batal'
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: '<?= base_url() ?>/monitoring/entry/simpan/',
          type: 'post',
          data: $("#form_lha").serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            if (data == "ERR")
              Swal.fire("Proses Gagal!", "Data sudah ada.", "error")
            else
              window.location = data;
          },
          error: function(data) {
            Swal.fire("Error!", "Server Error!", "error")
          }
        });
      }
    }) 
      }
    });
  });
</script>