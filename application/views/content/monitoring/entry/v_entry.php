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
              <label class="col-form-label col-3 text-right">Jenis Audit</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control select-dua" id="ID_JENIS_AUDIT" name="ID_JENIS_AUDIT" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_ja as $data) { ?>
                    <option value="<?= $data['ID_JENIS_AUDIT'] ?>"><?= $data['JENIS_AUDIT'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Nomor SPA</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control select-dua" id="nomor_spa" name="NOMOR_SPA">
                    <option value="">--Pilih Nomor--</option>
                    <?php 
                    foreach ($nomor_spa as $nomor) { ?>
                      <option value="<?= $nomor['NOMOR_SURAT'] ?>"><?= $nomor['NOMOR_SURAT'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Auditee</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control select-dua" id="AUDITEE" name="AUDITEE" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_divisi as $data) { ?>
                    <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Tahun Audit</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" class="form-control datepicker-year" name="TAHUN" placeholder="Tahun Audit" required>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Periode Audit</label>
              <div class="col-4">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Periode Mulai" class="form-control datepicker w-100" <?= $disabled ?> type="text" id="TGL_PERIODE_MULAI" name="TGL_PERIODE_MULAI">
                      <span>
                        <i class="fa fa-calendar cursor-pointer"></i>
                      </span>
                    </div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Periode Selesai" class="form-control datepicker w-100" <?= $disabled ?> type="text"  <?= $disabled ?> id="TGL_PERIODE_SELESAI" name="TGL_PERIODE_SELESAI">
                      <span>
                        <i class="fa fa-calendar cursor-pointer"></i>
                      </span>
                    </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Masa Audit</label>
              <div class="col-4">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Masa Audit Awal" class="form-control datepicker w-100" <?= $disabled ?> type="text" id="MASA_AUDIT_AWAL" name="MASA_AUDIT_AWAL">
                      <span>
                        <i class="fa fa-calendar cursor-pointer"></i>
                      </span>
                    </div>
                </div>
              </div>
              <div class="col-4">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Masa Audit Akhir" class="form-control datepicker w-100" <?= $disabled ?> type="text"  <?= $disabled ?> id="MASA_AUDIT_AKHIR" name="MASA_AUDIT_AKHIR">
                      <span>
                        <i class="fa fa-calendar cursor-pointer"></i>
                      </span>
                    </div>
                </div>
              </div>
            </div>
            <div class="separator separator-dashed mb-5"></div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right"></label>
              <div class="col-8">
                <!-- <a onclick="tindak_lanjut()" type="submit" class="btn btn-primary font-weight-bold">Simpan</a> -->
                <button type="submit" id="save" class="btn btn-light-primary font-weight-bold">Simpan data</button>
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

    $("#nomor_spa").on("change", function() {
        var nomor = $(this).val();
        $.post("<?= base_url('monitoring/entry/get_detil_spa') ?>", {nomor: nomor}, function(result){
          var data = JSON.parse(result);
          $('#TGL_PERIODE_MULAI').val(data.PERIODE_AUDIT_AWAL);
          $('#TGL_PERIODE_SELESAI').val(data.PERIODE_AUDIT_AKHIR);
          $('#MASA_AUDIT_AWAL').val(data.MASA_AUDIT_AWAL);
          $('#MASA_AUDIT_AKHIR').val(data.MASA_AUDIT_AKHIR);
        });
    });

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