<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Berita Acara</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Create</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <form class="form" id="form" method="post">
        <div class="card card-custom">
          <div class="card-header">
          <div class="card-title">
            <h3 class="card-label"><?= $title ?></h3>
          </div>

          </div>
          <div class="card-body">
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Nomor</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" name="NOMOR" value="<?= $data_ba->NOMOR ?>" class="form-control" placeholder="Nomor">
                  <input type="hidden" readonly name="ID_BA" value="<?= base64_encode($data_ba->ID) ?>">
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
                    <option <?= $data[ID_DIVISI] == $data_ba->AUDITEE ? 'selected' : '' ; ?> value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">PIC</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control select-dua" id="PIC" name="PIC" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_jabatan as $data) { ?>
                    <option <?= $data[ID_JABATAN] == $data_ba->PIC ? 'selected' : '' ; ?> value="<?= $data['ID_JABATAN'] ?>"><?= $data['NAMA_JABATAN'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Tahun Audit</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" value="<?= $data_ba->TAHUN_AUDIT ?>" class="form-control datepicker-year" name="TAHUN_AUDIT" placeholder="Tahun Audit" required>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Tanggal</label>
              <div class="col-8">
                <div class="form-label">
                    <div class="input-icon input-icon-right mb-2">
                      <input autocomplete="off" placeholder="Tanggal" class="form-control datepicker w-100" <?= $disabled ?> type="text" value="<?= $data_ba->TANGGAL ?>" name="TANGGAL" required>
                      <span>
                        <i class="fa fa-calendar cursor-pointer"></i>
                      </span>
                    </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right">Penanggung Jawab</label>
              <div class="col-8">
                <div class="form-label">
                  <select class="form-control select-dua" id="PJ" name="PJ" required>
                  <option value="">--Pilih--</option>
                  <?php foreach ($list_jabatan_pj as $data) { ?>
                    <option <?= $data[NIPP] == $data_ba->NIPP_SPI ? 'selected' : '' ; ?> value="<?= $data['NAMA'].'||'.$data['NAMA_JABATAN'].'||'.$data['NIPP'] ?>"><?= $data['NAMA'] ?> - <?= $data['NAMA_JABATAN'] ?></option>
                  <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="form-group row d-none">
              <label class="col-form-label col-3 text-right">Jabatan Penanggung Jawab</label>
              <div class="col-8">
                <div class="form-label">
                  <input type="text" name="JABATAN_SPI" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div class="separator separator-dashed mb-5"></div>
            <div class="form-group row">
              <label class="col-form-label col-3 text-right"></label>
              <div class="col-8">
                <!-- <a onclick="tindak_lanjut()" type="submit" class="btn btn-primary font-weight-bold">Simpan</a> -->
                <button type="submit" id="save" class="btn btn-light-primary font-weight-bold">Simpan data</button>
                <a href="<?= base_url('monitoring/berita_acara') ?>" class="btn btn-light-danger font-weight-bold">Kembali</a>
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

    $("#form").validate({
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
          url: '<?= current_url() ?>',
          type: 'post',
          data: $("#form").serialize(),
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            if (data == "OK")
            {
              let timerInterval
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Berhasil.',
                showConfirmButton: false,
                timer: 1500,
                onBeforeOpen: () => {
                  timerInterval = setInterval(() => {
                    const content = Swal.getContent()
                    if (content) {
                      const b = content.querySelector('b')
                      if (b) {
                        b.textContent = Swal.getTimerLeft()
                      }
                    }
                  }, 100)
                },
                onClose: () => {
                  clearInterval(timerInterval)
                }
              }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                  window.location.href = "<?= base_url('monitoring/berita_acara') ?>"; 
                }
              })
            }
            else
              Swal.fire("Proses Gagal!", "Data tidak tersimpan", "error")
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