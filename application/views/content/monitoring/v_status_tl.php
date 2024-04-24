<link href="<?= base_url() ?>assets/css/pages/wizard/wizard-27a50.css" rel="stylesheet" type="text/css" />

<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
  <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
    <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
      <div class="d-flex align-items-center flex-wrap mr-2">
        <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5"><?= APK_NAME ?></h5>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Monitoring</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Rekap</span>
        <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
        <span class="text-muted font-weight-bold mr-4">Rekap Monitoring Hasil Audit</span>
      </div>
    </div>
  </div>
  <div class="d-flex flex-column-fluid">
    <div class="container">
      <div class="card card-custom">
        <div class="card-body p-0">
          <div class="wizard wizard-2" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
            <div class="wizard-nav border-right py-8 px-8 py-lg-20 px-lg-10">
              <div class="wizard-steps">
                <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                  <div class="wizard-wrapper">
                    <div class="wizard-icon">
                      <i class="fa fa-file-alt" style="font-size: 20px;"></i>
                    </div>
                    <div class="wizard-label">
                      <h3 class="wizard-title">Monitoring</h3>
                      <div class="wizard-desc">Rekap Monitoring Hasil Audit</div>
                    </div>
                  </div>
                </div>
                <div class="wizard-step" data-wizard-type="step">
                  <div class="wizard-wrapper">
                    <div class="wizard-icon">
                      <i class="fa fa-download" style="font-size: 20px;"></i>
                    </div>
                    <div class="wizard-label">
                      <h3 class="wizard-title">Download</h3>
                      <div class="wizard-desc">Download</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
              <div class="row">
                <div class="offset-xxl-1 col-xxl-10">
                  <form class="form" id="kt_form">
                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                      <h4 class="mb-10 font-weight-bold text-dark">Rekap Monitoring Hasil Audit</h4>
                      <!--begin::Input-->
                      <div class="form-group">
                        <label>Tahun</label>
                        <div class="form-label">
                          <div class="input-icon input-icon-right mb-2">
                            <input autocomplete="off" placeholder="Tahun" type="text" class="form-control datepicker-year" name="tahun_val" id="tahun_val" placeholder="Tahun">
                            <span>
                              <i class="fa fa-calendar text-muted"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Jenis Audit</label>
                        <select class="form-control form-control-solid form-control-lg select-dua" id="id_jenis_audit" name="ID_JENIS_AUDIT" required>
                          <option value="">--Pilih--</option>
                          <?php foreach ($list_ja as $data) { ?>
                            <option value="<?= $data['ID_JENIS_AUDIT'] ?>"><?= $data['JENIS_AUDIT'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Auditee</label>
                        <select class="form-control form-control-solid form-control-lg select-dua" id="id_divisi" name="AUDITEE" required>
                          <option value="">--Pilih--</option>
                          <?php foreach ($list_divisi as $data) { ?>
                            <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                          <?php } ?>
                        </select>
                        <input type="hidden" class="form-control" id="divisi" name="divisi">
                        <input type="hidden" class="form-control" id="jenis_audit" name="jenis_audit">

                      </div>
                      <div class="form-group" style="display: none;" id="kolom-pic">
                        <label>PIC</label>
                        <select class="form-control form-control-solid form-control-lg select-dua" id="pic" name="PIC">
                          <option value="">--Pilih--</option>
                          <?php foreach ($div_pusat as $data) { ?>
                            <option value="<?= $data['ID_DIVISI'] ?>"><?= $data['NAMA_DIVISI'] ?></option>
                          <?php } ?>
                        </select>
                        <input type="hidden" class="form-control" id="divisi" name="divisi">
                        <input type="hidden" class="form-control" id="jenis_audit" name="jenis_audit">

                      </div>
                      <div class="form-group">
                        <label>Status</label>
                        <select class="form-control form-control-solid form-control-lg select-dua" id="STATUS" name="STATUS" required>
                          <option value="">--All Status--</option>
                          <option value="Selesai">SELESAI</option>
                          <option value="STL">SUDAH DITINDAK-LANJUTI (STL)</option>
                          <option value="BTL">BELUM DITINDAK-LANJUTI (BTL)</option>
                          <option value="TPTD">TEMUAN TIDAK DAPAT DITINDAK-LANJUTI (TPTD)</option>
                        </select>
                        <input type="hidden" class="form-control" id="divisi" name="divisi">
                        <input type="hidden" class="form-control" id="jenis_audit" name="jenis_audit">

                      </div>
                    </div>
                    <div class="pb-5" data-wizard-type="step-content">
                      <h4 class="mb-10 font-weight-bold text-dark">Download</h4>
                      <h6 class="font-weight-bolder mb-3">Status Tindak Lanjut:</h6>
                      <div class="text-dark-50 line-height-lg">
                        <div class="form-inline">Tahun:&nbsp;<div id="tahun"></div>
                        </div>
                        <div class="form-inline">Auditee:&nbsp;<div id="auditee"></div>
                        </div>
                        <div class="form-inline">Jenis Audit:&nbsp;<div id="jns_audit"></div>
                        </div>
                        <div class="form-inline">Status:&nbsp;<div id="status_txt"></div>
                        </div>
                      </div>
                      <div class="separator separator-dashed my-5"></div>
                      <h6 class="font-weight-bolder mb-3">File:</h6>
                      <div class="text-dark-50 line-height-lg">
                        <div class="form-inline">
                          <div id="nama_file"></div>
                          <div>.pdf</div>
                        </div>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between border-top mt-5 pt-10">
                      <div class="mr-2">
                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                      </div>
                      <div>
                        <a onclick="location.reload()" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-reset">Reset</a>
                        <button type="button" onclick="cetak()" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Download</button>
                        <button type="button" onclick="next()" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <script src="<?= base_url() ?>assets/js/pages/custom/user/edit-user7a50.js"></script>
 <script src="<?= base_url() ?>assets/js/pages/custom/wizard/wizard-27a50.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#id_divisi').on('change', function (e) {
      cek_auditi();
    });
      cek_auditi();
  });
  function cek_auditi()
  {
    if($('#id_divisi').val() == 19)
      $('#kolom-pic').show();
    else
      $('#kolom-pic').hide();
  }
  function download() {
    var tahun_val         = $('#tahun_val').val();
    var id_divisi         = $('#id_divisi').val();
    var id_jenis_audit    = $('#id_jenis_audit').val();
    var STATUS            = $('#STATUS').val();
    window.location.href  = '<?= base_url() ?>monitoring/status_tl/export/' + tahun_val + '/' + id_divisi + '/' + id_jenis_audit + '/' + STATUS;
  }

  function cetak() {
    var tahun_val         = $('#tahun_val').val();
    var id_divisi         = $('#id_divisi').val();
    var id_jenis_audit    = $('#id_jenis_audit').val();
    var STATUS            = $('#STATUS').val();
    var PIC               = $('#pic').val();
    window.open('<?= base_url() ?>monitoring/status_tl/cetak/' + tahun_val + '/' + id_divisi + '/' + id_jenis_audit + '?p=' + btoa(PIC) + '&s=' + btoa(STATUS), '_blank');
  }

  function next() {
    if ($('#tahun_val').val() == '') {
      Swal.fire("Proses Data Gagal!", "Tahun tidak boleh kosong!", "error").then((result) => {
        if (result.value) {
          location.reload();
        }
      })
    }
    if ($('#id_divisi').val() == '') {
      Swal.fire("Proses Data Gagal!", "Divisi tidak boleh kosong!", "error").then((result) => {
        if (result.value) {
          location.reload();
        }
      })
    }

    $('#status_txt').html($('#STATUS').val());
    if($('#STATUS').val() == '') $('#status_txt').html('All Status');
    $('#tahun').html($('#tahun_val').val());
    $('#jns_audit').html($('#id_jenis_audit :selected').text());
    $('#auditee').html($('#id_divisi :selected').text());
    var nama_file = document.getElementById('nama_file');
    nama_file.innerHTML = 'STATUS_TL_' + $('#id_divisi :selected').text() + '_' + $('#id_jenis_audit :selected').text() + '_' + $('#tahun_val').val();
  }
</script>